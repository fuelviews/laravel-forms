<?php

namespace Fuelviews\LaravelForm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class FormHandleUtm
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $utmParameters = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

        foreach ($utmParameters as $param) {
            if ($value = $request->query($param)) {
                if (! $request->cookies->has($param)) {
                    Cookie::queue($param, $value, 43200);
                }

                $request->session()->put($param, $value);
            }
        }

        return $response;
    }
}
