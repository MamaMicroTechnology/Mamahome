<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Mail\registration;
use Illuminate\Http\Request;
use App\Department;
use App\User;
use App\Group;
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
use App\MamahomeAsset;
use App\ProjectImage;

date_default_timezone_set("Asia/Kolkata");
class mamaController extends Controller
{
    public function addDepartment(Request $request)
    {
        $department = New Department;
        $department->dept_name = $request->dept_name;
        if($department->save()){
            $activity = new ActivityLog;
            $activity->time = date('Y-m-d H:i A');
            $activity->employee_id = Auth::user()->employeeId;
            $activity->activity = Auth::user()->name." has added a new department named ".$request->dept_name." at ".date('H:i A');
            $activity->save();
            return back()->with('Success','New Department Added');
        }else{
            $activity = new ActivityLog;
            $activity->time = date('Y-m-d H:i A');
            $activity->employee_id = Auth::user()->employeeId;
            $activity->activity = Auth::user()->name." has tried to add a new department on ".date('H:i A')." but failed";
            $activity->save();
            return back()->with('Error','Seems there is some problem in the input');
        }
    }
    public function deleteDepartment(Request $request)
    {
        User::where('department_id',$request->id)->update([
            'department_id' => 1
        ]);
        Department::where('id',$request->id)->delete();
        return back()->with('Success','Department deleted');
    }
    public function addEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employeeId' => 'required|unique:users'
        ]);
        if ($validator->fails()) {
            return back()
                    ->with('NotAdded','User already exists')
                    ->withErrors($validator)
                    ->withInput();
        }
        $user = New User;
        $user->employeeId = $request->employeeId;
        $user->department_id = $request->dept;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->group_id = $request->designation;
        $user->contactNo = '';
        $user->password = bcrypt('mama@home123');
        if($user->save()){
            $empdetails = new EmployeeDetails;
            $empdetails->employee_id = $user->employeeId;
            $empdetails->save();
            if($user->department_id == 1 && $user->group_id == 6){
                $assignment = new WardAssignment;
                $assignment->user_id = $user->id;
                $assignment->subward_id = 1;
                $assignment->status = "Completed";
                $assignment->save();
            }
            return back()->with('Added','Employee Added Successfully');
        }else{
            return back()->with('NotAdded','Employee add unsuccessful');
        }
    }
    public function deleteEmployee(Request $request)
    {
        User::where('id',$request->id)->delete();
        return back()->with('UserSuccess','User deleted');
    }
    public function assignDesignation($id,Request $request)
    {
        User::where('id',$id)->update([
            'group_id' => $request->designation
        ]);
        return back();
    }
    public function addDesignation(Request $request)
    {
        $group = New Group;
        $group->group_name = $request->desig_name;
        if($group->save()){
            return back();
        }else{
            return back();
        }
    }
    public function deleteDesignation(Request $request)
    {
        Group::where('id',$request->id)->delete();
        return back();
    }
    public function addCountry(Request $request)
    {
        $country = New Country;
        $country->country_code = $request->code;
        $country->country_name = $request->name;
        if($country->save()){
            return back();
        }else{
            return back();
        }
    }
    // public function addState(Request $request)
    // {
    //  $state = New State;
    //  $state->zone_id = $request->zone_id;
    //  $state->state_name = $request->state_name;
    //  $state->save();
    //  return back();
    // }
    public function addZone(Request $request)
    {
        $check = Zone::where('zone_name',$request->zone_name)->first();
        if(count($check) != 0){
            return back()->with('ErrorZone','Zone Name exists. Try another name');
        }
        $imageName1 = time().'.'.request()->image->getClientOriginalExtension();
        $request->image->move(public_path('zoneimages'),$imageName1);
        
        $zone = New Zone;
        $zone->country_id = $request->sId;
        $zone->zone_name = $request->zone_name;
        $zone->zone_number = $request->zone_no;
        $zone->zone_image = $imageName1;
        $zone->save();
        return back();
    }
     
     public function view_zone(Request $id){
    
        $zone = Zone::where('id',$id->zoneId)->first();
        return view('viewzone',['zone'=>$zone]);
    }
    public function save_edit(Request $request){

         $zoneimage = time().'.'.request()->image->getClientOriginalExtension();
        $request->image->move(public_path('zoneimages'),$zoneimage);

        Zone::where('id',$request->zoneId)->update([
            'zone_name'=> $request->zone_name,
            'zone_number' => $request->zone_no,
             'zone_image' => $zoneimage,
        ]);

        return redirect()->back()->with('Success','zone updated sucessfully');
    }
    public function addWard(Request $request)
    {
        $cCode = Country::where('id',$request->country)->pluck('country_code')->first();
        $zone = Zone::where('id', $request->zone)->pluck('zone_number')->first();
        $imageName = time().'.'.request()->image[0]->getClientOriginalExtension();
        $request->image[0]->move(public_path('wardImages'),$imageName);
        $ward = New Ward;
        $ward->country_id = $request->country;
        $ward->zone_id = $request->zone;
        // $ward->state_id = $request->state;
        $ward->ward_name = "MH_".$cCode."_".$zone."_".$request->name;
        $ward->ward_image = $imageName;
        $ward->save();
        return back();

    }
    public function salesreport()
    {
        $group = Group::where('group_name','Listing Engineer')->pluck('id')->first();
        $users = User::where('group_id',$group)
                    ->where('department_id','!=','10')
                    ->get();
                               
        return view('assistantmanager.salesreport',['users'=>$users,'pageName'=>'Sales Report']);
    }
    public function getSalesReport(Request $request)
    {
        $le = '';
        $fromdate = '';
        $todate = '';
        $userId = array();
        $totallistings = array();
        $confirmlistings = array();
        $initiatedlistings = array();
        $initiatedcount = array();
        $username = '';
        $totalcount = array();
        $confirmcount =array();
        
        $group = Group::where('group_name','Listing Engineer')->pluck('id')->first();
        $users = User::where('group_id',$group)
                    ->where('department_id','!=','10')
                    ->get();
        if(!$request->listengs || !$request->fromdate || !$request->todate) //If any one of the inputs is null
        {
            return back()->with('error','Please Select All The Fields');
        }
        else //All three inputs are given
        {
            $le = $request->listengs;
            $fromdate = $request->fromdate;
            $todate = $request->todate;
            if($le == 'All') //All listing engineers should be listed 
            {
                $group = Group::where('group_name','Listing Engineer')->pluck('id')->first();
                $users = User::where('group_id',$group)
                            ->where('department_id','!=','10')
                            ->get();   
                $i = 0;
                $userid = array();
                $username = array();
                foreach ($users as $user) {
                    $userid[$i++] = $user->id;
                }
                $i = 0;
                if($fromdate == $todate) //Both times are same
                {
                    foreach ($users as $user) 
                    {
                        $totalcount[$user->id] = ProjectDetails::join('users','project_details.listing_engineer_id','=','users.id')
                                                ->leftjoin('requirements','requirements.project_id','=','project_details.project_id')
                                                ->where('project_details.created_at','LIKE',$fromdate.'%')
                                                ->where('users.id', $user->id)
                                                ->count();       
                        $confirmcount[$user->id] = ProjectDetails::join('users','project_details.listing_engineer_id','=','users.id')
                                                ->leftjoin('requirements','requirements.project_id','=','project_details.project_id')
                                                ->where('project_details.created_at','LIKE',$fromdate.'%')
                                                ->where('users.id', $user->id)
                                                ->where('requirements.status','Order Confirmed')
                                                ->count();

                        $initiatedcount[$user->id] = ProjectDetails::join('users','project_details.listing_engineer_id','=','users.id')
                                        ->leftjoin('requirements','requirements.project_id','=','project_details.project_id')
                                        ->where('project_details.created_at','>',$fromdate.'%')
                                        ->where('users.id',$user->id)
                                        ->where('requirements.status','Order Initiated')
                                        ->count();
                    }   
                }
                else //Both dates are different
                {
                    $fromdate .= ' 00:00:00';
                    $todate .= ' 23:59:59';
                    foreach ($users as $user) 
                    {
                        $totalcount[$user->id] = ProjectDetails::join('users','project_details.listing_engineer_id','=','users.id')
                                                ->leftjoin('requirements','requirements.project_id','=','project_details.project_id')
                                                ->where('project_details.created_at','>',$fromdate)
                                                ->where('project_details.created_at','<',$todate)
                                                ->where('users.id', $user->id)
                                                ->count();

                    
                        $confirmcount[$user->id] = ProjectDetails::leftjoin('requirements','requirements.project_id','=','project_details.project_id')
                                                ->where('project_details.created_at','>',$fromdate)
                                                ->where('project_details.created_at','<',$todate)
                                                ->where('project_details.listing_engineer_id', $user->id)
                                                ->where('requirements.status','Order Confirmed')
                                                ->count();

                        $initiatedcount[$user->id] = ProjectDetails::leftjoin('requirements','requirements.project_id','=','project_details.project_id')
                                        ->where('project_details.created_at','>',$fromdate)
                                        ->where('project_details.created_at','<',$todate)
                                        ->where('project_details.listing_engineer_id', $user->id)
                                        ->where('requirements.status','Order Initiated')
                                        ->count();
                    }     
                }
            }//End All Listing Engineers Selection 
            
            else //Only one selection of Listing Engineer is made
            {
                $username = User::where('id',$le)->first();
                if($fromdate == $todate) //Both times are same
                {                   
                    $totalcount[$le] = ProjectDetails::where('project_details.created_at','LIKE',$fromdate.'%')
                                        ->where('listing_engineer_id',$le)
                                        ->count();

                    $confirmcount[$le] =  ProjectDetails::
                                            leftjoin('requirements','requirements.project_id','=','project_details.project_id')
                                            ->where('project_details.created_at','LIKE',$fromdate.'%')
                                            ->where('listing_engineer_id',$le)
                                            ->where('requirements.status','Order Confirmed')
                                            ->count();

                    $initiatedcount[$le] = ProjectDetails::
                                            leftjoin('requirements','requirements.project_id','=','project_details.project_id')
                                            ->where('project_details.created_at','LIKE',$fromdate.'%')
                                            ->where('listing_engineer_id',$le)
                                            ->where('requirements.status','Order Initiated')
                                            ->count();                                         
                }
                else //Both dates are different
                {
                    $fromdate .= ' 00:00:00';
                    $todate .= ' 23:59:59';
                    
                    $totalcount[$le] = ProjectDetails::where('listing_engineer_id',$le)
                                        ->where('project_details.created_at','>',$fromdate)
                                        ->where('project_details.created_at','<',$todate)
                                        ->count();                
                    
                    $confirmcount[$le] =  ProjectDetails::join('requirements','requirements.project_id','=','project_details.project_id')
                                            ->where('project_details.created_at','>',$fromdate)
                                            ->where('project_details.created_at','<',$todate)
                                            ->where('project_details.listing_engineer_id',$le)
                                            ->where('requirements.status','Order Confirmed')
                                            ->count();

                    $initiatedcount[$le] = ProjectDetails::join('requirements','requirements.project_id','=','project_details.project_id')
                                            ->where('project_details.created_at','>',$fromdate)
                                            ->where('project_details.created_at','<',$todate)
                                            ->where('project_details.listing_engineer_id',$le)
                                            ->where('requirements.status','Order Initiated')
                                            ->count();
                }
            }//End One selection of Listing Engineer     
        }//End All three Inputs Provided
        return view('assistantmanager.salesreport',['le'=>$le, 'fromdate'=>$fromdate,'todate'=>$todate,'totallistings' => $totallistings,'confirmlistings'=>$confirmlistings,'initiatedlistings'=> $initiatedlistings,'users'=>$users,'pageName' => 'Sales Report','totalcount'=>$totalcount,'username'=>$username,'confirmcount'=>$confirmcount,'initiatedcount'=>$initiatedcount]);
    }
    public function addSubWard(Request $request)
    {
        $ward = Ward::where('id',$request->ward)->pluck('ward_name')->first();
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        $request->image->move(public_path('subWardImages'),$imageName);
        $subWard = New SubWard;
        $subWard->ward_id = $request->ward;
        $subWard->sub_ward_name = $ward.$request->name;
        $subWard->sub_ward_image = $imageName;
        if($subWard->save()){
            return back();
        }else{
            return back();
        }
    }
    public function assignWards($id,Request $request)
    {
        $assigned = WardAssignment::where('user_id',$id)->first();
        if($assigned != NULL){
            $assigned->prev_subward_id = $assigned->subward_id;
            $assigned->subward_id = $request->subward;
            $assigned->status = "Not Completed";
            $assigned->save();
        }else{
            $assignWard = new WardAssignment;
            $assignWard->user_id = $id;
            $assignWard->subward_id = $request->subward;
            $assignWard->prev_subward_id = '';
            $assignWard->status = 'Not Completed';
            $assignWard->save();
        }
        return back()->with('error','Assigned Successfully');
    }
    public function addProject(Request $request)
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
        }

        $bType = count($request->budgetType);
        if(count($request->budgetType != 0)){
            $type2 = implode(", ",$request->budgetType);
        }
        $statusCount = count($request->status);
        $validator = Validator::make($request->all(), [
                'address' => 'required',
                'basement' => 'required',
                'ground' => 'required',
                'pName' => 'required',
                'rName' => 'required',
                'status' => 'required',
              
            ]);
            if ($validator->fails()) {
                return back()
                ->with('Error','Please check some of the fields again')
                ->withErrors($validator)
                ->withInput();
            }
            $statuses = $request->status[0];
            if($statusCount > 1){
                for($i = 1; $i < $statusCount; $i++){
                    $statuses .= ", ".$request->status[$i];
                }
            }
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            
            if($request->mApprove != NULL){
                $imageName1 = time().'.'.request()->mApprove->getClientOriginalExtension();
                $request->mApprove->move(public_path('projectImages'),$imageName1);
            }else{
                $imageName1 = "N/A";
            }
            $i = 0;
            if($request->oApprove){
                foreach($request->oApprove as $oApprove){
                    $imageName2 = $i.time().'.'.$oApprove->getClientOriginalExtension();
                    $oApprove->move(public_path('projectImages'),$imageName2);
                    if($i == 0){
                        $otherApprovals .= $imageName2;
                    }else{
                        $otherApprovals .= ", ".$imageName2;
                    }
                    $i++;
                }
            }
            $i = 0;
            if($request->pImage){
                foreach($request->pImage as $pimage){
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
        
            }
           
            $ward = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
            $projectdetails = New ProjectDetails;
            $projectdetails->sub_ward_id = $ward;
            $projectdetails->project_name = $request->pName;
            $projectdetails->road_width = $request->rWidth;
            $projectdetails->construction_type = $type;
            $projectdetails->interested_in_rmc = $request->rmcinterest;
            $projectdetails->road_name = $request->rName;
            $projectdetails->municipality_approval = $imageName1;
            $projectdetails->other_approvals = $otherApprovals;
            $projectdetails->project_status = $statuses;
            $projectdetails->basement = $basement;
            $projectdetails->ground = $ground;
            $projectdetails->project_type = $floor;
            $projectdetails->project_size = $request->pSize;
            $projectdetails->budget = $request->budget;
            $projectdetails->image = $projectimage;
            $projectdetails->listing_engineer_id = Auth::user()->id;
            $projectdetails->remarks = $request->remarks;
            $projectdetails->contract = $request->contract;
            $projectdetails->budgetType = $type2;
           
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
            $ownerDetails->project_id = $projectdetails->id;
            $ownerDetails->owner_name = $request->oName;
            $ownerDetails->owner_email = $request->oEmail;
            $ownerDetails->owner_contact_no = $request->oContact;
        $ownerDetails->save();

        $contractorDetails = New ContractorDetails;
        $contractorDetails->project_id = $projectdetails->id;
        $contractorDetails->contractor_name = $request->cName;
        $contractorDetails->contractor_email = $request->cEmail;
        $contractorDetails->contractor_contact_no = $request->cContact;
        $contractorDetails->save();

        $consultantDetails = New ConsultantDetails;
        $consultantDetails->project_id = $projectdetails->id;
        $consultantDetails->consultant_name = $request->coName;
        $consultantDetails->consultant_email = $request->coEmail;
        $consultantDetails->consultant_contact_no = $request->coContact;
        $consultantDetails->save();

        $siteEngineerDetails = New SiteEngineerDetails;
        $siteEngineerDetails->project_id = $projectdetails->id;
        $siteEngineerDetails->site_engineer_name = $request->eName;
        $siteEngineerDetails->site_engineer_email = $request->eEmail;
        $siteEngineerDetails->site_engineer_contact_no = $request->eContact;
        $siteEngineerDetails->save();

        $procurementDetails = New ProcurementDetails;
        $procurementDetails->project_id = $projectdetails->id;
        $procurementDetails->procurement_name = $request->prName;
        $procurementDetails->procurement_email = $request->pEmail;
        $procurementDetails->procurement_contact_no = $request->prPhone;
        $procurementDetails->save();
        $newtime = date('H:i A');
        // $newtime = date('H:i A',strtotime('+5 hour +30 minutes',strtotime($time)));
        loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
            'lastListingTime' => $newtime
        ]);
        $first = loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->first();
        $assigned = subWard::where('id',$ward)->pluck('sub_ward_name')->first();
        if($first->firstListingTime == NULL){
            loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                'firstListingTime' => $newtime
            ]);
        }
        $check = mktime(12,00);
        $checktime = date('H:i A',$check);
        $morningcheck=loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->first();
        if($newtime <= $checktime){
            if($morningcheck->noOfProjectsListedInMorning == NULL){
                loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                    'noOfProjectsListedInMorning' => 1
                ]);                
            }else{
                $number=loginTime::where('user_id',Auth::user()->id)
                    ->where('logindate',date('Y-m-d'))
                    ->pluck('noOfProjectsListedInMorning')
                    ->first();
                loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                    'noOfProjectsListedInMorning' => $number + 1
                ]); 
            }
        }
        if($morningcheck->TotalProjectsListed == NULL){
             loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                    'TotalProjectsListed' => 1
                ]);
        }else{
            $number2=loginTime::where('user_id',Auth::user()->id)
                    ->where('logindate',date('Y-m-d'))
                    ->pluck('TotalProjectsListed')
                    ->first();
                loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                    'TotalProjectsListed' => $number2 + 1
                ]);
        }
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has added a new project id: ".$projectdetails->id." at ".date('H:i A');
        $activity->save();
        return back()->with('Success','Project added successfully');
    }
    public function updateProject($id, Request $request)
    {

        $point = 0;
        $project = ProjectDetails::where('project_id',$id)->first();
        $projectimages = ProjectImage::where('project_id',$id)->first();
        $today = date('Y-m-d');
        $created = date('Y-m-d',strtotime($project->created_at));
        $updated = date('Y-m-d',strtotime($project->updated_at));
        if($today != $created || $today != $updated){
            if($request->quality && $project->quality != $request->quality){
                $points = new Point;
                $points->user_id = Auth::user()->id;
                $points->point = 20;
                $points->type = "Add";
                $points->reason = "Marking project Id: <a href=\"\">".$id."</a> as ".$request->quality;
                $points->save();
            }
            
            $point = $request->pName != null && $project->project_name != $request->pName ? $point+2 : $point+0;
            // road name
            $point = $request->rName != null && $project->road_name != $request->rName ? $point+2 : $point+0;        
            // road width
            $point = $request->rWidth != null && $project->road_width != $request->rWidth ? $point+4 : $point+0;
            // Construction type
            if(count($request->construction_type) != 0){
                $construction_types = implode(", ",$request->constructionType);
            }else{
                $construction_types = $project->construction_type;
            }
            $point = $request->constructionType != null && $project->construction_type != $construction_types ? $point+5 : $point+0;
            // interested in rmc
            $point = $request->rmcinterest != null && $project->interested_in_rmc != $request->rmcinterest ? $point+3 : $point+0;
            // type of contract
            $point = $request->contract != null && $project->contract != $request->contract ? $point+6 : $point+0;
            // project status
            if(count($request->status) != 0){
                $statuses = implode(", ",$request->status);
            }else{
                $statuses = $project->project_status;
            }
            $point = $request->status != null && $project->project_status != $statuses ? $point+5 : $point+0;
            // project type
            $point = ($request->basement != null && $request->ground != null) && ($request->basement != $project->basement && $request->ground != $project->ground) ? $point+5 : $point+0;
            // project size
            $point = $request->pSize != null && $project->project_size != $request->pSize ? $point+8 : $point+0;
            // budgettype
            $point = $request->budgetType != null && $project->budgetType != $request->budgetType ? $point+3 : $point+0;
            // total budget
            $point = $request->budget != null && $project->budget != $project->budget ? $point+5 : $point+0;
            // project Image
            $point = $request->pImage != null ? $point+6 : $point+0;
            // room types
            $point = $request->floorNo[0] != null ? $point+5 : $point+0;
            // owner details
            $point = $request->oName != null && $project->ownerdetails->owner_name != $request->oName ? $point+5 : $point+0;
            $point = $request->oEmail != null && $project->ownerdetails->owner_email != $request->oEmail ? $point+5 : $point+0;
            $point = $request->oContact != null && $project->ownerdetails->owner_contact_no != $request->oContact ? $point+5 : $point+0;
            // contractor details
            $point = $request->cName != null && $project->contractordetails->contractor_name != $request->cName ? $point+3 : $point+0;
            $point = $request->cEmail != null && $project->contractordetails->contractor_email != $request->cEmail ? $point+3 : $point+0;
            $point = $request->cContact != null && $project->contractordetails->contractor_contact_no != $request->cContact ? $point+3 : $point+0;
            // consultant details
            // $point = $request->coName != null ? $point+3 : $point+0;
            // $point = $request->coEmail != null ? $point+3 : $point+0;
            // $point = $request->coContact != null ? $point+3 : $point+0;
            // site engineer details
            $point = $request->eName != null && $project->siteengineerdetails->site_engineer_name != $request->eName ? $point+3 : $point+0;
            $point = $request->eEmail != null && $project->siteengineerdetails->site_engineer_email != $request->eEmail ? $point+3 : $point+0;
            $point = $request->eContact != null && $project->siteengineerdetails->site_engineer_contact_no != $request->eContact ? $point+3 : $point+0;
            // procurement details
            $point = $request->prName != null && $project->procurementdetails->procurement_name != $request->prName ? $point+3 : $point+0;
            $point = $request->pEmail != null && $project->procurementdetails->procurement_email != $request->pEmail ? $point+3 : $point+0;
            $point = $request->prPhone != null && $project->procurementdetails->procurement_contact_no != $request->prPhone ? $point+3 : $point+0;
            $point = $request->remarks != null && $project->remarks != $request->remarks ? $point+10 : $point+0;
            
            // store points to database
            if($point != 0){
                $points = new Point;
                $points->user_id = Auth::user()->id;
                $points->point = $point;
                $points->type = "Add";
                $points->reason = "Updating a project";
                $points->save();
            }
        }

        $basement = $request->basement;
        $ground = $request->ground;
        $floor = $basement + $ground + 1;
        if($request->mApprove != NULL){
            $imageName1 = time().'.'.request()->mApprove->getClientOriginalExtension();
            $request->mApprove->move(public_path('projectImages'),$imageName1);
            ProjectDetails::where('project_id',$id)->update([
                'municipality_approval' => $imageName1
            ]);
        }
        if(count($request->oApprove) != 0){
            $i = 0;
            $otherApprovals = "";
            foreach($request->oApprove as $oApprove){
                $imageName2 = $i.time().'.'.$oApprove->getClientOriginalExtension();
                $oApprove->move(public_path('projectImages'),$imageName2);
                if($i == 0){
                    $otherApprovals .= $imageName2;
                }else{
                    $otherApprovals .= ", ".$imageName2;
                }
                $i++;
            }
            ProjectDetails::where('project_id',$id)->update([
                'other_approvals' => $otherApprovals
            ]);
        }
        if($request->pImage){
                        if(count($request->pImage != 0)){
                                   $i = 0;
                                    $projectimage = ""; 

                                    foreach($request->pImage as $pimage){
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
                             }
                            $statusCount = count($request->status);
                            $statuses = $request->status[0];
                            if($statusCount > 1){
                                for($i = 1; $i < $statusCount; $i++){
                                    $statuses .= ", ".$request->status[$i];
                                }
                            }
                            $project_image = new ProjectImage;
                            $project_image->project_id = $id;
                            $project_image->project_status = $statuses;
                            $project_image->image = $projectimage;
                            $project_image->save();
        }
        else{
             $project_image = new ProjectImage;
             $project_image->image = '';
        }

        if($request->remarks != NULL){
            ProjectDetails::where('project_id',$id)->update([
                'remarks' => $request->remarks
            ]);
        }
        $cType = count($request->constructionType);
        $type = $request->constructionType[0];
        if($cType != 1){
            $type .= ", ".$request->constructionType[1];
        }
        $statusCount = count($request->status);
        $statuses = $request->status[0];
        if($statusCount > 1){
            for($i = 1; $i < $statusCount; $i++){
                $statuses .= ", ".$request->status[$i];
            }
        }

        ProjectDetails::where('project_id',$id)->update([
            'project_name' => $request->pName,
            'road_name' => $request->rName,
            'road_width' => $request->rWidth,
            'project_status' => $statuses,
            'basement' => $basement,
            'ground' => $ground,
            'quality' => ($request->quality != null ? $request->quality : 'Unverified'),
            'project_type' => $floor,
            'project_size' => $request->pSize,
            'interested_in_rmc'=>$request->rmcinterest,
            'construction_type'=>$type,
            'follow_up_date' =>$request->follow_up_date,
            'followup' => $request->follow,
            'budget' => $request->budget,
            'contract'=>$request->contract,
            'budgetType' => $request->budgetType,
            'updated_by'=>Auth::user()->id,
            'call_attended_by'=>Auth::user()->id
        ]);
        OwnerDetails::where('project_id',$id)->update([
            'owner_name' => $request->oName,
            'owner_email' => $request->oEmail,
            'owner_contact_no' => $request->oContact
        ]);
        ContractorDetails::where('project_id',$id)->update([
            'contractor_name' => $request->cName,
            'contractor_email' => $request->cEmail,
            'contractor_contact_no' => $request->cContact
        ]);
        ConsultantDetails::where('project_id',$id)->update([
            'consultant_name' => $request->coName,
            'consultant_email' => $request->coEmail,
            'consultant_contact_no' => $request->coContact
        ]);
        SiteEngineerDetails::where('project_id',$id)->update([
            'site_engineer_name' => $request->eName,
            'site_engineer_email' => $request->eEmail,
            'site_engineer_contact_no' => $request->eContact
        ]);
        ProcurementDetails::where('project_id',$id)->update([
            'procurement_name' => $request->pName,
            'procurement_email' => $request->pEmail,
            'procurement_contact_no' => $request->pContact
        ]);
        date_default_timezone_set("Asia/Kolkata");
        loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
            'lastUpdateTime' => date('H:i A')
        ]);
        $ward = WardAssignment::where('user_id',Auth::user()->id)->pluck('subward_id')->first();
        $first = loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->first();
        $assigned = subWard::where('id',$ward)->pluck('sub_ward_name')->first();
        if($first->firstUpdateTime == NULL){
            loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                'firstUpdateTime' => date('H:i A'),
                'allocatedWard' => $assigned,
            ]);
        }
        $check = mktime(12,00,00);
        $checktime = date('H:i:sA',$check);
        $morningcheck=loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->first();
        if(date('H:i:sA') <= $checktime){
            if($morningcheck->noOfProjectsUpdatedInMorning == NULL){
                loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                    'noOfProjectsUpdatedInMorning' => 1
                ]);                
            }else{
                $number=loginTime::where('user_id',Auth::user()->id)
                    ->where('logindate',date('Y-m-d'))
                    ->pluck('noOfProjectsUpdatedInMorning')
                    ->first();
                loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                    'noOfProjectsUpdatedInMorning' => $number + 1
                ]); 
            }
        }
        if($morningcheck->totalProjectsUpdated == NULL){
             loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                    'totalProjectsUpdated' => 1
                ]);
        }else{
            $number2=loginTime::where('user_id',Auth::user()->id)
                    ->where('logindate',date('Y-m-d'))
                    ->pluck('totalProjectsUpdated')
                    ->first();
                loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
                    'totalProjectsUpdated' => $number2 + 1
                ]);
        }
        $room_types = $request->roomType[0]." (".$request->number[0].")";
        $count = count($request->roomType);
        for($i = 0;$i<$count;$i++){
            if($request->number[$i] != null)
            {
                $roomtype = new RoomType;
                $roomtype->floor_no = $request->floorNo[$i];
                $roomtype->room_type = $request->roomType[$i];
                $roomtype->no_of_rooms = $request->number[$i];
                $roomtype->project_id = $id;
                $roomtype->save();
            }
        }
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has updated a project id: ".$id." at ".date('H:i A');
        $activity->save();
        return back()->with('Success','Updated Successfully');
    }
    // uses gtracing column to store morning meter reading
    public function addMorningMeter(Request $request)
    {
        $imageName1 = time().'.'.request()->morningMeter->getClientOriginalExtension();
        $request->morningMeter->move(public_path('meters'),$imageName1);
        date_default_timezone_set("Asia/Kolkata");
        loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
            'morningMeter' => $imageName1,
            'gtracing' => $request->morningMeterReading
        ]);
        return back();
    }
    // uses afternoonData to store morning data reading
    public function addMorningData(Request $request)
    {
        $imageName1 = time().'.'.request()->morningData->getClientOriginalExtension();
        $request->morningData->move(public_path('data'),$imageName1);
        date_default_timezone_set("Asia/Kolkata");
        loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
            'morningData' => $imageName1,
            'afternoonData' => $request->morningDataReading
        ]);
        return back();
    }
    public function afternoonMeter(Request $request)
    {
        $imageName1 = time().'.'.request()->afternoonmMeterImage->getClientOriginalExtension();
        $request->afternoonmMeterImage->move(public_path('meters'),$imageName1);
        date_default_timezone_set("Asia/Kolkata");
        loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
            'afternoonMeter' => $imageName1
        ]);
        return back();
    }
    public function afternoonData(Request $request)
    {
        $imageName1 = time().'.'.request()->afternoonDataImage->getClientOriginalExtension();
        $request->afternoonDataImage->move(public_path('data'),$imageName1);
        date_default_timezone_set("Asia/Kolkata");
        loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
            'afternoonData' => $imageName1
        ]);
        return back();
    }
    // uses afternoonMeter column to store evening meter reading
    public function eveningMeter(Request $request)
    {
        $imageName1 = time().'.'.request()->eveningMeterImage->getClientOriginalExtension();
        $request->eveningMeterImage->move(public_path('meters'),$imageName1);
        date_default_timezone_set("Asia/Kolkata");
        loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
            'eveningMeter' => $imageName1,
            'afternoonMeter' => $request->eveningMeterReading
        ]);
        return back();
    }
    // uses afternoonRemarks column to store evening data reading
    public function eveningData(Request $request)
    {
        $imageName1 = time().'.'.request()->eveningDataImage->getClientOriginalExtension();
        $request->eveningDataImage->move(public_path('data'),$imageName1);
        date_default_timezone_set("Asia/Kolkata");
        // $lastrecord = projectdetails::where('listing_engineer_id',Auth::user()->id)
        // ->where('created_at','like',date('Y-m-d').'%')
        // ->orderBy('created_at','desc')->first();
        // $takeTime = $lastrecord->created_at->format('H:i A');
        loginTime::where('user_id',Auth::user()->id)->where('logindate',date('Y-m-d'))->update([
            'eveningData' => $imageName1,
            'afternoonRemarks'=>$request->eveningDataReading
        ]);
        return back();
    }
    public function morningRemark($id, Request $request)
    {
        loginTime::where('id',$id)->update([
            'morningRemarks' => $request->mRemark
        ]);
        return back();
    }
    public function afternoonRemark($id, Request $request)
    {
        loginTime::where('id',$id)->update([
            'afternoonRemarks' => $request->aRemark
        ]);
        return back();
    }
    public function eveningRemark($id, Request $request)
    {
        loginTime::where('id',$id)->update([
            'total_kilometers' => $request->totalKm,
            'eveningRemarks' => $request->eRemark
        ]);
        return back();
    }
    public function addRequirement(Request $request)
    {
        $requirement = New Requirement;
        $requirement->project_id = $request->pId;
        $categoryname = Category::where('id',$request->mCategory)->pluck('category_name')->first();
        $requirement->main_category = $categoryname;
        $subcategoryname = SubCategory::where('id',$request->sCategory)->pluck('sub_cat_name')->first();
        $requirement->sub_category = $subcategoryname;
        $requirement->material_spec = $request->mSpec;
        if($request->rfImage1){
            $imageName1 = time().'.'.request()->rfImage1->getClientOriginalExtension();
            $request->rfImage1->move(public_path('requirements'),$imageName1);
            $requirement->referral_image1 = $imageName1;
        }
        if($request->rfImage2){
            $imageName2 = time().'.'.request()->rfImage2->getClientOriginalExtension();
            $request->rfImage2->move(public_path('requirements'),$imageName2);
            $requirement->referral_image2 = $imageName2;
        }
        $requirement->requirement_date = $request->rDate;
        $requirement->measurement_unit = $request->measure;
        $requirement->unit_price = $request->uPrice;
        $requirement->brand = $request->brand;
        $requirement->quantity = $request->quantity;
        $requirement->total = $request->total;
        $requirement->notes = $request->notes;
        if($request->truck){
            $requirement->truck = $request->truck;
        }
        $requirement->generated_by = Auth::user()->id;
        $requirement->save();
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has added a new requirement for project id: ".$request->pId." at ".date('H:i A');
        $activity->save();
        return back();
    }
    public function placeOrder($id, Request $request)
    {
        $counting = count($request->requirement);
        if($counting == 0){
            return back()->with('Error','Please select requirements to place order');
        }else{
            for($i = 0;$i<$counting;$i++){
                Requirement::where('project_id',$id)->where('id',$request->requirement[$i])->update(['status' => "Order Placed"]);
            }
        }
        $orders = Requirement::where('project_id',$id)->where('status','Order Placed')->get();
        return view('confirm',['orders'=>$orders,'id'=>$id])->with('Success','Order has been placed successfully');
    }
    public function confirmOrder($id, Request $request)
    {
        $project = projectdetails::where('project_id',$id)->first();
        Requirement::where('project_id',$id)->where('status','Order Placed')->update(['status' => "Order Confirmed"]);
        $orders = Requirement::where('project_id',$id)->where('status','Order Confirmed')->get();
        return redirect($id.'/confirmedOrder')->with('Confirmed','Order has been confirmed')
        ->withInput();
    }
    public function postOrder(Request $request)
    {
        $secret_key = $request->secretkey;
        return view('payment.posting',['secretkey'=>$secret_key]);
    }
    public function getPaymentResponse()
    {
        return view('payment.response');
    }
    public function addTracing(Request $request,$id)
    {
        if($request->gTracing){
            $imageName2 = time().'.'.request()->gTracing->getClientOriginalExtension();
            $request->gTracing->move(public_path('uploads'),$imageName2);
            loginTime::where('id',$id)->update([
                'gtracing' => $imageName2
            ]);
        }else if($request->wTracingI){
            $imageName2 = time().'.'.request()->wTracingI->getClientOriginalExtension();
            $request->wTracingI->move(public_path('uploads'),$imageName2);
            loginTime::where('id',$id)->update([
                'ward_tracing_image' => $imageName2
            ]);
        }else if($request->ewTracingI){
            $imageName2 = time().'.'.request()->ewTracingI->getClientOriginalExtension();
            $request->ewTracingI->move(public_path('uploads'),$imageName2);
            loginTime::where('id',$id)->update([
                'evening_ward_tracing_image' => $imageName2
            ]);
        }else if ($request->TracingIWtH) {
            $imageName2 = time().'.'.request()->TracingIWtH->getClientOriginalExtension();
            $request->TracingIWtH->move(public_path('uploads'),$imageName2);
            loginTime::where('id',$id)->update([
                'tracing_image_w_to_h' => $imageName2
            ]);
        }
        return back();
    }
    public function addComments($id, Request $request)
    {
        if($request->googleKm){
            loginTime::where('id',$id)->update([ 'kmfromhtw' => $request->googleKm ]);
        }else if($request->kmfromts){
            loginTime::where('id',$id)->update([ 'km_from_software' => $request->kmfromts]);
        }else if($request->ekmfromts){
            loginTime::where('id',$id)->update(['evening_km_from_tracking' => $request->ekmfromts]);
        }else if($request->ekmwth){
            loginTime::where('id',$id)->update(['km_from_w_to_h' => $request->ekmwth]);
        }else if($request->loginTimeInWard){
            $check = mktime(12,00);
            $checktime = date('H:i',$check);
            if($request->loginTimeInWard < $checktime){
                $time = 'AM';
            }else{
                $time = 'PM';
            }
            loginTime::where('id',$id)->update([ 'login_time_in_ward' => $request->loginTimeInWard.' '.$time]);
        }else if($request->totalKilometers){
            loginTime::where('id',$id)->update([ 'total_kilometers' => $request->totalKilometers]);
        }
        return back();
    }
    public function giveGrade($userid, $reportid, Request $request)
    {
        loginTime::where('user_id',$userid)->where('id',$reportid)->update(['AmGrade'=>$request->grade,'AmRemarks'=>$request->remarks]);
        return back();
    }
    public function giveRemarks($userid, $reportid, Request $request)
    {
        loginTime::where('user_id',$userid)->where('id',$reportid)->update(['AmRemarks'=>$request->amremarks]);
        return back();
    }
    public function editGrade($userid, $reportid, Request $request){
        loginTime::where('user_id',$userid)->where('id',$reportid)->update(['AmRemarks'=>$request->remarks, 'AmGrade'=>$request->grade]);
        return back();
    }
    public function postRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users'
        ]);
        if ($validator->fails()) {
            return back()
                    ->with('Error','User already exists')
                    ->withErrors($validator)
                    ->withInput();
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
        if($request->category == "Buyer"){
            View::share('password',$request->password);
            View::share('email',$request->email);
            View::share('name',$request->name);
            Mail::to($request->email)->send(new registration($user));
        }
        return back()->with('Success','Thank you for your registration. Mama team will contact you shortly.');
    }
    public function confirmUser(Request $request)
    {
        User::where('id',$request->id)->update(['confirmation'=>1]);
        return back();
    }
    public function totalKm($id, Request $request){
        loginTime::where('user_id',$id)->where('id',$reportid)->update(['total_kilometers'=>$request->tkm]);
        return back();
    }
    public function postChangePassword(Request $request){
        $old = User::where('id',Auth::user()->id)->pluck('password')->first();
        if (Hash::check($request->oldPwd, $old)) {
            User::where('id',Auth::user()->id)->update(['password'=>bcrypt($request->newPwd)]);
            $activity = new ActivityLog;
            $activity->time = date('Y-m-d H:i A');
            $activity->employee_id = Auth::user()->employeeId;
            $activity->activity = Auth::user()->name." has changed the password.";
            $activity->save();
            return redirect('/home');
        }else{
            $activity = new ActivityLog;
            $activity->time = date('Y-m-d H:i A');
            $activity->employee_id = Auth::user()->employeeId;
            $activity->activity = Auth::user()->name." attempted to change password but failed.";
            $activity->save();
            return back()->with('Error','Invalid password');
        }
    }
    public function forgotPw(){
        return view('forgotpassword');
    }
    public function forgot(Request $request){
        $password = User::where('id',$request->id)->update(['password'=>bcrypt($request->newpassword)]);
        return back();
    }
    public function assignthisSlot($id, Request $request){
        $x = salesassignment::where('user_id',$id)->get();
        if(count($x) > 0)
        {
            $assignment = salesassignment::where('user_id',$id)->first();
            $ward = Ward::where('id',$assignment->assigned_date)->first();
            if($ward != null){
                $assignment->prev_assign = $ward->ward_name;
            }
           
            $assignment->assigned_date = $request->subward;
            $assignment->status = 'Not Completed';
            $assignment->save();
            // salesassignment::where('user_id',$id)->update(['status'=>'Not Completed','assigned_date' => $request->date]);
            $activity = new ActivityLog;
            $activity->time = date('Y-m-d H:i A');
            $activity->employee_id = Auth::user()->employeeId;
            $activity->activity = Auth::user()->name." has assigned ".$id." to a daily slot for the date ".$request->date;
            $activity->save();
            return back();
        }
        else
        {
            $user = User::where('id',$request->id)->first();
            $assignment = new salesassignment;
            $assignment->user_id = $id;
            $assignment->assigned_date = $request->subward;
            $assignment->status = 'Not Completed';
            $assignment->save();
            $activity = new ActivityLog;
            $activity->time = date('Y-m-d H:i A');
            $activity->employee_id = Auth::user()->employeeId;
            $activity->activity = Auth::user()->name." has assigned ".$id." to a daily slot for the date ".$request->date;
            $activity->save();
            return back()->with('Success','Daily Slot assigned to '.$user->name);
        }
    }
    public function completedAssignment( Request $request)
    {
        $id = $request->id;
        $sub = WardAssignment::where('user_id',$id)->first();
        WardAssignment::where('user_id',$id)->update(['status' => 'Completed','prev_subward_id'=> $sub->subward_id]);
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has marked ".$id."'s assignment as completed.";
        $activity->save();
        return back();
    }
    public function editMorninRemarks($id, Request $request){
        loginTime::where('id',$id)->update(['morningRemarks'=>$request->remark]);
        return back();
    }
    public function editEveningRemarks($id, Request $request){
        loginTime::where('id',$id)->update(['eveningRemarks'=>$request->remark]);
        return back();
    }
    public function salesUpdateProject($id, Request $request){
        $point = 0;
        $project = ProjectDetails::where('project_id',$id)->first();
        if(count($request->status) != 0){
            $statuses = implode(", ",$request->status);
        }else{
            $statuses = $project->project_status;
        }
        if(count($request->constructionType) != 0){
            $type = implode(", ",$request->constructionType);
        }else{
            $type = $project->construction_type;
        }
        $point = $project->construction_type != $type ? $point+5 : $point+0;
        $point = $project->project_status != $statuses ? $point+5 : $point+0;
        $point = $project->road_width != $request->rWidth ? $point+4 : $point+0;
        $point = $project->quality != $request->quality ? $point+20 : $point+0;
        $point = $project->contract != $request->contract ? $point+6 : $point+0;
        $points = new Point;
        $points->user_id = Auth::user()->id;
        $points->point = $point;
        $points->type = "Add";
        $points->reason = "Updating project";
        $points->save();


        projectDetails::where('project_id',$id)->update([
            'project_status'=>$statuses,
            'remarks'=>$request->materials,
            'with_cont'=>$request->qstn,
            'reqDate' =>$request->reqDate,
            'followup'=>$request->followup,
            'follow_up_date' =>$request->follow_up_date,
            'construction_type'=>$type,
            'road_width'=>$request->rWidth,
            'quality'=>$request->quality,
            'contract'=>$request->contract,
            'note'=>$request->note,
            'follow_up_by'=>Auth::user()->id,
            'call_attended_by'=>Auth::user()->id
            ]);
 

        siteAddress::where('project_id',$id)->update([
            'address'=>$request->address
            ]);
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has updated a project id: ".$id." at ".date('H:i A')." with data - Status: ".$statuses.", Remarks: ".$request->materials.", Question: ".$request->qstn.", Followup: ".$request->follow.", Quality: ".$request->quality.", With contractor: ".$request->contract.", Note: ".$request->note;
        $activity->save();
        return back();
    }
    public function gradetoEmp(Request $request){
        attendance::where('empId',$request->userId)->where('date',$request->date)->update(['grade'=>$request->grade,'remarks'=>$request->remark,'am_remarks'=>$request->amremark]);
        return back();
    }
    public function saveEdit(Request $request){
        $check = EmployeeDetails::where('employee_id',$request->userid)->first();
        User::where('employeeId',$request->userid)->update(['contactNo'=>$request->contact]);
        if(count($check)==0){
            $empDetails = new EmployeeDetails;
            $empDetails->employee_id = $request->userid;
            $empDetails->date_of_joining = $request->doj;
            $empDetails->adhar_no = $request->aadhar;
            if($request->aadharImg != NULL){
                $aadhar = "aadhar".time().'.'.request()->aadharImg->getClientOriginalExtension();
                $request->aadharImg->move(public_path('employeeImages'),$aadhar);
                $empDetails->aadhar_image = $aadhar;
            }
            $empDetails->dob =$request->dob;
            $empDetails->blood_group = $request->bloodGroup;
            $empDetails->fathers_name = $request->fatherName;
            $empDetails->mothers_name = $request->motherName;
            $empDetails->spouse_name = $request->spouseName;
            $empDetails->alt_phone = $request->altPh;
            $empDetails->office_phone = $request->office;
            $empDetails->official_email = $request->official_email;
            $empDetails->mh_email = $request->mh_email;
            $empDetails->personal_email = $request->personal_email;
            $empDetails->permanent_address = $request->perAdd;
            if($request->permanenAddressProof != NULL){
                $address = "address1".time().'.'.request()->permanenAddressProof->getClientOriginalExtension();
                $request->permanenAddressProof->move(public_path('employeeImages'),$address);
                $empDetails->permanent_address_proof = $address;
            }
            $empDetails->temporary_address = $request->preAdd;
            if($request->presentAddressProof != NULL){
                $present = "address2".time().'.'.request()->presentAddressProof->getClientOriginalExtension();
                $request->presentAddressProof->move(public_path('employeeImages'),$present);
                $empDetails->temporary_address_proof = $present;
            }
            $empDetails->emergency_contact_name = $request->emergencyName;
            $empDetails->emergency_contact_no = $request->emergencyContact;
            $empDetails->emergency_contact2_name = $request->emergencyName2;
            $empDetails->emergency_contact2_no = $request->emergencyContact2;
            if($request->cv != NULL){
                $cvv = "cv".time().'.'.request()->cv->getClientOriginalExtension();
                $request->cv->move(public_path('employeeImages'),$cvv);
                $empDetails->curriculum_vite = $cvv;
            }
            if($request->cfa != NULL){
                $cfa = time().'.'.request()->cfa->getClientOriginalExtension();
                $request->cfa->move(public_path('employeeAudios'),$cfa);
                $empDetails->confirmation_call = $cfa;
            }
            if($request->cfa2 != NULL){
                $cfa2 = $request->emergencyName2.time().'.'.request()->cfa2->getClientOriginalExtension();
                $request->cfa2->move(public_path('employeeAudios'),$cfa2);
                $empDetails->confirmation_call2 = $cfa2;
            }
            $empDetails->save();
        }else{
            $check->employee_id = $request->userid;
            $check->date_of_joining = $request->doj;
            $check->adhar_no = $request->aadhar;
            if($request->aadharImg != NULL){
                $aadhar = "aadhar".time().'.'.request()->aadharImg->getClientOriginalExtension();
                $request->aadharImg->move(public_path('employeeImages'),$aadhar);
                $check->aadhar_image = $aadhar;
            }
            $check->dob =$request->dob;
            $check->blood_group = $request->bloodGroup;
            $check->fathers_name = $request->fatherName;
            $check->mothers_name = $request->motherName;
            $check->spouse_name = $request->spouseName;
            $check->alt_phone = $request->altPh;
            $check->office_phone = $request->office;
            $check->official_email = $request->official_email;
            $check->mh_email = $request->mh_email;
            $check->personal_email = $request->personal_email;
            $check->permanent_address = $request->perAdd;
            if($request->permanenAddressProof != NULL){
                $address = "address1".time().'.'.request()->permanenAddressProof->getClientOriginalExtension();
                $request->permanenAddressProof->move(public_path('employeeImages'),$address);
                $check->permanent_address_proof = $address;
            }
            $check->temporary_address = $request->preAdd;
            if($request->presentAddressProof != NULL){
                $present = "address2".time().'.'.request()->presentAddressProof->getClientOriginalExtension();
                $request->presentAddressProof->move(public_path('employeeImages'),$present);
                $check->temporary_address_proof = $present;
            }
            $check->emergency_contact_name = $request->emergencyName;
            $check->emergency_contact_no = $request->emergencyContact;
            $check->emergency_contact2_name = $request->emergencyName2;
            $check->emergency_contact2_no = $request->emergencyContact2;
            if($request->cv != NULL){
                $cvv = "cv".time().'.'.request()->cv->getClientOriginalExtension();
                $request->cv->move(public_path('employeeImages'),$cvv);
                $check->curriculum_vite = $cvv;
            }
            if($request->cfa != NULL){
                $cfa = time().'.'.request()->cfa->getClientOriginalExtension();
                $request->cfa->move(public_path('employeeAudios'),$cfa);
                $check->confirmation_call = $cfa;
            }
            if($request->cfa2 != NULL){
                $cfa2 = $request->emergencyName2.time().'.'.request()->cfa2->getClientOriginalExtension();
                $request->cfa2->move(public_path('employeeAudios'),$cfa2);
                $check->confirmation_call2 = $cfa2;
            }
            $check->save();
        }
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has updated ".$request->userid." details.";
        $activity->save();
        return back();
    }
    public function saveBankDetails(Request $request){
        $check = BankDetails::where('employeeId',$request->userid)->first();
        if(count($check)==0){
            $bankDetails = new BankDetails;
            $bankDetails->employeeId = $request->userid;
            $bankDetails->accountHolderName = $request->acHolder;
            $bankDetails->bank_name = $request->bankName;
            $bankDetails->accountNo = $request->acNo;
            $bankDetails->ifsc = $request->ifsc;
            $bankDetails->branchName = $request->branchName;
            if($request->passbook != NULL){
                $cvv = 'pas'.time().'.'.request()->passbook->getClientOriginalExtension();
                $request->passbook->move(public_path('employeeImages'),$cvv);
                $bankDetails->passbook = $cvv;
            }
            $bankDetails->pan_card_no = $request->panCard;
            if($request->panCardImage != NULL){
                $cvv = 'pan'.time().'.'.request()->panCardImage->getClientOriginalExtension();
                $request->panCardImage->move(public_path('employeeImages'),$cvv);
                $bankDetails->pan_card_image = $cvv;
            }
            $bankDetails->save();
        }else{
            $check->accountHolderName = $request->acHolder;
            $check->bank_name = $request->bankName;
            $check->accountNo = $request->acNo;
            $check->ifsc = $request->ifsc;
            $check->branchName = $request->branchName;
            if($request->passbook != NULL){
                $cvv = 'pas'.time().'.'.request()->passbook->getClientOriginalExtension();
                $request->passbook->move(public_path('employeeImages'),$cvv);
                $check->passbook = $cvv;
            }
            $check->pan_card_no = $request->panCard;
            if($request->panCardImage != NULL){
                $cvv = 'pan'.time().'.'.request()->panCardImage->getClientOriginalExtension();
                $request->panCardImage->move(public_path('employeeImages'),$cvv);
                $check->pan_card_image = $cvv;
            }
            $check->save();
        }
        return back();
    }
    public function saveAssetInfo(Request $request){
        $count = count($request->type);

        $empimage = time().'.'.request()->emp_image->getClientOriginalExtension();
        $request->emp_image->move(public_path('empsignature'),$empimage);
        $mimage = time().'.'.request()->manager_image->getClientOriginalExtension();
        $request->manager_image->move(public_path('managersignature'),$mimage);
        for($i = 0; $i<$count;$i++){
            $assetInfo = new AssetInfo;

            $assetInfo->employeeId = $request->userId;
            $type = Asset::where('id',$request->type[$i])->pluck('type')->first();
            $assetInfo->asset_type = $type;
            $name = MamahomeAsset::where('id',$request->mname)->pluck('name')->first();
            $assetInfo->name = $name;
            $assetInfo->emp_signature = $empimage;
            $assetInfo->manager_signature = $mimage;
            $snum = MamahomeAsset::where('id',$request->number)->pluck('sl_no')->first();
            $assetInfo->serial_no = $snum;
            $assetInfo->assign_date =$request->tdate;
            $assetInfo->remark = $request->remark[$i];
            $assetInfo->description = $request->details;
            $assetInfo->mh_id = $request->mname;
            $assetInfo->save();
        }
            $mhasset = MamahomeAsset::where('id',$request->mname)->first();
            $mhasset->status = "Assigned";
            $mhasset->save();
      
        return back();
    }
    public function uploadCertificates(Request $request){
        $count = count($request->type);
        for($i=0;$i<$count;$i++){
            $certificates = new Certificate;
            $certificates->employeeId = $request->userId;
            $certificates->type = $request->type[$i];
            if($request->certificateFile[$i] != NULL){
                $cvv = $request->userId.$i.time().'.'.request()->certificateFile[$i]->getClientOriginalExtension();
                $request->certificateFile[$i]->move(public_path('employeeImages'),$cvv);
                $certificates->location = $cvv;
            }
            $certificates->save();
        }
        return back();
    }
    public function insertCat(Request $request){
        CategoryPrice::where('category_sub_id',$request->subcategory)
            ->update([
                'price'=>$request->price,
                'gst'=>$request->gst,
                'transportation_cost'=>$request->tc,
                'royalty'=>$request->royalty
            ]);
        return back();
    }
    public function addManufacturer(Request $request){
        $pan = $request->companyName.time().'.'.request()->pan->getClientOriginalExtension();
        $request->pan->move(public_path('pan'),$pan);
        $manufacturer = new ManufacturerDetail;
        $manufacturer->vendortype = $request->vendortype;
        $manufacturer->company_name = $request->companyName;
        $manufacturer->category = $request->category;
        $manufacturer->cin = $request->cin;
        $manufacturer->gst = $request->gst;
        $manufacturer->registered_office = $request->regOffice;
        $manufacturer->pan = $pan;
        $manufacturer->production_capacity = $request->productionCapacity;
        $manufacturer->factory_location = $request->factoryLocation;
        $manufacturer->ware_house_location = $request->warehouselocation;
        $manufacturer->md = $request->md;
        $manufacturer->ceo = $request->ceo;
        $manufacturer->sales_contact = $request->salesContact;
        $manufacturer->finance_contact = $request->financeContact;
        $manufacturer->quality_department = $request->qualityDept;
        $manufacturer->save();
        return back()->with('Success','Manufacturer details added successfully');
    }
    public function editsubwardimage(Request $request){
        $subwardName = SubWard::where('id',$request->subwardId)->first();
        $subward = $subwardName->sub_ward_name.time().'.'.request()->subwardimage->getClientOriginalExtension();
        $request->subwardimage->move(public_path('subWardImages'),$subward);
        $subwardName->sub_ward_image = $subward;
        $subwardName->save();
        return back();
    }
    public function updateLogoutTime(Request $request)
    {
        loginTime::where('id',$request->id)->update(['logoutTime'=>$request->logoutTime]);
        return back()->with('Success','Logout time updated');
    }
    public function markLeave(Request $request){
        $check = loginTime::where('user_id',$request->id)->where('logindate',$request->date)->first();
        if($check == null){
            $login = new loginTime;
            $login->user_id =$request->id;
            $login->loginTime = "N/a";
            $login->logindate = $request->date;
            $login->login_time_in_ward = $request->leave;
            $login->save();
        }else{
            loginTime::where('user_id',$request->id)->where('logindate',$request->date)->update(['login_time_in_ward'=>$request->leave]);
        }
        return back();
    }
    public function markProject(Request $request)
    {
        ProjectDetails::where('project_id',$request->id)->update(['quality'=>$request->quality]);
        $points = new Point;
        $points->user_id = Auth::user()->id;
        $points->point = 20;
        $points->type = "Add";
        $points->reason = "Marking project Id: ".$id." as ".$request->quality;
        $points->save();
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has marked project ".$request->id." as ".$request->quality;
        $activity->save();
        return back();
    }
    public function editEnquiry(Request $request)
    {
        if($request->note != null){
            Requirement::where('id',$request->id)->update(['notes'=>$request->note]);
        }elseif($request->status != null){
            Requirement::where('id',$request->id)->update(['status'=>$request->status]);
            $requirement = Requirement::where('id',$request->id)->first();
            if($requirement->status == "Enquiry Confirmed"){
                $project = ProjectDetails::where('project_id',$requirement->project_id)->first();
                $subward = SubWard::where('id',$project->sub_ward_id)->first();
                $ward = Ward::where('id',$subward->ward_id)->first();
                $zone = Zone::where('id',$ward->zone_id)->first();
                $country = Country::where('id',$ward->country_id)->first();
                $year = date('Y');
                $country_initial = strtoupper(substr($country->country_name,0,2));
                $count = count(Order::all())+1;
                $number = sprintf("%03d", $count);
                $orderNo = "MH_".$country->country_code."_".$zone->zone_number."_".$year."_".$country_initial.$number;
                $order = new Order;
                $order->id = $orderNo;
                $order->project_id = $requirement->project_id;
                $order->main_category = $requirement->main_category;
                $order->brand = $requirement->brand;
                $order->sub_category = $requirement->sub_category ;
                $order->material_spec = $requirement->material_spec;
                $order->referral_image1 = $requirement->referral_image1;
                $order->referral_image2 = $requirement->referral_image2;
                $order->requirement_date = $requirement->requirement_date;
                $order->measurement_unit = $requirement->measurement_unit;
                $order->unit_price = $requirement->unit_price;
                $order->quantity = $requirement->quantity;
                $order->total = $requirement->total;
                $order->notes = $requirement->notes;
                $order->status = $requirement->status;
                $order->dispatch_status = $requirement->dispatch_status;
                $order->generated_by  = $requirement->generated_by;
                $order->save();
            }
        }
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has updated requirement id: ".$request->id." as ".$request->note.$request->status;
        $activity->save();
        return back();
    }
    public function editManualEnquiry(Request $request)
    {
        RecordData::where('id',$request->id)->update(['rec_remarks'=>$request->note]);
        $activity = new ActivityLog;
        $activity->time = date('Y-m-d H:i A');
        $activity->employee_id = Auth::user()->employeeId;
        $activity->activity = Auth::user()->name." has updated enquiry id: ".$request->id." as ".$request->note;
        $activity->save();
        return back();
    }
    public function deleteProject(Request $request)
    {
        ProjectDetails::where('project_id',$request->projectId)->update(['deleted'=>1]);
        return back();
    }
    public function editinputdata(Request $request)
    {
        // for fetching sub categories
        $sub_cat_name = SubCategory::whereIn('id',$request->subcat)->pluck('sub_cat_name')->toArray();
        $subcategories = implode(", ", $sub_cat_name);
         
            // fetching brands
        $brand_ids = SubCategory::whereIn('id',$request->subcat)->pluck('brand_id')->toArray();
        $brand = brand::whereIn('id',$brand_ids)->pluck('brand')->toArray();
        $brandnames = implode(", ", $brand);
        $get = implode(", ",array_filter($request->quan));
        $another = explode(", ",$get);
        $quantity = array_filter($request->quan);
        for($i = 0;$i < count($request->subcat); $i++){
            if($i == 0){
                $sub = SubCategory::where('id',$request->subcat[$i])->pluck('sub_cat_name')->first();
                $qnty = $sub." :".$another[$i];
            }else{
                $sub = SubCategory::where('id',$request->subcat[$i])->pluck('sub_cat_name')->first();
                $qnty .= ", ".$sub." :".$another[$i];
            }
        }

        $category_ids = SubCategory::whereIn('id',$request->subcat)->pluck('category_id')->toArray();
        $category= Category::whereIn('id',$category_ids)->pluck('category_name')->toArray();
        $categoryNames = implode(", ", $category);
      
        $x = Requirement::where('id',$request->reqId)->update([
            'main_category' => $categoryNames,
            'brand' => $brandnames,
            'sub_category'  =>$subcategories,
            'generated_by' => $request->initiator,
            'quantity' => $qnty,
             'notes' => $request->eremarks,
            'requirement_date' => $request->edate
        ]);
         if($x)
        {
            return back()->with('success','Enquiry updated Successfully !!!');
        }
        else
        {
            return back()->with('success','Error Occurred !!!');
        }
       
    }
    public function saveMap(Request $request)
    {
        if($request->page == "Zone"){
            if($check = ZoneMap::where('zone_id',$request->zone)->count() == 0){
                $map = new ZoneMap;
                $map->zone_id = $request->zone;
                $map->lat = $request->path;
                $map->color = $request->color;
                $map->save();
            }else{
                $check = ZoneMap::where('zone_id',$request->zone)->first();
                $check->lat = $request->path;
                $check->color = $request->color;
                $check->save();
            }
        }elseif($request->page == "Ward"){
            if($check = WardMap::where('ward_id',$request->zone)->count() == 0){
                $map = new WardMap;
                $map->ward_id = $request->zone;
                $map->lat = $request->path;
                $map->color = $request->color;
                $map->save();
            }else{
                $check = WardMap::where('ward_id',$request->zone)->first();
                $check->lat = $request->path;
                $check->color = $request->color;
                $check->save();
            }
        }elseif($request->page == "Sub Ward"){
            if($check = SubWardMap::where('sub_ward_id',$request->zone)->count() == 0){
                $map = new SubWardMap;
                $map->sub_ward_id = $request->zone;
                $map->lat = $request->path;
                $map->color = $request->color;
                $map->save();
            }else{
                $check = SubWardMap::where('sub_ward_id',$request->zone)->first();
                $check->lat = $request->path;
                $check->color = $request->color;
                $check->save();
            }
        }
        return back();
    }
    public function saveWardMap(Request $request)
    {
        $check = WardMap::where('ward_id',$request->ward_id)->first();
        if(count($check)== 0){
            $wardmaps = new WardMap;
            $wardmaps->ward_id = $request->ward_id;
            $wardmaps->lat = $request->path;
            $wardmaps->color = $request->color;
            $wardmaps->save();
        }else{
            $check->ward_id = $request->ward_id;
            $check->lat = $request->path;
            $check->color = $request->color;
            $check->save();
        }
        return back();
    }
    public function addPoints(Request $request)
    {
        $point = new Point;
        $point->user_id = $request->userId;
        $point->point = $request->point;
        $point->type = $request->type;
        $point->reason = $request->reason;
        $point->confirmation = Auth::user()->department_id == 1 ? 0 : 1;
        $point->created_at = $request->date;
        $point->updated_at = $request->date;
        $point->save();
        return back()->with('Success','Your request has been sent and is waiting for admin approval');
    }
    public function addDeliveryBoy(Request $request)
    {
        Order::where('id',$request->orderId)->update(['delivery_boy'=>$request->delivery]);
        return back();
    }
}
