@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">


        <div class="col-md-2">
            <div class="card">
                <div class="card-header">{{ __('Categories') }}</div>

                <div class="card-body">
                    <ul>
                    @foreach($categories as $category)
                        <li>
                            <a class="text-decoration-none text-body" href="{{ route('frontend.category', [ 'name'=>$category->name ]) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>

                <div class="card-body">
                    <div class="row">

                    @foreach($products as $product)
                        <div class="col-md-3">
                            <div class="px-0 card h-100">
                                <a class="text-decoration-none text-body" href="{{ route('frontend.product', ['name'=>$product->name]) }}">            
                                    <img class="card-img-top" src="{{ URL::to('/') }}/images/{{ $product->image->name }}">
                                    <div class="card-body flex-column d-flex">
                                        <div class="">
                                            <h5 class="card-title mt-1">
                                                {{ $product->name }} {{ '' }}
                                            </h5>
                                            <div class="card-text text-end">
                                                <h6>{{ $product->price }}</h6>
                                            </div>
                                        </div>
                                
                                    </a>
                                    <div class="text-center mt-3">
                                        
                                        <form action="{{ route('cart-item.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                                            <input type="hidden" value="" name="user_id">
                                            <input min="0" name="quantity" value="{{ optional($product->currentCart)->quantity ?? 1}}" type="number" class="form-control" style="width:60px" />
                                            <button type="submit" class="btn btn-primary btn-block w-100">
                                                <small>Add to cart</small>
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection