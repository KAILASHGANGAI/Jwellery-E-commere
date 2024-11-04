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
                <form id="product-form" class="product-form" action="{{ route('adminpermissions.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('adminpermissions.index') }}">
                                            <span>← </span>Add Admin Permission</a>
                                    </h4>
                                </span>
                                <button class="search-button float-end" id="submit-btn" type="submit">Save</button>

                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="form-section col-sm-12">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Name" required>
                                </div>
                                <div class="form-section col-sm-6">
                                    <label for="controller">Controller</label>
                                    <input type="text" id="controller" name="controller" value="{{ old('controller') }}"
                                        placeholder="Controller" required>
                                </div>
                                <div class="form-section col-sm-6">
                                    <label for="method">method</label>
                                    <input type="text" id="method" name="method" value="{{ old('method') }}"
                                        placeholder="method" required>
                                </div>
                                <div class="form-section col-sm-12">
                                    <label for="route">route</label>
                                    <input type="text" id="route" name="route" value="{{ old('route') }}"
                                        placeholder="route" required>
                                </div>
                           
                      

                            </div>

                        </div>

                        <div class="col-sm-4">
                            <aside class="">
                                <div class="sidebar-section card p-3">
                                    <h5>Status</h5>
                                    <select id="status" name="status">
                                        <option {{ old('status') == '0' ? 'selected' : '' }} value="0" selected>Inactive</option>
                                        <option {{ old('status') == '1' ? 'selected' : '' }} value="1">Active</option>
                                    </select>
                                </div>
                                <div class="form-section">
                                    <label for="description">Description:</label>
                                    <textarea name="description" class="w-100" id="" placeholder="Description"> {{ old('description') }}</textarea>
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
      //give_all_permission
      document.getElementById('give_all_permission').addEventListener('click', function() {
        const status = this.checked ? '1' : '0';
        document.querySelector('select').value = status;
        document.querySelector('select').dispatchEvent(new Event('change'));
        //CHECK ALL
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
          checkbox.checked = status === '1';
        });
      })    

    </script>
@endsection
