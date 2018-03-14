<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\orderconfirmation;
use App\Mail\invoice;
use App\Department;
use App\User;
use App\Group;
use App\Ward;
use App\Country;
use App\SubWard;
use App\WardAssignment;
use App\ProjectDetails;
use App\SiteAddress;
use App\Territory;
use App\State;
use App\Zone;
use App\loginTime;
use App\Requirement;
use App\ProcurementDetails;
use App\SiteEngineerDetails;
use App\OwnerDetails;
use App\ConsultantDetails;
use App\attendance;
use App\ContractorDetails;
use App\salesassignment;
use App\Report;
use Auth;
use DB;
use App\EmployeeDetails;
use App\BankDetails;
use App\Asset;
use App\AssetInfo;
use App\Category;
use App\SubCategory;
use App\CategoryPrice;
use App\ManufacturerDetail;
use App\Certificate;
use App\MhInvoice;
use App\ActivityLog;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function authlogin()
    {
        date_default_timezone_set("Asia/Kolkata");
        $check = loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->get();
        if(count($check)==0){
            $login = New loginTime;
            $login->user_id = Auth::user()->id;
            $login->logindate = date('Y-m-d');
            $login->loginTime = date('H:i A');
            $login->logoutTime = "N/A";
            $login->save();
        }
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has logged in to the system at ".date('H:i A');
        $activity->save();
        return redirect('/home');
    }
    public function authlogout(Request $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has logged out of the system at ".date('H:i A');
        $activity->save();
        Auth()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
    public function inputview()
    {
        return view('inputview');
    }
    public function inputdata(Request $request)
    {
        $x = DB::table('record_data')->insert(['rec_project'    =>$request->selectprojects,
                                                'rec_date'      =>$request->edate,
                                                'rec_name'      =>$request->ename,
                                                'rec_contact'   =>$request->econtact,
                                                'rec_email'     =>$request->eemail,
                                                'rec_product'   =>$request->eproduct,
                                                'rec_location'  =>$request->elocation,
                                                'rec_quantity'  =>$request->equantity,
                                                'rec_remarks'   =>$request->eremarks
                                        ]);
        if($x)
        {
            return back()->with('success','Inserted Successfully !!!');
        }
        else
        {
            return back()->with('success','Error Occurred !!!');
        }
    }
    public function getProjects(Request $request)
    {
        $contact = $request->contact;
        $x = ProjectDetails::join('procurement_details','procurement_details.project_id','=','project_details.project_id')
                            ->where('procurement_details.procurement_contact_no',$contact)
                            ->get();
        if(count($x)==0){
            $x = ProjectDetails::join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                                ->where('consultant_details.consultant_contact_no',$contact)
                                ->get();
            if(count($x) == 0)
            {
                $x = ProjectDetails::join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                        ->where('site_engineer_details.site_engineer_contact_no',$contact)
                        ->get();
                if(count($x) == 0)
                {
                    $x = ProjectDetails::join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                        ->where('contractor_details.contractor_contact_no',$contact)
                        ->get();
                    if(count($x) == 0)
                    {
                        $x = ProjectDetails::join('owner_details','owner_details.project_id','=','project_details.project_id')
                                            ->where('owner_details.owner_contact_no',$contact)
                                            ->get();
                        if(count($x) == 0){
                            $x = 'Nothing Found';    
                        }                    
                    }    
                }        
            }
        }
        if($x)
        {
            return response()->json($x);
        }                    
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function enquirysheet()
    {
        $records = DB::table('record_data')->get();
        return view('enquirysheet',['records'=>$records]);
    }
    public function index()
    {
        if(Auth::user()->confirmation == 0){
            return view('companypolicy');
        }
        $group = Group::where('id',Auth::user()->group_id)->pluck('group_name')->first();
        $dept = Department::where('id',Auth::user()->department_id)->pluck('dept_name')->first();
        $users = User::where('department_id','!=',0)->paginate(10);
        $departments = Department::all();
        $groups = Group::where('group_name','!=','Admin')->get();
        if($group == "Team Lead" && $dept == "Operation"){
            return redirect('teamLead');
        }else if($group == "Listing Engineer" && $dept == "Operation"){
            return redirect('leDashboard');
        }else if($group == "Team Lead" && $dept == "Sales"){
            return redirect('salesTL');
        }else if($group == "Sales Engineer" && $dept == "Sales"){
            return redirect('salesEngineer');
        }else if($dept == "Management"){
            return redirect('amdashboard');
        }else if($group == "Logistic Co-ordinator (Sales)"){
            return redirect('lcodashboard');
        }else if($group == "Account Executive"){
            return redirect('accountExecutive');
        }else if($group == "Admin"){
            return view('home',['departments'=>$departments,'users'=>$users,'groups'=>$groups]);
        }else{
            Auth()->logout();
            return view('errors.403error');
        }
        return view('home',['departments'=>$departments,'users'=>$users,'groups'=>$groups]);
    }
    public function amDept()
    {
        $users = User::where('department_id','!=',0)->paginate(10);
        $departments = Department::all();
        $groups = Group::where('group_name','!=','Admin')->get();
        return view('depdesign',['departments'=>$departments,'users'=>$users,'groups'=>$groups]);
    }
    public function quality()
    {
        $genuine = ProjectDetails::where('quality',"GENUINE")->count();
        $fake = ProjectDetails::where('quality',"FAKE")->count();
        $notConfirmed = ProjectDetails::where('quality',null)->count();
        $le = User::where('group_id','6')->get();
        $notes = ProjectDetails::groupBy('with_cont')->pluck('with_cont');
        $count = array();
        foreach($notes as $note){
            $count[$note] = ProjectDetails::where('with_cont',$note)->count();
        }
        $projects = ProjectDetails::join('users','users.id','=','project_details.listing_engineer_id')->orderBy('project_details.created_at','DESC')->get();
        return view('Qualityproj', ['notes'=>$notes,'count'=>$count,'le' => $le, 'projects' => $projects,'genuine'=>$genuine,'fake'=>$fake,'notConfirmed'=>$notConfirmed]);
    }
    
    public function getquality(Request $request)
    {
        $id = $request->id;
        $quality = $request->quality;
        $date1 = $request->date1;
        $date2 = $request->date2;
        $records = array();
        if($date1 == $date2)
        {
            $date1 .= " 00:00:00";
            $date2 .= " 23:59:59";
            if($quality == 'ALL')
            {
                if($id == 'ALL'){
                    $records[0] = ProjectDetails::join('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                    ->join('users','users.id','=','project_details.listing_engineer_id')
                    ->where('project_details.created_at','>',$date1)
                    ->where('project_details.created_at','<',$date2)
                    ->select('project_details.project_id','sub_wards.sub_ward_name','project_details.created_at','project_details.contract')
                    ->get();    
                    $records[2] = count($records[0]);                
                }else{
                    $records[0] = ProjectDetails::join('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                    ->join('users','users.id','=','project_details.listing_engineer_id')
                    ->where('users.id',$id)
                    ->where('project_details.created_at','>',$date1)
                    ->where('project_details.created_at','<',$date2)
                    ->select('project_details.project_id','sub_wards.sub_ward_name','project_details.created_at','project_details.contract')
                    ->get();    
                    $records[2] = count($records[0]);
                }
            }
            else
            {
                if($id == 'ALL'){
                    $records[0] = ProjectDetails::join('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                    ->join('users','users.id','=','project_details.listing_engineer_id')
                    ->where('project_details.created_at','>',$date1)
                    ->where('project_details.created_at','<',$date2)
                    ->where('quality',$quality)
                    ->select('project_details.project_id','sub_wards.sub_ward_name','project_details.created_at','project_details.contract')
                    ->get();
                    $records[2] = count($records[0]);
                }else{
                    $records[0] = ProjectDetails::join('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                    ->join('users','users.id','=','project_details.listing_engineer_id')
                    ->where('users.id',$id)
                    ->where('project_details.created_at','>',$date1)
                    ->where('project_details.created_at','<',$date2)
                    ->where('quality',$quality)
                    ->select('project_details.project_id','sub_wards.sub_ward_name','project_details.created_at','project_details.contract')
                    ->get();
                    $records[2] = count($records[0]);
                }
            }
            
        }
        else
        {
            $date1 .= " 00:00:00";
            $date2 .= " 23:59:59";
            if($quality == 'ALL')
            {
                if($id == 'ALL'){
                    $records[0] = ProjectDetails::join('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                    ->join('users','users.id','=','project_details.listing_engineer_id')
                    // ->where('users.id',$id)
                    ->where('project_details.created_at','>',$date1)
                    ->where('project_details.created_at','<',$date2)
                    ->select('project_details.project_id','sub_wards.sub_ward_name','project_details.created_at','project_details.contract')
                    ->get();    
                    $records[2] = count($records[0]);
                }else{
                    $records[0] = ProjectDetails::join('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                    ->join('users','users.id','=','project_details.listing_engineer_id')
                    ->where('users.id',$id)
                    ->where('project_details.created_at','>',$date1)
                    ->where('project_details.created_at','<',$date2)
                    ->select('project_details.project_id','sub_wards.sub_ward_name','project_details.created_at','project_details.contract')
                    ->get();    
                    $records[2] = count($records[0]);
                }
            }
            else
            {
                if($id == 'ALL'){
                    $records[0] = ProjectDetails::join('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                    ->join('users','users.id','=','project_details.listing_engineer_id')
                    // ->where('users.id',$id)
                    ->where('project_details.created_at','>',$date1)
                    ->where('project_details.created_at','<',$date2)->where('quality',$quality)
                    ->select('project_details.project_id','sub_wards.sub_ward_name','project_details.created_at','project_details.contract')
                    ->get();
                    $records[2] = count($records[0]);
                }else{
                    $records[0] = ProjectDetails::join('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                    ->join('users','users.id','=','project_details.listing_engineer_id')
                    ->where('users.id',$id)->where('project_details.created_at','>',$date1)
                    ->where('project_details.created_at','<',$date2)->where('quality',$quality)
                    ->select('project_details.project_id','sub_wards.sub_ward_name','project_details.created_at','project_details.contract')
                    ->get();
                    $records[2] = count($records[0]);
                }
            }
            
        }
        $records[1] = $id.' '.$quality.' '.$date1.' '.$date2;
        return response()->json($records);
    }
    public function viewEmployee(Request $id)
    {
        $user = User::where('employeeId',$id->UserId)->first();
        $details = EmployeeDetails::Where('employee_id',$id->UserId)->first();
        $bankdetails = BankDetails::where('employeeId',$id->UserId)->first();
        $assets = AssetInfo::where('employeeId',$id->UserId)->get();
        $certificates = Certificate::where('employeeId',$id->UserId)->get();
        return view('viewEmployee',['user'=>$user,'details'=>$details,'bankdetails'=>$bankdetails,'assets'=>$assets,'certificates'=>$certificates]);
    }
    public function teamLeadHome(){
        $group = Group::where('group_name','Listing Engineer')->pluck('id')->first();
        $users = User::where('group_id',$group)
                        ->join('ward_assignments','ward_assignments.user_id','=','users.id')
                        ->join('sub_wards','sub_wards.id','=','ward_assignments.subward_id')
                        ->join('wards','wards.id','=','sub_wards.ward_id' )
                        ->where('department_id','!=','10')
                        ->select('users.employeeId','users.id','users.name','ward_assignments.status','sub_wards.sub_ward_name','sub_wards.sub_ward_image','ward_assignments.prev_subward_id')
                        ->get();

        $subwardsAssignment = WardAssignment::all();
        $subwards = SubWard::orderby('sub_ward_name','ASC')->get();
        $wards = Ward::all();
        return view('teamLeader',['users'=>$users,'subwards'=>$subwards,'subwardsAssignment'=>$subwardsAssignment,'wards'=>$wards]);
    }
    public function loadSubWards(Request $request)
    {
        $subwards = Subward::where('ward_id',$request->ward_id)
                            ->orderby('sub_ward_name','ASC')
                            ->select('id','sub_ward_name')
                            ->get();
        if(count($subwards) > 0)
        {
            return response()->json($subwards);
        }
        else
        {
            return response()->json('No Sub Wards Found !!!');
        }
    }
    public function masterData()
    {
        $wards = Ward::orderBy('ward_name','ASC')->get();
        $countries = Country::all();
        $subwards = SubWard::orderby('sub_ward_name','ASC')->get();
        $states = State::all();
        $zones = Zone::all();
        return view('masterData',['wards'=>$wards,'countries'=>$countries,'subwards'=>$subwards,'states'=>$states,'zones'=>$zones]);
    }
   
    public function listingEngineer()
    {
        $wardsAssigned = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $subwards = SubWard::where('id',$wardsAssigned)->first();
        return view('listingEngineer',['subwards'=>$subwards]);
    }
    public function leDashboard()
    {
        $ordersInitiated = Requirement::where('generated_by',Auth::user()->id)
                            ->count();
        $ordersConfirmed = Requirement::where('generated_by',Auth::user()->id)
                            ->where('status','Order Confirmed')->count();
        $check = loginTime::where('user_id',Auth::user()->id)
            ->where('logindate',date('Y-m-d'))->first();
        if(count($check)==0){
            $login = New loginTime;
            $login->user_id = Auth::user()->id;
            $login->logindate = date('Y-m-d');
            $login->loginTime = date('H:i A');
            $login->logoutTime = "N/A";
            $login->save();   
        }
        date_default_timezone_set("Asia/Kolkata");
        $loginTime = mktime(05,15,00);
        $logoutTime = mktime(22,45,00);
        $outtime = date('H:i:sA',$logoutTime);
        $ldate = date('H:i:sA');
        $lodate = date('H:i:sA',$loginTime);
        
        $today = date('Y-m-d');
        $projectCount = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)
            ->where('created_at','like',$today.'%')->get());
        $loginTimes = loginTime::where('user_id',Auth::user()->id)->where('logindate',$today)->first();
        $totalLists = $loginTimes->TotalProjectsListed;
        
        $numbercount = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)->get());
        $wardsAssigned = WardAssignment::where('user_id',Auth::user()->id)->where('status','Not Completed')->pluck('subward_id')->first();
        $subwards = SubWard::where('id',$wardsAssigned)->first();
        $projects = ProjectDetails::join('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get();
        $prices = CategoryPrice::all();
        return view('listingEngineerDashboard',['prices'=>$prices,
                                                'subwards'=>$subwards,
                                                'projects'=>$projects,
                                                'numbercount'=>$numbercount,
                                                'ldate'=>$ldate,
                                                'lodate'=>$lodate,
                                                'outtime'=>$outtime,
                                                'total'=>$totalLists,
                                                'ordersInitiated'=>$ordersInitiated,
                                                'ordersConfirmed'=>$ordersConfirmed
                                                ]);
    }
    public function projectList()
    {
        $projectlist = ProjectDetails::where('listing_engineer_id',Auth::user()->id)->get();
        return view('projectlist',['projectlist'=>$projectlist]);
    }
    public function editProject(Request $request)
    {
        $projectdetails = ProjectDetails::where('project_id',$request->projectId)->first();
        $wardsAssigned = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $subwards = SubWard::where('id',$wardsAssigned)->first();
        return view('update',['subwards'=>$subwards,'projectdetails'=>$projectdetails]);
    }
    public function viewAll()
    {
        $allProjects = ProjectDetails::all();
        return view('allProjects',['allProjects'=>$allProjects]);
    }
    public function viewDetails($id)
    {
        $projectdetails = ProjectDetails::where('project_id',$id)->first();
        return view('viewDetails',['projectdetails'=>$projectdetails]);
    }
    public function getRoads()
    {
       $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $roads = ProjectDetails::where('sub_ward_id',$assignment)->groupBy('road_name')->pluck('road_name');
        
        $projectCount = array();
        
        foreach($roads as $road){
            $genuine = ProjectDetails::where('road_name',$road)
                                                    ->where('quality','Genuine')
                                                    ->where('sub_ward_id',$assignment)
                                                    ->count();
            $null = ProjectDetails::where('road_name',$road)
                                                    ->where('quality',null)
                                                    ->where('sub_ward_id',$assignment)
                                                    ->count();
            $projectCount[$road] = $genuine + $null;
        }
        return view('roads',['roads'=>$roads,'projectCount'=>$projectCount]);
    }
    public function viewProjectList(Request $request)
    {
        $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $projectlist = ProjectDetails::where('road_name',$request->road)
                    ->where('sub_ward_id',$assignment)
                    ->get();
        return view('projectlist',['projectlist'=>$projectlist,'pageName'=>"Update"]);
    }
    public function getMyReports(Request $request)
    {
        if(!$request->date){
            date_default_timezone_set("Asia/Kolkata");
            $today = date('Y-m-d');
            $projectCount = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)
                ->where('created_at','like',$today.'%')->get());
            $loginTimes = loginTime::where('user_id',Auth::user()->id)->where('logindate',$today)->first();
            return view('reports',['loginTimes'=>$loginTimes,'projectCount'=>$projectCount]);
        }else{
            $projectCount = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)
                ->where('created_at','like',$request->date.'%')->get());
            $loginTimes = loginTime::where('user_id',Auth::user()->id)->where('logindate',$request->date)->first();
            return view('reports',['loginTimes'=>$loginTimes,'projectCount'=>$projectCount]);
        }
    }
    public function updateAssignment(){
        WardAssignment::where('user_id',Auth::user()->id)->delete();
        return back();
    }
    public function viewLeReport(Request $request)
    {
        $id = $request->UserId;
        $username = User::where('id',$id)->first();
        if($request->date){
            $loginTimes = loginTime::where('user_id',$id)
                ->where('logindate',$request->date)->first();
            if($loginTimes != NULL){
                return view('lereportbytl',['loginTimes'=>$loginTimes,'userId'=>$id,'username'=>$username]);             
            }else{
                $loginTimes = loginTime::where('user_id',$id)
                    ->where('logindate',date('Y-m-d'))->first();
                return back()->with('Error','No Records found');
            }
        }
        $loginTimes = loginTime::where('user_id',$id)
            ->where('logindate',date('Y-m-d'))->first();
        return view('lereportbytl',['loginTimes'=>$loginTimes,'userId'=>$id,'username'=>$username]);
    }
    public function getRequirementRoads()
    {
        $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $roads = ProjectDetails::where('sub_ward_id',$assignment)->groupBy('road_name')->pluck('road_name');
        $projectCount = array();
        
        foreach($roads as $road){
            $genuine = ProjectDetails::where('road_name',$road)
                                                    ->where('quality','Genuine')
                                                    ->where('sub_ward_id',$assignment)
                                                    ->count();
            $null = ProjectDetails::where('road_name',$road)
                                                    ->where('quality',null)
                                                    ->where('sub_ward_id',$assignment)
                                                    ->count();
            $projectCount[$road] = $null + $genuine;
        }
        return view('requirementsroad',['roads'=>$roads,'projectCount'=>$projectCount]);
    }
    public function projectRequirement(Request $request)
    {
        $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $projectlist = ProjectDetails::where('road_name',$request->road)
        ->where('sub_ward_id',$assignment)
            ->get();
        return view('projectlist',['projectlist'=>$projectlist,'pageName'=>"Requirements"]);
    }
    public function getRequirements(Request $request)
    {
        $requirements = Requirement::where('project_id',$request->projectId)->get();
        $category = Category::all();
        return view('requirements',['category'=>$category, 'requirements'=>$requirements,'id'=>$request->projectId]);
    }
    public function deleteReportImage($id)
    {
        $file = loginTime::where('id',$id)->pluck('morningMeter')->first();
        $file_path = "public/meters/".$file;
        if(file_exists($file_path)){
            @unlink($file_path);
        }
        loginTime::where('id',$id)->update([
            'morningMeter' => Null,
        ]);
        return back();
    }
    public function deleteReportImage2($id)
    {
        $file = loginTime::where('id',$id)->pluck('morningData')->first();
        $file_path = "public/data/".$file;
        if(file_exists($file_path)){
            @unlink($file_path);
        }
        loginTime::where('id',$id)->update([
            'morningData' => Null,
        ]);
        return back();
    }
    public function deleteReportImage3($id)
    {
        $file = loginTime::where('id',$id)->pluck('afternoonMeter')->first();
        $file_path = "public/meters/".$file;
        if(file_exists($file_path)){
            @unlink($file_path);
        }
        loginTime::where('id',$id)->update([
            'afternoonMeter' => Null,
        ]);
        return back();
    }
    public function deleteReportImage4($id)
    {
        $file = loginTime::where('id',$id)->pluck('afternoonData')->first();
        $file_path = "public/data/".$file;
        if(file_exists($file_path)){
            @unlink($file_path);
        }
        loginTime::where('id',$id)->update([
            'afternoonData' => Null,
        ]);
        return back();
    }
    public function deleteReportImage5($id)
    {
        $file = loginTime::where('id',$id)->pluck('eveningMeter')->first();
        $file_path = "public/meters/".$file;
        if(file_exists($file_path)){
            @unlink($file_path);
        }
        loginTime::where('id',$id)->update([
            'eveningMeter' => Null,
        ]);
        return back();
    }
    public function deleteReportImage6($id)
    {
        $file = loginTime::where('id',$id)->pluck('eveningData')->first();
        $file_path = "public/data/".$file;
        if(file_exists($file_path)){
            @unlink($file_path);
        }
        loginTime::where('id',$id)->update([
            'eveningData' => Null,
        ]);
        return back();
    }
    public function getConfirmOrder($id)
    {
        $orders = Requirement::where('project_id',$id)->where('status','Order Confirmed')->get();
        $project = projectdetails::where('project_id',$id)->first();  
        return view('confirmed',['orders'=>$orders,'project'=>$project,'id'=>$id]);
    }
    public function getPayment(Request $request)
    {
        $total = $request->total;
        return view('payment.payment',['total'=>$total]);
    }
    public function getAMReports()
    {
        $group = Group::where('group_name','Listing Engineer')->pluck('id')->first();
        $group2 = Group::where('group_name','Sales Engineer')->pluck('id')->first();
        $users = User::where('group_id',$group)->orwhere('group_id',$group2)->paginate(10);
        return view('reportsbyam',['users'=>$users]);
    }
    public function getViewReports($id,$date)
    {
        $user = User::where('id',$id)->first();
        $logintimes = loginTime::where('user_id',$id)->where('logindate',$date)->first();
        return view('amreport',['logintimes'=>$logintimes,'user'=>$user,'date'=>$date]);
    }
    public function amreportdates($uid, Request $request){
        if($request->month != null){
            $today = $request->year."-".$request->month;
        }else{
            $today = date('Y-m');
        }
        $dates = loginTime::where('user_id',$uid)->where('logindate','like',$today.'%')->orderby('logindate','ASC')->get();
        $user = User::where('id',$uid)->first();
        return view('choosedates',['dates'=>$dates,'uid'=>$uid,'user'=>$user]);
    }
    public function placeOrder($id, Request $request)
    {
        Requirement::where('id',$id)->update([ 'status' => 'Order Placed']);
        $orders = Requirement::where('id',$id)->first();
        return view('confirm',['orders'=>$orders,'id'=>$id])->with('Success','Order has been placed successfully');
    }
    public function invoice($id, Request $request)
    {
        $requirement = Requirement::where('id',$id)->first();
        Mail::to($request->email)->send(new invoice($id));
        return redirect('/requirementsroads');
    }
    public function completethis(Request $id)
    {   
        salesassignment::where('user_id',$id->userid)->update(['status'=>'Completed']);
        return back();
    }
    // sales
    public function getSalesTL(){
        $id = Department::where('dept_name',"Sales")->pluck('id')->first();
        $users = User::where('department_id',$id)
                        ->leftjoin('salesassignments','salesassignments.user_id','=','users.id')
                        ->select('salesassignments.*','users.employeeId','users.name','users.id')
                        ->get();
        $subwardsAssignment = salesassignment::where('status','Not Completed')->get();

        return view('salestl',['users'=>$users,'subwardsAssignment'=>$subwardsAssignment,'pageName'=>'Assign']);
    }
    public function getSalesEngineer()
    {
        $today = date('Y-m');
        $requests = User::where('department_id', 100)->where('confirmation',0)->orderBy('created_at','DESC')->get();
        $reqcount = count($requests);
        $assignment = salesassignment::where('user_id',Auth::user()->id)->pluck('assigned_date')->first();
        $projects = ProjectDetails::where('created_at','like',$assignment.'%')->paginate(10);
        $calls = ProjectDetails::where('call_attended_by',Auth::user()->id)->count();
        $followups = ProjectDetails::where('follow_up_by',Auth::user()->id)->count();
        $ordersinitiate = Requirement::where('generated_by',Auth::user()->id)
                            ->where('status','Order Initiated')
                            ->count();
        $ordersConfirmed = Requirement::where('generated_by',Auth::user()->id)
                            ->where('status','Order Confirmed')
                            ->count();
        $fakeProjects = ProjectDetails::where('quality','Fake')
                                ->where('call_attended_by',Auth::user()->id)
                                ->count();
        $genuineProjects = ProjectDetails::where('quality','Genuine')
                                ->where('call_attended_by',Auth::user()->id)
                                ->count();
        $total = $fakeProjects + $genuineProjects;
        $prices = CategoryPrice::all();
        return view('salesdashboard',[
            'projects'=>$projects,
            'reqcount'=>$reqcount,
            'assignment'=>$assignment,
            'prices'=>$prices,
            'calls'=>$calls,
            'followups'=>$followups,
            'ordersinitiate'=>$ordersinitiate,
            'ordersConfirmed'=>$ordersConfirmed,
            'fakeProjects'=>$fakeProjects,
            'genuineProjects'=>$genuineProjects
        ]);
    }
    public function printLPO($id, Request $request)
    {
        $rec = ProjectDetails::where('project_id', $id)->first();
        return view('printLPO', ['rec' => $rec]);
    }
    public function ampricing(Request $request){
        $prices = CategoryPrice::all();
        $categories = Category::all();
        return view('updateprice',['prices'=>$prices,'categories'=>$categories]);
    }
    public function amorders()
    {
        $view = Requirement::orderby('project_id','DESC')->leftJoin('users','requirements.generated_by','=','users.id')->select('requirements.*','users.name','users.group_id')->paginate(25);
        return view('ordersadmin',['view' => $view]);
    }
    public function getSubCat(Request $request)
    {
        $cat = $request->cat; 
        $category = Category::where('id',$cat)->first();
        $subcat = SubCategory::where('category_id',$cat)->get();
        $res = array();
        $res[0] = $category;
        $res[1] = $subcat;
        return response()->json($res);
    }
    public function getSubCatPrices(Request $request){
        $cat = $request->cat;
        $category = Category::where('id',$cat)->first();
        $subcat = SubCategory::leftJoin('category_price','category_sub.id','=','category_price.category_sub_id')
            ->select('category_sub.*','category_price.price')
            ->where('category_sub.category_id',$cat)
            ->get();
        $res = array();
        $res[0] = $category;
        $res[1] = $subcat;
        return response()->json($res);   
    }
    public function showProjectDetails(Request $request)
    {
        $id = $request->id;
        $rec = ProjectDetails::where('project_id',$id)->first();
        return view('adminprojectdetails',['rec' => $rec]);
    }
    public function confirmOrder(Request $request)
    {
        $id = $request->id;
        $x = Requirement::where('id', $id)->update(['status' => 'Order Confirmed']);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json($id);
        }
    }
    public function cancelOrder(Request $request)
    {
        $id = $request->id;
        $x = Requirement::where('id', $id)->update(['status' => 'Order Cancelled']);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function getPrice(Request $request)
    {
        $cat = $request->cat;
        $subcat = $request->subcat;
        $price = CategoryPrice::where('category_sub_id',$subcat)->where('category_id',$cat)->first();
        return response()->json($price);
    }
    
    public function updateOwner(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $x = OwnerDetails::where('project_id',$id)->update(['owner_name' => $name, 'owner_contact_no' => $phone, 'owner_email' => $email]);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function updateContractor(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $x = ContractorDetails::where('project_id',$id)->update(['contractor_name' => $name, 'contractor_contact_no' => $phone, 'contractor_email' => $email]);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function updateConsultant(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $x = ConsultantDetails::where('project_id',$id)->update(['consultant_name' => $name, 'consultant_contact_no' => $phone, 'consultant_email' => $email]);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function updateProcurement(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $x = ProcurementDetails::where('project_id',$id)->update(['procurement_name' => $name, 'procurement_contact_no' => $phone, 'procurement_email' => $email]);
        if($x)
        {
            return response()->json('Success !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function updateampay(Request $request)
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
    public function updateamdispatch(Request $request)
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
    public function checkDupPhoneContractor(Request $request)
    {
        $arg = $request->only('arg');
        $check = ContractorDetails::where('contractor_contact_no',$arg)->get();
        $c = count($check);
        return response()->json($c);
    }
    public function checkDupPhoneOwner(Request $request)
    {
        $arg = $request->only('arg');
        $check = OwnerDetails::where('owner_contact_no',$arg)->get();
        $c = count($check);
        return response()->json($c);
    }
    public function checkDupPhoneProcurement(Request $request)
    {
        $arg = $request->only('arg');
        $check = ProcurementDetails::where('procurement_contact_no',$arg)->get();
        $c = count($check);
        return response()->json($c);
    }
    public function checkDupPhoneConsultant(Request $request)
    {
        $arg = $request->only('arg');
        $check = ConsultantDetails::where('consultant_contact_no',$arg)->get();
        $c = count($check);
        return response()->json($c);
    }
    public function checkDupPhoneSite(Request $request)
    {
        $arg = $request->only('arg');
        $check = SiteEngineerDetails::where('site_engineer_contact_no',$arg)->get();
        $c = count($check);
        return response()->json($c);
    }
    public function confirmstatus($id, Request $request)
    {
        $var2 = $request->only('opt');
        $var = ProjectDetails::where('project_id',$var2['opt'])->update(['status' => "Ready"]);
        $c = count($check);
        return response()->json($c);
    }
    public function confirmthis($id, Request $request)
    {
        $var = $request->only('opt');
        $var2 = ProjectDetails::where('project_id',$id)->update(['with_cont' => $var['opt']]);
        return response()->json($var2);
    }
    public function updateNoteFollowUp(Request $request)
    {
        $id = $request->id;
        $value = $request->value;
        $x = ProjectDetails::where('project_id', $id)->update(['note' => $value]);
        if($x){
            return response()->json('Successful !!');
        }
        else{
            return response()->json('Error !!');
        }
    }
    public function updateStatusReq(Request $request)
    {
        $id = $request->id;
        $x =DB::table('requirements')->where('id', $id)->update(['status' => 'Order Initiated']);
        if($x)
        {
            return response()->json('Successful !!!');
        }
        else
        {
            return response()->json('Error !!!');
        }
    }
    public function updatestatus($id, Request $request)
    {
        $view = $request->only('opt');
        $view = $view['opt'];
        ProjectDetails::where('project_id', $id)->update(['project_status' => $view]);
        return response()->json($view);
    }
    public function updateMat($id, Request $request)
    {
        $view = $request->only('opt');
        $view = $view['opt'];
        ProjectDetails::where('project_id', $id)->update(['remarks' => $view]);
        return response()->json($view);
    }
    public function updatelocation($id, Request $request)
    {
        $view = $request->only('newtext');
        $view = $view['newtext'];
        SiteAddress::where('project_id', $id)->update(['address' => $view]);
        return response()->json($view);
    }
    public function projectsUpdate()
    {
        $assignment = salesassignment::where('user_id',Auth::user()->id)->pluck('assigned_date')->first();
        $projectscount = count(ProjectDetails::where('created_at','like',$assignment.'%')->get());
        $projects = ProjectDetails::where('created_at','like',$assignment.'%')->orderBy('created_at', 'desc')->paginate(15);
        return view('salesengineer',['projects'=>$projects,'subwards'=>$assignment,'projectscount'=>$projectscount]);
    }
    public function dailyslots(Request $request)
    {
        if($request->userId){
            $date = date('Y-m-d');
            $projects = ProjectDetails::where('created_at','like',$date[0].'%')->where('listing_engineer_id',$request->userId)->get();
            $le = DB::table('users')->where('department_id','1')->where('group_id','6')->get();
            $projects = DB::table('project_details')
                ->join('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
                ->join('sub_wards', 'project_details.sub_ward_id', '=', 'sub_wards.id')
                ->join('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
                ->join('users','users.id','=','project_details.listing_engineer_id')
                ->join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                ->join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                ->join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                ->where('project_details.created_at','like',$date.'%')->where('listing_engineer_id',$request->userId)
                ->select('project_details.*', 'procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name','sub_wards.sub_ward_name')
                ->get();
            $projcount = count($projects); 
        }else{
            $date = date('Y-m-d');
            $projects = ProjectDetails::where('created_at','like',$date[0].'%')->get();
            $le = DB::table('users')->where('department_id','1')->where('group_id','6')->get();
            $projects = DB::table('project_details')
                ->join('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
                ->join('sub_wards', 'project_details.sub_ward_id', '=', 'sub_wards.id')
                ->join('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
                ->join('users','users.id','=','project_details.listing_engineer_id')
                ->join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                ->join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                ->join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                ->where('project_details.created_at','like',$date.'%')
                ->select('project_details.*', 'procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name','sub_wards.sub_ward_name')
                ->get();
            $projcount = count($projects);  
        }
        return view('dailyslots', ['date' => $date, 'projcount' => $projcount, 'projects' => $projects, 'le' => $le]);
    }
    public function getleinfo(Request $request)
    {
        $records = array();
        $id = $request->id;
        $from = $request->from;
        $to = $request->to;
        if($id !== 'ALL')
        {
        $records[0] =  DB::table('project_details')
                ->join('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
                ->join('sub_wards', 'project_details.sub_ward_id', '=', 'sub_wards.id')
                ->join('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
                ->join('users','users.id','=','project_details.listing_engineer_id')
                ->join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                ->join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                ->join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                ->where('project_details.created_at','>',$from)
                ->where('project_details.created_at','<',$to)
                ->where('users.id',$id)
                ->select('project_details.*', 'procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name','users.id','sub_wards.sub_ward_name')
                ->get();
        $records[1] = count($records[0]);
        }
        else
        {
            $records[0] =  DB::table('project_details')
                ->join('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
                ->join('sub_wards', 'project_details.sub_ward_id', '=', 'sub_wards.id')
                ->join('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
                ->join('users','users.id','=','project_details.listing_engineer_id')
                ->join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                ->join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                ->join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                ->where('project_details.created_at','>',$from)
                ->where('project_details.created_at','<',$to)
                ->select('project_details.*', 'procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name','users.id','sub_wards.sub_ward_name')
                ->get();
        $records[1] = count($records[0]);
        }
        return response()->json($records);
    }
    public function gettodayleinfo(Request $request)
    {
        $records = array();
        $id = $request->id;
        $from = $request->from_date;
        if($id !== 'ALL')
        {
        $records[0] =  DB::table('project_details')
                ->join('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
                ->join('sub_wards', 'project_details.sub_ward_id', '=', 'sub_wards.id')
                ->join('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
                ->join('users','users.id','=','project_details.listing_engineer_id')
                ->join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                ->join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                ->join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                ->where('project_details.created_at','like',$from.'%')
                ->where('users.id',$id)
                ->select('project_details.*', 'procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name','users.id','sub_wards.sub_ward_name')
                ->get();
        $records[1] = count($records[0]);
        }
        else
        {
            $records[0] =  DB::table('project_details')
                ->join('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
                ->join('sub_wards', 'project_details.sub_ward_id', '=', 'sub_wards.id')
                ->join('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
                ->join('users','users.id','=','project_details.listing_engineer_id')
                ->join('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
                ->join('contractor_details','contractor_details.project_id','=','project_details.project_id')
                ->join('consultant_details','consultant_details.project_id','=','project_details.project_id')
                ->where('project_details.created_at','like',$from.'%')
                ->select('project_details.*', 'procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name','users.id','sub_wards.sub_ward_name')
                ->get();
        $records[1] = count($records[0]);
        }
        return response()->json($records);
    }
    public function regReq()
    {
        $requests = User::where('department_id', 100)->where('confirmation',0)->orderBy('created_at','DESC')->get();
        $reqcount = count($requests);
        return view('regreq',['requests'=>$requests,'reqcount'=>$reqcount]);
    }
    public function getHRPage(){
        $departments = Department::all();
        $groups = Group::all();
        $depts = array();
        
        foreach($departments as $department){
            $depts[$department->dept_name] = User::where('department_id',$department->id)->count();
        }
        $depts["FormerEmployees"] = User::where('department_id',10)->count();
        return view('humanresource',['departments'=>$departments,'groups'=>$groups,'page'=>"hr",'depts'=>$depts]);
    }
    public function getHRDept($dept, Request $request){
        if($dept == "Formeremployee"){
            $users = User::where('department_id',10)
                        ->leftjoin('employee_details','users.employeeId','=','employee_details.employee_id')
                        ->select('users.*','employee_details.office_phone')
                        ->get();
        }else{
            $deptId = Department::where('dept_name',$dept)->pluck('id')->first();
            $users = User::where('department_id',$deptId)
                        ->leftjoin('employee_details','users.employeeId','=','employee_details.employee_id')
                        ->select('users.*','employee_details.office_phone')
                        ->get();
        }
        return view('hremp',['users'=>$users,'dept'=>$dept, 'page'=>$request->page]);
    }
    public function getFinance()
    {
        $departments = Department::all();
        return view('finance',['departments'=>$departments]);
    }
    public function getEmpDetails($dept, Request $request)
    {
        $deptId = Department::where('dept_name',$dept)->pluck('id')->first();
        $users = User::where('department_id',$deptId)->get();
        if($dept == 'Operation'){
            if($request->from){
                return $request->from;
            }
            $start_date = date("Y-m-d", strtotime("-1 week"));
            $end_date = date("Y-m-d");
            // $this->db->where("store_date >= '" . $start_date . "' AND store_date <= '" . $end_date . "'");
            
            $previous_week = strtotime("-1 week +1 day");
    
            $start_week = strtotime("last sunday midnight",$previous_week);
            $end_week = strtotime("next saturday",$start_week);
            
            $start_week = date("Y-m-d",$start_week);
            $end_week = date("Y-m-d",$end_week);
            
            $expenses = loginTime::where('logindate','>=',$start_date)->where('logindate','<',$end_date)->get();
            echo "Last week (".$start_date." to ".$end_date.") expenses.";
        }else{
            $expenses = "Null";
        }
        return view('empdetails',['users'=>$users,'dept'=>$dept,'expenses'=>$expenses]);
    }
    public function getProjectSize(Request $request){
        $wards = Ward::all();
        $projects = ProjectDetails::all();
        $totalProjects = count($projects);
        if($request->ward){
            $planningCount      = 0;
            $planningSize       = 0;
            $foundationCount    = 0;
            $foundationSize     = 0;
            $roofingCount       = 0;
            $roofingSize        = 0;
            $wallsCount         = 0;
            $wallsSize          = 0;
            $completionCount    = 0;
            $completionSize     = 0;
            $fixturesCount      = 0;
            $fixturesSize       = 0;
            $pillarsCount       = 0;
            $pillarsSize        = 0;
            $paintingCount      = 0;
            $paintingSize       = 0;
            $flooringCount      = 0;
            $flooringSize       = 0;
            $plasteringCount    = 0;
            $plasteringSize     = 0;
            $diggingCount       = 0;
            $diggingSize        = 0;
            $enpCount           = 0;
            $enpSize            = 0;
            $carpentryCount     = 0;
            $carpentrySize      = 0;
            
            $subwards = SubWard::where('ward_id',$request->ward)->get();
            $wardname = Ward::where('id',$request->ward)->first();
            if(count($subwards)!=0){
            foreach($subwards as $subward)
            {
                $planning = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Planning")->get();
                foreach($planning as $plan){
                    $planningCount++;
                    $planningSize += $plan->project_size;
                }
                $foundation = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Foundation")->get();
                foreach($foundation as $found){
                    $foundationCount++;
                    $foundationSize += $found->project_size;
                }
                $roofing = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Roofing")->get();
                foreach($roofing as $roof){
                    $roofingCount++;
                    $roofingSize += $roof->project_size;
                }
                $walls = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Walls")->get();
                foreach($walls as $wall){
                    $wallsCount++;
                    $wallsSize += $wall->project_size;
                }
                $completion = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Completion")->get();
                foreach($completion as $complete){
                    $completionCount++;
                    $completionSize += $complete->project_size;
                }
                $fixtures = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Fixtures")->get();
                foreach($fixtures as $fix){
                    $fixturesCount++;
                    $fixturesSize += $fix->project_size;
                }
                $pillars = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Pillars")->get();
                foreach($pillars as $pillar){
                    $pillarsCount++;
                    $pillarsSize += $pillar->project_size;
                }
                $painting = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Paintings")->get();
                foreach($painting as $paint){
                    $paintingCount++;
                    $paintingSize += $paint->project_size;
                }
                $flooring = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Flooring")->get();
                foreach($flooring as $floor){
                    $flooringCount++;
                    $flooringSize += $floor->project_size;
                }
                $plastering = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Plastering")->get();
                foreach($plastering as $plaster){
                    $plasteringCount++;
                    $plasteringSize += $plaster->project_size;
                }
                $digging = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Digging")->get();
                foreach($digging as $dig){
                    $diggingCount++;
                    $diggingSize += $dig->project_size;
                }
                $enp = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Electrical & Plumbing")->get();
                foreach($enp as $electricity){
                    $enpCount++;
                    $enpSize += $electricity->project_size;
                }
                $carpentry = ProjectDetails::where('sub_ward_id',$subward->id)->where('project_status',"Carpentry")->get();
                foreach($carpentry as $carp){
                    $carpentryCount++;
                    $carpentrySize += $carp->project_size;
                }
            }}else{
                return view('projectSize',['wards'=>$wards,'planningCount'=>NULL,'subwards'=>NULL,'wardId'=>NULL,'planning'=>NULL,'subwardId'=>NULL])->with('Error','No subwards found');
            }
            if(!$request->subward){
                return view('projectSize',[
                    'planningCount'=>$planningCount,'planningSize'=>$planningSize,
                    'foundationCount'=>$foundationCount,'foundationSize'=>$foundationSize,
                    'roofingCount'=>$roofingCount,'roofingSize'=>$roofingSize,
                    'wallsCount'=>$wallsCount,'wallsSize'=>$wallsSize,
                    'completionCount'=>$completionCount,'completionSize'=>$completionSize,
                    'fixturesCount'=>$fixturesCount,'fixturesSize'=>$fixturesSize,
                    'pillarsCount'=>$pillarsCount,'pillarsSize'=>$pillarsSize,
                    'paintingCount'=>$paintingCount,'paintingSize'=>$paintingSize,
                    'flooringCount'=>$flooringCount,'flooringSize'=>$flooringSize,
                    'plasteringCount'=>$plasteringCount,'plasteringSize'=>$plasteringSize,
                    'diggingCount'=>$diggingCount,'diggingSize'=>$diggingSize,
                    'enpCount'=>$enpCount,'enpSize'=>$enpSize,
                    'carpentryCount'=>$carpentryCount,'carpentrySize'=>$carpentrySize,
                    'wards'=>$wards,
                    'wardname'=>$wardname, 'subwards'=>$subwards,'wardId'=>$request->ward,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects
                ]);
            }else{
                $planning = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Planning')->get();
                $foundation = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Foundation')->get();
                $roofing = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Roofing')->get();
                $walls = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Walls')->get();
                $completion = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Completion')->get();
                $fixtures = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Fixtures')->get();
                $pillars = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Pillars')->get();
                $painting = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Painting')->get();
                $flooring = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Flooring')->get();
                $plastering = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Plastering')->get();
                $digging = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Digging')->get();
                $enp = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Electrical & Plumbing')->get();
                $carpentry = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Carpentry');
                $subwardname = SubWard::where('id',$request->subward)->pluck('sub_ward_name')->first();
                return view('projectSize',[
                    'planningCount'=>$planningCount,'planningSize'=>$planningSize,
                    'foundationCount'=>$foundationCount,'foundationSize'=>$foundationSize,
                    'roofingCount'=>$roofingCount,'roofingSize'=>$roofingSize,
                    'wallsCount'=>$wallsCount,'wallsSize'=>$wallsSize,
                    'completionCount'=>$completionCount,'completionSize'=>$completionSize,
                    'fixturesCount'=>$fixturesCount,'fixturesSize'=>$fixturesSize,
                    'pillarsCount'=>$pillarsCount,'pillarsSize'=>$pillarsSize,
                    'paintingCount'=>$paintingCount,'paintingSize'=>$paintingSize,
                    'flooringCount'=>$flooringCount,'flooringSize'=>$flooringSize,
                    'plasteringCount'=>$plasteringCount,'plasteringSize'=>$plasteringSize,
                    'diggingCount'=>$diggingCount,'diggingSize'=>$diggingSize,
                    'enpCount'=>$enpCount,'enpSize'=>$enpSize,
                    'carpentryCount'=>$carpentryCount,'carpentrySize'=>$carpentrySize,
                    'wards'=>$wards,
                    'wardname'=>$wardname, 'subwards'=>$subwards,'wardId'=>$request->ward,
                    'planning'=>$planning,
                    'foundation'=>$foundation,
                    'roofing'=>$roofing,
                    'walls'=>$walls,
                    'completion'=>$completion,
                    'fixtures'=>$fixtures,
                    'pillars'=>$pillars,
                    'painting'=>$painting,
                    'flooring'=>$flooring,
                    'plastering'=>$plastering,
                    'digging'=>$digging,
                    'enp'=>$enp,
                    'carpentry'=>$carpentry,
                    'subwardId'=>$request->subward,
                    'subwardName'=>$subwardname,
                    'totalProjects' => $totalProjects
                ]);
            }
        }else{
            return view('projectSize',['wards'=>$wards,'planningCount'=>NULL,'subwards'=>NULL,'wardId'=>NULL,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects]);
        }
    }
    public function getLEDetails($userid){
        $projectDetails = ProjectDetails::where('listing_engineer_id',$userid)->get();
        return view('ledetails',['projectDetails'=>$projectDetails]);
    }
    public function changePassword(){
        return view('changepassword');
    }
    public function hrAttendance($id, Request $request){
        if($request->month != null){
            $today = $request->year."-".$request->month;
        }else{
            $today = date('Y-m');
        }
        $user = User::where('employeeId',$id)->first();
        $attendances = attendance::where('empId',$id)
                    ->where('created_at','LIKE',$today.'%')
                    ->get();
        return view('empattendance',['attendances'=>$attendances,'userid'=>$id,'user'=>$user]);
    }
    public function forgotPw(){
        return view('forgotpassword');
    }
    public function updateSalesAssignment(){
        salesassignment::where('user_id',Auth::user()->id)->delete();
        return redirect('/home');
    }
    public function viewDailyReport($uId, $date){
        $reports = Report::where('empId',$uId)->where('created_at','like',$date.'%')->get();
        $user = User::where('employeeId',$uId)->first();
        $attendance = attendance::where('empId',$uId)->where('date',$date)->first();
        return view('viewdailyreport',['reports'=>$reports,'date'=>$date,'user'=>$user,'attendance'=>$attendance]);
    }
    public function followup(){
        $projects = ProjectDetails::where('followup',"Yes")
            ->where('follow_up_by',Auth::user()->id)
            ->paginate(10);
        return view('followup',['projects'=>$projects]);
    }
    public function confirmedProject(Request $request){
        $check = projectDetails::where('project_id',$request->id)->first();
        if($check->confirmed == Null || $check->confirmed == "False"){
            projectDetails::where('project_id',$request->id)->update([
                'confirmed' => "True"
            ]);
        }else{
            projectDetails::where('project_id',$request->id)->update([
                'confirmed' => "False"
            ]);
        }
        return back();
    }
    public function projectadmin(Request $id){
        $details = projectDetails::where('project_id',$id->projectId)->first();
        return view('viewDailyProjects',['details'=>$details]);
    }
    public function editEmployee(Request $request){
        $user = User::where('employeeId', $request->UserId)->first();
        $employeeDetails = EmployeeDetails::where('employee_id',$request->UserId)->first();
        $bankDetails = BankDetails::where('employeeId',$request->UserId)->first();
        $assets = Asset::all();
        $assetInfos = AssetInfo::where('employeeId',$request->UserId)->get();
        return view('editEmployee',['user'=>$user,'employeeDetails'=>$employeeDetails,'bankDetails'=>$bankDetails,'assets'=>$assets,'assetInfos'=>$assetInfos]);
    }
    public function acceptConfidentiality(Request $request){
        User::where('id',$request->UserId)->update(['confirmation'=>1]);
        return redirect('/home');
    }
    public function manufacturerDetails(){
        $mfdetails = ManufacturerDetail::all();
        $category = ManufacturerDetail::groupBy('category')->pluck('category');
        return view('manufacturerdetails',['mfdetails'=>$mfdetails,'category'=>$category]);
    }
    public function getKRA(){
        $kras = DB::table('key_results')
            ->join('departments', 'key_results.department_id', '=', 'departments.id')
            ->join('groups', 'key_results.group_id', '=', 'groups.id')
            ->select('key_results.*', 'departments.dept_name', 'groups.group_name')
            ->where('key_results.group_id','=',Auth::user()->group_id)
            ->where('key_results.department_id','=',Auth::user()->department_id)
            ->get();
        return view('kra',['kras'=>$kras]);
    }
    public function getMyProfile(){
        return view('myProfile');
    }
    public function postMyProfile(Request $request){
        $imageName1 = Auth::user()->name.time().'.'.request()->pp->getClientOriginalExtension();
        $request->pp->move(public_path('profilePic'),$imageName1);
        User::where('id',Auth::user()->id)->update(['profilepic'=>$imageName1]);
        return redirect('/home')->with('Success','Profile picture added successfully');
    }
    public function getMhOrders(){
        $invoices = MhInvoice::leftJoin('requirements','mh_invoice.requirement_id','=','requirements.id')->get();
        return view('mhOrders',['invoices'=>$invoices]);
    }
    public function getAnR(){
        $departments = Department::all();
        $groups = Group::all();
        return view('anr',['departments'=>$departments,'groups'=>$groups,'page'=>"anr"]);
    }
//	public function getSalesStatistics(){
//		$initiate = Requirement::where('status',"Order Initiated")->count();
//		$confirmed = Requirement::where('status',"Order Confirmed")->count();
//		$placed = Requirement::where('status',"Order Placed")->count();
//		$cancelled = Requirement::where('status',"Order cancelled")->count();
//		return view('salesstats',[
//			'initiate'=>$initiate,
//			'confirmed'=>$confirmed,
//			'placed'=>$placed,
//			'cancelled'=>$cancelled
//		]);
//	}
//	public function postapprove(Request $request)
//	{
//		User::where('id',$request->id)->update(['confirmation'=>2]);
//		return back();
//	}
    public function getSalesStatistics(){
        $notProcessed = Requirement::where('status',"Not Processed")->count();
        $initiate = Requirement::where('status',"Order Initiated")->count();
        $confirmed = Requirement::where('status',"Order Confirmed")->count();
        $placed = Requirement::where('status',"Order Placed")->count();
        $cancelled = Requirement::where('status',"Order cancelled")->count();
        $genuine = ProjectDetails::where('quality',"GENUINE")->count();
        $fake = ProjectDetails::where('quality',"FAKE")->count();
        $notConfirmed = ProjectDetails::where('quality',null)->count();
        return view('salesstats',[
            'initiate'=>$initiate,
            'confirmed'=>$confirmed,
            'placed'=>$placed,
            'cancelled'=>$cancelled,
            'genuine'=>$genuine,'fake'=>$fake,'notConfirmed'=>$notConfirmed,
            'notProcessed'=>$notProcessed
            ]);
    }
    public function postapprove(Request $request)
    {
        User::where('id',$request->id)->update(['confirmation'=>2]);
        return back();
    }
    public function wardsForLe(Request $request)
    {
        $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $ward = SubWard::where('id',$assignment)->pluck('ward_id')->first();
        $subward = Subward::where('ward_id',$ward)->pluck('id');
        if($request->next){
            $projects = ProjectDetails::where('sub_ward_id',$subward[$request->next])->orderBy('created_at', 'desc')->get();
        	$projectscount = ProjectDetails::where('sub_ward_id',$subward[$request->next])->count();
	}else{
            $projects = ProjectDetails::where('sub_ward_id',$subward[0])->orderBy('created_at', 'desc')->get();
        	$projectscount = ProjectDetails::where('sub_ward_id',$subward[0])->count();
	}
        $count = count($subward);
        if($request->next){
            $projects = ProjectDetails::where('sub_ward_id',$subward[$request->next])->orderBy('created_at', 'desc')->get();
            $projectscount = ProjectDetails::where('sub_ward_id',$subward[$request->next])->count();
        }else{
            $projects = ProjectDetails::where('sub_ward_id',$subward[0])->orderBy('created_at', 'desc')->get();
            $projectscount = ProjectDetails::where('sub_ward_id',$subward[0])->count();
        }
        return view('salesengineer',['projects'=>$projects,'subwards'=>$assignment,'projectscount'=>$projectscount,'links'=>$subward]);
    }
    public function activityLog()
    {
        $activities = ActivityLog::orderby('time','DESC')->paginate(50);
        return view('activitylog',['activities'=>$activities]);
    }
    public function eqpipeline()
    {
        $pipelines = Requirement::where('status','Not Processed')->get();
        return view('eqpipeline',['pipelines'=>$pipelines]);
    }
}