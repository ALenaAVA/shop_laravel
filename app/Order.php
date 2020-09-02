<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public static function getOrder(){
        $orderId = session('orderId');
        if(is_null($orderId)){
            $order = Order::create();
            session(['orderId'=> $order->id]);
        }else{
            $order = Order::find($orderId);
        }

        return $order;
    }
}
