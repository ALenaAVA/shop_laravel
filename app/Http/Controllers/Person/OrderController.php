<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->where('status',1)->get();
        //$orders = Order::where('status',1)->get();
        return view('orders.index',compact('orders'));
    }

    public function show($order_id){
        $order = Order::where('id',$order_id)->first();
        //dd($order);
        return view('orders.show',compact('order'));
    }
}
