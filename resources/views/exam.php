 public function getUpdateProject(Request $request)
    {
        $project = ProjectDetails::where('project_id',$request->project_id)->first();
        $contractor = $project->contractorDetails;
        $procurement = $project->procurementDetails;
        $consultant = $project->consultantDetails;
        $siteEngineer = $project->siteEngineerDetails;
        $owner = $project->ownerDetails;
        
        return response()->json(['project'=>$project,'contractor'=>$contractor,'procurement'=>$procurement,'consultant',$consultant,'siteEngineer'=>$siteEngineer,'owner'=>$owner]);
    }
    public function postUpdateProject(Request $request)
    {

       
        $cType = count($request->constructionType);
        $type = $request->constructionType[0];
        $otherApprovals = "";
        $projectimage = "";
        if($cType != 1){
            $type .= ", ".$request->constructionType[1];
        }else{
             $type=null;
        }

        
        $statusCount = count($request->project_status);
        $statuses = $request->project_status[0];
        if($statusCount > 1){
            for($i = 1; $i < $statusCount; $i++){
                $statuses .= ", ".$request->project_status[$i];
            }
        }else{
            $statuses=null;
        }
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            $length = $request->length;
            $breadth = $request->breadth;
            $size = $length * $breadth;
            $projectdetails = ProjectDetails::where('project_id',$request->project_id)->update([
                'project_name' => $request->project_name,
                'road_width'=>$request->road_width,
                'construction_type'=>$request->construction_type,
                'interested_in_rmc'=>$request->interested_in_rmc,
                'interested_in_loan'=>$request->interested_in_loan,
                'interested_in_doorsandwindows'=>$request->interested_in_doorsandwindows,
                'road_name'=>$request->road_name,
                'project_status' => $statuses,
                'project_size' => $request->project_size,
                'budgetType' => $request->budgetType,
                'budget' => $request->budget,
//                 'user_id' => $request->userid,
                'basement' => $basement,
                'ground' => $ground,
                'project_type' => $floor,
                'length' => $length,
                'breadth' => $breadth,
                'plotsize' => $size,
                'user_id' => $request->userid,
                'remarks' => $request->remarks,
                'contract' => $request->contract
            ]);
            // $projectdetails->project_name = $request->project_name;
            // $projectdetails->road_width = $request->road_width;
            // $projectdetails->construction_type =$request->construction_type;
            // $projectdetails->interested_in_rmc = $request->interested_in_rmc;
            // $projectdetails->interested_in_loan = $request->interested_in_loan;
            // $projectdetails->interested_in_doorsandwindows = $request->interested_in_doorsandwindows;
            // $projectdetails->road_name = $request->road_name;
            $projectdetails = ProjectDetails::where('project_id',$request->project_id)->first();
            $projectdetails->project_name = $request->project_name;
            $projectdetails->road_width = $request->road_width;
            $projectdetails->construction_type =$request->construction_type;
            $projectdetails->interested_in_rmc = $request->interested_in_rmc;
            $projectdetails->interested_in_loan = $request->interested_in_loan;
            $projectdetails->interested_in_doorsandwindows = $request->interested_in_doorsandwindows;
            $projectdetails->road_name = $request->road_name;
            if($request->municipality_approval != NULL){
                $data = $request->all();
                $png_url = $request->userid."municipality_approval-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_url;
                $img = $data['municipality_approval'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['municipality_approval']);   
                $success = file_put_contents($path, $decoded);
                $projectdetails->municipality_approval = $png_url;
                $projectdetails->save();
            }
            if($request->other_approvals){
                $data = $request->all();
                $png_other = $request->userid."other_approvals-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_other;
                $img = $data['other_approvals'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['other_approvals']);   
                $success = file_put_contents($path, $decoded);
                $projectdetails->other_approvals = $png_other;
                $projectdetails->save();
            }
            if($request->image){
                $data = $request->all();
                $png_project =$request->userid."project_image-".time().".jpg";
                $path = public_path() . "/projectImages/" . $png_project;
                $img = $data['image'];
                $img = substr($img, strpos($img, ",")+1);
                $decoded = base64_decode($data['image']);   
                $success = file_put_contents($path, $decoded);
                $projectdetails->image = $png_project;
                $projectdetails->save();
            }
            
           
            $projectdetails->remarks = $request->remarks;
            $projectdetails->contract = $request->contract;
           
            $projectdetails->save();
            
            $basement = $request->basement;
            $ground = $request->ground;
            $floor = $basement + $ground + 1;
            $length = $request->length;
            $breadth = $request->breadth;
            $size = $length * $breadth;
            
            $room_types = $request->roomType[0]." (".$request->number[0].")";
            $count = count($request->roomType);
            for($i = 0;$i<$count;$i++){
                $roomtype = new RoomType;
                $roomtype->floor_no = $request->floorNo[$i];
                $roomtype->room_type = $request->roomType[$i];
                $roomtype->no_of_rooms = $request->number[$i];
                $roomtype->project_id = $projectdetails->peoject_id;
                $roomtype->save();
            }

            $siteaddress = SiteAddress::where('project_id',$request->project_id)->first();
            $siteaddress->project_id = $projectdetails->peoject_id;
            $siteaddress->latitude = $request->latitude;
            $siteaddress->longitude = $request->longitude;
            $siteaddress->save();
        if($projectdetails->save() ||  $siteaddress->save() ||  $roomtype->save() ){
            return response()->json(['message'=>'Add project sucuss']);
        }else{
            return response()->json(['message'=>'Something went wrong']);
        }
    }