<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
use App\Group;

class AccountExecutive
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
        if(Auth::guest()){
            return redirect('login');
        }
        if(Auth::check()){
            if(Auth::user()->group_id != 11){
                return redirect()->back();
            }
        }
        return $next($request);
    }
}
