<?php

namespace System\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationMiddlewareBase;

/**
 * Class Locale
 * @package System\Http\Middleware
 * @author Jasmine <youjingqiang@gmail.com>
 */
class Locale extends LaravelLocalizationMiddlewareBase
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the URL of the request is in exceptions.
//        if ($this->shouldIgnore($request)) {
//            return $next($request);
//        }

        if (!auth('system')->guest() && $user = auth('system')->user()) {
            LaravelLocalization::setLocale($user->lang);
        }

        return $next($request);
    }
}
