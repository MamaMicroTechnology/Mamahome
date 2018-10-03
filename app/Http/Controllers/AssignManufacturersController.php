<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\assign_manufacturers;
use Auth;
use App\Ward;
use App\Tlwards;
use App\SubWard;
use App\History;
use App\Manufacturer;
use App\User;
use App\ProjectDetails;
use App\Point;
use App\Requirement;
use App\ActivityLog;
use DB;
use Illuminate\Support\Collection;

class AssignManufacturersController extends Controller
{
 


  public function Manufacturestore(request $request)
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
if($request->subward )
     {
    $subwards = implode(", ", $request->subward);

    } else{
        $subwards = "null";
    }

 $check = assign_manufacturers::where('user_id',$request->user_id)->first();


if(count($check) == 0){

        $projectassign = new assign_manufacturers;
        $projectassign->user_id = $request->user_id;
        $projectassign->ward = $wards;
        $projectassign->subward = $subwards;
        $projectassign->totalarea = $request->totalareaf;
        $projectassign->capacity = $request->capacityf;
        $projectassign->present_utilization  = $request->pf;
        $projectassign->capacityt  = $request->capacityt;
        $projectassign->totalareat  = $request->totalareat;
        $projectassign->persentto  = $request->pt;
        $projectassign->cementto  = $request->ct;
        $projectassign->sandt  = $request->st;
        $projectassign->agrrigatet  = $request->at;
        $projectassign->cement_requiernment  = $request->cf;
        $projectassign->sand_requiernment  = $request->sf;
        $projectassign->manufacture_type  = $request->type;
        $projectassign->data  = $request->assigndate;
        $projectassign->aggregates_required  = $request->af;
        $projectassign->save();



}else{


        $check->user_id = $request->user_id;
        $check->ward = $wards;
        $check->subward = $subwards;
        $check->totalarea = $request->totalareaf;
        $check->capacity = $request->capacityf;
        $check->present_utilization  = $request->pf;
        $check->capacityt  = $request->capacityt;
        $check->totalareat  = $request->totalareat;
        $check->persentto  = $request->pt;
        $check->cementto  = $request->ct;
        $check->sandt  = $request->st;
        $check->agrrigatet  = $request->at;
        $check->cement_requiernment  = $request->cf;
        $check->sand_requiernment  = $request->sf;
        $check->manufacture_type  = $request->type;
        $check->data  = $request->assigndate;
        $check->aggregates_required  = $request->af;

          $check->save();
     }
        return redirect()->back()->with('success',' Assigned Successfully');
}


  public function sales_manufacture(Request $request)
    {   
        
        $assigndate =assign_manufacturers::where('user_id',Auth::user()->id)
                     ->orderby('data','DESC')->pluck('data')->first();
        $date =  assign_manufacturers::where('user_id',Auth::user()->id)->pluck('data')->first();
           $totalarea = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('totalarea')->first();
           $capacity = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('capacity')->first();   
        $present_utilization  = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('present_utilization')->first();
           $capacityt = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('capacityt')->first();
           $totalareat = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('totalareat')->first();
           $persentto = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('persentto')->first();
           $cementto = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('cementto')->first();
           $sandt = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('sandt')->first();
           $agrrigatet = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('agrrigatet')->first();
    $cement_requiernment = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('cement_requiernment')->first();
    $sand_requiernment = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('sand_requiernment')->first();
    $manufacture_type = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('manufacture_type')->first();
    $aggregates_required = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('aggregates_required')->first();
    $subwards = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('subward')->first();

        $tlWard = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('ward')->first();

         $ward = Ward::where('ward_name',$tlWard)->pluck('id')->first();

         $assignedSubWards = SubWard::where('ward_id',$ward)->pluck('id');
        $subwards = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('subward')->first();

         $subwardNames = explode(", ", $subwards);
         if($subwards != "null"){
            $subwardid = Subward::whereIn('sub_ward_name',$subwardNames)->pluck('id')->toArray();
         }else{
            $subwardid = $assignedSubWards;
         }

         $tlWard = assign_manufacturers::where('user_id',Auth::user()->id)->pluck('ward')->first();

         $ward = Ward::where('ward_name',$tlWard)->pluck('id')->first();

         $assignedSubWards = SubWard::where('ward_id',$ward)->pluck('id');

        $projectids = new Collection();
        $projects = Manufacturer::whereIn('sub_ward_id',$subwardid)->pluck('id');

        if(count($projects) > 0){
            $projectids = $projectids->merge($projects);
        }
            if($totalarea != null){
                if(count($projectids) != 0){
                    $grd = Manufacturer::whereIn('id',$projectids)->where('total_area ','<=',$totalarea  !=null ? $totalarea :0 )->where('total_area','>=',$totalareat  !=null ? $totalareat :0 )->pluck('id');
                }else{
                    $grd = Manufacturer::where('total_area','>=',$totalarea  !=null ? $totalarea :0 )->where('total_area','<=',$totalareat  !=null ? $totalareat :0 )->pluck('id');
                }
                if(Count($grd) > 0){
                    $projectids = $grd;
                }
            }
            if($capacity != null){
                if(count($projectids) != 0){
                    $base = Manufacturer::whereIn('id',$projectids)->where('capacity', '<=',$capacity !=null ? $capacity :0 )->where('capacity', '>=',$capacityt !=null ? $capacityt :0 )->pluck('id');
                }else{
                    $base = Manufacturer::where('capacity', '<=',$capacity !=null ? $capacity :0 )->where('capacity', '>=',$capacityt !=null ? $capacityt :0 )->pluck('id');
                }
                if(Count($base) > 0){
                    $projectids = $base;
                }
                if(Count($base) > 0){
                    $datec = Manufacturer::where('created_at','LIKE' ,$date."%")->pluck('id');
                }
            }
            if($assigndate != "NULL"){
                if(count($projectids) != 0){
                    $datec = Manufacturer::whereIn('id',$projectids)->where('created_at','LIKE' ,$date."%")->pluck('id');
                }else{
                    $datec =  $projectids;
                    
                }
                if($datec != null){
                    $projectids = $datec;
                }
            }
            if($present_utilization != null){
          if(count($projectids) != 0){
                $project_types = Manufacturer::whereIn('id',$projectids)->where('present_utilization', '>=',$present_utilization  !=null ? $present_utilization  :0 )->where('present_utilization', '<=',$persentto !=null ? $persentto :0 )->pluck('id');
            }else{
                $project_types = Manufacturer::where('present_utilization', '>=',$present_utilization  !=null ? $present_utilization  :0 )->where('present_utilization', '<=',$persentto !=null ? $persentto :0 )->pluck('id');
            }
            if(count($project_types) != 0){
                $projectids = $project_types;
            }
     }
            if($cement_requiernment != null){
                if(count($projectids) != 0){
                    $budgets = Manufacturer::whereIn('id',$projectids)->where('cement_requirement','>=',$cement_requiernment != null ? $cement_requiernment : 0 )->where('cement_requirement','<=',$cementto != null ? $cementto : 0 )->pluck('id');
                }else{
                    $budgets = Manufacturer::where('cement_requirement','>=',$cement_requiernment != null ? $cement_requiernment : 0 )->where('cement_requirement','<=',$cementto != null ? $cementto : 0 )->pluck('id');
                }
                if(count($budgets) > 0){
                    $projectids = $budgets;
                }
            }


if($sand_requiernment != null){
                if(count($projectids) != 0){
                    $sand = Manufacturer::whereIn('id',$projectids)->where('sand_requirement','>=',$sand_requiernment != null ? $sand_requiernment : 0 )->where('sand_requirement','<=',$sandt != null ? $sandt : 0 )->pluck('id');
                }else{
                    $sand = Manufacturer::where('sand_requirement','>=',$sand_requiernment != null ? $sand_requiernment : 0 )->where('sand_requirement','<=',$sandt != null ? $sandt : 0 )->pluck('id');
                }
                if(count($sand) > 0){
                    $projectids = $sand;
                }
            }
            
if($aggregates_required != null){
                if(count($projectids) != 0){
                    $agri = Manufacturer::whereIn('id',$projectids)->where('aggregates_required','>=',$aggregates_required != null ? $aggregates_required : 0 )->where('aggregates_required','<=',$agrrigatet != null ? $agrrigatet : 0 )->pluck('id');
                }else{
                    $agri = Manufacturer::where('aggregates_required','>=',$aggregates_required != null ? $aggregates_required : 0 )->where('aggregates_required','<=',$agrrigatet != null ? $agrrigatet : 0 )->pluck('id');
                }
                if(count($agri) > 0){
                    $projectids = $agri;
                }
            }

            if( $manufacture_type != null){
                if(count( $projectids) != 0){
                    $qua = Manufacturer::whereIn('id',$projectids)->where('manufacturer_type', $manufacture_type )->pluck('id');
                }else{
                    $qua = Manufacturer::where('manufacturer_type',$manufacture_type )->pluck('id');
                }

                if(count($qua) > 0){
                    $projectids = $qua;
                }
            }
        
        $his = History::all();
        
          $assigncount = assign_manufacturers::where('user_id',Auth::user()->id)->first();
        if($assigncount != null){
            $assigncount->manu_ids = $projectids;
            $assigncount->save();
        }



        $projects = Manufacturer::whereIn('id',$projectids)
                    ->select('manufacturers.*','id')
                    ->orderBy('id','ASC')
                    ->paginate(15);

           $projectcount=count($projects);
             
       return view('sales_manufacture',[
                'projects'=>$projects,
                'his'=>$his,
                'projectcount'=>$projectcount


            ]);
    }

 public function manuenquiry(Request $request)
    {
        $category = Manufacturer::all();
       

        $depart1 = [6];
        $depart2 = [7];
        $depart = [2,4,8,6,7,15,17,16,1,11,22];
        $projects = Manufacturer::where('id', $request->projectId)->first();
        $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
       $users1 = User::whereIn('group_id',$depart1)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
       $users2 = User::whereIn('group_id',$depart2)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
        return view('manuenquiry',['category'=>$category,'users'=>$users,'users1'=>$users1,'users2'=>$users2,'projects'=>$projects]);
    }

