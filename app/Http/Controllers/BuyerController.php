<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use DB;
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
use App\EmployeeDetails;
use App\BankDetails;
use App\Asset;
use App\AssetInfo;
use App\Category;
use App\SubCategory;
use App\CategoryPrice;
use App\ManufacturerDetail;
use App\Certificate;

class BuyerController extends Controller
{
    public function buyerLogin(){
        if(Auth::check()){
            return redirect()->back();
        }
        return view('buyer.buyerlogin');
    }
    public function buyerLogout(){
        Auth::logout();
        return redirect('/blogin');
    }
    public function buyerHome(){
        $view = Requirement::join('users','users.id','=','requirements.generated_by')->where('users.id','=',Auth::user()->id)->select('requirements.*','users.name')->paginate(25);
        $count = count($view);
        return view('buyer.buyerhome',['view' => $view, 'count' => $count]);
    }
    //Siddharth
    public function myProfile(){
        $view = DB::table('users')->where('id',Auth::user()->id)->first();
        return view('buyer.buyerProfile',['view' => $view]);
    }
    public function updateProfile(Request $request)
    {
        $x = User::where('id',Auth::user()->id)->update(['name' => $request->name, 'email' => $request->email, 'contactNo' => $request->contactNo]);
        if($x){
            return back()->with('success','Updated Successfully !!!');
        }
    }
    //Siddharth
    public function postBuyerLogin(Request $request){
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
             return response()->json(['message'=>'sucuss']);
            return redirect('/buyerhome');
        }else{

            return response()->json(['message'=>'Something went wrong']);
            return back();
        }
    }
}