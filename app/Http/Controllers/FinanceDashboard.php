<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\SiteAddress;
use App\ProcurementDetails;
use App\PaymentDetails;
use App\Message;
use App\User;
use App\Tlwards;
use DB;
use Auth;
use PDF;
date_default_timezone_set("Asia/Kolkata");
class FinanceDashboard extends Controller
{
    public function financeIndex()
    {
        return view('finance.index');
    }
    public function getFinanceDashboard()
    {
        if(Auth::user()->group_id == 22){
            $tlward = Tlwards::where('user_id',Auth::user()->id)->pluck('ward_id')->first();
            $ward = explode(",",$tlward);
            $orders = DB::table('orders')->where('status','Order Confirmed')
                      ->leftjoin('project_details','project_details.project_id','orders.project_id')
                       ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                       ->leftJoin('wards','wards.id','sub_wards.ward_id')
                       ->whereIn('wards.id',$ward)
                       ->select('orders.*','project_details.sub_ward_id')
                       ->paginate('20');
                      
        }
        else{
            $orders = DB::table('orders')->where('status','Order Confirmed')->orderBy('created_at','desc')->paginate('20');
        }
        $payments = PaymentDetails::get();
        $messages = Message::all();
        $counts = array();
        $users = User::all();
        foreach($orders as $order){
            $counts[$order->id] = Message::where('to_user',$order->id)->count();
        }
        return view('finance.financeOrders',['users'=>$users,'orders'=>$orders,'payments'=>$payments,'messages'=>$messages,'counts'=>$counts]);
    }
    public function clearOrderForDelivery(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->clear_for_delivery = "Yes";
        $order->save();
        return back()->with('Success','Order Cleared For Delivery');
    }
    public function downloadProformaInvoice(Request $request)
    {
        $products = DB::table('orders')->where('id',$request->id)->first();
        $address = SiteAddress::where('project_id',$products->project_id)->first();
        $procurement = ProcurementDetails::where('project_id',$products->project_id)->first();
        $data = array(
            'products'=>$products,
            'address'=>$address,
            'procurement'=>$procurement
        );
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.invoice')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('pdf.invoice');
        }
    }
    function downloadProformatTaxInvoice(Request $request){
        $products = DB::table('orders')->where('id',$request->id)->first();
        $address = SiteAddress::where('project_id',$products->project_id)->first();
        $procurement = ProcurementDetails::where('project_id',$products->project_id)->first();
        $data = array(
            'products'=>$products,
            'address'=>$address,
            'procurement'=>$procurement
        );
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.proformalInvoice')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('pdf.proformalInvoice');
        }
    }
    public function savePaymentDetails(Request $request)
    {
        $totalRequests = count($request->payment_slip);

        $order = Order::where('id',$request->order_id)->first();
        $order->payment_status = "Payment Received";
        $order->payment_mode = $request->payment_mode;
        $order->payment_note = $request->notes;
        $order->save();
        for($i = 0; $i < $totalRequests; $i++){
            $paymentDetails = new PaymentDetails;
            $paymentDetails->order_id = $request->order_id;
            $imageName1 = $request->order_id.$i.time().'.'.request()->payment_slip[$i]->getClientOriginalExtension();
            $request->payment_slip[$i]->move(public_path('payment_details'),$imageName1);
            $paymentDetails->file = $imageName1;
            $paymentDetails->save();
        }
        return back()->with('Success','Payment Details Saved Successfully');
    }
    public function getFinanceAttendance()
    {
        return view('finance.attendance');
    }
    public function getViewProformaInvoice(Request $request)
    {
        $products = DB::table('orders')->where('id',$request->id)->first();
        $address = SiteAddress::where('project_id',$products->project_id)->first();
        $procurement = ProcurementDetails::where('project_id',$products->project_id)->first();
        $data = array(
            'products'=>$products,
            'address'=>$address,
            'procurement'=>$procurement
        );
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.proformaInvoice')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('pdf.proformaInvoice');
        }
    }
    public function getViewPurchaseOrder(Request $request)
    {
        $products = DB::table('orders')->where('id',$request->id)->first();
        $address = SiteAddress::where('project_id',$products->project_id)->first();
        $procurement = ProcurementDetails::where('project_id',$products->project_id)->first();
        $data = array(
            'products'=>$products,
            'address'=>$address,
            'procurement'=>$procurement
        );
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.purchaseOrder')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('pdf.purchaseOrder');
        }
    }
    public function sendMessage(Request $request)
    {
        $message = New Message;
        $message->from_user = Auth::user()->id;
        $message->to_user = $request->orderId;
        $message->body = $request->message;
        $message->save();
        return back();
    }
    public function confirmpayment(Request $request){

        
        Order::where('id',$request->id)->update([
            'final_payment'=>"Received"
        ]);
        return back()->with('Success','Payment Received Successfully');
    }
}
