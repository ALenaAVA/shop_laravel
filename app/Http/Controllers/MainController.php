<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductFiltersRequest;
use App\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(ProductFiltersRequest $request)
    {
        $productsQuery = Product::query();
        if ($request) {
            if ($request->filled('price_from')) {
                $productsQuery->where('price', '>=', $request->price_from);
            }
            if ($request->filled('price_to')) {
                $productsQuery->where('price', '<=', $request->price_to);
            }
            foreach (['hit', 'new', 'recommend'] as $field) {
                if ($request->has($field)) {
                    $productsQuery->where($field, 1);
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

    public function product($category, $product = null)
    {

        $p = Product::where('code', $product)->first();
        return view('product', ['product' => $p]);
    }
}
