<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\orderconfirmation;
use App\Mail\invoice;
use App\Department;
use App\User;
use App\Group;
use App\Ward;
use App\Country;
use App\SubWard;
use App\WardAssignment;
use App\ProjectDetails;
use App\SiteAddress;
use App\Territory;
use App\State;
use App\Zone;
use App\loginTime;
use App\Requirement;
use App\ProcurementDetails;
use App\SiteEngineerDetails;
use App\OwnerDetails;
use App\ConsultantDetails;
use App\attendance;
use App\ContractorDetails;
use App\salesassignment;
use App\Report;
use Auth;
use DB;
use App\EmployeeDetails;
use App\BankDetails;
use App\Asset;
use App\AssetInfo;
use App\Category;
use App\SubCategory;
use App\CategoryPrice;
use App\ManufacturerDetail;
use App\Certificate;
use App\MhInvoice;
use App\brand;

class marketingController extends Controller
{
    public function getHome(){
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $brands = brand::leftjoin('category','brands.category_id','=','category.id')->select('brands.*','category.category_name')->get();
        return view('marketing.marketinghome',['categories'=>$categories,'subcategories'=>$subcategories,'brands'=>$brands]);
    }
    public function addCategory(Request $request){
        $category = new Category;
        $category->category_name = $request->category;
        $category->measurement_unit = $request->measurement;
        $category->save();
        return back()->with('Success','Category added successfully');
    }
    public function addSubCategory(Request $request){
        $subcat = new SubCategory;
        $subcat->category_id = $request->category;
        $subcat->brand_id = $request->brand;
        $subcat->sub_cat_name = $request->subcategory;
        $subcat->save();
        $cprice = new CategoryPrice;
        $cprice->category_id = $request->category;
        $cprice->category_sub_id = $subcat->id;
        $cprice->price = 0;
        $cprice->save();
        return back()->with('Success','Sub Category added successfully');
    }
    public function deleteCategory(Request $request){
        Category::find($request->id)->delete();
        SubCategory::where('category_id',$request->id)->delete();
        return back()->with('Success','Category with its sub-categories has been deleted');
    }
    public function deletebrand(Request $request){
        brand::find($request->id)->delete();
        return back()->with('Success','brand has been deleted');
    }
    public function deleteSubCategory(Request $request){
        SubCategory::find($request->id)->delete();
        return back()->with('Success','Sub-Category has been deleted');
    }
    public function updateCategory(Request $request){
        Category::where('id',$request->id)
            ->update(['category_name'=>$request->name]);
        return back()->with('Success','Category has been updated');
    }
    public function updateBrand(Request $request){
        brand::where('id',$request->id)
            ->update(['brand'=>$request->name]);
        return back()->with('Success','Brand has been updated');
    }
    public function updateSubCategory(Request $request){
        SubCategory::where('id',$request->id)
        ->update(['sub_cat_name'=>$request->name]);
        return back()->with('Success','Sub-Category has been updated');
    }
    public function addBrand(Request $request)
    {
        $brand = new brand;
        $brand->category_id = $request->cat;
        $brand->brand = $request->brand;
        $brand->save();
        return back()->with('Success','Brand added');
    }
}