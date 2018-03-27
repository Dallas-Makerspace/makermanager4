<?php

namespace App\Http\Middleware;

use Closure;

class WhmcsApi
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
        if(
            $request->getUser() !== config('services.whmcs.username') &&
            $request->getPassword() !== config('services.whmcs.password')
        ) {
            return response('', 401);
        }

        return $next($request);
    }
}
