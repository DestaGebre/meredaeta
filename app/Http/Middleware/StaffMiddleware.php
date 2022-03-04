<?php

namespace App\Http\Middleware;

use Closure;

class StaffMiddleware
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
        if($request->user() && array_search($request->user()->usertype, ['admin','zoneadmin','woredaadmin','zone','woreda','staff']) !== FALSE)
            return $next($request);
        if($request->user())
            return abort(403);
        return redirect('home');
    }
}
