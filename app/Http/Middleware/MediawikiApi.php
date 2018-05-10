<?php

namespace App\Http\Middleware;

use Closure;

class MediawikiApi
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
            $request->getUser() !== config('services.mediawiki.username') &&
            $request->getPassword() !== config('services.mediawiki.password')
        ) {
            return response('', 401);
        }

        return $next($request);
    }
}
