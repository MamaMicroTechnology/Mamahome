<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
use App\Group;

class asst
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
            $group = Group::where('id',Auth::user()->group_id)->pluck('group_name')->first();
            if($group != "Asst. Manager"){
                if($group != "Admin"){
                    return response()->view('errors.403error');
                }
            }
        }
        return $next($request);
    }
}
