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
use App\MamahomePrice;
use App\Supplierdetails;
use App\Country;
use App\Zone;
use App\ManufacturerDetail;
use App\Manufacturer;
use App\Mprocurement_Details;
use App\Requirement;
use App\Quotation;
use App\Gst;
use App\Category;
use App\SupplierInvoice;
use App\brand;
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
            $orders = DB::table('orders')->where('status','Order Confirmed')->orderBy('updated_at','desc')
                      ->leftjoin('project_details','project_details.project_id','orders.project_id')
                       ->leftjoin('sub_wards','sub_wards.id','project_details.sub_ward_id')
                       ->leftJoin('wards','wards.id','sub_wards.ward_id')
                       ->whereIn('wards.id',$ward)
                       ->select('orders.*','project_details.sub_ward_id')
                       ->paginate('20');
                      
        }
        else{
            $orders = DB::table('orders')->where('status','Order Confirmed')->orderBy('updated_at','desc')->paginate('20');

        }
      
        $reqs = Requirement::all();
        $payments = PaymentDetails::get();
        $data = MamahomePrice::distinct()->select('mamahome_prices.order_id','mamahome_prices.id')->pluck('mamahome_prices.id','mamahome_prices.order_id');
        $mamaprices = MamahomePrice::whereIn('id',$data)->get();
        $messages = Message::all();
        $counts = array();
        $users = User::all();
        foreach($orders as $order){
            $counts[$order->id] = Message::where('to_user',$order->id)->count();
        }
        return view('finance.financeOrders',['mamaprices'=>$mamaprices,'users'=>$users,'orders'=>$orders,'payments'=>$payments,'messages'=>$messages,'counts'=>$counts,'reqs'=>$reqs]);
    }
    public function clearOrderForDelivery(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->clear_for_delivery = "Yes";
        $order->save();
        return back()->with('Success','Order Cleared For Delivery');
    }
    public function downloadquotation(Request $request)
    {
        $price = Quotation::where('req_id',$request->id)->first();
        $procurement = ProcurementDetails::where('project_id',$price->project_id)->first();
        $mprocurement = Mprocurement_Details::where('manu_id',$request->manu_id)->first();
        $gst = Quotation::where('req_id',$request->id)->pluck('gstpercent')->first();
        if($gst == 1.28){
            $cgst = 14;
            $sgst = 14;
            $igst = 28;
        }
        else if($gst == 1.18){
            $cgst = 9;
            $sgst = 9;
            $igst = 18;
        }
       else if($gst == 1.05){
            $cgst = 2.5;
            $sgst = 2.5;
            $igst = 5;
        }
        else{
            $cgst = 14;
            $sgst = 14;
            $igst = 28;
        }
        $data = array(
            'price'=>$price,
            'procurement'=>$procurement,
            'mprocurement'=>$mprocurement,
            'igst'=>$igst
        );
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.quotation')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('pdf.quotation');
        }
    }
    public function downloadInvoice(Request $request)
    {
        $products = DB::table('orders')->where('id',$request->id)->first();
        $address = SiteAddress::where('project_id',$products->project_id)->first();

        $procurement = ProcurementDetails::where('project_id',$products->project_id)->first();
        $payment = PaymentDetails::where('order_id',$request->id)->first();
        $price = MamahomePrice::where('order_id',$request->id)->orderby('created_at','DESC')->first()->getOriginal();
        $gst = MamahomePrice::where('order_id',$request->id)->pluck('gstpercent')->first();
        if($gst == 1.28){
            $cgst = 14;
            $sgst = 14;
            $igst = 28;
        }
        else if($gst == 1.18){
            $cgst = 9;
            $sgst = 9;
            $igst = 18;
        }
       else if($gst == 1.05){
            $cgst = 2.5;
            $sgst = 2.5;
            $igst = 5;
        }
        else{
            $cgst = 14;
            $sgst = 14;
            $igst = 28;
        }
         if( $request->manu_id != null){
        $manu = Manufacturer::where('id',$request->manu_id)->first()->getOriginal();
        $mprocurement = Mprocurement_Details::where('manu_id',$request->manu_id)->first()->getOriginal();
            }
            else{
                $mprocurement = "";
                $manu = "";
            }
          
        $data = array(
            'products'=>$products,
            'address'=>$address,
            'procurement'=>$procurement,
            'payment'=>$payment,
            'price'=>$price,
            'manu'=>$manu,
            'mprocurement'=>$mprocurement,
            'cgst'=>$cgst,
            'sgst'=>$sgst,
            'igst'=>$igst
        );
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.invoice')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('Invoice.pdf');
        }
    }
    function downloadTaxInvoice(Request $request){
        $products = DB::table('orders')->where('id',$request->id)->first();
        $address = SiteAddress::where('project_id',$products->project_id)->first();
        $procurement = ProcurementDetails::where('project_id',$products->project_id)->first();
        $payment = PaymentDetails::where('order_id',$request->id)->first();
        $price = MamahomePrice::where('order_id',$request->id)->orderby('created_at','DESC')->first()->getOriginal();
        $gst = MamahomePrice::where('order_id',$request->id)->pluck('gstpercent')->first();
        $payment = paymentDetails::where('order_id',$request->id)->first();

        if($gst == 1.28){
            $cgst = 14;
            $sgst = 14;
            $igst = 28;
        }
        else if($gst == 1.18){
            $cgst = 9;
            $sgst = 9;
            $igst = 18;
        }
       else if($gst == 1.05){
            $cgst = 2.5;
            $sgst = 2.5;
            $igst = 5;
        }
        else{
            $cgst = 14;
            $sgst = 14;
            $igst = 28;
        }
        if( $request->manu_id != null){
        $manu = Manufacturer::where('id',$request->manu_id)->first()->getOriginal();  
        $mprocurement = Mprocurement_Details::where('manu_id',$request->manu_id)->first()->getOriginal();
            }
            else{
                 $mprocurement = "";
                $manu = "";
            }
        
        $data = array(
            'products'=>$products,
            'address'=>$address,
            'procurement'=>$procurement,
            'payment'=>$payment,
            'price'=>$price,
             'manu'=>$manu,
            'mprocurement'=>$mprocurement,
            'payment'=>$payment,
            'cgst'=>$cgst,
            'sgst'=>$sgst,
            'igst'=>$igst

        );
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.proformaInvoice')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('Tax.pdf');
        }
    }
    function downloadSupplierInvoice(Request $request){
        $products = DB::table('orders')->where('id',$request->id)->first();
         if( $products->project_id != null){
        $address = SiteAddress::where('project_id',$products->project_id)->first();
            }
            else{
                $address = "";
            }
        $procurement = ProcurementDetails::where('project_id',$products->project_id)->first();
        $payment = PaymentDetails::where('order_id',$request->id)->first();
        $sp = Supplierdetails::where('order_id',$request->id)->pluck('id')->first();
        $supplier = Supplierdetails::where('id',$sp)->first()->getOriginal();
        $invoice = SupplierInvoice::where('order_id',$request->id)->first();
        if( $request->mid != null){
        $manu = Manufacturer::where('id',$request->mid)->first()->getOriginal();
            }
            else{
                $manu = "";
            }
        $suppliername = Supplierdetails::where('order_id',$request->id)->pluck('supplier_name')->first();
        $supplierimage = brand::where('brand',$suppliername)->pluck('brandimage')->first();
        
        $invoiceimage = SupplierInvoice::where('order_id',$request->id)->pluck('file1')->first();

        $data = array(
            'products'=>$products,
            'address'=>$address,
            'procurement'=>$procurement,
            'payment'=>$payment,
            'manu'=>$manu,
            'supplier'=>$supplier,
            'supplierimage'=>$supplierimage,
            'invoiceimage'=>$invoiceimage,
            'invoice'=>$invoice
        );

        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.supplierinvoice')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('supplier.pdf');
        }
    }
    function downloadpurchaseOrder(Request $request){
        $products = DB::table('orders')->where('id',$request->id)->first();
         if( $products->project_id != null){
        $address = SiteAddress::where('project_id',$products->project_id)->first();
            }
            else{
                $address = "";
            }
        $procurement = ProcurementDetails::where('project_id',$products->project_id)->first();
        $payment = PaymentDetails::where('order_id',$request->id)->first();
        $sp = Supplierdetails::where('order_id',$request->id)->pluck('id')->first();
        $supplier = Supplierdetails::where('id',$sp)->first()->getOriginal();
       
        if( $request->mid != null){
        $manu = Manufacturer::where('id',$request->mid)->first()->getOriginal();
            }
            else{
                $manu = "";
            }
          
        $data = array(
            'products'=>$products,
            'address'=>$address,
            'procurement'=>$procurement,
            'payment'=>$payment,
            'manu'=>$manu,
            'supplier'=>$supplier
        );

        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.purchaseOrder')->setPaper('a4','portrait');
        if($request->has('download')){
            return $pdf->download(time().'.pdf');
        }else{
            return $pdf->stream('purchaseOrder.pdf');
        }
    }
    public function savePaymentDetails(Request $request)
    {
        $totalRequests = count($request->payment_slip);
        $category =  Order::where('id',$request->id)->pluck('main_category')->first();
        $order = Order::where('id',$request->id)->first();
        $order->payment_status = "Payment Received";
        $order->payment_mode = $request->method;
        $order->save();
        $i = 0;
        $paymentimage ="";
            if($request->payment_slip){
                foreach($request->payment_slip as $pimage){
                     $imageName3 = $i.time().'.'.$pimage->getClientOriginalExtension();
                     $pimage->move(public_path('payment_details'),$imageName3);
                     if($i == 0){
                        $paymentimage .= $imageName3;
                     }
                     else{
                            $paymentimage .= ",".$imageName3;
                     }
                     $i++;
                }
            }
            $rtgsimage ="";
            if($request->rtgs_file){
                foreach($request->rtgs_file as $pimage){
                     $imageName3 = $i.time().'.'.$pimage->getClientOriginalExtension();
                     $pimage->move(public_path('rtgs_files'),$imageName3);
                     if($i == 0){
                        $rtgsimage .= $imageName3;
                     }
                     else{
                            $rtgsimage .= ",".$imageName3;
                     }
                     $i++;
                }
            }

        if($request->method == "CASH"){
               
                    $paymentDetails = new PaymentDetails;
                    $paymentDetails->order_id = $request->id;
                    $paymentDetails->payment_mode = $request->method;
                    $paymentDetails->date = $request->date;
                    $paymentDetails->Totalamount = $request->totalamount;
                    $paymentDetails->damount = $request->damount;
                    $paymentDetails->file = $paymentimage;
                    $paymentDetails->payment_note = $request->notes;
                    $paymentDetails->bank_name =$request->bankname;
                    $paymentDetails->branch_name = $request->branchname;
                    $paymentDetails->category = $category;
                    $paymentDetails->project_id = $request->pid;
                    $paymentDetails->manu_id = $request->mid;
                    $paymentDetails->save();
            }
            else if($request->method == "RTGS"){
                    $paymentDetails = new PaymentDetails;
                    $paymentDetails->order_id = $request->id;
                    $paymentDetails->payment_mode = $request->method;
                    $paymentDetails->account_number = $request->accnum;
                    $paymentDetails->branch_name =$request->accname;
                    $paymentDetails->date =$request->date;
                    $paymentDetails->Totalamount = $request->totalamount;
                    $paymentDetails->damount = $request->damount;
                    $paymentDetails->file = "";
                    $paymentDetails->payment_note = $request->notes;
                    $paymentDetails->category = $category;
                    $paymentDetails->project_id = $request->pid;
                    $paymentDetails->manu_id = $request->mid;
                    $paymentDetails->rtgs_file = $rtgsimage;
                    $paymentDetails->save();
            }
            else if($request->method == "CHEQUE"){
               
                $paymentDetails = new PaymentDetails;
                $paymentDetails->order_id = $request->id;
                $paymentDetails->payment_mode = $request->method;
                $paymentDetails->cheque_number =$request->cheque_num;
                $paymentDetails->date =$request->date;
                $paymentDetails->Totalamount = $request->totalamount;
                $paymentDetails->damount = $request->damount;
                $paymentDetails->file = "";
                $paymentDetails->payment_note = $request->notes;
                $paymentDetails->bank_name =$request->bankname;
                $paymentDetails->branch_name = $request->branchname;
                 $paymentDetails->category = $category;
                 $paymentDetails->project_id = $request->pid;
                    $paymentDetails->manu_id = $request->mid;
                $paymentDetails->save();
            }
            else{
                $paymentDetails = new PaymentDetails;
                $paymentDetails->order_id = $request->id;
                $paymentDetails->payment_mode = $request->method;
                $paymentDetails->cash_holder = $request->name;
                $paymentDetails->date =$request->date;
                $paymentDetails->damount = $request->damount;
                $paymentDetails->payment_note = $request->notes;
                $paymentDetails->Totalamount = $request->totalamount;
                 $paymentDetails->category = $category;
                 $paymentDetails->project_id = $request->pid;
                    $paymentDetails->manu_id = $request->mid;
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
    // public function confirmpayment(Request $request){    
    //     Order::where('id',$request->id)->update([
    //         'final_payment'=>"Received"
    //     ]);
    //     return back()->with('Success','Payment Received Successfully');
    // }
    public function paymentmode(Request $request){
        $users = User::where('department_id','!=',10)->get();

       return view('finance.payment',['id'=>$request->id,'users'=>$users,'mid'=>$request->mid,'pid'=>$request->pid]);
    }
    public function saveunitprice(Request $request){
       
       // invoice

       
        $year = date('Y');
        $country_code = Country::pluck('country_code')->first();
        $zone = Zone::pluck('zone_number')->first();
        // roundoff
        $unitwithoutgst = round($request->unitwithoutgst,2);
        $cgst = round($request->cgst,2);
        $sgst = round($request->sgst,2);
        $igst = round($request->igst,2);
        $price = MamahomePrice::where('order_id',$request->id)->first();
        $invoiceno = "MH_".$country_code."_".$zone."_".$year."_IN".$price->id; 
        $price->unit = $request->unit;
        $price->mamahome_price = $request->price;
        $price->unitwithoutgst = $unitwithoutgst;
        $price->totalamount = $request->tamount;
        $price->cgst = $cgst;
        $price->sgst = $sgst;
        $price->igst = $igst;
        $price->totaltax = $request->totaltax;
        $price->amountwithgst = $request->gstamount;
        $price->amount_word = $request->dtow1;
        $price->tax_word = $request->dtow2;
        $price->gstamount_word =  $request->dtow3;
        $price->igsttax_word = $request->dtow4;
        $price->quantity = $request->quantity;
        $price->manu_id = $request->manu_id;
        $price->description = $request->desc;
        $price->billaddress = $request->bill;
        $price->shipaddress = $request->ship;
        $price->updated_by = Auth::user()->id;
        $price->cgstpercent = $request->g1;
        $price->sgstpercent = $request->g2;
        $price->gstpercent = $request->g3;
        $price->igstpercent = $request->i1;
        $price->edited = "No";
        $price->invoiceno = $invoiceno;
        $price->save();
        
        $order = Order::where('id',$request->id)->first();
        $order->confirm_payment = " Received";
        $order->save();
         PaymentDetails::where('order_id',$request->id)->update([
            'status'=>"Received"
        ]);
         dd();
        return back()->with('Success','Payment Confirmed');
    }
    public function savesupplierdetails(Request $request){
        $check = Supplierdetails::where('order_id',$request->id)->first();
        if(count($check) == 0){
        $projectid = Order::where('id',$request->id)->pluck('project_id')->first();
        $order = Order::where('id',$request->id)->first();
        $order->purchase_order = "yes";
        $order->save();
        $year = date('Y');
        $country_initial = "O";
        $country_code = Country::pluck('country_code')->first();
        $zone = Zone::pluck('zone_number')->first();
        $supply = New Supplierdetails;
        $supply->project_id = $projectid;
        $supply->category = $request->category;
        $supply->manu_id = $request->mid;
        $supply->address = $request->address;
        $supply->ship = $request->ship;
        $supply->order_id = $request->id;
        $supply->supplier_name = $request->name;
        $supply->gst = $request->gst;
        $supply->description = $request->desc;
        $supply->quantity = $request->quantity;
        $supply->unit = $request->munit;
        $supply->unit_price = $request->uprice;
        $supply->amount = $request->amount;
        $supply->amount_words = $request->dtow;
        $supply->totalamount = $request->totalamount;
        $supply->tamount_words = $request->dtow1;
        $supply->unitwithoutgst =$request->unitwithoutgst;
        $supply->cgstpercent = $request->cgstpercent;
        $supply->sgstpercent = $request->sgstpercent;
        $supply->gstpercent = $request->gstpercent;
        $supply->igstpercent = $request->igstpercent;
        $supply->save();
        $lpoNo = "MH_".$country_code."_".$zone."_LPO_".$year."_".$supply->id; 
        $supply =Supplierdetails::where('id',$supply->id)->update(['lpo'=>
            $lpoNo]);
        }
        else{
               
                $check->address = $request->edit1;
                $check->ship = $request->edit2;  
                $check->supplier_name = $request->name;
                $check->gst = $request->edit3;
                $check->description = $request->edit4;
                $check->quantity = $request->edit6;
                $check->unit = $request->edit5;
                $check->unit_price = $request->uprice;
                $check->amount = $request->amount;
                $check->amount_words = $request->dtow;
                $check->totalamount = $request->totalamount;
                $check->tamount_words = $request->dtow1;
                $check->unitwithoutgst =$request->unitwithoutgst;
                $check->cgstpercent = $request->cgstpercent;
                $check->sgstpercent = $request->sgstpercent;
                $check->gstpercent = $request->gstpercent;
                $check->igstpercent = $request->igstpercent;
                $check->save();
        }
        return back();
    }
     public function getgst(Request $request){
        $res = ManufacturerDetail::where('company_name',$request->name)->pluck('registered_office')->first();
        $gst = ManufacturerDetail::where('company_name',$request->name)->pluck('gst')->first();
        $category = ManufacturerDetail::where('company_name',$request->name)->pluck('category')->first();
        $unit = Category::where('category_name',$category)->pluck('measurement_unit')->first();
        $id = $request->x;
        return response()->json(['res'=>$res,'id'=>$id,'gst'=>$gst,'category'=>$category,'unit'=>$unit]);
    }
    public function supplierinvoice(Request $request){   
        if($request->file1 != NULL){
                $image1 = time().'.'.request()->file1->getClientOriginalExtension();
                $request->file1->move(public_path('supplierinvoice'),$image1);
            }else{
                $image1 = "N/A";
            }
         if($request->file2 != NULL){
                $image2 = time().'.'.request()->file2->getClientOriginalExtension();
                $request->file2->move(public_path('supplierinvoice'),$image2);
            }else{
                $image2 = "N/A";
            }

        $lpo = Supplierdetails::where('order_id',$request->id)->pluck('lpo')->first();
   
        $invoice = New SupplierInvoice;
        $invoice->lpo_number = $lpo;
        $invoice->order_id = $request->id;
        $invoice->invoice_number = $request->supplierinvoice;
        $invoice->invoice_date = $request->invoicedate;
        $invoice->file1 = $image1;
        $invoice->file2 = $image2;
        $invoice->project_id = $request->project_id;
        $invoice_manu_id = $request->mid;
        $invoice->save();
        $order = Order::where('id',$request->id)->first();
        $order->supplier_invoice = "yes";
        $order->save();

        return back();
    }
}
