@extends('admin::layouts.master')
@section('style')
    <style>
        .main-title {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
@section('content')
    <h4 class="main-title">Collections List</h4>

    <div class="order-controls">
        <div class="order-tabs">
            <span class="order-tab active" onclick="setActiveTab('all')">All</span>
            <span class="order-tab" onclick="setActiveTab('active')">Active</span>
            <span class="order-tab" onclick="setActiveTab('archived')">Archived</span>
            <span class=" ">
                <a class="order-tab bg-success text-decoration-none text-white font-weight-bold"
                    href="{{ route('collections.create') }}">+</a>
            </span>
        </div>
        <div class="order-actions">
            <input type="text" id="table-search" placeholder="Search orders...">
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
                    <a href="#" onclick="applySort('updated_at', 'desc')">Last  Updated</a>
                    <a href="#" onclick="applySort('updated_at', 'asc')">First Updated</a>
                </div>
            </div>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table class="order-table" id="orderTable">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Status</th>
                    {{-- <th>ProductCount</th> --}}
                    <th>Display</th>
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
    <script>
        let currentPage = 1;
        const ordersPerPage = 10;
        const apiBaseUrl = '{{ route('collections.indexAjax') }}'; // Replace with your actual API base URL

        function searchOrders() {
            const searchTerm = document.getElementById('table-search').value;
            currentPage = 1;
            fetchOrders(searchTerm);
        }

        function applyFilter(filter) {
            currentPage = 1;
            fetchOrders('', filter);
        }

        function setActiveTab(tab) {
            fetchOrders('', tab);
        }

        function applySort(sortBy, sortOrder) {
            currentPage = 1;
            fetchOrders('', '',  sortBy, sortOrder);
        }

        async function fetchOrders(searchTerm = '', filter = 'all', sortBy = '', sortOrder = '') {
            try {
                const response = await fetch(
                    `${apiBaseUrl}?page=${currentPage}&per_page=${ordersPerPage}&search=${searchTerm}&filter=${filter}&sort_field=${sortBy}&sort_type=${sortOrder}`
                );
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                console.log(data.data);
                displayOrders(data.data);
                setupPagination(data.total, data.current_page, data.last_page);
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        function displayOrders(orders) {

            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';

            orders.forEach(order => {

                var imgUrl = "{{ asset('') }}" + order.file_path;
                var edit = "{{ route('collections.edit', ':id') }}";
                edit = edit.replace(':id', order.id);
                var destroy = "{{ route('collections.destroy', ':id') }}";
                destroy = destroy.replace(':id', order.id);
                const row = `
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>${order.id}</td>
                        <td><img src="${imgUrl}"  width="50"></td>
                        <td>${order.title}</td>
                        <td><span class="status-dot status-${order.status.toLowerCase()}"></span>${order.status}</td>
                        <td><span class="status-dot status-${order.display.toLowerCase()}"></span>${order.display}</td>
                        <td>${order.created_at}</td>
                        <td>
                            <a href="${edit}" class="edit-button">Edit</a>
                            <a href="${destroy}" class="delete-button">Delete</a>    
                        </td>
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
            // for (let i = 1; i <= totalPages; i++) {
            //     const pageButton = document.createElement('button');
            //     pageButton.innerText = i;
            //     pageButton.onclick = () => changePage(i);
            //     if (i === currentPage) {
            //         pageButton.classList.add('current-page');
            //     }
            //     paginationElement.appendChild(pageButton);
            // }

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
