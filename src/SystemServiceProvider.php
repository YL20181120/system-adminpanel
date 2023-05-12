<?php

namespace System;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Lab404\Impersonate\Events\LeaveImpersonation;
use Lab404\Impersonate\Events\TakeImpersonation;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use System\Http\Middleware\Locale;
use System\Http\Middleware\SystemPermissionChecker;
use System\Models\User;
use System\Traits\WithHttpResponse;
use System\View\Components\AppLayout;
use System\View\Components\Main;
use System\View\Components\Table;

class SystemServiceProvider extends PackageServiceProvider
{

    public function configurePackage(Package $package): void
    {
        $package
            ->name('system')
            ->hasConfigFile(['system', 'laravellocalization', 'laravel-impersonate', 'permission', 'translatable'])
            ->hasViews()
            ->hasAssets()
            ->hasTranslations()
            ->hasViewComponents('system', AppLayout::class, Main::class, Table::class)
            ->hasCommands([])
            ->hasRoutes(['web']);
    }


    public function boot(): SystemServiceProvider
    {
        Fortify::viewPrefix('system::auth.');

        /**
         * 重新定义 Fortify 路由
         */
        Fortify::ignoreRoutes();

        $middlewares = [
            Locale::class
        ];
        if (class_exists(\Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class)) {
            $middlewares[] = \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class;
        }
        if (class_exists(\Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class)) {
            $middlewares[] = \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class;
        }

        \Illuminate\Support\Facades\Route::group([
            'namespace'  => 'Laravel\Fortify\Http\Controllers',
            'prefix'     => LaravelLocalization::setLocale() . '/' . config('fortify.prefix'),
            'middleware' => $middlewares
        ], function () {
            $this->loadRoutesFrom(base_path('vendor/laravel/fortify/routes/routes.php'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
                'verify'   => ['nullable', 'captcha_api:' . \request('uniqid') . ',system']
            ], [
                'verify.captcha_api' => 'Captcha error'
            ]);

            $user = User::where('email', $request->email)->first();
            if ($user == null) {
                throw ValidationException::withMessages([
                    'email' => ['Email not found on out database']
                ]);
            }

            if ($user->ban_at && $user->ban_at->lt(now())) {
                throw ValidationException::withMessages([
                    'email' => ['User baned at ' . $user->ban_at]
                ]);
            }

            if (Hash::check($request->password, $user->password)) {
                $user->update(['last_login_at' => now(), 'last_login_ip' => $request->getClientIp(), 'lang' => $this->app->getLocale()]);
                return $user;
            } else {
                throw ValidationException::withMessages([
                    'password' => ['Password incorrect']
                ]);
            }
        });

        $this->bootMacro();

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            use WithHttpResponse;

            public function toResponse($request)
            {
                $this->success(__('system::login.login_successful'), route('system.index'));
            }
        });
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            use WithHttpResponse;

            public function toResponse($request)
            {
                $this->success(__('system::login.logout_successful'), LaravelLocalization::getLocalizedUrl(url: 'system/login'));
            }
        });


        $this->app['events']->listen(TakeImpersonation::class, function (TakeImpersonation $event) {
            Log::info('Impersonated:', [$event->impersonator->getAuthIdentifier(), $event->impersonated->getAuthIdentifier()]);
        });
        $this->app['events']->listen(LeaveImpersonation::class, function (LeaveImpersonation $event) {
            Log::info('Leave Impersonated:', [$event->impersonator->getAuthIdentifier(), $event->impersonated->getAuthIdentifier()]);
        });

        Gate::before(function (User $user, $ability) {
            if ($user->hasRole('Administrator')) {
                return true;
            }
        });

        $this->registerMiddlewareGroup();

        return parent::boot();
    }

    public function bootingPackage()
    {
        $this->registerAuthGuardsAndProviders();
    }

    protected function registerAuthGuardsAndProviders()
    {
        config(
            Arr::dot([
                'guards' => [
                    'system'     => [
                        'driver'   => 'session',
                        'provider' => 'system'
                    ],
                    'system-api' => [
                        'driver'   => 'sanctum',
                        'provider' => 'system'
                    ],
                ],

                'providers' => [
                    'system' => [
                        'driver' => 'eloquent',
                        'model'  => config('system.model') ?? User::class
                    ],
                ],
            ], 'auth.'));
    }

    protected function registerMiddlewareGroup()
    {
        $middlewares = [
            SystemPermissionChecker::class,
            Locale::class
        ];
        if (class_exists(\Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class)) {
            $middlewares[] = \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class;
        }
        if (class_exists(\Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class)) {
            $middlewares[] = \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class;
        }

        $this->app['router']->middlewareGroup('system', $middlewares);
    }

    protected function bootMacro()
    {
        Builder::macro('searchLike', function ($field, $value = null, $boolean = 'and'): Builder {
            if ($value === null) {
                $value = Arr::get(\request()->get('_search', []), $field, false);
            }
            if ($value !== null && $value !== false) {
                $this->where($field, 'like', join('', ['%', $value, '%']), $boolean);
            }
            return $this;
        });

        Builder::macro('searchEqual', function ($field, $value = null, $boolean = 'and'): Builder {
            if ($value === null) {
                $value = Arr::get(\request()->get('_search', []), $field, false);
            }
            if ($value !== null && $value !== false) {
                $this->where($field, '=', $value, $boolean);
            }
            return $this;
        });

        Builder::macro('searchDate', function ($field, $value = null, $boolean = 'and'): Builder {
            if ($value === null) {
                $value = Arr::get(\request()->get('_search', []), $field, false);
            }
            if ($value !== null && $value !== false) {
                $this->whereDate($field, '=', $value, $boolean);
            }
            return $this;
        });

        Builder::macro('searchRange', function ($field, $value = null, $boolean = 'and', $not = false): Builder {
            if ($value === null) {
                $value = Arr::get(\request()->get('_search', []), $field, false);
            }

            if ($value !== null && $value !== false) {
                list($start, $end) = explode(' - ', str_replace('+-+', ' - ', $value));
                $this->whereBetween($field, [$start, $end], $boolean, $not);
            }
            return $this;
        });

        Builder::macro('searchIn', function ($field, array|string $value = null, $boolean = 'and', $not = false): Builder {
            if ($value === null) {
                $value = Arr::get(\request()->get('_search', []), $field, false);
            }

            if ($value !== null && $value !== false) {
                if (is_string($value)) {
                    $value = explode(',', $value);
                }
                $this->whereIn($field, $value, $boolean, $not);
            }
            return $this;
        });

        Request::macro('isGet', function (): bool {
            return $this->isMethod('GET');
        });
        Request::macro('isPost', function (): bool {
            return $this->isMethod('POST');
        });

        Router::macro('getOrPost', function ($uri, $action = null): Route {
            return $this->match(['get', 'post'], $uri, $action);
        });

        Router::macro('system', function ($name, $controller) {
            $this->get($name, [$controller, 'index'])->name($name . '.index');
            $this->delete($name . '/destroy', [$controller, 'destroy'])->name($name . '.destroy');
            $this->get("$name/create", [$controller, 'createOrUpdate'])->name($name . '.create');
            $this->post($name, [$controller, 'createOrUpdate'])->name($name . '.store');
            $this->get(sprintf("%s/{%s}", $name, $name), [$controller, 'createOrUpdate'])->name($name . '.edit');
            $this->post(sprintf("%s/{%s}", $name, $name), [$controller, 'createOrUpdate'])->name($name . '.update');
        });
    }
}
