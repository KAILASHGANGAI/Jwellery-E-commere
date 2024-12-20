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
                <form id="product-form" class="product-form" action="{{ route('giftcards.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('giftcards.index') }}">
                                            <span>← </span>Create Gift Card</a>
                                    </h4>
                                </span>
                                <button class="search-button float-end" id="submit-btn" type="submit">Save</button>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="form-section col-sm-12">
                                    <label for="title">Name (Title)</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Short sleeve t-shirt" required>
                                </div>

                                <div class="form-section d-fllex col-sm-6">
                                    <label for="code">code</label>
                                    <input type="text" id="code" name="code" value="{{ old('code') }}" required>
                                </div>
                                <div class="form-section col-sm-6">
                                    <label for="value">Amount (Rs)</label>
                                    <input type="number" id="value" name="value" value="{{ old('value') }}" required>
                                </div>
                                                        
                                <div class="form-section col-sm-12">
                                    <label for="title">Customer</label>
                                    <input type="hidden" id="customer_id" name="customer_id" value="{{ old('customer_id') }}">
                                    <input type="text" id="customers" name="customer" value="{{ old('customer') }}"
                                        placeholder="Short sleeve t-shirt" required>
                                        <select id="customer-options" class="form-select" size="5" style="display: none;"></select>

                                </div>
                             
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <aside class="">
                                <div class="sidebar-section card p-3">
                                    <h5>Status</h5>
                                    <select id="status" name="status"  required>
                                        <option {{ old('status') == 'archived' ? 'selected' : '' }} value=" archived"
                                            selected>Archived</option>
                                        <option {{ old('status') == 'active' ? 'selected' : '' }} value="active">Active
                                        </option>
                                    </select>

                                </div>
                                
                                <div class="sidebar-section card p-3 mt-2">

                                    <div class="form-section">
                                        <label for="expiry_date">Expriry Date</label>
                                        <input type="date" id="expiry_date" name="expiry_date"
                                            value="{{ old('expiry_date') }}" required>
                                    </div>
                                   
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
            document.getElementById('customers').addEventListener('input', function() {
            const query = this.value;
            var url = "{{ route('customers.search', ['search' => 'PLACEHOLDER']) }}";
            if (query.length >= 2) { 
                let searchUrl = url.replace('PLACEHOLDER', encodeURIComponent(query));

                fetch(searchUrl)
                    .then(response => response.json())
                    .then(data => {
                        //if no data found display no results
                        if (data.length == 0) {
                            document.getElementById('customer-options').style.display = 'none';
                            document.getElementById('customers').value = '';
                            alert('No results found');
                            return;
                        }
                        // Display the search results
                        const selectElement = document.getElementById('customer-options');
                        selectElement.innerHTML = ''; 

                        if (data.length > 0) {
                            selectElement.style.display = 'block';

                            data.forEach(customer => {
                                const option = document.createElement('option');
                                option.value = customer.id; 
                                option.textContent = customer.name; 
                                selectElement.appendChild(option);
                            });

                            // Handle selection of an option
                            selectElement.addEventListener('change', function() {
                                const selectedOption = selectElement.options[selectElement.selectedIndex];
                                console.log(selectedOption.text);
                                console.log(selectedOption.value);
                                
                                document.getElementById('customers').value = selectedOption.text; 
                                selectElement.style.display ='none'; 
                                document.getElementById('customer_id').value = selectedOption.value; 
                                selectElement.style.display ='none'; 
                            });
                        } else {
                            selectElement.style.display = 'none'; 
                        }
                    });
            } else {
                document.getElementById('customer-options').style.display ='none'; 
            }
        });
    </script>
@endsection
