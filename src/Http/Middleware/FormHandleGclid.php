<?php

namespace Fuelviews\LaravelForm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class FormHandleGclid
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($gclid = $request->query('gclid')) {
            $cookie = Cookie::make('gclid', $gclid, 60 * 24 * 30);
            $response->cookie($cookie);
        }

        return $response;
    }
}
