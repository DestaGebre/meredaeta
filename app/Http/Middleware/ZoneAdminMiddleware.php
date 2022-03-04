<?php

namespace App\Http\Middleware;

use Closure;

class ZoneAdminMiddleware
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
        if($request->user() && ($request->user()->usertype == 'admin' || $request->user()->usertype == 'zoneadmin'))
            return $next($request);
        if($request->user())
            return abort(403);
        return redirect('home');
    }
}
