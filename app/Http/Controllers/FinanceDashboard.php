<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
class FinanceDashboard extends Controller
{
    public function getFinanceDashboard()
    {
        $orders = Order::where('status','Order Confirmed')->get();
        return view('finance.financeOrders',['orders'=>$orders]);
    }
}
