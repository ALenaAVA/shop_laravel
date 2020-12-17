@extends('layouts.master')
@section('title','Товар')
@section('content')
    @if(session()->has('success'))
        <p class="alert alert-success">{{session()->get('success')}}</p>
    @elseif(session()->has('warning'))
        <p class="alert alert-warning">{{session()->get('warning')}}</p>
    @endif
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
                    <p>Не доступен</p>
                @if($errors->get('email'))
                        <span class="alert-danger">{{$errors->get('email')[0]}}</span>
                @endif
                    <form action="{{route('subscription',$product)}}" method="POST">
                        <input type="text" name="email">
                        <button type="submit">Отправить</button>
                        @csrf
                    </form>
                @endif

            </div>
        </div>
    </div>

@endsection
