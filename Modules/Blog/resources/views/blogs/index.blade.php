@extends('admin::layouts.master')
@section('style')
    <style>
        .main-title {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
@section('content')
    <h4 class="main-title">Blogs List</h4>
    @include('admin::includes.errors')
    <div class="order-controls">
        <div class="order-tabs">
            <span class="order-tab active" onclick="setActiveTab('all')">All</span>
            <span class="order-tab" onclick="setActiveTab('1')">Published</span>
            <span class="order-tab" onclick="setActiveTab('2')">Unpublished</span>
            <span class=" ">
                <a class="order-tab bg-success text-decoration-none text-white font-weight-bold"
                    href="{{ route('blogs.create') }}">+</a>
            </span>
            <button id="bulk-delete-btn" class="btn text-danger" style="display: none;" onclick="bulkDelete()">Bulk
                <i class="fa fa-trash"></i>
            </button>

        </div>
        <div class="order-actions">

            <input type="text" id="table-search" placeholder="Search ...">
            <button class="search-button" onclick="searchOrders()">Search</button>
            <span>☰</span>
            <span>⋮</span>
            <div class="filter-dropdown">
                <span onclick="toggleFilter()">↓</span>
                <div id="filterDropdown" class="filter-content">
                    <a href="#" onclick="applySort('title', 'asc')">A -Z</a>
                    <a href="#" onclick="applySort('title', 'desc')">Z -A</a>
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
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>created At</th>
                    <th>updated At</th>
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
        const apiBaseUrl = '{{ route('blogs.indexAjax') }}'; // Replace with your actual API base URL
        const apiBaseDeleteUrl = '{{ route('blogs.bulkDelete') }}';
        const ordersPerPage = 10;
        let currentPage = 1;

        // Initialize the page
        function init() {
            initEventListeners();
            fetchOrders();
        }

        // Display orders in the table
        function displayOrders(orders) {
            
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';
            // Loop through each order and display it in the table
            if (orders.length == 0) {
                tableBody.innerHTML = '<tr><td colspan="8">No Data found.</td></tr>';
            }
            orders.forEach(data => {
              
                let edit = "{{ route('blogs.edit', ':id') }}".replace(':id', data.id);
                let destroy = "{{ route('blogs.destroy', ':id') }}".replace(':id', data.id);    
                let image = "{{ asset('') }}" + data.featured_image ;       
                const row = `
                        <tr>
                            <td><input type="checkbox" class="checkbox" name="ids[]" value="${data.id}"></td>
                            <td>${data.id}</td>
                            <td><img src="${image}" width="50px" height="50px" alt=""></td>
                            <td><a class="nav-link" href="${edit}">${data.title}</a></td>
                            <td>${data.category.title ?? ''}</td>
                            <td><span class="status-dot status-${data.status}"></span>${data.status== '1' ? 'Published' : 'Unpublished'}</td>
                             <td>${data.created_by.name}</td>
                            <td>${data.created_at ? data.created_at.split('T')[0] : ''}</td>
                            <td>${ data.updated_at ? data.updated_at.split('T')[0] : ''}</td>
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
