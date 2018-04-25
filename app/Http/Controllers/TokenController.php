<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use App\Message;
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
        $userlist = "";
        foreach($users as $i){
            $userlist .="<p>".$i->name."<br><small>".$i->email."</small></p>";
        }
        // Create token from user + add claims data
        $token = $auth->fromUser($user, $claims);
        return response()->json(['token' => $token,'user'=>$user,'userlist'=>$userlist]);
    }
    public function index()
    {
        $articles = Message::orderBy('messages.created_at','asc')
                    ->leftJoin('users','users.id','messages.from_user')
                    ->select('messages.body','users.name','users.id')
                    ->get();
        return MessageResource::collection($articles);
    }
    public function store(Request $request)
    {
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
    public function logout()
    {
    	Auth::logout();
    	return redirect('/login');
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
}