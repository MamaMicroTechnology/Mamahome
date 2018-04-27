<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use DB;
use App\Ward;
use App\Country;
use App\SubWard;
use App\Zone;
use App\CategoryPrice;
use App\Category;
use App\Requirement;
use App\ProjectDetails;
use App\Department;
use App\loginTime;
use App\User;
use App\Group;
use App\EmployeeDetails;
use App\BankDetails;
use App\Asset;
use App\AssetInfo;
use App\Certificate;
use App\Report;
use App\attendance;
use App\ManufacturerDetail;
use App\KeyResult;
use App\MhInvoice;
use App\Order;
use App\DeliveryDetails;

class logisticsController extends Controller
{
    public function dashboard()
    {
        return view('logistics.lcodashboard');
    }
    
    public function report(Request $request)
    {
        if(!$request->date){
            date_default_timezone_set("Asia/Kolkata");
            $today = date('Y-m-d');
            $projectCount = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)
                            ->where('created_at','like',$today.'%')
                            ->get());
            
            $loginTimes = loginTime::where('user_id',Auth::user()->id)
                            ->where('logindate',$today)->first();
            return view('logistics.myreport',['loginTimes'=>$loginTimes,'projectCount'=>$projectCount]);
        }
        else
        {
            $projectCount = count(ProjectDetails::where('listing_engineer_id',Auth::user()->id)
                            ->where('created_at','like',$request->date.'%')
                            ->get());
            
            $loginTimes = loginTime::where('user_id',Auth::user()->id)
                            ->where('logindate',$request->date)
                            ->first();

            return view('logistics.myreport',['loginTimes'=>$loginTimes,'projectCount'=>$projectCount]);
        }
    }
    
    public function orders()
    {
        $view = Order::orderBy('project_id','DESC')
                ->leftJoin('users','orders.generated_by','=','users.id')
                ->select('orders.*','orders.id as orderid','users.name','users.group_id')
                ->where('status','Order Confirmed')
                ->paginate(25);
        $countview = Order::where('status',"Order Confirmed")->count();
        return view('logistics.orders',['view' => $view,'count' => $countview]);
    }
    
    public function showProjectDetails($id)
    {
        $rec = ProjectDetails::where('project_id',$id)->first();
        return view('logistics.projectdetails',['rec' => $rec]);
    }
    public function confirmDelivery(Request $request){
        $requirement = Requirement::where('id',$request->id)->first();
        $project = ProjectDetails::where('project_id',$request->projectId)->first();
        $subward = SubWard::where('id',$project->sub_ward_id)->pluck('sub_ward_name')->first();
        return view('logistics.confirmDelivery',['pageName'=>'Orders','requirement'=>$requirement,'project'=>$project,'subward'=>$subward]);
    }
    public function postconfirmDelivery(Request $request){
        $invoiceCount = count(MhInvoice::all()) + 1;
        $no = sprintf("%04d", $invoiceCount);
        $project = ProjectDetails::where('project_id',$request->projectId)->first();
        $subward = SubWard::where('id',$project->sub_ward_id)->first();
        $ward = Ward::where('id',$subward->ward_id)->first();
        $country = Country::where('id',$ward->country_id)->first();
        $zone = Zone::where('id',$ward->zone_id)->first();
        $invoiceNo = "MH_".$country->country_code."_".$zone->zone_number."_".date('Y')."_".$country->country_code.$no;
        $invoice = new MhInvoice;
        $invoice->project_id = $request->projectId;
        $invoice->requirement_id = $request->requiremntId;
        $invoice->customer_name = $request->customerName;
        $invoice->deliver_location = $request->location;
        $invoice->sub_ward = $request->subward;
        $invoice->invoice_number = $invoiceNo;
        $invoice->amount_received = $request->amount;
        $invoice->receive_date = $request->rDate;
        $invoice->payment_method = $request->paymentMethod;
        $invoice->transactional_details = $request->transactionNo;
        $invoice->save();
        Requirement::where('id',$request->requiremntId)->update(['delivery_status'=>"Delivered"]);
        return redirect('orders');
    }
    public function deliveredorders()
    {
        $rec = Order::where('delivery_status','Yes')->orWhere('delivery_status','Delivered')->get();
        $countrec = count($rec);
        return view('logistics.deliveredorders',['rec'=>$rec,'countrec'=>$countrec]);
    }
    public function takesignature()
    {
        return view('logistics.takesignature');
    }
    public function saveSignature(Request $request)
    {
        $signatureName = time().'.'.request()->signature->getClientOriginalExtension();
        $request->signature->move(public_path('signatures'),$signatureName);
        $signature = Order::where('id',$request->orderId)->first();
        $signature->signature = $signatureName;
        $signature->payment_status = "Payment Received";
        $signature->save();
        return back()->with('Success','Payment Received');
    }
    public function saveDeliveryDetails(Request $request)
    {
        if(!$request->vid){
            $vehicleNo = "vehicle".time().'.'.request()->vno->getClientOriginalExtension();
            $request->vno->move(public_path('delivery_details'),$vehicleNo);

            $locationPicture = "loction".time().'.'.request()->lp->getClientOriginalExtension();
            $request->lp->move(public_path('delivery_details'),$locationPicture);

            $quality = "quality".time().'.'.request()->qm->getClientOriginalExtension();
            $request->qm->move(public_path('delivery_details'),$quality);

            $deliveryDetails = new DeliveryDetails;
            $deliveryDetails->order_id = $request->orderId;
            $deliveryDetails->vehicle_no = $vehicleNo;
            $deliveryDetails->location_picture = $locationPicture;
            $deliveryDetails->quality_of_material = $quality;
            $deliveryDetails->delivery_date = date('Y-m-d h:i:s A');
            $deliveryDetails->save();
        }else{
            $video = "video".time().'.'.request()->vid->getClientOriginalExtension();
            $request->vid->move(public_path('delivery_details'),$video);
            $deliveryDetails = new DeliverDedtails;
            $deliveryDetails->order_id = $request->orderId;
            $deliveryDetails->delivery_video = $video;
            $deliveryDetails->delivery_date = date('Y-m-d h:i:s A');
            $deliveryDetails->save();
        }
    }
}