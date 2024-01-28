@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-3 col-xl-2">
            <div class="card">
                <div class="card-header">{{ __('Categories') }}</div>

                <div class="card-body">
                    <ul>
                    @foreach($categories as $category)
                        <li>
                            <a class="text-decoration-none text-body" href="{{ route('frontend.category', [ 'name'=>$category->name ]) }}">
                                
                                @php($belongs_to_product = $product->categories->contains('name', $category->name))

                                @if($belongs_to_product)<u>@endif

                                {{ $category->name }}

                                @if($belongs_to_product)</u>@endif
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="my-0">{{ __('Product') }}</h6>

                    <form class="d-flex" action="{{ route('cart-item.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                        <input type="hidden" value="" name="user_id">
                        <input min="0" name="quantity" value="{{ optional($product->currentCart)->quantity ?? 1}}" type="number" class="form-control" style="width:60px" />
                        <button type="submit" class="btn btn-primary btn-block w-100">
                            <small>Add to cart</small>
                        </button>
                    </form>

                </div>

                <div class="card-body">
                    <div class="row row justify-content-evenly">    
                        <div class="col-md-3">
                            <img class="mw-100" src="{{ URL::to('/') }}/images/{{$product->image->name }}">
                        </div>
                        <div class="col-md-5 d-flex my-auto flex-column">
                            <div>
                                <h4 class="my-3">
                                    {{ $product->name }}
                                </h4>
                                <p>
                                    {!! html_entity_decode($product->description) !!}
                                </p>
                            </div>
                            <div class="text-end">
                                {{ $product->price  }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection