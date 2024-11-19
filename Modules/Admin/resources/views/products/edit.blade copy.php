@extends('admin::layouts.master')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
                <form id="product-form" class="product-form" action="{{ route('products.update', $product->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('products.index') }}">
                                            <span>← </span>Edit Product</a>
                                    </h4>
                                </span>
                                <button class="search-button float-end" id="submit-btn" type="submit">Update</button>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-section">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title"
                                    value="{{ old('title', $product->title) }}" placeholder="Short sleeve t-shirt" required>
                            </div>

                            <div class="form-section">
                                <label for="description">Description</label>
                                @include('admin::includes.texteditor')
                                <div id="editor">
                                    {!! old('description', $product->description) !!}
                                </div>
                                <input type="hidden" id="description" name="description"
                                    value="{{ old('description', $product->description) }}">
                            </div>

                            <!-- ... Other product fields ... -->

                            <div class="form-section">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="variation">Has Variations</label>
                                        <div class="form-group d-flex">
                                            <div class="form-check d-flex">
                                                <input class="" type="radio" name="hasvariation" id="no-variations"
                                                    value="0" {{ $product->hasVariation ? '' : 'checked' }}>
                                                <label class="mx-3" for="no-variations">
                                                    No (Simple Product)
                                                </label>
                                            </div>
                                            <div class="form-check d-flex">
                                                <input class="" type="radio" name="hasvariation" id="has-variations"
                                                    value="1" {{ $product->hasVariation ? 'checked' : '' }}>
                                                <label class="mx-3" for="has-variations">
                                                    Yes (Matrix Product)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="variations-section" class="variation-section"
                                style="display: {{ $product->hasVariation ? 'block' : 'none' }};">
                                <h5>Product Options</h5>
                                <div id="options-container"></div>
                                <button type="button" id="add-option" class="add-option-btn mt-3">
                                    <i class="fas fa-plus"></i> Add New Option
                                </button>

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
                                        <tbody id="variants-body"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ... Sidebar content ... -->

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let options = @json(json_decode($product->options) ?? []);
     
        let variants = @json($product->variations ?? []);

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

            // Initialize existing options and variants
            renderOptions();
            renderVariants();

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
                    <button type="button" class="remove-option-btn" onclick="removeOption(${optionIndex})">
                        <i class="fas fa-trash-alt"></i> Remove Option
                    </button>
                </div>
                <div class="option-values">
                    ${option.values.map((value, valueIndex) => `
                            <div class="option-value">
                                <span>${value}</span>
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
            if (options.length === 0) {
                variants = [];
                renderVariants();
                return;
            }

            const newVariants = [{
                name: '',
                price: 0,
                comparePrice: 0,
                sku: '',
                barcode: '',
                stock: 0,
                weight: 0
            }];
            options.forEach(option => {
                const tempVariants = [];
                newVariants.forEach(variant => {
                    option.values.forEach(value => {
                        tempVariants.push({
                            ...variant,
                            name: variant.name ? `${variant.name} / ${value}` : value
                        });
                    });
                });
                newVariants.splice(0, newVariants.length, ...tempVariants);
            });

            // Preserve existing variant data where possible
            variants = newVariants.map(newVariant => {
                const existingVariant = variants.find(v => v.name === newVariant.name);
                return existingVariant || newVariant;
            });

            renderVariants();
        }

        function renderVariants() {
            const tbody = document.getElementById('variants-body');
            tbody.innerHTML = variants.map((variant, index) => `
            <tr>
                <td>${variant.name}</td>
                <td><input type="number" step="0.01" value="${variant.price}" onchange="updateVariant(${index}, 'price', this.value)"></td>
                <td><input type="number" step="0.01" value="${variant.comparePrice}" onchange="updateVariant(${index}, 'comparePrice', this.value)"></td>
                <td><input type="text" value="${variant.sku}" onchange="updateVariant(${index}, 'sku', this.value)"></td>
                <td><input type="text" value="${variant.barcode}" onchange="updateVariant(${index}, 'barcode', this.value)"></td>
                <td><input type="number" value="${variant.stock}" onchange="updateVariant(${index}, 'stock', this.value)"></td>
                <td><input type="number" step="0.01" value="${variant.weight}" onchange="updateVariant(${index}, 'weight', this.value)"></td>
            </tr>
        `).join('');
        }

        function updateVariant(index, field, value) {
            variants[index][field] = value;
        }

        function submitWithVariants() {
            const form = document.querySelector('form');
            const formData = new FormData(form);

            // Add options and their values
            options.forEach((option, index) => {
                formData.append(`options[${index}][name]`, option.name);
                option.values.forEach((value, valueIndex) => {
                    formData.append(`options[${index}][values][${valueIndex}]`, value);
                });
            });

            // Add variants
            variants.forEach((variant, index) => {
                Object.keys(variant).forEach(key => {
                    formData.append(`variants[${index}][${key}]`, variant[key]);
                });
            });

            // Submit the form
            fetch(form.action, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    alert('Product updated successfully!');
                    window.location.href = "{{ route('products.index') }}";
                } else {
                    alert('Error updating product. Please try again.');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        // ... (rest of the script content remains unchanged) ...
    </script>
@endsection
