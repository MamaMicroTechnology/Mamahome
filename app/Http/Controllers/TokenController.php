<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Mail\registration;
use Illuminate\Http\Request;
use App\Department;
use App\User;
use Session;
use App\Group;
use App\Builder;
use App\ProjectUpdate;
use App\AssignCategory;
use App\Ward;
use App\SubWard;
use App\Country;
use App\Territory;
use App\WardAssignment;
use App\ProjectDetails;
use App\ConsultantDetails;
use App\ContractorDetails;
use App\ProcurementDetails;
use App\OwnerDetails;
use App\SiteAddress;
use App\SiteEngineerDetails;
use App\EmployeeDetails;
use App\State;
use App\Zone;
use App\loginTime;
use App\Requirement;
use Auth;
use App\attendance;
use Validator;
use Hash;
use App\salesassignment;
use App\BankDetails;
use App\AssetInfo;
use App\Certificate;
use App\Category;
use App\SubCategory;
use App\CategoryPrice;
use App\ManufacturerDetail;
use App\RoomType;
use App\ActivityLog;
use App\RecordData;
use App\Order;
use App\Map;
use App\brand;
use App\WardMap;
use App\Point;
use App\ZoneMap;
use App\SubWardMap;
use App\Asset;
use App\Check;
use App\Manufacturer;
use App\ManufacturerProduce;
use App\MamahomeAsset;
use App\ProjectImage;
use App\Tlwards;
use App\FieldLogin;
use Carbon\Carbon;
use App\TrackLocation;
use App\Report;
use App\Salescontact_Details;
use App\Manager_Deatils;
use App\Mprocurement_Details;
use App\Mowner_Deatils;
use App\Banner;
use Spatie\Activitylog\Models\Activity;

