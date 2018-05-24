<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
use App\RoomType;
use App\Message;
use App\training;
use App\Point;
use App\SiteAddress;
use App\OwnerDetails;

class logisticsController extends Controller
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
                ->leftJoin('users','orders.delivery_boy','=','users.id')
                ->leftJoin('delivery_details','delivery_details.order_id','orders.id')
                ->select('orders.*','orders.id as orderid','users.name','users.group_id','delivery_details.vehicle_no',
                'delivery_details.location_picture','delivery_details.quality_of_material','delivery_details.delivery_video')
                ->where('delivery_boy',Auth::user()->id)
                ->paginate(25);
        $countview = Order::where('delivery_boy',Auth::user()->id)->count();
        return view('logistics.orders',['view' => $view,'count' => $countview]);
    }
    
    public function showProjectDetails(Request $id)
    {
        $id = $id->id;
        $rec = ProjectDetails::where('project_id',$id)->first();
        $roomtypes = RoomType::where('project_id',$id)->get();
        return view('logistics.projectdetails',['rec' => $rec,'roomtypes'=>$roomtypes]);
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
        $rec = Order::where('delivery_boy',Auth::user()->id)->Where('delivery_status','Delivered')->get();
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
<<<<<<< HEAD
<<<<<<< HEAD
        $signature->payment_status = "Payment Received";
        $signature->save();
=======
=======
>>>>>>> e060e358804d4d9ef5425e8041bb61d0fbe4f9db
        $signature->total = $request->amount;
        $signature->payment_status = "Payment Received";
        $signature->save();
        $points = new Point;
        $points->user_id = Auth::user()->id;
        $points->point = 400;
        $points->type = "Add";
        $points->reason = "Receiving payment";
        $points->save();
<<<<<<< HEAD
>>>>>>> master
=======
>>>>>>> e060e358804d4d9ef5425e8041bb61d0fbe4f9db
        return back()->with('Success','Payment Received');
    }
    public function saveDeliveryDetails(Request $request)
    {
<<<<<<< HEAD
<<<<<<< HEAD
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
=======
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
        if($request->vid){
>>>>>>> e060e358804d4d9ef5425e8041bb61d0fbe4f9db
            $video = "video".time().'.'.request()->vid->getClientOriginalExtension();
            $request->vid->move(public_path('delivery_details'),$video);
            $deliveryDetails->delivery_video = $video;
        }
<<<<<<< HEAD
=======
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
        if($request->vid){
            $video = "video".time().'.'.request()->vid->getClientOriginalExtension();
            $request->vid->move(public_path('delivery_details'),$video);
            $deliveryDetails->delivery_video = $video;
        }
        $deliveryDetails->save();
        Order::where('id',$request->orderId)->update(['delivery_status'=>"Delivered"]);
=======
        $deliveryDetails->save();
        Order::where('id',$request->orderId)->update(['delivery_status'=>"Delivered",'delivered_on'=>date('Y-m-d')]);
>>>>>>> e060e358804d4d9ef5425e8041bb61d0fbe4f9db
        $reasonText = date('H:i:s') > "20:00:00" ? "Delivering material at night" : "Delivering material";
        $point = date('H:i:s') > "20:00:00" ? 500 : 250;
        $points = new Point;
        $points->user_id = Auth::user()->id;
        $points->point = $point;
        $points->type = "Add";
        $points->reason = $reasonText;
        $points->save();
        return back();
<<<<<<< HEAD
>>>>>>> master
=======
    }
    public function getinvoice()
    {
        $number = 48035;
        $length = strlen($number);
        if($number < 20){
            $length = 1;
        }
        $ones = array(
            0 => "", 
            1 => "one", 
            2 => "two", 
            3 => "three", 
            4 => "four", 
            5 => "five", 
            6 => "six", 
            7 => "seven", 
            8 => "eight", 
            9 => "nine", 
            10 => "ten", 
            11 => "eleven", 
            12 => "twelve", 
            13 => "thirteen", 
            14 => "fourteen", 
            15 => "fifteen", 
            16 => "sixteen", 
            17 => "seventeen", 
            18 => "eighteen", 
            19 => "nineteen" 
        ); 
        $tens = array(
            0 => "and",
            2 => "twenty", 
            3 => "thirty", 
            4 => "forty", 
            5 => "fifty", 
            6 => "sixty", 
            7 => "seventy", 
            8 => "eighty", 
            9 => "ninety" 
        ); 
        $hundreds = array( 
            "hundred", 
            "thousand", 
            "lakhs", 
            "crores", 
            "trillion", 
            "quadrillion" 
        );
        switch($length){
            case 1:
            // ones
                $text = $ones[$number];
                break;
            case 2:
            // tens
                $first = substr($number,0,1);
                $second = substr($number,-1);
                if($second != 0){
                    $text = $tens[$first]." ".$ones[$second];
                }else{
                    $text = $tens[$first];
                }
                break;
            case 3:
            // hundreds
                $first = substr($number,0,1);
                $text = $ones[$first]." ".$hundreds[0];
                $second = substr($number,-2);
                if($second != 0){
                    $number = $second;
                    $first = substr($number,0,1);
                    $second = substr($number,-1);
                    if($second != 0){
                        $text .= " ".$tens[$first]." ".$ones[$second];
                    }else{
                        $text .= " ".$tens[$first];
                    }
                }
            break;
            case 4:
            // thounsands
                $first = substr($number,0,1);
                $text = $ones[$first]." ".$hundreds[1];
                $second = substr($number,-3);
                if($second != 0){
                    $number = $second;
                    $first = substr($number,0,1);
                    if($first != 0){
                        $text .= " ".$ones[$first]." ".$hundreds[0];
                    }
                    $second = substr($number,-2);
                    if($second != 0){
                        $number = $second;
                        $first = substr($number,0,1);
                        $second = substr($number,-1);
                        if($second != 0){
                            $text .= " ".$tens[$first]." ".$ones[$second];
                        }else{
                            $text .= " ".$tens[$first];
                        }
                    }
                }
                break;
            case 5:
            // ten thousands
                $first = substr($number,0,2);
                if($first < 20){
                    $text = $ones[$first]." ".$hundreds[1];
                }else{
                    $another = substr($first,0,1);
                    $and = substr($first,-1);
                    $text = $tens[$another]." ".$ones[$and]." ".$hundreds[1];
                }
                $second = substr($number,-3);
                if($second != 0){
                    $number = $second;
                    $first = substr($number,0,1);
                    if($first != 0){
                        $text .= " ".$ones[$first]." ".$hundreds[0];
                    }
                    $second = substr($number,-2);
                    if($second != 0){
                        $number = $second;
                        $first = substr($number,0,1);
                        $second = substr($number,-1);
                        if($second != 0){
                            $text .= " ".$tens[$first]." ".$ones[$second];
                        }else{
                            $text .= " ".$tens[$first];
                        }
                    }
                }
                break;
            case 6:
            // lakhs
                $first = substr($number,0,1);
                if($first == 1){
                    $text = $ones[$first]." lakh";
                }else{
                    $text = $ones[$first]." ".$hundreds[2];
                }
                $first = substr($number,1,2);
                $check = substr($first,0,1);
                if($check == 0){
                    $first = substr($first,1,1);
                }
                if($first < 20){
                    $text .= " ".$ones[$first]." ".$hundreds[1];
                }else{
                    $another = substr($first,0,1);
                    $and = substr($first,-1);
                    $text .= " ".$tens[$another]." ".$ones[$and]." ".$hundreds[1];
                }
                $second = substr($number,-3);
                if($second != 0){
                    $number = $second;
                    $first = substr($number,0,1);
                    if($first != 0){
                        $text .= " ".$ones[$first]." ".$hundreds[0];
                    }
                    $second = substr($number,-2);
                    if($second != 0){
                        $number = $second;
                        $first = substr($number,0,1);
                        $second = substr($number,-1);
                        if($second != 0){
                            $text .= " ".$tens[$first]." ".$ones[$second];
                        }else{
                            $text .= " ".$tens[$first];
                        }
                    }
                }
                break;
        }
        return view('logistics.getinvoice',['text'=>$text]);
    }
    public function inputinvoice(Request $request)
    {
        $orders = Order::where('id',$request->id)->first();
        $address = SiteAddress::where('project_id',$orders->project_id)->first();
        $owner = OwnerDetails::where('project_id',$orders->project_id)->first();
        return view('logistics.inputinvoice',['orders'=>$orders,'address'=>$address,'owner'=>$owner]);
>>>>>>> e060e358804d4d9ef5425e8041bb61d0fbe4f9db
    }
}