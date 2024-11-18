@extends('admin::layouts.master')
@section('style')
    <style>

    </style>
@endsection

@section('content')
    <div class="container">
        @include('admin::includes.errors')
        <div class="row">
            <div class="col-sm-12">
                <form id="product-form" class="product-form" action="{{ route('shipping.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('shipping.index') }}">
                                            <span>← </span>Create Shipping area</a>
                                    </h4>
                                </span>
                                <button class="search-button float-end" id="submit-btn" type="submit">Save</button>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="form-section col-sm-12">
                                    <label for="title">Name (Title)</label>
                                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                                        placeholder="Short sleeve t-shirt" required>
                                </div>
                                <div class="form-section col-sm-4">
                                    <label for="country">Country</label>
                                    <input type="text" id="country" name="country" value="{{ old('country') }}"
                                        placeholder="Country">
                                </div>
                                <div class="form-section col-sm-4">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" value="{{ old('state') }}"
                                        placeholder="state">
                                </div>
                                <div class="form-section col-sm-4">
                                    <label for="city">city</label>
                                    <input type="text" id="city" name="city" value="{{ old('city') }}"
                                        placeholder="city">
                                </div>
                                <div class="form-section col-sm-4">
                                    <label for="zipcode">zipCode (Postal Code)</label>
                                    <input type="text" id="zipcode" name="zipcode" value="{{ old('zipcode') }}"
                                        placeholder="zipcode">
                                </div>
                                <div class="form-section col-sm-4">
                                    <label for="amount">Amount</label>
                                    <input type="text" id="amount" name="amount" value="{{ old('amount') }}"
                                        placeholder="amount" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <aside class="">
                                <div class="sidebar-section card p-3">
                                    <h5>Status</h5>
                                    <select id="status" name="status"  required>
                                        <option {{ old('status') == '0' ? 'selected' : '' }} value="0"
                                            selected>Archived</option>
                                        <option {{ old('status') == '1' ? 'selected' : '' }} value="1">Active
                                        </option>
                                    </select>

                                </div>
                                
                            </aside>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endSection

@section('script')
 
@endsection
