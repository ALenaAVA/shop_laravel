<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\ProductFiltersRequest;
use App\Models\Product;
use Illuminate\Http\Request;

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

        $products = $productsQuery->paginate(6)->withPath('?'.$request->getQueryString());

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
}
