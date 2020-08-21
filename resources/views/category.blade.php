@extends('master')
@section('title',$category->name)
@section('content')
    <div class="starter-template">
        <h1>{{$category->name}} </h1>

        <p>
            {{$category->description}}
        </p>
        <div class="row">
            @for($i = 0;$i<5;$i++)
                @include('card')
            @endfor
        </div>
    </div>
@endsection
