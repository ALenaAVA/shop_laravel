<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

    public static function getOrder(){
        $orderId = session('orderId');

        if(is_null($orderId)){
            $order = Order::create();
            session(['orderId'=> $order->id]);
        }else{
            $order = Order::find($orderId);
        }
//dd($order);
        return $order;
    }

    public static function clearOrder(){
        session()->forget('orderId');
    }
    public function saveOrder($name,$phone){
        $this->name = $name;
        $this->phone = $phone;
        $this->status = 1;
        $this->save();
    }


    public function getTotalPrice(){
        $totalPrice = 0;
        foreach ($this->products as $product){
            $totalPrice += $product->getPriceForCount();
        }
        return $totalPrice;
    }
}
