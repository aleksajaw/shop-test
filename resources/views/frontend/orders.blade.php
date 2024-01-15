@extends('layouts.app')

@section('content')
<section class="h-100 gradient-custom">
    <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-12">
                <div class="card mb-4">

                    <div class="card-header py-3">
                        <h5 class="mb-0">{{ _('Orders') }}</h5>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        Order id
                                    </th>
                                    <th>
                                        Client
                                    </th>
                                    <th>
                                        Address
                                    </th>
                                    <th>
                                        Contact
                                    </th>
                                    <th>
                                        Order items
                                    </th>
                                    <th>
                                        Order total price
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)

                                    <tr>
                                        <td>
                                            {{ $order->id }}
                                        </td>
                                        <td>
                                            {{ $order->client->firstname }} {{ $order->client->surname }}
                                        </td>
                                        <td>
                                            {{ $order->client->address1 }}<br>
                                            {{ $order->client->address2 }}
                                        </td>
                                        <td>
                                            {{ $order->client->phone }}<br>
                                            {{ $order->client->email }}
                                        </td>
                                        <td>
                                            <ul class="list-group">
                                                @foreach ($order->items as $item)
                                                    <li class="list-group-item">
                                                        {{ $item->product->name }}
                                                        &nbsp;&nbsp;&nbsp;{{ $item->product->price }} 
                                                        &nbsp;&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;
                                                        {{ $item->quantity }}
                                                        &nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;
                                                        {{ $item->product->price * $item->quantity }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $order->order_total_price }}
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                                <tfoot class="text-end">
                                    <tr>
                                        <td class="border-0">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection