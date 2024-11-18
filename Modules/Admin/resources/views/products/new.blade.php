@extends('admin::layouts.master')
@section('style')
    <style>
        input[type="radio"] {
            width: 20px;
        }

        .variation-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .option {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .option-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .option-name {
            font-weight: bold;
            font-size: 1.1em;
        }

        .option-values {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .option-value {
            background-color: #e9ecef;
            border-radius: 20px;
            padding: 5px 15px;
            display: flex;
            align-items: center;
        }

        .remove-value,
        .remove-option-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 0;
            font-size: 1.1em;
        }

        .remove-value {
            margin-left: 5px;
        }

        .add-value-btn,
        .remove-option-btn {
            background: none;
            border: 1px solid #007bff;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .add-value-btn:hover,
        .remove-option-btn:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .remove-option-btn {
            border-color: #dc3545;
            color: #dc3545;
        }

        .remove-option-btn:hover {
            background-color: #dc3545;
        }

        .add-option-btn {
            background-color: #28a745;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-option-btn:hover {
            background-color: #218838;
        }

        .variants-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
        }

        .variants-table th,
        .variants-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }

        .variants-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .variants-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .variants-table input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .option-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .remove-option-btn {
                margin-top: 10px;
            }

            .variants-table {
                font-size: 0.9em;
            }
        }

        .upload-container {
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
            gap: 5px;
        }

        .preview-item {
            position: relative;
            aspect-ratio: 1;
            cursor: move;
        }

        .preview-item img,
        .preview-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 14px;
            cursor: pointer;
            display: none;
        }

        .preview-item:hover .remove-btn {
            display: block;
        }

        .add-more {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px dashed #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-more::before {
            content: '+';
            font-size: 40px;
            color: #ccc;
        }

        .dragging {
            opacity: 0.5;
        }
    </style>
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

                            <div class="form-section">
                                <div class="upload-container">
                                    <p>Select Files to Upload </p>
                                    <input type="file" name="images[]" id="fileInput" multiple accept="image/*,video/*"
                                        style="display: none;">
                                    <div class="preview-container" id="previewContainer"></div>
                                </div>
                            </div>


                            <div class="form-section">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="variation">Has Variations</label>
                                        <div class="form-group d-flex">
                                            <div class="form-check d-flex">
                                                <input class="" {{ old('hasVariation') == '0' ? 'checked' : '' }}
                                                    type="radio" name="hasVariation" id="no-variations" checked
                                                    value="0">
                                                <label class="mx-3" for="no-variations">
                                                    No (Simple Product)
                                                </label>
                                            </div>
                                            <div class="form-check d-flex">
                                                <input class="" {{ old('hasVariation') == '1' ? 'checked' : '' }}
                                                    type="radio" name="hasVariation" id="has-variations" value="1">
                                                <label class="mx-3" for="has-variations">
                                                    Yes (Matrix Product)
                                                </label>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            {{-- has varinations --}}

                            <div id="variations-section" class="variation-section" style="display: none;">
                                <h5>Product Options</h5>
                                <div id="options-container">

                                </div>
                                <button type="button" id="add-option" class="add-option-btn mt-3">
                                    <i class="fas fa-plus"></i> Add New Option
                                </button>


                            </div>
                            {{-- has no variation --}}
                            <div class="variation-section" id="no-variations-section" style="display: none">
                                <div class="row">
                                    <div class="col-sm-4 mt-2">
                                        <label for="price">Price</label>
                                        <input class="form-control" type="number" id="price" name="variants[0][price]"
                                            value="{{ @old('variants')[0]['price'] }}" placeholder="price">
                                    </div>
                                    <div class="col-sm-4 mt-2">
                                        <label for="compare-price">Compare at price</label>
                                        <input class="form-control" type="number" id="compare-price"
                                            name="variants[0][compare_price]"
                                            value="{{ @old('variants')[0]['compare_price'] }}"
                                            placeholder="Compare at price">
                                    </div>
                                    <div class="col-sm-4 mt-2">
                                        <label for="sku">SKU</label>
                                        <input class="form-control" type="text" id="sku" name="variants[0][sku]"
                                            value="{{ @old('variants')[0]['sku'] }}" placeholder="SKU">
                                    </div>
                                    <div class="col-sm-4 mt-2">
                                        <label for="barcode">Barcode</label>
                                        <input class="form-control" type="number" id="barcode"
                                            name="variants[0][barcode]" value="{{ @old('variants')[0]['barcode'] }}"
                                            placeholder="Barcode">
                                    </div>
                                    <div class="col-sm-4 mt-2">
                                        <label for="stock">Stock</label>
                                        <input class="form-control" type="number" id="stock"
                                            name="variants[0][stock]" value="{{ @old('variants')[0]['stock'] }}"
                                            placeholder="Stock">
                                    </div>

                                    <div class="col-sm-4 mt-2">
                                        <label for="weight">Weight</label>
                                        <input class="form-control" type="number" id="weight"
                                            name="variants[0][weight]" value="{{ @old('variants')[0]['weight'] }}"
                                            placeholder="Weight">
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
                        <div class="col-sm-12 " id="variants-table">
                            <h5 class="mt-4">Variants</h5>
                            <div class="table-responsive">
                                <table id="variants-table" class="variants-table">
                                    <thead>
                                        <tr>
                                            <th>Variant</th>
                                            <th>Price</th>
                                            <th>Compare Price</th>
                                            <th>SKU</th>
                                            <th>Barcode</th>
                                            <th>Stock</th>
                                            <th>Weight</th>
                                        </tr>
                                    </thead>

                                    <tbody id="variants-body">
                                        @if (old('variants'))
                                            @foreach (old('variants') as $variant)
                                                <tr>
                                                    <td><input type="text" name="variants[{{ $loop->index }}][name]"
                                                            value="{{ $variant['name'] ?? '' }}"></td>
                                                    <td><input type="number" name="variants[{{ $loop->index }}][price]"
                                                            step="0.01" value="{{ $variant['price'] }}"></td>
                                                    <td><input type="number"
                                                            name="variants[{{ $loop->index }}][compare_price]"
                                                            step="0.01" value="{{ $variant['compare_price'] }}"></td>
                                                    <td><input type="text" name="variants[{{ $loop->index }}][sku]"
                                                            value="{{ $variant['sku'] }}"></td>
                                                    <td><input type="text"
                                                            name="variants[{{ $loop->index }}][barcode]"
                                                            value="{{ $variant['barcode'] }}"></td>
                                                    <td><input type="number" name="variants[{{ $loop->index }}][stock]"
                                                            value="{{ $variant['stock'] }}"></td>
                                                    <td><input type="number"
                                                            name="variants[{{ $loop->index }}][weight]" step="0.01"
                                                            value="{{ $variant['weight'] }}"></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endSection



