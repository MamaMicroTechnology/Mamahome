<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\assign_manufacturers;
use Auth;
use Validator;
use App\Ward;
use App\Tlwards;
use App\BreakTime;
use App\SubWard;
use App\History;
use App\Manufacturer;
use App\User;
use App\State;
use App\ProjectDetails;
use App\Point;
use App\Requirement;
use App\ActivityLog;
use DB;
use App\ProjectUpdate;
use App\AssignCategory;
use App\Category;
use App\Salesofficer;
use Illuminate\Support\Collection;      
use Spatie\Activitylog\Models\Activity;
use  App\Order;
use App\Mowner_Deatils;
use App\Mprocurement_Details;
use App\Salescontact_Details;
use App\Manager_Deatils;
use App\SubWardMap;
use App\brand;
use App\Noneed;
use App\SubCategory;
use App\CustomerProjectAssign;


use App\WardMap;
class AssignManufacturersController extends Controller
{
 


  public function Manufacturestore(request $request)
{
  
   if($request->ward){
    $wards = implode(", ", $request->ward);
    }else{
        if(Auth::user()->group_id == 22){
            $tl= Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
            $tlWard = explode(",",$tl); 
            $ward = Ward::whereIn('id',$tlWard)->pluck('ward_name');
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
                    ->paginate('20');

           $projectcount=count($projects);
             
       return view('sales_manufacture',[
                'projects'=>$projects,
                'his'=>$his,
                'projectcount'=>$projectcount


            ]);
    }

 public function manuenquiry(Request $request)
    {
        $category1 = Manufacturer::all();
        $category = Category::all();
        $brand = brand::leftjoin('category','category.id','=','brands.category_id')
                ->select('brand')->get();


        $depart1 = [6];
        $depart2 = [7];
        $depart = [2,4,8,6,7,15,17,16,1,11,22];
        $projects = Manufacturer::where('id', $request->projectId)->first();
        $users = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
       $users1 = User::whereIn('group_id',$depart1)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
       $users2 = User::whereIn('group_id',$depart2)->where('department_id','!=',10)->where('name',Auth::user()->name)->get();
        $states = State::all();
        return view('manuenquiry',['category1'=>$category1,'category'=>$category,'users'=>$users,'users1'=>$users1,'users2'=>$users2,'projects'=>$projects,'brand'=>$brand,'states'=>$states]);
    }

public function inputdata(Request $request)
    {


           $user_id = User::where('id',Auth::user()->id)->pluck('id')->first();

           $cat = category::where('id',$request->cat)->pluck('id')->first();
        if($request->name){

              $billaddress = $request->shipaddress;
         }
         else{
            
           $billaddress = $request->billaddress;
         }
     
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
           if(count($request->sub_ward_id) > 0){
        $ward = $request->sub_ward_id;
            
           }else{
             $find = Manufacturer::where('id',$request->manu_id)->pluck('sub_ward_id')->first();
             $ward = $find;

           }
        $x = DB::table('requirements')->insert(['project_id'    =>'',
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
                                                'billadress'=> $billaddress,
                                                'total_quantity'=>$request->totalquantity,
                                               
                                                'manu_id'=>$request->manu_id,
                                                'sub_ward_id'=>$ward, 
                                                'ship' =>$request->shipaddress,
                                                'state'=>$request->state,
                                                'price' =>$request->price
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
                    $category = Category::all();
         $states = State::all();
         return view('menqedit',['enq'=>$enq,'users'=>$users,'users1'=>$users1,'users2'=>$users2,'category'=>$category,'states'=>$states]);
    }
public function addcat(request $request){
         
         if($request->cat){
            $category = implode(",", $request->cat);
         }
                

                 $check = new Salesofficer;
                 $check->category = $category;
                 $check->user_id = $request->user_id;
                 $check->location = $request->location;
                 $check->project_id = $request->project_id;
                 $check->remark = $request->remark;

                

    if($check->save())
        {
            return back()->with('success','category Added Successfully !!!');
        }
        else
        {
            return back()->with('success','Error Occurred !!!');
        }

}
 public function catsalesreports(Request $request)
       {
                 $subward = Subward::all();
            if($request->se == "ALL" && $request->fromdate && !$request->todate){
                  $date = $request->fromdate;
                  $str = ProjectUpdate::where('created_at','LIKE',$date.'%')->get();
              }
              elseif($request->se != "ALL" && $request->fromdate && !$request->todate){
                  $date = $request->fromdate;
                  $str = ProjectUpdate::where('created_at','LIKE',$request->fromdate.'%')
                          ->where('user_id',$request->se)
                          ->get();
                          
              }elseif($request->se == "ALL" && $request->fromdate && $request->todate){
                  $date = $request->fromdate;
                  $from= $request->fromdate;
                  $to= $request->todate;
                  
                  if($from == $to){
                       $str = ProjectUpdate::where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")
                             ->get();
                       
                  }
                  else{
                  $str = ProjectUpdate::where('created_at','>',$request->fromdate)
                          ->where('created_at','<=',$request->todate)
                             ->get();
                            
                        
                  }
              }elseif($request->se != "ALL" && $request->fromdate && $request->todate){

                  $date = $request->fromdate;
                  $from= $request->fromdate;
                  $to= $request->todate;
                  if($from == $to){

                  $str = ProjectUpdate::where('created_at','like',$from.'%')
                      ->where('created_at','LIKE',$to."%")
                      ->where('user_id',$request->se)
                        ->get();
                            
                  }
                  else{
                  $str = ProjectUpdate::where('created_at','>',$request->fromdate)
                          ->where('created_at','<=',$request->todate)
                          ->where('user_id',$request->se)
                           ->get();
                  }
              }else{
                 $users = User::where('group_id',23)
                       ->pluck('id');
                  $cat = AssignCategory::whereIn('user_id',$users)->pluck('cat_id');
                  $date = date('Y-m-d');
                  $str = ProjectUpdate::where('created_at','LIKE',$date.'%')->whereIn('cat_id',$cat)->get();
              }
                
           $users = User::where('group_id',23)
                       ->get();
             
          foreach($users as $user){

           $today = date('Y-m-d');
           $ac = AssignCategory::where('user_id',$user->id)->pluck('cat_id')->first();
          $catsub = Category::where('id',$ac)->pluck('category_name')->first();
         $cat = AssignCategory::where('user_id',$user->id)->pluck('cat_id')->first();

               $noOfCalls[$user->id]['calls'] = History::where('called_Time','LIKE',$today.'%')
                                           ->where('user_id',$user->id)
                                           ->count();
               $noOfCalls[$user->id]['projectupdate'] = ProjectUpdate::where('created_at','LIKE',$today.'%')
                                           ->where('user_id',$user->id)
                                           ->where('cat_id',$cat)
                                           ->count();

               $noOfCalls[$user->id]['Enquiry'] = Requirement::where('created_at','LIKE',$today.'%')
                                           ->where('generated_by',$user->id)
                                           
                                           ->count();

               $noOfCalls[$user->id]['Genuine'] = ProjectUpdate::where('created_at','LIKE',$today.'%')
                                                       ->where('user_id',$user->id)
                                                        ->where('cat_id',$cat)
                                                        ->where('quality','Genuine')
                                                       ->count();

           }

           return view('catofficer',['users'=>$users,'str'=>$str,
                   'noOfCalls'=>$noOfCalls,'subward'=>$subward

               ]);
       }
        public function manudailyslots(Request $request)
    {

        $totalListing = array();
        $totalRMCListing = array();
        $totalBlocksListing = array();
        $date = date('Y-m-d');
        $grpid = [6,7,22,23,17.11];
        $users = User::whereIn('group_id',$grpid)
                    ->where('users.department_id','!=',10)
                    ->leftjoin('ward_assignments','users.id','ward_assignments.user_id')
                    ->leftjoin('sub_wards','ward_assignments.subward_id','sub_wards.id')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();

         $accusers = User::where('department_id','2')->where('group_id','11')
                    ->where('users.department_id','!=',10)
                    ->leftjoin('ward_assignments','users.id','ward_assignments.user_id')
                    ->leftjoin('sub_wards','ward_assignments.subward_id','sub_wards.id')
                    ->select('users.*','sub_wards.sub_ward_name')
                    ->get();

        $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('users')->first();
        $userIds = explode(",", $tl);
        // total project of list in stl
        $tllistuser = DB::table('users')->where('group_id',6)->whereIn('id',$userIds)
        ->pluck('id');
        $tlcount = Manufacturer::where('created_at','like',$date.'%')->count();
        $tlRMCcount = Manufacturer::where('created_at','like',$date.'%')->where('manufacturer_type',"RMC")->count();
        $tlBlocksCount = Manufacturer::where('created_at','like',$date.'%')->where('manufacturer_type',"Blocks")->count();

        $tlupcount = Activity::where('created_at','like',$date.'%')->where('description','updated')->where('subject_type','App\Manufacturer')->count();
        // total project of list in tl
        $tlaccuser = DB::table('users')->where('group_id',11)->whereIn('id',$userIds)
        ->pluck('id');
        $tlacount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$tlaccuser)->count();
        $tlAcRMCcount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$tlaccuser)->where('manufacturer_type',"RMC")->count();
        $tlAcBlocksCount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$tlaccuser)->where('manufacturer_type',"Blocks")->count();
        $tlaupcount = Manufacturer::where('updated_at','like',$date.'%')->whereIn('updated_by',$tlaccuser)->count();


        $tlUsers = User::whereIn('id',$userIds)
            ->where('group_id',6)->simplePaginate();

         $tlUsers1 = User::whereIn('id',$userIds)
           ->where('group_id',11)->simplePaginate();
        // total project of list in st
        $list = DB::table('users')->where('group_id',6)->where('department_id','!=',10)->pluck('id');
        $lcount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$list)->count();
        $lupcount = Manufacturer::where('updated_at','like',$date.'%')->whereIn('updated_by',$list)->count();
        $lRMCcount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$list)->where('manufacturer_type',"RMC")->count();
        $lBlocksCount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$list)->where('manufacturer_type',"Blocks")->count();
            // total prolect of account in st
        $account = DB::table('users')->where('group_id',11)->where('department_id','!=',10)->pluck('id');
        $acount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$account)->count();
        $aRMCcount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$account)->where('manufacturer_type',"RMC")->count();
        $aBlocksCount = Manufacturer::where('created_at','like',$date.'%')->whereIn('listing_engineer_id',$account)->where('manufacturer_type',"Blocks")->count();
        $aupcount = Manufacturer::where('updated_at','like',$date.'%')->whereIn('updated_by',$account)->count();
        $projects = Manufacturer::where('created_at','like',$date.'%')->get();
        $groupid = [6,11];
        $le = DB::table('users')->whereIn('group_id',$groupid)->where('department_id','!=',10)->get();
        
        if(Auth::user()->group_id != 22){
              if($request->list =="ALL" && $request->fromdate && $request->todate){
                      $from =$request->fromdate;
                      $to = $request->todate;
                      if($from == $to){
                       $projects = Manufacturer::where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")
                             ->get();
                       
                                    }
                  else{
                  $projects = Manufacturer::where('created_at','>',$request->fromdate)
                              ->where('created_at','<=',$request->todate)
                             ->get(); 
                  }
              }elseif($request->list !="ALL" && $request->fromdate && $request->todate){
                      $from =$request->fromdate;
                      $to = $request->todate;
                      if($from == $to){
                       $projects = Manufacturer::where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")
                             ->where('listing_engineer_id',$request->list)
                             ->get();
                       
                                      }
                  else{
                      $projects = Manufacturer::where('created_at','>',$request->fromdate)
                              ->where('created_at','<=',$request->todate)
                             ->where('listing_engineer_id',$request->list)
                             ->get();     
                  }
              }else{

                   $projects =Manufacturer::where('created_at','like',$date.'%')
                  ->get();
              }




          
}else{
            $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id');
            $tll = explode(",",$tl);
            $ward = Ward::whereIn('id',$tl)->pluck('id');
            $sub  = Subward::whereIn('ward_id',$ward)->pluck('id');


               if($request->list =="ALL" && $request->fromdate && $request->todate){
                      $from =$request->fromdate;
                      $to = $request->todate;
                      if($from == $to){
                       $projects = Manufacturer::where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")
                             ->whereIn('sub_ward_id',$sub)
                             ->get();
                       
                                    }
                  else{
                  $projects = Manufacturer::where('created_at','>',$request->fromdate)
                              ->where('created_at','<=',$request->todate)
                             ->whereIn('sub_ward_id',$sub)
                             ->get(); 
                      }
                  }elseif($request->list !="ALL" && $request->fromdate && $request->todate){
                      $from =$request->fromdate;
                      $to = $request->todate;
                      if($from == $to){
                       $projects = Manufacturer::where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")
                             ->where('listing_engineer_id',$request->list)
                             ->whereIn('sub_ward_id',$sub)
                             ->get();
                       
                                      }
                  else{
                      $projects = Manufacturer::where('created_at','>',$request->fromdate)
                              ->where('created_at','<=',$request->todate)
                             ->where('listing_engineer_id',$request->list)
                             ->whereIn('sub_ward_id',$sub)
                             ->get();     
                  }
                 }
                 else{

                     $projects =Manufacturer::whereIn('sub_ward_id',$sub)
                        ->where('created_at','like',$date.'%')->get();
                 }
              }
   
   foreach($users as $user){
                $totalListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
                $totalRMCListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->where('manufacturer_type',"RMC")
                                                ->count();
                $totalBlocksListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->where('manufacturer_type',"Blocks")
                                                ->count();
            }
            foreach($tlUsers as $user){
                $totalListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
                $totalRMCListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->where('manufacturer_type',"RMC")
                                                ->count();
                $totalBlocksListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->where('manufacturer_type',"Blocks")
                                                ->count();
            }
            foreach($accusers as $user){
                $totalaccountlist[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
                $totalAccountRMCListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->where('manufacturer_type',"RMC")
                                                ->count();
                $totalAccountBlocksListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->where('manufacturer_type',"Blocks")
                                                ->count();
            }
             foreach($tlUsers1 as $user){
                $totalaccountlist[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->count();
                $totalAccountRMCListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->where('manufacturer_type',"RMC")
                                                ->count();
                $totalAccountBlocksListing[$user->id] = Manufacturer::where('listing_engineer_id',$user->id)
                                                ->where('created_at','LIKE',$date.'%')
                                                ->where('manufacturer_type',"Blocks")
                                                ->count();
            }
            foreach($users as $user){
                $totalupdates[$user->id] = Activity::where('created_at','like',$date.'%')->where('description','updated')->where('subject_type','App\Manufacturer')->where('causer_id',$user->id)->count();
            }
            foreach($tlUsers as $user){
                $totalupdates[$user->id] = Manufacturer::
                                                where('updated_at','LIKE',$date.'%')
                                                ->where('updated_by','=',$user->id)
                                                ->count();
            }

            foreach($accusers as $user){
                $totalaccupdates[$user->id] = Manufacturer::
                                                where('updated_at','LIKE',$date.'%')
                                                ->where('updated_by','=',$user->id)
                                                ->count();
            }
            foreach($tlUsers1 as $user){
                $totalaccupdates[$user->id] = Manufacturer::
                                                where('updated_at','LIKE',$date.'%')
                                                ->where('updated_by','=',$user->id)
                                                ->count();
            }
            
        $projcount = count($projects); 
        return view('manudailyslot', ['date' => $date,'users'=>$users,'accusers'=>$accusers, 'projcount' => $projcount, 'projects' => $projects, 'le' => $le, 'totalListing'=>$totalListing,'totalaccountlist'=>$totalaccountlist,'tlUsers'=>$tlUsers,'tlUsers1'=>$tlUsers1,'totalupdates'=>$totalupdates,'totalaccupdates'=>$totalaccupdates,'lcount'=>$lcount,'acount'=>$acount,'lupcount'=>$lupcount,'aupcount'=>$aupcount,'tlcount'=>$tlcount,'tlupcount'=>$tlupcount,'tlacount'=>$tlacount,'tlaupcount'=>$tlaupcount,
            'totalRMCListing'=>$totalRMCListing,'totalBlocksListing'=>$totalBlocksListing,'lRMCCount'=>$lRMCcount,'lBlocksCount'=>$lBlocksCount,'aRMCcount'=>$aRMCcount,'aBlocksCount'=>$aBlocksCount,
            'totalAccountRMCListing'=>$totalAccountRMCListing,'totalAccountBlocksListing'=>$totalAccountBlocksListing,'tlRMCcount'=>$tlRMCcount,'tlBlocksCount'=>$tlBlocksCount,
            'tlAcBlocksCount'=>$tlAcBlocksCount,'tlAcRMCcount'=>$tlAcRMCcount
        ]);
    }
    public function getreport(request $request){


        $groupid = [6,11,7,22,23,17];
        $users = User::whereIn('group_id',$groupid)->where('department_id','!=',10)->get();
        $previous = date('Y-m-d',strtotime('-30 days'));
        $today = date('Y-m-d');
    

    if($request->user_id !="ALL" && $request->fromdate && $request->todate){
        $users = User::where('id',$request->user_id)->get();
                      $from =$request->fromdate;
                      $to = $request->todate;
                      if($from == $to){

        foreach($users as $user){
                 $total[$user->id]['updateproject'] = Activity::where('causer_id',$user->id)->where('description','updated')->where('subject_type','App\ProjectDetails')->where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")->count();
                 
                  

                 $total[$user->id]['addproject'] = ProjectDetails::where('listing_engineer_id',$user->id)->where('created_at','like',$from.'%')->where('created_at','LIKE',$to."%")->count(); 

                  $total[$user->id]['addmanu'] = Manufacturer::where('listing_engineer_id',$user->id)->where('created_at','like',$from.'%')->where('created_at','LIKE',$to."%")->count();
                
                $total[$user->id]['addenquiry'] = Requirement::where('generated_by',$user->id)->where('created_at','like',$from.'%')
                  ->where('created_at','LIKE',$to."%")->count(); 

                
                $total[$user->id]['confirm'] = Requirement::where('generated_by',$user->id)->where('status','Enquiry Confirmed')->where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")->count(); 

                $total[$user->id]['converted'] = Requirement::where('converted_by',$user->id)->where('status','Enquiry Confirmed')->where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")->count();

               
               $total[$user->id]['order'] = Order::where('generated_by',$user->id)->where('status','Order Confirmed')->where('created_at','like',$from.'%')
                             ->where('created_at','LIKE',$to."%")->count();
                   

    
                    


               $total[$user->id]['calls'] = History::where('user_id',$user->id)->where('called_Time','like',$from.'%')
                             ->where('called_Time','LIKE',$to."%")->count();
            
                }
            }else{
        foreach($users as $user){
        $total[$user->id]['updateproject'] = Activity::where('causer_id',$user->id)->where('description','updated')->where('subject_type','App\ProjectDetails')->where('created_at','>',$from."%")
            ->where('created_at','<=',$to)->count();
         $total[$user->id]['addproject'] = ProjectDetails::where('listing_engineer_id',$user->id)->where('created_at','>',$from."%")->where('created_at','<=',$to."%")->count(); 

                 $total[$user->id]['addmanu'] = Manufacturer::where('listing_engineer_id',$user->id)->where('created_at','>',$from."%")->where('created_at','<=',$to."%")->count(); 
                
                $total[$user->id]['addenquiry'] = Requirement::where('generated_by',$user->id)->where('created_at','>',$from."%")->where('created_at','<=',$to."%")->count(); 

                
                $total[$user->id]['confirm'] = Requirement::where('generated_by',$user->id)->where('status','Enquiry Confirmed')->where('created_at','>',$from."%")
                             ->where('created_at','<=',$to."%")->count(); 

                $total[$user->id]['converted'] = Requirement::where('converted_by',$user->id)->where('status','Enquiry Confirmed')->where('created_at','>',$from."%")
                             ->where('created_at','<=',$to."%")->count();

               
               $total[$user->id]['order'] = Order::where('generated_by',$user->id)->where('status','Order Confirmed')->where('created_at','>',$from."%")
                             ->where('created_at','<=',$to)->count();
               $total[$user->id]['calls'] = History::where('user_id',$user->id)->where('called_Time','>',$from."%")
                            ->where('called_Time','<=',$to."%")->count();
            
                }
 }
}else{
        foreach($users as $user){
                 $total[$user->id]['updateproject'] = Activity::where('causer_id',$user->id)->where('description','updated')->where('subject_type','App\ProjectDetails')->where('created_at','>=', $previous."%")->count();
                 $total[$user->id]['addproject'] = ProjectDetails::where('listing_engineer_id',$user->id)->where('created_at','>=', $previous."%")->count(); 
                 $total[$user->id]['addmanu'] = Manufacturer::where('listing_engineer_id',$user->id)->where('created_at','>=', $previous."%")->count(); 

                $total[$user->id]['addenquiry'] = Requirement::where('generated_by',$user->id)->where('created_at','>=', $previous."%")->count(); 

                $total[$user->id]['confirm'] = Requirement::where('generated_by',$user->id)->where('status','Enquiry Confirmed')->where('created_at','>=', $previous."%")->count(); 

                $total[$user->id]['converted'] = Requirement::where('converted_by',$user->id)->where('status','Enquiry Confirmed')->where('created_at','>=', $previous."%")->count();

               $total[$user->id]['order'] = Order::where('generated_by',$user->id)->where('status','Order Confirmed')->where('created_at','>=', $previous."%")->count();
                 

               $total[$user->id]['calls'] = History::where('user_id',$user->id)->where('called_Time','>=', $previous."%")->count();

               $orderdata = Order::all();

               foreach ($orderdata as $order) {
                   # code...
               }
            

             }

                 
}
return view('/monthlyreport',['users' =>$users,'total'=>$total]);
    }

  public function manusearch(Request $request)
    {
        $details = array();
        $ids = array();
        $tl = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
       $ward = Subward::where('ward_id',$tl)->pluck('id');
         $dd= $request->type;
          $his = History::get();
        if($request->phNo)
        {
             $details[0] = Mowner_Deatils::leftjoin('manufacturers','manufacturers.id','mowner_details.manu_id')->where('mowner_details.contact',$request->phNo)->orwhere('mowner_details.manu_id',$request->phNo)->orwhere('manufacturers.plant_name','LIKE',$request->phNo)
                  ->pluck('manufacturers.id');
            
            $details[1] = Mprocurement_Details::leftjoin('manufacturers','manufacturers.id','mprocurement_details.manu_id')->where('mprocurement_details.contact',$request->phNo)->orwhere('mprocurement_details.manu_id',$request->phNo)->orwhere('manufacturers.plant_name','LIKE',$request->phNo)
            ->pluck('manufacturers.id');


            $details[2] = Manager_Deatils::leftjoin('manufacturers','manufacturers.id','manager_details.manu_id')->where('manager_details.contact',$request->phNo)->orwhere('manager_details.manu_id',$request->phNo)->orwhere('manufacturers.plant_name','LIKE',$request->phNo)
                  ->pluck('manufacturers.id');

            $details[3] = Salescontact_Details::leftjoin('manufacturers','manufacturers.id','salescontact_details.manu_id')->where('salescontact_details.contact',$request->phNo)->orwhere('salescontact_details.manu_id',$request->phNo)->orwhere('manufacturers.plant_name','LIKE',$request->phNo)
            ->pluck('manufacturers.id');


            for($i = 0; $i < count($details); $i++){
                for($j = 0; $j<count($details[$i]); $j++){
                    array_push($ids, $details[$i][$j]);
                }
            }
            $manufacturers = Manufacturer::whereIn('id',$ids)->paginate('10');
            $count = Manufacturer::whereIn('id',$ids)->count();
        }
            return view('viewManufacturer',['manufacturers'=>$manufacturers,'count'=>$count,'dd'=>$dd,'his'=>$his]);
}

public function manuenquirysheet(Request $request)
    {
                         // dd( $enquiries);
          
        $totalofenquiry = "";
        $totalenq = "";
         $wardwise = Ward::get();
        $wards = SubWard::orderby('sub_ward_name','ASC')->get();
        $category = Category::all();
        $depart = [1,6,7,8,11,15,16,17,22];
        $initiators = User::whereIn('group_id',$depart)->where('department_id','!=',10)->get();
             // dd($request->status);
        if($request->status && !$request->category){
            if($request->status != "all"){

                $enquiries = Requirement::where('status','like','%'.$request->status)
                            ->where('status','!=',"Enquiry Cancelled")
                            ->orderby('created_at','DESC')
                            ->where('manu_id','!=',NULL)
                            ->select('requirements.*')
                            ->get();
               $converter = user::get();
            $totalenq = count($enquiries);
                 
                }
            else{

                $enquiries = Requirement::where('status','!=',"Enquiry Cancelled")
                        ->orderby('created_at','DESC')
                        ->where('manu_id','!=',NULL)
                            ->get();
                $converter = user::get();
            $totalenq = count($enquiries);
                
            }
        }elseif($request->status && $request->category){
            if($request->status != "all"){

                $enquiries = Requirement::where('status','like','%'.$request->status)
                            ->where('main_category',$request->category)
                            ->where('status','!=',"Enquiry Cancelled")
                           ->orderby('created_at','DESC')
                           ->where('manu_id','!=',NULL)
                       
                            ->get();
                $converter = user::get();
            $totalenq = count($enquiries);
               
            }else{

                $enquiries = Requirement::where('main_category',$request->category)
                            ->where('status','!=',"Enquiry Cancelled")
                            ->orderby('created_at','DESC')
                        ->where('manu_id','!=',NULL)
                            
                            ->get();
                $converter = user::get();
            $totalenq = count($enquiries);

               
            }
        }elseif($request->from && $request->to  && !$request->initiator && !$request->category && !$request->ward){
            // only from and to

            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::orderBy('created_at','DESC')
                            ->where('created_at','LIKE',$from."%")
                            ->where('status','!=',"Enquiry Cancelled")
                            ->orderby('created_at','DESC')
                        ->where('manu_id','!=',NULL)
                            
                            ->get();
            $converter = user::get();
            $totalenq = count($enquiries);

            }else{
                $enquiries = Requirement::orderBy('created_at','DESC')
                            ->where('created_at','>',$from)
                            ->where('created_at','<',$to)
                            ->where('status','!=',"Enquiry Cancelled")
                 ->orderby('created_at','DESC')
                        ->where('manu_id','!=',NULL)
                               
                            ->get();
            $converter = user::get();
            $totalenq = count($enquiries);

            }

        }elseif(!$request->from && !$request->to && !$request->initiator && !$request->category && $request->ward && $request->enqward){
          
           if($request->ward == "All"){
            $subwardid = Subward::where('ward_id',$request->enqward)->pluck('id');    
            }else{
            $subwardid = Subward::where('id',$request->ward)->pluck('id');    
            }
            // only ward
            $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                        ->whereIn('manufacturers.sub_ward_id',$subwardid)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                 ->orderby('requirements.created_at','DESC')
                        ->where('requirements.manu_id','!=',NULL)
                          
                        ->get();
                            
            $converter = user::get();
            $totalenq = count($enquiries);
            
        }elseif(!$request->from && !$request->to && !$request->initiator && $request->category && !$request->ward && !$request->enqward){
            // only category

            $enquiries = Requirement::where('main_category',$request->category)
                        ->where('status','!=',"Enquiry Cancelled")
                 ->orderby('created_at','DESC')
                        ->where('manu_id','!=',NULL)
                       
                        ->get();
            $totalenq = count($enquiries);


          $converter = user::get();

            $totalofenquiry = Requirement::where('main_category',$request->category)->where('requirements.status','!=',"Enquiry Cancelled")->sum('quantity');
        }elseif(!$request->from && !$request->to && $request->initiator && !$request->category && !$request->ward){
            // only initiator
            $enquiries = Requirement::where('generated_by',$request->initiator)
                        ->where('status','!=',"Enquiry Cancelled")
                 ->orderby('created_at','DESC')
                        ->where('manu_id','!=',NULL)
                          
                        ->get();
            $converter = user::get();
            $totalenq = count($enquiries);

        }elseif($request->from && $request->to && $request->initiator && $request->category && $request->ward && $request->enqward){
            // everything
        
            if($request->ward == "All"){
            $subwardid = Subward::where('ward_id',$request->enqward)->pluck('id');    
            }else{
            $subwardid = Subward::where('id',$request->ward)->pluck('id');    
            }
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                ->whereIn('manufacturers.sub_ward_id',$subwardid)
                ->where('requirements.generated_by',$request->initiator)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                ->where('requirements.main_category','LIKE',"%".$request->category."%")
                 ->orderby('requirements.created_at','DESC')
                        ->where('requirements.manu_id','!=',NULL)
                 
                ->get();
            $converter = user::get();
            $totalenq = count($enquiries);
               
            }else{
            $subwardid = Subward::where('ward_id',$request->enqward)->pluck('id');
               
                $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                            ->whereIn('manufacturers.sub_ward_id',$subwardid)
                            ->where('requirements.generated_by',$request->initiator)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->where('requirements.main_category','LIKE',"%".$request->category."%")
                            ->orderby('requirements.created_at','DESC')
                            ->where('requirements.manu_id','!=',NULL)
                               
                            ->get();
                $converter = user::get();
            $totalenq = count($enquiries);

            }
        }elseif($request->from && $request->to && !$request->initiator && !$request->category && $request->ward && $request->enqward){

            // from, to and ward
            if($request->ward == "All"){
            $subwardid = Subward::where('ward_id',$request->enqward)->pluck('id');    
            }else{
            $subwardid = Subward::where('id',$request->ward)->pluck('id');    
            }
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                ->orderBy('requirements.created_at','DESC')
                ->whereIn('manufacturers.sub_ward_id',$subwardid)
                ->where('requirements.created_at','LIKE',$from."%")
                ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->where('requirements.manu_id','!=',NULL)
                
                ->get();
                $converter = user::get();
            $totalenq = count($enquiries);

            }else{

                $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                ->orderBy('requirements.created_at','DESC')
                ->whereIn('manufacturers.sub_ward_id',$subwardid)
                ->where('requirements.created_at','>',$from)
                ->where('requirements.created_at','<',$to)
                ->where('requirements.status','!=',"Enquiry Cancelled")
                 ->where('requirements.manu_id','!=',NULL)
                

                ->get();
                $converter = user::get();
            $totalenq = count($enquiries);
                
            }
        }elseif($request->from && $request->to && $request->initiator && !$request->category && !$request->ward){
            // from, to and initiator
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::orderBy('created_at','DESC')
                ->where('generated_by','=',$request->initiator)
                ->where('created_at','LIKE',$from."%")
                ->where('status','!=',"Enquiry Cancelled")
                 ->where('manu_id','!=',NULL)
                 
                ->get();
               $converter = user::get();
            $totalenq = count($enquiries);
                
            }else{
                $enquiries = Requirement::orderBy('created_at','DESC')
                ->where('generated_by','=',$request->initiator)
                ->where('created_at','>',$from)
                      
                ->where('created_at','<',$to)
                ->where('status','!=',"Enquiry Cancelled")
                 ->where('manu_id','!=',NULL)
                 
                ->get();
               $converter = user::get();
            $totalenq = count($enquiries);
                
            }
        }elseif($request->from && $request->to && !$request->initiator && $request->category && !$request->ward){
            // from, to and category
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::orderBy('created_at','DESC')
                ->where('main_category','=',$request->category)
                ->where('created_at','LIKE',$from."%")
                ->where('status','!=',"Enquiry Cancelled")
                 ->where('manu_id','!=',NULL)
                       
               
                ->get();
                $converter = user::get();
            $totalenq = count($enquiries);
                
            }else{
                $enquiries = Requirement::orderBy('created_at','DESC')
                ->where('main_category','=',$request->category)
                ->where('created_at','>',$from)
                ->where('created_at','<',$to)
                ->where('status','!=',"Enquiry Cancelled")
                 ->where('manu_id','!=',NULL)
                      

                ->get();
                $converter = user::get();
            $totalenq = count($enquiries);
               
            }
        }elseif($request->from && $request->to && $request->initiator && $request->category && !$request->ward){
            // from, to, initiator and category
            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::orderBy('created_at','DESC')
                ->where('main_category','=',$request->category)
                ->where('generated_by','=',$request->initiator)
                ->where('created_at','LIKE',$from."%")
                ->where('status','!=',"Enquiry Cancelled")
                 ->where('manu_id','!=',NULL)
                      
                ->get();
                $converter = user::get();
            $totalenq = count($enquiries);
                
            }else{
                $enquiries = Requirement::orderBy('created_at','DESC')
                ->where('main_category','=',$request->category)
                ->where('generated_by','=',$request->initiator)
                ->where('created_at','>',$from)
                ->where('created_at','<',$to)
                ->where('status','!=',"Enquiry Cancelled")
                 ->where('manu_id','!=',NULL)
                      

                ->get();
                $converter = user::get();
            $totalenq = count($enquiries);

                
            }
        }elseif($request->from && $request->to && !$request->initiator && $request->category && $request->ward && $request->enqwrad){
            // from, to, wards and category
            $from = $request->from;
          if($request->ward == "All"){
            $subwardid = Subward::where('ward_id',$request->enqward)->pluck('id');    
            }else{
            $subwardid = Subward::where('id',$request->ward)->pluck('id');    
            }
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.main_category','=',$request->category)
                            ->whereIn('manufacturers.sub_ward_id',$subwardid)
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->where('requirements.manu_id','!=',NULL)
                      

                            ->get();
            $totalenq = count($enquiries);

                        $converter = user::get();
            }else{
                $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.main_category','=',$request->category)
                            ->whereIn('manufacturers.sub_ward_id',$subwardid)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                              ->where('requirements.manu_id','!=',NULL)
                       
                            
                            ->get();
                $converter = user::get();
            $totalenq = count($enquiries);

               
                }
            
        }elseif($request->from && $request->to && $request->initiator && !$request->category && $request->ward && $request->enqward){
            // from, to, wards and initiator
           if($request->ward == "All"){
            $subwardid = Subward::where('ward_id',$request->enqward)->pluck('id');    
            }else{
            $subwardid = Subward::where('id',$request->ward)->pluck('id');    
            }

            $from = $request->from;
            $to = $request->to;
            if($from == $to){
                $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.generated_by','=',$request->initiator)
                            ->whereIn('manufacturers.sub_ward_id',$subwardid)
                            ->where('requirements.created_at','LIKE',$from."%")
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                            ->where('requirements.manu_id','!=',NULL)

                            ->select('requirements.*','manufacturers.sub_ward_id')
                       
                            ->get();
            $totalenq = count($enquiries);
                
            }else{
                $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                            ->orderBy('requirements.created_at','DESC')
                            ->where('requirements.generated_by','=',$request->initiator)
                            ->whereIn('manufacturers.sub_ward_id',$subwardid)
                            ->where('requirements.created_at','>',$from)
                            ->where('requirements.created_at','<',$to)
                            ->where('requirements.status','!=',"Enquiry Cancelled")
                           ->where('requirements.manu_id','!=',NULL)
                            

                            ->get();
            $totalenq = count($enquiries);
                
            }
        }elseif(!$request->from && !$request->to && $request->initiator && $request->category && !$request->ward){
            //initiator and category
            $from = $request->from; 
            $to = $request->to;
            $enquiries = Requirement::where('main_category','=',$request->category)
                        ->where('generated_by','=',$request->initiator)
                        ->where('status','!=',"Enquiry Cancelled")
                       ->orderby('created_at','DESC')
                 ->where('manu_id','!=',NULL)
                       
                        ->get();
            $totalenq = count($enquiries);
            
        }elseif($request->manu){
                         if($request->manu != "manu"){
                            $enquiries = Requirement::where('manu_id','!=',NULL)
                                        ->where('status','like','%'.$request->manu)
                                        ->orderby('created_at','DESC')
                                         ->where('manu_id','!=',NULL)

                                        ->select('requirements.*')
                                        ->get();
                           $converter = user::get();
                        $totalenq = count($enquiries);
                            }
                        else{
                           
                             $enquiries = Requirement::where('manu_id','!=',NULL)
                                           ->where('status','!=',"Enquiry Cancelled")
                                           ->orderby('created_at','DESC')
                                              ->where('manu_id','!=',NULL)

                                           ->get();
                                $converter = user::get();
                                $totalenq = count($enquiries);

                            }
                        }
          elseif($request->enqward && !$request->category  && !$request->from && !$request->to && !$request->initiator && !$request->ward){
           // only ward
          $wardtotal = Subward::where('ward_id',$request->enqward)->pluck('id');
          $pro = ProjectDetails::whereIn('sub_ward_id',$wardtotal )->pluck('project_id');

         $enquiries = Requirement::whereIn('project_id',$pro)
                        ->where('status','!=',"Enquiry Cancelled")
                       ->orderby('created_at','DESC')
                      ->where('manu_id','!=',NULL)

                        ->get();
                       
            $converter = user::get();
            $totalenq = count($enquiries);
        }
        elseif($request->category && $request->enqward && !$request->from && !$request->to && !$request->initiator && !$request->ward){
          
            // ward and category
            $subwardid = Subward::where('ward_id',$request->enqward)->pluck('id');
            $enquiries = Requirement::leftjoin('manufacturers','manufacturers.id','=','requirements.manu_id')
                        ->whereIn('manufacturers.sub_ward_id',$subwardid)
                        ->where('requirements.status','!=',"Enquiry Cancelled")
                        ->where('main_category',$request->category)
                        ->where('status','!=',"Enquiry Cancelled")
                        ->orderby('requirements.created_at','DESC')
                        ->where('manu_id','!=',NULL)

                        ->get();
                        
            $converter = user::get();
            $totalenq = count($enquiries);

        }
        else{
            // no selection
           
            $enquiries = Requirement::where('status','!=',"Enquiry Cancelled")
                       ->orderby('created_at','DESC')
                        ->where('manu_id','!=',NULL)
                        ->get();
                      
            $converter = user::get();
            $totalenq = count($enquiries);

         
            }
        $projectOrdersReceived = Order::whereIn('status',["Order Confirmed","Order Cancelled"])->pluck('project_id')->toArray();
        
        return view('manuenquirysheet',[
            'totalenq' =>$totalenq,
            'totalofenquiry'=>$totalofenquiry,
            'enquiries'=>$enquiries,
            'wardwise'=>$wardwise,
            'category'=>$category,
            'initiators'=>$initiators,
            'wards'=>$wards,
            'projectOrdersReceived'=>$projectOrdersReceived
        ]);
    }
