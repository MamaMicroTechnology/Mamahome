<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;
use App\ContractorDetails;
use App\ProjectDetails;
use App\ProcurementDetails;
use App\SiteEngineerDetails;
use App\OwnerDetails;
use App\ConsultantDetails;
use App\RoomType;
use DB;
use Auth;
use App\training;
use App\Message;

date_default_timezone_set("Asia/Kolkata");
class ContractorController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $message = Message::where('read_by','NOT LIKE',"%".$this->user->id."%")->count();
            View::share('chatcount', $message);
            $trainingCount = training::where('dept',$this->user->department_id)
                            ->where('designation',$this->user->group_id)
                            ->where('viewed_by','NOT LIKE',"%".$this->user->id."%")->count();
            View::share('trainingCount',$trainingCount);
            return $next($request);
        });
    }

    public function getUpdates()
    {
      if(Auth::user()->employeeId == "MH398"){
        return redirect('contractorDetails?page=1');
      }elseif(Auth::user()->employeeId == "MH401"){
        return redirect('contractorDetails?page=2');
      }elseif(Auth::user()->employeeId == "MH296"){
        return redirect('contractorDetails?page=3');
      }elseif(Auth::user()->employeeId == "MH390"){
        return redirect('contractorDetails?page=4');
      }else{
        return redirect('contractorDetails');
      }
    }
    public function getWhatYouWant()
    {
      $projectIds = OwnerDetails::where('owner_name','!=',null)->pluck('project_id');
      $projects = ProjectDetails::whereIn('project_id',$projectIds)->get();
      return view('owners',['projects'=>$projects]);
    }
    public function getContractorDetails()
    {
      $projectIds = OwnerDetails::whereNotNull('owner_contact_no')->orderby('owner_contact_no')->pluck('project_id');
      if(Auth::user()->employeeId == "MH296" || Auth::user()->employeeId == "MH390" || Auth::user()->employeeId == "MH404"){
        $projects = ProjectDetails::where('project_status',"Plastering")->paginate(30);
      }else{
        $projects = ProjectDetails::where('project_status',"Roofing")->paginate(30);
      }
    	return view('contractor',['projects'=>$projects]);
    }
   	public function getProjects(Request $request)
   	{
   		$projectIds = ContractorDetails::where('contractor_contact_no',$request->phone)->pluck('project_id');
   		$projects = ProjectDetails::whereIn('project_id',$projectIds)->get();
   		$tab = "";
   		if(count($projects) != 0){
	   		foreach($projects as $project){
	   			$tab .= "<tr><td>".$project->contractordetails->contractor_name."</td>
	   						<td>".$project->contractordetails->contractor_contact_no."</td>
	   						<td>".$project->contractordetails->contractor_email."</td>
	   						<td>".$project->siteaddress->address."</td>
	   						<td>".$project->budget." Cr. </td>
	   						<td>".$project->project_size." Sq.m</td>
	   						<td>".$project->project_status."</td>
	   						<td>".$project->quality."</td>
	   						<td><a target='_blank' href='https://mamahome360.com/webapp/ameditProject?projectId=".$project->project_id."' class='btn btn-primary btn-sm'>Edit</a></td></tr>";
	   		}
   		}else{
   			$tab .= "<tr style='background-color:orange; color:white;'><td colspan='5'><center>No records found</center></td></tr>";
   		}
   		return response()->json($tab);
   	}
   	public function getNoOfProjects(Request $request)
   	{
      if($request->phone){
        $projectIds = new Collection;
        $conName = ContractorDetails::where('contractor_contact_no',$request->phone)->pluck('project_id')->first();
        $projectIds = $projectIds->merge($conName);
        $procurement=ProcurementDetails::where('procurement_contact_no',$request->phone)->pluck('project_id')->first();
        $projectIds = $projectIds->merge($procurement);
        $consultant=ConsultantDetails::where('consultant_contact_no',$request->phone)->pluck('project_id')->first();
        $projectIds = $projectIds->merge($consultant);
        $siteEngineer=SiteEngineerDetails::where('site_engineer_contact_no',$request->phone)->pluck('project_id')->first();
        $projectIds = $projectIds->merge($siteEngineer);
        $owner=OwnerDetails::where('owner_contact_no',$request->phone)->pluck('project_id')->first();
        $projectIds = $projectIds->merge($owner);
        $projects = array();
        $projectIds = ContractorDetails::where('contractor_contact_no',$request->phone)->pluck('project_id');
        $projects[$request->phone] = ProjectDetails::whereIn('project_id',$projectIds)->count();
      }else{
        $contractors = ContractorDetails::groupby('contractor_contact_no')->pluck('contractor_contact_no');
        $conName = ContractorDetails::wherein('contractor_contact_no',$contractors)->paginate(10);
        $projects = array();
        foreach($conName as $contractor){
          $projectIds = ContractorDetails::where('contractor_contact_no',$contractor->contractor_contact_no)->pluck('project_id');
          $projects[$contractor->contractor_contact_no] = ProjectDetails::whereIn('project_id',$projectIds)->count();
        }
      }
   		return view('contractorProjects',['projects'=>$projects,'conName'=>$conName]);
   	}
  public function viewProjects(Request $request)
    {
     
      
      $table = "<tr> <td colspan='8'><center>Material Estimation prices may vary according to Market Price</center> </td></center></tr>
     
      <tr><th>Category</th><th>Total Required</th><th>Total Amount</th></tr>";
      $projectIds = ContractorDetails::where('contractor_contact_no',$request->no)->pluck('project_id');
      $procurement = ProcurementDetails::where('procurement_contact_no',$request->no)->pluck('project_id');
      $projectIds = $projectIds->merge($procurement);
      $projects = ProjectDetails::whereIn('project_id',$projectIds)->get();
      $roomTypes = RoomType::whereIn('project_id',$projectIds)->get();
      foreach($roomTypes as $type){
        $size = ProjectDetails::where('project_id',$type->project_id)->pluck('project_size')->first();
        $cases = $type->room_type;
        switch ($cases) {
          case '1BHK':
              $floors=1;
              $kitchen=1;
              $bedroom=1;
              $hall=1;
              $bathroom=1;
              $flatsfloors=1;
            break;
          case '2BHK':
              $floors=1;
              $kitchen=1;
              $bedroom=2;
              $hall=1;
              $bathroom=1;
              $flatsfloors=1;
            break;
          case '3BHK':
              $floors=1;
              $kitchen=1;
              $bedroom=3;
              $hall=1;
              $bathroom=1;
              $flatsfloors=1;
            break;
          default:
              $floors=1;
              $kitchen=1;
              $bedroom=1;
              $hall=1;
              $bathroom=1;
              $flatsfloors=1;
            break;
        }
        
      }
      $steel = array();
      $cement = array();
      $plumbing = array();
      $doors = array();
      $flooring = array();
      $sand = array();
      $aggregates = array();
      $blocks = array();
      $electrical = array();

     
      $totalPlumbing =0;
      $totaldoors=0;
      $totalflooring=0;
      $totalcement = 0;
      $totalsteel = 0;
      $totalsand = 0;
      $totalaggregates = 0;
      $totalblocks = 0;
      $totalelectrical = 0;
      $i = 0;
      foreach($projects as $project){
        $Total_Flats = $project->project_type;
        $Total_Area = $project->project_type * $project->project_size;
        $stage = $project->project_status;
        switch ($stage) {
          case 'Planning':
             
              $plumbingRequirement = 100;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
              $cementRequirement = 100;
              $steelRequirement  = 100;
              $sandRequirement = 100;
              $aggregatesRequirement = 100;
              $blocksRequirement = 100;
              $electricalRequirement = 100;
              // calculation Part
             
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);

            break;
          case 'Digging':
             
              $plumbingRequirement = 100;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
              $cementRequirement = 100;
              $steelRequirement  = 100;
              $sandRequirement = 100;
              $aggregatesRequirement = 100;
              $blocksRequirement = 100;
              $electricalRequirement = 100;

// calculation Part
             
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);
         break;
          case 'Foundation':
             
              $plumbingRequirement = 100;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement =85;
               $steelRequirement  = 70;
              $sandRequirement = 90;
              $aggregatesRequirement = 80;
              $blocksRequirement = 100;

              $electricalRequirement = 100;


// calculation Part
              
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);

                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);

            break;
          case 'Pillar':
             
              $plumbingRequirement = 100;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement = 70;
               $steelRequirement  = 35;
              $sandRequirement = 70;
              $aggregatesRequirement = 50;
              $blocksRequirement = 100;
              $electricalRequirement = 100;


