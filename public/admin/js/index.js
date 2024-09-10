
// Fetch orders from the API
async function fetchOrders(options = {}) {
    const {
        searchTerm = '',    // Default value: empty string
        filter = 'all',     // Default value: 'all'
        sortBy = '',        // Default value: empty string
        sortOrder = ''      // Default value: empty string
    } = options;
    const url = `${apiBaseUrl}?page=${currentPage}&per_page=${ordersPerPage}&search=${searchTerm}&filter=${filter}&sort_field=${sortBy}&sort_type=${sortOrder}`;
    showLoader();
    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        displayOrders(data.data);
        setupPagination(data.total, data.current_page, data.last_page);
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    } finally {
        hideLoader(); // Hide loader after the fetch completes
    }
}



// Setup pagination for the orders table
function setupPagination(totalOrders, currentPage, totalPages) {
    const paginationElement = document.getElementById('pagination');
    paginationElement.innerHTML = '';

    const prevButton = createPaginationButton('Previous', currentPage - 1, currentPage === 1);
    paginationElement.appendChild(prevButton);

    const nextButton = createPaginationButton('Next', currentPage + 1, currentPage === totalPages);
    paginationElement.appendChild(nextButton);
}

// Create a button for pagination
function createPaginationButton(label, newPage, disabled = false) {
    const button = document.createElement('button');
    button.innerText = label;
    button.onclick = () => changePage(newPage);
    button.disabled = disabled;
    return button;
}

// Change to the new page
function changePage(newPage) {
    currentPage = newPage;
    fetchOrders({ searchTerm: document.getElementById('table-search').value });
}

// Toggle the visibility of the bulk delete button
function toggleBulkDeleteButton() {
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const checkboxes = document.querySelectorAll('.checkbox');
    const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
    bulkDeleteBtn.style.display = anyChecked ? 'block' : 'none';
}

// Bulk delete selected orders
async function bulkDelete() {
    const selectedOrders = Array.from(document.querySelectorAll('.checkbox:checked')).map(checkbox => checkbox.value);
    showLoader();
    if (selectedOrders.length > 0) {
        try {
            const response = await fetch(apiBaseDeleteUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ ids: selectedOrders })
            });
            const result = await response.json();
            if (result.success) {
                alert('Deleted successfully!');
                selectedOrders.forEach(id => document.querySelector(`input[value="${id}"]`).closest('tr').remove());
                toggleBulkDeleteButton();
            } else {
                alert('Failed to delete.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting.');
        } finally {
            hideLoader();
        }
    } else {
        alert('No items selected for deletion.');
    }
}

// Initialize event listeners
function initEventListeners() {
    document.getElementById('select-all').addEventListener('change', function () {
        document.querySelectorAll('.checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkDeleteButton();
    });

    document.querySelector('tbody').addEventListener('change', function (event) {
        if (event.target.classList.contains('checkbox')) {
            toggleBulkDeleteButton();
        }
    });
}
function showLoader() {
    document.getElementById('loader').style.display = 'block';
}

function hideLoader() {
    document.getElementById('loader').style.display = 'none';
}

function searchOrders() {
    const searchTerm = document.getElementById('table-search').value;
    currentPage = 1;
    fetchOrders({searchTerm: searchTerm});
}

function applyFilter(filter) {
    currentPage = 1;
    fetchOrders({filter: filter});
}

function setActiveTab(tab) {
   
    this.fetchOrders({filter: tab});
}

function applySort(sortBy, sortOrder) {
    currentPage = 1;
    fetchOrders({sortBy: sortBy, sortOrder: sortOrder});
}