public function getsubwards(request $request){

         
$sub = SubWard::where('ward_id',9)->get();


$subwardlat = [];
foreach ($sub as  $users) {
           
       $nosubwards =SubWardMap::where('sub_ward_id',$users->id)->get()->toArray();
                array_push($subwardlat,['nosubwards'=>$nosubwards,'wardname'=>$users->sub_ward_name]);
      }
    

            
 return response()->json(['newUsers'=>$subwardlat]);
}
public function indexnumber(){

    $number  = Noneed::get();
    return view('/noneed',['number'=>$number]);
}
public function noneed(request $request ){


       $check = New Noneed;
       $check->number = $request->number;
       $check->save();

    return back();
}
 

 public  function projectsize(request $request)
 {

    $wards = Ward::all();
  

    if($request->ward == "All"){
         $subward = Subward::all();

    }else{
        
     $subward = SubWard::where('ward_id',$request->ward)->get();
    }

    
    $projectscount =[];
    

    foreach ($subward as $sub) {
       $projectcount = ProjectDetails::where('sub_ward_id',$sub->id)->get()->toArray();
       array_push($projectscount,['projectcount'=>$projectcount,'wardname'=>$sub->sub_ward_name]);
    }
   
     return view('/projectandward',[ 'wards'=>$wards,'projectscount'=>$projectscount]);
 }

