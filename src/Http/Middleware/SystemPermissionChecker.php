<?php

namespace Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Admin\Models\User;
use Admin\Traits\WithHttpResponse;

class SystemPermissionChecker
{
    use WithHttpResponse;

    public array $except
        = [
            'api/*', 'horizon/*', '_ignition/*', 'docs/*',
        ];

    public function __construct()
    {
        $this->except = array_merge($this->except, [
            config('admin.prefix') . '/login*',
            config('admin.prefix') . '/index*',
            config('admin.prefix') . '/logout',
            config('admin.prefix') . '/api*',
            config('admin.prefix') . '/impersonate/leave',
        ]);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->inExceptArray($request) || auth('admin')->guest()) {
            return $next($request);
        }
        /** @var User $user */
        $user = auth('admin')->user();
        if ($request->route()->controller !== null) {
            /** @var Controller $controller */
            $controller = $request->route()->getController();

            if ($controller instanceof Controller && in_array($request->route()->getActionMethod(), $controller->exceptPermissions ?? [])) {
                return $next($request);
            }
        }


        if ($user->can(preg_replace('/\{[\s\S]*?\}/i', '*', $request->route()->uri()))) {
            return $next($request);
        } else {
            if ($request->expectsJson()) {
                $this->error(__('You are not allowed access this page'), 'javascript:void');
            } else {
                return redirect()->route('admin.index');
            }
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}

