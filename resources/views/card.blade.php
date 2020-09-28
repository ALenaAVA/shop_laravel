<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">

            @if($product->isNew())
                <span class="badge badge-success">New</span>
            @endif
            @if($product->isHit())
                <span class="badge badge-warning">Hit</span>
            @endif
            @if($product->isRecommend())
                <span class="badge badge-danger">Recommend</span>
            @endif
        </div>
        <img src="{{Storage::url($product->image)}}" alt="{{$product->name}}">
        <div class="caption">
            <h3>{{$product->name}}</h3>
            <p>{{$product->price}} $</p>
            <p>
            <form action="{{route('basket_add',$product->id)}}" method="POST">
                <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                <a href="{{route('product',['category'=>$product->category->code,'product'=>$product->code])}}"
                   class="btn btn-default" role="button">Подробнее</a>
                @csrf
            </form>
            <p></p>
        </div>
    </div>
</div>
