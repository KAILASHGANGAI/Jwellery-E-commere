@extends('layouts.app')
@section('style')
    <style>
        .order-map {
            height: 300px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto my-4">
                <h1 class="mb-4 text-success">Checkout Success</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-check-circle text-success me-2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            Order #{{ $_GET['OrderID'] }}
                        </h5>
                        <p class="card-text">Thank you {{ Auth::user()->name }}!</p>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Order Updates</h5>
                        <p class="card-text">You will receive order and shipping updates via email.</p>
                        <dl class="row">
                            <dt class="col-sm-3">Contact</dt>
                            <dd class="col-sm-9">james@example.com</dd>
                            <dt class="col-sm-3">Address</dt>
                            <dd class="col-sm-9">James Smith<br>7535 N May Rd<br>Mount Morris, MI 48458</dd>
                            <dt class="col-sm-3">Payment</dt>
                            <dd class="col-sm-9">Check payments</dd>
                        </dl>
                    </div>
                </div>
                <p>
                    <small>Need Help? <a href="#">Contact Us</a></small>
                </p>
                <button class="btn btn-dark">Continue Shopping</button>
            </div>
          
        </div>
    </div>
@endsection

