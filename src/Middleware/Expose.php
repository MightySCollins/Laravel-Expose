<?php

namespace SCollins\LaravelExpose\Middleware;

use Cache;
use Closure;
use SCollins\LaravelExpose\Jobs\ExposeRequest;

class Expose
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (count($request->all()) > 0) {
            $id = 'expose-' . uniqid();
            Cache::put($id, $request->except(config('expose.ignore')), 5);
            dispatch(new ExposeRequest($id, $request->ip()));
        }

        return $next($request);
    }

}
