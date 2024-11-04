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
                <form id="product-form" class="product-form" action="{{ route('adminusers.update', $data->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="header d-flex">
                                <span class="back-button">
                                    <h4 class="main-title ">
                                        <a class="text-decoration-none text-dark" href="{{ route('adminusers.index') }}">
                                            <span>← </span>Add Admin Users</a>
                                    </h4>
                                </span>
                                <button class="search-button float-end" id="submit-btn" type="submit">Save</button>

                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="form-section col-sm-12">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $data->name) }}"
                                        placeholder="Name" required>
                                </div>

                                <div class="form-section col-sm-6">
                                    <label for="phone">phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $data->phone) }}"
                                        placeholder="phone" required>
                                </div>

                                <div class="form-section col-sm-6">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $data->email) }}"
                                        placeholder="Email" required>
                                </div>

                                <div class="form-section col-sm-6">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" value="{{ old('password') }}"
                                        placeholder="Password">
                                </div>

                                <div class="form-section col-sm-6">
                                    <label for="password">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}" placeholder="Confirm Password" >
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-4">
                            <aside class="">
                                <div class="sidebar-section card p-3">
                                    <h5>Status</h5>
                                    <select id="status" name="status">
                                        <option {{ old('status')?? $data->status == '0' ? 'selected' : '' }} value="0" selected>Inactive</option>
                                        <option {{ old('status') ?? $data->status == '1' ? 'selected' : '' }} value="1">Active</option>
                                    </select>
                                </div>
                                <div class="sidebar-section card p-2 mt-1">
                                    <h5>Role</h5>
                                    <select id="role" name="role">
                                        <option >Choose Role</option>
                                        @foreach ($roles as $role)
                                            <option {{ old('role', @$data->adminUserRole->admin_role_id) == $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="sidebar-section  p-2 mt-1">
                                    <input type="checkbox" name="is_super_admin" {{ old('is_super_admin', $data->is_super_admin) ? 'checked' : '' }} value="1" id="is_super_admin" >
                                    <label for="is_super_admin">Is Super Admin</label>
                                </div>

                            </aside>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

@section('script')
@endsection
