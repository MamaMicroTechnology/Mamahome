<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Auth;

date_default_timezone_set("Asia/Kolkata");
class ItController extends Controller
{
    public function getItDashboard()
    {
        $today = date('Y-m-d');
        $reports = Report::where('empId',Auth::user()->employeeId)->where('created_at','LIKE',$today.'%')->get();
        return view('it.dashboard',['reports'=>$reports]);
    }
    public function postItReport(Request $request)
    {
        for($i = 0; $i < count($request->report); $i++){
            $report = new Report;
            $report->empId = Auth::user()->employeeId;
            $report->report = $request->report[$i];
            $report->start = $request->from[$i];
            $report->end = $request->to[$i];
            $report->save();
        }
        return back()->with('Success','Your Report Has Been Saved Successfully');
    }
}
