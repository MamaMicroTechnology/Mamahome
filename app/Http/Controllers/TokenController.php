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
        $check = loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->get();
         if(count($check)==0){
           DB::table('login_times')->where('user_id',$userdetails)->insert(['tracktime'=>date('H:i A')]);
          }else{
             loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update(['tracktime'=>date('H:i A')]);
                    }
            return response()->json(['message' => 'true','userid'=>$userdetails->id,'userName'=>$userdetails->name]);
        
    }
        else{
            return response()->json(['message' => 'false']);
        }
    }
    public function buyerLogin(Request $request)
    {
        $messages = new Collection;
        if(Auth::attempt(['contactNo'=>$request->email,'password'=>$request->password]) || Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $userdetails = User::where('id',Auth::user()->id)->first();
            return response()->json(['message' => 'true','userid'=>$userdetails->id,'userName'=>$userdetails->name,'phoneNumber'=>$userdetails->contactNo]);
        }else{
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
                $imageName1 = time().'.'.request()->municipality_approval->getClientOriginalExtension();
                $request->municipality_approval->move(public_path('projectImages'),$imageName1);
            }else{
                $imageName1 = "N/A";
            }
            $i = 0;
            if($request->other_approvals){
                foreach($request->other_approvals as $oApprove){
                    $imageName2 = $i.time().'.'.$other_approvals->getClientOriginalExtension();
                    $other_approvals->move(public_path('projectImages'),$imageName2);
                    if($i == 0){
                        $otherApprovals .= $imageName2;
                    }else{
                        $otherApprovals .= ", ".$imageName2;
                    }
                    $i++;
                }
            }else{
             $otherApprovals=null;   
            }
            $i = 0;
            if($request->image){
                foreach($request->image as $pimage){
                     $imageName3 = $i.time().'.'.$pimage->getClientOriginalExtension();
                     $pimage->move(public_path('projectImages'),$imageName3);
                     if($i == 0){
                        $projectimage .= $imageName3;
                     }
                     else{
                            $projectimage .= ",".$imageName3;
                     }
                     $i++;
                }
        
            }else{
                $projectimage=null;
            }
           
            
            $projectdetails = New ProjectDetails;
           
            $projectdetails->project_name = $request->project_name;
            $projectdetails->road_width = $request->road_width;
            $projectdetails->construction_type =$request->construction_type;
            $projectdetails->interested_in_rmc = $request->interested_in_rmc;
            $projectdetails->interested_in_loan = $request->interested_in_loan;
            $projectdetails->interested_in_doorsandwindows = $request->interested_in_doorsandwindows;
            $projectdetails->road_name = $request->road_name;
            $projectdetails->municipality_approval = $imageName1;
            $projectdetails->other_approvals = $otherApprovals;
            $projectdetails->project_status = $statuses;
            $projectdetails->project_size = $request->project_size;
            $projectdetails->budgetType = $request->budgetType;
            $projectdetails->budget = $request->budget;
            $projectdetails->image = $projectimage;
            
            $projectdetails->basement = $basement;
            $projectdetails->ground = $ground;
            $projectdetails->project_type = $floor;
            $projectdetails->length = $length;
            $projectdetails->breadth = $breadth;
            $projectdetails->plotsize = $size;
           
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
        $enquiry->main_caegory = $request->main_caegory;
        $enquiry->brand = $request->brand;
        $enquiry->sub_category = $request->sub_category;
        $enquiry->reqirement_date = $request->reqirement_date;
        $enquiry->notes = $request->remark;
        $enquiry->A_contact = $request->A_contact;
        $enquiry->save();
          if($enquiry->save() ){
            return response()->json(['message'=>'Enquiry Added sucuss']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
        }
 } 

           
}