public  function manureport(request $request)
 {

    $wards = Ward::all();
  

    if($request->ward == "All"){
         $subward = Subward::all();

    }else{
        
     $subward = SubWard::where('ward_id',$request->ward)->get();
    }


   
    $projectscount =[];
    
     if($request->ward && $request->type){

             foreach ($subward as $sub) {
       $projectcount = Manufacturer::where('sub_ward_id',$sub->id)->where('manufacturer_type',$request->type)->get()->toArray();
       array_push($projectscount,['projectcount'=>$projectcount,'wardname'=>$sub->sub_ward_name,'type'=>$request->type]);
        }

     }
    else{
       foreach ($subward as $sub) {
       $projectcount = Manufacturer::where('sub_ward_id',$sub->id)->get()->toArray();
       array_push($projectscount,['projectcount'=>$projectcount,'wardname'=>$sub->sub_ward_name,'type'=>$request->type]);
        }
    }
 return view('/manureport',[ 'wards'=>$wards,'projectscount'=>$projectscount]);
 }


 public function mini(request $request){

    $users = User::where('department_id','!=',10)->get();

        $date=date('Y-m-d');
        $breacktime = [];
         foreach ($users as $user) {
             $usertime = BreakTime::where('user_id',$user->id)
                            ->where('created_at','LIKE',$date."%")
                            ->pluck('totaltime')->toArray();
                        array_push($breacktime,['usertime'=>$usertime,'name'=>$user->name]);      
        }
       
         $on = BreakTime::leftjoin('users','users.id','breaktime.user_id')->where('breaktime.created_at','LIKE',$date."%")->where('breaktime.stop_time','=',"")->select('users.name')->get();
         return view('/minibreack',['breacktime'=>$breacktime,'on'=>$on]);

 }
 public function find(request $request){
     $Wards = [];
      $wards = Ward::all();
     foreach($wards as $user){
           
                $noOfwards = WardMap::where('ward_id',$user->id)->first()->toArray();
                array_push($Wards,['ward'=>$noOfwards,'wardid'=>$user->id]);
            }
              $allwardlats = [];
              foreach ($Wards as $all) {

               
                  $allx = explode(",",$all['ward']['lat']);
                  $wardid = $all['wardid'];
               
                  array_push($allwardlats, ['lat'=>$allx,'wardid'=>$wardid]);
               }
             
         
    $a = [];

    for($j = 0; $j<sizeof($allwardlats);$j++){
        $finalward = [];

        $wardId = $allwardlats[$j]['wardid'];
    for($i=0;$i<sizeof($allwardlats[$j]['lat'])-3; $i+=2){

         $lat = $allwardlats[$j]['lat'][$i];
         $long =  $allwardlats[$j]['lat'][$i+1];
        $latlong = "{lat: ".$lat.", lng: ".$long."}";
       
         array_push($finalward,$latlong);

    }


      
       array_push($a,['lat'=>$finalward,'ward'=>$wardId]);

   }

    $d = response()->json($a);

    return view('/subwardfind',['ward'=>$d]);
}