@section('script')
    <script>
        let options = [];
        let variants = [];

        document.addEventListener('DOMContentLoaded', function() {
            const hasVariationsRadio = document.getElementById('has-variations');
            const noVariationsRadio = document.getElementById('no-variations');
            const variationsSection = document.getElementById('variations-section');
            const variantsTable = document.getElementById('variants-table');
            const novarinationsSection = document.getElementById('no-variations-section');

            function toggleVariationOptions() {
                variationsSection.style.display = hasVariationsRadio.checked ? 'block' : 'none';
                variantsTable.style.display = hasVariationsRadio.checked ? 'block' : 'none';
                novarinationsSection.style.display = noVariationsRadio.checked ? 'block' : 'none';
            }

            hasVariationsRadio.addEventListener('change', toggleVariationOptions);
            noVariationsRadio.addEventListener('change', toggleVariationOptions);



            // Initial toggle
            toggleVariationOptions();

            document.getElementById('add-option').addEventListener('click', addOption);

            // Add event listener to the form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                if (hasVariationsRadio.checked) {
                    e.preventDefault(); // Prevent the form from submitting
                    submitWithVariants(); // Custom submission with variants
                }
            });
        });

        function addOption() {
            const optionName = prompt("Enter option name (e.g., Color, Size):");
            if (optionName) {
                options.push({
                    name: optionName,
                    values: []
                });
                renderOptions();
            }
        }

        function addOptionValue(optionIndex) {
            const value = prompt(`Enter a value for ${options[optionIndex].name}:`);
            if (value) {
                options[optionIndex].values.push(value);
                renderOptions();
                generateVariants();
            }
        }

        function removeOption(optionIndex) {
            options.splice(optionIndex, 1);
            renderOptions();
            generateVariants();
        }

        function removeOptionValue(optionIndex, valueIndex) {
            options[optionIndex].values.splice(valueIndex, 1);
            renderOptions();
            generateVariants();
        }

        function renderOptions() {
            const container = document.getElementById('options-container');
            container.innerHTML = options.map((option, optionIndex) => `
            <div class="option">
                <div class="option-header">
                    <span class="option-name">${option.name}</span>
                    <input type="hidden" name="options[${optionIndex}][name]" class="option-name-input" value="${option.name}" >
                    <button type="button" class="remove-option-btn" onclick="removeOption(${optionIndex})">
                        <i class="fas fa-trash-alt"></i> Remove Option
                    </button>
                </div>
                <div class="option-values">
                    ${option.values.map((value, valueIndex) => `
                                        <div class="option-value">
                                            <span>${value}</span>
                                            <input type="hidden" name="options[${optionIndex}][values][${valueIndex}]" value="${value}">
                                            <button type="button" class="remove-value" onclick="removeOptionValue(${optionIndex}, ${valueIndex})">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    `).join('')}
                </div>
                <button type="button" class="add-value-btn mt-2" onclick="addOptionValue(${optionIndex})">
                    <i class="fas fa-plus"></i> Add Value
                </button>
            </div>
        `).join('');
        }

        function generateVariants() {
            variants = [{
                name: '',
                price: 0,
                comparePrice: 0,
                sku: '',
                barcode: '',
                stock: 0,
                weight: 0
            }];
            options.forEach(option => {
                const newVariants = [];
                variants.forEach(variant => {
                    option.values.forEach(value => {
                        newVariants.push({
                            ...variant,
                            name: variant.name ? `${variant.name} / ${value}` : value
                        });
                    });
                });
                variants = newVariants;
            });
            renderVariants();
        }

        function renderVariants() {
            const tbody = document.getElementById('variants-body');
            tbody.innerHTML = variants.map((variant, index) => `
            <tr>
                <td>${variant.name} <input type="hidden" name="variants[${index}][name]" value="${variant.name}"> </td>
                <td><input type="number" name="variants[${index}][price]" step="0.01" value="${variant.price}" onchange="updateVariant(${index}, 'price', this.value)"></td>
                <td><input type="number" name="variants[${index}][compare_price]" step="0.01" value="${variant.comparePrice}" onchange="updateVariant(${index}, 'comparePrice', this.value)"></td>
                <td><input type="text" name="variants[${index}][sku]" value="${variant.sku}" onchange="updateVariant(${index}, 'sku', this.value)"></td>
                <td><input type="text" name="variants[${index}][barcode]" value="${variant.barcode}" onchange="updateVariant(${index}, 'barcode', this.value)"></td>
                <td><input type="number" name="variants[${index}][stock]" value="${variant.stock}" onchange="updateVariant(${index}, 'stock', this.value)"></td>
                <td><input type="number" name="variants[${index}][weight]" step="0.01" value="${variant.weight}" onchange="updateVariant(${index}, 'weight', this.value)"></td>
            </tr>
        `).join('');
        }

        function updateVariant(index, field, value) {
            variants[index][field] = value;
        }


        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');

        fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect(e) {
            handleFiles(e.target.files);
        }

        function handleFiles(files) {
            for (const file of files) {
                if (file.type.startsWith('image/') || file.type.startsWith('video/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const previewItem = createPreviewItem(e.target.result, file.type);
                        previewContainer.insertBefore(previewItem, previewContainer.lastElementChild);
                    };
                    reader.readAsDataURL(file);
                }
            }
            ensureAddMoreButton();
        }

        function createPreviewItem(src, fileType) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.draggable = true;

            const media = fileType.startsWith('image/') ?
                document.createElement('img') :
                document.createElement('video');

            media.src = src;
            if (media.tagName === 'VIDEO') {
                media.setAttribute('controls', '');
            }

            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.textContent = '×';
            removeBtn.onclick = (e) => {
                e.stopPropagation();
                previewItem.remove();
            };

            previewItem.appendChild(media);
            previewItem.appendChild(removeBtn);

            previewItem.addEventListener('dragstart', dragStart);
            previewItem.addEventListener('dragover', dragOver);
            previewItem.addEventListener('dragleave', dragLeave);
            previewItem.addEventListener('drop', drop);
            previewItem.addEventListener('dragend', dragEnd);

            return previewItem;
        }

        function ensureAddMoreButton() {
            let addMore = previewContainer.querySelector('.add-more');
            if (!addMore) {
                addMore = document.createElement('div');
                addMore.className = 'preview-item add-more';
                addMore.onclick = () => fileInput.click();
                previewContainer.appendChild(addMore);
            }
        }

        function dragStart(e) {
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', this.innerHTML);
        }

        function dragOver(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        }

        function dragLeave(e) {
            this.classList.remove('drag-over');
        }

        function drop(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            const draggedElement = document.querySelector('.dragging');
            if (this !== draggedElement) {
                const allItems = [...previewContainer.querySelectorAll('.preview-item:not(.add-more)')];
                const draggedIndex = allItems.indexOf(draggedElement);
                const dropIndex = allItems.indexOf(this);
                if (draggedIndex < dropIndex) {
                    this.parentNode.insertBefore(draggedElement, this.nextSibling);
                } else {
                    this.parentNode.insertBefore(draggedElement, this);
                }
            }
        }

        function dragEnd(e) {
            this.classList.remove('dragging');
        }

        ensureAddMoreButton();
        // ... (rest of the script content remains unchanged) ...
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
