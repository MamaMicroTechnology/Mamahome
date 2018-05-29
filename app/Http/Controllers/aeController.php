<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use DB;
use App\BuilderInfo;
use App\BuilderProjects;
use App\Ward;
use App\SubWard;
use App\Order;

class aeController extends Controller
{
    public function getAccountExecutive(){
        $builders = BuilderInfo::all();
        $projects = BuilderProjects::all();
       return view('accountExecutive.accountExecutive',['builders'=>$builders,'projects'=>$projects]);
    }
    public function postBuilderDetails(Request $request){
        $builderInfo = new BuilderInfo;
        $builderInfo->builder_name = $request->builderName;
        $builderInfo->builder_address = $request->Address;
        $builderInfo->builder_email = $request->Email;
        $builderInfo->builder_contact_no = $request->Contact;
        $builderInfo->website = $request->web;
        $builderInfo->ceo_gm_name = $request->ceo;
        $builderInfo->ceo_contact = $request->ceocontact;
        $builderInfo->ceo_email = $request->ceoEmail;
        $builderInfo->purchase_manager = $request->purchase;
        $builderInfo->pm_contact = $request->pmContact;
        $builderInfo->pm_email = $request->pmEmail;
        $builderInfo->purchase_executive = $request->purchaseEx;
        $builderInfo->purchase_contact = $request->peContact;
        $builderInfo->purchase_email = $request->peEmail;
        $builderInfo->save();
        return back()->with('Success','Builder Details added successfully');
    }
    public function viewBuilderProjects(Request $request){
        $user = BuilderInfo::where('builder_id',$request->builderId)->first();
        $projects = BuilderProjects::where('builder_id',$request->builderId)->get();
        return view('accountExecutive.aeProjects',['user'=>$user,'projects'=>$projects]);
    }
    public function addBuilderProjects(){
        $builders = BuilderInfo::all();
        $wards = Ward::orderBy('ward_name','ASC')->get();
        return view('accountExecutive.addProject',['builders'=>$builders,'wards'=>$wards]);
    }
    public function getSubWards(Request $request){
        $ward = $request->ward; 
        $sub = SubWard::where('ward_id',$ward)->get();
        $subward = array();
        $subward[0] = $sub;
        return response()->json($subward);
    }
    public function addBuilderProject(Request $request){
        $builderProjects = new BuilderProjects;
        $builderProjects->builder_id = $request->builderId;
        $builderProjects->project_name = $request->projectName;
        $builderProjects->project_manager = $request->projectManager;
        $builderProjects->pm_contact = $request->pmContact;
        $builderProjects->pm_email = $request->pmEmail;
        $builderProjects->site_engineer = $request->pmEmail;
        $builderProjects->se_contact = $request->seContact;
        $builderProjects->se_email = $request->seMail;
        $builderProjects->project_location = $request->location;
        $builderProjects->sub_ward = $request->subward;
        $builderProjects->project_approx_value = $request->value;
        $builderProjects->total_size = $request->size;
        $builderProjects->no_of_floors = $request->floors;
        $builderProjects->project_status = $request->status;
        $builderProjects->posession_date = $request->pDate;
        $builderProjects->project_website = $request->web;
        if($request->rfImage != NULL){ 
            $imageName = time().'.'.request()->rfImage->getClientOriginalExtension();
            $request->rfImage->move(public_path('projectImages'),$imageName);
            $builderProjects->referal_image = $imageName;
        }
        $builderProjects->remarks = $request->remarks;
        $builderProjects->save();
        return back()->with('Success','Project added successfully');
    }
    public function getDeliveredOrders()
    {
        $deliveredOrders = Order::where('orders.delivery_status',"Delivered")
                            ->leftjoin('site_addresses','site_addresses.project_id','orders.project_id')
                            ->leftjoin('project_details','project_details.project_id','orders.project_id')
                            ->select('orders.*','site_addresses.address','orders.id as orderId','project_details.project_name')
                            ->get();
        return view('accountExecutive.deliveredOrders',['deliveredOrders'=>$deliveredOrders]);
    }
}