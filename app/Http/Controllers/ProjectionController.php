<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BulkRequest;
use App\Manufacturer;
use App\Ward;
use App\SubWard;
use App\BulkProjection;

class ProjectionController extends Controller
{
    public function getBulkBusiness(Request $request)
    {
        $manufacturers = null;
        $wards = Ward::all();
        if($request->wards == "All"){
            $rmcManufacturerCount = Manufacturer::whereNotNull('sub_ward_id')->where('manufacturer_type',$request->type)->count();
            $manufacturers = Manufacturer::sum('cement_requirement');
        }elseif($request->wards != "All"){
            $subWards = SubWard::where('ward_id',$request->wards)->pluck('id');
            $rmcManufacturerCount = Manufacturer::whereIn('sub_ward_id',$subWards)->where('manufacturer_type',$request->type)->count();
        }else{
            $manufacturers = null;
        }
        return view('projection.bulkBusiness',['wards'=>$wards,'rmcManufacturerCount'=>$rmcManufacturerCount,'type'=>$request->type]);
    }
    public function saveProjection(BulkRequest $request)
    {
        $check = BulkProjection::where('type',$request->type)->where('sub_ward_id',$request->sub_ward_id)->first();
        if($check == null){
            $projection = New BulkProjection;
            $projection->type = $request->type;
            $projection->sub_ward_id = $request->sub_ward_id;
            $projection->number_of_manufacturers = $request->number_of_manufacturer;
            $projection->monthly_target = $request->monthly_target;
            $projection->transactional_profit = $request->transactional_profit;
            $projection->monthly_requirement = $request->monthly_requirement;
            $projection->monthly_amount = $request->monthly_amount;
            $projection->price = $request->price;
            $projection->dates = $request->dates;
            $projection->save();
            return back()->with('success','Target Saved Successfully');
        }else{
            return back()->with('error','Target Already Set For This Manufacturer Type');
        }
    }
    public function viewBulk()
    {
        $projections = BulkProjection::where('sub_ward_id',"All")->get();
        dd($projections);
    }
    public function fiveyearsWithZones()
    {
        return view('projection.fiveYearsWithZones');
    }
}
