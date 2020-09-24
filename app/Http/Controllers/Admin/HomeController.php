<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::where('status',1)->get();
        return view('orders.index',compact('orders'));
    }

    public function show($order_id){
        $order = Order::where('id',$order_id)->first();
        //dd($order);
        return view('orders.show',compact('order'));
    }
}