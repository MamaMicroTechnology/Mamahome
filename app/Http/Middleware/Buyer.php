<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class Buyer
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
        if(Auth::check()){
            if(Auth::user()->category != "Buyer"){
                return redirect()->back();
            }
        }else{
            return redirect('/blogin');
        }
        return $next($request);
    }
}
