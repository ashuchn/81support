<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkSubLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->get('subadminId') != NULL){
            return $next($request);
        }
        else{
            session()->put('err_msg', 'Login First');
            return redirect()->route('subadmin.login');
        }
    }
}
