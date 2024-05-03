<?php

namespace Fuelviews\LaravelForms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleStep
{
    public function handle(Request $request, Closure $next)
    {
        view()->share('step', $request->session()->get('form_step', 1));
        return $next($request);
    }
}
