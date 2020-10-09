@extends('layouts.master')
@section('title','Товар')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4">

                <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg"></div>
            <div class="col-sm-8">
                <h1>{{$product->name}}</h1>
                <p>Цена: <b>{{$product->price}} $</b></p>

                <p>{{$product->description}}</p>

                <form action="{{route('basket_add',$product->id)}}" method="POST">
                    @if($product->isAvailable())
                        {{--            <button type="submit" class="btn btn-primary" role="button">В корзину</button>--}}
                        <a href="{{route('basket')}}" class="btn btn-primary" role="button">В корзину</a>
                    @else
                        Не доступен
                @endif

                @csrf
            </div>
        </div>
    </div>

@endsection
