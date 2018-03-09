<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Group;
use App\Department;

class SalesDashboard
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
            $department = Department::where('id',Auth::user()->department_id)->pluck('dept_name')->first();
            if(Auth::user()->department_id != 2 && Auth::user()->group_id != 7){
                return redirect()->back();
            }
        }
        return $next($request);
    }
}
