@extends('admin::layouts.master')
@section('style')
    <style>
        .main-title {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection

@section('content')
    <h4 class="main-title">Blog Category List</h4>
    @include('admin::includes.errors')

    <!-- Order Controls -->
    <div class="order-controls">
        <div class="order-tabs">
            <!-- Add Category Button -->
            <span>
                <button class="btn bg-success text-white font-weight-bold" data-bs-toggle="modal"
                    data-bs-target="#createModal"><i class="fa-solid fa-plus"></i></button>
            </span>
            <button id="bulk-delete-btn" class="btn text-danger" style="display: none;" onclick="bulkDelete()">Bulk
                <i class="fa fa-trash"></i>
            </button>
        </div>

        <!-- Search and Filter Controls -->
        <div class="order-actions">
            <input type="text" id="table-search" placeholder="Search ...">
            <button class="search-button" onclick="searchOrders()">Search</button>
            <span>☰</span>
            <span>⋮</span>
            <div class="filter-dropdown">
                <span onclick="toggleFilter()">↓</span>
                <div id="filterDropdown" class="filter-content">
                    <a href="#" onclick="applySort('title', 'asc')">A - Z</a>
                    <a href="#" onclick="applySort('title', 'desc')">Z - A</a>
                    <a href="#" onclick="applySort('created_at', 'desc')">Newest</a>
                    <a href="#" onclick="applySort('created_at', 'asc')">Oldest</a>
                    <a href="#" onclick="applySort('updated_at', 'desc')">Last Updated</a>
                    <a href="#" onclick="applySort('updated_at', 'asc')">First Updated</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="overflow-x: auto;" class="bg-white">
        <table class="order-table" id="orderTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
                <!-- Table body will be populated dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination" id="pagination">
        <!-- Pagination buttons will be added here -->
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('blogcategory.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Category Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group mt-1">
                            <label for="slug">slug</label>
                            <input type="text" name="slug" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit-title">Category Title</label>
                            <input type="text" name="title" id="edit-title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-slug">Slug</label>
                            <input type="text" name="slug" id="edit-slug" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/js/index.js') }}"></script>
    <script>
        const apiBaseUrl = '{{ route('blogcategory.indexAjax') }}';
        const apiBaseDeleteUrl = '{{ route('blogcategory.bulkDelete') }}';
        const ordersPerPage = 10;
        let currentPage = 1;

        function init() {
            initEventListeners();
            fetchOrders();
        }

        // Display orders in the table
        function displayOrders(orders) {
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';
            if (orders.length == 0) {
                tableBody.innerHTML = '<tr><td colspan="8">No Data found.</td></tr>';
            }
            orders.forEach(data => {
                let edit = "{{ route('blogcategory.edit', ':id') }}".replace(':id', data.id);
                let destroy = "{{ route('blogcategory.destroy', ':id') }}".replace(':id', data.id);

                const row = `
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="ids[]" value="${data.id}"></td>
                        <td>${data.id}</td>
                        <td><a href="#" class="nav-link" onclick="showEditModal(${data.id}, '${data.title}', '${data.slug}')">${data.title}</a></td>
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

        // Show Edit Modal and populate data
        function showEditModal(id, title, slug) {
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-slug').value = slug;
            const editFormAction = "{{ route('blogcategory.update', ':id') }}".replace(':id', id);
            document.getElementById('editCategoryForm').action = editFormAction;
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        init();
    </script>
@endsection
