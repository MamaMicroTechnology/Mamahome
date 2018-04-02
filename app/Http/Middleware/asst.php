<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
use App\Department;

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
            $group = Department::where('id',Auth::user()->department_id)->pluck('dept_name')->first();
            if($group != "Management"){
                if(Auth::user()->group_id != 1){
                    return response()->view('errors.403error');
                }
            }
        }
        return $next($request);
    }
}
