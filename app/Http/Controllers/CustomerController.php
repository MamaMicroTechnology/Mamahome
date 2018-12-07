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
use App\Manufacturer;
class CustomerController extends Controller
{
   

   public function getcustomer(request $request){

        $type = CustomerProjectAssign::where('user_id',Auth::user()->id)->pluck('type')->first();
        

        if($type != "project"){
          return  $this->customermanu($request);
        }

      $project = CustomerProjectAssign::where('user_id',Auth::user()->id)->where('type',"project")->pluck('project_id');
      $pro = explode(",",$project);
        

      $projects = ProjectDetails::whereIn('project_id',$pro)->paginate(10);
     
    
      
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
public function customermanu(request $request)
{
           $his = History::all();
            $project = CustomerProjectAssign::where('user_id',Auth::user()->id)->where('type',"Manufacturer")->pluck('project_id');

            $pro = explode(",",$project);
             $projects = Manufacturer::whereIn('id',$pro)->paginate("10");
          
           $projectcount=count($projects);
         
         return view('customermanu',[
                'projects'=>$projects,
                'his'=>$his,
                'projectcount'=>$projectcount


            ]);

}

public function deleteuser(request $request){
   CustomerProjectAssign::where('user_id',$request->projectId)->delete();

   return back();
}

   }
