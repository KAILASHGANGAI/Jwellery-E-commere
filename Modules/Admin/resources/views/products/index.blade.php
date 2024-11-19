@extends('admin::layouts.master')
@section('style')
<style>
    .main-title {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
@section('content')
    <h4 class="main-title">Products List</h4>
 
    <div class="order-controls">
        <div class="order-tabs">
            <span class="order-tab active" onclick="setActiveTab('all')">All</span>
            <span class="order-tab" onclick="setActiveTab('active')">Active</span>
            <span class="order-tab" onclick="setActiveTab('archived')">Archived</span>
           
            <span class="order-tab bg-success " >
                <a class="text-decoration-none text-white font-weight-bold" href="{{ route('products.create') }}"><i class="fa-solid fa-plus"></i></a></span>
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
    <div style="overflow-x: auto;">
        <table class="order-table" id="orderTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>IsMatrix</th>
                    <th>Status</th>
                    <th>Display</th>
                    <th>Price</th>
                    <th>Compare at price</th>
                    <th>Quantity</th>
                    <th>created At</th>
                  
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
        const apiBaseUrl = '{{ route('products.indexAjax') }}'; // Replace with your actual API base URL
        const apiBaseDeleteUrl = '{{ route('products.bulkDelete') }}';
        const ordersPerPage = 10;
        let currentPage = 1;



        // Initialize the page
        function init() {
            initEventListeners();
            fetchOrders();
        }



        // Display orders in the table
        function displayOrders(datas) {
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';
            // Loop through each order and display it in the table
            if (datas.length == 0) {
                tableBody.innerHTML = '<tr><td colspan="11">No datas found.</td></tr>';
            }
            datas.forEach(data => {
                const imgUrl = data.images.length > 0 ? "{{ asset('') }}" + data.images[0].image_path: '';
                let edit = "{{ route('products.edit', ':id') }}".replace(':id', data.id);
                let destroy = "{{ route('products.destroy', ':id') }}".replace(':id', data.id);
                const formattedDate = new Date(data.created_at).toISOString().split('T')[0];
                const display = data.display == 1 ? 'Yes' : 'No';
                const ismatrix = data.hasVariation == 1 ? 'Yes' : 'No';
                const row = `
                        <tr>
                            <td><input type="checkbox" class="checkbox" name="ids[]" value="${data.id}"></td>
                            <td>${data.id}</td>
                            <td><img src="${imgUrl}" width="50"></td>
                            <td><a class="nav-link" href="${edit}">${data.title}</a></td>
                            <td>${data.product_type}</td>
                            <td>${ismatrix}</td>
                            <td><span class="status-dot status-${data.status}"></span>${data.status}</td>
                            <td><span class="status-dot status-${data.display}"></span>${display}</td>
                            <td>${data.variations[0].price}</td>
                            <td>${data.variations[0].compare_price}</td>
                           
                            <td>${sum(data.variations)}</td>
                            <td>${formattedDate}</td>
                          
                        </tr>
                    `;
                tableBody.innerHTML += row;
            });
        }

        function sum(variations) {
            let sum = 0;
            for (let i = 0; i < variations.length; i++) {
                sum += parseInt(variations[i].inventory);
            }
            return sum;
        }
        init();
    </script>
@endsection
