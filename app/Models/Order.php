<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $fillable = ['user_id'];
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public static function getOrder()
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            $userId = [];
            if(Auth::check()){
                $userId['user_id'] =Auth::id();
            }
            $order = Order::create($userId);
            session(['orderId' => $order->id]);
        } else {
            $order = Order::findOrFail($orderId);
        }

        return $order;
    }

    public static function clearOrder()
    {
        session()->forget('orderId');
    }

    public function saveOrder($name, $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->status = 1;
        $this->save();
    }

    public function removeProduct($product)
    {

        if ($this->products->contains($product->id)) {
            $pivotRow = $this->products()->where('product_id', $product->id)->first()->pivot;
            if ($pivotRow->count < 2) {
                $this->products()->detach($product->id);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
            session()->flash('warning', 'Удален продукт ' . $product->name);
        }
    }

    public function addProduct($product)
    {
        if ($this->products->contains($product->id)) {
            $pivotRow = $this->products()->where('product_id', $product->id)->first()->pivot;
            $pivotRow->count++;

            if ($pivotRow->count > $product->count) {
                session()->flash('warning', 'Количество товара ' . $product->name .' ограничено');
                return;
            }
            $pivotRow->update();
        } else
            $this->products()->attach($product->id);

        session()->flash('success', 'Добавлен продукт ' . $product->name);
    }

    public function confirmOrder($request)
    {
        if (count($this->products) > 0) {
            $this->saveOrder($request->name, $request->phone);
            Order::clearOrder();
            session()->flash('success', 'Ваш заказ принят в обработку');
        }
    }


    public function getTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $totalPrice += $product->getPriceForCount();
        }
        return $totalPrice;
    }
}
