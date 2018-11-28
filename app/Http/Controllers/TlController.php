<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requirement;
use App\SubWard;
use App\Category;
use App\User;
use App\Manufacturer;
use App\WardAssignment;
use App\SubWardMap;
use Auth;
use App\FieldLogin;
class TlController extends Controller
{
    
  public function delete_enquiry(Request $Request){

      Requirement::where('id',$Request->projectId)->delete();
      return back();
  }

 public function search_enquiry(Request $Request){
              $cancelcount = 0;
        $wards = SubWard::orderby('sub_ward_name','ASC')->get();
        $category = Category::all();
        $depart = [6,7];
        $initiators = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
        $subwards2 = array();
     $enquiries = Requirement::where('project_id',$Request->phNo)->where('status',"Enquiry Cancelled")->paginate("10");               
        $cancelcount = count( $enquiries);
        return view('enquiryCancell',[
            'cancelcount' =>$cancelcount,
            'subwards2'=>$subwards2,
            'enquiries'=>$enquiries,
            'wards'=>$wards,
            'category'=>$category,
            'initiators'=>$initiators
        ]);
  
      return back();

 }
 public function manumap(Request $Request){

        $wardsAssigned = WardAssignment::where('user_id',Auth::user()->id)->where('status','Not Completed')->pluck('subward_id')->first();
     $projects = Manufacturer::where('sub_ward_id',$wardsAssigned)->get();

        $subwards = SubWard::where('id',$wardsAssigned)->first();
        if($subwards != null){
            $subwardMap = SubWardMap::where('sub_ward_id',$subwards->id)->first();
        }else{
            $subwardMap = "None";
        }
        if($subwardMap == Null){
            $subwardMap = "None";
        }
          $date = date('Y-m-d');
        $log = FieldLogin::where('user_id',Auth::user()->id)->where('created_at','LIKE',$date.'%')->count();
           
           $log1 = FieldLogin::where('user_id',Auth::user()->id)->where('logout','!=','NULL')->pluck('logout')->count();


        return view('/manu_map',['projects'=>$projects,'subwardMap'=>$subwardMap,'log'=>$log,
                                                'log1'=>$log1]);

 }
}

