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
            <div class="col-md-8 max-auto my-4">
                <h1 class="mb-4 text-danger">Checkout failed ! Try Again</h1>
            
          
                <p>
                    <small>Need Help? <a href="#">Contact Us</a></small>
                </p>
                <button class="btn btn-dark">Continue Shopping</button>
            </div>
         
        </div>
    </div>
@endsection
@section('scripts')

@endsection
