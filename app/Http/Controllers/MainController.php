<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        return view('index');
    }
    public function category($code)
    {
        $category = Category::where('code',$code)->first();

        return view('category',['category'=>$category]);
    }
    public function basket(){
        return view('basket');
    }
    public function basketPlace(){
        return view('order');
    }

    public function categories()
    {
        $categories =Category::get();
        return view('categories',compact('categories'));
    }
    public function product($product = null)
    {
        return view('product',['product'=>$product]);
    }
}
