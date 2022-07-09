<?php

namespace Sdkconsultoria\Base\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class Theme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->theme) {
            Cache::put('theme', $request->theme);
        }

        return $next($request);
    }
}
