<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\orderconfirmation;
use App\Mail\invoice;
use App\Department;
use App\User;
use App\Group;
use App\Ward;
use App\Tlwards;
use App\Country;
use App\SubWard;
use App\WardAssignment;
use App\ProjectDetails;
use App\SiteAddress;
use App\Territory;
use App\State;
use App\Zone;
use App\Checklist;
use App\training;
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
use App\RoomType;
use App\WardMap;
use Auth;
use DB;
use App\EmployeeDetails;
use Validator;
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
use App\Order;
use App\Stages;
use App\Dates;
use App\Map;
use App\brand;
use App\Point;
use App\Message;
use App\ZoneMap;
use App\SubWardMap;
use App\UserLocation;
use App\AssignStage;
use App\History;
use App\Assignenquiry;
use App\ProjectImage;
use App\EnquiryQuantity;
use App\AssignNumber;
use App\MamaSms;
use Carbon\Carbon;
use App\numbercount;
use App\numbers;
use App\Payment;
use App\Detail;
use App\Projection;
use App\Conversion;
use App\Utilization;
use App\Planning;
use App\CapitalExpenditure;
use App\OperationalExpenditure;
use App\NumberOfZones;
use App\Pricing;

date_default_timezone_set("Asia/Kolkata");
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
        return redirect('/login');
    }
    public function inputview(Request $request)
    {
        $category = Category::all();
        $brand = brand::leftjoin('category','category.id','=','brands.category_id')
                ->select('brand')->get();

        $depart1 = [6];
        $depart2 = [7];
        $depart = [2,4,8,6,7,15,17,16,1,11];
        $projects = ProjectDetails::where('project_id', $request->projectId)->first();
        $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
       $users1 = User::whereIn('group_id',$depart1)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
       $users2 = User::whereIn('group_id',$depart2)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
        return view('inputview',['category'=>$category,'users'=>$users,'users1'=>$users1,'users2'=>$users2,'projects'=>$projects,'brand'=>$brand]);
    }
    
    public function inputdata(Request $request)
    {

           $user_id = User::where('id',Auth::user()->id)->pluck('id')->first();
           $cat = category::where('id',$request->cat)->pluck('id')->first();
          
         if($request->name){

              $shipadress = $request->billadress;     
         }   
           $shipadress = $request->billadress;   

   // for fetching sub categories
        $get = implode(", ",array_filter($request->quan));
        $another = explode(", ",$get);
        $quantity = array_filter($request->quan);
        $qu = implode(", ", $quantity);     
            

       
        for($i = 0;$i < count($request->subcat); $i++){
            if($i == 0){
                $sub = SubCategory::where('id',$request->subcat[$i])->pluck('sub_cat_name')->first();
                $qnty = $sub.":".$another[$i];
            }else{
                $sub = SubCategory::where('id',$request->subcat[$i])->pluck('sub_cat_name')->first();
                $qnty .= ", ".$another[$i];
              
            }
        }
        $validator = Validator::make($request->all(), [
            'subcat' => 'required'
            ]);
            if ($validator->fails()) {
                return back()
                ->with('NotAdded','Select Category Before Submit')
                ->withErrors($validator)
                ->withInput();
            }
            $sub_cat_name = SubCategory::whereIn('id',$request->subcat)->pluck('sub_cat_name')->toArray();
            $subcategories = implode(", ", $sub_cat_name);
            // fetching brands
            $brand_ids = SubCategory::whereIn('id',$request->subcat)->pluck('brand_id')->toArray();
            $brand = brand::whereIn('id',$brand_ids)->pluck('brand')->toArray();
            $brandnames = implode(", ", $brand);
            
            $category_ids = SubCategory::whereIn('id',$request->subcat)->pluck('category_id')->toArray();
            $category= Category::whereIn('id',$category_ids)->pluck('category_name')->toArray();
            $categoryNames = implode(", ", $category);
            
            $points = new Point;
            $points->user_id = $request->initiator;
            $points->point = 100;
            $points->type = "Add";
            $points->reason = "Generating an enquiry";
            $points->save();
            $var = count($request->subcat);
            $var1 = count($brand);
            
            
            // $qnty = implode(", ", $request->quan);
            
        $var2 = count($category);
        $storesubcat =$request->subcat[0];
        $x = DB::table('requirements')
            ->insert(['project_id'    =>$request->selectprojects,
                'main_category' => $categoryNames,
                'brand' => $brandnames,
                'sub_category'  =>$subcategories,
                'follow_up' =>'',
                'follow_up_by' =>'',
                'material_spec' =>'',
                'referral_image1'   =>'',
                'referral_image2'   =>'',
                'requirement_date'  =>$request->edate,
                'measurement_unit'  =>$request->measure != null?$request->measure:'',
                'unit_price'   => '',
                    'quantity'     =>$qnty,
                
                'total'   =>0,
                'notes'  =>$request->eremarks,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => "Enquiry On Process",
                'dispatch_status' => "Not yet dispatched",
                'generated_by' => $request->initiator
            ]);
        $x = DB::table('requirements')->insert(['project_id'    =>$request->selectprojects,
                                                'main_category' => $categoryNames,
                                                'brand' => $brandnames,
                                                'sub_category'  =>$subcategories,
                                                'follow_up' =>'',
                                                'follow_up_by' =>'',
                                                'material_spec' =>'',
                                                'referral_image1'   =>'',
                                                'referral_image2'   =>'',
                                                'requirement_date'  =>$request->edate,
                                                'measurement_unit'  =>$request->measure != null?$request->measure:'',
                                                'unit_price'   => '',
                                                 'quantity'     =>$qnty,
                                                
                                                'total'   =>0,
                                                'notes'  =>$request->eremarks,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s'),
                                                'status' => "Enquiry On Process",
                                                'dispatch_status' => "Not yet dispatched",
                                                'generated_by' => $request->initiator,
                                                'billadress'=>$request->billadress,
                                                'ship' =>$shipadress
                                        ]);
        // $y = DB::table('quantity')->insert(['req_id' =>$request->requirements->id,
        //                                     'project_id'=>$request->selectprojects
                                           

        //         ]);
        if($x)
        {
            return back()->with('success','Enquiry Raised Successfully !!!');
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
    public function enquirysheet1(Request $request)
    {
                         // dd( $enquiries); 

        $totalofenquiry = "";
        $totalenq = "";
        $wards = SubWard::orderby('sub_ward_name','ASC')->get();
        $category = Category::all();  
        $depart = [1,6,7,8,11,15,16,17];
        $initiators = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $subwards2 = array();

        if($request->status && !$request->category){
            if($request->status != "all"){
                
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->where('status','like','%'.$request->status)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();

                       $enquiries = Response::Json( $enquiries);

                $converter = user::get();

                
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                             $enquiries = Response::Json( $enquiries);
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->status && $request->category){
            if($request->status != "all"){
                
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->where('status','like','%'.$request->status)
                            ->where('requirements.main_category',$request->category)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->where('requirements.main_category',$request->category)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to  && !$request->initiator && !$request->category && !$request->ward){
            // only from and to

            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
            $converter = user::get();
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
            $converter = user::get();
            }
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }

        }elseif(!$request->from && !$request->to && !$request->initiator && !$request->category && $request->ward){
            // only ward
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$request->ward)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            $converter = user::get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif(!$request->from && !$request->to && !$request->initiator && $request->category && !$request->ward){
            // only category
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('requirements.main_category',$request->category)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();

                 
          $converter = user::get();

            $totalofenquiry = Requirement::where('main_category',$request->category)->where('requirements.status','!=',"Enquiry Cancelled")->sum('quantity');
            

            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif(!$request->from && !$request->to && $request->initiator && !$request->category && !$request->ward){
            // only initiator
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('requirements.generated_by',$request->initiator)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            $converter = user::get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif($request->from && $request->to && $request->initiator && $request->category && $request->ward){
            // everything
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('project_details.sub_ward_id','=',$request->ward)
                ->where('requirements.generated_by',$request->initiator)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->where('requirements.main_category','LIKE',"%".$request->category."%")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
            $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.generated_by',$request->initiator)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->where('requirements.main_category','LIKE',"%".$request->category."%")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && !$request->initiator && !$request->category && $request->ward){
            // from, to and ward
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('project_details.sub_ward_id','=',$request->ward)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('project_details.sub_ward_id','=',$request->ward)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && $request->initiator && !$request->category && !$request->ward){
            // from, to and initiator
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.generated_by','=',$request->initiator)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
               $converter = user::get(); 
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.generated_by','=',$request->initiator)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
               $converter = user::get(); 
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && !$request->initiator && $request->category && !$request->ward){
            // from, to and category
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.main_category','=',$request->category)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.main_category','=',$request->category)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && $request->initiator && $request->category && !$request->ward){
            // from, to, initiator and category
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.main_category','=',$request->category)
                ->where('requirements.generated_by','=',$request->initiator)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.main_category','=',$request->category)
                ->where('requirements.generated_by','=',$request->initiator)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && !$request->initiator && $request->category && $request->ward){
            // from, to, wards and category
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.main_category','=',$request->category)
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                        $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.main_category','=',$request->category)
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && $request->initiator && !$request->category && $request->ward){
            // from, to, wards and initiator
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.generated_by','=',$request->initiator)
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.generated_by','=',$request->initiator)
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif(!$request->from && !$request->to && $request->initiator && $request->category && !$request->ward){
            //initiator and category
            $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('requirements.main_category','=',$request->category)
                        ->where('requirements.generated_by','=',$request->initiator)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            $converter = user::get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }else{
            // no selection
             $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->get();
            $converter = user::get();
            $totalenq = count($enquiries);
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }
      
        $filtered = new Collection;
        $projectOrdersReceived = Order::whereIn('status',["Order Confirmed","Order Cancelled"])->pluck('project_id')->toArray();
        return view('enquirysheet',[
            'totalenq' =>$totalenq,
            'converter' =>$converter,
            'totalofenquiry'=>$totalofenquiry,
            'subwards2'=>$subwards2,
            'enquiries'=>$enquiries,
            'wards'=>$wards,
            'category'=>$category,
            'initiators'=>$initiators,
            'projectOrdersReceived'=>$projectOrdersReceived
        ]);
    }
    


 public function enquirysheet(Request $request)
    {
     if(Auth::user()->group_id != 22){
       return  $this->enquirysheet1($request);
     }                    // dd( $enquiries); 
        $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
        $totalofenquiry = "";
        $totalenq = "";
        $wards = SubWard::orderby('sub_ward_name','ASC')->where('ward_id',$tlward)->get();

        $category = Category::all();  
        $depart = [1,6,7,8,11,15,16,17];
        $initiators = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $subwards2 = array();

        if($request->status && !$request->category){
            if($request->status != "all"){
               $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                            ->leftjoin('wards','wards.id','sub_wards.ward_id')
                            ->where('wards.id',$tlward)
                            ->where('status','like','%'.$request->status)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();

                       $enquiries = Response::Json( $enquiries);

                $converter = user::get();

                
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                            ->leftjoin('wards','wards.id','sub_wards.ward_id')
                            ->where('wards.id',$tlward)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                             $enquiries = Response::Json( $enquiries);
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->status && $request->category){

            if($request->status != "all"){
                
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->where('status','like','%'.$request->status)
                            ->where('requirements.main_category',$request->category)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->where('requirements.main_category',$request->category)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to  && !$request->initiator && !$request->category && !$request->ward){
            // only from and to
            $from = $request->from;
            $to = $request->to;
                

            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
            $converter = user::get();
            }
            else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
            $converter = user::get();
            }
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }

        }elseif(!$request->from && !$request->to && !$request->initiator && !$request->category && $request->ward){
            // only ward
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                         ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                        ->where('project_details.sub_ward_id',$request->ward)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            $converter = user::get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif(!$request->from && !$request->to && !$request->initiator && $request->category && !$request->ward){
            // only category
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                         ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                        ->where('requirements.main_category',$request->category)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();

                 
          $converter = user::get();

            $totalofenquiry = Requirement::where('main_category',$request->category)->where('requirements.status','!=',"Enquiry Cancelled")->sum('quantity');
            

            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif(!$request->from && !$request->to && $request->initiator && !$request->category && !$request->ward){
            // only initiator
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                         ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                        ->where('requirements.generated_by',$request->initiator)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            $converter = user::get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif($request->from && $request->to && $request->initiator && $request->category && $request->ward){
            // everything
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('project_details.sub_ward_id','=',$request->ward)
                ->where('requirements.generated_by',$request->initiator)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->where('requirements.main_category','LIKE',"%".$request->category."%")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
            $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->orderBy('requirements.created_at','DESC')
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.generated_by',$request->initiator)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->where('requirements.main_category','LIKE',"%".$request->category."%")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && !$request->initiator && !$request->category && $request->ward){
            // from, to and ward
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('project_details.sub_ward_id','=',$request->ward)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('project_details.sub_ward_id','=',$request->ward)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && $request->initiator && !$request->category && !$request->ward){
            // from, to and initiator
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.generated_by','=',$request->initiator)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
               $converter = user::get(); 
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.generated_by','=',$request->initiator)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
               $converter = user::get(); 
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && !$request->initiator && $request->category && !$request->ward){
            // from, to and category
            $from = $request->from;
            $to = $request->to;
            if($from == $to){

                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                 ->leftjoin('wards','wards.id','sub_wards.ward_id')
                 ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.main_category','=',$request->category)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.main_category','=',$request->category)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && $request->initiator && $request->category && !$request->ward){
            // from, to, initiator and category
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.main_category','=',$request->category)
                ->where('requirements.generated_by','=',$request->initiator)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                 ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                ->orderBy('requirements.created_at','DESC')
                ->where('requirements.main_category','=',$request->category)
                ->where('requirements.generated_by','=',$request->initiator)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && !$request->initiator && $request->category && $request->ward){
            // from, to, wards and category
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.main_category','=',$request->category)
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                        $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.main_category','=',$request->category)
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif($request->from && $request->to && $request->initiator && !$request->category && $request->ward){
            // from, to, wards and initiator
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.generated_by','=',$request->initiator)
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                             ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.generated_by','=',$request->initiator)
                            ->where('project_details.sub_ward_id','=',$request->ward)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
                $converter = user::get();
                foreach($enquiries as $enquiry){
                    $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
                }
            }
        }elseif(!$request->from && !$request->to && $request->initiator && $request->category && !$request->ward){
            //initiator and category
            $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                         
                        ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                        ->leftjoin('wards','wards.id','sub_wards.ward_id')
                        ->where('wards.id',$tlward)
                        ->where('requirements.main_category','=',$request->category)
                        ->where('requirements.generated_by','=',$request->initiator)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            $converter = user::get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }else{
            // no selection
             $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                            ->leftjoin('wards','wards.id','sub_wards.ward_id')
                            ->where('wards.id',$tlward)
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->get();



            $converter = user::get();
            $totalenq = count($enquiries);
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }
      
        $filtered = new Collection;
        $projectOrdersReceived = Order::whereIn('status',["Order Confirmed","Order Cancelled"])->pluck('project_id')->toArray();
        return view('enquirysheet',[
            'totalenq' =>$totalenq,
            'converter' =>$converter,
            'totalofenquiry'=>$totalofenquiry,
            'subwards2'=>$subwards2,
            'enquiries'=>$enquiries,
            'wards'=>$wards,
            'category'=>$category,
            'initiators'=>$initiators,
            'projectOrdersReceived'=>$projectOrdersReceived
        ]);
    }

 public function enquiryCancell(Request $request)
    {
        if(Auth::user()->group_id == 22)
       {
        return $this->enquiryCancell1($request);
       } 
        $cancelcount = 0;
        $wards = SubWard::orderby('sub_ward_name','ASC')->get();
        $category = Category::all();
        $depart = [6,7];
        $initiators = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $subwards2 = array();
        $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->where('requirements.status',"Enquiry Cancelled")
                        ->get();
        $cancelcount = count( $enquiries);
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        return view('enquiryCancell',[
            'cancelcount' =>$cancelcount,
            'subwards2'=>$subwards2,
            'enquiries'=>$enquiries,
            'wards'=>$wards,
            'category'=>$category,
            'initiators'=>$initiators
        ]);
    }

 public function enquiryCancell1(Request $request)
    {
       
       

        $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
        $cancelcount = 0;
        $wards = SubWard::orderby('sub_ward_name','ASC')->get();
        $category = Category::all();
        $depart = [6,7];
        $initiators = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $subwards2 = array();
        $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                            ->leftjoin('wards','wards.id','sub_wards.ward_id')
                            ->where('wards.id',$tlward)
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->where('requirements.status',"Enquiry Cancelled")
                        ->get();

        $cancelcount = count( $enquiries);
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        
        return view('enquiryCancell',[
            'cancelcount' =>$cancelcount,
            'subwards2'=>$subwards2,
            'enquiries'=>$enquiries,
            'wards'=>$wards,
            'category'=>$category,
            'initiators'=>$initiators
        ]);
    }
    public function myenquirysheet()
    {
        $wards = SubWard::orderby('sub_ward_name','ASC')->get();
        $category = Category::all();
        $depart = [6,7];
        $initiators = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $subwards2 = array();
        $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                    ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                    ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                    ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                    ->where('requirements.generated_by',Auth::user()->id)
                    ->get();
        foreach($enquiries as $enquiry){
            $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
        }
        return view('enquirysheet',[
            'subwards2'=>$subwards2,
            'enquiries'=>$enquiries,
            'wards'=>$wards,
            'category'=>$category,
            'initiators'=>$initiators
        ]);
    }
    public function editEnq(Request $request)
    {
       
        $category = Category::all();
        $depart = [2,4,6,7,8,17];
        $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $enq = Requirement::where('requirements.id',$request->reqId)
                    ->leftjoin('users','users.id','=','requirements.generated_by')
                    ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                    ->leftjoin('procurement_details','requirements.project_id','=','procurement_details.procurement_contact_no')
                    ->leftjoin('contractor_details','requirements.project_id','contractor_details.project_id')
                    ->leftjoin('owner_details','requirements.project_id','owner_details.project_id')
                    ->leftjoin('site_engineer_details','requirements.project_id','site_engineer_details.project_id')
                    ->leftjoin('consultant_details','requirements.project_id','consultant_details.project_id')
                    ->leftjoin('site_addresses','requirements.project_id','=','site_addresses.project_id')
                    ->select('requirements.*','users.name','project_details.project_name','procurement_details.procurement_contact_no','site_addresses.address','contractor_details.contractor_contact_no','owner_details.owner_contact_no','site_engineer_details.site_engineer_contact_no','consultant_details.consultant_contact_no','requirements.id')
                    ->first();
                   
        return view('editEnq',['enq'=>$enq,'category'=>$category,'users'=>$users]);
    }
    public function editEnq1(Request $request)
    {


        $category = Category::all();
        $depart = [7];
       $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
        $depart1 = [6];
       $users1 = User::whereIn('group_id',$depart1)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
        $depart2 = [2,4,6,7,8,17,11];
        $users2 = User::whereIn('group_id',$depart2)->where('department_id','!=',10)->get();
      
        $enq = Requirement::where('requirements.id',$request->reqId)
                    ->leftjoin('users','users.id','=','requirements.generated_by')
                    ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                    ->leftjoin('procurement_details','requirements.project_id','=','procurement_details.procurement_contact_no')
                    ->leftjoin('contractor_details','requirements.project_id','contractor_details.project_id')
                    ->leftjoin('owner_details','requirements.project_id','owner_details.project_id')
                    ->leftjoin('site_engineer_details','requirements.project_id','site_engineer_details.project_id')
                    ->leftjoin('consultant_details','requirements.project_id','consultant_details.project_id')
                    ->leftjoin('site_addresses','requirements.project_id','=','site_addresses.project_id')
                    ->select('requirements.*','users.name','project_details.project_name','procurement_details.procurement_contact_no','site_addresses.address','contractor_details.contractor_contact_no','owner_details.owner_contact_no','site_engineer_details.site_engineer_contact_no','consultant_details.consultant_contact_no')
                    ->first();
                  
        return view('editEnq1',['enq'=>$enq,'category'=>$category,'users'=>$users,'users1'=>$users1,'users2'=>$users2]);
    }
    public function eqpipelineedit(Request $request)
    {
        $category = Category::all();
        $depart = [2,4,6,7,8,17];
        $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $enq = Requirement::where('requirements.id',$request->reqId)
                    ->leftjoin('users','users.id','=','requirements.generated_by')
                    ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                    ->leftjoin('procurement_details','requirements.project_id','=','procurement_details.procurement_contact_no')
                    ->leftjoin('contractor_details','requirements.project_id','contractor_details.project_id')
                    ->leftjoin('owner_details','requirements.project_id','owner_details.project_id')
                    ->leftjoin('site_engineer_details','requirements.project_id','site_engineer_details.project_id')
                    ->leftjoin('consultant_details','requirements.project_id','consultant_details.project_id')
                    ->leftjoin('site_addresses','requirements.project_id','=','site_addresses.project_id')
                    ->select('requirements.*','users.name','project_details.project_name','procurement_details.procurement_contact_no','site_addresses.address','contractor_details.contractor_contact_no','owner_details.owner_contact_no','site_engineer_details.site_engineer_contact_no','consultant_details.consultant_contact_no')
                    ->first();
        return view('editEnq',['enq'=>$enq,'category'=>$category,'users'=>$users]);
    }
   


    // public function index1(Request $request )
    // {
        
       
        
    //     $check =DB::table('stages')->where('list',Auth::user()->name)
    //                 ->orderby('created_at','DESC')->pluck('status');

    //     $count = count($check);
    //     $ss = ProjectDetails::pluck('project_status');
       
    //      $cc = explode("," , $ss);
         
    //     $projects = ProjectDetails::where($cc ,'LIKE' ,$check)->get();
             
    //      dd($projects);
            
    //     $totalListing = ProjectDetails::where('project_status',$check)->count();
            
    //     return view('status_wise_projects', ['projects' => $projects, 'totalListing'=>$totalListing,'status'=>$check ,'stages'=>$stages]);
    //    }
       



       public function datewise(Request $request )
       {
            $assigndate =AssignStage::where('user_id',Auth::user()->id)
                           ->orderby('created_at','DESC')->pluck('assigndate')->first();
            $check =DB::table('assignstage','user_id',Auth::user()->id)->pluck('stage');  
            $projects =ProjectDetails::where('project_details.created_at','like',$assigndate."%")
                ->whereOr('project_details.project_status','asssign_satge')
                ->leftjoin('users','users.id','=','project_details.listing_engineer_id')
                 ->whereOr('stage' , $check)
               ->leftjoin('assignstage', 'project_details.sub_ward_id',  'assignstage.sub_id')
               ->select('project_details.*')
               ->paginate(15);
                  
            $totalListing = ProjectDetails::where('created_at','LIKE',$assigndate."%")->count();
           
           return view('date_wise_project',['projects' => $projects,'assigndate'=>$assigndate,'totalListing'=>$totalListing ]);
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
        $loggedInUsers = attendance::where('date',date('Y-m-d'))
                        ->join('users','empattendance.empId','users.employeeId')
                        ->select('users.name','empattendance.*')
                        ->get();
        $leLogins = loginTime::where('logindate',date('Y-m-d'))
                        ->join('users','login_times.user_id','users.id')
                        ->select('users.name','users.employeeId','login_times.*')
                        ->get();
        if($group == "Team Lead" && $dept == "Operation"){
            return redirect('teamLead');
        }else if($group == "Team Leader" && $dept == "Operation"){
            return redirect('teamLead');
        }
        else if($group == "Listing Engineer" && $dept == "Operation"){
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
            return view('home',['departments'=>$departments,'users'=>$users,'groups'=>$groups,'loggedInUsers'=>$loggedInUsers,'leLogins'=>$leLogins]);
        }else if($group == "Sales Converter" && $dept == "Sales"){
            return redirect('scdashboard');
        }else if($group == "Marketing Exective" && $dept == "Marketing"){
            return redirect('marketingdashboard');
        }else if(Auth::user()->department_id == 10){
            Auth()->logout();
            return view('errors.403error');
        }else if($group = "Auditor"){
            return redirect('auditor');
        }else{
            return redirect('chat');
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
        $notConfirmed = ProjectDetails::where('quality',"Unverified")->count();
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
        $records[4] = date('d-m-Y',strtotime($date2));
        $records[3] = date('d-m-Y',strtotime($date1));
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
         $depts=[1,2];
         $loggedInUsers = attendance::where('date',date('Y-m-d'))
                        ->join('users','empattendance.empId','users.employeeId')
                        ->whereIn('department_id',$depts)
                        ->leftjoin('departments','users.department_id','departments.id')
                        ->select('users.name','empattendance.*','departments.id')
                        ->get();
                        $depts=[1,2];
                        $users = User::where('department_id',$depts)->get();

        $leLogins = loginTime::where('logindate',date('Y-m-d'))
                        ->join('users','login_times.user_id','users.id')
                        ->leftjoin('departments','users.department_id','departments.id')
                        ->select('users.name','users.employeeId','login_times.*','departments.id')
                        ->get();
         $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();


         $x = Ward::where('id',$tl)->pluck('ward_name')->first();
                  
         return view('/teamLeader',['loggedInUsers'=>$loggedInUsers,'leLogins'=> $leLogins,'users'=>$users,'x'=>$x]);
    }
    public function assignListSlots(){          
    // $group = Group::where('group_name','Listing Engineer')->pluck('id')->first();
    $group = [6,11];
        
        $users = User::whereIn('group_id',$group)
                        ->leftjoin('ward_assignments','ward_assignments.user_id','=','users.id')
                        ->leftjoin('sub_wards','sub_wards.id','=','ward_assignments.subward_id')
                        ->leftjoin('wards','wards.id','=','sub_wards.ward_id' )
                        ->leftjoin('employee_details','users.employeeId','=','employee_details.employee_id') 
                        ->where('department_id','!=','10')
                        ->select('users.employeeId','users.id','users.name','ward_assignments.status','sub_wards.sub_ward_name','sub_wards.sub_ward_image','ward_assignments.prev_subward_id','employee_details.office_phone')
                        ->get();
        $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
        $userIds = explode(",", $tl);
      $tlUsers= User::whereIn('users.id',$userIds)
                        ->where('users.group_id',6)
                        ->leftjoin('ward_assignments','ward_assignments.user_id','=','users.id')
                        ->leftjoin('sub_wards','sub_wards.id','=','ward_assignments.subward_id')
                        ->leftjoin('wards','wards.id','=','sub_wards.ward_id' )
                        ->leftjoin('employee_details','users.employeeId','=','employee_details.employee_id') 
                        ->where('department_id','!=','10')
                        ->select('users.employeeId','users.id','users.name','ward_assignments.status','sub_wards.sub_ward_name','sub_wards.sub_ward_image','ward_assignments.prev_subward_id','employee_details.office_phone')
                        ->get();
                       
       $totalcount = User::whereIn('group_id',$group)
                            ->where('department_id','!=','10')
                            ->count();

        $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
      
        
         if(Auth::user()->group_id != 22){
        $wards = Ward::orderby('ward_name','ASC')->get();
         }else{
             $wards = Ward::orderby('ward_name','ASC')->where('id',$tlward)->get();
         }
            
        $zones = Zone::all();
        $subwardsAssignment = WardAssignment::all();
        $subwards = SubWard::orderby('sub_ward_name','ASC')->get();
        

        
        return view('assignListSlots',['users'=>$users,'subwards'=>$subwards,'subwardsAssignment'=>$subwardsAssignment,'wards'=>$wards,'zones'=>$zones,'totalcount'=>$totalcount,'tlUsers'=> $tlUsers]);
    }
     public function assignadmin(){          
    $group = Group::where('group_name','Admin')->pluck('id')->first();
        $users = User::where('group_id',$group)
                        ->leftjoin('ward_assignments','ward_assignments.user_id','=','users.id')
                        ->leftjoin('sub_wards','sub_wards.id','=','ward_assignments.subward_id')
                        ->leftjoin('wards','wards.id','=','sub_wards.ward_id' )
                        ->leftjoin('employee_details','users.employeeId','=','employee_details.employee_id')
                        ->where('department_id','!=','10')
                        ->select('users.employeeId','users.id','users.name','ward_assignments.status','sub_wards.sub_ward_name','sub_wards.sub_ward_image','ward_assignments.prev_subward_id','employee_details.office_phone')
                        ->get();

       
        $wards = Ward::orderby('ward_name','ASC')->get();
        $zones = Zone::all();
        $subwardsAssignment = WardAssignment::all();
        $subwards = SubWard::orderby('sub_ward_name','ASC')->get();
        
        return view('assignadmin',['users'=>$users,'subwards'=>$subwards,'subwardsAssignment'=>$subwardsAssignment,'wards'=>$wards,'zones'=>$zones]);
    }
     public function tlmaps()
    {
         if(Auth::user()->group_id != 22){
            return $this->tlmap1($request);
         }

        $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
        $wards = Ward::orderby('ward_name','ASC')
        ->where('id',  $tlward)->get();
        $zones = Zone::all();
        return view('tlMaps',['wards'=>$wards,'zones'=>$zones]);
    }
    public function tlmaps1()
    {
        $wards = Ward::orderby('ward_name','ASC')->get();
        $zones = Zone::all();
        return view('tlMaps',['wards'=>$wards,'zones'=>$zones]);
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

        $date = date('Y-m-d');
        $users = User::where('department_id','1')->where('group_id','6')
                    ->leftjoin('ward_assignments','users.id','ward_assignments.user_id')
                    ->leftjoin('sub_wards','ward_assignments.subward_id','sub_wards.id')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();
        $accusers = User::where('department_id','2')->where('group_id','11')
                    ->leftjoin('ward_assignments','users.id','ward_assignments.user_id')
                    ->leftjoin('sub_wards','ward_assignments.subward_id','sub_wards.id')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();
        foreach($accusers as $user){
                $totalaccount[$user->id] = ProjectDetails::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
        }
        foreach($users as $user){
                $totalListing[$user->id] = ProjectDetails::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
        }
        $ordersInitiated = Requirement::where('generated_by',Auth::user()->id)
                            ->where( 'created_at', '>=', Carbon::now()->firstOfMonth())
                            ->count();
       

        $ordersConfirmed = Requirement::where('generated_by',Auth::user()->id)
                           ->where( 'created_at', '>=', Carbon::now()->firstOfMonth())
                            ->where('status','Order Confirmed')->count();
        


        $check = loginTime::where('user_id',Auth::user()->id)
            ->where('logindate',date('Y-m-d'))->first();
        if(($check)== null){
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


         
                        
        $genuineprojects = count(ProjectDetails::where('quality','Genuine')
                        ->leftjoin('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get());
       
        $unverifiedprojects = count(ProjectDetails::where('quality','Unverified')
                        ->leftjoin('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get());
        $fakeprojects = count(ProjectDetails::where('quality','Fake')
                        ->leftjoin('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get());

        $totalprojects = count($projects);

       


       $today = date('Y-m-d');
        $past = date('Y-m-d',strtotime("-30 days",strtotime($today)));
       $update =User::leftjoin('project_details','project_details.listing_engineer_id','users.id')
                    ->where('project_details.sub_ward_id',$wardsAssigned)
                    ->where('users.id',Auth::user()->id)
                   ->where('project_details.updated_at',">=",$past)->pluck('project_details.project_id')->count();
     
         $bal = $totalprojects  -  $update;


      
        $prices = CategoryPrice::all();
        $points_earned_so_far = Point::where('user_id',Auth::user()->id)->where('confirmation',1)->where('created_at','LIKE',date('Y-m-d')."%")->where('type','Add')->sum('point');
        $points_subtracted = Point::where('user_id',Auth::user()->id)->where('confirmation',1)->where('created_at','LIKE',date('Y-m-d')."%")->where('type','Subtract')->sum('point');
        $points_indetail = Point::where('user_id',Auth::user()->id)->where('confirmation',1)->where('created_at','LIKE',date('Y-m-d')."%")->get();
        if($subwards != null){
            $subwardMap = SubWardMap::where('sub_ward_id',$subwards->id)->first();
        }else{
            $subwardMap = "None";
        }
        if($subwardMap == Null){
            $subwardMap = "None";
        }
        // $total = $points_earned_so_far - $points_subtracted;
         $lastmonth = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)->where( 'created_at', '>=', Carbon::now()->firstOfMonth())->get());
        
        return view('listingEngineerDashboard',['prices'=>$prices,
                                                'subwards'=>$subwards,
                                                'projects'=>$projects,
                                                'numbercount'=>$numbercount,
                                                'lastmonth' =>$lastmonth,
                                                'ldate'=>$ldate,
                                                'lodate'=>$lodate,
                                                'outtime'=>$outtime,
                                                'total'=>$totalLists,
                                                'ordersInitiated'=>$ordersInitiated,
                                                'ordersConfirmed'=>$ordersConfirmed,
                                                'points_indetail'=>$points_indetail,
                                                'points_earned_so_far'=>$points_earned_so_far,
                                                'points_subtracted'=>$points_subtracted,
                                                'subwardMap'=>$subwardMap,
                                                'totalprojects'=>$totalprojects,
                                                'genuineprojects'=>$genuineprojects,
                                                'unverifiedprojects'=>$unverifiedprojects,
                                                'fakeprojects'=>$fakeprojects,
                                                'totalListing'=> $totalListing,
                                                'users'=>$users,
                                                'accusers'=>$accusers,
                                                'totalaccount'=>$totalaccount,
                                                'update' =>  $update,
                                                'bal'=>$bal
                                                // 'total'=>$total
                                                ]);
    }


public function sales(Request $request){



     $wardsAssigned = WardAssignment::where('user_id',$request->userId)->where('status','Not Completed')->pluck('subward_id')->first();
        $subwards = SubWard::where('id',$wardsAssigned)->first();

$projects = ProjectDetails::join('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get();
                        
        $genuineprojects = count(ProjectDetails::where('quality','Genuine')
                        ->leftjoin('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get());
       
        $unverifiedprojects = count(ProjectDetails::where('quality','Unverified')
                        ->leftjoin('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get());
        $fakeprojects = count(ProjectDetails::where('quality','Fake')
                        ->leftjoin('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get());

        $totalprojects = count($projects);

       


       $update =User::leftjoin('project_details','project_details.listing_engineer_id','users.id')
                    ->where('project_details.sub_ward_id',$wardsAssigned)
                   ->where('project_details.updated_at','LIKE',date('Y-m-d')."%")->pluck('project_details.project_id')->count();
     
         $bal = $totalprojects  -  $update ;
                  

         return response()->json(['balance'=>$bal]);


} 



    public function projectList()
    {
        $projectlist = ProjectDetails::where('listing_engineer_id',Auth::user()->id)->get();
        return view('projectlist',['projectlist'=>$projectlist]);
    }
    public function editProject(Request $request)
    {
        $projectdetails = ProjectDetails::where('project_id',$request->projectId)->first();
        $projectimages = ProjectImage::where('project_id',$request->projectId)->get();
        $wardsAssigned = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $subwards = SubWard::where('id',$wardsAssigned)->first();
        $roomtypes = RoomType::where('project_id',$request->projectId)->get();
        $projectward = SubWard::where('id',$projectdetails->sub_ward_id)->pluck('sub_ward_name')->first();
        $user = User::where('id',$projectdetails->listing_engineer_id)->pluck('name')->first();
        $updater = User::where('id',$projectdetails->updated_by)->first();
        // $projectdetails['budgetType'] = explode(",", $projectdetails['budgetType']);
        return view('update',[
                    'updater'=>$updater,
                    'username'=>$user,
                    'subwards'=>$subwards,
                    'projectdetails'=>$projectdetails,
                    'projectimages'=>$projectimages,
                    'projectward'=>$projectward,
                    'roomtypes'=>$roomtypes

                ]);
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
        // $roads = ProjectDetails::where('sub_ward_id',$assignment)->select('road_name')->groupby('road_name')->paginate(10);

        // $roadname = ProjectDetails::where('sub_ward_id',$assignment)->groupby('road_name')->pluck('road_name');
      
         $todays = ProjectDetails::where('listing_engineer_id',Auth::user()->id)->where('created_at','LIKE',date('Y-m-d')."%")->count();
       
        // $projectcount = array();

        // foreach($roadname as $roadname){
            $genuine = ProjectDetails::where('quality','Genuine')
                                                    ->where('sub_ward_id',$assignment)
                                                    ->paginate(10);
                                                  
            $null = ProjectDetails::where('quality','Unverified')
                                                    ->where('sub_ward_id',$assignment)
                                                    ->paginate(10);
            $fake = ProjectDetails::where('quality','Fake')
                                                    ->where('sub_ward_id',$assignment)
                                                    ->paginate(10);

            // $projectCount = $null + $genuine; + $fake;

        // }


        return view('requirementsroad',['todays'=>$todays,'genuine'=>$genuine,'null'=>$null,'fake'=>$fake]);

        

    }
    public function viewProjectList(Request $request)
    {
        if($request->today){
            $projectlist = ProjectDetails::where('created_at','LIKE',date('Y-m-d')."%")->where('listing_engineer_id',Auth::user()->id)->get();
        }else{
            $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
            $projectlist = ProjectDetails::where('road_name',$request->road)
            ->where('sub_ward_id',$assignment)
            ->get();
        }
        if($request->quality){
            $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
            $projectlist = ProjectDetails::where('quality',$request->quality)
            ->where('sub_ward_id',$assignment)
            ->get();
        }
        return view('projectlist',['projectlist'=>$projectlist,'pageName'=>"Update"]);
    }

    public function getMyReports(Request $request)
    {
        $now = date('H:i:s');
        $currentURL = url()->current();;
        $display = "";
        $evening = "";
        if(!$request->date){
            date_default_timezone_set("Asia/Kolkata");
            $today = date('Y-m-d');
            $projectCount = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)
                ->where('created_at','like',$today.'%')->get());
            $loginTimes = loginTime::where('user_id',Auth::user()->id)->where('logindate',$today)->first();
            $display .= "<tr><td>Login Time</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->loginTime : '').
                        "</td></tr><tr><td>Allocated Ward</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->allocatedWard : '').
                        "</td></tr><tr><td>First Listing Time</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->firstListingTime : '').
                        "</td></tr><tr><td>First Update Time</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->firstUpdateTime : '').
                        "</td></tr><tr><td>No. of Projects Listed <br> In The Morning</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->noOfProjectsListedInMorning : '').
                        "</td></tr><tr><td>No. of Projects Updated <br> In The Morning</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->noOfProjectsUpdatedInMorning : '').
                        "</td></tr><tr><td>Meter Image</td><td>:</td><td>".
                        ($loginTimes != null ? ($loginTimes->morningMeter != null ? "<img src='"
                        .$currentURL."/public/meters/".$loginTimes->morningMeter.
                        "' height='100' width='200' class='img img-thumbnail'>" : '*No Image Uploaded*') : '*No Image Uploaded*').
                        "</td></tr><tr><td>Meter Reading</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->gtracing : '').
                        "</td></tr><tr><td>Data Image</td><td>:</td><td>".
                        ($loginTimes != null ? ($loginTimes->morningData != null ? "<img src='"
                        .$currentURL."/public/data/".$loginTimes->morningData.
                        "' height='100' width='200' class='img img-thumbnail'>" : '*No Image Uploaded*') : '*No Image Uploaded*').
                        "</td></tr><tr><td>Data Reading</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->afternoonData : '').
                        "</td></tr><tr><td>Team Leader Remarks</td><td>:</td><td>".
                        ($loginTimes != null ? $loginTimes->morningRemarks : '')."</td></tr>";

                    $evening .= "<tr><td>Last Listing Time</td><td>:</td><td>"
                    .($loginTimes != null ? $loginTimes->lastListingTime : '').
                    "</td></tr><tr><td>Last Update Time</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->lastUpdateTime : '').
                    "</td></tr><tr><td>Total Projects Listed</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->TotalProjectsListed : '').
                    "</td></tr><tr><td>Total Projects Updated</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->totalProjectsUpdated : '').
                    "</td></tr><tr><td>Meter Image</td><td>:</td><td>".
                    ($loginTimes != null ? ($loginTimes->eveningMeter != null ? "<img src='"
                    .$currentURL."/public/meters/".$loginTimes->eveningMeter.
                    "' height='100' width='200' class='img img-thumbnail'>" : '*No Image Uploaded*') : '*No Image Uploaded*').
                    ($loginTimes != null ? $loginTimes->eveningMeter : '').
                    "</td></tr><tr><td>Meter Reading</td><td>:</td><td>".
                    "</td></tr><tr><td>Data Image</td><td>:</td><td>".
                    ($loginTimes != null ? ($loginTimes->afternoonMeter != null ? "<img src="
                    .$currentURL."/public/meters/".$loginTimes->afternoonMeter.
                    " height='100' width='200' class='img img-thumbnail'>"
                    : '*No Image Uploaded*') : '*No Image Uploaded*').
                    ($loginTimes != null ? $loginTimes->eveningData : '').
                    // "</td></tr><tr><td>Data Reading</td><td>:</td><td>".
                    // ($loginTimes != null ? $loginTimes->afternoonRemarks : '').
                     "</td></tr><tr><td>Team Leader Remark</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->eveningRemarks : '').
                    "</td></tr><tr><td>Asst. Manager Remarks</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->AmRemarks : '').
                    "</td></tr><tr><td>Grade</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->AmGrade : '').
                    "</td></tr></table>";
            return view('reports',[
                'evening'=>$evening,
                'display'=>$display,
                'loginTimes'=>$loginTimes,
                'projectCount'=>$projectCount,
                'now'=>$now
            ]);
        }else{
            $projectCount = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)
                ->where('created_at','like',$request->date.'%')->get());
            $loginTimes = loginTime::where('user_id',Auth::user()->id)->where('logindate',$request->date)->first();
            $display .= "<tr><td>Login Time</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->loginTime : '').
                        "</td></tr><tr><td>Allocated Ward</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->allocatedWard : '').
                        "</td></tr><tr><td>First Listing Time</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->firstListingTime : '').
                        "</td></tr><tr><td>First Update Time</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->firstUpdateTime : '').
                        "</td></tr><tr><td>No. of projects listed <br> in the morning</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->noOfProjectsListedInMorning : '').
                        "</td></tr><tr><td>No. of projects updated <br> in the morning</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->noOfProjectsUpdatedInMorning : '').
                        "</td></tr><tr><td>Meter Image</td><td>:</td><td>".
                        ($loginTimes != null ? ($loginTimes->morningMeter != null ? "<img src='"
                        .$currentURL."/public/meters/".$loginTimes->morningMeter.
                        "' height='100' width='200' class='img img-thumbnail'>" : '*No Image Uploaded*') : '*No Image Uploaded*').
                        "</td></tr><tr><td>Meter Reading</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->gtracing : '').
                        "</td></tr><tr><td>Data Image</td><td>:</td><td>".
                        ($loginTimes != null ? ($loginTimes->morningData != null ? "<img src='"
                        .$currentURL."/public/data/".$loginTimes->morningData.
                        "' height='100' width='200' class='img img-thumbnail'>" : '*No Image Uploaded*') : '*No Image Uploaded*').
                        "</td></tr><tr><td>Data Reading</td><td>:</td><td>"
                        .($loginTimes != null ? $loginTimes->afternoonData : '').
                        "</td></tr><tr><td>Team Leader Remarks</td><td>:</td><td>".
                        ($loginTimes != null ? $loginTimes->morningRemarks : '')."</td></tr>";

                        $evening .= "<tr><td>Last Listing Time</td><td>:</td><td>"
                    .($loginTimes != null ? $loginTimes->lastListingTime : '').
                    "</td></tr><tr><td>Last Update Time</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->lastUpdateTime : '').
                    "</td></tr><tr><td>Total Projects Listed</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->TotalProjectsListed : '').
                    "</td></tr><tr><td>Total Projects Updated</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->totalProjectsUpdated : '').
                    "</td></tr><tr><td>Meter Image</td><td>:</td><td>".
                    ($loginTimes != null ? ($loginTimes->eveningMeter != null ? "<img src='"
                    .$currentURL."/public/meters/".$loginTimes->eveningMeter.
                    "' height='100' width='200' class='img img-thumbnail'>" : '*No Image Uploaded*') : '*No Image Uploaded*').
                    ($loginTimes != null ? $loginTimes->eveningMeter : '').
                    "</td></tr><tr><td>Meter Reading</td><td>:</td><td>".
                    "</td></tr><tr><td>Data Image</td><td>:</td><td>".
                    ($loginTimes != null ? ($loginTimes->afternoonMeter != null ? "<img src="
                    .$currentURL."/public/meters/".$loginTimes->afternoonMeter.
                    " height='100' width='200' class='img img-thumbnail'>"
                    : '*No Image Uploaded*') : '*No Image Uploaded*').
                    ($loginTimes != null ? $loginTimes->eveningData : '').
                    "</td></tr><tr><td>Data Reading</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->afternoonRemarks : '').

                     "</td></tr><tr><td>Team Leader Remark</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->eveningRemarks : '').

                    "</td></tr><tr><td>Asst. Manager Remarks</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->AmRemarks : '').
                    "</td></tr><tr><td>Grade</td><td>:</td><td>".
                    ($loginTimes != null ? $loginTimes->AmGrade : '').
                    "</td></tr></table>";
            return view('reports',[
                'loginTimes'=>$loginTimes,
                'projectCount'=>$projectCount,
                'display'=>$display,
                'evening'=>$evening,
                'now'=>$now
            ]);
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
            $points_earned_so_far = Point::where('user_id',$id)
                                ->where('created_at','LIKE',$request->date."%")
                                ->where('confirmation',1)
                                ->where('type','Add')
                                ->sum('point');
            $points_subtracted = Point::where('user_id',$id)
                                ->where('created_at','LIKE',$request->date."%")
                                ->where('confirmation',1)
                                ->where('type','Subtract')
                                ->sum('point');
            $points_indetail = Point::where('user_id',$id)
                                ->where('created_at','LIKE',$request->date."%")
                                ->where('confirmation',1)
                                ->get();
            $total = $points_earned_so_far - $points_subtracted;
            $loginTimes = loginTime::where('user_id',$id)
                ->where('logindate',$request->date)->first();
            if($loginTimes != NULL){
                return view('lereportbytl',[
                    'points_earned_so_far' => $points_earned_so_far,
                    'points_subtracted'=>$points_subtracted,
                    'points_indetail'=>$points_indetail,
                    'total'=>$total,
                    'loginTimes'=>$loginTimes,
                    'userId'=>$id,
                    'username'=>$username
                    ]);             
            }else{
                $loginTimes = loginTime::where('user_id',$id)
                    ->where('logindate',date('Y-m-d'))->first();
                return back()->with('Error','No Records found');
            }
        }
        $points_earned_so_far = Point::where('user_id',$id)
                                ->where('created_at','LIKE',date('Y-m-d')."%")
                                ->where('confirmation',1)
                                ->where('type','Add')
                                ->sum('point');
        $points_subtracted = Point::where('user_id',$id)
                                ->where('created_at','LIKE',date('Y-m-d')."%")
                                ->where('confirmation',1)
                                ->where('type','Subtract')
                                ->sum('point');
        $points_indetail = Point::where('user_id',$id)
                                ->where('created_at','LIKE',date('Y-m-d')."%")
                                ->where('confirmation',1)
                                ->get();
        $total = $points_earned_so_far - $points_subtracted;
        $loginTimes = loginTime::where('user_id',$id)
            ->where('logindate',date('Y-m-d'))->first();
        return view('lereportbytl',[
            'points_earned_so_far' => $points_earned_so_far,
            'points_subtracted'=>$points_subtracted,
            'points_indetail'=>$points_indetail,
            'total'=>$total,
            'loginTimes'=>$loginTimes,
            'userId'=>$id,
            'username'=>$username
            ]);
    }
    public function getRequirementRoads()
    {
        $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $roadname = ProjectDetails::where('sub_ward_id',$assignment)->groupBy('road_name')->pluck('road_name');
        $roads = ProjectDetails::where('sub_ward_id',$assignment)->select('road_name')->groupBy('road_name')->paginate(10);
        $projectcount = array();
        $todays = ProjectDetails::where('listing_engineer_id',Auth::user()->id)->where('created_at','LIKE',date('Y-m-d')."%")->count();
        
        
        $name = ProjectDetails::where('sub_ward_id',$assignment)->where('quality','Genuine')->select("road_name")->groupBy('road_name')->pluck("project_id");
       
        foreach($roadname as $roadw){
            $genuine = ProjectDetails::where('road_name',$roadw)
                                                    ->where('quality','Genuine')
                                                    ->where('sub_ward_id',$assignment)
                                                    ->count();
            $null = ProjectDetails::where('road_name',$roadw)
                                                    ->where('quality','Unverified')
                                                    ->where('sub_ward_id',$assignment)
                                                    ->count();
            $projectcount[$roadw] = $null + $genuine;
        }
        return view('requirementsroad',['todays'=>$todays,'roads'=>$roads,'projectcount'=>$projectcount,'roadname'=>$roadname]);
    }
    public function projectRequirement(Request $request)
    {
        if($request->today){
            $projectlist = ProjectDetails::where('created_at','LIKE',date('Y-m-d')."%")->where('listing_engineer_id',Auth::user()->id)->get();
        }
        else{
        $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $projectlist = ProjectDetails::where('road_name',$request->road)
        ->where('sub_ward_id',$assignment)
            ->get();
        }
        if($request->quality){
            $assignment = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
            $projectlist = ProjectDetails::where('quality',$request->quality)
            ->where('sub_ward_id',$assignment)
                ->paginate(10);
        }
        return view('projectlist',['projectlist'=>$projectlist,'pageName'=>"Requirements"]);
    }
    public function getRequirements(Request $request)
    {
        $depart = [2,4,8,6,7];
        $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $assignment = salesassignment::where('user_id',Auth::user()->id)->pluck('assigned_date')->first();
        $requirements = Requirement::where('project_id',$request->projectId)->get();
        $projects = ProjectDetails::where('project_id', $request->projectId)->first();
        $category = Category::all();
        return view('requirements',['category'=>$category, 'requirements'=>$requirements,'id'=>$request->projectId,'projects'=>$projects,'assignment'=>$assignment,'users'=>$users]);
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
        $points_earned_so_far = Point::where('user_id',$id)
                                ->where('created_at','LIKE',$date."%")
                                // ->where('confirmation',1)
                                ->where('type','Add')
                                ->sum('point');
        $points_subtracted = Point::where('user_id',$id)
                            ->where('created_at','LIKE',$date."%")
                            // ->where('confirmation',1)
                            ->where('type','Subtract')
                            ->sum('point');
        $points_indetail = Point::where('user_id',$id)
                            ->where('created_at','LIKE',$date."%")
                            // ->where('confirmation',1)
                            ->get();
        $total = $points_earned_so_far - $points_subtracted;
        return view('amreport',[
                'logintimes'=>$logintimes,
                'user'=>$user,
                'date'=>$date,
                'points_earned_so_far'=>$points_earned_so_far,
                'points_subtracted'=>$points_subtracted,
                'points_indetail'=>$points_indetail,
                'total'=>$total
            ]);
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
        $assignment = salesassignment::where('user_id',$id->userid)->first();
        $ward = SubWard::where('id',$assignment->assigned_date)->first();
        $assignment->prev_assign = $ward->sub_ward_name;
        $assignment->status = 'Completed';
        $assignment->save();
        salesassignment::where('user_id',Auth::user()->id)->delete();
        return back();
    }
     public function completethis1(Request $user_id)
    {   
        $assignment =AssignStage::where('user_id',Auth::user()->id)->first();
       
        $assignment->state = 'Completed';
        $assignment->save();    
        AssignStage::where('user_id',Auth::user()->id)->delete();
        return back();
    }

    // sales
    public function getSalesTL(){
        $id = Department::where('dept_name',"Sales")->pluck('id')->first();
        $users = User::where('department_id',$id)
                        ->leftjoin('salesassignments','salesassignments.user_id','=','users.id')
                        ->leftjoin('sub_wards','salesassignments.assigned_date','=','sub_wards.id')
                        ->select('salesassignments.*','users.employeeId','users.name','users.id','sub_wards.sub_ward_name')
                        ->get();
        $subwardsAssignment = salesassignment::where('status','Not Completed')->get();
        $wards = Ward::all();
        return view('salestl',['users'=>$users,'subwardsAssignment'=>$subwardsAssignment,'pageName'=>'Assign','wards'=>$wards]);
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
        $points_earned_so_far = Point::where('user_id',Auth::user()->id)->where('created_at','LIKE',date('Y-m-d')."%")->where('type','Add')->sum('point');
        $points_subtracted = Point::where('user_id',Auth::user()->id)->where('created_at','LIKE',date('Y-m-d')."%")->where('type','Subtract')->sum('point');
        $points_indetail = Point::where('user_id',Auth::user()->id)->where('created_at','LIKE',date('Y-m-d')."%")->get();
        $total = $points_earned_so_far - $points_subtracted;
        $stages = AssignStage::where('user_id',Auth::user()->id)->first();
        return view('sedashboard',[
            'projects'=>$projects,
            'reqcount'=>$reqcount,
            'assignment'=>$assignment,
            'prices'=>$prices,
            'calls'=>$calls,
            'followups'=>$followups,
            'ordersinitiate'=>$ordersinitiate,
            'ordersConfirmed'=>$ordersConfirmed,
            'fakeProjects'=>$fakeProjects,
            'genuineProjects'=>$genuineProjects,
            'points_indetail'=>$points_indetail,
            'points_earned_so_far'=>$points_earned_so_far,
            'points_subtracted'=>$points_subtracted,
            'total'=>$total,
            'stages'=>$stages
        ]);
    }
    public function printLPO($id, Request $request)
    {
        $order = Order::where('id',$id)->first();

        $rec = ProjectDetails::where('project_id', $order->project_id)->first(); 
        
        return view('printLPO', ['rec' => $rec,'order'=>$order,'id'=>$id]);
    }
    public function ampricing(Request $request){
        $prices = CategoryPrice::all();
        $categories = Category::all();
        return view('updateprice',['prices'=>$prices,'categories'=>$categories]);
    }

    public function setprice(Request $request){
        $prices = CategoryPrice::all();
        $categories = Category::all();
        $myPrices = Pricing::leftJoin('category','pricing.cat','category.id')
                            ->leftJoin('brands','pricing.brand','brands.id')
                            ->leftJoin('category_sub','pricing.suncat','category_sub.id')
                            ->get();
        return view('setprice',['prices'=>$prices,'categories'=>$categories,'myPrices'=>$myPrices]);
    }
 public function allprice(Request $request){
       $myPrices = Pricing::leftJoin('category','pricing.cat','category.id')
                            ->leftJoin('brands','pricing.brand','brands.id')
                            ->leftJoin('category_sub','pricing.suncat','category_sub.id')
                            ->get();
         $users = User::get();
                         
        return view('allprice',['myPrices'=>$myPrices,'users'=>$users]);
    }
 public function amorders1(Request $request)
    {  

         $id = $request->projectId;
        if($request->projectId){
            $view = Order::orderby('orders.id','DESC')
                    ->leftJoin('users','orders.generated_by','=','users.id')
                    ->leftJoin('delivery_details','orders.id','delivery_details.order_id')
                     ->select('orders.*','orders.status as order_status','orders.delivery_status as order_delivery_status','orders.id as orderid','users.name','users.group_id',
                         'delivery_details.vehicle_no','delivery_details.location_picture','delivery_details.quality_of_material','delivery_details.delivery_video','delivery_details.delivery_date','orders.payment_status as ostatus','orders.quantity')
                    ->where('project_id',$request->projectId)
                  
                    ->paginate(25);
               
        }else{
            $view = Order::orderby('orders.id','DESC')
                    ->leftJoin('users','orders.generated_by','=','users.id')
                    ->leftJoin('delivery_details','orders.id','delivery_details.order_id')
                    ->leftjoin('requirements','orders.project_id','requirements.project_id')->where('requirements.status','=','Enquiry Confirmed')
                    ->select('orders.*','orders.status as order_status','orders.delivery_status as order_delivery_status','requirements.*','orders.id as orderid','users.name','users.group_id',
                    'delivery_details.vehicle_no','delivery_details.location_picture','delivery_details.quality_of_material','delivery_details.delivery_video','delivery_details.delivery_date' ,'orders.payment_status as ostatus','orders.quantity')
                    ->paginate(25);

        }
  
        $depts = [1,2];
        $users = User::whereIn('department_id',$depts)->get();
        $req = Requirement::pluck('project_id');
       
        
        return view('ordersadmin',['view' => $view,'users'=>$users,'req'=>$req]);
    }
   

    public function amorders(Request $request)
    {  
          $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
          if(Auth::user()->group_id != 22){
            return $this->amorders1($request);
          }
        if($request->projectId){
            $view = Order::orderby('orders.id','DESC')
                    ->leftJoin('users','orders.generated_by','=','users.id')
                    ->leftJoin('delivery_details','orders.id','delivery_details.order_id')
                    ->leftjoin('project_details','project_details.project_id','orders.project_id')
                    ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                    ->leftJoin('wards','wards.id','sub_wards.ward_id')
                    ->select('orders.*','orders.status as order_status','orders.delivery_status as order_delivery_status','orders.id as orderid','users.name','users.group_id',
                         'delivery_details.vehicle_no','delivery_details.location_picture','delivery_details.quality_of_material','delivery_details.delivery_video','delivery_details.delivery_date','orders.payment_status as ostatus','orders.quantity')
                    ->where('project_id',$request->projectId)
                    ->where('wards.id',$tlward)

                    ->paginate(25);
               
        }else{
            $view = Order::orderby('orders.id','DESC')
                    ->leftJoin('users','orders.generated_by','=','users.id')
                    ->leftJoin('delivery_details','orders.id','delivery_details.order_id')
                    ->leftjoin('requirements','orders.project_id','requirements.project_id')->where('requirements.status','=','Enquiry Confirmed')
                     ->leftjoin('project_details','project_details.project_id','orders.project_id')
                    ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                    ->leftJoin('wards','wards.id','sub_wards.ward_id')
                    ->where('wards.id',$tlward)
                    
                    ->select('orders.*','orders.status as order_status','orders.delivery_status as order_delivery_status','requirements.*','orders.id as orderid','users.name','users.group_id',
                    'delivery_details.vehicle_no','delivery_details.location_picture','delivery_details.quality_of_material','delivery_details.delivery_video','delivery_details.delivery_date','orders.payment_status as ostatus','orders.quantity')
                    ->paginate(25);
        }
  
        $depts = [1,2];
        $users = User::whereIn('department_id',$depts)->get();
        $req = Requirement::pluck('project_id');
       
        
        return view('ordersadmin',['view' => $view,'users'=>$users,'req'=>$req]);
    }
   
    public function getSubCat(Request $request)
    {
        $cat = $request->cat; 
        $category = Category::where('id',$cat)->first();
        $subcat = SubCategory::where('brand_id',$request->brand)->get();
        $res = array();
        $res[0] = $category;
        $res[1] = $subcat;
        return response()->json($res);
    }
    public function getSubCatPrices(Request $request){
        $cat = $request->cat;
        $brand = $request->brand;
        $category = Category::where('id',$cat)->first();
        $subcat = SubCategory::leftJoin('category_price','category_sub.id','=','category_price.category_sub_id')
            ->select('category_sub.*','category_price.price')
            ->where('category_sub.category_id',$cat)
           ->where('category_sub.brand_id',$brand)
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
        $username = User::where('id',$rec->listing_engineer_id)->first();
        $callAttendedBy = User::where('id',$rec->call_attended_by)->first();
        $followupby = User::where('id',$rec->follow_up_by)->first();
        $roomtypes = RoomType::where('project_id',$id)->get();
        $subward = SubWard::where('id',$rec->sub_ward_id)->pluck('sub_ward_name')->first();
        return view('adminprojectdetails',[
                'rec' => $rec,
                'username'=>$username,
                'callAttendedBy'=>$callAttendedBy,
                'roomtypes'=>$roomtypes,
                'followupby'=>$followupby,
                'subward'=>$subward
            ]);
    }
    public function confirmOrder(Request $request)
    {
        $id = $request->id;
       

            $x = Order::where('id', $id)->update(['status' => 'Order Confirmed','payment_status'=>'Payment Pending']);
            
                return back();
          
    }
    public function cancelOrder(Request $request)
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
        $project = OwnerDetails::where('project_id',$id)->first();
        $point = 0;
        if($project != null){
            $point = $name != $project->owner_name ? $point+5 : $point+0;
            $point = $phone != $project->owner_contact_no ? $point+5 : $point+0;
            $point = $email != $project->owner_email ? $point+5 : $point+0;
            $points = new Point;
            $points->user_id = Auth::user()->id;
            $points->point = $point;
            $points->type = "Add";
            $points->reason = "Updating owner details";
            $points->save();
        }
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
        $project = ContractorDetails::where('project_id',$id)->first();
        $point = 0;
        if($project != null){
            $point = $name != $project->contractor_name ? $point+3 : $point+0;
            $point = $phone != $project->contractor_contact_no ? $point+3 : $point+0;
            $point = $email != $project->contractor_email ? $point+3 : $point+0;
            $points = new Point;
            $points->user_id = Auth::user()->id;
            $points->point = $point;
            $points->type = "Add";
            $points->reason = "Updating contractor details";
            $points->save();
        }
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
        $project = ConsultantDetails::where('project_id',$id)->first();
        $point = 0;
        if($project != null){
            $point = $name != $project->consultant_name ? $point+3 : $point+0;
            $point = $phone != $project->consultant_contact_no ? $point+3 : $point+0;
            $point = $email != $project->consultant_email ? $point+3 : $point+0;
            $points = new Point;
            $points->user_id = Auth::user()->id;
            $points->point = $point;
            $points->type = "Add";
            $points->reason = "Updating consultant details";
            $points->save();
        }
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
        $project = ProcurementDetails::where('project_id',$id)->first();
        $point = 0;
        if($project != null){
            $point = $name != $project->procurement_name ? $point+3 : $point+0;
            $point = $phone != $project->procurement_contact_no ? $point+3 : $point+0;
            $point = $email != $project->procurement_email ? $point+3 : $point+0;
            $points = new Point;
            $points->user_id = Auth::user()->id;
            $points->point = $point;
            $points->type = "Add";
            $points->reason = "Updating procurement details";
            $points->save();
        }
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
        $x = Order::where('id', $id)->update(['payment_status' => $update]);
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
        $x = Order::where('id', $id)->update(['dispatch_status' => "Yes",'delivery_status'=>'Not Delivered']);
        if($x)
        {
            return response()->json("Updated");
        }
        else
        {
            return response()->json('Error');
        }
    }
    public function deliverOrder(Request $request)
    {
        $id = $request->id;
        $today = date('Y-m-d');
        $x = Order::where('id', $id)->update(['delivery_status'=>'Delivered','delivered_on'=>$today]);
        if($x)
        {
            return response()->json("Updated");
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
    public function smstonumber(Request $request)
    {
       
                        if(Auth::user()->group_id != 22){
                        return $this->smstonumber1($request);
                        }



        if(!$request->stage ){
            $stages =null;
        }else{
            $stages = $request->stage;
        }

  $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();

         $projectids = new Collection();
         $orders = Order::where('status','Order Confirmed')->pluck('project_id');
         $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
         if($stages != null){
             $projectids = ProjectDetails::leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
             ->leftjoin('wards','wards.id','sub_wards.ward_id')
             ->where('wards.id',$tlward)
             ->whereIn('project_status',$stages)
             ->where('quality','!=','Fake')
             ->whereNotIn('project_id',$orders)
             ->pluck('project_id'); 
         }else{
            $projectids = null;
         }     
    if($projectids != null){

           //fetch phonee numbers//
            $procurement =ProcurementDetails::whereIn('project_id',$projectids)->where('procurement_contact_no','!=',null)->pluck('procurement_contact_no')->toarray();
          
           
            $siteeng =SiteEngineerDetails::whereIn('project_id',$projectids)->where('site_engineer_contact_no','!=',null)->pluck('site_engineer_contact_no')->toarray();
         
            $contractor =ContractorDetails::whereIn('project_id',$projectids)->where('contractor_contact_no','!=',null)->pluck('contractor_contact_no')->toarray();
         
            $consultant =ConsultantDetails::whereIn('project_id',$projectids)->where('consultant_contact_no','!=',null)->pluck('consultant_contact_no')->toarray();
           
            $owner =OwnerDetails::whereIn('project_id',$projectids)->where('owner_contact_no','!=',null)->pluck('owner_contact_no')->toarray();
           

           $merge = array_merge($procurement,$siteeng, $contractor,$consultant,$owner);
        
           $filtered = array_unique($merge);
           $unique = array_combine(range(1,count($filtered)), array_values($filtered));
            
           for($ss=1;$ss<count($unique);$ss++){
             DB::insert('insert into numbers (number) values(?)',[$unique[$ss] ]);
            
           }
           $count = count($unique);
        }else{
            return "NO Numbers assigned";
        }

       return back();
    }


  public function smstonumber1(Request $request)
    {
        if(!$request->stage ){
            $stages =null;
        }else{
            $stages = $request->stage;
        }

  $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();

         $projectids = new Collection();
         $orders = Order::where('status','Order Confirmed')->pluck('project_id');
        
         if($stages != null){
             $projectids = ProjectDetails::
             whereIn('project_status',$stages)
             ->where('quality','!=','Fake')
             ->whereNotIn('project_id',$orders)
             ->pluck('project_id'); 
         }else{
            $projectids = null;
         }     
    if($projectids != null){

           //fetch phonee numbers//
            $procurement =ProcurementDetails::whereIn('project_id',$projectids)->where('procurement_contact_no','!=',null)->pluck('procurement_contact_no')->toarray();
          
           
            $siteeng =SiteEngineerDetails::whereIn('project_id',$projectids)->where('site_engineer_contact_no','!=',null)->pluck('site_engineer_contact_no')->toarray();
         
            $contractor =ContractorDetails::whereIn('project_id',$projectids)->where('contractor_contact_no','!=',null)->pluck('contractor_contact_no')->toarray();
         
            $consultant =ConsultantDetails::whereIn('project_id',$projectids)->where('consultant_contact_no','!=',null)->pluck('consultant_contact_no')->toarray();
           
            $owner =OwnerDetails::whereIn('project_id',$projectids)->where('owner_contact_no','!=',null)->pluck('owner_contact_no')->toarray();
           

           $merge = array_merge($procurement,$siteeng, $contractor,$consultant,$owner);
        
           $filtered = array_unique($merge);
           $unique = array_combine(range(1,count($filtered)), array_values($filtered));
            
           for($ss=1;$ss<count($unique);$ss++){
             DB::insert('insert into numbers (number) values(?)',[$unique[$ss] ]);
            
           }
           $count = count($unique);
        }else{
            return "NO Numbers assigned";
        }

       return back();
    }

    public function projectsUpdate(Request $request)
    {   
        $assigndate =AssignStage::where('user_id',Auth::user()->id)
                     ->orderby('assigndate','DESC')->pluck('assigndate')->first();
        
         $rmc =AssignStage::where('user_id',Auth::user()->id)->pluck('rmc')->first();
         
         $project_type = AssignStage::where('user_id',Auth::user()->id)->pluck('project_type')->first();
         
         $projectSize = AssignStage::where('user_id',Auth::user()->id)->pluck('project_size')->first();
         
         $budget = AssignStage::where('user_id',Auth::user()->id)->pluck('budget')->first();

         $tlWard = AssignStage::where('user_id',Auth::user()->id)->pluck('ward')->first();

         $ward = Ward::where('ward_name',$tlWard)->pluck('id')->first();

         $assignedSubWards = SubWard::where('ward_id',$ward)->pluck('id');

         // dd($ward."<br>".$assignedSubWards);
        
        $subwards = AssignStage::where('user_id',Auth::user()->id)->pluck('subward')->first();

        $subwardNames = explode(", ", $subwards);
         
         if($subwards != "null"){
            $subwardid = Subward::whereIn('sub_ward_name',$subwardNames)->pluck('id')->toArray();
         }else{
            $subwardid = $assignedSubWards;
         }

         

        $bud = AssignStage::where('user_id',Auth::user()->id)->pluck('budget_type')->first();
        
        $lab = AssignStage::where('user_id',Auth::user()->id)->pluck('contract_type')->first();

        $constraction = AssignStage::where('user_id',Auth::user()->id)->pluck('constraction_type')->first();
         
        $ground = AssignStage::where('user_id',Auth::user()->id)->pluck('Floor')->first();
       
        $basement = AssignStage::where('user_id',Auth::user()->id)->pluck('basement')->first();
        
        $date =  AssignStage::where('user_id',Auth::user()->id)->pluck('assigndate')->first();
        
        $budgetto = AssignStage::where('user_id',Auth::user()->id)->pluck('budgetto')->first();
        
        $total = AssignStage::where('user_id',Auth::user()->id)->pluck('total')->first();
        
        $base1 = AssignStage::where('user_id',Auth::user()->id)->pluck('base')->first();
        
        $Floor2 = AssignStage::where('user_id',Auth::user()->id)->pluck('Floor2')->first();
        
        $projectsize1 = AssignStage::where('user_id',Auth::user()->id)->pluck('projectsize')->first();

        $quality = AssignStage::where('user_id',Auth::user()->id)->pluck('quality')->first();
        $roomtypes = RoomType::all();
        $projectids = new Collection();
        $projects = ProjectDetails::whereIn('sub_ward_id',$subwardid)->pluck('project_id');
        if(count($projects) > 0){
            $projectids = $projectids->merge($projects);
        }
        if(count($projectids) != 0){
            $budgettypes = ProjectDetails::whereIn('project_id',$projectids)->where('budgetType',"LIKE","%".$bud."%")->pluck('project_id');
        }else{
            $budgettypes = ProjectDetails::where('budgetType',"LIKE","%".$bud."%")->pluck('project_id');
        }
        if(count($budgettypes) != 0){
            $projectids = $budgettypes;
        }
        if($projectSize != null){
            $project_sizes = new Collection;
            if(count($projectids) != 0){
                $projectSize = floatval($projectSize);
                for($i = 0; $i < count($projectids); $i++){
                    $get_project = ProjectDetails::where('project_id',$projectids[$i])->first();
                    if(round($get_project->project_size) >= $projectSize && round($get_project->project_size) <= $projectsize1){
                        $project_sizes = $project_sizes->merge($get_project->project_id);
                    }
                }
            }else{
                $get_project = ProjectDetails::get();
                foreach($get_project as $project){
                    if(round($project->project_size) >= $projectSize && round($project->project_size) <= $projectsize1){
                        $project_sizes = $project_sizes->merge($project->project_id);
                    }
                }
                }
                if(count($project_sizes) != 0){
                    $projectids = $project_sizes;
                }
            }
            $contractInt = explode(",", $lab);
            if($contractInt[0] != "null"){
                if(count($projectids) != 0){
                    $labc = ProjectDetails::whereIn('project_id',$projectids)->where('contract',$contractInt)->pluck('project_id');
                }else{
                    $labc = ProjectDetails::where('contract',$contractInt)->pluck('project_id');
                }
                if(count($labc) != 0){
                    $projectids = $labc;
                }
            }
            if($ground != null){
                if(count($projectids) != 0){
                    $grd = ProjectDetails::whereIn('project_id',$projectids)->where('ground','<=',$ground  !=null ? $ground :0 )->where('ground','>=',$Floor2  !=null ? $Floor2 :0 )->pluck('project_id');
                }else{
                    $grd = ProjectDetails::where('ground','>=',$ground  !=null ? $ground :0 )->where('ground','<=',$Floor2  !=null ? $Floor2 :0 )->pluck('project_id');
                }
                if(Count($grd) > 0){
                    $projectids = $grd;
                }
            }
            if($basement != null){
                if(count($projectids) != 0){
                    $base = ProjectDetails::whereIn('project_id',$projectids)->where('basement', '<=',$basement !=null ? $basement :0 )->where('basement', '>=',$base1 !=null ? $base1 :0 )->pluck('project_id');
                }else{
                    $base = ProjectDetails::where('basement', '<=',$basement !=null ? $basement :0 )->where('basement', '>=',$base1 !=null ? $base1 :0 )->pluck('project_id');
                }
                if(Count($base) > 0){
                    $projectids = $base;
                }   
            }
            $stage = AssignStage::where('user_id',Auth::user()->id)->pluck('stage')->first(); 
            $stagec = explode(", ", $stage);
            $projectsat = new Collection;    
            if($stagec[0] != "null"){
                if(count($projectids) != 0){
                    for($i = 0; $i<count($stagec); $i++)
                    {
                        $projectsats = ProjectDetails::whereIn('project_id',$projectids)->where('project_status' ,'LIKE', "%".$stagec[$i]."%")->pluck('project_id');
                        $projectsat = $projectsat->merge($projectsats);
                    }                     
                }else{
                    for($i = 0; $i<count($stagec); $i++)
                    {
                        $projectsat = ProjectDetails::where('project_status' ,'LIKE', "%".$stagec[$i]."%")->pluck('project_id');
                    }
                }
                if(count($projectsat) != 0){
                    $projectids = $projectsat;            
                }
            }
            $sta = explode(", ", $constraction);
            if($sta[0] != "null"){
                if(count($projectids) != 0){
                    for($i=0;$i<count($sta);$i++){
                        
                        $cons =ProjectDetails::whereIn('project_id',$projectids)->where('construction_type','LIKE', "%".$sta[$i]."%")->pluck('project_id');
                    }
                }
                else{
                    for($i=0;$i<count($sta);$i++){
                        $cons =ProjectDetails::where('construction_type','LIKE', "%".$sta[$i]."%")->pluck('project_id');
                    }        
                }
                if(Count($cons) > 0){
                    $datec = ProjectDetails::where('created_at','LIKE' ,$date."%")->pluck('project_id');
                }
            }
            if($date != "NULL"){
                if(count($projectids) != 0){
                    $datec = ProjectDetails::whereIn('project_id',$projectids)->where('created_at','LIKE' ,$date."%")->pluck('project_id');
                }else{
                    $datec = ProjectDetails::where('created_at','LIKE' ,$date."%")->pluck('project_id');
                }
                if($datec != null){
                    $projectids = $datec;
                }
            }
            
            
            $rmcInt = explode(",", $rmc);
            if($rmcInt[0] != "null"){
                if(count($projectids) != 0){
                    $rmcs = ProjectDetails::whereIn('project_id',$projectids)->whereIn('interested_in_rmc',$rmcInt)->pluck('project_id');
                }else{
                    $rmcs = ProjectDetails::whereIn('interested_in_rmc',$rmcInt)->pluck('project_id');
                }
                if(count($rmcs) != 0){
                    $projectids = $rmcs;
                }
            }
            
            if(count($projectids) != 0){
                $project_types = ProjectDetails::whereIn('project_id',$projectids)->where('project_type', '>=',$project_type !=null ? $project_type :0 )->where('project_type', '<=',$total !=null ? $total :0 )->pluck('project_id');
            }else{
                $project_types = ProjectDetails::where('project_type', '>=',$project_type !=null ? $project_type :0 )->where('project_type', '<=',$total !=null ? $total :0 )->pluck('project_id');
            }
            if(count($project_types) != 0){
                $projectids = $project_types;
            }
            
            if($budget != null){
                if(count($projectids) != 0){
                    $budgets = ProjectDetails::whereIn('project_id',$projectids)->where('budget','>=',$budget != null ? $budget : 0 )->where('budget','<=',$budgetto != null ? $budgetto : 0 )->pluck('project_id');
                }else{
                    $budgets = ProjectDetails::where('budget','>=',$budget != null ? $budget : 0 )->where('budget','<=',$budgetto != null ? $budgetto : 0 )->pluck('project_id');
                }
                if(count($budgets) > 0){
                    $projectids = $budgets;
                }
            }
            
            if( $quality != null){
                if(count( $projectids) != 0){
                    $qua = ProjectDetails::whereIn('project_id',$projectids)->where('quality', $quality )->pluck('project_id');
                }else{
                    $qua = ProjectDetails::where('quality', $quality )->pluck('project_id');
                }
                
                if(count($qua) > 0){
                    $projectids = $qua;
                }
            }
       
        $checking = AssignStage::where('user_id',Auth::user()->id)->pluck('project_ids')->first();
        if($checking != null){
            $projectids = explode(", ",$checking);
        }else{
            if(is_array($projectids)){
                AssignStage::where('user_id',Auth::user()->id)->update(['project_ids'=>implode(", ",$projectids)]);
            }else{
                AssignStage::where('user_id',Auth::user()->id)->update(['project_ids'=>implode(", ",$projectids->toArray())]);
            }
        }
        $projectOrdersReceived = Order::whereIn('status',["Order Confirmed","Order Cancelled"])->pluck('project_id');
        $projects = ProjectDetails::whereIn('project_id',$projectids)
                    ->whereNotIn('project_id',$projectOrdersReceived)
                    // ->where('quality',"Unverified")
                    // ->Where('updated_at','LIKE',date('Y-m-d')."%")
                    ->select('project_details.*','project_id')
                    ->orderBy('project_id','ASC')
                    ->paginate(15);
                  
     $projectcount = ProjectDetails::whereIn('project_id',$projectids)->whereNotIn('project_id',$projectOrdersReceived)->count();
     $scount = ProjectDetails::whereIn('project_id',$projectids)->whereNotIn('project_id',$projectOrdersReceived)->count();
     //dd($scount);

        $requirements = array();
        foreach($projects as $project){
            $req = Requirement::where('project_id',$project->project_id)->pluck('id')->toArray(); 
            $pid = $project->project_id;
            array_push($requirements, [$pid,$req]);
        }
        $his = History::all();
        // $assigncount = new  AssignStage();
        $assigncount = AssignStage::where('user_id',Auth::user()->id)->first();
        if($assigncount != null){
            $assigncount->count = $scount;
            $assigncount->save();
        }
            
    
        $orders = Order::all();
       return view('salesengineer',[
                'projects'=>$projects,
                'roomtypes'=>$roomtypes,            
                'requirements' =>$requirements,
                'subwardid' => $subwardid,
                'his'=>$his,
                'orders' => $orders,
                'projectcount'=>$projectcount,
                
            ]);
    }

 public function dailywiseProjects(Request $request){
        $today = date('Y-m-d');
        $date = date('Y-m-d',strtotime('-1 day',strtotime($today)));
        $projectCount = ProjectDetails::where('created_at','like',$date.'%')->count();
         $projects = DB::table('project_details')
            ->rightjoin('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
            ->rightjoin('sub_wards', 'project_details.sub_ward_id', '=', 'sub_wards.id')
            ->rightjoin('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
            ->rightjoin('users','users.id','=','project_details.listing_engineer_id')
            ->rightjoin('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
            ->rightjoin('contractor_details','contractor_details.project_id','=','project_details.project_id')
            ->rightjoin('consultant_details','consultant_details.project_id','=','project_details.project_id')
            ->where('project_details.created_at','like',$date.'%')
            ->select('project_details.*', 'procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name','sub_wards.sub_ward_name')
            ->paginate(4);
             return view('dailywiseProjects', ['date' => $date,'today'=>$today,'projects'=> $projects,'projectCount'=>$projectCount]);
    }
    public function dailyslots(Request $request)
    {
        $totalListing = array();
        $date = date('Y-m-d');
        $users = User::where('department_id','1')->where('group_id','6')
                    ->leftjoin('ward_assignments','users.id','ward_assignments.user_id')
                    ->leftjoin('sub_wards','ward_assignments.subward_id','sub_wards.id')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();
         $accusers = User::where('department_id','2')->where('group_id','11')
                    ->leftjoin('ward_assignments','users.id','ward_assignments.user_id')
                    ->leftjoin('sub_wards','ward_assignments.subward_id','sub_wards.id')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();

        $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();

        $userIds = explode(",", $tl);
        $tlUsers = User::whereIn('id',$userIds)
            ->where('group_id',6)->simplePaginate();

         $tlUsers1 = User::whereIn('id',$userIds)
           ->where('group_id',11)->simplePaginate();


        $projects = ProjectDetails::where('created_at','like',$date[0].'%')->get();
        $groupid = [6,11];
        $le = DB::table('users')->whereIn('group_id',$groupid)->where('department_id','!=',10)->get();
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
            
            foreach($users as $user){
                $totalListing[$user->id] = ProjectDetails::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
            }
            foreach($tlUsers as $user){
                $totalListing[$user->id] = ProjectDetails::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
            }
            foreach($accusers as $user){
                $totalaccountlist[$user->id] = ProjectDetails::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
            }
             foreach($tlUsers1 as $user){
                $totalaccountlist[$user->id] = ProjectDetails::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
            }
            foreach($users as $user){
                $totalupdates[$user->id] = ProjectDetails::
                                                where('updated_at','LIKE',$date.'%')
                                                ->where('updated_by','=',$user->id)
                                                ->count();                                  
            }
            foreach($tlUsers as $user){
                $totalupdates[$user->id] = ProjectDetails::
                                                where('updated_at','LIKE',$date.'%')
                                                ->where('updated_by','=',$user->id)
                                                ->count();                                  
            }

            foreach($accusers as $user){
                $totalaccupdates[$user->id] = ProjectDetails::
                                                where('updated_at','LIKE',$date.'%')
                                                ->where('updated_by','=',$user->id)
                                                ->count();
            }
            foreach($tlUsers1 as $user){
                $totalaccupdates[$user->id] = ProjectDetails::
                                                where('updated_at','LIKE',$date.'%')
                                                ->where('updated_by','=',$user->id)
                                                ->count();
            }

        $projcount = count($projects);  
        return view('dailyslots', ['date' => $date,'users'=>$users,'accusers'=>$accusers, 'projcount' => $projcount, 'projects' => $projects, 'le' => $le, 'totalListing'=>$totalListing,'totalaccountlist'=>$totalaccountlist,'tlUsers'=>$tlUsers,'tlUsers1'=>$tlUsers1,'totalupdates'=>$totalupdates,'totalaccupdates'=>$totalaccupdates]);
    }
    public function getleinfo(Request $request)
    {
        $records = array();
        $id = $request->id;
        $from = $request->from;
        $to = $request->to;
        if($from == $to){
            return redirect('/gettodayleinfo?from='.$from.'&id='.$id.'&to='.$to);
        }
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
        $to = date('Y-m-d', strtotime($request->to));
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
                ->where('project_details.created_at','LIKE',$from."%")
                ->where('project_details.created_at','LIKE',$to."%")
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
                ->where('project_details.created_at','LIKE',$to."%")
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
    public function getProjectSize(Request $request)
    {
         $wards = Ward::all();
        $projects = ProjectDetails::where('deleted',0)->get();
        $qualityCheck = ['Genuine','Fake','Unverified'];

        // getting total no of projects
        $wardsselect = Ward::pluck('id');
        $subwards = SubWard::whereIn('ward_id',$wardsselect)->pluck('id');
        $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Planning%')->count();
        $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Planning%')->sum('project_size');
        $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Foundation%')->count();
        $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Foundation%')->sum('project_size');
        $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Roofing%')->count();
        $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Roofing%')->sum('project_size');
        $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Walls%')->count();
        $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Walls%')->sum('project_size');
        $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Completion%')->count();
        $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Completion%')->sum('project_size');
        $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Fixtures%')->count();
        $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Fixtures%')->sum('project_size');
        $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Pillars%')->count();
        $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Pillars%')->sum('project_size');
        $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Paintings%')->count();
        $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Paintings%')->sum('project_size');
        $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Flooring%')->count();
        $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Flooring%')->sum('project_size');
        $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plastering%')->count();
        $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plastering%')->sum('project_size');
        $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Digging%')->count();
        $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Digging%')->sum('project_size');
        $ele                = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Electrical%')->pluck('project_id');
        $plum               = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
        $ele                = $ele->merge($plum);

        $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
        $enpSize            = ProjectDetails::where('project_id',$ele)->sum('project_size');
        $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Carpentry%')->count();
        $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Carpentry%')->sum('project_size');
        $closedCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Closed%')->count();
        $closedSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Closed%')->sum('project_size');

        $totalProjects = $planningCount + $diggingCount + $foundationCount + $pillarsCount + $completionCount + $fixturesCount + $paintingCount + $carpentryCount + $flooringCount + $plasteringCount + $enpCount + $roofingCount + $wallsCount + $closedCount;
        
        if($request->ward && !$request->subward){
            if($request->ward == "All"){
                $planningCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
                $planningSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
                $foundationCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
                $foundationSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
                $roofingCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
                $roofingSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
                $wallsCount         = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
                $wallsSize          = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
                $completionCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
                $completionSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
                $fixturesCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
                $fixturesSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
                $pillarsCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
                $pillarsSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
                $paintingCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
                $paintingSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
                $flooringCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
                $flooringSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
                $plasteringCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
                $plasteringSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
                $diggingCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
                $diggingSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
                $ele                = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
                $plum               = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
                $ele                = $ele->merge($plum);
                $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
                $enpSize            = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');
                $carpentryCount     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
                $carpentrySize      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
                $closedCount        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
                $closedSize         = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');
                $wardname = "All";
                $subwards = SubWard::all();
            }else{
                $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
                $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
                $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
                $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
                $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
                $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
                $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
                $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
                $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
                $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
                $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
                $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
                $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
                $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
                $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
                $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
                $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
                $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
                $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
                $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
                $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
                $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
                $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
                $ele                = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
                $plum               = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
                $ele                = $ele->merge($plum);
                $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
                $enpSize            = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');

                $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
                $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
                $closedCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
                $closedSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');
                $wardname = Ward::where('id',$request->ward)->first();
                $subwards = SubWard::where('ward_id',$request->ward)->get();
            }
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
                'closedSize'=>$closedSize,'closedCount'=>$closedCount,
                'wards'=>$wards,
                'wardname'=>$wardname,
                'subwards'=>$subwards,'wardId'=>$request->ward,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects
            ]);
        }
        if($request->subward){
            $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
            $subwardQuality = ['Genuine','Fake','Unverified'];
            $planningCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
            $planningSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
            $foundationCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
            $foundationSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
            $roofingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
            $roofingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
            $wallsCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
            $wallsSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
            $completionCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
            $completionSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
            $fixturesCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
            $fixturesSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
            $pillarsCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
            $pillarsSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
            $paintingCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
            $paintingSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
            $flooringCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
            $flooringSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
            $plasteringCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
            $plasteringSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
            $diggingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
            $diggingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
            $ele               = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
            $plum              = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
            $ele               = $ele->merge($plum);
            $enpCount          = ProjectDetails::whereIn('project_id',$ele)->count();
            $enpSize           = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');
            $carpentryCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
            $carpentrySize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
            $closedCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
            $closedSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');

            $wardname = Ward::where('id',$request->ward)->first();
            $subwards = SubWard::where('ward_id',$request->ward)->get();
            $total = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->count();
            $planning   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Planning%')->sum('project_size');
            $foundation = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Foundation%')->sum('project_size');
            $roofing    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Roofing%')->sum('project_size');
            $walls      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Walls%')->sum('project_size');
            $completion = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Completion%')->sum('project_size');
            $fixtures   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Fixtures%')->sum('project_size');
            $pillars    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Pillars%')->sum('project_size');
            $painting   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Paintings%')->sum('project_size');
            $flooring   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Flooring%')->sum('project_size');
            $plastering = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Plastering%')->sum('project_size');
            $digging    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Digging%')->sum('project_size');
            $ele2        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->where('sub_ward_id',$request->subward)->pluck('project_id');
            $plum2       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->where('sub_ward_id',$request->subward)->pluck('project_id');
            $ele2        = $ele2->merge($plum2);
            $enp    = ProjectDetails::whereIn('project_id',$ele2)->sum('project_size');
            $carpentry  = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Carpentry%')->sum('project_size');
            $closed     = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Closed%')->sum('project_size');
            
            $Cplanning      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Planning%')->count();
            $Cfoundation    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Foundation%')->count();
            $Croofing       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Roofing%')->count();
            $Cwalls         = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Walls%')->count();
            $Ccompletion    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Completion%')->count();
            $Cfixtures      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Fixtures%')->count();
            $Cpillars       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Pillars%')->count();
            $Cpainting      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Paintings%')->count();
            $Cflooring      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Flooring%')->count();
            $Cplastering    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Plastering%')->count();
            $Cdigging       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Digging%')->count();
            $Cenp   = ProjectDetails::whereIn('project_id',$ele2)->count();
            // $Cenp           = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Electrical%')
            //                     ->orWhere('project_status','LIKE','Plumbing%')->count();
            $Ccarpentry     = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Carpentry%')->count();
            $Cclosed        = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Closed%')->count();
            
            $subwardname = SubWard::where('id',$request->subward)->pluck('sub_ward_name')->first();
            $totalsubward = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->sum('project_size');
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
                'closedSize'=>$closedSize,'closedCount'=>$closedCount,
                'wards'=>$wards,'wardname'=>$wardname,
                'subwards'=>$subwards,'wardId'=>$request->ward,
                'totalProjects' => $totalProjects,
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
                'Cplanning'=>$Cplanning,
                'Cfoundation'=>$Cfoundation,
                'Croofing'=>$Croofing,
                'Cwalls'=>$Cwalls,
                'Ccompletion'=>$Ccompletion,
                'Cfixtures'=>$Cfixtures,
                'Cpillars'=>$Cpillars,
                'Cpainting'=>$Cpainting,
                'Cflooring'=>$Cflooring,
                'Cplastering'=>$Cplastering,
                'Cdigging'=>$Cdigging,
                'Cenp'=>$Cenp,
                'Ccarpentry'=>$Ccarpentry,
                'closed'=>$closed,
                'Cclosed'=>$Cclosed,
                'subwardId'=>$request->subward,
                'subwardName'=>$subwardname,
                'total'=>$total,
                'totalsubward'=>$totalsubward
            ]);
        }
        return view('projectSize',['wards'=>$wards,'planningCount'=>NULL,'subwards'=>NULL,'wardId'=>NULL,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects]);
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
                    ->orderby('date')
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
    public function updateAdminAssignment(){
        salesassignment::where('user_id',Auth::user()->id)->delete();
        return redirect('/leDashboard');
    }
    public function viewDailyReport($uId, $date){
        $reports = Report::where('empId',$uId)->where('created_at','like',$date.'%')->get();
        $user = User::where('employeeId',$uId)->first();
        $attendance = attendance::where('empId',$uId)->where('date',$date)->first();
        $points_earned_so_far = Point::where('user_id',$user->id)->where('confirmation',1)->where('created_at','LIKE',$date."%")->where('type','Add')->sum('point');
        $points_subtracted = Point::where('user_id',$user->id)->where('confirmation',1)->where('created_at','LIKE',$date."%")->where('type','Subtract')->sum('point');
        $points_indetail = Point::where('user_id',$user->id)->where('confirmation',1)->where('created_at','LIKE',$date."%")->get();
        $total = $points_earned_so_far - $points_subtracted;
        return view('viewdailyreport',[
            'reports'=>$reports,
            'date'=>$date,
            'user'=>$user,
            'attendance'=>$attendance,
            'points_indetail'=>$points_indetail,
            'points_earned_so_far'=>$points_earned_so_far,
            'points_subtracted'=>$points_subtracted,
            'total'=>$total
        ]);
    }
    // public function followup_projects(Request $request){


    //     $today = date('Y-m-d');
    //     $projects = Requirement::where('follow_up',$today)
    //     ->leftjoin('users','users.id','=','requirements.generated_by')
    //                 ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')     
    //                 ->leftjoin('owner_details','owner_details.project_id','=','requirements.project_id')
    //                 ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
    //                 ->leftjoin('site_engineer_details','site_engineer_details.project_id','=','requirements.project_id')
    //                 ->leftjoin('consultant_details','consultant_details.project_id','=','requirements.project_id')
    //      ->get( );
    //      $from = $request->from;
    //     $to = $request->to;
    //   if($request->from && $request->to){
    //      $projects = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
    //                 ->leftjoin('project_details','project_details.project_id','=','requirements.project_id') 
    //                  ->where('requirements.created_at','>',$from)
    //                  ->where('requirements.created_at','<=',$to) 
    //                  ->where('follow_up', '!=', null)   
    //                 ->leftjoin('owner_details','owner_details.project_id','=','requirements.project_id')
    //                 ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
    //                 ->leftjoin('site_engineer_details','site_engineer_details.project_id','=','requirements.project_id')
    //                 ->leftjoin('consultant_details','consultant_details.project_id','=','requirements.project_id')
    //                 ->get();

    //   }
    //     return view('followupproject',['projects'=>$projects]);
    // }

    public function followup(Request $request){
        $today = date('Y-m-d');
        $from = $request->from;
        $to = $request->to;

        


                            
                      if($request->from && $request->to)
                      {
                            $from = $request->from;
                            $to = $request->to;  
                            if($from == $to)
                             {   
                                    $projects = ProjectDetails::
                                    where('follow_up_by',Auth::user()->id)
                                    ->where('follow_up_date','>=',$from)
                                    ->where('follow_up_date','<=',$to) 
                                     ->paginate(10);
                             }
                             else{

                                    $projects = ProjectDetails::
                                    where('follow_up_by',Auth::user()->id)
                                    ->where('follow_up_date','>=',$from)
                                    ->where('follow_up_date','<=',$to) 
                                     ->paginate(10);


                             }
                            

                      }

                      else
                      {
                                $projects = ProjectDetails::where('follow_up_date','LIKE',$today."%")
                                ->where('follow_up_by',Auth::user()->id)
                            
                                ->paginate(10);

                      }
     
    return view('followup',['projects'=>$projects]);
    }
    public function confirmedProject(Request $request){

           $check = ProjectDetails::where('project_id',$request->id)->first();
           $project_id = ProjectDetails::where('project_id',$request->id)->pluck('project_id')->first();
           $user_id = User::where('id',Auth::user()->id)->pluck('id')->first();
           $username = User::where('name',Auth::user()->name)->pluck('name')->first();
           $call  =  ProjectDetails::where('project_id',$request->id)->pluck('updated_at')->first();
           
    DB::insert('insert into history (user_id,project_id,called_Time,username) values(?,?,?,?)',[$user_id,$project_id,$call,$username]);
       
        
        if($check->confirmed == null || $check->confirmed == "true" || $check->confirmed == "false"){
            ProjectDetails::where('project_id',$request->id)->update(['confirmed'=>1]);
        }else{
            projectDetails::where('project_id',$request->id)

           ->increment('confirmed');
        }

        return redirect()->back();
    }
    public function projectadmin(Request $id){

        $details = projectDetails::where('project_id',$id->projectId)->first();
       $check =projectDetails::where('project_id',Auth::user()->name)
                    ->orderby('created_at','DESC')->pluck('project_id')->first();
        $roomtypes = RoomType::where('project_id',$id->projectId)->get();
        $followupby = User::where('id',$details->follow_up_by)->first();
        $callAttendedBy = User::where('id',$details->call_attended_by)->first();
        $listedby = User::where('id',$details->listing_engineer_id)->first();
        $subward = SubWard::where('id',$details->sub_ward_id)->pluck('sub_ward_name')->first();

        return view('viewDailyProjects',[
                'details'=>$details,
                'roomtypes'=>$roomtypes,
                'followupby'=>$followupby,
                'callAttendedBy'=>$callAttendedBy,
                'listedby'=>$listedby,
                'subward'=>$subward,
                'check'=>$check
            ]);
    }
     public function projectadmin1(Request $id){
        $details = projectDetails::where('project_id',$id->projectId)->first();
        $roomtypes = RoomType::where('project_id',$id->projectId)->get();
        $followupby = User::where('id',$details->follow_up_by)->first();
        $callAttendedBy = User::where('id',$details->call_attended_by)->first();
        $listedby = User::where('id',$details->listing_engineer_id)->first();
        $subward = SubWard::where('id',$details->sub_ward_id)->pluck('sub_ward_name')->first();
        return view('viewDailyProjects1',[
                'details'=>$details,
                'roomtypes'=>$roomtypes,
                'followupby'=>$followupby,
                'callAttendedBy'=>$callAttendedBy,
                'listedby'=>$listedby,
                'subward'=>$subward
            ]);
    }
    public function editEmployee(Request $request){
        $user = User::where('employeeId', $request->UserId)->first();
        $employeeDetails = EmployeeDetails::where('employee_id',$request->UserId)->first();
        $bankDetails = BankDetails::where('employeeId',$request->UserId)->first();
        $assets = Asset::all();
        $assetInfos = AssetInfo::where('employeeId',$request->UserId)->get();
        $certificates = Certificate::where('employeeId',$request->UserId)->get();
        return view('editEmployee',['user'=>$user,'employeeDetails'=>$employeeDetails,'bankDetails'=>$bankDetails,'assets'=>$assets,'assetInfos'=>$assetInfos,'certificates'=>$certificates]);
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
        if($request->userid){
            User::where('employeeId',$request->userid)->update(['profilepic'=>$imageName1]);
            return back()->with('Success','Profile picture added successfully');
        }else{
            User::where('id',Auth::user()->id)->update(['profilepic'=>$imageName1]);
            return redirect('/home')->with('Success','Profile picture added successfully');
        }
    }
    public function getMhOrders(Request $request){
        $invoices = MhInvoice::leftJoin('requirements','mh_invoice.requirement_id','=','requirements.id')->get();
      $details =MhInvoice::where('project_id',$request->phNo)->orwhere('invoice_number',$request->phNo)->get();
        return view('mhOrders',['invoices'=>$invoices,'details'=>$details]);
    }
    public function getAnR(){
        $departments = Department::all();
        $groups = Group::all();
        return view('anr',['departments'=>$departments,'groups'=>$groups,'page'=>"anr"]);
    }
    public function getCheck(Request $request)
    { 
        $lists = Checklist::all();
        return view('getCheck',['lists'=>$lists]);
    }
    public function trainingVideo(Request $request)
    { 
        $titles = training::all();
        $depts = Department::all();
        $grps = Group::all();
        if(!$request->dept){
            return view('trainingVideo',['depts'=>$depts,'grps'=>$grps,'videos'=>"none",'titles'=>$titles]);
        }else{
            $videos = training::where('dept',$request->dept)
                        ->where('designation',$request->designation)
                        ->get();
            return view('trainingVideo',['depts'=>$depts,'grps'=>$grps,'videos'=>$videos,'titles'=>$titles]);
        }
    }
    public function uploadfile(Request $request){
        $extension = request()->upload->getClientOriginalExtension();
        $files = time().'.'.strtoupper($extension);
        $request->upload->move(public_path('hrfiles'),$files);
        $list = New Checklist;
        $list->id=$request->id;
        $list->name= $request->name;
        $list->upload= $files;
        $list->save();
        return back();

    }
     public function uploadvideo(Request $request){

       $vedio = time().'.'.request()->upload->getClientOriginalExtension();
        $request->upload->move(public_path('trainingvideo'),$vedio);
        $train = New training;
        $train->dept=$request->dept;
        $train->designation= $request->designation;
        $train->upload= $vedio;
        $train->remark= $request->remark;
        $train->save();
        return back();

    }
    public function deletelist(Request $id)
    {
    
        Checklist::where('id',$id->id)->delete();
        return back();
    }
    public function deleteentry(Request $id)
    {
    
        training::where('id',$id->id)->delete();
        return back();
    }

    
    public function getSalesStatistics(){
        $notProcessed = Requirement::where('status',"Not Processed")->count();
        $initiate = Requirement::where('status',"Order Initiated")->count();
        $confirmed = Requirement::where('status',"Order Confirmed")->count();
        $placed = Requirement::where('status',"Order Placed")->count();
        $cancelled = Requirement::where('status',"Order cancelled")->count();
        $genuine = ProjectDetails::where('quality',"GENUINE")->where('deleted',0)->count();
        $fake = ProjectDetails::where('quality',"FAKE")->where('deleted',0)->count();
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
        $projects = ProjectDetails::where('quality','Genuine')->where('project_status','Walls')->paginate(10);
        $projectscount = ProjectDetails::where('quality','Genuine')->count();
        return view('salesengineer',['projects'=>$projects,'subwards'=>$assignment,'projectscount'=>$projectscount,'links'=>$subward]);
    }
    public function activityLog()
    {
        $activities = ActivityLog::orderby('time','DESC')->get();
        return view('activitylog',['activities'=>$activities]);
    }
    public function eqpipeline(Request $request)
    {
      
                $category = Category::all();
                $today = date('Y-m-d');
               if(!$request){
                    $pipelines = Requirement::where('requirements.generated_by',Auth::user()->id)
                                    ->leftjoin('procurement_details','requirements.project_id','procurement_details.project_id')
                                    ->where('requirements.status','!=',"Enquiry Cancelled")
                                    ->select('requirements.*','procurement_details.procurement_contact_no','procurement_details.procurement_name')
                                    ->get();
                               

                 }
             elseif($request->eqpipeline == 'today'){

                 $pipelines = Requirement::where('requirements.generated_by',Auth::user()->id)
                ->leftjoin('procurement_details','requirements.project_id','procurement_details.project_id')
                ->where('requirements.status','!=',"Enquiry Cancelled" )
                ->where('requirements.created_at','LIKE',$today."%")    
                ->select('requirements.*','procurement_details.procurement_contact_no','procurement_details.procurement_name')
                ->get() ;

               
             }
             elseif($request->category)
             { 
                
                $pipelines = Requirement::where('requirements.generated_by',Auth::user()->id)
                ->leftjoin('procurement_details','requirements.project_id','procurement_details.project_id')
                ->where('requirements.status','!=',"Enquiry Cancelled" )
                ->where('requirements.main_category',$request->category)
                ->select('requirements.*','procurement_details.procurement_contact_no','procurement_details.procurement_name')
                ->get() ;
             }
             else
            {           
                $pipelines = Requirement::where('requirements.generated_by',Auth::user()->id)
                ->leftjoin('procurement_details','requirements.project_id','procurement_details.project_id')
                ->where('requirements.status','!=',"Enquiry Cancelled")        
                ->select('requirements.*','procurement_details.procurement_contact_no','procurement_details.procurement_name')
                ->get() ;


            }
                       
        $subwards2 = array();
        foreach($pipelines as $enquiry){

            $pId = ProjectDetails::where('project_id',$enquiry->project_id)->first();
            $subwards2[$enquiry->project_id] = SubWard::where('id',$pId->sub_ward_id)->pluck('sub_ward_name')->first();
        }
        return view('eqpipeline',['pipelines'=>$pipelines,'subwards2'=>$subwards2,'category'=>$category]);
    }
    public function letraining(Request $request)
    {
         $depts = Department::all();
        $grps = Group::all();
        $users = User::all();
        $videos = training::where('dept',"1")
                        ->where('designation',"6")
                        ->get();
        foreach($videos as $video){
            if($video->viewed_by == "none"){
                $video->viewed_by = Auth::user()->id;
                $video->save();
            }else{
                $newList = $video->viewed_by.", ".Auth::user()->id;
                $video->viewed_by = $newList;
                $video->save();
            }
        }
        return view('letraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps,'users'=>$users]);
    
    }
    public function setraining(Request $request)
        {
            $depts = Department::all();
            $grps = Group::all();
            $videos = training::where('dept',"2")
                            ->where('designation',"7")
                            ->get();
            foreach($videos as $video){
                if($video->viewed_by == "none"){
                    $video->viewed_by = Auth::user()->id;
                    $video->save();
                }else{
                    $newList = $video->viewed_by.", ".Auth::user()->id;
                    $video->viewed_by = $newList;
                    $video->save();
                }
            }
        return view('setraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps]);
    }
    public function asttraining(Request $request)
    {
        $depts = Department::all();
        $grps = Group::all();
        $videos = training::where('dept',"5")
                        ->where('designation',"4")
                        ->get();
        foreach($videos as $video){
            if($video->viewed_by == "none"){
                $video->viewed_by = Auth::user()->id;
                $video->save();
            }else{
                $newList = $video->viewed_by.", ".Auth::user()->id;
                $video->viewed_by = $newList;
                $video->save();
            }
        }
        return view('asttraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps]);
    }
    public function adtraining(Request $request)
    {
        $depts = Department::all();
        $grps = Group::all();
        $videos = training::where('dept',"5")
                        ->where('designation',"3")
                        ->get();
        foreach($videos as $video){
            if($video->viewed_by == "none"){
                $video->viewed_by = Auth::user()->id;
                $video->save();
            }else{
                $newList = $video->viewed_by.", ".Auth::user()->id;
                $video->viewed_by = $newList;
                $video->save();
            }
        }
        return view('adtraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps]);
    }
    public function tltraining(Request $request)
    {
        $depts = Department::all();
        $grps = Group::all();
        $videos = training::where('dept',"1")
                        ->where('designation',"2")
                        ->get();
        foreach($videos as $video){
            if($video->viewed_by == "none"){
                $video->viewed_by = Auth::user()->id;
                $video->save();
            }else{
                $newList = $video->viewed_by.", ".Auth::user()->id;
                $video->viewed_by = $newList;
                $video->save();
            }
        }
        return view('tltraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps]);   
    }
    public function employeereports(Request $request)
    {
        $depts = [1,2,3,4,5,6];
        $users = User::whereIn('department_id',$depts)->where('name','NOT LIKE','%test%')->orderBy('department_id','ASC')->get();
        if($request->month){
            $year = $request->year;
            $month = ($request->month < 10 ? "0".$request->month : $request->month);
            $today = $year."-".$month;
            $text = "";
        }else{
            $today = date('Y-m');
            $text = "";
            $year = date('Y');
            $month = date('m');
        }
        $ofdays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        foreach($users as $user){
            $count = 0;
            $text .= "<tr><td>".$user->employeeId."</td><td>".$user->name."<br>(".($user->Group != null ? $user->Group->group_name: '').")</td>";
            for($i = 1;$i<=$ofdays;$i++){
                if($i < 10){
                    $date = $today."-0".$i;
                }else{
                    $date = $today."-".$i;
                }
                if($user->group_id == "6"){
                    $att = loginTime::where('user_id',$user->id)->where('logindate',$date)->first();
                    if($att == null){
                        $text .= "<td style='background-color:rgba(999,111,021,0.3); color:black;'>Leave</td>";
                    }else{
                        $text .= "<td style='background-color:green; color:white;'>".$att->loginTime."<br>".$att->logoutTime."</td>";
                        $count++;
                    }
                }else{
                    $att = attendance::where('empId',$user->employeeId)->where('date',$date)->first();
                    if($att == null){
                        $text .= "<td style='background-color:rgba(999,111,021,0.3); color:black;'>Leave</td>";
                    }else{
                        $text .= "<td style='background-color:green; color:white;'>".$att->inTIme."<br>".$att->outTime."</td>";
                        $count++;
                    }
                }
            }
            $text .= "<td>".$count."</td></tr>";
        }
        return view('employeereports',['text'=>$text]);
    }
    public function getAddress(Request $request)
    {
        $address = SiteAddress::where('project_id',$request->projectId)->first();
        return response()->json($address);   
    }
    public function viewallProjects(Request $request)
    {
        $details = array();
        $wards = Ward::all();
        $users = User::all();
        $ids = array();
        if($request->phNo )
        {
            $details[0] = ContractorDetails::where('contractor_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[1] = ProcurementDetails::where('procurement_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[2] = SiteEngineerDetails::where('site_engineer_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[3] = ConsultantDetails::where('consultant_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[4] = OwnerDetails::where('owner_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
             $details[5] = ProjectDetails::where('project_id',$request->phno)->orwhere('project_id',$request->phNo)->pluck('project_id');
            for($i = 0; $i < count($details); $i++){
                for($j = 0; $j<count($details[$i]); $j++){
                    array_push($ids, $details[$i][$j]);
                }
            }
            $projects = ProjectDetails::whereIn('project_details.project_id',$ids)
                            ->leftjoin('users','users.id','=','project_details.listing_engineer_id')
                            ->leftjoin('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                            ->leftjoin('site_addresses','site_addresses.project_id','=','project_details.project_id')
                            ->select('project_details.*','users.name','sub_wards.sub_ward_name','site_addresses.address')
                            ->where('deleted',0)
                            ->get();
            return view('viewallprojects',['projects'=>$projects,'wards'=>$wards,'users'=>$users]);
        }
        if($request->subward && $request->ward){
            $projects = ProjectDetails::where('project_details.sub_ward_id',$request->subward)
                            ->leftjoin('users','users.id','=','project_details.listing_engineer_id')
                            ->leftjoin('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                            ->leftjoin('site_addresses','site_addresses.project_id','=','project_details.project_id')
                            ->select('project_details.*','users.name','sub_wards.sub_ward_name','site_addresses.address')
                            ->where('deleted',0)
                            ->get();
        }elseif(!$request->subward && $request->ward){
            if($request->ward == "All"){
            $projects = ProjectDetails::leftjoin('users','users.id','=','project_details.listing_engineer_id')
                            ->leftjoin('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                            ->leftjoin('site_addresses','site_addresses.project_id','=','project_details.project_id')
                            ->select('project_details.*','users.name','sub_wards.sub_ward_name','site_addresses.address')
                            ->where('deleted',0)
                            ->get();
            }
            else{
                 $subwards = SubWard::where('ward_id',$request->ward)->get()->pluck('id');
            $projects = ProjectDetails::whereIn('project_details.sub_ward_id',$subwards)
                            ->leftjoin('users','users.id','=','project_details.listing_engineer_id')
                            ->leftjoin('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                            ->leftjoin('site_addresses','site_addresses.project_id','=','project_details.project_id')
                            ->select('project_details.*','users.name','sub_wards.sub_ward_name','site_addresses.address')
                            ->where('deleted',0)
                            ->get();
            }
        }
        else{
            $projects = "None";
        }
        return view('viewallprojects',['projects'=>$projects,'wards'=>$wards,'users'=>$users]);
    }



    public function projectDetailsForTL(Request $request)
    {
        $details = array();
        $wards = Ward::all();
        $users = User::all();
        $ids = array();
$tl= Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
        if($request->phNo){
            $details[0] = ContractorDetails::where('contractor_contact_no',$request->phNo )->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[1] = ProcurementDetails::where('procurement_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[2] = SiteEngineerDetails::where('site_engineer_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[3] = ConsultantDetails::where('consultant_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[4] = OwnerDetails::where('owner_contact_no',$request->phNo)->orwhere('project_id',$request->phNo)->pluck('project_id');
            $details[5] = ProjectDetails::where('project_id',$request->phno)->get();
            for($i = 0; $i < count($details); $i++){
                for($j = 0; $j<count($details[$i]); $j++){
                    array_push($ids, $details[$i][$j]);
                }

            }
            if(Auth::user()->group_id != 22){
            $projects = ProjectDetails::whereIn('project_details.project_id',$ids)->where('deleted',0)
                            ->leftjoin('users','users.id','=','project_details.listing_engineer_id')
                            ->leftjoin('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                            ->leftjoin('site_addresses','site_addresses.project_id','=','project_details.project_id')
                            ->select('project_details.*','users.name','sub_wards.sub_ward_name','site_addresses.address')
                            ->where('deleted',0)
                            ->get();
            }else{
                 $projects = ProjectDetails::whereIn('project_details.project_id',$ids)->where('deleted',0)
                            ->leftjoin('users','users.id','=','project_details.listing_engineer_id')
                            ->leftjoin('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                            ->leftjoin('wards','wards.id','sub_wards.ward_id')
                            ->where('wards.id',$tl)
                            ->leftjoin('site_addresses','site_addresses.project_id','=','project_details.project_id')
                            ->select('project_details.*','users.name','sub_wards.sub_ward_name','site_addresses.address')
                            ->where('deleted',0)
                            ->get();
            }

            $projectdetails = ProjectDetails::whereIn('project_id',$ids)->pluck('updated_by');
            $updater = User::whereIn('id',$projectdetails)->first();
           

            return view('viewallprojects',['wards'=>$wards,'users'=>$users,'projects'=>$projects,'wards'=>$wards,'users'=>$users,'updater'=>$updater]);
        }else{
            return view('viewallprojects',['wards'=>$wards,'users'=>$users,'projects'=>"None"]);
        }
    }
    
    public function deleteRoomType(Request $request)
    {
        RoomType::findOrFail($request->roomId)->delete();
        return back()->with('Success','Room type deleted');
    }
    public function salesreports(Request $request)
    {
        if($request->se == "ALL" && $request->fromdate && !$request->todate){
            $date = $request->fromdate;
            $str = ActivityLog::where('time','LIKE',$date.'%')->where('activity','LIKE','%Updated a project%')->get();
        }elseif($request->se != "ALL" && $request->fromdate && !$request->todate){
            $date = $request->fromdate;
            $str = ActivityLog::where('time','LIKE',$request->fromdate.'%')
                    ->where('employee_id',$request->se)
                    ->where('activity','LIKE','%Updated a project%')->get();
        }elseif($request->se == "ALL" && $request->fromdate && $request->todate){
            $date = $request->fromdate;
            $from= $request->fromdate;
            $to= $request->todate;
            if($from == $to){
                 $str = ActivityLog::where('time','like',$from.'%')
                ->where('time','LIKE',$to."%")
                ->where('activity','LIKE','%Updated a project%')->get();
            }
            else{
            $str = ActivityLog::where('time','>',$request->fromdate)
                    ->where('time','<',$request->todate)
                    ->where('activity','LIKE','%Updated a project%')->get();
            }
        }elseif($request->se != "ALL" && $request->fromdate && $request->todate){

            $date = $request->fromdate;
            $from= $request->fromdate;
            $to= $request->todate;
            if($from == $to){
              
            $str = ActivityLog::where('time','like',$from.'%')
                ->where('time','LIKE',$to."%")
                ->where('employee_id',$request->se)
                ->where('activity','LIKE','%Updated a project%')->get();
            }
            else{
            $str = ActivityLog::where('time','>',$request->fromdate)
                    ->where('time','<',$request->todate)
                    ->where('employee_id',$request->se)
                    ->where('activity','LIKE','%Updated a project%')->get();
            }
        }else{
            $date = date('Y-m-d');
            $str = ActivityLog::where('time','LIKE',$date.'%')->where('activity','LIKE','%Updated a project%')->get();
        }
        $today = date('Y-m-d');
        $exploded = array();
        $projectIds = array();
        foreach($str as $strings){
            array_push($exploded,explode(" ",$strings->activity));
        }

        for($i = 0;$i<count($exploded);$i++){
            $key = array_search("id:", $exploded[$i]);
            $name = array_search("has", $exploded[$i]);
            $quality = array_search("Quality:", $exploded[$i]);
            $projectIds[$i]['projectId'] = $exploded[$i][$key+1];
            if($name == 3){
                $projectIds[$i]['updater'] = $exploded[$i][$name-3]." ".$exploded[$i][$name-2]." ".$exploded[$i][$name-1];
            }elseif($name == 2){
                $projectIds[$i]['updater'] = $exploded[$i][$name-2]." ".$exploded[$i][$name-1];
            }else{
                $projectIds[$i]['updater'] = $exploded[$i][$name-1];
            }

            $project = ProjectDetails::where('project_id',$projectIds[$i]['projectId'])->first();
          
            if($project != null){
                $projectIds[$i]['quality'] = $project->quality;
                $projectIds[$i]['followup'] = $project->followup;
                $projectIds[$i]['followupby'] = User::where('id',$project->follow_up_by)->pluck('name')->first();
                $projectIds[$i]['caller'] = User::where('id',$project->call_attended_by)->pluck('name')->first();
                $projectIds[$i]['sub_ward_name'] = SubWard::where('id',$project->sub_ward_id)->pluck('sub_ward_name')->first();
                $projectIds[$i]['enquiryInitiated'] = Requirement::where('project_id',$projectIds[$i]['projectId'])->count();
                $projectIds[$i]['enquiryInitiatedBy'] = Requirement::where('requirements.project_id',$projectIds[$i]['projectId'])
                                                            ->leftjoin('users','requirements.generated_by','users.id')
                                                            ->select('users.name','requirements.id')
                                                            ->get();
            }else{
                $projectIds[$i]['quality'] = "";
                $projectIds[$i]['followup'] = "";
                $projectIds[$i]['followupby'] = "";
                $projectIds[$i]['caller'] = "";
                $projectIds[$i]['sub_ward_name'] = "";
                $projectIds[$i]['enquiryInitiated'] = "";
                $projectIds[$i]['enquiryInitiatedBy'] = "";
           }
            
        }
        $noOfCalls = array();
        $users = User::where('department_id',2)
                    ->leftjoin('salesassignments','salesassignments.user_id','users.id')
                    ->leftJoin('sub_wards','sub_wards.id','salesassignments.assigned_date')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();
             $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
             $userIds = explode(",", $tl);
             
             $tluser =User::whereIn('users.id',$userIds)
                    ->where('users.group_id',7)
                    ->leftjoin('salesassignments','salesassignments.user_id','users.id')
                    ->leftJoin('sub_wards','sub_wards.id','salesassignments.assigned_date')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();


      foreach($tluser as $user){
            $noOfCalls[$user->id]['calls'] = ProjectDetails::where('updated_at','LIKE',$today.'%')
                                        ->where('call_attended_by',$user->id)
                                        ->count();
            $noOfCalls[$user->id]['fake'] = ActivityLog::where('time','LIKE',$today.'%')
                                        ->where('employee_id',$user->employeeId)
                                        ->where('activity','LIKE','%Quality: Fake%')
                                        ->count();
            $noOfCalls[$user->id]['genuine'] = ActivityLog::where('time','LIKE',$today.'%')
                                        ->where('employee_id',$user->employeeId)
                                        ->where('activity','LIKE','%Quality: Genuine%')
                                        ->count();
            $noOfCalls[$user->id]['initiated'] = Requirement::where('created_at','LIKE',$today.'%')
                                                    ->where('generated_by',$user->id)
                                                    ->count();
        }


        foreach($users as $user){
            $noOfCalls[$user->id]['calls'] = ProjectDetails::where('updated_at','LIKE',$today.'%')
                                        ->where('call_attended_by',$user->id)
                                        ->count();
            $noOfCalls[$user->id]['fake'] = ActivityLog::where('time','LIKE',$today.'%')
                                        ->where('employee_id',$user->employeeId)
                                        ->where('activity','LIKE','%Quality: Fake%')
                                        ->count();
            $noOfCalls[$user->id]['genuine'] = ActivityLog::where('time','LIKE',$today.'%')
                                        ->where('employee_id',$user->employeeId)
                                        ->where('activity','LIKE','%Quality: Genuine%')
                                        ->count();
            $noOfCalls[$user->id]['initiated'] = Requirement::where('created_at','LIKE',$today.'%')
                                                    ->where('generated_by',$user->id)
                                                    ->count();
        }
        $projectsCount = count($projectIds);
         
         $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
         $userIds = explode(",", $tl);
         $tlUsers = User::whereIn('id',$userIds)
           ->where('group_id',7)->get();
      
        return view('salesReport',['users'=>$users,
                'date'=>$date,
                'projectsCount'=>$projectsCount,
                'noOfCalls'=>$noOfCalls,
                'projectIds'=>$projectIds,
                'tl' =>$tl,
                'tlUsers'=>$tlUsers,
                'tluser'=>$tluser
            ]);
    }


    
    public function stages(Request $request)
    {
       $users = User::where('users.department_id','!=',10)
                    ->leftjoin('departments','departments.id','users.department_id')
                    ->leftjoin('groups','groups.id','users.group_id')
                    ->leftjoin('stages','stages.list','users.name')
                    ->select('users.*','departments.dept_name','groups.group_name')

                    ->paginate(10);
             $stages = Stages::where('status','')->get();
              

            $wards = Ward::all();
                 
         $le = DB::table('users')->where('department_id','1')->where('group_id','6')->get();
          $se = DB::table('users')->where('department_id','2')->where('group_id','7')->get();
         return view('assignStages',['le' => $le ,'se' => $se,'users'=>$users]);
        
    }


     




     public function store(Request $request)
    {
       
        $this->validate($request, [
            
            'list' => 'required|max:500',
            'status' => 'required|max:500',

        ]);
        Stages::create([
        'list'=> $request['list'],
        'status'=> $request['status'],
           
      ]);
        return redirect()->back();
     
    }
     public function datestore(Request $request)
    {
       
        $this->validate($request, [
            
            'name' => 'required|max:500',
            'assigndate' => 'required|max:500',

        ]);
        $dates = new Dates;
        $dates->user_id = $request->name;
        $dates->assigndate = $request->assigndate;
        $dates->save();
        return redirect()->back();
     
    }
    public function salesConverterDashboard()
    {
        return view('scdashboard');
    }
   

   
    public function getChat()
    {
        $reads = Message::where('read_by','NOT LIKE',"%".Auth::user()->id."%")->get();
        foreach($reads as $read){
            $reader = $read->read_by;
            if($reader == "none"){
                $read->read_by = Auth::user()->id;
                $read->save();
            }else{
                $read->read_by = $reader.", ".Auth::user()->id;
                $read->save();
            }
        }
       
        return view('chat');
    }

public function approval(request $request  )
    {         
      ProjectDetails::where('project_id',$request->id)
        ->update([
            'deleted'=>2
        ]);
      return back();
    }
    public function getWardMaping(Request $request)
    {
        if($request->zoneId){
            $zones = Zone::leftjoin('zone_maps','zones.id','zone_maps.zone_id')
                        ->select('zones.*','zone_maps.lat','zone_maps.color','zone_maps.zone_id','zones.zone_name as name')
                        ->where('zones.id',$request->zoneId)
                        ->first();
            $page = "Zone";
        }elseif($request->wardId){
            $zones = Ward::leftjoin('ward_maps','wards.id','ward_maps.ward_id')
                        ->select('wards.*','ward_maps.lat','ward_maps.color','ward_maps.ward_id','wards.ward_name as name')
                        ->where('wards.id',$request->wardId)
                        ->first();
            $page = "Ward";
        }elseif($request->subWardId){
            $zones = SubWard::leftjoin('sub_ward_maps','sub_wards.id','sub_ward_maps.sub_ward_id')
                        ->select('sub_wards.*','sub_ward_maps.lat','sub_ward_maps.color','sub_ward_maps.sub_ward_id','sub_wards.sub_ward_name as name')
                        ->where('sub_wards.id',$request->subWardId)
                        ->first();
            $page = "Sub Ward";
        }
        return view('maping.wardmaping',['zones'=>$zones,'page'=>$page]);
    }
    public function getWards(Request $request)
    {
        $wards = Ward::where('zone_id',$request->id)
                    ->leftjoin('ward_maps','wards.id','ward_maps.ward_id')
                    ->select('wards.*','ward_maps.lat','ward_maps.color')
                    ->get();
        return response()->json($wards);
    }
public function myreport()
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
   return view('myreport',[
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


public function assigndate(request $request )
{
     $users = User::where('users.department_id','!=',10)
                    ->leftjoin('departments','departments.id','users.department_id')
                    ->leftjoin('groups','groups.id','users.group_id')
                    ->leftjoin('stages','stages.list','users.name')
                    ->select('users.*','departments.dept_name','groups.group_name')

                    ->paginate(10);
             $stages = Stages::where('status','')->get();
              

            $wards = Ward::all();
                 
         $le = DB::table('users')->where('department_id','1')->where('group_id','6')->get();
          $se = DB::table('users')->where('department_id','2')->where('group_id','7')->get();
         return view('assigndate',['le' => $le ,'se' => $se,'users'=>$users]);
        
}
    public function approvePoint(Request $request)
    {
        $point = Point::where('id',$request->id)->first();
        $point->confirmation = 1;
        $point->save();
        return back();
    }
    public function getLeTracking(Request $request)
    {
        $tracking = UserLocation::where('created_at','LIKE',date('Y-m-d')."%")->pluck('user_id')->toArray();
        $users = User::whereIn('id',$tracking)->get();
         $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
              $userIds = explode(",", $tl);
              $tlUsers = User::whereIn('id',$userIds)->where('group_id',6)->simplePaginate();
        if($request->userId){
            $track = UserLocation::where('user_id',$request->userId)
                        ->where('created_at','LIKE',date('Y-m-d')."%")
                        ->get();
            return view('letracking',['users'=>$users,'track'=>$track,'tlUsers'=>$tlUsers]);
        }
        return view('letracking',['users'=>$users,'tlUsers'=>$tlUsers]);
    }
    public function confidential(Request $request){
      
        $wards = Ward::orderby('ward_name','ASC')->get();
        $projects = ProjectDetails::where('deleted',0)->get();
        $qualityCheck = $request->quality;
        // getting total no of projects
        $wardsselect = Ward::pluck('id');
        $subwards = SubWard::whereIn('ward_id',$wardsselect)->pluck('id');
        $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Planning%')->count();
        $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Planning%')->sum('project_size');
        $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Foundation%')->count();
        $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Foundation%')->sum('project_size');
        $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Roofing%')->count();
        $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Roofing%')->sum('project_size');
        $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Walls%')->count();
        $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Walls%')->sum('project_size');
        $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Completion%')->count();
        $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Completion%')->sum('project_size');
        $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Fixtures%')->count();
        $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Fixtures%')->sum('project_size');
        $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Pillars%')->count();
        $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Pillars%')->sum('project_size');
        $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Paintings%')->count();
        $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Paintings%')->sum('project_size');
        $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Flooring%')->count();
        $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Flooring%')->sum('project_size');
        $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plastering%')->count();
        $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plastering%')->sum('project_size');
        $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Digging%')->count();
        $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Digging%')->sum('project_size');
        $ele                = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Electrical%')->pluck('project_id');
        $plum               = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
        $ele                = $ele->merge($plum);
        $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
        $enpSize            = ProjectDetails::where('project_id',$ele)->sum('project_size');
        $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Carpentry%')->count();
        $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Carpentry%')->sum('project_size');
        // $closedCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Closed%')->count();
        // $closedSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Closed%')->sum('project_size');

        $totalProjects = $planningCount + $diggingCount + $foundationCount + $pillarsCount + $completionCount + $fixturesCount + $paintingCount + $carpentryCount + $flooringCount + $plasteringCount + $enpCount + $roofingCount + $wallsCount ;
        
        if($request->ward && !$request->subward){
            if($request->ward == "All"){
                $planningCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
                $planningSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
                $foundationCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
                $foundationSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
                $roofingCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
                $roofingSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
                $wallsCount         = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
                $wallsSize          = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
                $completionCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
                $completionSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
                $fixturesCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
                $fixturesSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
                $pillarsCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
                $pillarsSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
                $paintingCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
                $paintingSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
                $flooringCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
                $flooringSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
                $plasteringCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
                $plasteringSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
                $diggingCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
                $diggingSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
                $ele                = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
                $plum               = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
                $ele                = $ele->merge($plum);
                $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
                $enpSize            = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');
                $carpentryCount     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
                $carpentrySize      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
                // $closedCount        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
                // $closedSize         = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');
                $wardname = "All";
                $subwards = SubWard::all();
            
            }else{
                $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
                $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
                $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
                $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
                $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
                $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
                $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
                $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
                $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
                $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
                $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
                $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
                $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
                $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
                $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
                $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
                $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
                $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
                $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
                $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
                $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
                $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
                $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
                $ele                = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
                $plum               = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
                $ele                = $ele->merge($plum);
                $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
                $enpSize            = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');
                $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
                $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
                // $closedCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
                // $closedSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');
                $wardname = Ward::where('id',$request->ward)->first();
                $subwards = SubWard::where('ward_id',$request->ward)->get();
            }
            return view('confidential',[
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
                // 'closedSize'=>$closedSize,'closedCount'=>$closedCount,
                'wards'=>$wards,
                'wardname'=>$wardname,
                'subwards'=>$subwards,'wardId'=>$request->ward,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects
            ]);
        }
        if($request->subward){
            $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
            $subwardQuality = $request->subwardquality;
            $planningCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
            $planningSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
            $foundationCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
            $foundationSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
            $roofingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
            $roofingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
            $wallsCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
            $wallsSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
            $completionCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
            $completionSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
            $fixturesCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
            $fixturesSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
            $pillarsCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
            $pillarsSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
            $paintingCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
            $paintingSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
            $flooringCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
            $flooringSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
            $plasteringCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
            $plasteringSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
            $diggingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
            $diggingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
            $ele               = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
            $plum              = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
            $ele               = $ele->merge($plum);
            $enpCount          = ProjectDetails::whereIn('project_id',$ele)->count();
            $enpSize           = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');
            $carpentryCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
            $carpentrySize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
            // $closedCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
            // $closedSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');

            $wardname = Ward::where('id',$request->ward)->first();
            $subwards = SubWard::where('ward_id',$request->ward)->get();
            $total = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->count();
            $planning   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Planning%')->sum('project_size');
            $foundation = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Foundation%')->sum('project_size');
            $roofing    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Roofing%')->sum('project_size');
            $walls      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Walls%')->sum('project_size');
            $completion = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Completion%')->sum('project_size');
            $fixtures   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Fixtures%')->sum('project_size');
            $pillars    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Pillars%')->sum('project_size');
            $painting   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Paintings%')->sum('project_size');
            $flooring   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Flooring%')->sum('project_size');
            $plastering = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Plastering%')->sum('project_size');
            $digging    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Digging%')->sum('project_size');
            $ele2        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
            $plum2       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
            $ele2        = $ele2->merge($plum2);
            $enp    = ProjectDetails::whereIn('project_id',$ele2)->sum('project_size');
            $carpentry  = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Carpentry%')->sum('project_size');
            // $closed     = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Closed%')->sum('project_size');
            
            $Cplanning      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Planning%')->count();
            $Cfoundation    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Foundation%')->count();
            $Croofing       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Roofing%')->count();
            $Cwalls         = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Walls%')->count();
            $Ccompletion    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Completion%')->count();
            $Cfixtures      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Fixtures%')->count();
            $Cpillars       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Pillars%')->count();
            $Cpainting      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Paintings%')->count();
            $Cflooring      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Flooring%')->count();
            $Cplastering    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Plastering%')->count();
            $Cdigging       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Digging%')->count();
            $Cenp   = ProjectDetails::whereIn('project_id',$ele2)->count();
            // $Cenp           = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Electrical%')
            //                     ->orWhere('project_status','LIKE','Plumbing%')->count();
            $Ccarpentry     = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Carpentry%')->count();
            // $Cclosed        = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Closed%')->count();
            
            $subwardname = SubWard::where('id',$request->subward)->pluck('sub_ward_name')->first();
            $totalsubward = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->sum('project_size');
            return view('confidential',[
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
                // 'closedSize'=>$closedSize,'closedCount'=>$closedCount,
                'wards'=>$wards,'wardname'=>$wardname,
                'subwards'=>$subwards,'wardId'=>$request->ward,
                'totalProjects' => $totalProjects,
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
                'Cplanning'=>$Cplanning,
                'Cfoundation'=>$Cfoundation,
                'Croofing'=>$Croofing,
                'Cwalls'=>$Cwalls,
                'Ccompletion'=>$Ccompletion,
                'Cfixtures'=>$Cfixtures,
                'Cpillars'=>$Cpillars,
                'Cpainting'=>$Cpainting,
                'Cflooring'=>$Cflooring,
                'Cplastering'=>$Cplastering,
                'Cdigging'=>$Cdigging,
                'Cenp'=>$Cenp,
                'Ccarpentry'=>$Ccarpentry,
                // 'closed'=>$closed,
                // 'Cclosed'=>$Cclosed,
                'subwardId'=>$request->subward,
                'subwardName'=>$subwardname,
                'total'=>$total,
                'totalsubward'=>$totalsubward
            ]);
        }
        return view('confidential',['wards'=>$wards,'planningCount'=>NULL,'subwards'=>NULL,'wardId'=>NULL,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects]);
    }
 public function numberwise(request $request){
    $depts = [1,2];
    $users = User::whereIn('users.department_id',$depts)
              ->leftjoin('groups','groups.id','users.group_id')
              
             ->select('users.*','groups.group_name')->get();
             $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
              $userIds = explode(",", $tl);
              $tlUsers = User::whereIn('id',$userIds)->simplePaginate();
        $count = numbers::count();
        $number = numbers::paginate(100);
        if($request->delete){
            numbers::truncate();
            return back();
        }

         return view('assign_number',['users'=>$users,'number'=>$number,'count'=>$count,'tlUsers'=>$tlUsers]);

}
public function savenumber(request $request){


        $check = new MamaSms;
        $check->sim_number = $request->phNo;
        $check->user_id = Auth::user()->id;
        $check->totalnumber = 100;
        $check->save();
        return back();
 
}
public function storenumber(request $request){
    if($request->stage ){
        $stages = implode(", ", $request->stage);
    } else{
        $stages ="null";
    }
    $validator = Validator::make($request->all(), ['stage' => 'required']);
            if ($validator->fails()) {
                return back()
                ->with('NotAdded','Select Stage Before Submit')
                ->withErrors($validator)
                ->withInput();
            }
    $check = AssignNumber::where('user_id',$request->user_id)->first();
            if(count($check) == 0){
            $anumber = new AssignNumber;
            $anumber->user_id = $request->user_id ;
            $anumber->stage = $stages;
            $anumber->save();
        
    }
    else{
            $check->stage = $stages;
            $check->save();

    }

     return redirect()->back()->with('Success','Assigned successfully');

}

public function projectwise1(request $request){


      //$ss = $request->$scount;
    
     $depts = [1,2];
     $wardsAndSub = [];
    $users = User::whereIn('users.department_id',$depts)
              ->leftjoin('assignstage','assignstage.user_id','users.id')
              ->leftjoin('departments','departments.id','users.department_id'   )
              ->leftjoin('groups','groups.id','users.group_id')
              
              ->select('users.*','departments.dept_name','groups.group_name','assignstage.prv_ward','assignstage.prv_subward','assignstage.prv_date','assignstage.prv_stage','assignstage.state' )->paginate(20);

               $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
              $userIds = explode(",", $tl);
              $tlUsers = User::whereIn('id',$userIds)->get();

      
 //      $details= $request->Search;
 // $detail = User::where(['name', 'LIKE', '%' . $details . '%'])->get();

                   
   $assignstage=AssignStage::all();
    $wards = Ward::all();
    $subwards = SubWard::leftjoin('project_details','sub_ward_id','sub_wards.id')
               ->select('sub_wards.*')->get();
    $assign = AssignStage::pluck('state');
    foreach($wards as $ward){
        $subward = SubWard::where('ward_id',$ward->id)->get();
        array_push($wardsAndSub,['ward'=>$ward->id,'subWards'=>$subward]);
    }

        
 return view('assign_project',['wardsAndSub'=>$wardsAndSub,'subwards'=>$subwards, 'users'=>$users,'wards'=>$wards,'assign'=>$assign,'assignstage'=>$assignstage,'tlUsers'=>$tlUsers]);
    
}


public function projectwise(request $request){

if(Auth::user()->group_id != 22){
    return $this->projectwise1($request);
}
      
 $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
    
     $depts = [1,2];
     $wardsAndSub = [];
    $users = User::whereIn('users.department_id',$depts)
              ->leftjoin('assignstage','assignstage.user_id','users.id')
              ->leftjoin('departments','departments.id','users.department_id'   )
              ->leftjoin('groups','groups.id','users.group_id')
              
              ->select('users.*','departments.dept_name','groups.group_name','assignstage.prv_ward','assignstage.prv_subward','assignstage.prv_date','assignstage.prv_stage','assignstage.state' )->paginate(20);
$tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
              $userIds = explode(",", $tl);
$tlUsers = User::whereIn('users.id',$userIds)
              ->leftjoin('assignstage','assignstage.user_id','users.id')
              ->leftjoin('departments','departments.id','users.department_id'   )
              ->leftjoin('groups','groups.id','users.group_id')
              
              ->select('users.*','departments.dept_name','groups.group_name','assignstage.prv_ward','assignstage.prv_subward','assignstage.prv_date','assignstage.prv_stage','assignstage.state' )->paginate(20);


      
              
 //      $details= $request->Search;
 // $detail = User::where(['name', 'LIKE', '%' . $details . '%'])->get();

                   
   $assignstage=AssignStage::all();
    $wards = Ward::where('wards.id',$tlward)->get();
    
    $subwards = SubWard::leftjoin('project_details','sub_ward_id','sub_wards.id')
               ->select('sub_wards.*')->get();
    $assign = AssignStage::pluck('state');
    foreach($wards as $ward){
        $subward = SubWard::where('ward_id',$ward->id)->get();
        array_push($wardsAndSub,['ward'=>$ward->id,'subWards'=>$subward]);
    }
 return view('assign_project',['wardsAndSub'=>$wardsAndSub,'subwards'=>$subwards, 'users'=>$users,'wards'=>$wards,'assign'=>$assign,'assignstage'=>$assignstage,'tlUsers'=>$tlUsers]);
    
}



public function projectwisedel(request $request){

AssignStage::where('user_id',Auth::user()->id)->delete();
return redirect()->back();

}

public function projectstore(request $request)
{
    if($request->ward){
    $wards = implode(", ", $request->ward);
    }else{
        if(Auth::user()->group_id == 22){
            $tlWard = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
            $ward = Ward::where('id',$tlWard)->pluck('ward_name')->first();
            $wards = $ward;
        }else{
            $wards = "null";
        }
    }

  if($request->contract_type){
    $contract = implode(",", $request->contract_type);
  }else{
    $contract = "null";
  }
    

    if($request->rmc)
    {
        $rmc = implode(",", $request->rmc);
    }else{
        $rmc="null";
    }


    if($request->subward ) 
     {
    $subwards = implode(", ", $request->subward);

    } else{
        $subwards = "null";
    }

    if($request->stage )  {

    $stages = implode(", ", $request->stage);
    } else{
        $stages ="null";
    }
    if($request->constraction_type ){
    $contracts = implode(", ",$request->constraction_type);
        
    }else{
       $contracts = "null";  
    }
   if($request->budget_type){

    $budgets = implode(", ", $request->budget_type);
   }else{
    $budgets = "null";
   }
$check = AssignStage::where('user_id',$request->user_id)->first();

    
if(count($check) == 0){
     
        $projectassign = new AssignStage;
    
        $projectassign->user_id = $request->user_id;

        $projectassign->ward = $wards;
        $projectassign->subward = $subwards;
        $projectassign->stage = $stages;
        $projectassign->assigndate = $request->assigndate;
        $projectassign->project_type = $request->project_type;
        $projectassign->project_size = $request->project_size;
        $projectassign->budget = $request->budget;
        $projectassign->contract_type =$contract;
        $projectassign->constraction_type = $contracts;
        $projectassign->rmc = $rmc;
        $projectassign->budget_type = $budgets;
        $projectassign->prv_ward =$wards ;
        $projectassign->state = "Not Completed ";
        $projectassign->prv_subward =$subwards;
        $projectassign->prv_date =$request->assigndate;
        $projectassign->prv_stage =$stages;
        $projectassign->Floor = $request->Floor;
        
        $projectassign->basement = $request->basement;
        $projectassign->base = $request->base;
        $projectassign->Floor2 = $request->Floor2;
        $projectassign->total = $request->total;
        $projectassign->projectsize = $request->projectsize;
        $projectassign->budgetto = $request->budgetto;
        $projectassign->quality = $request->quality;
        $projectassign->save();
}else{

        $check->ward = $wards;
        $check->subward = $subwards;
        $check->stage = $stages;
        $check->assigndate = $request->assigndate;
        $check->project_type = $request->project_type;
        $check->project_size = $request->project_size;
        $check->budget = $request->budget;
        $check->contract_type = $contract;
        $check->constraction_type = $contracts;
        $check->rmc = $rmc;
        $check->budget_type = $budgets;           
        $check->state = "Not Completed ";
        $check->prv_ward =$wards ;
        $check->prv_subward =$subwards;
        $check->prv_date =$request->assigndate;
        $check->prv_stage =$stages;
        $check->Floor =$request->Floor;
        $check->basement =$request->basement;
        $check->basement = $request->basement;
        $check->base = $request->base;
        $check->Floor2 = $request->Floor2;
        $check->total = $request->total;
        $check->projectsize = $request->projectsize;
        $check->budgetto = $request->budgetto;
        $check->quality = $request->quality;
        $check->project_ids = null;
        $check->time = $request->settime;
        $check->instruction = $request->inc;
        $check->save(); 
}
       

      return redirect()->back()->with('Assig projects successfully');


            
}

public function projectstore1(request $request){
    $check = AssignStage::where('user_id',$request->user_id)->first();

       if(count($check) != 0){


     
        $check->time = $request->settime;
        $check->instruction = $request->inc;
        $check->save(); 




}
 return redirect()->back()->with('Assig projects successfully');


            
}

public function reject(request $request){
    $check = AssignStage::where('user_id',$request->user_id)->first();

       if(count($check) != 0){


        
        $check->remark = $request->remark;
        
        $check->save(); 




}
 return redirect()->back()->with('Assig projects successfully');


            
}


public function enquirywise(request $request){
 
if(Auth::user()->group_id != 22){
    return $this->enquirywise1($request);
}
 
   $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
   $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
  $userIds = explode(",", $tl);
  
 $wards = Ward::where('wards.id',$tlward)->get();
 $depts = [17,6];
 $wardsAndSub = [];
 $users = User::whereIn('users.group_id',$depts)
              ->leftjoin('departments','departments.id','users.department_id')
              ->leftjoin('groups','groups.id','users.group_id')
              ->select('users.*','departments.dept_name','groups.group_name')->paginate(20);

   $tlUsers = User::whereIn('users.id',$userIds)
              ->leftjoin('departments','departments.id','users.department_id')
              ->leftjoin('groups','groups.id','users.group_id')
              ->select('users.*','departments.dept_name','groups.group_name')->paginate(20);
                $category = Category::all();
                $brands = brand::all();
                $sub = SubCategory::all();
                foreach($wards as $ward){
                    $subward = SubWard::where('ward_id',$ward->id)->get();
                    array_push($wardsAndSub,['ward'=>$ward->id,'subwards'=>$subward]);
                }
    return view('/assign_enquiry',['wardsAndSub'=>$wardsAndSub, 'users'=>$users,'sub'=>$sub,'wards'=> $wards,'category'=>$category,'brands'=>$brands,'tlUsers'=>$tlUsers ]);
}

public function enquirywise1(request $request){
 
 $depts = [17,6];
 $wardsAndSub = [];
 $users = User::whereIn('users.group_id',$depts)
              ->leftjoin('departments','departments.id','users.department_id')
              ->leftjoin('groups','groups.id','users.group_id')
              ->select('users.*','departments.dept_name','groups.group_name')->paginate(20);

   $wards = Ward::all();
                $category = Category::all();
                $brands = brand::all();
                $sub = SubCategory::all();
    foreach($wards as $ward){
        $subward = SubWard::where('ward_id',$ward->id)->get();
        array_push($wardsAndSub,['ward'=>$ward->id,'subwards'=>$subward]);
    }
    return view('/assign_enquiry',['wardsAndSub'=>$wardsAndSub, 'users'=>$users,'sub'=>$sub,'wards'=> $wards,'category'=>$category,'brands'=>$brands ]);
}




function enquirystore(request $request){
    if($request->ward){
    $wards = implode(", ", $request->ward);
    }else{
        if(Auth::user()->group_id == 22){
            $tlWard = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
            $ward = Ward::where('id',$tlWard)->pluck('ward_name')->first();
            $wards = $ward;
        }else{
            $wards = "null";
        }
    }
    if($request->subward ) 
    {
    $subwards = implode(", ", $request->subward);

    } else{
        $subwards = "null";
    }
    if($request->cat){
        $cat = implode(",", $request->cat);
    }else{
        $cat = "null";
    }
    if($request->brand){
        $brand = implode(",", $request->brand);
    }else{
        $brand = "null";
    }

    // if($request->subcat){
    //     $sub = implode(",",$request->subcat);
    // }else{
    //     $sub = "null";
    // }
        $check = Assignenquiry::where('user_id',$request->user_id)->first();
        if(count($check) == 0){
            $enquiry = new Assignenquiry;
            $enquiry ->user_id = $request->user_id;
            $enquiry->ward = $wards;
            $enquiry->subward = $subwards;
            $enquiry->cat =$cat;
            $enquiry->brand=$brand;
            $enquiry->dateenq=$request->dateenq;
            // $enquiry->sub=$sub;
            $enquiry->save();
        }else{
            $check->ward = $wards;
            $check->subward = $subwards;

            $check->cat =$cat;
            $check->brand=$brand;
            $check->dateenq=$request->dateenq;
            // $check->sub=$sub;
            $check->save(); 
        }
        return redirect()->back()->with('Assig enquiry successfully');
    }
    public function enqwise(Request $request){
        $assigndate =Assignenquiry::where('user_id',Auth::user()->id)
                       ->orderby('dateenq','DESC')->pluck('dateenq')->first();


         $tlWard = Assignenquiry::where('user_id',Auth::user()->id)->pluck('ward')->first();
         $ward = Ward::where('ward_name',$tlWard)->pluck('id')->first();
         $assignedSubWards = SubWard::where('ward_id',$ward)->pluck('id');

         // dd($ward."<br>".$assignedSubWards);
        
       $subwards = Assignenquiry::where('user_id',Auth::user()->id)->pluck('subward');
       
        $subwardNames = explode(", ", $subwards);
        $subwardid = Subward::whereIn('sub_ward_name',$subwardNames)->pluck('id')->toArray(); 
         
         if($subwardid != "null"){
             $subwardid = $assignedSubWards;
         }
        
         $cat =  Assignenquiry::where('user_id',Auth::user()->id)->pluck('cat')->first();
        $brand = Assignenquiry::where('user_id',Auth::user()->id)->pluck('brand');
                $sub = Assignenquiry::where('user_id',Auth::user()->id)->pluck('sub');
 
        $projectids = new Collection();
         //feching wardwise
        $project = ProjectDetails::leftjoin('requirements','requirements.project_id','project_details.project_id')
                    ->whereIn('project_details.sub_ward_id',$subwardid)
                    ->pluck('project_details.project_id');
         
         
        if(count($project) > 0){
            $projectids = $projectids->merge($project);

        }
        $catc = explode(", ", $cat);

        if($catc[0] != ""){
            for($i = 0; $i<count($catc); $i++)
            {
                if(count($projectids) != 0){
                    $category = Requirement::whereIn('project_id',$projectids)->where('main_category' ,'LIKE', $catc[$i]."%")->pluck('project_id');
                     
                }else{
                    $category = Requirement::where('main_category' ,'LIKE', "%".$catc[$i]."%")->pluck('project_id');
                }
            }
            $projectids = $projectids->merge($category);
        }
        $brandc = $brand->toArray();
       $brandlist = new Collection;
        

        if(count($projectids) != 0){
            for($i = 0; $i<count($brandc); $i++)
            {
                $brands = Requirement::whereIn('project_id',$projectids)->where('brand' ,'LIKE', "%".$brandc[$i]."%")->pluck('project_id');
                
                $brandlist = $brandlist->merge($brands);
            }
        }else{
            for($i = 0; $i<count($brandc); $i++)
            $brandlist= Requirement::where('brand' ,'LIKE', "%".$brandc[$i]."%")->pluck('project_id');
        
        }
         $projectids = $projectids->merge($brandlist);
        if( $assigndate != NULL){
            if(count($projectids) != 0)
                $datec = Requirement::whereIn('project_id',$projectids)->where('created_at','LIKE' , $assigndate."%")->pluck('project_id');
            else
                $datec = Requirement::where('created_at','LIKE' , $assigndate."%")->pluck('project_id');
            $projectids=$projectids->merge($datec);
        }


    
        $projects = Requirement::whereIn('requirements.project_id',$projectids)
                        ->leftjoin('procurement_details','requirements.project_id', '=' ,'procurement_details.project_id')
                        ->select('requirements.*','procurement_details.procurement_contact_no')
                        ->paginate(20);
            
                        

        return view('enquirywise',['projects'=>$projects]);
    }
    public function viewMap(Request $request)
    {
        $wards = Ward::where('zone_id',$request->zoneId)->pluck('id');
        $zones = WardMap::whereIn('wards.id',$wards)
                    ->leftJoin('wards','wards.id','ward_maps.ward_id')
                    ->select('ward_maps.*','wards.ward_name as name')
                    ->get();
        if($request->wardId){
             $wards = SubWard::where('ward_id',$request->wardId)->pluck('id');
            $zones = SubWardMap::whereIn('sub_wards.id',$wards)
                    ->leftJoin('sub_wards','sub_wards.id','sub_ward_maps.sub_ward_id')
                    ->select('sub_ward_maps.*','sub_wards.sub_ward_name as name')
                    ->get();
        }
        return view('maping.viewmap',['zones'=>$zones]);
    }
    public function allProjectsWithWards(Request $request)
    {
        $wardMaps = null;
        $projects = null;
        if($request->wards && $request->quality ){
           
            $subwards = SubWard::where('ward_id',$request->wards)->pluck('id')->toArray();
            $wardMaps = WardMap::where('ward_id',$request->wards)->first();
            if($wardMaps == null ){
                $wardMaps = "None";
            }
            $projects = ProjectDetails::leftJoin('site_addresses','project_details.project_id','site_addresses.project_id')
                        ->select('site_addresses.*','project_details.quality')
                        ->where('project_details.quality',$request->quality)
                        ->whereIn('project_details.sub_ward_id',$subwards)
                        ->get();
        }
        // $zonemap== null;
        // if( $request->zone){
        //     $zones = Zone::where('id',$request->zone)->pluck('id')->toArray();
        //     $zonemap = ZoneMap::where('zone_id',$request->zone)->first();
        //     if($zonemap== null ){
        //         $zonemap = "None";
        //     }
        // }
        // $projects = Zone::leftjoin('wards','wards.zone_id','zones.id')
        //  ->leftjoin('sub_wards','sub_wards.ward_id','wards.id')
        //  ->leftjoin('project_details','project_details.sub_ward_id','sub_wards.id')
        //  ->leftJoin('site_addresses','project_details.project_id','site_addresses.project_id')
        //  ->select('site_addresses.*','project_details.quality')
        //  ->get();

        $wards = Ward::all();
        $zone = Zone::all();
        return view('maping.allProjectsWithWards',['wardMaps'=>$wardMaps,'projects'=>$projects,'wards'=>$wards,'zone'=>$zone]);
    }
 
    public function storecount(request $request){
    $check = numbercount::where('user_id',$request->user_id)->first();
    $numberexist = numbercount::where('num',$request->num)->first();
    if($numberexist != null){
        $userName = User::where('id',$numberexist->user_id)->pluck('name')->first();
        $text = "These numbers are already assigned to ".$userName;
        return back()->with('NotAdded',$text);
    }
            if(count($check) == 0){
                $number = new numbercount;
                $number ->user_id = $request->user_id;
                $number->num = $request->num;
                $number->save();
            }else{
                $check->num=$request->num;
                $check->save(); 
            }
            return redirect()->back()->with('Assig   successfully');
    }

    public function sms(request $request){
        $users = User::all();
        $ss = numbercount::all();
        $num =MamaSms::all();
        return view('/sms',['users'=>$users,'ss'=>$ss,'num'=>$num]);
    }
    public function payment( request $request){

       $payment = Payment::all();
       $pay = Payment::all()->count();
       $converter = user::all();
       
        return view('/payment',['payment'=>$payment,'pay'=>$pay,'converter'=>$converter]);
    }
public function display(request $request){

 $wardMaps = null;
        $projects = null;
        if($request->wards && $request->quality){
            $subwards = SubWard::where('ward_id',$request->wards)->pluck('id')->toArray();
            $wardMaps = WardMap::where('ward_id',$request->wards)->first();
            if($wardMaps == null){
                $wardMaps = "None";
            }
            $projects = ProjectDetails::leftJoin('site_addresses','project_details.project_id','site_addresses.project_id')
                        ->select('site_addresses.*','project_details.quality')
                        ->where('project_details.quality',$request->quality)
                        ->whereIn('project_details.sub_ward_id',$subwards)
                        ->get();
        }
        $wards = Ward::all();
        $war = WardMap::all();
        
        return view('maping.map',['wardMaps'=>$wardMaps,'projects'=>$projects,'wards'=>$wards,'war'=>$war]);

    
}
// public function getProjection(Request $request)
    // public function sendSMS(Request $request)
    // {
        // $nexmo = app('Nexmo\Client');
        // if($request->number && $request->content){
            // $nexmo->message()->send([
            //     'to'   => $request->number,
            //     'from' => "MAMAHOME",
            //     'text' => $request->content
            // ]);
            // return redirect('/sendSMS');
        // }
    //     return view('sendSMS');
    // }
    public function getProjection(Request $request)
    {
        $conversions = Conversion::all();
        if($request->category){
            $conversion = Conversion::where('id',$request->category)->first();
            $utilizations = Utilization::where('id',$request->category)->first();
            View::share('conversion', $conversion);
            View::share('utilization',$utilizations);
        }else{
            View::share('conversion',null);
        }
        $wards = Ward::all();
       $projects = ProjectDetails::where('deleted',0)->get();
       $qualityCheck = ['Genuine','Fake','Unverified'];
       // getting total no of projects
       $wardsselect = Ward::pluck('id');
       $subwards = SubWard::whereIn('ward_id',$wardsselect)->pluck('id');
       $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Planning%')->count();
       $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Planning%')->sum('project_size');
       $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Foundation%')->count();
       $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Foundation%')->sum('project_size');
       $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Roofing%')->count();
       $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Roofing%')->sum('project_size');
       $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Walls%')->count();
       $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Walls%')->sum('project_size');
       $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Completion%')->count();
       $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Completion%')->sum('project_size');
       $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Fixtures%')->count();
       $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Fixtures%')->sum('project_size');
       $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Pillars%')->count();
       $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Pillars%')->sum('project_size');
       $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Paintings%')->count();
       $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Paintings%')->sum('project_size');
       $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Flooring%')->count();
       $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Flooring%')->sum('project_size');
       $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plastering%')->count();
       $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plastering%')->sum('project_size');
       $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Digging%')->count();
       $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Digging%')->sum('project_size');
       $ele                = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Electrical%')->pluck('project_id');
       $plum               = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
       $ele                = $ele->merge($plum);
       $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
       $enpSize            = ProjectDetails::where('project_id',$ele)->sum('project_size');
       $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Carpentry%')->count();
       $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Carpentry%')->sum('project_size');
       $closedCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Closed%')->count();
       $closedSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Closed%')->sum('project_size');

       $totalProjects = $planningCount + $diggingCount + $foundationCount + $pillarsCount + $completionCount + $fixturesCount + $paintingCount + $carpentryCount + $flooringCount + $plasteringCount + $enpCount + $roofingCount + $wallsCount + $closedCount;
       
       if($request->ward && !$request->subward){
           if($request->ward == "All"){
               $planningCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
               $planningSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
               $foundationCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
               $foundationSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
               $roofingCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
               $roofingSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
               $wallsCount         = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
               $wallsSize          = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
               $completionCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
               $completionSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
               $fixturesCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
               $fixturesSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
               $pillarsCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
               $pillarsSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
               $paintingCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
               $paintingSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
               $flooringCount      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
               $flooringSize       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
               $plasteringCount    = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
               $plasteringSize     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
               $diggingCount       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
               $diggingSize        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
               $ele                = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
               $plum               = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
               $ele                = $ele->merge($plum);
               $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
               $enpSize            = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');
               $carpentryCount     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
               $carpentrySize      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
               $closedCount        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
               $closedSize         = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');
               $wardname = "All";
               $subwards = SubWard::all();
           }else{
               $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
               $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
               $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
               $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
               $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
               $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
               $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
               $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
               $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
               $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
               $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
               $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
               $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
               $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
               $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
               $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
               $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
               $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
               $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
               $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
               $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
               $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
               $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
               $ele                = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
               $plum               = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
               $ele                = $ele->merge($plum);
               $enpCount           = ProjectDetails::whereIn('project_id',$ele)->count();
               $enpSize            = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');
               $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
               $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
               $closedCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
               $closedSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');
               $wardname = Ward::where('id',$request->ward)->first();
               $subwards = SubWard::where('ward_id',$request->ward)->get();
           }
           
           return view('projection',[
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
               'closedSize'=>$closedSize,'closedCount'=>$closedCount,
               'wards'=>$wards,
               'wardname'=>$wardname,'conversions'=>$conversions,
               'subwards'=>$subwards,'wardId'=>$request->ward,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects
           ]);
       }
       if($request->subward){
           $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
           $subwardQuality = ['Genuine','Fake','Unverified'];
           $planningCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->count();
           $planningSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
           $foundationCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->count();
           $foundationSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
           $roofingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->count();
           $roofingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
           $wallsCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->count();
           $wallsSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
           $completionCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->count();
           $completionSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
           $fixturesCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->count();
           $fixturesSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
           $pillarsCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->count();
           $pillarsSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
           $paintingCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->count();
           $paintingSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
           $flooringCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->count();
           $flooringSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
           $plasteringCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->count();
           $plasteringSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
           $diggingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->count();
           $diggingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
           $ele               = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->pluck('project_id');
           $plum              = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
           $ele               = $ele->merge($plum);
           $enpCount          = ProjectDetails::whereIn('project_id',$ele)->count();
           $enpSize           = ProjectDetails::whereIn('project_id',$ele)->sum('project_size');
           $carpentryCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->count();
           $carpentrySize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
           $closedCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->count();
           $closedSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');

           $wardname = Ward::where('id',$request->ward)->first();
           $subwards = SubWard::where('ward_id',$request->ward)->get();
           $total = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->count();
           $planning   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Planning%')->sum('project_size');
           $foundation = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Foundation%')->sum('project_size');
           $roofing    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Roofing%')->sum('project_size');
           $walls      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Walls%')->sum('project_size');
           $completion = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Completion%')->sum('project_size');
           $fixtures   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Fixtures%')->sum('project_size');
           $pillars    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Pillars%')->sum('project_size');
           $painting   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Paintings%')->sum('project_size');
           $flooring   = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Flooring%')->sum('project_size');
           $plastering = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Plastering%')->sum('project_size');
           $digging    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Digging%')->sum('project_size');
           $ele2        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Electrical%')->where('sub_ward_id',$request->subward)->pluck('project_id');
           $plum2       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plumbing%')->where('sub_ward_id',$request->subward)->pluck('project_id');
           $ele2        = $ele2->merge($plum2);
           $enp    = ProjectDetails::whereIn('project_id',$ele2)->sum('project_size');
           $carpentry  = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Carpentry%')->sum('project_size');
           $closed     = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Closed%')->sum('project_size');
           
           $Cplanning      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Planning%')->count();
           $Cfoundation    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Foundation%')->count();
           $Croofing       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Roofing%')->count();
           $Cwalls         = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Walls%')->count();
           $Ccompletion    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Completion%')->count();
           $Cfixtures      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Fixtures%')->count();
           $Cpillars       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Pillars%')->count();
           $Cpainting      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Paintings%')->count();
           $Cflooring      = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Flooring%')->count();
           $Cplastering    = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Plastering%')->count();
           $Cdigging       = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Digging%')->count();
           $Cenp   = ProjectDetails::whereIn('project_id',$ele2)->count();
           // $Cenp           = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Electrical%')
           //                     ->orWhere('project_status','LIKE','Plumbing%')->count();
           $Ccarpentry     = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Carpentry%')->count();
           $Cclosed        = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->where('project_status','LIKE','Closed%')->count();
           
           $subwardname = SubWard::where('id',$request->subward)->pluck('sub_ward_name')->first();
           $totalsubward = ProjectDetails::where('sub_ward_id',$request->subward)->whereIn('quality',$subwardQuality)->sum('project_size');
           
           return view('projection',[
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
               'closedSize'=>$closedSize,'closedCount'=>$closedCount,
               'wards'=>$wards,'wardname'=>$wardname,
               'subwards'=>$subwards,'wardId'=>$request->ward,
               'totalProjects' => $totalProjects,
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
               'Cplanning'=>$Cplanning,
               'Cfoundation'=>$Cfoundation,
               'Croofing'=>$Croofing,
               'Cwalls'=>$Cwalls,
               'Ccompletion'=>$Ccompletion,
               'Cfixtures'=>$Cfixtures,
               'Cpillars'=>$Cpillars,
               'Cpainting'=>$Cpainting,
               'Cflooring'=>$Cflooring,
               'Cplastering'=>$Cplastering,
               'Cdigging'=>$Cdigging,
               'Cenp'=>$Cenp,
               'Ccarpentry'=>$Ccarpentry,
               'closed'=>$closed,
               'Cclosed'=>$Cclosed,
               'subwardId'=>$request->subward,
               'subwardName'=>$subwardname,
               'total'=>$total,
               'totalsubward'=>$totalsubward,
               'conversions'=>$conversions
           ]);
       }
       return view('projection',['wards'=>$wards,'planningCount'=>NULL,'subwards'=>NULL,'wardId'=>NULL,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects,'conversions'=>$conversions]);
    }
    public function getLockProjection(Request $request){
        $wardsselect = Ward::pluck('id');
        $check = Detail::where('created_at','LIKE',date('Y-m').'%')->first();
        $qualityCheck = ['Genuine','Fake','Unverified'];
        if($check == null){
            foreach($wardsselect as $wards){
                // planning
                $subwards = SubWard::where('ward_id',$wards)->pluck('id');
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Planning";
                $details->size       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
                $details->save();
                
                // digging
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Digging";
                $details->size        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
                $details->save();

                // foundation
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Foundation";
                $details->size     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
                $details->save();

                // pillars
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Pillars";
                $details->size        = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
                $details->save();
                
                // walls
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Walls";
                $details->size          = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
                $details->save();
                
                
                
                // roofing
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Roofing";
                $details->size       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
                $details->save();
                
                $ele                = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Electrical%')->pluck('project_id');
                $plum               = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','LIKE','Plumbing%')->pluck('project_id');
                $ele                = $ele->merge($plum);
    
                // electrical & plumbing
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Electrical & Plumbing";
                $details->size            = ProjectDetails::whereIn('project_id',$ele)->whereIn('quality',$qualityCheck)->sum('project_size');
                $details->save();

                // plastering
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Plastering";
                $details->size     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
                $details->save();
                
                // flooring
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Flooring";
                $details->size       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
                $details->save();

                // carpentry
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Carpentry";
                $details->size      = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
                $details->save();

                // painting
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Painting";
                $details->size       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
                $details->save();

                // fixture
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Fixture";
                $details->size       = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
                $details->save();

                // completion
                $details = new Detail;
                $details->ward_id = $wards;
                $details->stage = "Completion";
                $details->size     = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
                $details->save();

                // closed
                // $details = new Detail;
                // $details->ward_id = $wards;
                // $details->stage = "Closed";
                // $details->size         = ProjectDetails::whereIn('sub_ward_id',$subwards)->whereIn('quality',$qualityCheck)->where('project_status','LIKE','Closed%')->sum('project_size');
                // $details->save();
            }
             // planning
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Planning";
             $details->size       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Planning%')->sum('project_size');
             $details->save();
             
             // digging
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Digging";
             $details->size        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Digging%')->sum('project_size');
             $details->save();
 
             // foundation
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Foundation";
             $details->size     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Foundation%')->sum('project_size');
             $details->save();
 
             // pillars
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Pillars";
             $details->size        = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Pillars%')->sum('project_size');
             $details->save();
             
             // walls
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Walls";
             $details->size          = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Walls%')->sum('project_size');
             $details->save();
             
             
             
             // roofing
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Roofing";
             $details->size       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Roofing%')->sum('project_size');
             $details->save();
             
             $ele                = ProjectDetails::where('project_status','LIKE','Electrical%')->pluck('project_id');
             $plum               = ProjectDetails::where('project_status','LIKE','Plumbing%')->pluck('project_id');
             $ele                = $ele->merge($plum);
 
             // electrical & plumbing
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Electrical & Plumbing";
             $details->size            = ProjectDetails::whereIn('project_id',$ele)->whereIn('quality',$qualityCheck)->sum('project_size');
             $details->save();
 
             // plastering
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Plastering";
             $details->size     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Plastering%')->sum('project_size');
             $details->save();
             
             // flooring
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Flooring";
             $details->size       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Flooring%')->sum('project_size');
             $details->save();
 
             // carpentry
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Carpentry";
             $details->size      = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Carpentry%')->sum('project_size');
             $details->save();
 
             // painting
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Painting";
             $details->size       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Paintings%')->sum('project_size');
             $details->save();
 
             // fixture
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Fixture";
             $details->size       = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Fixtures%')->sum('project_size');
             $details->save();
 
             // completion
             $details = new Detail;
             $details->ward_id = "all";
             $details->stage = "Completion";
             $details->size     = ProjectDetails::whereIn('quality',$qualityCheck)->where('project_status','LIKE','Completion%')->sum('project_size');
             $details->save();
         }
         $cat = Conversion::where('id',$request->category)->pluck('category')->first();
        $check2 = Projection::where('category',$cat)->first();
        if($check2 == null){
            $projection = new Projection;
            $projection->category = $cat;
            $projection->price = $request->price;
            $projection->business_cycle = $request->businessCycle;
            $projection->target = $request->monthlyTarget;
            $projection->transactional_profit = $request->transactionalProfit;
            $projection->from_date = $request->from;
            $projection->to_date = $request->to;
            if($request->incrementalPercentage){
                $projection->incremental_percentage = $request->incrementalPercentage;
            }
            $projection->save();
        }
        return back();
   }
   public function getLockedProjection()
   {
       $projections = Projection::pluck('category')->toArray();
       $categories = Utilization::all();
       return view('projection.projectionFirst',['categories'=>$categories,'projections'=>$projections]);
   }
   public function getLockedStage(Request $request){
    $categories = Projection::all();
        $wards = Ward::all();
        $text = "<br><br><br><br><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#reset'>Master Reset</button><br><br><table class='table table-hover' border=1>";
        $totalRequirement = 0;
        $totalPrice = 0;
        $totalMonthly = 0;
        $totalMonthlyPrice = 0;
        $totalTP = 0;
        $totalTarget = 0;
        if($request->ward){
            $projections = Detail::where('details.ward_id',$request->ward)
                            ->leftJoin('wards','wards.id','details.ward_id')
                            ->select('details.*','wards.ward_name')
                            ->get();
            if($request->category == 'all'){
                $category = Projection::all()->toArray();
                foreach($category as $category){
                    $totalCategory = 0;
                    $totalCategoryPrice = 0;
                    $conversion = Conversion::where('category',$category['category'])->first();
                    $utilizations = Utilization::where('category',$category['category'])->first();
                    $text .= "<tr><th colspan=6>".ucwords($category['category'])."</th></tr>";
                    foreach($projections as $projection){
                        if($projection['stage'] == "Electrical & Plumbing")
                            $stage = "electrical";
                        else
                            $stage = $projection['stage'];
                        $totalCategory += ($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]);
                        $totalCategoryPrice += ($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]) * $category['price'];
                    }
                    $text .= "<tr>
                                <th></th>
                                <th style='text-align:right'>Total ".$conversion['unit']."</th>
                                <th style='text-align:right'>Amount</th>
                                <th style='text-align:center'>Business Cycle</th>
                                <td style='text-align:center'><b>Monthly Target</b><br>
                                (".$category['target']."% From The Existing Monthly Requirement)</td>
                                <td style='text-align:center'><b>Transactional Profit</b><br>(".$category['transactional_profit']."% From The Monthly Target)</td>
                            </tr>";
                    $totalRequirement += $totalCategory;
                    $totalPrice += $totalCategoryPrice;
                    $text .= "<tr><td>Total Requirement In The Listed Projects</td>";

                    if($category['incremental_percentage'] != null){
                        $text .= "<td style='text-align:right'>".number_format($totalCategory + $totalCategory / 100 * $category['incremental_percentage'])."</td>
                        <td style='text-align:right'>".number_format($totalCategoryPrice + $totalCategoryPrice / 100 * $category['incremental_percentage'])."</td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                        <td>Monthly Requirement In The Listed Projects</td>";

                        $text .="<td style='text-align:right'>".number_format($monthly = $totalCategory/$category['business_cycle'] + $totalCategory/$category['business_cycle'] / 100 * $category['incremental_percentage'])."</td>
                        <td style='text-align:right'>".number_format($monthlyPrice = $totalCategoryPrice/$category['business_cycle'] + $totalCategoryPrice/$category['business_cycle'] / 100 * $category['incremental_percentage'])."</td>";
                    }else{
                        $text .= "<td style='text-align:right'>".number_format($totalCategory)."</td>
                        <td style='text-align:right'>".number_format($totalCategoryPrice)."</td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                        <td>Monthly Requirement In The Listed Projects</td>";

                        $text .="<td style='text-align:right'>".number_format($monthly = $totalCategory/$category['business_cycle'])."</td>
                        <td style='text-align:right'>".number_format($monthlyPrice = $totalCategoryPrice/$category['business_cycle'])."</td>";
                    }
                    $totalMonthly += $totalCategory/$category['business_cycle'];
                    $totalMonthlyPrice += $totalCategoryPrice/$category['business_cycle'];
                    
                    $totalMonthly/100*$category['target'];
                    $totalTarget += $amount = $monthlyPrice/100*$category['target'];
                    $totalTP += $tp = $amount/100*$category['transactional_profit'];
                    $text .= "<td style='text-align:center'>".$category['business_cycle'].
                                "</td><td style='text-align:right'>".number_format($amount).
                                "</td><td style='text-align:right'>".number_format($tp).
                            "</td></tr>";
                }
                $text .= "<tr><th colspan=6></th></tr><tr><th style='background-color:#236281; color:white;' colspan=6><center>Total</center></th></tr>
                    <tr>
                    <th>Total Monthly Target</th><th></th><th></th><th></th>
                    <th style='text-align:right'>".number_format($totalTarget)."</th>
                    <th></th>
                    </tr>
                    <tr>
                    <th>Total Monthly Transactional Profit</th>
                    <th></th><th></th><th></th><th></th>
                    <th style='text-align:right'>".number_format($totalTP)."</th>
                    </tr>
                    </table>";
                return view('projection.projectionStage',['category'=>$category,'wards'=>$wards,'categories'=>$categories,'text'=>$text]);
            }else{
                $category = Projection::where('category',$request->category)->first();
                $conversion = Conversion::where('category',$request->category)->first();
                $utilizations = Utilization::where('category',$request->category)->first()->toArray();
            }
            $total = Detail::where('ward_id',$request->ward)->sum('size');
            return view('projection.projectionStage',['projections'=>$projections,'category'=>$category,'wards'=>$wards,'total'=>$total,'conversion'=>$conversion,'utilizations'=>$utilizations,'categories'=>$categories]);
        }
       return view('projection.projectionStage',['wards'=>$wards,'categories'=>$categories]);
    }
    public function viewwardmap(Request $request){
        $id=$request->UserId;
        $wardsAssigned = WardAssignment::where('user_id',$id)->where('status','Not Completed')->pluck('subward_id')->first();
        $subwards = SubWard::where('id',$wardsAssigned)->first();
        $projects = ProjectDetails::join('site_addresses','project_details.project_id','=','site_addresses.project_id')
                        ->leftJoin('requirements','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id',$wardsAssigned)
                        ->select('requirements.status','site_addresses.address','site_addresses.latitude','site_addresses.longitude','project_details.project_name','project_details.project_id','project_details.created_at','project_details.updated_at')
                        ->get();
        if($subwards != null){
            $subwardMap = SubWardMap::where('sub_ward_id',$subwards->id)->first();
            // dd($subwardMap);
        }else{
            $subwardMap = "None";
        }
        if($subwardMap == Null){
            $subwardMap = "None";
        }
        return view('viewwardmap',['subwards'=>$subwards,'projects'=>$projects,'subwardMap'=>$subwardMap]);

    }
    public function Unupdated(Request $request){

        $wards = Ward::orderby('ward_name','ASC')->get();
        $wardid= $request->subward;
        $previous = date('Y-m-d',strtotime('-45 days'));
        $today = date('Y-m-d');
        $total = "";
        $site = SiteAddress::all();
        $names = user::get();
        $status =  $request->status;
        if($status != null){
            $projectsat = new Collection;
            for($i = 0; $i<count($status); $i++)
            {
                $project = ProjectDetails::where('project_status' ,'LIKE', "%".$status[$i]."%")->pluck('project_id');
                $projectsat = $projectsat->merge($project);
            }

        }
        if(!$request->subward && $request->ward && $request->status){
            $from="";
            $to="";
            if($request->ward == "All"){
                $subwards = SubWard::pluck('id');
            }else{
                $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
            }
            $projectid = ProjectDetails::where( 'updated_at', '<=', $previous)
                    ->whereIn('sub_ward_id',$subwards)
                    ->whereIn('project_id',$projectsat)
                    ->paginate('20');

            $totalproject =ProjectDetails::where( 'updated_at', '<=', $previous)
                    ->whereIn('sub_ward_id',$subwards)
                    ->whereIn('project_id',$projectsat)
                    ->count();

        }
        else if(!$request->subward && $request->ward){
            $from="";
            $to="";
            if($request->ward == "All"){
                $subwards = SubWard::pluck('id');
            }else{
                $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
            }
            $projectid = ProjectDetails::where( 'updated_at', '<=', $previous)
                    ->whereIn('sub_ward_id',$subwards)
                    ->paginate('20');

            $totalproject =ProjectDetails::where( 'updated_at', '<=', $previous)
                    ->whereIn('sub_ward_id',$subwards)->count();
           
             // return view('unupdated',['project'=>$projectid,'wards'=>$wards,'site'=>$site,'from'=>$from,'to'=>$to,'total'=>$total,'totalproject'=>$totalproject]);
        }
        else if($request->subward && $request->ward && $request->status){
         $from=$request->from;
        $to=$request->to;

        $projectid = ProjectDetails::whereIn('project_id',$projectsat)
                        ->where('sub_ward_id',$request->subward)
                        ->where('updated_at','<=',$previous)
                        ->paginate('20');
        $totalproject = ProjectDetails::where('updated_at','<=',$previous)
                        ->where('sub_ward_id',$request->subward)
                        ->whereIn('project_id',$projectsat)
                        ->count();
        }
        else if($request->subward && $request->ward){
            $from=$request->from;
            $to=$request->to;
            $projectid = ProjectDetails::where('updated_at','<=',$previous)
                        ->where('sub_ward_id',$request->subward)
                        ->paginate('20');
            $totalproject = ProjectDetails::where('updated_at','<=',$previous)
                            ->where('sub_ward_id',$request->subward)->count();
             // return view('unupdated',['project'=>$projectid,'wards'=>$wards,'site'=>$site,'from'=>$from,'to'=>$to,'total'=>$total,'totalproject'=>$totalproject]);
        }

        else{
                $projectid = new Collection;
                $total = "";
                $from = "";
                $to = "";
                $totalproject = "";
                $site = "";
                
        }
        return view('unupdated',['projects'=>$projectid,'wards'=>$wards,'from'=>$from,'to'=>$to,'total'=>$total,'totalproject'=>$totalproject,'site'=>$site,'previous'=>$previous,'today'=>$today,'names'=>$names]);
    }
    public function getDaily()
    {
        $totalRequirement = 0;
        $totalPrice = 0;
        $totalMonthly = 0;
        $totalMonthlyPrice = 0;
        $totalTP = 0;
        $totalTarget = 0;
        $projections = Detail::where('details.ward_id','all')
                            ->leftJoin('wards','wards.id','details.ward_id')
                            ->select('details.*','wards.ward_name')
                            ->get();
        $category = Projection::all()->toArray();
        foreach($category as $category){
            $totalCategory = 0;
            $totalCategoryPrice = 0;
            $conversion = Conversion::where('category',$category['category'])->first();
            $utilizations = Utilization::where('category',$category['category'])->first()->toArray();
            foreach($projections as $projection){
                if($projection['stage'] == "Electrical & Plumbing")
                    $stage = "electrical";
                else
                    $stage = $projection['stage'];
                $totalCategory += ($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]);
                $totalCategoryPrice += ($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]) * $category['price'];
            }
            $totalRequirement += $totalCategory;
            $totalPrice += $totalCategoryPrice;
            $monthly = $totalCategory/$category['business_cycle'];
            $monthlyPrice = $totalCategoryPrice/$category['business_cycle'];
            $totalMonthly += $totalCategory/$category['business_cycle'];
            $totalMonthlyPrice += $totalCategoryPrice/$category['business_cycle'];
            
            // $totalMonthly/100*$category['target'];
            $totalTarget += $amount = $monthlyPrice/100*$category['target'];
            $totalTP += $tp = $amount/100*$category['transactional_profit'];   
        }
        $projection = Projection::pluck('from_date')->first();
        $toDate = Projection::pluck('to_date')->first();
        return view('projection.daily',['projection'=>$projection,'totalTarget'=>$totalTarget,'totalTP'=>$totalTP,'toDate'=>$toDate]);
    }
    public function lockYearly(Request $request)
    {
        $planning = new Planning;
        $planning->incremental_percentage = $request->incremental_percentage;
        $planning->type = $request->type;
        $planning->totalTarget = $request->totalTarget;
        $planning->totalTP = $request->totalTP;
        $planning->save();
        return back();
    }
    public function getCountryProjection()
    {
        $planning = Planning::where('type','yearly')->first();
        $zone = Zone::first();
        $country = Country::where('id',$zone->id)->first();
        $zone_name = "MH_".$country->country_code."_".$zone->zone_number;
        $dates = Projection::first();
        $numberOfZones = NumberOfZones::all()->toArray();
        return view('projection.country',['planning'=>$planning,'zone_name'=>$zone_name,'zone'=>$zone,'dates'=>$dates,'numberOfZones'=>$numberOfZones]);
    }
    public function getAuditorDashboard()
    {
        return view('auditor.dashboard');
    }
    public function getExpenditure(Request $request)
    {
        $capitalExpenditure = CapitalExpenditure::first();
        $operationalExpenditure = OperationalExpenditure::first();
        if(count($capitalExpenditure) != 0 && !$request->edit){
            return redirect('/viewExpenditure');
        }
        return view('expenditure.expenditures',['capitalExpenditure'=>$capitalExpenditure,'operationalExpenditure'=>$operationalExpenditure]);
    }
    public function saveExpenditure(Request $request)
    {
        $check1 = CapitalExpenditure::first();
        if($check1 == null){
            $capital = new CapitalExpenditure;
            $capital->rental = $request->deposit;
            $capital->assets = $request->assets;
            $capital->save();
        }else{
            $check1->rental = $request->deposit;
            $check1->assets = $request->assets;
            $check1->save();
        }
        $check2 = OperationalExpenditure::first();
        if($check2 == null){
            $operational = new OperationalExpenditure;
            $operational->salary = $request->salary;
            $operational->office_rent = $request->rent;
            $operational->petrol = $request->petrol;
            $operational->travelling = $request->travel;
            $operational->mmt_user_fee = $request->mmt_fees;
            $operational->telephone_charges = $request->phone_charges;
            $operational->miscellineous = $request->miscellineous;
            $operational->save();
        }else{
            $check2->salary = $request->salary;
            $check2->office_rent = $request->rent;
            $check2->petrol = $request->petrol;
            $check2->travelling = $request->travel;
            $check2->mmt_user_fee = $request->mmt_fees;
            $check2->telephone_charges = $request->phone_charges;
            $check2->miscellineous = $request->miscellineous;
            $check2->save();
        }
        return redirect('/viewExpenditure');
    }
    public function viewExpenditure()
    {
        $capitalExpenditure = CapitalExpenditure::first();
        $operationalExpenditure = OperationalExpenditure::first();
        $planning = Planning::where('type','yearly')->first();
        if(count($capitalExpenditure) == 0)
            return redirect('/expenditure');
        return view('expenditure.viewExpenditures',['capitalExpenditure'=>$capitalExpenditure,'operationalExpenditure'=>$operationalExpenditure,'planning'=>$planning]);
    }
    public function getFiveYearsExpenditure()
    {
        $capitalExpenditure = CapitalExpenditure::first();
        $operationalExpenditure = OperationalExpenditure::first();
        $planning = Planning::where('type','yearly')->first();
        return view('expenditure.five_years',['capitalExpenditure'=>$capitalExpenditure,'operationalExpenditure'=>$operationalExpenditure,'planning'=>$planning]);
    }
    public function save(Request $request)
    {
        NumberOfZones::truncate();
        for($i = 0; $i < count($request->month); $i++){
            $zones = new NumberOfZones;
            $zones->month = $request->month[$i];
            $zones->grade_a = $request->gradeA[$i];
            $zones->grade_b = $request->gradeB[$i];
            $zones->grade_c = $request->gradeC[$i];
            $zones->grade_d = $request->gradeD[$i];
            $zones->grade_e = $request->gradeE[$i];
            $zones->save();
        }
        return back();
    }
    public function getExtensionPlanner()
    {
        $dates = Projection::first();
        return view('projection.extension',['dates'=>$dates]);
    }
    public function getFiveYears()
    {
        $totalTarget = Planning::where('type','yearly')->pluck('totalTarget')->first();
        $totalTP = Planning::where('type','yearly')->pluck('totalTP')->first();
        $projection = Projection::pluck('from_date')->first();
        return view('projection.fiveYears',['totalTarget'=>$totalTarget,'totalTP'=>$totalTP,'projection'=>$projection]);
    }
    public function getReset(Request $request)
    {
        if($request->category == "all"){
            Projection::truncate();
            Detail::truncate();
            Planning::truncate();
        }else{
            Projection::where('category',$request->category)->delete();
        }
        return redirect('/stage');
    }
    public function getYearlyPlanning(Request $request)
    {
        $totalRequirement = 0;
        $totalPrice = 0;
        $totalMonthly = 0;
        $totalMonthlyPrice = 0;
        $totalTP = 0;
        $totalTarget = 0;
        $projections = Detail::where('details.ward_id','all')
                            ->leftJoin('wards','wards.id','details.ward_id')
                            ->select('details.*','wards.ward_name')
                            ->get();
        $category = Projection::all()->toArray();
        foreach($category as $category){
            $totalCategory = 0;
            $totalCategoryPrice = 0;
            $conversion = Conversion::where('category',$category['category'])->first();
            $utilizations = Utilization::where('category',$category['category'])->first();
            foreach($projections as $projection){
                if($projection['stage'] == "Electrical & Plumbing")
                    $stage = "electrical";
                else
                    $stage = $projection['stage'];
                $totalCategory += ($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]);
                $totalCategoryPrice += ($projection['size'] * $conversion->minimum_requirement/$conversion->conversion)/100*($utilizations[strtolower($stage)]) * $category['price'];
            }
            $totalRequirement += $totalCategory;
            $totalPrice += $totalCategoryPrice;
            $monthly = $totalCategory/$category['business_cycle'];
            $monthlyPrice = $totalCategoryPrice/$category['business_cycle'];
            $totalMonthly += $totalCategory/$category['business_cycle'];
            $totalMonthlyPrice += $totalCategoryPrice/$category['business_cycle'];
            
            $totalMonthly/100*$category['target'];
            $totalTarget += $amount = $monthlyPrice/100*$category['target'];
            $totalTP += $tp = $amount/100*$category['transactional_profit'];   
        }
        $projection = Projection::pluck('from_date')->first();
        $categories = Projection::all();
        return view('projection.yearly',['projection'=>$projection,'totalTarget'=>$totalTarget,'totalTP'=>$totalTP,'categories'=>$categories]);
    }
    public function getEditProjectionPlanner()
    {
        $dates = Projection::first();
        $projections = NumberOfZones::all()->toArray();
        return view('projection.extension',['dates'=>$dates,'projections'=>$projections]);
    }
    public function assigntl(request $request){

          $users = User::where('group_id',22)
            ->paginate(10);
            $def =[1,2];
            $user1 = User::whereIn('department_id',$def)
            ->where('users.group_id','!=',2)
            ->get();
          $ward = Ward::all();
          $tlward = Tlwards::all();

        return view('/assigntl',['users'=>$users,'ward'=>$ward,'user1'=>$user1]);
    }
    public function tlward(request $request){
        $check = Tlwards::where('user_id',$request->user_id)->first();
        if($request->framework){
            
        $users = implode(",", $request->framework);
        }else{
            $users="null";
        }

       if(($check) == null){
            $tlward=new Tlwards;
            $tlward->user_id = $request->user_id;
             $tlward->group_id = $request->group_id;
             $tlward->users = $users;
              $tlward->ward_id = $request->ward_id;
              $tlward->save();
        }else{
             $check->user_id = $request->user_id;
             $check->group_id = $request->group_id;
              $check->ward_id = $request->ward_id;
              $check->users = $users;
              $check->save();
        }
        return back();
    }
    public function storedetails(Request $request){
         $id = $request->id;
         $value= $request->value;
          $x = ProjectDetails::where('project_id',$id)->update([
                'detailed_mcal' => $request->value
            ]);
         if($x && $value== "yes")
        {
            return back()->with('success','MAMAHOME Executive Will Contact You Shortly.');
        }
        else{
            return back()->with('success','Thank You :)');
        }
    }
     public function addManufacturer()
    {
        return view('addManufacturer');
    }
    
    public function addManufacturer()
    {
        return view('addManufacturer');
    }
    public function viewManufacturer()
    {
        $manufacturers = Manufacturer::all();
        return view('viewManufacturer',['manufacturers'=>$manufacturers]);
    }
    public function lebrands(){

        return view('lebrands');
    }
    public function storequery(Request $request){

       
        $id = History::where('project_id',$request->id)->pluck('id')->last();
        History::where('id',$id)->update(['question'=>$request->qstn,
                                            'remarks'=>$request->remarks
            ]);
        
         return redirect()->back();
    }
}
