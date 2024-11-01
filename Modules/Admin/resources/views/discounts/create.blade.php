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
                                    <input type="radio" class="m-2" name="discount_on" value="on_checkout" id="on_checkout">
                                    <label class="fw-bold" for="on_checkout">Order Checkout</label>
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
                                <div class="form-section mt-2">
                                    <h5>Images</h5>
                                    <div id="drop-zone" class="drop-zone">
                                        <input type="file" id="file-input" name="images" accept="image/*"
                                            style="display: none;">
                                        <p>Drag & drop your images here <span id="upload-trigger"></span></p>

                                        <div id="image-preview" class="image-preview"></div>
                                    </div>
                                    <input type="hidden" id="files-data">
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

        document.addEventListener('DOMContentLoaded', () => {
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('file-input');
            const imagePreview = document.getElementById('image-preview');
            const uploadTrigger = document.getElementById('upload-trigger');
            const filesDataInput = document.getElementById('files-data');

            // Trigger file input click when the user clicks on the drop zone or upload text
            dropZone.addEventListener('click', () => {
                fileInput.click();
            });

            // Trigger file input click when the user clicks on the upload text
            uploadTrigger.addEventListener('click', () => {
                fileInput.click();
            });

            // Handle file input change event
            fileInput.addEventListener('change', handleFiles);

            // Handle drag and drop events
            dropZone.addEventListener('dragover', (event) => {
                event.preventDefault();
                event.stopPropagation();
                dropZone.classList.add('dragging');
            });

            dropZone.addEventListener('dragleave', (event) => {
                event.preventDefault();
                event.stopPropagation();
                dropZone.classList.remove('dragging');
            });

            dropZone.addEventListener('drop', (event) => {
                event.preventDefault();
                event.stopPropagation();
                dropZone.classList.remove('dragging');
                const files = event.dataTransfer.files;
                fileInput.files = files;
                handleFiles({
                    target: {
                        files
                    }
                });
            });

            function handleFiles(event) {
                const files = event.target.files;
                imagePreview.innerHTML = '';
                const fileNames = [];
                for (const file of files) {
                    if (file.type.startsWith('image/')) {
                        const container = document.createElement('div');
                        container.classList.add('image-container');

                        const img = document.createElement('img');
                        img.classList.add('preview-img');
                        img.file = file;
                        img.addEventListener('click', (event) => {
                            event.stopPropagation(); // Prevent redirection
                        });
                        container.appendChild(img);

                        const removeBtn = document.createElement('button');
                        removeBtn.classList.add('remove-img');
                        removeBtn.textContent = '×';
                        removeBtn.addEventListener('click', () => {
                            container.remove();
                            // updateFilesData();
                        });
                        container.appendChild(removeBtn);

                        imagePreview.appendChild(container);

                        const reader = new FileReader();
                        reader.onload = ((aImg) => (e) => {
                            aImg.src = e.target.result;
                        })(img);
                        reader.readAsDataURL(file);

                        fileNames.push(file.name);
                    } else {
                        alert('Only image files are allowed.');
                    }
                }

                // Update hidden input with file names
                filesDataInput.value = fileNames.join(',');
            }

            // Initialize SortableJS on the image preview container
            new Sortable(imagePreview, {
                animation: 150,
                onStart: function(evt) {
                    // Optionally disable dragging during reordering if necessary
                    evt.from.classList.add('sorting');
                },
                onEnd: function() {
                    // Enable dragging after reordering
                    imagePreview.classList.remove('sorting');
                    // updateFilesData();
                }
            });

            function updateFilesData() {
                const images = Array.from(imagePreview.querySelectorAll('.preview-img'));
                const fileNames = images.map(img => img.file.name);
                filesDataInput.value = fileNames.join(',');
            }
        });
    </script>
@endsection