use App\Http\Resources\Message as MessageResource;
date_default_timezone_set("Asia/Kolkata");
class TokenController extends Controller
{
    /**
     * Create and return a token if the user is logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function token(\Tymon\JWTAuth\JWTAuth $auth)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'not_logged_in'], 401);
        }

        // Claims will be sent with the token
        $user = Auth::user();
        $claims = ['name' => $user->name, 'email' => $user->email];
        $users = User::where('department_id','!=',10)->get();
        $departmentList = "<p><a href='/'>All</a></p>";
        $departments = Department::get();
        foreach($departments as $department){
            $departmentList .= "<p><a href='".$department->id."'>".$department->dept_name."</a></p>";
        }
        // Create token from user + add claims data
        $token = $auth->fromUser($user, $claims);
        return response()->json(['token' => $token,'user'=>$user,'userlist'=>$departmentList]);
    }
    public function index()
    {
        $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->where('messages.to_user','All')
                    ->select('messages.body','users.name','users.id')
                    ->get();
        return MessageResource::collection($articles);
    }
    public function store(Request $request)
    {
        $article = new Message;
        $article->from_user = $request->input('id');
        $article->to_user = "All";
        $article->body = $request->input('body');

        if($article->save()){
            $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->select('messages.body','users.name','users.id')
                    ->where('messages.id',$article->id)
                    ->first();
            return new MessageResource($articles);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function apilogout()
    {
        Auth::logout();
        return response()->json(['status'=>"logged out"]);
    }
    public function pms(Request $request)
    {
        $mymessages = Message::where('from_user',$request->authId)
                    ->where('to_user',$request->userId)
                    ->get();
        $hismessages = Message::where('from_user',$request->userId)
                    ->where('to_user',$request->authId)
                    ->get();
        $messages = $mymessages->merge($hismessages);
        $messages = $messages->sortBy('created_at');
        return new MessageResource($messages);
    }
    // getting management messages
    public function ManagementMessages(Request $request)
    {
        $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->where('messages.to_user','1')
                    ->select('messages.body','users.name','users.id')
                    ->get();
        return MessageResource::collection($articles);
    }
    public function ManagementMessage(Request $request){
        $article = new Message;
        $article->from_user = $request->input('id');
        $article->to_user = "1";
        $article->body = $request->input('body');

        if($article->save()){
            $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->select('messages.body','users.name','users.id')
                    ->where('messages.id',$article->id)
                    ->first();
            return new MessageResource($articles);
        }
    }
    // it
    public function itMessages(Request $request)
    {
        $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->where('messages.to_user','it')
                    ->select('messages.body','users.name','users.id')
                    ->get();
        return MessageResource::collection($articles);
    }
    public function itMessage(Request $request){
        $article = new Message;
        $article->from_user = $request->input('id');
        $article->to_user = "it";
        $article->body = $request->input('body');

        if($article->save()){
            $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->select('messages.body','users.name','users.id')
                    ->where('messages.id',$article->id)
                    ->first();
            return new MessageResource($articles);
        }
    }
    // tl
    public function tlMessages(Request $request)
    {
        $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->where('messages.to_user','tl')
                    ->select('messages.body','users.name','users.id')
                    ->get();
        return MessageResource::collection($articles);
    }
    public function tlMessage(Request $request){
        $article = new Message;
        $article->from_user = $request->input('id');
        $article->to_user = "tl";
        $article->body = $request->input('body');

        if($article->save()){
            $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->select('messages.body','users.name','users.id')
                    ->where('messages.id',$article->id)
                    ->first();
            return new MessageResource($articles);
        }
    }
     public function getLogin(Request $request)
    {
         date_default_timezone_set("Asia/Kolkata");
        $messages = new Collection;
        if(Auth::attempt(['email'=>$request->username,'password'=>$request->password])){
            $userdetails = User::where('id',Auth::user()->id)->first();

        $wardsAssigned = WardAssignment::where('user_id',$userdetails->id)->where('status','Not Completed')->pluck('subward_id')->first();
        $subwards = SubWard::where('id',$wardsAssigned)->first();
        if($subwards == null){
            $subwards = null;
        }else{
            $subwards = $subwards->sub_ward_name;
        }
        
        // $subwardMap = SubWardMap::where('sub_ward_id',$subwards->id)->first();
        $check = loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->get();
        if(count($check)==0){
            $loginTime = new loginTime;
            $loginTime->user_id = $userdetails->id;
            $loginTime->logindate = date('Y-m-d');
            $loginTime->loginTime = date('H:i A');
            $loginTime->tracktime = date('H:i A');
            $loginTime->save();
            //    DB::table('login_times')->where('user_id',$userdetails)->insert(['tracktime'=>date('H:i A')]);
        }else{
            loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update(['tracktime'=>date('H:i A')]);
        }
        $logistics_order = Order::where('delivery_boy',$userdetails->id)->first();
        $logistics = Order::where('delivery_boy',$userdetails->id)->pluck('orders.id')->first();
        if($logistics_order != null){
            $logistic_sub_ward = ProjectDetails::where('project_id',$logistics_order->project_id)->pluck('sub_ward_id')->first();
        }else{
            $logistic_sub_ward = null;
        }
        return response()
                ->json(['message' => 'true',
                    'userid'=>$userdetails->id,
                    'userName'=>$userdetails->name,
                    'wardAssigned'=>$subwards,
                    'order_project_id'=>$logistics_order->project_id,
                    'sub_category'=>$logistics_order->sub_category,
                    'order_id'=>$logistics,
                    'logistic_sub_ward'=>$logistic_sub_ward

                ]);
        }
        else{
            return response()->json(['message' => 'false']);
        }
    }
	public function tracklogin(Request $request)
    {
         date_default_timezone_set("Asia/Kolkata");
        $messages = new Collection;
        if(Auth::attempt(['email'=>$request->username,'password'=>$request->password])){
            $userdetails = User::where('id',Auth::user()->id)->first();
	$modes = User::where('group_id',Auth::user()->group_id)->pluck('group_id')->first();
		if($modes == "6" || $modes == "11"){
			$mode = 0;
		}
		else{
			$mode = 1;
		}
		
        $wardsAssigned = WardAssignment::where('user_id',$userdetails->id)->where('status','Not Completed')->pluck('subward_id')->first();
        $subwards = SubWard::where('id',$wardsAssigned)->first();
        if($subwards == null){
            $subward = null;
        }else{
            $subward = $subwards->sub_ward_name;
        }
  
        $subwardMap = SubWardMap::where('sub_ward_id',$subwards->id)->first();
	if($subwardMap == null){
	$latlon = null;
	}else{
	$latlon = $subwardMap->lat;
	}
        $check = loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->get();
        if(count($check)==0){
            $loginTime = new loginTime;
            $loginTime->user_id = $userdetails->id;
            $loginTime->logindate = date('Y-m-d');
            $loginTime->loginTime = date('H:i A');
            $loginTime->tracktime = date('H:i A');
	    $loginTime->applogintime = $request->applogintime;
            $loginTime->save();
            //    DB::table('login_times')->where('user_id',$userdetails)->insert(['tracktime'=>date('H:i A')]);
        }else{
            loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update(['tracktime'=>date('H:i A')]);
        }
        $logistics_order = Order::where('delivery_boy',$userdetails->id)->first();
        $logistics = Order::where('delivery_boy',$userdetails->id)->pluck('orders.id')->first();
        if($logistics_order != null){
            $logistic_sub_ward = ProjectDetails::where('project_id',$logistics_order->project_id)->pluck('sub_ward_id')->first();
        }else{
            $logistic_sub_ward = null;
        }
        return response()
                ->json(['message' => 'true',
                    'userid'=>$userdetails->id,
                    'userName'=>$userdetails->name,
                    'wardAssigned'=>$subward,
		    'mode'=>$mode,
         	    'latlon'=>$latlon
		   
                ]);
        }
        else{
            return response()->json(['message' => 'false']);
        }
    }
  public function buyerLogin(Request $request)
    {
        $messages = new Collection;
        if(Auth::attempt(['contactNo'=>$request->email,'password'=>$request->password]) || Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            $userdetails = User::where('id',Auth::user()->id)->first();
            return response()->json(['message' => 'true','success'=>1,'userid'=>$userdetails->id,'userName'=>$userdetails->name,'phoneNumber'=>$userdetails->contactNo]);
        }
        else{
            return response()->json(['message' => 'false','success'=>0]);
        }
    }


    public function saveLocation(Request $request)
    {
        $location = new UserLocation;
        $location->user_id = $request->userid;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->save();
        $messages = new Collection;
        return response()->json(['message'=>'true']);
    }
    public function getregister(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>'0','message'=>'This email/phone number has already been used.']);
        }
        $user = new User;
        $user->employeeId = $request->email;
        $user->department_id = 100;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contactNo = $request->number;
        $user->category = $request->category;
        $user->password = bcrypt($request->password);
        $user->save();
        if($user->save()){
            return response()->json(['success'=>'1','message'=>'Registered']);
        }else{
            return response()->json(['success'=>'0','message'=>'Something went wrong']);
        }
    }
    public function addProject(Request $request)
    {
        $cType = count($request->constructionType);
        $type = $request->constructionType[0];
        $otherApprovals = "";
        $projectimage = "";
        if($cType != 1){
            $type .= ", ".$request->constructionType[1];
        }else{
             $type=null;
        }

        
        $statusCount = count($request->project_status);
        $statuses = $request->project_status[0];
            if($statusCount > 1){
                for($i = 1; $i < $statusCount; $i++){
                    $statuses .= ", ".$request->project_status[$i];
                }
            }
            // else{
            //     $statuses=null;
            // }
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            $length = $request->length;
            $breadth = $request->breadth;
            $size = $length * $breadth;
            
            if($request->municipality_approval != NULL){
             $data = $request->all();
                $png_url = $request->userid."municipality_approval-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_url;
                $img = $data['municipality_approval'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['municipality_approval']);   
                $success = file_put_contents($path, $decoded);
               

            }
            else{
                 $png_url  = "N/A";
            }
            

      
            if($request->other_approvals){
                $data = $request->all();
                $png_other = $request->userid."other_approvals-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_other;
                $img = $data['other_approvals'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['other_approvals']);   
                $success = file_put_contents($path, $decoded);
                  
                
            }
            else{
              $png_other = null;   
            }
          
          if($request->image){
                $data = $request->all();
                $png_project =$request->userid."project_image-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_project;
                $img = $data['image'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['image']);   
                $success = file_put_contents($path, $decoded);

            }
            else{
                $png_project = null;
            }
           
            
            $projectdetails = New ProjectDetails;
           
            $projectdetails->project_name = $request->project_name;
            $projectdetails->sub_ward_id = $request->sub_ward_id;
            $projectdetails->road_width = $request->road_width;
            $projectdetails->construction_type =$type;
            $projectdetails->interested_in_rmc = $request->interested_in_rmc;
            $projectdetails->interested_in_loan = $request->interested_in_loan;
            $projectdetails->interested_in_doorsandwindows = $request->interested_in_doorsandwindows;
            $projectdetails->road_name = $request->road_name;
            $projectdetails->municipality_approval = $png_url;
            $projectdetails->other_approvals = $png_other;
            $projectdetails->project_status = $statuses;
            $projectdetails->project_size = $request->project_size;
            $projectdetails->budgetType = $request->budgetType;
            $projectdetails->budget = $request->budget;
            $projectdetails->image = $png_project;
            $projectdetails->user_id = $request->userid;
            $projectdetails->automation=$request->automation;
            $projectdetails->brilaultra=$request->brila;
            $projectdetails->Kitchen_Cabinates = $request->kitchen_cabinets;
            $projectdetails->interested_in_premium = $request->premium;
            $projectdetails->contract = $request->contract;
            $projectdetails->remarks = $request->remarks;
            $projectdetails->basement = $basement;
            $projectdetails->ground = $ground;
            $projectdetails->project_type = $floor;
            $projectdetails->length = $length;
            $projectdetails->breadth = $breadth;
            $projectdetails->plotsize = $size;
//             $projectdetails->user_id = $request->user_id;
            
           
            $projectdetails->remarks = $request->remarks;
            $projectdetails->contract = $request->contract;
           
            $projectdetails->save();
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            $length = $request->length;
            $breadth = $request->breadth;
            $size = $length * $breadth;
            
            $room_types = $request->roomType[0]." (".$request->number[0].")";
            $count = count($request->roomType);
            for($i = 0;$i<$count;$i++){
                $roomtype = new RoomType;
                $roomtype->floor_no = $request->floorNo[$i];
                $roomtype->room_type = $request->roomType[$i];
                $roomtype->no_of_rooms = $request->number[$i];
                $roomtype->project_id = $projectdetails->id;
                $roomtype->save();
            }

            $siteaddress = New SiteAddress;
            $siteaddress->project_id = $projectdetails->id;
             $siteaddress->latitude = $request->latitude;
            $siteaddress->longitude = $request->longitude;
            $siteaddress->address = $request->address;
            $siteaddress->save();
            

        
        if($projectdetails->save() ||  $siteaddress->save() ||  $roomtype->save() ){
            return response()->json(['success'=>'1','message'=>'Add project sucuss','status'=>$request->project_status]);
        }else{
            return response()->json(['success'=>'0','message'=>'Something went wrong']);
        }
    }
public function enquiry(request $request){
    
      
        $enquiry = new Requirement;
        $enquiry->project_id = $request->project_id;
        $enquiry->main_category = $request->main_category;
        $enquiry->brand = $request->brand;
        $enquiry->sub_category = $request->sub_category;
        $enquiry->requirement_date = $request->requirement_date;
        $enquiry->notes = $request->notes;
        $enquiry->A_contact = $request->A_contact;
        $enquiry->quantity = $request->quantity;
        $enquiry->user_id = $request->userid;
       
        $enquiry->save();
          if($enquiry->save() ){
            return response()->json(['message'=>'Enquiry Added sucuss','']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
        }
 } 
    public function updateEnquiry(request $request){
        
       
            $enquiry = Requirement::where('id',$request->id)->first();
                $enquiry->project_id = $request->project_id;
                $enquiry->main_category = $request->main_category;
                $enquiry->brand = $request->brand;
                $enquiry->sub_category = $request->sub_category;
                $enquiry->requirement_date = $request->requirement_date;
                $enquiry->notes = $request->notes;
                $enquiry->A_contact = $request->A_contact;
                $enquiry->quantity = $request->quantity;
                $enquiry->user_id = $request->userid;
              $enquiry->save();
                       
         
          if($enquiry->save()){
            return response()->json(['message'=>'Enquiry Updated sucuss']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
        }
 } 
public function getproject(request $request){
  $project = ProjectDetails::where('project_details.user_id',$request->user_id)
                    ->leftJoin('site_addresses','project_details.project_id','site_addresses.project_id')
                    ->select('project_details.*','site_addresses.address','site_addresses.latitude','site_addresses.longitude')
                    ->get();
      if($project != null){
         return response()->json(['message' => 'true','user_id'=>$request->user_id,'projectdetails'=>$project]);

      }else{
         return response()->json(['message'=>'No projects Found']);
      }
  }  
 public function getsingleProject(Request $request)
    {
        $project = ProjectDetails::where('project_details.project_id',$request->project_id)
                    ->leftJoin('room_types','project_details.project_id','room_types.project_id')
                    ->select('room_types.*')
                    ->get();
       
        return response()->json(['projectdetails'=>$project]);
    }       
  public function getenq(request $request){
    $enq = Requirement::where('project_id',$request->project_id)->get();
    if($enq != null){
         return response()->json(['message' => 'true','project_id'=>$request->project_id,'EnqDetails'=>$enq]);

      }else{
         return response()->json(['message'=>'No enquires Found']);
      }
  }   
   public function getbrands(){
        $category = Category::orderBy('priority','ASC')->get();
        $brand = brand::all();
        $sub_cat = SubCategory::all();   

        return response()->json(['category'=>$category,'brand'=>$brand,'sub_cat'=>$sub_cat]);    
    }
    public function getUpdateProject(Request $request)
    {
        $project = ProjectDetails::where('project_id',$request->project_id)->first();
        $contractor = $project->contractorDetails;
        $procurement = $project->procurementDetails;
        $consultant = $project->consultantDetails;
        $siteEngineer = $project->siteEngineerDetails;
        $owner = $project->ownerDetails;
        
        return response()->json(['project'=>$project,'contractor'=>$contractor,'procurement'=>$procurement,'consultant',$consultant,'siteEngineer'=>$siteEngineer,'owner'=>$owner]);
    }
    public function postUpdateProject(Request $request)
    {
        $cType = count($request->constructionType);
        $type = $request->constructionType[0];
        $otherApprovals = "";
        $projectimage = "";
        if($cType != 1){
            $type .= ", ".$request->constructionType[1];
        }else{
             $type=null;
        }
        
        $statusCount = count($request->project_status);
        $statuses = $request->project_status[0];
        if($statusCount > 1){
            for($i = 1; $i < $statusCount; $i++){
                $statuses .= ", ".$request->project_status[$i];
            }
        }
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            $length = $request->length;
            $breadth = $request->breadth;
            $size = $length * $breadth;
            $projectdetails = ProjectDetails::where('project_id',$request->project_id)->update([
                'project_name' => $request->project_name,
                'road_width'=>$request->road_width,
                'construction_type'=>$request->construction_type,
                'interested_in_rmc'=>$request->interested_in_rmc,
                'interested_in_loan'=>$request->interested_in_loan,
                'interested_in_doorsandwindows'=>$request->interested_in_doorsandwindows,
                'road_name'=>$request->road_name,
                'project_status' => $statuses,
                'project_size' => $request->project_size,
                'budgetType' => $request->budgetType,
                'budget' => $request->budget,
                'user_id' => $request->userid,
                'basement' => $basement,
                'ground' => $ground,
                'project_type' => $floor,
                'length' => $length,
                'breadth' => $breadth,
                'plotsize' => $size,
                
                'remarks' => $request->remarks,
                'contract' => $request->contract
            ]);
            // $projectdetails->project_name = $request->project_name;
            // $projectdetails->road_width = $request->road_width;
            // $projectdetails->construction_type =$request->construction_type;
            // $projectdetails->interested_in_rmc = $request->interested_in_rmc;
            // $projectdetails->interested_in_loan = $request->interested_in_loan;
            // $projectdetails->interested_in_doorsandwindows = $request->interested_in_doorsandwindows;
            // $projectdetails->road_name = $request->road_name;
          $siteaddress = SiteAddress::where('project_id',$request->project_id)->update([
                    'latitude' =>$request->latitude,
                    'longitude' =>$request->longitude,
                    'address' =>$request->address]);
                                                       
            $projectdetails = ProjectDetails::where('project_id',$request->project_id)->first();
            
            if($request->municipality_approval != NULL){
                $data = $request->all();
                $png_url = $request->userid."municipality_approval-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_url;
                $img = $data['municipality_approval'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['municipality_approval']);   
                $success = file_put_contents($path, $decoded);
                $projectdetails->municipality_approval = $png_url;
                $projectdetails->save();
            }
            if($request->other_approvals){
                $data = $request->all();
                $png_other = $request->userid."other_approvals-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_other;
                $img = $data['other_approvals'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['other_approvals']);   
                $success = file_put_contents($path, $decoded);
                $projectdetails->other_approvals = $png_other;
                $projectdetails->save();
            }
            if($request->image){
                $data = $request->all();
                $png_project =$request->userid."project_image-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_project;
                $img = $data['image'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['image']);   
                $success = file_put_contents($path, $decoded);
                $projectdetails->image = $png_project;
                $projectdetails->save();
            }
            
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            $length = $request->length;
            $breadth = $request->breadth;
            $size = $length * $breadth;
            
            $room_types = $request->roomType[0]." (".$request->number[0].")";
            $count = count($request->roomType);
            for($i = 0;$i<$count;$i++){
                $roomtype = new RoomType;
                $roomtype->floor_no = $request->floorNo[$i];
                $roomtype->room_type = $request->roomType[$i];
                $roomtype->no_of_rooms = $request->number[$i];
                $roomtype->project_id = $projectdetails->project_id;
                $roomtype->save();
            }
          
        if( $projectdetails->save() || $roomtype->save() ){
            return response()->json(['success'=>'1','message'=>'project Updated sucussfully']);
        }else{
            return response()->json(['success'=>'0','message'=>'Something went wrong']);
        }
    } 
    public function addLocation(Request $request){
         $check = TrackLocation::where('user_id',$request->user_id)->where('date',$request->date)->first();
	if(count($check) == 0){
       
        $data = new TrackLocation;
        $data->user_id = $request->user_id;
        $data->lat_long = $request->lat_long;
        $data->time = $request->time;
        $data->date = $request->date;
        $data->kms = $request->kms;
       }
	else{
		return $this->updateLocation($request);
	}

        if($data->save()){
            $responseData = array('success'=>'1', 'data'=>$data, 'message'=>"Location added to table");
            $userResponse = json_encode($responseData);
            print $userResponse;
        }else{
            $responseData = array('success'=>'0', 'data'=>$data, 'message'=>"Unable to add location.");
            $userResponse = json_encode($responseData);
            print $userResponse;
        }
    }
    public function fakegps(Request $request){
        $fake = new FakeGPS;
        $fake->user_id = $request->user_id;
        $fake->date = $request->date;
        $fake->time = $request->time;
        $fake->fakegps = $request->fakegps;
        
        if($fake->save()){
            return response()->json(['success'=>'1','message'=>'recieved']);
        }
        else{
            return reponse()->json(['success'=>'0','message'=>'error']);
        }
    }
        //update location
      public function updateLocation(Request $request){
            $data = TrackLocation::where('user_id',$request->user_id)
                        ->where('date',$request->date)
                        ->update([
            
                                'user_id' => $request->user_id,
                                'lat_long' => $request->lat_long,
                                'time' => $request->time,
                                'date' => $request->date,
                                'kms' => $request->kms
                                ]);                 
             if($data){
            return response()->json(['message'=>'Update Location  sucussfully']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
        }

       }
       public function pending(Request $request){
        $pending = Order::where('status','Enquiry Confirmed')->where('user_id',$request->userid)->get();
         return response()->json(['order'=>$pending]);
       }
        public function confirm(request $request){
        $confirm = Order::where('status','Order Confirmed')->where('user_id',$request->userid)->get();
         return response()->json(['order'=>$confirm]);
       }


     public function recordtime(Request $request)
    {
                        $field = new FieldLogin;
                        $field->user_id = $request->user_id;
                        $field->logindate = date('Y-m-d');
                        $field->logintime = date(' H:i A');
                        $field->remark = $request->remark;
                        $field->latitude = $request->latitude;
                        $field->longitude = $request->longitude;
                        $field->address = $request->address;
                        $field->save();

      if($field->save()){
           return response()->json(['message'=>'Login  sucuss']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
        }
    }
    public function fieldlogout(request $request){
       $x =  FieldLogin::where('user_id',$request->user_id)->where('logindate',date('Y-m-d'))->first();
            $x->logout = $request->logouttime;
            $x->save();
        if($x->save()){
                return response()->json(['message'=>'logout successfull']);
        }else{
                return response()->json(['message'=>'Something went wrong']);
        }
    }
  public function tracklogout(request $request){
            $check = TrackLocation::where('user_id',$request->user_id)->where('date',date('Y-m-d'))->update(['tracklogout'=>$request->tracklogout]);
        if($check){
                return response()->json(['message'=>'logout successfull']);
        }else{
                return response()->json(['message'=>'Something went wrong']);
        }
    }
    public function gettime(){
            $logintime = date('H:i:s');
            return response()->json(['message'=>$logintime]);
    }
    public function getreq(Request $request){
        $pending = Requirement::get();
         return response()->json(['order'=>$pending]);
       }
        public function data(request $request){


            $data = new Reactuser;
            $data->name = $request->username;
            $data->password = $request->email;
            $data->birthdate = $request->birthdate;
            
            if($data->save()){
                   return response()->json(['data'=>'successfull']);
            }else{
                    return response()->json(['data'=>'Something went wrong']);
            }
        }
         public function bannerdata(Request $request){
           $banner = Banner::get();
         return response()->json(['banner'=>$banner,'message'=>"Banner data"]);
       }
       public function addleProject(Request $request)
    {

        $point = 0;
        // counting points
        // project name
        $point = $request->pName != null ? $point+2 : $point+0;
        // road name
        $point = $request->rName != null ? $point+2 : $point+0;        
        // road width
        $point = $request->rWidth != null ? $point+4 : $point+0;
        // Construction type
        $point = $request->constructionType != null ? $point+5 : $point+0;
        // interested in rmc
        $point = $request->rmcinterest != null ? $point+3 : $point+0;
        // type of contract
        $point = $request->contract != null ? $point+6 : $point+0;
        // project status
        $point = $request->status != null ? $point+5 : $point+0;
        // project type
        $point = $request->basement != null && $request->ground != null ? $point+5 : $point+0;
        // project size
        $point = $request->pSize != null ? $point+8 : $point+0;
        // budgettype
        $point = $request->budgetType != null ? $point+3 : $point+0;
        // total budget
        $point = $request->budget != null ? $point+5 : $point+0;
        // project Image
        $point = $request->pImage != null ? $point+6 : $point+0;
        // room types
        $point = $request->roomType[0] != null ? $point+5 : $point+0;
        // owner details
        $point = $request->oName != null ? $point+5 : $point+0;
        $point = $request->oEmail != null ? $point+5 : $point+0;
        $point = $request->oContact != null ? $point+5 : $point+0;
        // contractor details
        $point = $request->cName != null ? $point+3 : $point+0;
        $point = $request->cEmail != null ? $point+3 : $point+0;
        $point = $request->cContact != null ? $point+3 : $point+0;
        // consultant details
        // $point = $request->coName != null ? $point+3 : $point+0;
        // $point = $request->coEmail != null ? $point+3 : $point+0;
        // $point = $request->coContact != null ? $point+3 : $point+0;
        // site engineer details
        $point = $request->eName != null ? $point+3 : $point+0;
        $point = $request->eEmail != null ? $point+3 : $point+0;
        $point = $request->eContact != null ? $point+3 : $point+0;
        // procurement details
        $point = $request->prName != null ? $point+3 : $point+0;
        $point = $request->pEmail != null ? $point+3 : $point+0;
        $point = $request->prPhone != null ? $point+3 : $point+0;
        $point = $request->remarks != null ? $point+10 : $point+0;
        
        // store points to database
        $points = new Point;
        $points->user_id = Auth::user()->id;
        $points->point = $point;
        $points->type = "Add";
        $points->reason = "Adding a project";
        $points->save();
        $cType = count($request->constructionType);
        $type = $request->constructionType[0];
        $otherApprovals = "";
        $projectimage = "";
        if($cType != 1){
            $type .= ", ".$request->constructionType[1];
        }else{
             $type=null;
        }

        $bapart = count($request->apart);
        if($request->apart != 0){
            $btype = implode(", ",$request->apart);
        }

     
        $btype = count($request->budgetType);
        if($request->budgetType != 0){
            $type2 = implode(", ",$request->budgetType);
        }
        $statusCount = count($request->project_status);
        $statuses = $request->project_status[0];
            if($statusCount > 1){
                for($i = 1; $i < $statusCount; $i++){
                    $statuses .= ", ".$request->project_status[$i];
                }
            }
            // else{
            //     $statuses=null;
            // }
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            $length = $request->length;
            $breadth = $request->breadth;
            $size = $length * $breadth;
            
            if($request->municipality_approval != NULL){
             $data = $request->all();
                $png_url = $request->userid."municipality_approval-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_url;
                $img = $data['municipality_approval'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['municipality_approval']);   
                $success = file_put_contents($path, $decoded);

            }
            else{
                 $png_url  = "N/A";
            }
            

      
            if($request->other_approvals){
                $data = $request->all();
                $png_other = $request->userid."other_approvals-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_other;
                $img = $data['other_approvals'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['other_approvals']);   
                $success = file_put_contents($path, $decoded);
                  
                
            }
            else{
              $png_other = null;   
            }
          
          if($request->image){
                $data = $request->all();
                $png_project =$request->userid."project_image-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_project;
                $img = $data['image'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['image']);   
                $success = file_put_contents($path, $decoded);

            }
            else{
                $png_project = null;
            }
           
            $ward = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
            $projectdetails = New ProjectDetails;
        
            $projectdetails->project_name = $request->project_name;
            $projectdetails->sub_ward_id = $ward;
            $projectdetails->road_width = $request->road_width;
            $projectdetails->construction_type =$request->construction_type;
            $projectdetails->interested_in_rmc = $request->interested_in_rmc;
            $projectdetails->interested_in_loan = $request->interested_in_loan;
            $projectdetails->interested_in_doorsandwindows = $request->interested_in_doorsandwindows;
            $projectdetails->interested_in_premium = $request->premium;
            $projectdetails->automation=$request->automation;
            $projectdetails->brilaultra=$request->brila;
            $projectdetails->road_name = $request->road_name;
            $projectdetails->municipality_approval = $png_url;
            $projectdetails->other_approvals = $png_other;
            $projectdetails->project_status = $statuses;
            $projectdetails->project_size = $request->project_size;
            $projectdetails->budgetType = $request->budgetType;
            $projectdetails->budget = $request->budget;
            $projectdetails->image = $png_project;
            $projectdetails->user_id = $request->userid;
            $projectdetails->basement = $basement;
            $projectdetails->ground = $ground;
            $projectdetails->project_type = $floor;
            $projectdetails->length = $length;
            $projectdetails->breadth = $breadth;
            $projectdetails->plotsize = $size;
            $projectdetails->remarks = $request->remarks;
            $projectdetails->contract = $request->contract;
            $projectdetails->res = $btype;
            $projectdetails->save();

            
            $room_types = $request->roomType[0]." (".$request->number[0].")";
            $count = count($request->roomType);
            for($i = 0;$i<$count;$i++){
                $roomtype = new RoomType;
                $roomtype->floor_no = $request->floorNo[$i];
                $roomtype->room_type = $request->roomType[$i];
                $roomtype->no_of_rooms = $request->number[$i];
                $roomtype->project_id = $projectdetails->id;
                $roomtype->save();
            }

            $siteaddress = New SiteAddress;
            $siteaddress->project_id = $projectdetails->id;
             $siteaddress->latitude = $request->latitude;
            $siteaddress->longitude = $request->longitude;
            $siteaddress->address = $request->address;
            $siteaddress->save();
                        $ownerDetails = New OwnerDetails;
            $ownerDetails->project_id = $projectdetails->project_id;
            $ownerDetails->owner_name = $request->oName;
            $ownerDetails->owner_email = $request->oEmail;
            $ownerDetails->owner_contact_no = $request->oContact;
            $ownerDetails->save();
        
            $contractorDetails = New ContractorDetails;
            $contractorDetails->project_id = $projectdetails->project_id;
            $contractorDetails->contractor_name = $request->cName;
            $contractorDetails->contractor_email = $request->cEmail;
            $contractorDetails->contractor_contact_no = $request->cContact;
            $contractorDetails->save();
        
            $consultantDetails = New ConsultantDetails;
            $consultantDetails->project_id = $projectdetails->project_id;
            $consultantDetails->consultant_name = $request->coName;
            $consultantDetails->consultant_email = $request->coEmail;
            $consultantDetails->consultant_contact_no = $request->coContact;
            $consultantDetails->save();
        
            $siteEngineerDetails = New SiteEngineerDetails;
            $siteEngineerDetails->project_id = $projectdetails->project_id;
            $siteEngineerDetails->site_engineer_name = $request->eName;
            $siteEngineerDetails->site_engineer_email = $request->eEmail;
            $siteEngineerDetails->site_engineer_contact_no = $request->eContact;
            $siteEngineerDetails->save();
        
            $procurementDetails = New ProcurementDetails;
            $procurementDetails->project_id = $projectdetails->project_id;
            $procurementDetails->procurement_name = $request->prName;
            $procurementDetails->procurement_email = $request->pEmail;
            $procurementDetails->procurement_contact_no = $request->prPhone;
            $procurementDetails->save();

            $procurementDetails = New Builder;
            $procurementDetails->project_id = $projectdetails->project_id;
            $procurementDetails->builder_name = $request->bName;
            $procurementDetails->builder_email = $request->bEmail;
            $procurementDetails->builder_contact_no = $request->bPhone;
            $procurementDetails->save();
        if($projectdetails->save() ||  $siteaddress->save() ||  $roomtype->save() ){
            return response()->json(['success'=>'1','message'=>'Add project successfully','status'=>$request->project_status]);
        }else{
            return response()->json(['success'=>'0','message'=>'Something went wrong']);
        }
    }

 public function getreq1(request $request){
            $enquiries = Requirement::where('requirements.status','!=',"Enquiry Cancelled")->get();
            $converter = user::get();
            $totalenq = count($enquiries);
             $ward = Ward::all();
            foreach($enquiries as $enquiry){
                $subwards2[$enquiry->project_id] = SubWard::where('id',$enquiry->sub_ward_id)->pluck('sub_ward_name')->first();
            }
        return response()->json(['sucuss'=>1, 'enquiries'=>$enquiries,'totalenq' =>$totalenq,'users'=>$converter,'ward'=>$ward]);

            
       
     
        }

 


public function postSaveManufacturer(Request $request)
    {
        
            $userGroup = User::where('id',$request->user_id)->first();
             if($userGroup->group_id == 22){
                  $wardsAssigned = $request->tlward;
             }else{
                
        $wardsAssigned = WardAssignment::where('user_id',$request->user_d)->where('status','Not Completed')->pluck('subward_id')->first();
             }


           if($request->production){
            $pro = implode(",",$request->production);
           }else{
            $pro = "null";
           }
        $projectimage = "";
            $i = 0;
            if($request->pImage){
                foreach($request->pImage as $pimage){
                     $imageName3 = $i.time().'.'.$pimage->getClientOriginalExtension();
                     $pimage->move(public_path('Manufacturerimage'),$imageName3);
                     if($i == 0){
                        $projectimage .= $imageName3;
                     }
                     else{
                            $projectimage .= ",".$imageName3;
                     }
                     $i++;
                }
        
            }

        $manufacturer = new Manufacturer;
        $manufacturer->listing_engineer_id = $request->user_id;
        $manufacturer->name = $request->name;
        $manufacturer->image = $projectimage;

        $manufacturer->sub_ward_id = $wardsAssigned;
        $manufacturer->plant_name = $request->plant_name;
        $manufacturer->latitude = $request->latitude;
        $manufacturer->longitude = $request->longitude;
        $manufacturer->address = $request->address;
        $manufacturer->contact_no = $request->phNo;
        $manufacturer->capacity = $request->capacity;
        $manufacturer->cement_requirement = $request->cement_requirement;
        $manufacturer->cement_requirement_measurement = $request->cement_required;
        $manufacturer->prefered_cement_brand = $request->brand;
        $manufacturer->sand_requirement = $request->sand_requirement;
        $manufacturer->aggregates_required = $request->aggregate_requirement;
        $manufacturer->manufacturer_type = $request->type;
        $manufacturer->type = $request->manufacturing_type;
        $manufacturer->moq = $request->moq;
        $manufacturer->total_area = $request->total_area;
        $manufacturer->remarks = $request->remarks;
        $manufacturer->production_type = $pro;


        $manufacturer->save();
        $sales = new Salescontact_Details;
       $sales->manu_id =  $manufacturer->id;
       $sales->name = $request->coName;
       $sales->email = $request->coEmail;
       $sales->contact = $request->coContact;
       $sales->contact1 = $request->coContact1;

       $sales->save();

       $manager = new Manager_Deatils;
       $manager->manu_id =  $manufacturer->id;
       $manager->name = $request->cName;
       $manager->email = $request->cEmail;
       $manager->contact = $request->cContact;
       $manager->contact1 = $request->cContact1;

       $manager->save();
    
       $proc = new Mprocurement_Details;
       $proc->manu_id =  $manufacturer->id;
       $proc->name = $request->prName;
       $proc->email = $request->pEmail;
       $proc->contact = $request->prPhone;
       $proc->contact1 = $request->prPhone1;

       $proc->save();

        $owner = new Mowner_Deatils;
       $owner->manu_id =  $manufacturer->id;
       $owner->name = $request->oName;
       $owner->email = $request->oEmail;
       $owner->contact = $request->oContact;
       $owner->contact1 = $request->oContact1;

       $owner->save();

        
        if($request->type == "Blocks"){
            // saving product details
            for($i = 0; $i < count($request->blockType); $i++){
                $products = new ManufacturerProduce;
                $products->manufacturer_id = $manufacturer->id;
                $products->block_type = $request->blockType[$i];
                $products->block_size = $request->blockSize[$i];
                $products->price = $request->price[$i];
                $products->save();
            }
        }elseif($request->type == "RMC"){
            // saving product details
            for($i = 0; $i < count($request->grade); $i++){
                $products = new ManufacturerProduce;
                $products->manufacturer_id = $manufacturer->id;
                $products->block_type = $request->grade[$i];
                $products->price = $request->gradeprice[$i];
                $products->save();
            }
        }elseif($request->type == "Fabricators"){
            // saving product details
            for($i = 0; $i < count($request->fab); $i++){
                $products = new ManufacturerProduce;
                $products->manufacturer_id = $manufacturer->id;
                $products->Fabricators_type = $request->fab[$i];
                $products->price = $request->fabprice[$i];
                $products->save();
            }
        }
        return response()->json(['message'=>"Manufacturer Added Successfully"]);
    }


public function getwards(request $request){


  $newUsers = [];
  $wards = Ward::all();
foreach($wards as $user){
            
                $noOfwards = WardMap::where('ward_id',$user->id)->get()->toArray();
                array_push($newUsers,['wardlat'=>$nofwards]);
            }
 return response()->json(['newUsers'=>$newUsers]);
}






}
