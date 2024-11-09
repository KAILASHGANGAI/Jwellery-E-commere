@extends('admin::layouts.master')

@section('content')
    <h5>Orders</h5>
    {{-- <div class="pickup-info">
        <h3>1 scheduled carrier pickup</h3>
        <p>From Castle Hill with Sendle on Thursday, 5 September between 8 am - 6 pm.</p>
        <button>View pickup</button>
    </div> --}}
    <div class="order-controls">    
        <div class="order-tabs">
            <span class="order-tab active" onclick="setActiveTab('all')">All</span>
            <span class="order-tab" onclick="setActiveTab('refund')">Refund</span>
            <span class="order-tab" onclick="setActiveTab('cancled')">Cancled</span>
            <span class="order-tab" onclick="setActiveTab('pending')">Pending</span>
            <span class=" ">
                <a class="order-tab bg-success text-decoration-none text-white font-weight-bold"
                    href="{{ route('customers.create') }}">+</a>
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
                <span onclick="toggleFilter()"><i class="fa-solid fa-arrow-up-a-z"></i></span>
                <div id="filterDropdown" class="filter-content">
               
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
                    <th>S.N</th>
                    <th>OrderID</th>
                    <th>Date</th>
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
    <script>
        let currentPage = 1;
        const ordersPerPage = 10;
        const apiBaseUrl = '{{ route('orders.indexAjax') }}'; // Replace with your actual API base URL

      

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
                    `${apiBaseUrl}?page=${currentPage}&per_page=${ordersPerPage}&search=${searchTerm}&filter=${filter}`
                    );
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                displayOrders(data.data);
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
                        <td>${order.order_date}</td>
                        <td>${order.customer.name}</td>
                        <td><span class="status-dot status-${order.status.toLowerCase()}"></span>${order.status}</td>
                        <td>NPR. ${order.total_amount}</td>
             
                        <td>${order.no_of_item}</td>
                        <td>NPR. ${order.nettotal}</td>
                        <td>NPR. ${order.taxAmount}</td>
                        <td><span class="status-dot status-${order.payment_method.toLowerCase()}"></span>${order.payment_method}</td>
                     
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
