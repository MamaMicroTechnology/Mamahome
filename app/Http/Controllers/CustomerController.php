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
use App\SubWard;
use App\MamahomePrice;
use App\Supplierdetails;
use App\Gst;
use DB;

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
 
   CustomerProjectAssign::where('user_id',$request->projectId)->where('type',$request->type)->delete();

   return back();
}
public function testindex(){
  return view('/test');
}
public function subward(request $request)
{
  $sub = SubWard::where('sub_ward_name',$request->wardid)->pluck('id')->first();
  
 Requirement::where('manu_id',$request->manu_id)->update(['sub_ward_id'=>$sub]);
 Manufacturer::where('id',$request->manu_id)->update(['sub_ward_id'=>$sub]);
 return back();
 
}

public function gstinfo(request $request){


  $orders = DB::table('orders')->where('status',"Order Confirmed")->get();
  


  $data = [];

  foreach ($orders as $order) {
    $mamacgst =MamahomePrice::where('order_id',$order->id)->pluck('cgstpercent')->first();
    $mamasgst =MamahomePrice::where('order_id',$order->id)->pluck('sgstpercent')->first();
    $mamaigst =MamahomePrice::where('order_id',$order->id)->pluck('igst')->first();
    $mamaquantity =MamahomePrice::where('order_id',$order->id)->pluck('quantity')->first();
    $mamaprice =MamahomePrice::where('order_id',$order->id)->pluck('mamahome_price')->first();
    $mamawithgst = MamahomePrice::where('order_id',$order->id)->pluck('amountwithgst')->first();
    $mamawithoutgst = MamahomePrice::where('order_id',$order->id)->pluck('totalamount')->first();
    $sprice =Supplierdetails::where('order_id',$order->id)->pluck('unit_price')->first();
    $swithgst = Supplierdetails::where('order_id',$order->id)->pluck('totalamount')->first();
    $swithoutgst = Supplierdetails::where('order_id',$order->id)->pluck('amount')->first();

    $income = $mamawithoutgst - $swithoutgst ;

   array_push($data,['id'=>$order->id,'category'=>$order->main_category,'quantity'=>$mamaquantity,'Mamaprice'=>$mamaprice,'Mamacgst'=>$mamacgst,'Mamasgst'=>$mamasgst,'Mamaigst'=>$mamaigst,'Mamawithgst'=>$mamawithgst,'Mamawithoutgst'=>$mamawithoutgst,'sprice'=>$sprice,'swithgst'=>$swithgst,'swithoutgst'=>$swithoutgst,'income'=>$income]); 


  }

  

  return view('/gstinformation',['data'=>$data]);
}



   }
