<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
use App\Order;
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
use App\Message;
use App\training;

class marketingController extends Controller
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
    public function getHome(){
        $categories = Category::all();
        $subcategories = SubCategory::leftjoin('brands','category_sub.brand_id','=','brands.id')->select('brands.brand','category_sub.*')->get();
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
        $subcat->Quantity = $request->Quantity;
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
        ->update(['sub_cat_name'=>$request->name,   
                'Quantity'=>$request->Quantity

            ]);
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
     public function marketingDashboard()
    {
        return view('marketingdashboard');
    }
    public function ordersformarketing()
    {
        $rec = Order::select('id as orderid','orders.*')->where('status','!=','Order Cancelled')->get();
        $countrec = count($rec);   
        $invoice = MhInvoice::pluck('requirement_id')->toArray(); 
        return view('marketing.orders',['rec'=>$rec,'countrec'=>$countrec,'invoice' => $invoice]);
    }
    public function saveinvoice(Request $request){
        if($request->invoicePic != NULL){
            $imageName1 = "invoice".time().'.'.request()->invoicePic->getClientOriginalExtension();
            $request->invoicePic->move(public_path('invoiceImages'),$imageName1);
        }else{
            $imageName1 = null;
        }
        if($request->signature != NULL){
            $imageName2 = "signature".time().'.'.request()->signature->getClientOriginalExtension();
            $request->signature->move(public_path('invoiceImages'),$imageName2);
        }else{
            $imageName2 = null;
        }
        if($request->weighment != NULL){
            $imageName3 = "weighment".time().'.'.request()->weighment->getClientOriginalExtension();
            $request->weighment->move(public_path('invoiceImages'),$imageName3);
        }else{
            $imageName3 = null;
        }

        if($request->manufacturer_invoice != null){

                $i= 0;
            $invoiceimage = ""; 

            foreach($request->manufacturer_invoice as $invimage){
             $image = "manufacturer_invoice".$i.time().'.'.$invimage->getClientOriginalExtension();
            $invimage->move(public_path('invoiceImages'),$image);
           
             if($i == 0){
                                                 $invoiceimage .= $image;
                                                
                                           }
                                           else{
                                                $invoiceimage .= ",".$image;
                                               
                                           }
                                   $i++;
             }
                           
        }else{
            $invoiceimage = null;
        }

        


        if($request->quantity){

          $qnty = implode(", ", $request->quantity);
        }else{
            $qnty = "null";
        }

        if( $request->price){

            $price = implode(" , ", $request->price);
        }else{
           $price = "null"; 
        }


        $mhinvoice = new MhInvoice;
        $mhinvoice->project_id = $request->project_id;
        $mhinvoice->requirement_id = $request->invoice_no;
        $mhinvoice->invoice_id = $request->invoice_id;
        $mhinvoice->customer_name = $request->customer_name;
        $mhinvoice->deliver_location = $request->address;
        $mhinvoice->delivery_date = $request->delivery_date;
        $mhinvoice->item = $request->product;
        $mhinvoice->quantity = $qnty;
        $mhinvoice->price = $price;
        $mhinvoice->invoice_pic = $imageName1;
        $mhinvoice->signature = $imageName2;
        $mhinvoice->weighment_slip = $imageName3;
        $mhinvoice->amount_to_manufacturer = $request->amount_to_manufacturer;
        $mhinvoice->mama_invoice_amount = $request->mhinvoice;
        $mhinvoice->transactional_profit = $request->mhinvoice - $request->amount_to_manufacturer;
        $mhinvoice->manufacturer_number = $request->manufacturer_no;
        $mhinvoice->date_of_invoice = $request->dateOfInvoice;
        $mhinvoice->total_amount = $qnty * $price;
        $mhinvoice->manufacturer_invoice = $invoiceimage;
        $mhinvoice->save();
        return back();
    }
    public function viewInvoices( request $request )
    {
         $cat = Category::all();
        $invoice =count(MhInvoice::all());
         
        
        $inc = MhInvoice::where('item',$request->cat)
        ->orderBy('invoice_id','ASC')->get();
        $total = count($inc);
         
   
        return view('marketing.viewInvoices',['inc'=>$inc,'cat'=>$cat,'invoice'=>$invoice,'total'=>$total]);
    }
}
