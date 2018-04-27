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

        $depart = [2,4,8,6,7,15];
        $projects = ProjectDetails::where('project_id', $request->projectId)->first();
        $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        return view('inputview',['category'=>$category,'users'=>$users,'projects'=>$projects,'brand'=>$brand]);
    }
    public function inputdata(Request $request)
    {
        
        $sub_cat_name = SubCategory::where('id',$request->subcat)->first();
        $brand = brand::where('id',$sub_cat_name->brand_id)->first();
        $category= Category::where('id',$sub_cat_name->category_id)->first();
        $var = count($request->subcat);
        $var1 = count($brand);
        $var2 = count($category);
        $storecategory = $request->mCategory[0];
        $storebrand = $request->bnd[0];
        $storesubcat =$request->subcat[0];
       
         if($var > 1)
         {
            for($i = 1 ; $i<$var ; $i++)
            {
                 $brand .=",".$request->subcat[$i];
            }
         }
          if($var1 > 1)
         {
            for($i = 1 ; $i<$var1 ; $i++)
            {
                 $brand .=",".$brand[$i];
            }
         }
         if($var2 > 1)
         {
            for($i = 1 ; $i<$var2 ; $i++)
            {
                 $category .=",".$category[$i];
            }
         }

        // if($request->mCategory == "All"){
        //     $category = "All";
        // }else{
        //     $category = Category::where('id',$request->mCategory)->pluck('category_name')->first();
        // }
        // if($request->sCategory == "All"){
        //     $subcategory = "All";
        // }else{
        //     $subcategory = SubCategory::where('id',$request->sCategory)->pluck('sub_cat_name')->first();
        // }

        // if($request->brand == "All"){
        //     $brand = "All";
        // }else{
        //     $brand = DB::table('brands')->where('id',$request->brand)->pluck('brand')->first();
        // }
        $x = DB::table('requirements')->insert(['project_id'    =>$request->selectprojects,
                                                'main_category' =>$category->category_name,
                                                'brand' => $brand->brand,
                                                'sub_category'  =>$storesubcat,
                                                'material_spec' =>'',
                                                'referral_image1'   =>'',
                                                'referral_image2'   =>'',
                                                'requirement_date'  =>$request->edate,
                                                'measurement_unit'  =>$request->measure != null?$request->measure:'',
                                                'unit_price'   =>$request->econtact,
                                                'quantity'     =>$request->equantity,
                                                'total'   =>0,
                                                'notes'  =>$request->eremarks,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s'),
                                                'status' => "Enquiry On Process",
                                                'dispatch_status' => "Not yet dispatched",
                                                'generated_by' => $request->initiator
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
    public function enquirysheet(Request $request)
    {
        $totalofenquiry = "";
        $wards = SubWard::orderby('sub_ward_name','ASC')->get();
        $category = Category::all();  
        $depart = [6,7];
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
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
            }else{
                $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                            ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                            ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                            ->get();
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
            $totalofenquiry = Requirement::where('main_category',$request->category)->sum('quantity');
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
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif($request->from && $request->to && $request->initiator && $request->category && $request->ward){
            // everything
            $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id','=',$request->ward)
                        ->where('requirements.generated_by',$request->initiator)
                        ->where('requirements.created_at','>',$from)
                        ->where('requirements.created_at','<',$to)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->where('requirements.main_category',$request->category)
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif($request->from && $request->to && !$request->initiator && !$request->category && $request->ward){
            // from, to and ward
            $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('project_details.sub_ward_id','=',$request->ward)
                        ->where('requirements.created_at','>',$from)
                        ->where('requirements.created_at','<',$to)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif($request->from && $request->to && $request->initiator && !$request->category && !$request->ward){
            // from, to and initiator
            $from = $request->from;
            $to = $request->to;
           
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('requirements.generated_by','=',$request->initiator)
                        ->where('requirements.created_at','>',$from)
                        ->where('requirements.created_at','<',$to)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
                    
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif($request->from && $request->to && !$request->initiator && $request->category && !$request->ward){
            // from, to and category
            $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('requirements.main_category','=',$request->category)
                        ->where('requirements.created_at','>',$from)
                        ->where('requirements.created_at','<',$to)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif($request->from && $request->to && $request->initiator && $request->category && !$request->ward){
            // from, to, initiator and category
            $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('requirements.main_category','=',$request->category)
                        ->where('requirements.generated_by','=',$request->initiator)
                        ->where('requirements.created_at','>',$from)
                        ->where('requirements.created_at','<',$to)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }elseif($request->from && $request->to && !$request->initiator && $request->category && $request->ward){
            // from, to, wards and category
            $from = $request->from;
            $to = $request->to;
            $enquiries = Requirement::leftjoin('users','users.id','=','requirements.generated_by')
                        ->leftjoin('procurement_details','procurement_details.project_id','=','requirements.project_id')
                        ->leftjoin('project_details','project_details.project_id','=','requirements.project_id')
                        ->where('requirements.main_category','=',$request->category)
                        ->where('project_details.sub_ward_id','=',$request->ward)
                        ->where('requirements.created_at','>',$from)
                        ->where('requirements.created_at','<',$to)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_name','procurement_details.procurement_contact_no','procurement_details.procurement_email','users.name','project_details.sub_ward_id')
                        ->get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
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
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        }
        return view('enquirysheet',[
            'totalofenquiry'=>$totalofenquiry,
            'subwards2'=>$subwards2,
            'enquiries'=>$enquiries,
            'wards'=>$wards,
            'category'=>$category,
            'initiators'=>$initiators
        ]);
    }
    public function enquiryCancell(Request $request)
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
                        ->where('requirements.status',"Enquiry Cancelled")


                        ->get();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        
        return view('enquiryCancell',[
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
        $depart = [2,4,6,7,8];
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
    public function eqpipelineedit(Request $request)
    {
        $category = Category::all();
        $depart = [2,4,6,7,8];
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
    public function index1(Request $request )
    {
        $totalListing = array();
        $date = date('Y-m-d');
        $users = User::where('department_id','1')->where('group_id','6')
                    ->leftjoin('ward_assignments','users.id','ward_assignments.user_id')
                    ->leftjoin('sub_wards','ward_assignments.subward_id','sub_wards.id')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();
                 
        $check =DB::table('stages')->where('list',Auth::user()->name)
                    ->orderby('created_at','DESC')->pluck('status');
        $count = count($check);
        $status = DB::table('project_details')->whereIn('project_status' , $check )->get();        
        // $projects = ProjectDetails::where('created_at','like',$date[0].'%')->get();
        $le = DB::table('users')->where('department_id','1')->where('group_id','6')->get();
       
        
        $projects = DB::table('project_details')
            ->leftjoin('owner_details', 'project_details.project_id', '=', 'owner_details.project_id')
            ->leftjoin('sub_wards', 'project_details.sub_ward_id', '=', 'sub_wards.id')
            ->leftjoin('procurement_details', 'procurement_details.project_id', '=', 'project_details.project_id')
            ->leftjoin('users','users.id','=','project_details.listing_engineer_id')
            ->leftjoin('site_engineer_details','site_engineer_details.project_id','=','project_details.project_id')
            ->leftjoin('contractor_details','contractor_details.project_id','=','project_details.project_id')
            ->leftjoin('consultant_details','consultant_details.project_id','=','project_details.project_id')
            ->where('project_status' , $check)
            ->select('project_details.*','procurement_details.procurement_contact_no','contractor_details.contractor_contact_no','consultant_details.consultant_contact_no','site_engineer_details.site_engineer_contact_no', 'owner_details.owner_contact_no','users.name','sub_wards.sub_ward_name')
            ->paginate(15);
         
            
        return view('status_wise_projects', ['date' => $date,'users'=>$users,  'projects' => $projects, 'le' => $le, 'totalListing'=>$totalListing,'status' =>$status,'status'=>$check]);
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
        }else if($group == "Sales converter" && $dept == "Sales"){
            return redirect('scdashboard');
        }else if($group == "Marketing Exective" && $dept == "Marketing"){
            return redirect('marketingdashboard');
        }else if(Auth::user()->department_id == 10){

            Auth()->logout();
            return view('errors.403error');
        }else {
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
         
         return view('/teamLeader');
    }
    public function assignListSlots(){          
    $group = Group::where('group_name','Listing Engineer')->pluck('id')->first();
        $users = User::where('group_id',$group)
                        ->join('ward_assignments','ward_assignments.user_id','=','users.id')
                        ->join('sub_wards','sub_wards.id','=','ward_assignments.subward_id')
                        ->join('wards','wards.id','=','sub_wards.ward_id' )
                        ->join('employee_details','users.employeeId','=','employee_details.employee_id')
                        ->where('department_id','!=','10')
                        ->select('users.employeeId','users.id','users.name','ward_assignments.status','sub_wards.sub_ward_name','sub_wards.sub_ward_image','ward_assignments.prev_subward_id','employee_details.office_phone')
                        ->get();
    
        $wards = Ward::orderby('ward_name','ASC')->get();
        $zones = Zone::all();
        $subwardsAssignment = WardAssignment::all();
        $subwards = SubWard::orderby('sub_ward_name','ASC')->get();
        
        return view('assignListSlots',['users'=>$users,'subwards'=>$subwards,'subwardsAssignment'=>$subwardsAssignment,'wards'=>$wards,'zones'=>$zones]);
    }
     public function tlmaps()
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
        $roomtypes = RoomType::where('project_id',$request->projectId)->get();
        $projectward = SubWard::where('id',$projectdetails->sub_ward_id)->pluck('sub_ward_name')->first();
        $user = User::where('id',$projectdetails->listing_engineer_id)->pluck('name')->first();
        $updater = User::where('id',$projectdetails->updated_by)->first();
        return view('update',[
                    'updater'=>$updater,
                    'username'=>$user,
                    'subwards'=>$subwards,
                    'projectdetails'=>$projectdetails,
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
        $roads = ProjectDetails::where('sub_ward_id',$assignment)->groupBy('road_name')->pluck('road_name');
        
        $projectCount = array();
        $todays = ProjectDetails::where('listing_engineer_id',Auth::user()->id)->where('created_at','LIKE',date('Y-m-d')."%")->count();
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
        return view('roads',['todays'=>$todays,'roads'=>$roads,'projectCount'=>$projectCount]);
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
                        "</td></tr><tr><td>Morning Remarks</td><td>:</td><td>".
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
                        "</td></tr><tr><td>Morning Remarks</td><td>:</td><td>".
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
        $todays = ProjectDetails::where('listing_engineer_id',Auth::user()->id)->where('created_at','LIKE',date('Y-m-d')."%")->count();
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
        return view('requirementsroad',['todays'=>$todays,'roads'=>$roads,'projectCount'=>$projectCount]);
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
        $assignment = salesassignment::where('user_id',$id->userid)->first();
        $ward = SubWard::where('id',$assignment->assigned_date)->first();
        $assignment->prev_assign = $ward->sub_ward_name;
        $assignment->status = 'Completed';
        $assignment->save();
        salesassignment::where('user_id',Auth::user()->id)->delete();
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
            'genuineProjects'=>$genuineProjects
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
    public function amorders()
    {
        $view = Order::orderby('project_id','DESC')
                ->leftJoin('users','orders.generated_by','=','users.id')
                ->select('orders.*','orders.id as orderid','users.name','users.group_id')
                ->paginate(25);
        return view('ordersadmin',['view' => $view]);
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
        $x = Order::where('id', $id)->update(['delivery_status'=>'Delivered']);
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
    public function projectsUpdate()
    {
        $assignment = salesassignment::where('user_id',Auth::user()->id)->pluck('assigned_date')->first();
        $subwards = SubWard::where('id',$assignment)->pluck('sub_ward_name')->first();
        $projects = ProjectDetails::where('sub_ward_id', $assignment)->paginate(10);
        $projectscount = ProjectDetails::where('sub_ward_id', $assignment)->count();
        if(Auth::user()->id == 82){
            $projects = ProjectDetails::where('created_at','LIKE',$assignment."%")->paginate(10);
            $projectscount = ProjectDetails::where('created_at','LIKE', $assignment."%")->count();
        }elseif(Auth::user()->id == 85){
            $projects = ProjectDetails::where('created_at','LIKE',"2018-04-19%")->paginate(10);
            $projectscount = ProjectDetails::where('created_at','LIKE', "2018-04-19%")->count();
        }elseif(Auth::user()->id == 78){
            $projects = ProjectDetails::where('created_at','LIKE',$assignment."%")->paginate(10);
            $projectscount = ProjectDetails::where('created_at','LIKE', $assignment."%")->count();
        }
        // $projects = ProjectDetails::where('created_at','like',$assignment.'%')->orderBy('created_at', 'desc')->paginate(15);
        return view('salesengineer',['projects'=>$projects,'subwards'=>$subwards,'projectscount'=>$projectscount]);
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

            foreach($users as $user){
                $totalListing[$user->id] = ProjectDetails::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
            }
        $projcount = count($projects);  
        return view('dailyslots', ['date' => $date,'users'=>$users, 'projcount' => $projcount, 'projects' => $projects, 'le' => $le, 'totalListing'=>$totalListing]);
    }
    public function getleinfo(Request $request)
    {
        $records = array();
        $id = $request->id;
        $from = $request->from;
        $to = $request->to;
        if($from == $to){
            return redirect('/gettodayleinfo?from='.$from.'&id='.$id);
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
    public function getProjectSize(Request $request)
    {
        $wards = Ward::all();
        $projects = ProjectDetails::where('deleted',0)->get();

        // getting total no of projects
        $wardsselect = Ward::pluck('id');
        $subwards = SubWard::whereIn('ward_id',$wardsselect)->pluck('id');
        $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Planning')->count();
        $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Planning')->sum('project_size');
        $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Foundation')->count();
        $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Foundation')->sum('project_size');
        $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Roofing')->count();
        $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Roofing')->sum('project_size');
        $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Walls')->count();
        $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Walls')->sum('project_size');
        $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Completion')->count();
        $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Completion')->sum('project_size');
        $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Fixtures')->count();
        $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Fixtures')->sum('project_size');
        $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Pillars')->count();
        $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Pillars')->sum('project_size');
        $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Paintings')->count();
        $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Paintings')->sum('project_size');
        $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Flooring')->count();
        $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Flooring')->sum('project_size');
        $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Plastering')->count();
        $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Plastering')->sum('project_size');
        $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Digging')->count();
        $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Digging')->sum('project_size');
        $enpCount           = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Electrical & Plumbing')->count();
        $enpSize            = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Electrical & Plumbing')->sum('project_size');
        $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Carpentry')->count();
        $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Carpentry')->sum('project_size');


        $totalProjects = $planningCount + $diggingCount + $foundationCount + $pillarsCount + $completionCount + $fixturesCount + $paintingCount + $carpentryCount + $flooringCount + $plasteringCount + $enpCount + $roofingCount + $wallsCount;
        
        if($request->ward && !$request->subward){
            if($request->ward == "All"){
                $wardsselect = Ward::pluck('id');
                $subwards = SubWard::whereIn('ward_id',$wardsselect)->pluck('id');
                $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Planning')->count();
                $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Planning')->sum('project_size');
                $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Foundation')->count();
                $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Foundation')->sum('project_size');
                $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Roofing')->count();
                $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Roofing')->sum('project_size');
                $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Walls')->count();
                $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Walls')->sum('project_size');
                $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Completion')->count();
                $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Completion')->sum('project_size');
                $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Fixtures')->count();
                $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Fixtures')->sum('project_size');
                $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Pillars')->count();
                $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Pillars')->sum('project_size');
                $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Paintings')->count();
                $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Paintings')->sum('project_size');
                $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Flooring')->count();
                $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Flooring')->sum('project_size');
                $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Plastering')->count();
                $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Plastering')->sum('project_size');
                $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Digging')->count();
                $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Digging')->sum('project_size');
                $enpCount           = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Electrical & Plumbing')->count();
                $enpSize            = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Electrical & Plumbing')->sum('project_size');
                $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Carpentry')->count();
                $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Carpentry')->sum('project_size');
                $wardname = "All";
                $subwards = SubWard::all();
            }else{
                $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
                $planningCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Planning')->count();
                $planningSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Planning')->sum('project_size');
                $foundationCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Foundation')->count();
                $foundationSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Foundation')->sum('project_size');
                $roofingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Roofing')->count();
                $roofingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Roofing')->sum('project_size');
                $wallsCount         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Walls')->count();
                $wallsSize          = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Walls')->sum('project_size');
                $completionCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Completion')->count();
                $completionSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Completion')->sum('project_size');
                $fixturesCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Fixtures')->count();
                $fixturesSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Fixtures')->sum('project_size');
                $pillarsCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Pillars')->count();
                $pillarsSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Pillars')->sum('project_size');
                $paintingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Paintings')->count();
                $paintingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Paintings')->sum('project_size');
                $flooringCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Flooring')->count();
                $flooringSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Flooring')->sum('project_size');
                $plasteringCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Plastering')->count();
                $plasteringSize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Plastering')->sum('project_size');
                $diggingCount       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Digging')->count();
                $diggingSize        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Digging')->sum('project_size');
                $enpCount           = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Electrical & Plumbing')->count();
                $enpSize            = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Electrical & Plumbing')->sum('project_size');
                $carpentryCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Carpentry')->count();
                $carpentrySize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Carpentry')->sum('project_size');
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
                'wards'=>$wards,
                'wardname'=>$wardname,
                'subwards'=>$subwards,'wardId'=>$request->ward,'planning'=>NULL,'subwardId'=>NULL,'subwardName'=>NULL,'totalProjects' => $totalProjects
            ]);
        }
        if($request->subward){
            $subwards = SubWard::where('ward_id',$request->ward)->pluck('id');
            $planningCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Planning')->count();
            $planningSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Planning')->sum('project_size');
            $foundationCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Foundation')->count();
            $foundationSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Foundation')->sum('project_size');
            $roofingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Roofing')->count();
            $roofingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Roofing')->sum('project_size');
            $wallsCount        = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Walls')->count();
            $wallsSize         = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Walls')->sum('project_size');
            $completionCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Completion')->count();
            $completionSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Completion')->sum('project_size');
            $fixturesCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Fixtures')->count();
            $fixturesSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Fixtures')->sum('project_size');
            $pillarsCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Pillars')->count();
            $pillarsSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Pillars')->sum('project_size');
            $paintingCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Painting')->count();
            $paintingSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Painting')->sum('project_size');
            $flooringCount     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Flooring')->count();
            $flooringSize      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Flooring')->sum('project_size');
            $plasteringCount   = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Plastering')->count();
            $plasteringSize    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Plastering')->sum('project_size');
            $diggingCount      = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Digging')->count();
            $diggingSize       = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Digging')->sum('project_size');
            $enpCount          = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Electrical & Plumbing')->count();
            $enpSize           = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Electrical & Plumbing')->sum('project_size');
            $carpentryCount    = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Carpentry')->count();
            $carpentrySize     = ProjectDetails::whereIn('sub_ward_id',$subwards)->where('project_status','Carpentry')->sum('project_size');

            $wardname = Ward::where('id',$request->ward)->first();
            $subwards = SubWard::where('ward_id',$request->ward)->get();
            $total = ProjectDetails::where('sub_ward_id',$request->subward)->count();

            $planning = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Planning')->sum('project_size');
            $foundation = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Foundation')->sum('project_size');
            $roofing = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Roofing')->sum('project_size');
            $walls = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Walls')->sum('project_size');
            $completion = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Completion')->sum('project_size');
            $fixtures = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Fixtures')->sum('project_size');
            $pillars = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Pillars')->sum('project_size');
            $painting = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Painting')->sum('project_size');
            $flooring = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Flooring')->sum('project_size');
            $plastering = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Plastering')->sum('project_size');
            $digging = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Digging')->sum('project_size');
            $enp = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Electrical & Plumbing')->sum('project_size');
            $carpentry = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Carpentry')->sum('project_size');

            $Cplanning = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Planning')->count();
            $Cfoundation = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Foundation')->count();
            $Croofing = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Roofing')->count();
            $Cwalls = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Walls')->count();
            $Ccompletion = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Completion')->count();
            $Cfixtures = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Fixtures')->count();
            $Cpillars = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Pillars')->count();
            $Cpainting = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Painting')->count();
            $Cflooring = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Flooring')->count();
            $Cplastering = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Plastering')->count();
            $Cdigging = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Digging')->count();
            $Cenp = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Electrical & Plumbing')->count();
            $Ccarpentry = ProjectDetails::where('sub_ward_id',$request->subward)->where('project_status','Carpentry')->count();

            $subwardname = SubWard::where('id',$request->subward)->pluck('sub_ward_name')->first();
            $totalsubward = ProjectDetails::where('sub_ward_id',$request->subward)->sum('project_size');
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
    public function viewDailyReport($uId, $date){
        $reports = Report::where('empId',$uId)->where('created_at','like',$date.'%')->get();
        $user = User::where('employeeId',$uId)->first();
        $attendance = attendance::where('empId',$uId)->where('date',$date)->first();
        return view('viewdailyreport',['reports'=>$reports,'date'=>$date,'user'=>$user,'attendance'=>$attendance]);
    }
    public function followup(){
        $projects = ProjectDetails::where('followup',"Yes")
            ->where('follow_up_by',Auth::user()->id)
            ->where('deleted',0)
            ->paginate(10);
        return view('followup',['projects'=>$projects]);
    }
    public function confirmedProject(Request $request){
        $check = projectDetails::where('project_id',$request->id)->first();
        if($check->confirmed == Null || $check->confirmed == "False"){
            projectDetails::where('project_id',$request->id)
            ->update([
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
        return- back();

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
      
   if(!$request){
        $pipelines = Requirement::where('requirements.generated_by',Auth::user()->id)
                        ->leftjoin('procurement_details','requirements.project_id','procurement_details.project_id')
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->select('requirements.*','procurement_details.procurement_contact_no','procurement_details.procurement_name')
                        ->get();

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
        return view('eqpipeline',['pipelines'=>$pipelines,'subwards2'=>$subwards2]);
    }
    public function letraining(Request $request)
    {
         $depts = Department::all();
        $grps = Group::all();
        $users = User::all();
        $videos = training::where('dept',"1")
                        ->where('designation',"6")
                        ->get();
return view('letraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps,'users'=>$users]);
    
}
public function setraining(Request $request)
    {
         $depts = Department::all();
        $grps = Group::all();
        $videos = training::where('dept',"2")
                        ->where('designation',"7")
                        ->get();
return view('setraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps]);
    
}
public function asttraining(Request $request)
    {
         $depts = Department::all();
        $grps = Group::all();
        $videos = training::where('dept',"5")
                        ->where('designation',"4")
                        ->get();
return view('asttraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps]);
    
}
public function adtraining(Request $request)
    {
         $depts = Department::all();
        $grps = Group::all();
        $videos = training::where('dept',"5")
                        ->where('designation',"3")
                        ->get();
return view('adtraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps]);
    
}
public function tltraining(Request $request)
    {
         $depts = Department::all();
        $grps = Group::all();
        $videos = training::where('dept',"1")
                        ->where('designation',"2")
                        ->get();
return view('tltraining',['video'=>$videos,'depts'=>$depts,'grps'=>$grps]);
    
}
    public function employeereports(Request $request)
    {
        $depts = [1,2,3,4,5];
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
            $projects = ProjectDetails::whereIn('project_details.project_id',$ids)->where('deleted',0)
                            ->leftjoin('users','users.id','=','project_details.listing_engineer_id')
                            ->leftjoin('sub_wards','project_details.sub_ward_id','=','sub_wards.id')
                            ->leftjoin('site_addresses','site_addresses.project_id','=','project_details.project_id')
                            ->select('project_details.*','users.name','sub_wards.sub_ward_name','site_addresses.address')
                            ->where('deleted',0)
                            ->get();
            return view('viewallprojects',['wards'=>$wards,'users'=>$users,'projects'=>$projects,'wards'=>$wards,'users'=>$users]);
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
            $str = ActivityLog::where('time','>',$request->fromdate)
                    ->where('time','<',$request->todate)
                    ->where('activity','LIKE','%Updated a project%')->get();
        }elseif($request->se != "ALL" && $request->fromdate && $request->todate){
            $date = $request->fromdate;
            $str = ActivityLog::where('time','>',$request->fromdate)
                    ->where('time','<',$request->todate)
                    ->where('employee_id',$request->se)
                    ->where('activity','LIKE','%Updated a project%')->get();
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
        }
        $noOfCalls = array();
        $users = User::where('group_id','7')->where('department_id',2)
                    ->leftjoin('salesassignments','salesassignments.user_id','users.id')
                    ->leftJoin('sub_wards','sub_wards.id','salesassignments.assigned_date')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();
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
        return view('salesReport',['users'=>$users,
                'date'=>$date,
                'projectsCount'=>$projectsCount,
                'noOfCalls'=>$noOfCalls,
                'projectIds'=>$projectIds
            ]);
    }


     public function editEnq1(Request $request)
    {
        $category = Category::all();
        $depart = [2,4,6,7,8];
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
        return view('editEnq1',['enq'=>$enq,'category'=>$category,'users'=>$users]);
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
        $dates->name = $request->name;
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
    public function getWardMaping()
    {
        $zones = Zone::leftjoin('maps','zones.id','maps.zone_id')
                    ->select('zones.*','maps.lat','maps.color','maps.zone_id')
                    ->get();
        return view('maping.wardmaping',['zones'=>$zones]);
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
                    ->leftjoin('stages','stages.list','user.name')
                    ->select('users.*','departments.dept_name','groups.group_name')

                    ->paginate(10);
             $stages = Stages::where('status','')->get();
              

            $wards = Ward::all();
                 
         $le = DB::table('users')->where('department_id','1')->where('group_id','6')->get();
          $se = DB::table('users')->where('department_id','2')->where('group_id','7')->get();
         return view('assigndate',['le' => $le ,'se' => $se,'users'=>$users]);
        
}

}
