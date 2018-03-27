<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectIfUnwaivered
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && is_null(Auth::guard($guard)->user()->waiver_id)) {
            return redirect('/waiver');
        }

        return $next($request);
    }
}
