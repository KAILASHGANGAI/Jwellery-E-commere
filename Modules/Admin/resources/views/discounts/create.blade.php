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
                <form id="product-form" class="product-form" action="{{ route('discounts.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('discounts.index') }}">
                                            <span>← </span>Create Discount</a>
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

                                <div class="form- d-fllex col-sm-6">
                                    <label class="my-1" for="type" class="w-25">Discount Type</label> <br>
                                    <select id="type" class="w-100 p-2"name="type" required>
                                        <option {{ old('type') == 'fixed' ? 'selected' : '' }} value=" fixed" selected>Fixed
                                            Amount (Rs)</option>
                                        <option {{ old('type') == 'percentage' ? 'selected' : '' }} value="percentage">
                                            Percentage (%)
                                        </option>
                                    </select>
                                </div>
                                <div class="form-section col-sm-6">
                                    <label for="value">Amount / Percentage</label>
                                    <input type="number" id="value" name="value" value="{{ old('value') }}" required>
                                </div>
                                <hr>
                                <div class="form-section col-sm-12">
                                    <label for="">Discount On</label>
                                </div>

                                <div class="col-sm-12">
                                    <input type="radio" name="discount_on" id="products" value="products"> <label
                                        class="fw-bold" for="products">Products</label>
                                    <input type="radio" class="m-2" name="discount_on" value="collections"
                                        id="collections"> <label class="fw-bold" for="collections">Collections</label>
                                    <input type="radio" class="m-2" name="discount_on" value="tags" id="tags">
                                    <label class="fw-bold" for="tags">Products Tags</label>
                                </div>

                                <div class="lists" style="height: 200px; width: 100%; overflow-y: scroll">

                                </div>
                                <span id="load-more-btn" style="display: none;">Click Me ToLoad More....</span>

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
                                        <label for="start">Starting Date</label>
                                        <input type="date" id="start" name="start_date"
                                            value="{{ old('start_date') }}" required>
                                    </div>
                                    <div class="form-section">
                                        <label for="end_date">Ending Date</label>
                                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                    </div>
                                    <div class="form-section">
                                        <label for="tags">Tags</label>
                                        <textarea name="tags" id="" placeholder="tag1, tag2"> {{ old('tags') }}</textarea>
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
        $(document).ready(function() {
            let currentPage = 1;
            let loading = false;
            let selectedValue = ''; 

            $('input[name="discount_on"]').on('change', function() {
                selectedValue = $(this).val();

                // Clear the lists container
                $('.lists').html('');
                $('#tag-input-container').hide(); // Hide the tag input field by default
                currentPage = 1; // Reset the page number

                // If "tags" is selected, show the tag input and stop the AJAX call
                if (selectedValue === 'tags') {
                    $('#tag-input-container').show(); // Show the tag input container
                    $('#tag-input').focus(); // Focus the tag input field
                    return;
                }

                loadMoreData(); // Initial load of the first page
            });

            // Load More button click event
            $('#load-more-btn').on('click', function() {
                if (!loading) {
                    loadMoreData();
                }
            });

            function loadMoreData() {
                loading = true;
                $.ajax({
                    url: '{{ route('discounts.getLists') }}', // Laravel route
                    type: 'GET',
                    data: {
                        type: selectedValue,
                        page: currentPage // Send the current page number to the backend
                    },
                    success: function(response) {
                        var listsContainer = $('.lists');
                        console.log(response.data);

                        // Loop through the response and append checkboxes dynamically
                        $.each(response.data, function(index, item) {
                            listsContainer.append(
                                '<label><input type="checkbox" name="ids[]" value="' + item.id +
                                '"> ' + item.title + '</label><br>'
                            );
                        });

                        if (response.next_page_url) {
                            $('#load-more-btn').show(); // Show the load more button if more pages exist
                        } else {
                            $('#load-more-btn').hide(); // Hide the button if no more pages
                        }

                        currentPage++; // Increment the page number
                        loading = false;
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        loading = false;
                    }
                });
            }
        });
    </script>
@endsection
