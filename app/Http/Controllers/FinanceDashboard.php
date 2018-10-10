<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\SiteAddress;
use App\ProcurementDetails;
use App\PaymentDetails;
use DB;
use Auth;
use PDF;
class FinanceDashboard extends Controller
{
    public function getFinanceDashboard()
    {
        $orders = DB::table('orders')->where('status','Order Confirmed')->get();
        $payments = PaymentDetails::get();
        return view('finance.financeOrders',['orders'=>$orders,'payments'=>$payments]);
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
        $products = Order::where('id',$request->id)->first();
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
    public function savePaymentDetails(Request $request)
    {
        $totalRequests = count($request->payment_slip);
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
}
