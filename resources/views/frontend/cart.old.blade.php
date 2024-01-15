@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cart') }}</div>
                <div class="card-body">
                    <div class="">
                        Hello World, we are in the cart now!
                        <div class="row">
                            <div class="px-0 card h-100">
                                <div class="card-body flex-row d-flex justify-content-between">
                                    <a class="text-decoration-none d-flex flex-row text-body align-items-center" href="">            
                                        <img width=100 height=100 class="card-img-top" src="">
                                        <div class="">
                                            <h5 class="card-title mt-1">
                                                Name
                                            </h5>
                                        </div>
                                    </a>
                                    <div class="text-center mt-3">
                                        <div class="card-text text-end">
                                            <h6>Price</h6>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-block">
                                            <small>Delete from cart</small>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection