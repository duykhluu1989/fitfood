<?php

namespace App\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                if(strpos($request->url(), 'admin/logout') === false)
                    return redirect()->guest('admin/login?redirectUrl=' . urlencode($request->fullUrl()));
                else
                    return redirect()->guest('admin/login');
            }
        }

        return $next($request);
    }
}