function subfind(request $request){


 $sub = SubWard::where('ward_id',$request->id)->get();     
 $subwardlat = [];
foreach ($sub as  $users) {
           
       $nosubwards =SubWardMap::where('sub_ward_id',$users->id)->first()->toArray();
                array_push($subwardlat,['subward'=>$nosubwards,'subid'=>$users->id]);
      }
            
      
    


              $allsubwardlats = [];
              foreach ($subwardlat as $all) {

                
                  $allx = explode(",",$all['subward']['lat']);
                
                  $wardid = $all['subid'];
                
                  array_push($allsubwardlats, ['lat'=>$allx,'subid'=>$wardid]);
               } 
             
    $suba = [];

    for($j = 0; $j<sizeof($allsubwardlats);$j++){
        $finalsubward = [];
        $subwardId = $allsubwardlats[$j]['subid'];
    for($i=0;$i<sizeof($allsubwardlats[$j]['lat'])-3; $i+=2){

         $lat = $allsubwardlats[$j]['lat'][$i];
         $long =  $allsubwardlats[$j]['lat'][$i+1];
        $latlong = "{lat: ".$lat.", lng: ".$long."}";
        array_push($finalsubward, $latlong);   

    }
        
       
       array_push($suba,['lat'=>$finalsubward,'subward'=>$subwardId]);

   }
  
  return response()->json($suba);
 
 }
 public function viewmanu(request $request){

       $project = Manufacturer::where('id',$request->id)->first();
         $Wards = [];
      $wards = Ward::all();
     foreach($wards as $user){
           
                $noOfwards = WardMap::where('ward_id',$user->id)->first()->toArray();
                array_push($Wards,['ward'=>$noOfwards,'wardid'=>$user->id]);
            }
              $allwardlats = [];
              foreach ($Wards as $all) {

               
                  $allx = explode(",",$all['ward']['lat']);
                  $wardid = $all['wardid'];
               
                  array_push($allwardlats, ['lat'=>$allx,'wardid'=>$wardid]);
               }
             
         
    $a = [];

    for($j = 0; $j<sizeof($allwardlats);$j++){
        $finalward = [];

        $wardId = $allwardlats[$j]['wardid'];
    for($i=0;$i<sizeof($allwardlats[$j]['lat'])-3; $i+=2){

         $lat = $allwardlats[$j]['lat'][$i];
         $long =  $allwardlats[$j]['lat'][$i+1];
        $latlong = "{lat: ".$lat.", lng: ".$long."}";
       
         array_push($finalward,$latlong);

    }


      
       array_push($a,['lat'=>$finalward,'ward'=>$wardId]);

   }

    $d = response()->json($a);


       return view('/viewmanu',['project'=>$project,'ward'=>$d]);
 }
 
 public function details(request $request){

    $users = User::where('department_id','!=',10)->get(); 
    $projects = CustomerProjectAssign::all();


    return view('/details',['users'=>$users,'projects'=>$projects]);
 }
  public function storeproject(request $request){
      
      if($request->type != "project"){

        return $this->manustore($request);
      }

     $push = [];
        $i = CustomerProjectAssign::where('type',"project")->pluck('user_id');
        $user = User::whereIn('id',$i)->get();
     
        foreach ($user as $project) {
            $ids =CustomerProjectAssign::where('user_id',$project->id)->pluck('project_id')->first();
           $ex = explode(",",$ids);
            array_push($push,$ex);
          
        } 
        $mergearray = [];
      $ids =  $request->projectids;
      $id = explode(',',$ids);
     
      $result = [];
      foreach($push as $array){
        $result = array_merge($result, $array);
              }
  $z = array_intersect($result,$id);
     

        ProjectDetails::whereIn('project_id',$id)->update(['type'=>1]);
        
     


    $check = CustomerProjectAssign::where('user_id',$request->user_id)->where('type',"project")->first();
    $numberexist = CustomerProjectAssign::where('project_id',$request->projectids)->first();
    if($z != null){

       $text2 =implode(",",$z);
       $text = "Project ids are assigned please check "  .$text2;
       
        return back()->with('NotAdded',$text);
    }
            if($check == null){
                $number = new CustomerProjectAssign;
                $number ->user_id = $request->user_id;
                $number->project_id = $request->projectids;
                $number->type = $request->type;
                $number->save();
            }else{
                $check->project_id=$request->projectids;
                $check->type = $request->type;
                $check->save();
            }
            return redirect()->back()->with('success','Projects  Assigned');
    }

 public function manustore(request $request){
      

       $push = [];
        $i = CustomerProjectAssign::where('type',"Manufacturer")->pluck('user_id');
        $user = User::whereIn('id',$i)->get();
     
        foreach ($user as $project) {
            $ids =CustomerProjectAssign::where('user_id',$project->id)->pluck('project_id')->first();
           $ex = explode(",",$ids);
            array_push($push,$ex);
          
        } 
        $mergearray = [];
      $ids =  $request->projectids;
      $id = explode(',',$ids);
     
      $result = [];
      foreach($push as $array){
        $result = array_merge($result, $array);
              }
  $z = array_intersect($result,$id);
     
 

        Manufacturer::whereIn('id',$id)->update(['manu_type'=>1]);
 


    
    $numberexist = CustomerProjectAssign::where('project_id',$request->projectids)->first();
    if($z != null){

       $text2 =implode(",",$z);
       $text = "Project ids are assigned please check "  .$text2;
       
        return back()->with('NotAdded',$text);
    }
    $check = CustomerProjectAssign::where('user_id',$request->user_id)->where('type',"Manufacturer")->first();

            if($check == null){
                $number = new CustomerProjectAssign;
                $number ->user_id = $request->user_id;
                $number->project_id = $request->projectids;
                $number->type = $request->type;
                $number->save();
           }else{
                $check->project_id=$request->projectids;
                $check->type = $request->type;
                $check->save();
           }
            return redirect()->back()->with('success','Projects  Assigned');
    }


}

