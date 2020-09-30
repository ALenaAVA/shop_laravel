<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query){
        return $query->where('status',1);
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
