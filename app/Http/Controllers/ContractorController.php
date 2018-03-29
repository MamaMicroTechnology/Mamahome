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
	   						<td><a target='_blank' href='/ameditProject?projectId=".$project->project_id."' class='btn btn-primary btn-sm'>Edit</a></td></tr>";
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
      $projectIds = ContractorDetails::where('contractor_contact_no',$request->no)->pluck('project_id');
      $projects = ProjectDetails::whereIn('project_id',$projectIds)->get();
      $roomTypes = RoomType::where('project_id',$projectIds);
      $summary = "<table class='table table-hover'><tr><th>Room Type</th><th>No.</th></tr>";
      foreach($roomTypes as $type){
        $summary .= "<tr><td>".$type->room_type."</td><td>".$type->no_of_rooms."</td></tr>";
      }
      $summary .= "</table>";
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
      $steel20 = array();
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
      $estimation = "<tr>".
                        "<th>Cement OPC</th>".
                        "<th>Cement PPC</th>".
                        "<th>M-Sand Concrete (cft)</th>".
                        "<th>M-Sand Concrete (tons)</th>".
                        "<th>M-Sand Plastering (cft)</th>".
                        "<th>M-Sand Plastering (tons)</th>".
                        "<th>Jelly 12mm (cft)</th>".
                        "<th>Jelly 12mm (tons)</th>".
                        "<th>Jelly 20mm (cft)</th>".
                        "<th>Jelly 20mm (tons)</th>".
                        "<th>Block 6</th>".
                        "<th>Block 4</th>".
                        "</tr>";
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
              // $steel8[$i] = 
              // $steel10[$i] = 
              // $steel12[$i] = 
              // $steel18[$i] = 
              // $steel20[$i] = 
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
            break;
          default:
            # code...
            break;
        }
        $estimation .= "<tr>".
                          "<td>".round($cementOPC[$i])."</td>".
                          "<td>".round($cementPPC[$i])."</td>".
                          "<td>".round($mSandConcreteCft[$i])."</td>".
                          "<td>".round($mSandConcreteTons[$i])."</td>".
                          "<td>".round($mSandPlasteringCft[$i])."</td>".
                          "<td>".round($mSandPlasteringTons[$i])."</td>".
                          "<td>".round($jelly12mmCft[$i])."</td>".
                          "<td>".round($jelly12mmTons[$i])."</td>".
                          "<td>".round($jelly20mmCft[$i])."</td>".
                          "<td>".round($jelly20mmTons[$i])."</td>".
                          "<td>".round($blocks6[$i])."</td>".
                          "<td>".round($blocks4[$i])."</td>".
                        "</tr>";
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
        $i++;
      }
      $estimation .= "<tr><th colspan='12'><center>TOTAL</center></th></tr>";
      $estimation .= "<tr>".
                "<th>".round($totalcementOPC)."</th>".
                "<th>".round($totalcementPPC)."</th>".
                "<th>".round($totalmSandConcreteCft)."</th>".
                "<th>".round($totalmSandConcreteTons)."</th>".
                "<th>".round($totalmSandPlasteringCft)."</th>".
                "<th>".round($totalmSandPlasteringTons)."</th>".
                "<th>".round($totaljelly12mmCft)."</th>".
                "<th>".round($totaljelly12mmTons)."</th>".
                "<th>".round($totaljelly20mmCft)."</th>".
                "<th>".round($totaljelly20mmTons)."</th>".
                "<th>".round($totalblocks6)."</th>".
                "<th>".round($totalblocks4)."</th>".
                "</tr>";
      return view('detailProjects',['projects'=>$projects,'estimation'=>$estimation,'summary'=>$summary]);
    }
}