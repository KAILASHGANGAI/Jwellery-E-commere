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
            <span class="order-tab active" onclick="setActiveTab(this)">All</span>
            <span class="order-tab" onclick="setActiveTab(this)">Active</span>
            <span class="order-tab" onclick="setActiveTab(this)">Archived</span>
            <span class="order-tab" onclick="setActiveTab(this)">Display</span>
            <span class="order-tab bg-success " ><a class="text-decoration-none text-white font-weight-bold" href="{{ route('products.create') }}">+</a></span>
        </div>
        <div class="order-actions">
            <input type="text" id="table-search" placeholder="Search orders...">
            <button class="search-button" onclick="searchOrders()">Search</button>
            <span>☰</span>
            <span>⋮</span>
            <div class="filter-dropdown">
                <span onclick="toggleFilter()">↓</span>
                <div id="filterDropdown" class="filter-content">
                    <a href="#" onclick="applyFilter('all')">All</a>
                    <a href="#" onclick="applyFilter('paid')">Paid</a>
                    <a href="#" onclick="applyFilter('unfulfilled')">Unfulfilled</a>
                    <a href="#" onclick="applyFilter('fulfilled')">Fulfilled</a>
                </div>
            </div>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table class="order-table" id="orderTable">
            <thead>
                <tr>
                    <th></th>
                    <th>Order</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Channel</th>
                    <th>Total</th>
                    <th>Payment status</th>
                    <th>Fulfillment status</th>
                    <th>Items</th>
                    <th>Delivery status</th>
                    <th>Delivery method</th>
                    <th>Tags</th>
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
    <script>
        let currentPage = 1;
        const ordersPerPage = 10;
        const apiBaseUrl = 'https://api.example.com'; // Replace with your actual API base URL

      

        function searchOrders() {
            const searchTerm = document.getElementById('table-search').value;
            currentPage = 1;
            fetchOrders(searchTerm);
        }

        function applyFilter(filter) {
            currentPage = 1;
            fetchOrders('', filter);
        }

        async function fetchOrders(searchTerm = '', filter = 'all') {
            try {
                const response = await fetch(
                    `${apiBaseUrl}/orders?page=${currentPage}&per_page=${ordersPerPage}&search=${searchTerm}&filter=${filter}`
                    );
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                displayOrders(data.orders);
                setupPagination(data.total, data.current_page, data.last_page);
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                // Handle the error (e.g., display an error message to the user)
            }
        }

        function displayOrders(orders) {
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';

            orders.forEach(order => {
                const row = `
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>${order.id}</td>
                        <td>${order.date}</td>
                        <td>${order.customer}</td>
                        <td>${order.channel}</td>
                        <td>${order.total}</td>
                        <td><span class="status-dot status-${order.payment_status.toLowerCase()}"></span>${order.payment_status}</td>
                        <td><span class="status-dot status-${order.fulfillment_status.toLowerCase()}"></span>${order.fulfillment_status}</td>
                        <td>${order.items}</td>
                        <td>${order.delivery_status}</td>
                        <td>${order.delivery_method}</td>
                        <td>${order.tags}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        function setupPagination(totalOrders, currentPage, totalPages) {
            const paginationElement = document.getElementById('pagination');
            paginationElement.innerHTML = '';

            // Previous button
            const prevButton = document.createElement('button');
            prevButton.innerText = 'Previous';
            prevButton.onclick = () => changePage(currentPage - 1);
            prevButton.disabled = currentPage === 1;
            paginationElement.appendChild(prevButton);

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.innerText = i;
                pageButton.onclick = () => changePage(i);
                if (i === currentPage) {
                    pageButton.classList.add('current-page');
                }
                paginationElement.appendChild(pageButton);
            }

            // Next button
            const nextButton = document.createElement('button');
            nextButton.innerText = 'Next';
            nextButton.onclick = () => changePage(currentPage + 1);
            nextButton.disabled = currentPage === totalPages;
            paginationElement.appendChild(nextButton);
        }

        function changePage(newPage) {
            currentPage = newPage;
            const searchTerm = document.getElementById('table-search').value;
            fetchOrders(searchTerm);
        }

        // Initial load
        fetchOrders();
    </script>
@endsection
