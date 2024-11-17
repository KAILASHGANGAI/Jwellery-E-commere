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

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="variation">Has Variations</label>
                                        <div class="form-group d-flex">
                                            <div class="form-check d-flex">
                                                <input class="" type="radio" name="hasvariation" id="no-variations"
                                                    checked value="0">
                                                <label class="mx-3" for="no-variations">
                                                    No (Simple Product)
                                                </label>
                                            </div>
                                            <div class="form-check d-flex">
                                                <input class="" type="radio" name="hasvariation" id="has-variations"
                                                    value="1">
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
                        <div class="col-sm-12">
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
                                    {{ old('variants') }}
                                    <tbody id="variants-body">
                                        @if (old('variants'))
                                            @foreach (old('variants') as $variant)
                                                <tr>
                                                    <td><input type="text" name="variants[{{ $loop->index }}][name]"
                                                            value="{{ $variant['name'] }}"></td>
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

            function toggleVariationOptions() {
                variationsSection.style.display = hasVariationsRadio.checked ? 'block' : 'none';
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



        // ... (rest of the script content remains unchanged) ...
    </script>
@endsection
