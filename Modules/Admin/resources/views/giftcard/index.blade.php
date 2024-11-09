@extends('admin::layouts.master')
@section('style')
    <style>
        .main-title {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
@section('content')
    <h4 class="main-title">Gift Cards List</h4>
    <div class="pickup-info">
        <h3>Under Development</h3>
        <p>comming Soon. you can create , edit and delete Gift Cards. but wont be implented on websiteright now. </p>
    </div>
    @include('admin::includes.errors')
    <div class="order-controls">
        <div class="order-tabs">
            <span class="order-tab active" onclick="setActiveTab('all')">All</span>
            <span class="order-tab" onclick="setActiveTab('active')">Active</span>
            <span class="order-tab" onclick="setActiveTab('archived')">Archived</span>
            <span class=" ">
                <a class="order-tab bg-success text-decoration-none text-white font-weight-bold"
                    href="{{ route('giftcards.create') }}"><i class="fa-solid fa-plus"></i></a>
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
                    <th>Gift Code</th>
                    <th>Value</th>
                    <th>Status</th>
                    <th>Expiry_date</th>
                    <th>created At</th>
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
        const apiBaseUrl = '{{ route('giftcards.indexAjax') }}'; // Replace with your actual API base URL
        const apiBaseDeleteUrl = '{{ route('giftcards.bulkDelete') }}';
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
                tableBody.innerHTML = '<tr><td colspan="8">No data found.</td></tr>';
            }
            orders.forEach(data => {
                let edit = "{{ route('giftcards.edit', ':id') }}".replace(':id', data.id);
                let destroy = "{{ route('giftcards.destroy', ':id') }}".replace(':id', data.id);
                const formattedDate = new Date(data.created_at).toISOString().split('T')[0];
                const display = data.display == 1 ? 'Yes' : 'No';
                
                const row = `
                        <tr>
                            <td><input type="checkbox" class="checkbox" name="ids[]" value="${data.id}"></td>
                            <td>${data.id}</td>
                            <td><a class="nav-link" href="${edit}">${data.name}</a></td>
                            <td>${data.code}</td>
                            <td>${data.value}</td>
                            <td><span class="status-dot status-${data.status}"></span>${data.status}</td>
                            <td>${data.expiry_date}</td>
                            <td>${formattedDate}</td>
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
