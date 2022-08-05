<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PromotorMiddleware
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
        if(Auth::user()-> tipoUserID==3 || Auth::user()-> tipoUserID==2) // se for admin ou promotor 
            return $next($request);
        return redirect('/');
    }
}
