@extends('layouts.app')

@section('content')
<section class="h-100 gradient-custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="my-0">{{ __('Checkout') }}</h6>
                    </div>
                    
                    <div class="col-md-11 mx-auto my-4 px-3">
                        <form class="d-flex flex-column" action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row justify-content-around">
                                <div class="col-md-5 mb-4">
                                    <div class="form-group">
                                        <label for="firstname">First Name:</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="surname">Surname:</label>
                                        <input type="text" class="form-control" id="surname" name="surname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address1">Address 1:</label>
                                        <input type="text" class="form-control" id="address1" name="address1" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="address2">Address 2:</label>
                                        <input type="text" class="form-control" id="address2" name="address2">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone Number:</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{3} [0-9]{3} [0-9]{3}" placeholder="123 456 789" required>
                                    </div>
                                </div>


                                <div class="col-md-5">
                                    <h3>Order Details</h3>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-end fw-normal">
                                                    <i>
                                                        {{ $cart->cart_items_amount }} item(s)
                                                    </i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php( $i = 0 )
                                            @foreach($cart_items as $item)
                                            <tr class="d-flex">
                                                <td class="d-inline-flex align-items-center" style="width:-webkit-fill-available">

                                                    <input type="hidden" value="{{ $item->product->id }}" name="items[{{ $i }}][product_id]">
                                                    <input type="hidden" value="{{ $item->product->name }}" name="items[{{ $i }}][name]">

                                                    <img src="{{ URL::to('/') }}/images/{{$item->product->image->name}}" class="object-fit-cover" width="75" height="75" alt="" />
                                                    <p class="mb-0 ps-2">{{ $item->product->name }}</p>

                                                </td>
                                                <td class="d-inline-flex align-items-center" style="width:-webkit-fill-available">

                                                    <input type="hidden" value="{{ $item->quantity }}" name="items[{{ $i }}][quantity]">

                                                    x {{ $item->quantity }}

                                                </td>
                                                <td class="d-inline-flex align-items-center ps-4" style="width:-webkit-fill-available">
                                                    {{ $item->item_total_price }}
                                                </td>
                                            </tr>

                                            @php( $i++ )
                                            @endforeach
                                        </tbody>
                                        <tfoot class="text-end">
                                            <tr>
                                                <td class="border-0">
                                                    <input type="hidden" value="{{ $cart->cart_total_price }}" name="order_total_price">
                                                    <strong>
                                                        {{ $cart->cart_total_price }}
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <button type="submit" class="ms-auto btn btn-primary">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection