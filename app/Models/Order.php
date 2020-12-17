<?php

namespace App\Models;

use App\Mail\OrderCrated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    protected $fillable = ['user_id','email'];
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

    public function saveOrder($request)
    {
        if(($name = $this->countAvailable(true)) != 'success'){
            session()->flash('warning', 'Количество товара ' . $name .' ограничено');
            return;
        }



        $this->name = $request->name;
        $this->phone = $request->phone;
        $this->email = $request->email;
        $this->status = 1;
        $this->save();
        Mail::to($request->email)->send(new OrderCrated($request->name,$this));
    }

    public function removeProduct($product)
    {
        if ($this->products->contains($product->id)) {
            $pivotRow = $this->getPivotRow($product);
            if ($pivotRow->count < 2) {
                $this->products()->detach($product->id);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
            session()->flash('warning', 'Удален продукт ' . $product->name);
        }
    }

    protected function getPivotRow($product){
        return $this->products()->where('product_id', $product->id)->first()->pivot;
    }

    public function addProduct($product)
    {
        if ($this->products->contains($product->id)) {
            $pivotRow = $this->getPivotRow($product);
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

    public  function checkOrderCount(){
        if(($name = $this->countAvailable())!='success'){
            session()->flash('warning', 'Количество товара ' . $name .' недостаточно для заказа');
            return redirect()->route('index');
        }
    }
    public function confirmOrder($request)
    {
        if (count($this->products) > 0) {
            $this->saveOrder($request);
            self::clearOrder();
            session()->flash('success', 'Ваш заказ принят в обработку');
        }
    }

    public function countAvailable($updateCount = false){
        foreach ($this->products as $orderProduct){
            if ($orderProduct->count < $this->getPivotRow($orderProduct)->count){
                return $orderProduct->name;
            }

            if($updateCount){
                $orderProduct->count -=$this->getPivotRow($orderProduct)->count;
            }

        }
        if($updateCount){
            $this->products->map->save();
        }
        return 'success';
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
