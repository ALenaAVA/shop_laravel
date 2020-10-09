@extends('layouts.master')
@section('title','Товар')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4">

                <img src="{{Storage::url($product->image)}}"></div>
            <div class="col-sm-8">
                <h1>{{$product->name}}</h1>
                <p>Цена: <b>{{$product->price}} $</b></p>

                <p>{{$product->description}}</p>

                @if($product->isAvailable())
                    <form action="{{route('basket_add',$product->id)}}" method="POST">
                        <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                        @csrf
                    </form>
                @else
                    Не доступен
                @endif

            </div>
        </div>
    </div>

@endsection
