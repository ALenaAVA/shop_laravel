@extends('layouts.master')
@section('title','Категории')
@section('content')
        <div class="panel">
            @foreach($categories as $category)
            <a href="{{route('category',$category->code)}}">
                <img src="{{$category->image}}">
                <h2>{{$category->name}}</h2>
            </a>
            <p>
                {{$category->description}}
            </p>
            @endforeach
        </div>
@endsection
