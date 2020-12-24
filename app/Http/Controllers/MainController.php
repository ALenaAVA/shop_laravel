<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Http\Requests\ProductFiltersRequest;
use App\Models\Product;
use App\Models\Subscriotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MainController extends Controller
{
    public function index(ProductFiltersRequest $request)
    {
        // \Debugbar::info($request);
        // $productsQuery = Product::query();
        $productsQuery = Product::with('category');
        if ($request) {
            if ($request->filled('price_from')) {
                $productsQuery->where('price', '>=', $request->price_from);
            }
            if ($request->filled('price_to')) {
                $productsQuery->where('price', '<=', $request->price_to);
            }
            foreach (['hit', 'new', 'recommend'] as $field) {
                if ($request->has($field)) {
                    $productsQuery->$field();
                }
            }
        }

        $products = $productsQuery->paginate(6)->withPath('?' . $request->getQueryString());

        return view('index', compact('products'));
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->first();
        return view('category', compact('category'));
    }

    public function categories()
    {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function product($category, $productCode)
    {
        $p = Product::byCode($productCode)->firstOrFail();
        return view('product', ['product' => $p]);
    }

    public function subscribe(SubscriptionRequest $request, Product $product)
    {

        Subscriotion::create([
            'email' => $request->email,
            'product_id' => $product->id,
        ]);

        return redirect()->back()->with('success', 'Спасибо, мы сообщим вам о наличии товара');
    }

    public function changeLocale($locale)
    {
        session(['locale'=>$locale]);
        App::setLocale($locale);
        return redirect()->back();
    }
}