public function inputdata(Request $request)
    {

           $user_id = User::where('id',Auth::user()->id)->pluck('id')->first();

         if($request->name){

              $shipadress = $request->billadress;
         }
           $shipadress = $request->billadress;

  $points = new Point;
            $points->user_id = $request->initiator;
            $points->point = 100;
            $points->type = "Add";
            $points->reason = "Generating an enquiry";
            $points->save();
            
        $ward = $request->sub_ward_id;
        $x = DB::table('requirements')->insert(['project_id'    =>'',
                                                'main_category' => '',
                                                'brand' => '',
                                                'sub_category'  =>'',
                                                'follow_up' =>'',
                                                'follow_up_by' =>'',
                                                'material_spec' =>'',
                                                'referral_image1'   =>'',
                                                'referral_image2'   =>'',
                                                'requirement_date'  =>$request->edate,
                                                'measurement_unit'  =>$request->measure != null?$request->measure:'',
                                                'unit_price'   => '',
                                                 'quantity'     =>'',
                                                 'total'   =>0,
                                                'notes'  =>$request->eremarks,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s'),
                                                'status' => "Enquiry On Process",
                                                'dispatch_status' => "Not yet dispatched",
                                                'generated_by' => $request->initiator,
                                                'billadress'=>$request->billadress,
                                                'total_quantity'=>$request->totalquantity,
                                                'product'=>$request->product,
                                                'manu_id'=>$request->manu_id,
                                                'sub_ward_id'=>$ward, 
                                                'ship' =>$shipadress
                                        ]);


         $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has added a new requirement for project id: ".$request->selectprojects." at ".date('H:i A');
        $uproject = ProjectDetails::where('project_id',$request->selectprojects)->pluck('updated_by')->first();
        $qproject = ProjectDetails::where('project_id',$request->selectprojects)->pluck('quality')->first();
        $fproject = ProjectDetails::where('project_id',$request->selectprojects)->pluck('followup')->first();
        $eproject = Requirement::where('project_id',$request->selectprojects)->pluck('generated_by')->first();
         $project = ProjectDetails::where('project_id',$request->selectprojects)->pluck('sub_ward_id')->first();
        $activity->sub_ward_id = $project;
        $activity->updater = $uproject;
        $activity->quality = $qproject;
        $activity->followup = $fproject;
        if(count($eproject) != 0){
        
       $activity->enquiry = $eproject;
       }
        else{
       $activity->enquiry ="null";

        }

        $activity->project_id = $request->selectprojects;
        // $activity->req_id = $requirement->id;
        $activity->typeofactivity = "Add Enquiry";
        $activity->save();
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
 public function editEnq(Request $request)
    {

        $depart = [7];
       $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
        $depart1 = [6];
       $users1 = User::whereIn('group_id',$depart1)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
        $depart2 = [2,4,6,7,8,17,11];
        $users2 = User::whereIn('group_id',$depart2)->where('department_id','!=',10)->get();

        $enq = Requirement::where('requirements.id',$request->reqId)
                    ->leftjoin('users','users.id','=','requirements.generated_by')
                    ->leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                    ->select('requirements.*','users.name','manufacturers.name','manufacturers.contact_no','manufacturers.address','requirements.total_quantity')
                    ->first();

         return view('menqedit',['enq'=>$enq,'users'=>$users,'users1'=>$users1,'users2'=>$users2]);
    }


}