<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LaravelFormsHandleGclid
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
