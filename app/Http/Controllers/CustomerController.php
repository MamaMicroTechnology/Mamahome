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
use App\Category;
use App\ContractorDetails;
use App\ProcurementDetails;
use App\SiteEngineerDetails;
use App\ConsultantDetails;
use App\OwnerDetails;
use App\Mowner_Deatils;
use App\Mprocurement_Details;
use App\Manager_Deatils;
use App\Salescontact_Details;
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


  $category = Category::all();
 if($request->from && $request->to && !$request->category){

        $from = $request->from;
        $to = $request->to;
  $orders = DB::table('orders')->where('status',"Order Confirmed")->where('created_at','>',$from)->where('created_at','<',$to)->get();
   
  $data = [];
 foreach ($orders as $order) {
    $mamacgst =Supplierdetails::where('order_id',$order->id)->pluck('cgstpercent')->first();
    $mamasgst =Supplierdetails::where('order_id',$order->id)->pluck('sgstpercent')->first();
    $mamaigst =Supplierdetails::where('order_id',$order->id)->pluck('igstpercent')->first();
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
        
  }
else if($request->category && !$request->from && !$request->to){
  $orders = DB::table('orders')->where('status',"Order Confirmed")->where('main_category',$request->category)->get();

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
}else if($request->category && $request->from && $request->to){
      $from = $request->from;
        $to = $request->to;
  $orders = DB::table('orders')->where('status',"Order Confirmed")->where('main_category',$request->category)->where('created_at','>',$from)->where('created_at','<',$to)->get();

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
}else{

 $data = []; 
}


  return view('/gstinformation',['data'=>$data,'category'=>$category]);
}


public function userfull(request $request){
  $ids = [];
  $pdetails =[];
  if($request->phNo )
        {
            $details[0] = ContractorDetails::where('contractor_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            if(count($details[0]) > 0){
                $name = "Contractor";
                array_push($pdetails,['name'=>$name]);
            }
            $details[1] = ProcurementDetails::where('procurement_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            if(count($details[1]) > 0){
                 $name = "Procurement";
           array_push($pdetails,['name'=>$name]);
            }
            $details[2] = SiteEngineerDetails::where('site_engineer_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            if(count($details[2]) > 0){
                 $name = "SiteEngineer";
           array_push($pdetails,['name'=>$name]);
            }
            $details[3] = ConsultantDetails::where('consultant_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            if(count($details[3]) > 0){
                 $name = "Consultant";
           array_push($pdetails,['name'=>$name]);
            }
            $details[4] = OwnerDetails::where('owner_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            if(count($details[4]) > 0){
                 $name = "Owner";
                array_push($pdetails,['name'=>$name]);
            }
             
            for($i = 0; $i < count($details); $i++){
                for($j = 0; $j<count($details[$i]); $j++){
                    array_push($ids, $details[$i][$j]);
                }
            }
          }

 $manuids = [];
 $mdestails = [];  
 if($request->phNo )
        {
            $details1[10] = Salescontact_Details::where('contact',$request->phNo)->pluck('manu_id');
            if(count($details1[10]) > 0){
                $name = "Salesmanager";
                array_push($mdestails,['name'=>$name]);
            }
            $details1[11] = Manager_Deatils::where('contact',$request->phNo)->pluck('manu_id');

            if(count($details1[11]) > 0){
                 $name = "Manager";
           array_push($mdestails,['name'=>$name]);
            }
            $details1[12] = Mprocurement_Details::where('contact',$request->phNo)->pluck('manu_id');
            if(count($details1[12]) > 0){
                 $name = "Procurement";
                array_push($mdestails,['name'=>$name]);
            }
            $details1[13] = Mowner_Deatils::where('contact',$request->phNo)->pluck('manu_id');
             if(count($details1[13]) > 0){
                 $name = "Owner";
           array_push($mdestails,['name'=>$name]);
            }
           
            for($i = 10; $i < count($details1); $i++){
                for($j = 10; $j<count($details1[$i]); $j++){
                    array_push($manuids, $details1[$i][$j]);
                }
            }
          }
         
       
$confirmenq = Requirement::whereIn('project_id',$ids)->orwhereIn('manu_id',$manuids)->where('status',"Enquiry Confirmed")->pluck('id');
$cancelenq = Requirement::whereIn('project_id',$ids)->orwhereIn('manu_id',$manuids)->where('status',"Enquiry Cancelled")->pluck('id');
$onprocessenq = Requirement::whereIn('project_id',$ids)->orwhereIn('manu_id',$manuids)->where('status',"Enquiry On Process")->pluck('id');

$orderconfirm =DB::table('orders')->whereIn('project_id',$ids)->orwhereIn('manu_id',$manuids)->where('status',"Order Confirmed")->pluck('id');

$cancelorder =DB::table('orders')->whereIn('project_id',$ids)->orwhereIn('manu_id',$manuids)->where('status',"Order Cancelled")->pluck('id');


 return view('/searchuser',['projectids'=>$ids,'projecttype'=>$pdetails,'manuids'=>$manuids,'manutype'=>$mdestails,'confirmenq'=>$confirmenq,'cancelenq'=>$cancelenq,'onprocessenq'=>$onprocessenq,'orderconfirm'=>$orderconfirm,'cancelorder'=>$cancelorder]);

}

   


   }