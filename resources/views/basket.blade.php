@extends('master')
@section('title','Корзина')
@section('content')
    <div class="starter-template">
        <p class="alert alert-success">Добавлен товар HTC One S</p>
        <h1>Корзина</h1>
        <p>Оформление заказа</p>
        <div class="panel">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Стоимость</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td>
                        <a href="{{route('product',['category'=>$product->category->code,'product'=>$product->code])}}">
                            <img height="56px" src="http://internet-shop.tmweb.ru/storage/products/htc_one_s.png">
                            {{$product->name}}
                        </a>
                    </td>
                    <td><span class="badge">1</span>
                        <div class="btn-group form-inline">
                            <form action="http://internet-shop.tmweb.ru/basket/remove/3" method="POST">
                                <button type="submit" class="btn btn-danger" href="">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </button>
                                <input type="hidden" name="_token" value="T0b7UBWkEgdN8CanY4T0VmZoLhfm94ucAqdMisqN">
                            </form>
                            <form action="{{route('basket_add',$product)}}" method="POST">
                                <button type="submit" class="btn btn-success" >
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                @csrf
                            </form>
                        </div>
                    </td>
                    <td>{{$product->price}} $</td>
                    <td>{{$product->price}} $</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3">Общая стоимость:</td>
                    <td>12490 ₽</td>
                </tr>
                </tbody>
            </table>
            <br>
            <div class="btn-group pull-right" role="group">
                <a type="button" class="btn btn-success" href="{{route('basket_place')}}">Оформить заказ</a>
            </div>
        </div>
    </div>
@endsection
