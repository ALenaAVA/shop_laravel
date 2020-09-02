<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;

class BasketController extends Controller
{

    public function basket(){
        $order = Order::getOrder();

        return view('basket',compact('order'));
    }

    public function basketPlace(){
        return view('order');
    }

    public function basketAdd($productId){
        $order = Order::getOrder();

        $order->products()->attach($productId);
        return redirect()->route('basket');
    }

    public function basketRemove($productId){
        $order = Order::getOrder();

        $order->products()->detach($productId);
        return redirect()->route('basket');
    }
}
