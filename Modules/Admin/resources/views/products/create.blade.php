@extends('admin::layouts.master')
@section('style')
@endsection

@section('content')
    <div class="container">
        @include('admin::includes.errors')

        <div class="row">
            <div class="col-sm-12">
                <form id="product-form" class="product-form" action="{{ route('products.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('products.index') }}">
                                            <span>← </span>Add Product</a>

                                    </h4>

                                </span>
                                <button class="search-button float-end" id="submit-btn" type="submit">Save</button>

                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-section">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Short sleeve t-shirt" required>
                            </div>

                            <div class="form-section">
                                <label for="description">Description</label>
                                @include('admin::includes.texteditor')
                                <!-- Create the editor container -->
                                <div id="editor">
                                    {!! old('description') !!}
                                </div>
                                <input type="hidden" id="description" name="description" value="{{ old('description') }}">
                            </div>
                            <hr>
                            <div class="form-section">
                                <h5>Drag and Drop Images</h5>
                                <div id="drop-zone" class="drop-zone">
                                    <input type="file" id="file-input" name="images[]" multiple accept="image/*"
                                        style="display: none;">
                                    <p>Drag & drop your images here or <span id="upload-trigger">click to upload</span></p>

                                    <div id="image-preview" class="image-preview"></div>
                                </div>
                                <input type="hidden" id="files-data" name="">
                            </div>

                            <hr>
                            <div class="form-section">
                                <h5>Pricing</h5>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" value="{{ old('price') }}" id="price"
                                            placeholder="Rs. 0.00" required>

                                    </div>
                                    <div class="col-sm-4">
                                        <label for="compare-price">Compare at price</label>
                                        <input type="text" name="compare_price" value="{{ old('compare_price') }}"
                                            id="compare-price" placeholder="Rs. 0.00">

                                    </div>
                                    <div class="col-sm-4">
                                        <label for="cost">Cost per item</label>
                                        <input type="number" name="cost" value="{{ old('cost') }}" id="cost"
                                            placeholder="Rs. 0.00">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-section">
                                <h3>Variations
                                    <button type="button" class="search-button" id="add-variation">➕</button>
                                </h3>
                                <div class="variation-group">
                                    <div class="variation">
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="option-name-1">Name</label>
                                                <input type="text" name="name[]" value="{{ old('name.0') }}"
                                                    id="option-name-1" placeholder="Color/size/material, etc.">
                                            </div>
                                            <div class="col-3">
                                                <label for="option-sku-1">SKU</label>
                                                <input type="text" name="sku[]" value="{{ old('sku.0') }}"
                                                    id="option-sku-1" placeholder="code">
                                            </div>
                                            <div class="col-3">
                                                <label for="option-barcode-1">Barcode</label>
                                                <input type="number" name="barcode[]" value="{{ old('barcode.0') }}"
                                                    id="option-barcode-1" placeholder="barcode">
                                            </div>
                                            <div class="col-2">
                                                <label for="option-inventory-1">Inventory</label>
                                                <input type="number" name="inventory[]"
                                                    value="{{ old('inventory.0') }}" min="0"
                                                    id="option-inventory-1" placeholder="0">
                                            </div>
                                            <div class="col-1 pb-2">

                                            </div>
                                        </div>

                                        @foreach (old('name', []) as $index => $oldName)
                                            @if ($index == 0)
                                                @continue
                                            @endif
                                            <div class="row variation-row">
                                                <div class="col-3">
                                                    <input type="text" name="name[]"
                                                        value="{{ old('name.' . $index) }}"
                                                        placeholder="Color/size/material, etc.">
                                                    @if ($errors->has('name.' . $index))
                                                        <span
                                                            class="text-danger">{{ $errors->first('name.' . $index) }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" name="sku[]"
                                                        value="{{ old('sku.' . $index) }}" placeholder="code">
                                                    @if ($errors->has('sku.' . $index))
                                                        <span
                                                            class="text-danger">{{ $errors->first('sku.' . $index) }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-3">
                                                    <input type="number" name="barcode[]"
                                                        value="{{ old('barcode.' . $index) }}" placeholder="barcode">
                                                    @if ($errors->has('barcode.' . $index))
                                                        <span
                                                            class="text-danger">{{ $errors->first('barcode.' . $index) }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-2">
                                                    <input type="number" name="inventory[]"
                                                        value="{{ old('inventory.' . $index) }}" min="0"
                                                        placeholder="0">
                                                    @if ($errors->has('inventory.' . $index))
                                                        <span
                                                            class="text-danger">{{ $errors->first('inventory.' . $index) }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-1 pb-2">
                                                    <button type="button" class="remove-variation">x</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <aside class="">
                                <div class="sidebar-section card p-3">
                                    <h5>Product Status</h5>
                                    <select id="status" name="status">
                                        <option {{ old('status') == 'archived' ? 'selected' : '' }} value="archived"
                                            selected>Archived</option>
                                        <option {{ old('status') == 'active' ? 'selected' : '' }} value="active">Active
                                        </option>
                                    </select>
                                    <div>
                                        <input type="checkbox" name="display" checked id="online-store">
                                        <label for="online-store">Online Store</label>

                                    </div>
                                </div>
                                <div class="sidebar-section card p-3 mt-2">
                                    <div class="form-section">
                                        <label for="vendor">Vendor/Brand</label>
                                        <input type="text" id="vendor" name="vendor" value="{{ old('vendor') }}"
                                            placeholder="e.g. Nike">
                                    </div>
                                    <div class="form-section">
                                        <label for="product-type">Product Type</label>
                                        <input type="text" name="product_type" value="{{ old('product_type') }}"
                                            id="product-type" placeholder="Search types">
                                    </div>
                                    <div class="form-section">
                                        <label for="collections">Collections</label>
                                        <input type="text" id="collection-search" name="collections"
                                            value="{{ old('collections') }}" id="collections"
                                            placeholder="Search for collections">
                                        <select id="collection-options" class="form-select" size="5"
                                            style="display: none;"></select>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script>
           document.getElementById('product-form').onsubmit = function() {
            // Get the editor content as HTML
            var quillContent = quill.root.innerHTML;

            // Set the content into the hidden input field
            document.getElementById('description').value = quillContent;
        };

        document.querySelector('#online-store').addEventListener('change', function() {
            const status = this.checked ? 'Active' : 'Draft';
            document.querySelector('select').value = status;
        });

        document.getElementById('add-variation').addEventListener('click', function() {
            const variationGroup = document.querySelector('.variation-group');
            const variationCount = variationGroup.querySelectorAll('.variation').length +
                1; // Calculate the new index

            const newVariation = document.createElement('div');
            newVariation.className = 'variation';
            newVariation.innerHTML = `
                    <div class="row">
                        <div class="col-3">
                            <input type="text" name="name[]" value="{{ old('name.${variationCount}') }}"  placeholder="Color/size/material, etc.">
                        </div>
                        <div class="col-3">
                            <input type="text" name="sku[]" value="{{ old('sku.${variationCount}') }}"  placeholder="code">
                        </div>
                        <div class="col-3">
                            <input type="number" name="barcode[]"  value="{{ old('barcode.${variationCount}') }}" placeholder="barcode">
                        </div>
                        <div class="col-2">
                            <input type="number" name="inventory[]" value="{{ old('inventory.${variationCount}') }}" min="0" placeholder="0">
                        </div>
                        <div class="col-1 pb-2">
                            <button class="remove-variation">x</button>
                        </div>
                    </div>
                `;

            variationGroup.insertBefore(newVariation, document.getElementById('variation'));
        });

        // document.querySelector('.variation-group').addEventListener('click', function(event) {
        //     if (event.target.classList.contains('remove-variation')) {
        //         event.target.closest('.variation').remove();
        //     }
        // });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-variation')) {
                event.preventDefault(); // Prevent default button behavior

                const row = event.target.closest('.variation-row'); // Find the closest row to the clicked button
                if (row) {
                    row.remove(); // Remove only this specific row
                } else {
                    event.target.closest('.variation').remove();
                }
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

        document.getElementById('collection-search').addEventListener('input', function() {
            const query = this.value;
            var url = "{{ route('collections.search', ['search' => 'PLACEHOLDER']) }}";
            if (query.length >= 2) { // Start searching after 2 characters
                let searchUrl = url.replace('PLACEHOLDER', encodeURIComponent(query));

                fetch(searchUrl)
                    .then(response => response.json())
                    .then(data => {
                        //if no data found display no results
                        if (data.length == 0) {
                            document.getElementById('collection-options').style.display = 'none';
                            document.getElementById('collection-search').value = '';
                            alert('No results found');
                            return;
                        }
                        // Display the search results
                        const selectElement = document.getElementById('collection-options');
                        selectElement.innerHTML = ''; // Clear previous results

                        if (data.length > 0) {
                            selectElement.style.display = 'block'; // Show the select dropdown

                            data.forEach(collection => {
                                const option = document.createElement('option');
                                option.value = collection.id; // Store the collection ID as the value
                                option.textContent = collection
                                .title; // Show the collection name in the dropdown
                                selectElement.appendChild(option);
                            });

                            // Handle selection of an option
                            selectElement.addEventListener('change', function() {
                                const selectedOption = selectElement.options[selectElement
                                    .selectedIndex];
                                document.getElementById('collection-search').value = selectedOption
                                    .text; // Set input value to selected option text
                                selectElement.style.display =
                                    'none'; // Hide the dropdown after selection
                            });
                        } else {
                            selectElement.style.display = 'none'; // Hide the select dropdown if no results
                        }
                    });
            } else {
                document.getElementById('collection-options').style.display =
                    'none'; // Hide the dropdown if query length is less than 2
            }
        });
    </script>
@endsection
