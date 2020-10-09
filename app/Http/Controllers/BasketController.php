<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

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

        return view('order', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $order = Order::getOrder();

        $order->confirmOrder($request);

        return redirect()->route('index');
    }

    public function basketAdd(Product $product)
    {
        $order = Order::getOrder();

        $order->addProduct($product);

        return redirect()->route('basket');
    }

    public function basketRemove(Product $product)
    {
        $order = Order::getOrder();

        $order->removeProduct($product);

        return redirect()->route('basket');
    }
}
