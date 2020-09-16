<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{

    public function basket()
    {
        $order = Order::getOrder();

        return view('basket', compact('order'));
    }

    public function basketPlace()
    {
        $order = Order::getOrder();
        if (count($order->products) < 1) {
            return redirect()->route('index');
        }
        return view('order', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $order = Order::getOrder();
        if (count($order->products) > 0) {
            $order->saveOrder($request->name, $request->phone);
            Order::clearOrder();
            session()->flash('success','Ваш заказ принят в обработку');
        }

        return redirect()->route('index');
    }

    public function basketAdd($productId)
    {

        $order = Order::getOrder();
        if ($order->products->contains($productId)) {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            $pivotRow->count++;
            $pivotRow->update();
        } else
            $order->products()->attach($productId);
        if(Auth::check()){
            $order->user_id = Auth::id();
            $order->save();
        }

        $product = Product::find($productId);
        session()->flash('success','Добавлен продукт '.$product->name);

        return redirect()->route('basket');
    }

    public function basketRemove($productId)
    {
        $order = Order::getOrder();

        if ($order->products->contains($productId)) {

            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            if ($pivotRow->count < 2) {
                $order->products()->detach($productId);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }

            $product = Product::find($productId);
            session()->flash('warning','Удален продукт '.$product->name);
        }



        return redirect()->route('basket');
    }
}
