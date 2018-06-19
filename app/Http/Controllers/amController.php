<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Auth;
use DB;
use App\Ward;
use App\Country;
use App\SubWard;
use App\Zone;
use App\CategoryPrice;
use App\Category;
use App\Requirement;
use App\ProjectDetails;
use App\Vendor;
use App\Department;
use App\loginTime;
use App\User;
use App\Group;
use App\EmployeeDetails;
use App\BankDetails;
use App\Asset;
use App\AssetInfo;
use App\Certificate;
use App\SubCategory;
use App\Report;
use App\attendance;
use App\ManufacturerDetail;
use App\KeyResult;
use App\MhInvoice;
use App\brand;
use App\ActivityLog;
use App\Order;
use App\Message;
use App\training;
use App\MamahomeAsset;

date_default_timezone_set("Asia/Kolkata");
class amController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $message = Message::where('read_by','NOT LIKE',"%".$this->user->id."%")->count();
            View::share('chatcount', $message);
            $trainingCount = training::where('dept',$this->user->department_id)
                            ->where('designation',$this->user->group_id)
                            ->where('viewed_by','NOT LIKE',"%".$this->user->id."%")->count();
            View::share('trainingCount',$trainingCount);
            return $next($request);
        });
    }
    public function getAMDashboard(){
        $prices = CategoryPrice::all();
         $loggedInUsers = attendance::where('date',date('Y-m-d'))
                        ->join('users','empattendance.empId','users.employeeId')
                        ->select('users.name','empattendance.*')
                        ->get();
        $leLogins = loginTime::where('logindate',date('Y-m-d'))
                        ->join('users','login_times.user_id','users.id')
                        ->select('users.name','users.employeeId','login_times.*')
                        ->get();
        return view('assistantmanager.amdashboard',['prices'=>$prices, 'pageName'=>'Home','loggedInUsers'=>$loggedInUsers,'leLogins'=> $leLogins]);
    }
    public function getPricing(){
        $prices = CategoryPrice::all();
        $categories = Category::all();
        return view('assistantmanager.pricing',['prices'=>$prices,'pageName'=>'Price','categories'=>$categories]);
    }
    public function amgetSubCatPrices(Request $request){
        $cat = $request->cat;
        $brand = $request->brand;
        $category = Category::where('id',$cat)->first();
        $subcat = SubCategory::leftJoin('category_price','category_sub.id','=','category_price.category_sub_id')
            ->select('category_sub.*','category_price.price','category_price.gst','category_price.transportation_cost','category_price.royalty')
            ->where('category_sub.category_id',$cat)
            ->get();
        $res = array();
        $res[0] = $category;
        $res[1] = $subcat;
        return response()->json($res);   
    }
    public function getname(Request $request){
       
         $name = MamahomeAsset::where('asset_id',$request->name)->where('status',null)->get();
            return response()->json($name);
    

       
    }
    public function getserial(Request $request){

       $serial = MamahomeAsset::where('id',$request->z)->get();
       return response()->json($serial);
    }
    public function getdesc(Request $request){
        $desc = MamahomeAsset::where('id',$request->z)->get();
        return response()->json($desc);
    }
    public function getBrands(Request $request){
        $res[0] = brand::where('category_id',$request->cat)->get();
        return response()->json($res);
    }
    public function getAmBrands(Request $request){
        $res[0] = brand::all();
        return response()->json($res);
    }
    public function filter(Request $request)
    {
        if($records)
        {
            return response()->json($records);
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function enquirysheet()
    {
        $records = DB::table('record_data')->join('project_details','project_details.project_id','=','record_data.rec_project')->get();
        return view('assistantmanager.amenquirysheet',['records'=>$records,'pageName'=>'Enquiry']);
    }
    public function amorders(Request $request)
    {
        $view = Order::orderby('project_id','DESC')
                ->leftJoin('users','orders.generated_by','=','users.id')
                ->select('orders.*','orders.id as orderid','users.name','users.group_id')
                ->paginate(25);
        return view('assistantmanager.amorders',['view' => $view,'pageName'=>'Orders']);        
    }
    
    //Siddharth's block
    public function updatepay(Request $request)
    {
        $id = $request->id;
        $update = $request->payment;
        $x = Requirement::where('id', $id)->update(['payment_status' => $update]);
        if($x)
        {
            return response()->json($update);
        }
        else
        {
            return response()->json('Error');
        }
    }
    public function updatedispatch(Request $request)
    {
        $id = $request->id;
        $update = $request->dispatch;
        $x = Requirement::where('id', $id)->update(['dispatch_status' => $update]);
        if($x)
        {
            return response()->json($update);
        }
        else
        {
            return response()->json('Error');
        }
    }
  
    
    public function amshowProjectDetails(Request $id)
    {
        $rec = ProjectDetails::where('project_id',$id->projectId)->first();
        return view('assistantmanager.amprojectdetails',['rec' => $rec,'pageName'=>'Orders']);
    }
     public function getamFinance()
    {
        $departments = Department::all();
        return view('assistantmanager.amfinance',['departments'=>$departments,'pageName'=>'Finance']);
    }
    public function getamEmpDetails(Request $request)
    {
        $deptId = Department::where('dept_name',$request->dept)->pluck('id')->first();
        $users = User::where('department_id',$deptId)->get();
        if($request->dept == 'Operation'){
            if($request->from){
                return $request->from;
            }
            $start_date = date("d-m-Y", strtotime("-1 week"));
            $end_date = date("d-m-Y");
            // $this->db->where("store_date >= '" . $start_date . "' AND store_date <= '" . $end_date . "'");
            
            $previous_week = strtotime("-1 week +1 day");
    
            $start_week = strtotime("last sunday midnight",$previous_week);
            $end_week = strtotime("next saturday",$start_week);
            
            $start_week = date("d-m-Y",$start_week);
            $end_week = date("d-m-Y",$end_week);
            
            $expenses = loginTime::where('logindate','>=',$start_date)->where('logindate','<',$end_date)->get();
            $disp = "<div class='panel-body' style='background-color:white'><div class='col-md-4'>From :<input id='from' type='date' class='form-control'></div>".
                    "<div class='col-md-4'>To :<input id='to' type='date' class='form-control'></div><br>".
                    "<div class='col-md-4'><button type='button' id='date' class='form-control btn-default' style='background-color:green;color:white'>Fetch</button></div></div>".
                    "<br><br>";
            echo $disp;
        }else{
            $expenses = "Null";
        }
        return view('assistantmanager.amempdetails',['users'=>$users,'dept'=>$request->dept,'expenses'=>$expenses,'pageName'=>'Finance']);
    }
    public function getamHRPage(){
        $departments = Department::all();
        $groups = Group::all();
        return view('assistantmanager.amhumanresource',['departments'=>$departments,'groups'=>$groups,'pageName'=>'HR']);
    }
    public function addassets(Request $request){
        
         
        $assets = Asset::all();
        $asts = array();
        foreach($assets as $asset){
            $asts[$asset->type] = MamahomeAsset::where('asset_id',$asset->id)->count();
        }
        $asts["SIMCard"] =  MamahomeAsset::where('asset_id',10)->count();
        return view('addassets',['assets'=>$assets,'asts'=>$asts]);
    }
    public function confirmamOrder(Request $request)
    {
        $id = $request->id;
        $x = Order::where('id', $id)->update(['status' => 'Order Confirmed']);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function cancelamOrder(Request $request)
    {
        $id = $request->id;
        $x = Order::where('id', $id)->update(['status' => 'Order Cancelled']);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function printLPO(Request $request)
    {
        $rec = ProjectDetails::where('project_id', $request->id)->first();
        $requirements = Requirement::find($request->reqId);
        $invoice = MhInvoice::where('requirement_id',$request->reqId)->first();
        return view('assistantmanager.printLPO', ['requirements'=>$requirements,'rec' => $rec,'pageName'=>'Orders','invoice'=>$invoice]);
    }
    public function getHRDept(Request $request){
        if($request->dept == "FormerEmployees"){
            $users = User::where('department_id',10)
                ->leftJoin('employee_details', 'users.employeeId', '=', 'employee_details.employee_id')
                ->get();
        return view('assistantmanager.formeremployees',['users'=>$users,'dept'=>$request->dept,'pageName'=>'HR']);
        }
        $deptId = Department::where('dept_name',$request->dept)->pluck('id')->first();
        $users = User::where('department_id',$deptId)
                ->leftJoin('employee_details', 'users.employeeId', '=', 'employee_details.employee_id')
                ->select('users.*','employee_details.verification_status','employee_details.office_phone')
                ->get();
        return view('assistantmanager.hremp',['users'=>$users,'dept'=>$request->dept,'pageName'=>'HR']);
    }
    public function getasset(Request $request){
         
       if($request->asset == "SimCard"){

         $id = Asset::where('type',$request->asset)->pluck('id')->first();
         $tcount = MamahomeAsset::where('asset_id',10)->count();
        $rcount =AssetInfo::where('asset_type',$request->asset)->count();
        $remaining = $tcount-$rcount;
        $mh = MamahomeAsset::where('asset_id',10)->select('mamahome_assets.*')->get(); 
        return view('assetsim',['asset'=>$request->asset,'mh'=>$mh,'tcount'=>$tcount,'rcount'=>$rcount,'remaining' =>$remaining]);
       } 
        $id = Asset::where('type',$request->asset)->pluck('id')->first();
        $tcount = MamahomeAsset::where('asset_id',$id)->count();
        $rcount =AssetInfo::where('asset_type',$request->asset)->count();
        $remaining = $tcount-$rcount;
        $mh = MamahomeAsset::where('asset_id','=',$id)->select('mamahome_assets.*')->get(); 
        return view('hrasset',['asset'=>$request->asset,'mh'=>$mh,'tcount'=>$tcount,'rcount'=>$rcount,'remaining' =>$remaining]);

    }
    public function storeasset(Request $request){
        
       
        $image = time().'.'.request()->upload->getClientOriginalExtension();
        $request->upload->move(public_path('assettype'),$image);
        if($request->bill != null){
        $billimage = time().'.'.request()->bill->getClientOriginalExtension();
        $request->bill->move(public_path('assetbill'),$billimage);
        }
        else{
            $billimage='';
        }
      
       $asset = Asset::where('type',$request->asset)->pluck('id')->first();
        $mhome = New MamahomeAsset;
        $mhome->asset_id = $asset;
        $mhome->name=$request->lname;
        $mhome->sl_no= $request->slno;
        $mhome->asset_image= $image;
        $mhome->description= $request->desc;
        $mhome->company= $request->cmp;
        $mhome->date= $request->tdate;
        $mhome->bill= '';
        $mhome->remark =$request->remark;
        $mhome->save();

        return back();
    }
    public function assetsimcard(Request $request){

         $asset = Asset::where('type',$request->asset)->pluck('id')->first();
        
         $mhome = New MamahomeAsset;
        $mhome->asset_id = 10;
         $mhome->provider = $request->sim;
         $mhome->sim_number = $request->number;
         $mhome->sim_remark = $request->sremark;
         $mhome->save();
         return back();

    }
    public function addtype(Request $request){

        $name = New Asset;
        $name->type = $request->aname;
        $name->save();
       return back()->with('Added','Asset Added Successfully');
    }
    public function amreportdates(Request $request){
        if($request->month != null){
            $today = $request->year."-".$request->month;
        }else{
            $today = date('Y-m');
        }
        $dates = loginTime::where('user_id',$request->uid)->where('logindate','like',$today.'%')->get();
        $user = User::where('id',$request->uid)->first();
        return view('assistantmanager.choosedates',['dates'=>$dates,'uid'=>$request->uid,'pageName'=>'HR','user'=>$user]);
    }
    public function editEmployee(Request $request){
        $user = User::where('employeeId', $request->UserId)->first();
        $employeeDetails = EmployeeDetails::where('employee_id',$request->UserId)->first();
        $bankDetails = BankDetails::where('employeeId',$request->UserId)->first();
        $assets = Asset::all();
        $assetInfos = AssetInfo::where('employeeId',$request->UserId)->get();
        $certificates = Certificate::where('employeeId',$request->UserId)->get();
        return view('assistantmanager.editEmployee',['certificates'=>$certificates,'user'=>$user,'employeeDetails'=>$employeeDetails,'bankDetails'=>$bankDetails,'assets'=>$assets,'assetInfos'=>$assetInfos,'pageName'=>'HR']);
    }
    public function viewEmployee(Request $id)
    {
        $user = User::where('employeeId',$id->UserId)->first();
        $details = EmployeeDetails::Where('employee_id',$id->UserId)->first();
        $bankdetails = BankDetails::where('employeeId',$id->UserId)->first();
        $assets = AssetInfo::where('employeeId',$id->UserId)->get();
        $certificates = Certificate::where('employeeId',$id->UserId)->get();
        return view('assistantmanager.viewEmployee',['user'=>$user,'details'=>$details,'bankdetails'=>$bankdetails,'assets'=>$assets,'certificates'=>$certificates,'pageName'=>'HR']);
    }
    public function hrAttendance(Request $request){
        $user = User::where('employeeId',$request->userId)->first();
        if($request->month){
            $date = $request->year.'-'.$request->month;
            $attendances = attendance::where('empId',$request->userId)->where('date','like',$date.'%')->orderby('date')->get();
        }else{
            $date = date('Y-m');
            $attendances = attendance::where('empId',$request->userId)->where('date','like',$date.'%')->orderby('date')->get();
        }
        return view('assistantmanager.empattendance',['attendances'=>$attendances,'userid'=>$request->userId,'user'=>$user,'pageName'=>'HR']);
    }
    public function viewDailyReport(Request $request){
        $uId = $request->userId;
        $date = $request->date;
        $reports = Report::where('empId',$uId)->where('created_at','like',$date.'%')->get();
        $user = User::where('employeeId',$uId)->first();
        $attendance = attendance::where('empId',$uId)->where('date',$date)->first();
        return view('assistantmanager.viewdailyreport',['reports'=>$reports,'date'=>$date,'user'=>$user,'attendance'=>$attendance,'pageName'=>'HR']);
    }
    public function addvendortype()
    {
        $vendors = DB::table('vendor')->select('vendor.*')->get();
        return view('assistantmanager.amaddvendortype',['vendor'=>$vendors, 'pageName'=>'Vendor Details']);
    }
    public function vendorDetails(){
        $mfdetails = ManufacturerDetail::leftJoin('vendor','vendor.id','=','manufacturer_details.vendortype')->get();
        $category = ManufacturerDetail::groupBy('category')->pluck('category');
        $categories = Category::all();
        $vendor = DB::table('vendor')->select('vendor.*')->get();
        return view('assistantmanager.manufacturerdetails',['mfdetails'=>$mfdetails,'category'=>$category,'vendor' => $vendor,'categories'=>$categories,'pageName'=>'Vendor Details']);
    }
    public function amdailyslots(Request $request)
    {
        $totalListing = array();
        $users = User::where('department_id','1')->where('group_id','6')
                    ->leftjoin('ward_assignments','users.id','ward_assignments.user_id')
                    ->leftjoin('sub_wards','ward_assignments.subward_id','sub_wards.id')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();
        if($request->userId){
            $date = date('Y-m-d');
            $projects = ProjectDetails::where('created_at','like',$date[0].'%')->where('listing_engineer_id',$request->userId)->get();
            $le = DB::table('users')->where('department_id','1')->where('group_id','6')->get();
            $projects = DB::table('project_details')
                ->join('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
                ->join('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
                ->join('users','users.id','=','project_details.listing_engineer_id')
                ->join('sub_wards','sub_wards.id','=','project_details.sub_ward_id')
                ->join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                ->join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                ->join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                ->where('project_details.created_at','like',$date.'%')->where('listing_engineer_id',$request->userId)
                ->select('project_details.*','sub_wards.sub_ward_name','procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name')
                ->get();
            $projcount = count($projects); 
        }else{
            $date = date('Y-m-d');
            $projects = ProjectDetails::where('created_at','like',$date[0].'%')->get();
            $le = DB::table('users')->where('department_id','1')->where('group_id','6')->get();
            $projects = DB::table('project_details')
                ->join('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
                ->join('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
                ->join('users','users.id','=','project_details.listing_engineer_id')
                ->join('sub_wards','sub_wards.id','=','project_details.sub_ward_id')
                ->join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                ->join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                ->join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                ->where('project_details.created_at','like',$date.'%')
                ->select('project_details.*','sub_wards.sub_ward_name', 'procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name')
                ->get();
            $projcount = count($projects);  
        }
        foreach($users as $user){
                $totalListing[$user->id] = ProjectDetails::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
            }
        return view('assistantmanager.dailyslots', ['date' => $date,'users'=>$users, 'projcount' => $projcount, 'projects' => $projects, 'le' => $le,'pageName'=>'dailyslots', 'totalListing'=>$totalListing]);
    }
    public function amprojectadmin(Request $id){
        $details = projectDetails::where('project_id',$id->projectId)->first();
        return view('assistantmanager.viewDailyProjects',['details'=>$details,'pageName'=>'dailyslots']);
    }
    public function getViewReports(Request $request)
    {
        $id=$request->id;
        $date= $request->date;
        $user = User::where('id',$id)->first();
        $logintimes = loginTime::where('user_id',$id)->where('logindate',$date)->first();
        return view('assistantmanager.amreport',['logintimes'=>$logintimes,'user'=>$user,'date'=>$date,'pageName'=>'HR']);
    }
    public function amKRA(){
        $departments = Department::all();
        $groups = Group::all();
        $kras = DB::table('key_results')
            ->join('departments', 'key_results.department_id', '=', 'departments.id')
            ->join('groups', 'key_results.group_id', '=', 'groups.id')
            ->select('key_results.*', 'departments.dept_name', 'groups.group_name')
            ->get();
        return view('assistantmanager.keyresultarea',['departments'=>$departments,'groups'=>$groups,'kras'=>$kras,'pageName'=>'KRA']);
    }
    public function teamamKRA(){
        $dept = [1,2];
        $group = [6,7,12,17,18];
        $departments = Department::whereIn('id',$dept)->get();
        $groups = Group::whereIn('id',$group)->get();
        $kras = DB::table('key_results')
            ->join('departments', 'key_results.department_id', '=', 'departments.id')
            ->join('groups', 'key_results.group_id', '=', 'groups.id')
            ->select('key_results.*', 'departments.dept_name', 'groups.group_name')
            ->whereIn('key_results.department_id',$dept)
            ->whereIn('key_results.group_id',$group)
            ->get();
        return view('assistantmanager.keyresultarea',['departments'=>$departments,'groups'=>$groups,'kras'=>$kras,'pageName'=>'KRA']);
    }
    public function addKRA(Request $request){
        $kra = new KeyResult;
        $kra->department_id = $request->department;
        $kra->group_id = $request->group;
        $kra->role = $request->role;
        $kra->goal = $request->goal;
        $kra->key_result_area = $request->kra;
        $kra->key_performance_area = $request->kpa;
        $kra->save();
        return back()->with('Success','You have added KRA successfully');
    }
    public function teamaddKRA(Request $request){
        $kra = new KeyResult;
        $kra->department_id = $request->department;
        $kra->group_id = $request->group;
        $kra->role = $request->role;
        $kra->goal = $request->goal;
        $kra->key_result_area = $request->kra;
        $kra->key_performance_area = $request->kpa;
        $kra->save();


        return back()->with('Success','You have a


            ed KRA successfully');
    }
    public function editkra(Request $request)
    {
        $groupid = $request->groupid;
        $deptid = $request->deptid;
        $rec = DB::table('key_results')->join('departments', 'key_results.department_id', '=', 'departments.id')
                    ->join('groups', 'key_results.group_id', '=', 'groups.id')
                    ->select('key_results.*', 'departments.dept_name', 'groups.group_name')
                    ->where('key_results.group_id',$groupid)
                    ->where('key_results.department_id',$deptid)
                    ->get();           
        return view('assistantmanager.keyresultedit',['kra'=>$rec,'pageName' => 'KRA']);
    }
    public function deletekra(Request $request)
    { 
        $groupid = $request->groupid;

        $deptid = $request->deptid;
        $rec = DB::table('key_results')->where('department_id',$deptid)->where('group_id',$groupid)->delete();
        return back();
    }
    public function updatekra(Request $request)
    {
    
        KeyResult::where('id',$request->id)
            ->update(['role'=>$request->role,
                'goal'=>$request->goal,
                'key_result_area'=>$request->kra,
                'key_performance_area' => $request->kpa]);
        return back();
    }
    
    public function confirmDelivery(Request $request){
        $requirement = Requirement::where('id',$request->id)->first();
        $project = ProjectDetails::where('project_id',$request->projectId)->first();
        $subward = SubWard::where('id',$project->sub_ward_id)->pluck('sub_ward_name')->first();
        return view('assistantmanager.confirmDelivery',['pageName'=>'Orders','requirement'=>$requirement,'project'=>$project,'subward'=>$subward]);
    }
    public function postconfirmDelivery(Request $request){
        $invoiceCount = count(MhInvoice::all()) + 1;
        $no = sprintf("%04d", $invoiceCount);
        $project = ProjectDetails::where('project_id',$request->projectId)->first();
        $subward = SubWard::where('id',$project->sub_ward_id)->first();
        $ward = Ward::where('id',$subward->ward_id)->first();
        $country = Country::where('id',$ward->country_id)->first();
        $zone = Zone::where('id',$ward->zone_id)->first();
        $invoiceNo = "MH_".$country->country_code."_".$zone->zone_number."_".date('Y')."_".$country->country_code.$no;
        $invoice = new MhInvoice;
        $invoice->project_id = $request->projectId;
        $invoice->requirement_id = $request->requiremntId;
        $invoice->customer_name = $request->customerName;
        $invoice->deliver_location = $request->location;
        $invoice->sub_ward = $request->subward;
        $invoice->invoice_number = $invoiceNo;
        $invoice->amount_received = $request->amount;
        $invoice->receive_date = $request->rDate;
        $invoice->payment_method = $request->paymentMethod;
        $invoice->transactional_details = $request->transactionNo;
        $invoice->save();
        Requirement::where('id',$request->requiremntId)->update(['delivery_status'=>"Delivered"]);
        return back();
    }
    public function updateUser(Request $request){
        $check = EmployeeDetails::where('employee_id',$request->userId)->first();
        if($check->verification_status == "Pending"){
            EmployeeDetails::where('employee_id',$request->userId)->update(['verification_status'=>"Verified"]);
        }else{
            EmployeeDetails::where('employee_id',$request->userId)->update(['verification_status'=>"Pending"]);
        }
        $text = "Updated Successfully !!!";
        return response()->json($text);
    }
    public function placeOrder(Request $request)
    {
        $id = $request->id;
        $x = Requirement::where('id', $id)->update(['status' => 'Order Placed','dispatch_status' => 'Not yet dispatched']);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function addvendor(Request $request){
        $vendor = new Vendor;
        $vendor->vendor_type = $request->vendor;
        $vendor->save();
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has added new vendor".$request->vendor." at ".date('H:i A');
        $activity->save();
        return back()->with('Success','Vendor type added successfully');
    }
    public function inactiveEmployee(Request $request){
        User::where('employeeId',$request->id)->update(['department_id'=>10]);
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has marked ".$request->id." as inactive at ".date('H:i A');
        $activity->save();
        return back()->with('Success','Employee marked as inactive');
    }
    public function savePetrolExpenses(Request $request){
        $count = count($request->id);
        for($i = 0; $i < $count; $i++){
            loginTime::where('id',$request->id[$i])->update(['total_kilometers'=>$request->exp[$i]]);
        }
        return back()->with('Success','Petrol Expense Updated Successfully');
    }
    public function deleteAsset(Request $request)
    {
         $mh = AssetInfo::where('id',$request->id)->pluck('mh_id')->first();
        AssetInfo::where('id',$request->id)->delete();
        $mhasset = MamahomeAsset::where('id',$mh)->first();
        $mhasset->status = null;
        $mhasset->save();
        return back();
    }
     public function deleteassetsim(Request $request)
    {
        
        MamahomeAsset::where('id',$request->id)->delete();
        return back();
    }
     public function deletesim(Request $request)
    {
        
        $mh = AssetInfo::where('id',$request->id)->pluck('mh_id')->first();
        AssetInfo::where('id',$request->id)->delete();
        $mhasset = MamahomeAsset::where('id',$mh)->first();
        $mhasset->status = null;  
        $mhasset->save();
        return back();
    }
    public function deleteassets(Request $request)
    {
        MamahomeAsset::where('id',$request->Id)->delete();
        return back();
    }
    public function deleteCertificate(Request $request)
    {
        $userid = Certificate::find($request->id);
        $username = User::where('employeeId',$userid->employeeId)->pluck('name')->first();
        Certificate::find($request->id)->delete();
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has deleted ".$username."'s certificate at ".date('H:i A');
        $activity->save();
        return back();
    }
    public function assignassets(Request $request)
    {

        $departments = Department::all();
        $groups = Group::all();
        return view('assignassets',['departments'=>$departments,'groups'=>$groups]);
    
    }
    public function getview(Request $request){
       $deptId = Department::where('dept_name',$request->dept)->pluck('id')->first();
        $users = User::where('department_id',$deptId)
                ->leftJoin('employee_details', 'users.employeeId', '=', 'employee_details.employee_id')
                ->select('users.*','employee_details.verification_status','employee_details.office_phone')
                ->get();
        return view('hrassign',['users'=>$users,'dept'=>$request->dept,'pageName'=>'HR']);
    }
     public function assignEmployee(Request $request){

        $user = User::where('employeeId', $request->UserId)->first();
        $employeeDetails = EmployeeDetails::where('employee_id',$request->UserId)->first();
        $assets = Asset::where('id','!=',10)->get();
        $sim = MamahomeAsset::where('asset_id','=',10)->get();
        $assetInfos = AssetInfo::where('employeeId',$request->UserId)->get();
        $info = AssetInfo::where('id',$request->id)->get();
        return view('assignEmployee',['user'=>$user,'employeeDetails'=>$employeeDetails,'assets'=>$assets,'assetInfos'=>$assetInfos,'sim'=>$sim,    
            'pageName'=>'HR']);
    }
    public function editasset(Request $request){
        $post = MamahomeAsset::where('id',$request->Id)->get();
        return view('editasset',['post'=>$post]);

    }
    public function saveasset(Request $request){

         MamahomeAsset::where('id',$request->Id)->update([
        'name'=> $request->ename,
        'sl_no' => $request->serialno,
        'description' => $request->desc,
        'company' => $request->cmp,
        'remark' =>$request->remark,
            
        ]);
         return redirect('/assets');
    }
    public function saveassetinfo(Request $request){

        AssetInfo::where('id',$request->Id)->update([
            'serial_no' =>$request->serial_no,
            'description' =>$request->desc,
            'remark' =>$request->remark,
        ]);
        return back();
    }
    public function savesiminfo(Request $request){

        
         $simnumber = MamahomeAsset::where('id',$request->number)->pluck('sim_number')->first();
         $empimage = time().'.'.request()->emp_image->getClientOriginalExtension();
        $request->emp_image->move(public_path('empsignature'),$empimage);
        $mimage = time().'.'.request()->manager_image->getClientOriginalExtension();
        $request->manager_image->move(public_path('managersignature'),$mimage);
         $assetInfo = new AssetInfo;
        $assetInfo->asset_type = 'SIMCard';
        $assetInfo->mh_id = $request->number;
        $assetInfo->employeeId = $request->userId;
        $assetInfo->emp_signature = $empimage;
        $assetInfo->manager_signature = $mimage;
         $assetInfo->provider = $request->sim;
         $assetInfo->sim_number = $simnumber;
         $assetInfo->sim_remark = $request->sremark;
         $assetInfo->save();


        $mhasset = MamahomeAsset::where('id',$request->number)->first();
        $mhasset->status = "Assigned";
        $mhasset->save();

         return back();


    }
    public function getbrand(Request $request){
       $name = MamahomeAsset::where('id',$request->name)->where('status',null)->get();

       return response()->json($name);
    }
    public function signature()
    {
        return view('logistics.takesignature');
    }
    public function preview(Request $request)
    {
         $user = User::where('employeeId', $request->Id)
        ->leftJoin('employee_details', 'users.employeeId', '=', 'employee_details.employee_id')
                ->select('users.*','employee_details.date_of_joining','employee_details.permanent_address')
                ->get();
        $info = AssetInfo::where('id', $request->id)->get();

        return view('preview',['user'=>$user,'info'=>$info]);
    }
}
