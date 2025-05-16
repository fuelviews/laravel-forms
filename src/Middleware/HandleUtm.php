<?php

namespace Fuelviews\Forms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HandleUtm
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $utmParameters = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

        foreach ($utmParameters as $utmParameter) {
            if ($value = $request->query($utmParameter)) {
                if (! $request->cookies->has($utmParameter)) {
                    Cookie::queue($utmParameter, $value, 43200);
                }

                $request->session()->put($utmParameter, $value);
            }
        }

        return $response;
    }
}
