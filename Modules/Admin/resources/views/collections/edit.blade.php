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
                <form id="product-form" class="product-form" action="{{ route('collections.update', $data->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('collections.index') }}">
                                            <span>← </span>Edit Collection</a>

                                    </h4>

                                </span>
                                <button class="search-button float-end" id="submit-btn" type="submit">Save</button>

                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-section">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title"
                                    value="{{ $data->title ?? old('title') }}" placeholder="Short sleeve t-shirt" required>
                            </div>
                            <div class="form-section">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" value="{{ $data->slug ?? old('slug') }}"
                                    placeholder="short-sleeve-t-shirt">
                            </div>
                            <div class="form-section">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4" placeholder="Add a description">{{ $data->description ?? old('description') }}</textarea>
                            </div>



                        </div>

                        <div class="col-sm-4">
                            <aside class="">
                                <div class="sidebar-section card p-3">
                                    <h5>Status</h5>
                                    <select id="status" name="status">
                                        <option {{ old('status') == 'archived' ? 'selected' : '' }} value=" archived"
                                            selected>Archived</option>
                                        <option {{ old('status') == 'active' ? 'selected' : '' }} value="active">Active
                                        </option>
                                    </select>
                                    <div>
                                        <input type="checkbox" name="display" {{ $data->display ? 'checked' : '' }}
                                            id="online-store">
                                        <label for="online-store">Online Store</label>

                                    </div>
                                </div>
                                <div class="form-section mt-2">
                                    <h5>Images</h5>
                                    <div id="drop-zone" class="drop-zone">
                                        <input type="file" id="file-input" name="images" accept="image/*"
                                            style="display: none;">
                                        <p>Drag & drop your images here <span id="upload-trigger"></span></p>

                                        <div id="image-preview" class="image-preview"> <img
                                                src="{{ asset($data->file_path ?? '') }}" height="60" alt="">
                                        </div>
                                    </div>
                                    <input type="hidden" id="files-data">
                                </div>
                                <div class="sidebar-section card p-3 mt-2">

                                    <div class="form-section">
                                        <label for="collections">Parent Collections</label>
                                        <input type="text" id="collection-search" name="collections"
                                            value="{{ ($data->collection_id !=0 ? $data->parent->title : '') ?? old('collections') }}" id="collections"
                                            placeholder="Search for collections">
                                            <select id="collection-options" class="form-select" size="5" style="display: none;"></select>

                                    </div>
                                    <div class="form-section">
                                        <label for="tags">Tags</label>
                                        <textarea name="tags" id="" placeholder="tag1, tag2"> {{ $data->tags ?? old('tags') }}</textarea>
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
        document.querySelector('#online-store').addEventListener('change', function() {
            const status = this.checked ? 'Active' : 'Draft';
            document.querySelector('select').value = status;
        });

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
                                option.textContent = collection.title; // Show the collection name in the dropdown
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
