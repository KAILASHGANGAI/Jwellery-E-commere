@extends('admin::layouts.master')
@section('style')
    <style>
        .main-title {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
@section('content')
    <h4 class="main-title">Admin Users List</h4>
    @include('admin::includes.errors')
    <div class="order-controls">
        <div class="order-tabs">
            <span class="order-tab active" onclick="setActiveTab('all')">All</span>
            <span class="order-tab" onclick="setActiveTab('1')">Active</span>
            <span class="order-tab" onclick="setActiveTab('0')">Inactive</span>
            <span class=" ">
                <a class="order-tab bg-success text-decoration-none text-white font-weight-bold"
                    href="{{ route('adminusers.create') }}"><i class="fa-solid fa-plus"></i></a>
            </span>
            <button id="bulk-delete-btn" class="btn text-danger" style="display: none;" onclick="bulkDelete()">Bulk
                <i class="fa fa-trash"></i>
            </button>

        </div>
        <div class="order-actions">

            <input type="text" id="table-search" placeholder="Search ...">
            <button class="search-button" onclick="searchOrders()">Search</button>
            <span title="filter data"><i class="fa-solid fa-filter"></i></span>
            <div class="filter-dropdown">
                <span onclick="toggleFilter()"><i class="fa-solid fa-arrow-up-a-z"></i></span>
                <div id="filterDropdown" class="filter-content">
                    <a href="#" onclick="applySort('name', 'asc')">A -Z</a>
                    <a href="#" onclick="applySort('name', 'desc')">Z -A</a>
                    <a href="#" onclick="applySort('created_at', 'desc')">Newest</a>
                    <a href="#" onclick="applySort('created_at', 'asc')">Oldest</a>
                    <a href="#" onclick="applySort('updated_at', 'desc')">Last Updated</a>
                    <a href="#" onclick="applySort('updated_at', 'asc')">First Updated</a>
                </div>
            </div>
        </div>
    </div>
    <div style="overflow-x: auto;" class="bg-white">
        <table class="order-table" id="orderTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>IsAdmin</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
                <!-- Table body will be populated dynamically -->

            </tbody>
        </table>
    </div>
    <div class="pagination" id="pagination">
        <!-- Pagination buttons will be added here -->
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/js/index.js') }}"></script>
    <script>
        const apiBaseUrl = '{{ route('adminusers.indexAjax') }}'; // Replace with your actual API base URL
        const apiBaseDeleteUrl = '{{ route('adminusers.bulkDelete') }}';
        const ordersPerPage = 10;
        let currentPage = 1;

        // Initialize the page
        function init() {
            initEventListeners();
            fetchOrders();
        }

        // Display orders in the table
        function displayOrders(users) {
       
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';
            // Loop through each order and display it in the table
            if (users.length == 0) {
                tableBody.innerHTML = '<tr><td colspan="8">No Data found.</td></tr>';
            }
            users.forEach(data => {
                var created_at = data.created_at ? data.created_at.split('T')[0] : '';
                console.log(data)
              
                let edit = "{{ route('adminusers.edit', ':id') }}".replace(':id', data.id);
                let destroy = "{{ route('adminusers.destroy', ':id') }}".replace(':id', data.id);           
                const row = `
                        <tr>
                            <td><input type="checkbox" class="checkbox" name="ids[]" value="${data.id}"></td>
                            <td>${data.id}</td>
                            <td><a class="nav-link" href="${edit}">${data.name}</a></td>
                            <td>${data.email}</td>
                            <td>${data.phone}</td>
                            <td>${ data.admin_user_role ? data.admin_user_role.admin_role.name : '-'}</td>
                            <td>${data.is_super_admin == 1 ? 'Yes' : 'No'}</td>
                            <td><span class="status-dot status-${data.status}"></span>${data.status== '1' ? 'Active' : 'Inactive'}</td>
                            <td>${created_at}</td>
                            <td>
                                <form action="${destroy}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn"><i class="fa-solid fa-trash text-danger"></i></button>
                                </form>
                            </td>
                        </tr>
                    `;
                tableBody.innerHTML += row;
            });
        }
        init();
    </script>
@endsection
