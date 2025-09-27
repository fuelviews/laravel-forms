<?php

namespace Fuelviews\Forms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HandleFbclid
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($fbclid = $request->query('fbclid')) {
            $cookie = Cookie::make('fbclid', $fbclid, 60 * 24 * 30); // 30 days
            $response->cookie($cookie);

            $request->session()->put('fbclid', $fbclid);
        }

        return $response;
    }
}
