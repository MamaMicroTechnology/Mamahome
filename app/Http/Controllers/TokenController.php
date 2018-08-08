<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use App\Message;
use App\Department;
use Validator;
use App\UserLocation;
use App\Aregister;
use App\ProjectDetails;
use App\SiteAddress;  
use DB;  
use App\loginTime;
use App\Requirement;
use App\RoomType;
use App\Category;
use App\SubCategory;
use App\brand;
use App\WardAssignment;
use App\SubWard;
use App\SubWardMap;
use App\TrackLocation;



use App\Http\Resources\Message as MessageResource;

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
        $subwardMap = SubWardMap::where('sub_ward_id',$subwards->id)->first();
        $check = loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->get();
         if(count($check)==0){
           DB::table('login_times')->where('user_id',$userdetails)->insert(['tracktime'=>date('H:i A')]);
          }else{
             loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update(['tracktime'=>date('H:i A')]);
                    }
            return response()->json(['message' => 'true','userid'=>$userdetails->id,'userName'=>$userdetails->name,'wardAssigned'=>$subwards->sub_ward_name,'latlon'=>$subwardMap->lat]);
        
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
            return response()->json(['message' => 'true','userid'=>$userdetails->id,'userName'=>$userdetails->name,'phoneNumber'=>$userdetails->contactNo]);
        }
        else{
            return response()->json(['message' => 'false']);
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
            return response()->json(['message'=>'This email/phone number has already been used.']);
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
            
//             View::share('password',$request->password);
//             View::share('email',$request->email);
//             View::share('name',$request->name);
//             Mail::to($request->email)->send(new registration($user));

            return response()->json(['message'=>'Registered']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
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
            }else{
                $statuses=null;
            }
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
               
;
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
            $projectdetails->road_width = $request->road_width;
            $projectdetails->construction_type =$request->construction_type;
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
            
            $siteaddress->address = $request->address;
            $siteaddress->save();
        if($projectdetails->save() ||  $siteaddress->save() ||  $roomtype->save() ){
            return response()->json(['message'=>'Add project sucuss']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
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
        $enquiry->save();
          if($enquiry->save() ){
            return response()->json(['message'=>'Enquiry Added sucuss']);
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
        $category = Category::all();
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
    public function postUpdateProject(Request $requet)
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
            }else{
                $statuses=null;
            }
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            $length = $request->length;
            $breadth = $request->breadth;
            $size = $length * $breadth;
            
            $projectdetails = ProjectDetails::where('project_id',$request->project_id)->first();
            
            $projectdetails->project_name = $request->project_name;
            $projectdetails->road_width = $request->road_width;
            $projectdetails->construction_type =$request->construction_type;
            $projectdetails->interested_in_rmc = $request->interested_in_rmc;
            $projectdetails->interested_in_loan = $request->interested_in_loan;
            $projectdetails->interested_in_doorsandwindows = $request->interested_in_doorsandwindows;
            $projectdetails->road_name = $request->road_name;
            if($request->municipality_approval != NULL){
                $data = $request->all();
                $png_url = $request->userid."municipality_approval-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_url;
                $img = $data['municipality_approval'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['municipality_approval']);   
                $success = file_put_contents($path, $decoded);
                $projectdetails->municipality_approval = $png_url;
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
            }
            $projectdetails->project_status = $statuses;
            $projectdetails->project_size = $request->project_size;
            $projectdetails->budgetType = $request->budgetType;
            $projectdetails->budget = $request->budget;
            if($request->image){
                $data = $request->all();
                $png_project =$request->userid."project_image-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_project;
                $img = $data['image'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['image']);   
                $success = file_put_contents($path, $decoded);
                $projectdetails->image = $png_project;
            }
            $projectdetails->user_id = $request->userid;
            
            $projectdetails->basement = $basement;
            $projectdetails->ground = $ground;
            $projectdetails->project_type = $floor;
            $projectdetails->length = $length;
            $projectdetails->breadth = $breadth;
            $projectdetails->plotsize = $size;
            $projectdetails->user_id = $request->user_id;
            
           
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

            $siteaddress = SiteAddress::where('project_id',$request->project_id);
            $siteaddress->project_id = $projectdetails->id;
             $siteaddress->latitude = $request->latitude;
             $siteaddress->longitude = $request->longitude;
            $siteaddress->address = $request->address;
            $siteaddress->save();
        if($projectdetails->save() ||  $siteaddress->save() ||  $roomtype->save() ){
            return response()->json(['message'=>'Add project sucuss']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
        }
    }
    public function addLocation(Request $request){

       
        $data = new TrackLocation;
        $data->user_id = $request->user_id;
        $data->lat_long = $request->lat_long;
        $data->date = $request->date;
        $data->kms = $request->kms;
        
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

        //update location
      public function updateLocation(Request $request){
              $data = TrackLocation::where('user_id',$request->user_id)
                          ->where('date',$request->date)
                          ->first();
              $data->user_id = $request->user_id;
            $data->lat_long = $request->lat_long;
            $data->date = $request->date;
            $data->kms = $request->kms;
            if($data->save()){
               $responseData = array('success'=>'1', 'data'=>$data, 'message'=>"Location has been Updated successfully");
               $userResponse = json_encode($responseData);
               print $userResponse;
            }else{
                $responseData = array('success'=>'0', 'data'=>$data, 'message'=>"Location could not be updated");
               $userResponse = json_encode($responseData);
               print $userResponse;
            }

       }
}
