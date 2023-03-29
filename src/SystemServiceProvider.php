<?php

namespace System;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
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
            ->hasConfigFile()
            ->hasViews()
            ->hasAssets()
            ->hasTranslations()
            ->hasMigrations(['create_users_table', 'create_configs_table', 'create_menus_table', 'create_system_password_resets_table'])
            ->hasViewComponents('system', AppLayout::class, Main::class, Table::class)
            ->hasCommands([])
            ->hasRoutes(['web']);
    }


    public function boot(): SystemServiceProvider
    {
        Fortify::viewPrefix('system::auth.');
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
                $user->update(['last_login_at' => now(), 'last_login_ip' => $request->getClientIp()]);
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
                $this->success('Login Success!', route('system.index'));
            }
        });
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            use WithHttpResponse;

            public function toResponse($request)
            {
                $this->success('Logout Success!', url('system/login'));
            }
        });

        return parent::boot();
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
                $this->whereBetween($field, [$start, $end], $boolean);
            }
            return $this;
        });

        Request::macro('isGet', function () {
            return $this->isMethod('GET');
        });
        Request::macro('isPost', function () {
            return $this->isMethod('POST');
        });
    }
}
