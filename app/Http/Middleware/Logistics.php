<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
use App\Group;

class Logistics
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
            if(Auth::user()->group_id != 12){
                return redirect()->back();
            }
        }
        return $next($request);
    }
}
