@extends('layouts.app')

@section('content')
<section class="h-100 gradient-custom">
    <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">

                    <div class="card-header py-3">
                        <h5 class="mb-0">{{ __('Cart - ' . $cart->cart_items_amount . ' item(s)') }}</h5>
                    </div>

                    <div class="card-body">

                        @php($i = 1)
                        <!--@php( session(['cart' => $cart, 'items' => $items]) )-->
                        @foreach($items as $item)
                        <div class="row">
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                
                                <form id="form-remove-{{ $item->product->id }}" class="d-flex" action="{{ route('cart-item.remove') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{ $item->product->id }}" name="product_id">
                                    <input type="hidden" value="{{ $cart->user_id }}" name="user_id">
                                    <button type="submit" class="btn btn-primary btn-sm" data-mdb-toggle="tooltip" title="Remove item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-2 mb-4 mb-lg-0">
                                <a href="{{ route('frontend.product', ['name'=>$item->product->name]) }}">
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src="{{ URL::to('/') }}/images/{{$item->product->image->name}}" class="w-100" alt="" />
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 mb-4 mb-lg-0 py-1 justify-content-between d-flex flex-column">
                                <p>
                                    <a href="{{ route('frontend.product', ['name'=>$item->product->name]) }}" class="text-decoration-none text-body">
                                        <strong>{{ $item->product->name }}</strong>
                                    </a>
                                </p>
                                <div>
                                    <!--<button type="button" class="btn btn-primary btn-sm me-1 mb-2" data-mdb-toggle="tooltip" title="Remove item">
                                        <i class="fas fa-trash"></i>
                                    </button>-->
                                    <!--<button type="button" class="btn btn-danger btn-sm mb-2" data-mdb-toggle="tooltip" title="Move to the wish list">
                                        <i class="fas fa-heart"></i>
                                    </button>-->
                                </div>
                            </div>

                            <div class="col-md-2 mb-4 mb-lg-0 py-1 align-items-center d-flex justify-content-end px-4 border-end">
                                <div class="text-end h-100 d-flex justify-content-between flex-column">
                                    <p class="mt-auto mb-0">
                                        <!--[ {{ $item->product->price}} x {{ $item->quantity }} ]<br>-->
                                        {{ $item->product->price }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-4 mb-lg-0 py-1 align-items-center d-flex justify-content-center px-4">
                                <div class="text-end h-100 d-flex justify-content-between flex-column">

                                    <form id="form-quantity-{{ $item->product->id }}" action="{{ route('cart-item.update') }}" method="POST" enctype="multipart/form-data">
                                        <label class="form-label w-100 text-center" for="counter-for-{{ $item->product->id }}">Quantity</label>

                                        <div class="form-outline inline-flex d-flex">
                                            @csrf
                                            <input type="hidden" value="{{ $item->product->id }}" name="product_id">
                                            <input type="hidden" value="{{ $cart->user_id }}" name="user_id">

                                            <button class="btn btn-primary px-2 me-2" type="submit" onclick="decrementQuantity('{{$item->product->id}}')">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <input id="counter-for-{{$item->product->id}}" min="0" name="quantity" value="{{ $item->quantity }}" onchange="form.submit()" type="number" class="form-control" style="width:60px" />
                                                  
                                            <button class="btn btn-primary px-2 ms-2" type="button" onclick="incrementQuantity('{{$item->product->id}}')">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                        </div>
                                          
                                    </form>

                                    <div>
                                        <strong class="mt-auto">
                                            {{ $item->item_total_price }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($i != $cart->cart_items_amount)
                        <hr class="my-4" />
                        @endif
                        @php($i++)

                        @endforeach

                    </div>
                </div>
                <!--<div class="card mb-4">
                    <div class="card-body">
                        <p><strong>Expected shipping delivery</strong></p>
                        <p class="mb-0"></p>
                    </div>
                </div>-->
                <!--<div class="card mb-4 mb-lg-0">
                    <div class="card-body">
                        <p><strong>We accept</strong></p>
                        <img class="me-2" width="45px"
                            src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                            alt="Visa" />
                        <img class="me-2" width="45px"
                            src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
                            alt="American Express" />
                        <img class="me-2" width="45px"
                            src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                            alt="Mastercard" />
                        <img class="me-2" width="45px"
                            src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce/includes/gateways/paypal/assets/images/paypal.webp"
                            alt="PayPal acceptance mark" />
                    </div>
                </div>-->
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Products
                                <span>{{ $cart->cart_total_price }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Shipping
                                <span>Gratis</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>Total amount</strong>
                                    <strong>
                                        <p class="mb-0">(including VAT)</p>
                                    </strong>
                                </div>
                                <span><strong>{{ $cart->cart_total_price }}</strong></span>
                            </li>
                        </ul>
                        <form action="{{ route('order.checkout')}}" method="GET">
                            @csrf
                            @foreach ($cart as $key => $value) 
                                <input type="hidden" value="{{ $value }}" name="{{ $key }}">
                            @endforeach
                            <button type="submit" class="btn btn-primary btn-lg btn-block w-100">
                                Go to checkout
                            </button>
                        <form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function incrementQuantity(id) {
        var inputElement = document.getElementById('counter-for-' + id);
        inputElement.stepUp();
        updateQuantity(id);
    }

    function decrementQuantity(id) {
        var inputElement = document.getElementById('counter-for-' + id);
        inputElement.stepDown();
        updateQuantity(id);
    }

    function updateQuantity(id) {
        document.getElementById('form-quantity-' + id).submit();
    }
</script>
@endsection