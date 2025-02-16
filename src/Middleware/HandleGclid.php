<?php

namespace Fuelviews\Forms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HandleGclid
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($gclid = $request->query('gclid')) {
            $cookie = Cookie::make('gclid', $gclid, 60 * 24 * 30); // 30 days
            $response->cookie($cookie);

            $request->session()->put('gclid', $gclid);
        }

        return $response;
    }
}
