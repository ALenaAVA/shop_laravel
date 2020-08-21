@extends('master')
@section('title','Товар')
@section('content')
<div class="starter-template">
    <h1>{{$product->name}}</h1>
    <p>Цена: <b>{{$product->price}} $</b></p>
    <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg">
    <p>{{$product->description}}</p>

    <form action="{{route('basket_add',$product->id)}}" method="POST">
        <a href="{{route('basket')}}" class="btn btn-primary" role="button">В корзину</a>
        <input type="hidden" name="_token" value="WvJqvAjeuDLhyPtf3owd89KuqT9rMgtZjABbiNTd"></form>
</div>
@endsection