// calculation Part
             
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100);
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);

                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);
             break;
          case 'Walling':
             
              $plumbingRequirement = 100;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement = 55;
               $steelRequirement  = 35;
              $sandRequirement = 50;
               $aggregatesRequirement = 50;
              $blocksRequirement = 100;
              $electricalRequirement = 100;
// calculation Part
             
               $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);

                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);

            break;
          case 'Roofing':
            
              $plumbingRequirement = 100;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement = 25;
               $steelRequirement  = 35;
              $sandRequirement = 35;
               $aggregatesRequirement = 50;
              $blocksRequirement = 0;
              $electricalRequirement = 100;

 // calculation Part
             
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);


            break;
          case 'Electrical':
              
              $plumbingRequirement = 100;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement = 25;
               $steelRequirement  = 0;
              $sandRequirement = 35;
               $aggregatesRequirement = 0;
              $blocksRequirement = 0;
              $electricalRequirement = 100;

 // calculation Part
             
               $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100);
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);







            break;
          case 'Plumbing':
            
              $plumbingRequirement = 100;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement = 25;
               $steelRequirement  = 0;
              $sandRequirement = 35;
               $aggregatesRequirement = 0;
              $blocksRequirement = 0;
              $electricalRequirement = 0;






              // calculation Part
             
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);







            break;
          case 'Plastering':
             
              $plumbingRequirement = 0;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement = 10;
               $steelRequirement  = 0;
              $sandRequirement = 10;
               $aggregatesRequirement = 0;
              $blocksRequirement = 0;
              $electricalRequirement = 0;






              // calculation Part
             
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);








            break;
          case 'Flooring':
             
              $plumbingRequirement = 0;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement = 5;
               $steelRequirement  = 0;
              $sandRequirement = 0;
               $aggregatesRequirement = 0;
              $blocksRequirement = 0;
              $electricalRequirement = 0;








              // calculation Part
             $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100);
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);







            break;
          case 'Carpentry':
             
              $plumbingRequirement = 0;
              $doorsRequirement = 100;
              $flooringRequirement = 100;
               $cementRequirement = 0;
               $steelRequirement  = 0;
              $sandRequirement = 0;
               $aggregatesRequirement = 0;
              $blocksRequirement = 0;
              $electricalRequirement = 0;








              // calculation Part
           
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);
              








            // dd($plumbing[$i] );

            break;
          case 'Painting':
              
              $plumbingRequirement = 0;
              $doorsRequirement = 0;
              $flooringRequirement = 100;
               $cementRequirement = 0;
               $steelRequirement  = 0;
              $sandRequirement = 0;
               $aggregatesRequirement = 0;
              $blocksRequirement = 0;

              $electricalRequirement = 0;







              // calculation Part
              
               $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);





 



            break;
          case 'Fixtures':
              
              $plumbingRequirement = 0;
              $doorsRequirement = 0;
              $flooringRequirement = 0;
               $cementRequirement = 0;
               $steelRequirement  = 0;
              $sandRequirement = 0;
               $aggregatesRequirement = 0;
              $blocksRequirement = 0;
              $electricalRequirement = 0;








              // calculation Part
           
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100); 
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);







            break;
          case 'Completion':
            
              $plumbingRequirement = 0;
              $doorsRequirement = 0;
              $flooringRequirement = 0;
              $cementRequirement = 0;
               $steelRequirement  = 0;
              $sandRequirement = 0;
               $aggregatesRequirement = 0;
              $blocksRequirement = 0;

              $electricalRequirement = 0;

              
             


              // calculation Part
             
              $plumbing[$i] = ((50*$Total_Area)/50) * ($plumbingRequirement/100);
              $doors[$i] = ((350 *$Total_Area )/350) *($doorsRequirement/100);
              $flooring [$i] = ((0.8 *$Total_Area)/0.8) *($flooringRequirement/100);
              $cement[$i] = ((15 * $Total_Area)/50) * ($cementRequirement/100);
               $steel[$i] = ((4 * $Total_Area)/1000) *($steelRequirement/100);
                $sand[$i] = ((1.2 * $Total_Area)/23.35) * ($sandRequirement/100);
                $aggregates[$i] = ((1.35 * $Total_Area)/23.35) *($aggregatesRequirement/100);
                $blocks[$i] = ((4.167 * $Total_Area)/4.16) * ($blocksRequirement/100);
                $electrical[$i] = ((84 * $Total_Area)/84)*($electricalRequirement/100);









            break;
          default:
            # code...
            break;
        }
        if(count(1) > $i){
         
          $totalPlumbing += $plumbing[$i];
          $totaldoors += $doors[$i];
           $totalsteel += $steel[$i];
          $totalflooring +=  $flooring[$i];
         $totalcement += $cement[$i];
         $totalsand += $sand[$i];
         $totalaggregates += $aggregates[$i]; 
         $totalblocks += $blocks[$i]; 
         $totalelectrical += $electrical[$i];      
       }
        $i++;
      }


               $table .="<tr><td>Cement</td>
                <td>".round($totalcement)." (Bags)</td>
                <td>".(round ($cement1 = ($totalcement) * 270))."</td></tr>";

                 $table .="<tr><td>Steel</td>
                <td>".round($totalsteel)." (Ton)</td>
                <td>".(round($steel1 = ($totalsteel) * 50000))."</td></tr>";

                 $table .="<tr><td>Sand</td>
                <td>".round($totalsand)." (Ton)</td>
                <td>".(round($sand1 = ($totalsand) * 950))."</td></tr>";

                $table .="<tr><td>Aggregates</td>
                <td>".round($totalaggregates)." (Ton)</td>
                <td>".(round($agr=($totalaggregates) * 750))."</td></tr>";

                  $table .="<tr><td>Electrical</td>
                <td>".round($totalelectrical)." (Sqft)</td>
                <td>".(round($ele=($totalelectrical) * 84))."</td></tr>";


                $table .="<tr><td>Blocks and Bricks</td>
                <td>".round($totalblocks)." (No.)</td>
                <td>".(round($bl=($totalblocks) * 28))."</td></tr>";

        
               $table .="<tr><td>Plumbing</td>
                <td>".round($totalPlumbing)." (Sqft)</td>
                <td>".(round($pl =($totalPlumbing) * 50))."</td></tr>";

                $table .="<tr><td>Doors and windows</td>
                <td>".round($totaldoors)." (Sqft)</td>
                <td>".(round($door=($totaldoors) * 350))."</td></tr>";

                $table .="<tr><td>Flooring</td>
                <td>".round($totalflooring)." (Sqft)</td>
                <td>".(round($floor=($totalflooring) * 45))."</td></tr>";

     $total = round($cement1+$steel1+$floor+$door+$pl+$bl+$ele+$agr+$sand1);


      return view('detailProjects',['projects'=>$projects,'table'=>$table,'total'=>$total]);
   
    }
}
