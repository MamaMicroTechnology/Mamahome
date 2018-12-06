<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerProjectAssign;
use App\Order;
use App\ProjectUpdate;
use App\History;
use App\Requirement;
use Auth;
use App\ProjectDetails;
class CustomerController extends Controller
{
   

   public function getcustomer(Request $Request){

      $project = CustomerProjectAssign::where('user_id',Auth::user()->id)->pluck('project_id');

      $pro = explode(",",$project);

      $projects = ProjectDetails::whereIn('project_id',$pro)->paginate("10");
      
        $orders = Order::all();
        $projectupdat=ProjectUpdate::all(); 
        $his = History::all();
        $requirements = array();
        foreach($projects as $project){
            $req = Requirement::where('project_id',$project->project_id)->pluck('id')->toArray();
            $pid = $project->project_id;
            array_push($requirements, [$pid,$req]);
        }

          return view('/customer',['requirements' =>$requirements,'his'=>$his,'orders' => $orders,'projectupdat'=>$projectupdat,'projects'=>$projects]);

   }



   }
