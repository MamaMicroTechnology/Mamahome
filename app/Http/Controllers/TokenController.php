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
        $messages = new Collection;
        if(Auth::attempt(['email'=>$request->username,'password'=>$request->password])){
            $userdetails = User::where('id',Auth::user()->id)->first();
            return response()->json(['message' => 'true','userid'=>$userdetails->id]);
        }else{
            return response()->json(['message' => 'false']);
        }
    }
}