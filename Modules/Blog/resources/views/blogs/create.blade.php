@extends('admin::layouts.master')
@section('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor {
            height: 300px;
            /* Set a fixed height for the editor */
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        @include('admin::includes.errors')
        <div class="row">
            <div class="col-sm-12">
                <form id="form" class="product-form" action="{{ route('blogs.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('blogs.index') }}">
                                            <span>← </span>Create Blog</a>
                                    </h4>
                                </span>
                                <button class="search-button float-end" id="submit-btn" type="submit">Save</button>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="form-section col-sm-12">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                                        placeholder="Short sleeve t-shirt" required>
                                </div>

                                <div class="form-section d-fllex col-sm-12">
                                    <label for="code">Meta Description (optional)</label>
                                    <textarea id="description" name="description" rows="2" placeholder="Add Meta description for Seo">{{ old('description') }}</textarea>
                                </div>

                                <div>
                                    <!-- Create the toolbar container -->
                                    <div id="toolbar">
                                        <!-- Font type -->
                                        <select class="ql-font">
                                            <option selected>Sans Serif</option>
                                            <option value="serif">Serif</option>
                                            <option value="monospace">Monospace</option>
                                        </select>

                                        <!-- Font size -->
                                        <select class="ql-size">
                                            <option value="small"></option>
                                            <option selected></option>
                                            <option value="large"></option>
                                            <option value="huge"></option>
                                        </select>

                                        <!-- Text formatting -->
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-strike"></button>

                                        <!-- Blockquote, code -->
                                        <button class="ql-blockquote"></button>
                                        <button class="ql-code-block"></button>

                                        <!-- Headers -->
                                        <select class="ql-header">
                                            <option selected></option>
                                            <option value="1"></option>
                                            <option value="2"></option>
                                            <option value="3"></option>
                                            <option value="4"></option>
                                            <option value="5"></option>
                                            <option value="6"></option>
                                        </select>

                                        <!-- Text alignment -->
                                        <select class="ql-align"></select>

                                        <!-- List types -->
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>

                                        <!-- Indent and outdent -->
                                        <button class="ql-indent" value="-1"></button>
                                        <button class="ql-indent" value="+1"></button>

                                        <!-- Color and background -->
                                        <select class="ql-color"></select>
                                        <select class="ql-background"></select>

                                        <!-- Links, images, and video -->
                                        <button class="ql-link"></button>
                                        <button class="ql-image"></button>
                                        <button class="ql-video"></button>

                                        <!-- Clean formatting -->
                                        <button class="ql-clean"></button>
                                    </div>

                                    <!-- Create the editor container -->
                                    <div id="editor">
                                        <p>Your content goes here...</p>
                                    </div>
                                    <input type="hidden" name="content" id="quill_content">

                                </div>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <aside class="">
                                <div class="sidebar-section card p-2">
                                    <h5>Status</h5>
                                    <select id="status" name="status" required>
                                        <option {{ old('status') == 0 ? 'selected' : '' }} value="0" selected>
                                            Unpublished</option>
                                        <option {{ old('status') == '1' ? 'selected' : '' }} value="1">Published
                                        </option>
                                    </select>

                                </div>
                                <div class="sidebar-section card p-2 mt-1">
                                    <h5>Category</h5>
                                    <select id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                                                       
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-section mt-2">
                                    <h5>Featured Images</h5>
                                    <div id="drop-zone" class="drop-zone">
                                        <input type="file" id="file-input" name="image" accept="image/*"
                                            style="display: none;">
                                        <p>Drag & drop your images here <span id="upload-trigger"></span></p>

                                        <div id="image-preview" class="image-preview"></div>
                                    </div>
                                    <input type="hidden" id="files-data">
                                </div>
                                <div class="sidebar-section card p-3 mt-2">

                                    <div class="form-section">
                                        <label for="">KeyWords </label>
                                        <textarea name="keywords" id="" placeholder="tag1, tag2"> {{ old('keywords') }}</textarea>

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
    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        var quill = new Quill('#editor', {
            modules: {
                toolbar: '#toolbar'
            },
            theme: 'snow'
        });
        // Handle form submission
        document.getElementById('form').onsubmit = function() {
            // Get the editor content as HTML
            var quillContent = quill.root.innerHTML;

            // Set the content into the hidden input field
            document.getElementById('quill_content').value = quillContent;
        };
    </script>
    <script>
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
