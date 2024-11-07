@extends('admin::layouts.master')
@section('style')
    <style>
        .main-title {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
@section('content')
    <h4 class="main-title">Orders List</h4>
    @include('admin::includes.errors')
    <div class="order-controls">
        <div class="order-tabs">
            <span class="order-tab active" onclick="setActiveTab('all')">All</span>
            <span class="order-tab" onclick="setActiveTab('refund')">Refund</span>
            <span class="order-tab" onclick="setActiveTab('cancled')">Cancled</span>
            <span class="order-tab" onclick="setActiveTab('pending')">Pending</span>
            <span class="order-tab" onclick="setActiveTab('fulfilled')">Fulfilled</span>
            <span class=" ">
                {{-- <a class="order-tab bg-success text-decoration-none text-white font-weight-bold"
                    href="{{ route('orders.create') }}"><i class="fa-solid fa-plus"></i></a> --}}
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
                    <a href="#" onclick="applySort('id', 'asc')">A -Z</a>
                    <a href="#" onclick="applySort('id', 'desc')">Z -A</a>
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
                    <th>OrderID</th>
                    <th>Order Date</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>No Items</th>
                    <th>Net Total</th>
                    <th>Tax Amount</th>
                    <th>Payment Method</th>
                    {{-- <th>Fulfillment status</th> --}}
                    {{-- <th>Delivery status</th>
                    <th>Delivery method</th>
                    <th>Tags</th> --}}
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
        const apiBaseUrl = '{{ route('orders.indexAjax') }}'; // Replace with your actual API base URL
        const apiBaseDeleteUrl = '{{ route('orders.bulkDelete') }}';
        const ordersPerPage = 10;
        let currentPage = 1;

        // Initialize the page
        function init() {
            initEventListeners();
            fetchOrders();
        }

        // Display orders in the table
        function displayOrders(data) {
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';
        console.log(data);
            if (data.length == 0) {
                tableBody.innerHTML = '<tr><td colspan="11">No datas found.</td></tr>';
            }
         
            
            data.forEach(order => {
                var viewUrl = '{{ route('orders.show', ':id') }}';
                viewUrl = viewUrl.replace(':id', order.id);
                const row = `
                    <tr>
                     <td><input type="checkbox" class="checkbox" name="ids[]" value="${order.id}"></td>

                        <td><a class="text-decoration-none" href="${viewUrl}">${order.id}</a></td>
                        <td>${order.order_date}</td>
                        <td><a href="${viewUrl}">${order.customer.name}</a></td>
                        <td><span class="status-dot status-${order.status}"></span>${order.status}</td>
                        <td>NPR. ${order.total_amount}</td>
                        <td>${order.no_of_item}</td>
                        <td>NPR. ${order.nettotal}</td>
                        <td>NPR. ${order.taxAmount}</td>
                        <td><span class="status-dot status-${order.payment_method}"></span>${order.payment_method}</td>
                     
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }
        init();
    </script>
@endsection
