<?php

namespace App\Beta\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class Locale
{
    public function handle(Request $request, Closure $next)
    {
        if($request->hasCookie('lang'))
            App::setLocale($request->cookie('lang'));
        else
            App::setLocale('vi');

        return $next($request);
    }
}