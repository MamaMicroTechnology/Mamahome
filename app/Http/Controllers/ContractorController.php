<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContractorDetails;
use App\ProjectDetails;
use App\RoomType;
use DB;

class ContractorController extends Controller
{
    public function getContractorDetails()
    {
    	return view('contractor');
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
   	public function getNoOfProjects()
   	{
   		$contractors = ContractorDetails::groupby('contractor_contact_no')->pluck('contractor_contact_no');
   		$conName = ContractorDetails::wherein('contractor_contact_no',$contractors)->paginate(10);
      $projects = array();
   		foreach($conName as $contractor){
        $projectIds = ContractorDetails::where('contractor_contact_no',$contractor->contractor_contact_no)->pluck('project_id');
   			$projects[$contractor->contractor_contact_no] = ProjectDetails::whereIn('project_id',$projectIds)->count();
   		}
   		return view('contractorProjects',['projects'=>$projects,'conName'=>$conName]);
   	}
    public function viewProjects(Request $request)
    {
      $fan = 0;
      $led = 0;
      $metalbox8 = 0;
      $cover = 0;
      $socket15a = 0;
      $switches15a = 0;
      $twoway = 0;
      $switches5a = 0;
      $sockets5a = 0;
      $plasticexhaust = 0;
      $metalexhaust = 0;
      $ledbulb = 0;
      $wiring142 = 0;
      $wiring122 = 0;
      $wiring143 = 0;
      $mcb = 0;
      $tpn = 0;
      $dbdoor = 0;
      $table = "<tr><td colspan='8'><center>ESTIMATE</center></td></tr>
      <tr><th>Category</th><th>Products</th><th>UOM</th><th>Nos.</th>
        <th>Total Material</th><th>MRP</th><th>TOTAL</th><th>MHP</th></tr>";
      $projectIds = ContractorDetails::where('contractor_contact_no',$request->no)->pluck('project_id');
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
        $fan += $hall+$bedroom+$flatsfloors;
        $led += $kitchen+$hall+$bedroom+$bathroom * $floors;
        $metalbox8 += $kitchen+$hall+$bedroom+$bathroom+2 * $floors;
        $cover += $kitchen+$hall+$bedroom+$bathroom+2 * $floors;
        $socket15a += $kitchen+$hall+$bedroom+$bathroom+2 * $floors;
        $switches15a += $kitchen+$hall+$bedroom+$bathroom+2 * $floors;
        $twoway += 4*$floors;
        $switches5a += 30*$floors;
        $sockets5a += 20*$floors;
        $plasticexhaust += $bathroom;
        $metalexhaust += $kitchen;
        $ledbulb += 10*$floors;
        $wiring142 += $size/290;
        $wiring122 += $size/590;
        $wiring143 += $size/590;
        $mcb += 4*$flatsfloors*$floors;
        $tpn += 1;
        $dbdoor += 1;
      }
      $cementOPC = array();
      $cementPPC = array();
      $mSandConcreteCft = array();
      $mSandConcreteTons = array();
      $mSandPlasteringCft = array();
      $mSandPlasteringTons = array();
      $jelly12mmCft = array();
      $jelly12mmTons = array();
      $jelly20mmCft = array();
      $jelly20mmTons = array();
      $blocks6 = array();
      $blocks4 = array();
      $steel8 = array();
      $steel10 = array();
      $steel12 = array();
      $steel18 = array();
      $steelTot = array();
      $totalcementOPC=0;
      $totalcementPPC=0;
      $totalmSandConcreteCft=0;
      $totalmSandConcreteTons=0;
      $totalmSandPlasteringCft=0;
      $totalmSandPlasteringTons=0;
      $totaljelly12mmCft=0;
      $totaljelly12mmTons=0;
      $totaljelly20mmCft=0;
      $totaljelly20mmTons=0;
      $totalblocks6=0;
      $totalblocks4=0;
      $totalSteel=0;
      $totalsteel8=0;
      $totalsteel10=0;
      $totalsteel12=0;
      $totalsteel18=0;
      $i = 0;
      foreach($projects as $project){
        $Total_Flats = $project->project_type;
        $Total_Area = $project->project_type * $project->project_size;
        $stage = $project->project_status;
        switch ($stage) {
          case 'Planning':
              $cement_requirement = 100;
              $steel_requirement = 100;
              $m_sand_requirement = 100;
              $jelly_requirement = 100;
              $blocks_requirement = 100;
              $electrical_requirement = 100;
              $plumbing_requirement = 100;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Digging':
              $cement_requirement = 100;
              $steel_requirement = 100;
              $m_sand_requirement = 100;
              $jelly_requirement = 100;
              $blocks_requirement = 100;
              $electrical_requirement = 100;
              $plumbing_requirement = 100;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Foundation':
              $cement_requirement = 100;
              $steel_requirement = 100;
              $m_sand_requirement = 90;
              $jelly_requirement = 40;
              $blocks_requirement = 100;
              $electrical_requirement = 100;
              $plumbing_requirement = 100;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Pillar':
              $cement_requirement = 80;
              $steel_requirement = 60;
              $m_sand_requirement = 80;
              $jelly_requirement = 40;
              $blocks_requirement = 100;
              $electrical_requirement = 100;
              $plumbing_requirement = 100;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Walling':
              $cement_requirement = 60;
              $steel_requirement = 60;
              $m_sand_requirement = 70;
              $jelly_requirement = 40;
              $blocks_requirement = 50;
              $electrical_requirement = 100;
              $plumbing_requirement = 100;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Roofing':
              $cement_requirement = 40;
              $steel_requirement = 0;
              $m_sand_requirement = 40;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 100;
              $plumbing_requirement = 100;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Electrical':
              $cement_requirement = 40;
              $steel_requirement = 0;
              $m_sand_requirement = 40;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 100;
              $plumbing_requirement = 100;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Plumbing':
              $cement_requirement = 40;
              $steel_requirement = 0;
              $m_sand_requirement = 40;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 0;
              $plumbing_requirement = 100;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Plastering':
              $cement_requirement = 40;
              $steel_requirement = 0;
              $m_sand_requirement = 0;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 0;
              $plumbing_requirement = 0;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Flooring':
              $cement_requirement = 5;
              $steel_requirement = 0;
              $m_sand_requirement = 0;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 0;
              $plumbing_requirement = 0;
              $flooring_requirement = 100;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Carpentry':
              $cement_requirement = 0;
              $steel_requirement = 0;
              $m_sand_requirement = 0;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 0;
              $plumbing_requirement = 0;
              $flooring_requirement = 0;
              $doors_requirement = 100;
              $windows_requirement = 100;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 100;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Painting':
              $cement_requirement = 0;
              $steel_requirement = 0;
              $m_sand_requirement = 0;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 0;
              $plumbing_requirement = 0;
              $flooring_requirement = 0;
              $doors_requirement = 0;
              $windows_requirement = 0;
              $sanitary_requirement = 100;
              $paint_requirement = 100;
              $wardrobe_requirement = 0;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Fixtures':
              $cement_requirement = 0;
              $steel_requirement = 0;
              $m_sand_requirement = 0;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 0;
              $plumbing_requirement = 0;
              $flooring_requirement = 0;
              $doors_requirement = 0;
              $windows_requirement = 0;
              $sanitary_requirement = 100;
              $paint_requirement = 0;
              $wardrobe_requirement = 0;
              $kitchenCabinet_requirement = 100;
              $buildingManagement_requirement = 100;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          case 'Completion':
              $cement_requirement = 0;
              $steel_requirement = 0;
              $m_sand_requirement = 0;
              $jelly_requirement = 0;
              $blocks_requirement = 0;
              $electrical_requirement = 0;
              $plumbing_requirement = 0;
              $flooring_requirement = 0;
              $doors_requirement = 0;
              $windows_requirement = 0;
              $sanitary_requirement = 0;
              $paint_requirement = 0;
              $wardrobe_requirement = 0;
              $kitchenCabinet_requirement = 0;
              $buildingManagement_requirement = 0;
              // calculation Part
              $cementOPC[$i] = (0.3*$Total_Area)*($cement_requirement/100);
              $cementPPC[$i] = (0.01677*$Total_Area)*($cement_requirement/100);
              $mSandConcreteCft[$i] = 1.2*$Total_Area;
              $mSandConcreteTons[$i] = 0.0426*$mSandConcreteCft[$i];
              $mSandPlasteringTons[$i] = 0.0125*$Total_Area;
              $mSandPlasteringCft[$i] = 23.46*$mSandPlasteringTons[$i];
              $jelly12mmCft[$i] = 0.7*$Total_Area;
              $jelly12mmTons[$i] = 0.0426*$jelly12mmCft[$i];
              $jelly20mmCft[$i] = 0.3*$Total_Area[$i];
              $jelly20mmTons[$i] = 0.0426*$jelly20mmCft[$i];
              $blocks6[$i] = 1.25*$Total_Area;
              $blocks4[$i] = 0.8333*$Total_Area;
              $steel8[$i] = (1.5*$Total_Area)/1000;
              $steel10[$i] = (1.25*$Total_Area)/1000;
              $steel12[$i] = (0.75*$Total_Area)/1000;
              $steel18[$i] = (0.5*$Total_Area)/1000;
              $steelTot[$i] = $steel8[$i] + $steel10[$i] + $steel12[$i] + $steel18[$i];
            break;
          default:
            # code...
            break;
        }
        $totalcementOPC+=$cementOPC[$i];
        $totalcementPPC+=$cementPPC[$i];
        $totalmSandConcreteCft+=$mSandConcreteCft[$i];
        $totalmSandConcreteTons+=$mSandConcreteTons[$i];
        $totalmSandPlasteringCft+=$mSandPlasteringCft[$i];
        $totalmSandPlasteringTons+=$mSandPlasteringTons[$i];
        $totaljelly12mmCft+=$jelly12mmCft[$i];
        $totaljelly12mmTons+=$jelly12mmTons[$i];
        $totaljelly20mmCft+=$jelly20mmCft[$i];
        $totaljelly20mmTons+=$jelly20mmTons[$i];
        $totalblocks6+=$blocks6[$i];
        $totalblocks4+=$blocks4[$i];
        $totalSteel+=$steelTot[$i];
        $totalsteel8 += $steel8[$i];
        $totalsteel10 += $steel10[$i];
        $totalsteel12 += $steel12[$i];
        $totalsteel18 += $steel18[$i];
        $i++;
      }
        $table .="<tr><td>Cement</td><td>OPC</td><td>Bags</td>
                <td>".round($totalcementOPC)."</td><td rowspan='2'>".round($totalcementPPC+$totalcementOPC)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>OPC</td><td>Bags</td>
                <td>".round($totalcementPPC)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td>M-Sand</td><td>Concrete</td><td>Tons</td>
                <td>".round($totalmSandConcreteTons)."</td><td rowspan='2'>".round($totalmSandPlasteringTons+$totalmSandConcreteTons)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>Plastering</td><td>Tons</td>
                <td>".round($totalmSandPlasteringTons)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td>Jelly</td><td>12mm</td><td>Tons</td>
                <td>".round($totaljelly12mmTons)."</td><td rowspan='2'>".round($totaljelly12mmTons+$totaljelly20mmTons)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>20mm</td><td>Tons</td>
                <td>".round($totaljelly20mmTons)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td>Steel</td><td>8mm</td><td>Tons</td>
                <td>".round($totalsteel8)."</td><td rowspan='5'>".round($totalSteel)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>10mm</td><td>Tons</td>
                <td>".round($totalsteel10)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>12mm</td><td>Tons</td>
                <td>".round($totalsteel12)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>16mm</td><td>Tons</td>
                <td>".round($totalsteel18)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>20mm</td><td>Tons</td>
                <td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td>Blocks</td><td>6\"</td><td>Nos</td>
                <td>".round($totalblocks6)."</td><td rowspan='2'>".round($totalblocks6+$totalblocks4)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>4\"</td><td>Nos</td>
                <td>".round($totalblocks4)."</td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td>Electrical</td><td>Fan</td><td>Nos</td>
                <td>".$fan."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>LED Tube Light</td><td>Nos</td>
                <td>".$led."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>8M Metal Box</td><td>Nos</td>
                <td>".$metalbox8."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>8M Cover Frame</td><td>Nos</td>
                <td>".$cover."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>15 A Sockets</td><td>Nos</td>
                <td>".$socket15a."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>15 A Switches</td><td>Nos</td>
                <td>".$switches15a."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>Two way switches</td><td>Nos</td>
                <td>".$twoway."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>5 A Switches</td><td>Nos</td>
                <td>".$switches5a."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>5 A Sockets </td><td>Nos</td>
                <td>".$sockets5a."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>Plastic Exhaust Fan</td><td>Nos</td>
                <td>".$plasticexhaust."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>Metal Exhaust Fan</td><td>Nos</td>
                <td>".$metalexhaust."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>LED Bulb</td><td>Nos</td>
                <td>".$ledbulb."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>Wiring 14/2 90MTS</td><td>Nos</td>
                <td>".$wiring142."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>Wiring 12/2 90MTS</td><td>Nos</td>
                <td>".$wiring122."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>Wiring 14/3 90MTS</td><td>Nos</td>
                <td>".$wiring143."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>MCB 25A</td><td>Nos</td>
                <td>".$mcb."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>TPN Distribution Board</td><td>Nos</td>
                <td>".$tpn."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
        $table .="<tr><td></td><td>DB Door</td><td>Nos</td>
                <td>".$dbdoor."</td><td></td>
                <td>380</td><td>0</td><td>0</td></tr>";
      return view('detailProjects',['projects'=>$projects,'table'=>$table]);
    }
}