<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class HamdleUtm
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $utmParameters = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

        foreach ($utmParameters as $param) {
            if (($value = $request->query($param)) && !Cookie::has($param)) {
                Cookie::queue($param, $value, 43200);
            }
        }

        return $response;
    }
}
