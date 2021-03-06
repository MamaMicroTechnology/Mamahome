<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CustomerProjectAssign;
use App\Order;
use App\ProjectUpdate;
use App\History;
use App\Requirement;
use App\Builder;
use App\SupplierInvoice;
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
use App\Group;
use App\Department;
use App\User;
use App\Ledger;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\AccountHead;
use App\Subaccountheads;
use App\Quotation;
use GuzzleHttp\Client;

class CustomerController extends Controller
{

public function getcustomer(request $request){

        $type = CustomerProjectAssign::where('user_id',Auth::user()->id)->where('type',"project")->first();
        
       
        if(count($type) == 0){
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
 
   CustomerProjectAssign::where('id',$request->projectId)->delete();

   return back();
}
public function testindex(request $request){
     $bank =$request->bank;
    
     if($request->acc != NULL){
                $imageName1 = time().'.'.request()->acc->getClientOriginalExtension();
                $request->acc->move(public_path('Ledger'),$imageName1);
            }else{
                $imageName1 = "N/A";
            }
      
    // $path = base_path("public/ledger/".$imageName1);

    //  $path ="/var/www/mamamicrotech/clients/MH/webapp/public/Ledger/".$imageName1; 

            $path = "/var/www/html/mamaReu/public/Ledger/".$imageName1;
      chmod($path,0777);

     $rows = Excel::load($path, function($reader) { })->get()->toArray();
     
   foreach ($rows as $row) {
           
            $yadav = new Ledger;
            $yadav->val_date =$row['date'];
            $yadav->Transaction =$row['transaction_particulars'];
            $yadav->amount =$row['amountinr'];
            $yadav->debitcredit =$row['drcr'];
            $yadav->bank =$bank;
            $yadav->branch =$row['branch_name'];
            $yadav->accounthead ="";
            $yadav->remark = $row['remarks'];
            $yadav->save();

       }    
$ledger = Ledger::orderBy('id','DESC')->get();
      $acc = AccountHead::all();
   // dd($rows);
    

    // $y="/var/www/html/mamaReu/public/Ledger/book.csv";


  // return view('/ledger',['ledger'=>$ledger,'acc'=>$acc]);
      return redirect('/ledger');
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
  $project ='';
  $project1 = '';
  if($request->phNo){

  $project = ProcurementDetails::where('project_id',$request->phNo)->pluck('procurement_contact_no')->first();
  }
   $cname =ProcurementDetails::where('project_id',$request->phNo)->pluck('procurement_name')->first();

  if(count($project > 0 ))
        {
            $details[0] = ContractorDetails::where('contractor_contact_no',$project)->pluck('project_id');
            if(count($details[0]) > 0){
                $name = "Contractor";
                array_push($pdetails,['name'=>$name]);
            }
            $details[1] = ProcurementDetails::where('procurement_contact_no',$project)->pluck('project_id');
            if(count($details[1]) > 0){
                 $name = "Procurement";
           array_push($pdetails,['name'=>$name]);
            }
            $details[2] = SiteEngineerDetails::where('site_engineer_contact_no',$project)->pluck('project_id');
            if(count($details[2]) > 0){
                 $name = "SiteEngineer";
           array_push($pdetails,['name'=>$name]);
            }
            $details[3] = ConsultantDetails::where('consultant_contact_no',$project)->pluck('project_id');
            if(count($details[3]) > 0){
                 $name = "Consultant";
           array_push($pdetails,['name'=>$name]);
            }
            $details[4] = OwnerDetails::where('owner_contact_no',$project)->pluck('project_id');
            if(count($details[4]) > 0){
                 $name = "Owner";
                array_push($pdetails,['name'=>$name]);
            }
              $details[5] =Builder::where('builder_contact_no',$project)->pluck('project_id');

            if(count($details[5]) > 0){
                 $name = "Builder";
                array_push($pdetails,['name'=>$name]);

            }
             
            for($i = 0; $i < count($details); $i++){
                for($j = 0; $j<count($details[$i]); $j++){
                    array_push($ids, $details[$i][$j]);
                }
            }
          }

  $project1 = Mprocurement_Details::where('manu_id',$request->phNo)->pluck('contact')->first();
  $cmanu = Mprocurement_Details::where('manu_id',$request->phNo)->pluck('name')->first();

 $manuids = [];
 $mdestails = [];  
 if(count($project1) > 0 )
        {
            $details1[0] = Salescontact_Details::where('contact',$project1)->pluck('manu_id');
            if(count($details1[0]) >= 0){
                $name = "Salesmanager";
                array_push($mdestails,['name'=>$name]);
            }
            $details1[1] = Manager_Deatils::where('contact',$project1)->pluck('manu_id');

            if(count($details1[1]) > 0){
                 $name = "Manager";
           array_push($mdestails,['name'=>$name]);
            }
            $details1[2] = Mprocurement_Details::where('contact',$project1)->pluck('manu_id');
            if(count($details1[2]) > 0){
                 $name = "Procurement";
                array_push($mdestails,['name'=>$name]);
            }
            $details1[3] = Mowner_Deatils::where('contact',$project1)->pluck('manu_id');
             if(count($details1[3]) > 0){
                 $name = "Owner";
           array_push($mdestails,['name'=>$name]);
            }
            for($i =0; $i < count($details1); $i++){
                for($j = 0; $j<count($details1[$i]); $j++){
                    array_push($manuids, $details1[$i][$j]);
                }
            }
          }
$confirmenq =[];
$cancelenq  = [];
$onprocessenq = [];
$orderconfirm = [];
$cancelorder = [];
$confirms = [];
$cancel = [];
$onprocess = [];
$oconfirm = [];
$corder = [];
$sproinc=[];
$smanuinc=[];
$cproinc=[];
$cmanuinc=[];
$enq = [];
$enqmanu = [];
$cenq = [];
$cenqm = [];

 if(count($request->manuid) > 0){
   $manu = $request->manuid;

 }else{
  $manu ="no";
 }
 if(count($request->id) > 0){
   $pro = $request->id;

 }else{
  $pro ="nu";
 }
if($request->id || $request->manuid){
$confirmenq = Requirement::where('project_id',$pro)->where('status',"Enquiry Confirmed")->pluck('id');
$confirms =Requirement::Where('manu_id',$manu)->where('status',"Enquiry Confirmed")->pluck('id');


$cancelenq = Requirement::where('project_id',$pro)->where('status',"Enquiry Cancelled")->pluck('id');
   
  $cancel = Requirement::where('manu_id',$manu)->where('status',"Enquiry Cancelled")->pluck('id');

$onprocessenq = Requirement::where('project_id',$pro)->where('status',"Enquiry On Process")->pluck('id');

$onprocess = Requirement::where('manu_id',$manu)->where('status',"Enquiry On Process")->pluck('id');

$orderconfirm =DB::table('orders')->where('project_id',$pro)->where('status',"Order Confirmed")->pluck('id');
$enq=DB::table('orders')->where('project_id',$pro)->where('status',"Order Confirmed")->pluck('req_id');
$oconfirm =DB::table('orders')->where('manu_id',$manu)->where('status',"Order Confirmed")->pluck('id');
$enqmanu =DB::table('orders')->where('manu_id',$manu)->where('status',"Order Confirmed")->pluck('req_id');


$sproinc = SupplierInvoice::whereIn('order_id',$orderconfirm)->pluck('lpo_number');
$smanuinc = SupplierInvoice::whereIn('order_id',$oconfirm)->pluck('lpo_number');
// dd($smanuinc);
$cproinc = MamahomePrice::whereIn('order_id',$orderconfirm)->pluck('invoiceno');
$cmanuinc = MamahomePrice::whereIn('order_id',$oconfirm)->pluck('invoiceno');

// $qproinc = Quotation::whereIn('order_id',$orderconfirm)->pluck('invoiceno');
// $qmanuinc = Quotation::whereIn('order_id',$oconfirm)->pluck('invoiceno');


$cancelorder =DB::table('orders')->where('project_id',$pro)->where('status',"Order Cancelled")->pluck('id');
$corder =DB::table('orders')->where('manu_id',$manu)->where('status',"Order Cancelled")->pluck('id');

$cenq =DB::table('orders')->where('project_id',$pro)->where('status',"Order Cancelled")->pluck('req_id');
$cenqm =DB::table('orders')->where('manu_id',$manu)->where('status',"Order Cancelled")->pluck('req_id');
     }    

$s = array_unique($ids);
  
 return view('/searchuser',['projectids'=>$s,'projecttype'=>$pdetails,'manuids'=>$manuids,'manutype'=>$mdestails,'confirmenq'=>$confirmenq,'cancelenq'=>$cancelenq,'onprocessenq'=>$onprocessenq,'orderconfirm'=>$orderconfirm,'cancelorder'=>$cancelorder,'project'=>$project,'project1'=>$project1,
'confirms'=>$confirms,
'cancel'=>$cancel,
'onprocess'=>$onprocess,
'oconfirm'=>$oconfirm,
'corder'=>$corder,'cname'=>$cname,'cmanu'=>$cmanu,'sproinc'=>$sproinc,'smanuinc'=>$smanuinc,'cproinc'=>$cproinc,'cmanuinc'=>$cmanuinc,'enq'=>$enq,'enqmanu'=>$enqmanu,'cenq'=>$cenq,'cenqm'=>$cenqm]);

}

  public function changedesc(request $request){
     $user = User::where('id',$request->user)->update(['department_id'=>$request->dept,'group_id'=>$request->designation]);

    return back();
  } 
public function leview(request $request){
     $ledger = Ledger::orderBy('id','DESC')->get();
      $acc = AccountHead::all(); 
       

  return view('/ledger',['ledger'=>$ledger,'acc'=>$acc]);
}

public function ledgeracc(request $request){
  $yadav = new Ledger;
  $yadav->val_date = $request->date;
  $yadav->Transaction = $request->Transaction;
  $yadav->amount = $request->money;
  $yadav->bank = $request->bank;
  $yadav->branch = $request->branch;
  $yadav->accounthead = $request->acchead;
  $yadav->subhead = $request->brand;
  $yadav->debitcredit  = $request->crdr;
  $yadav->remark = $request->remark;
  $yadav->name = $request->name;

  $yadav->save();

  return back()->with('success',' Added Successfully !!!');

}
public function testdata(request $request){

  $m =unserialize($request->id);
  for($i=0;$i<sizeof($m);$i++){
          $murali = [];
          foreach ($m[$i] as $data) {
            array_push($murali,$data);
          }

  $yadav = new Ledger;
  $yadav->val_date =$murali[0];
  $yadav->Transaction =$murali[1];
  $yadav->amount =$murali[2];
  $yadav->debitcredit =$murali[3];
  $yadav->bank =$murali[4];
  $yadav->branch =$murali[5];
  $yadav->accounthead =$murali[6];
  $yadav->remark = $murali[7];
  $yadav->save();

  }
  $i = $i+1;
  return redirect('/ledger');
}
  public function testeditdata(request $request){
    
  $data = Ledger::where('id',$request->id)->first();
   $data->val_date =$request->date;
  $data->Transaction =$request->trans;
  $data->amount =$request->amount;
  $data->debitcredit =$request->dr;
  $data->bank =$request->bank;
  $data->branch =$request->branch;
  $data->accounthead =$request->acchead;
  $data->subhead = $request->br;
  $data->remark = $request->remark;
  $data->save();

  return back();
  } 
public function testhead(request $request){

    $check = new AccountHead;
    $check->name = $request->achead;
    $check->type = $request->crdr;
    $check->save();
    return back();
}
public function subtesthead(request $request){

    $check = new Subaccountheads;
    $check->AccountHead = $request->accounthead;
    $check->Subaccountheads = $request->subhead;
    $check->type = $request->crdr;
    $check->save();
    return back();
}
public function getsubaccounthead(request $request){

       $cat = $request->cat;
        $subcat = Subaccountheads::where('AccountHead',$cat)
            ->get();
        return response()->json($subcat);
}
public function getuser(request $request){

       $cat = $request->cat;
        $subcat = User::where('department_id','!=',10)->get();
        $res = $subcat;
        return response()->json($res);
}
public function getdetails(request $request){
           
$projectid = $request->projectid;
$project_type = $request->project_type;
$manuids = $request->manuids;
$manutype = $request->manutype;
$pconfirmenq = $request->pconfirmenq;
$pcancelenq = $request->pcancelenq;
$ponprocess = $request->ponprocess;
$porderconfirm = $request->porderconfirm;
$pordercancel = $request->pordercancel;
$monfirmsenq = $request->monfirmsenq;
$mcancelenq = $request->mcancelenq;
$monprocess = $request->monprocess;
$mordercancel  = $request->mordercancel;   

$d = unserialize($projectid);
  $s = implode(",",$d); 
     
       $client = new \GuzzleHttp\Client();
      
       // $request = $client->post($url,['project_id'=>$projectid,'project_type'=>$project_type,'manuids'=>$manuids,'pconfirmenq'=>$pconfirmenq,'pcancelenq'=>$pcancelenq,'ponprocess'=>$ponprocess,'porderconfirm','pordercancel'=>$pordercancel,'monfirmsenq'=>$monfirmsenq,'mcancelenq'=>$mcancelenq,'monprocess'=>$monprocess,'mordercancel'=>$mordercancel]);
       // $response = $request->send();

$response = $client->request('POST', 'https://microtechtesting.tk/MH/api/post_cust', [
    'form_params' => ['project_id'=>$s,'order_id'=>123]
                      
]);

    
 return back();


   
}
public function blocked(request $request){

      $projects = ProjectDetails::onlyTrashed()->get();

      return view('/blocked_projects',['projects'=>$projects]);

}
public  function approval1(request $request){

  
    $val = NULL;
   ProjectDetails::withTrashed()->where('project_id',$request->id1)->update(['deleted_at'=>null]);
   return back();

}
 public function findward(request $request){

       if(count($request->subid) > 0){
        
      $sub =ProjectDetails::where('project_id',$request->projectid)->update(['sub_ward_id'=>$request->subid]); 
       
       ProjectUpdate::where('project_id',$request->projectid)->update(['sub_ward_id'=>$request->subid]); 
       Requirement::where('project_id',$request->projectid)->update(['sub_ward_id'=>$request->subid]); 
       }


      return back();
 }
 public function findmanuward(request $request){

       if(count($request->manusubidfind) > 0){
      $sub =Manufacturer::where('id',$request->projectid)->update(['sub_ward_id'=>$request->manusubidfind]); 
            Requirement::where('manu_id',$request->projectid)->update(['sub_ward_id'=>$request->manusubidfind]); 
        
       }
      return back();
 }


   }
