<?php

namespace System\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use System\Models\User;
use System\Traits\WithHttpResponse;

class SystemPermissionChecker
{
    use WithHttpResponse;

    public array $except
        = [
            'system/login*', 'system/index*', 'system/logout', 'system/api*',
            'api/*', 'horizon/*', '_ignition/*', 'docs/*', 'system/impersonate/leave'
        ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->inExceptArray($request)) {
            return $next($request);
        }
        /** @var User $user */
        $user = auth('system')->user();
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
                return redirect()->route('system.index');
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

