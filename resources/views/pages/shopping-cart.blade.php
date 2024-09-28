@extends('layouts.app')
@section('style')
<style>
    .quantity-input {
        width: 40px;
        text-align: center;
        border: none;
        background-color: transparent;
    }
    .item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
    .btn-quantity {
        padding: 0 5px;
    }
    #loadingSpinner {
        display: none;
    }
</style>
@endsection
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Your Cart (<span id="itemCount">0</span> items)</h1>
    <div id="loadingSpinner" class="text-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
    <table class="table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="cartItems">
            <!-- Cart items will be dynamically inserted here -->
        </tbody>
    </table>
    <div class="row justify-content-end">
        <div class="col-md-4">
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span id="subtotal">$0.00</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Sales Tax:</span>
                    <span id="salesTax">$0.00</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="coupon" class="form-label">Coupon Code:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="coupon">
                    <button class="btn btn-outline-secondary" type="button">Add Coupon</button>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Grand total:</h4>
                <h4 id="grandTotal">$0.00</h4>
            </div>
            <div class="alert alert-success" role="alert">
                Congrats, you're eligible for Free Shipping.
            </div>
            <button class="btn btn-dark w-100">Check out</button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // API endpoint for cart items
    const API_URL = '{{ route('cart.get') }}';

    // Function to fetch cart items from the API
    async function fetchCartItems() {
        showLoading(true);
        try {
            const response = await fetch(API_URL);
            if (!response.ok) {
                throw new Error('Failed to fetch cart items');
            }
            console.log()
            const data = await response.json();
            showLoading(false);
            return data;
        } catch (error) {
            showLoading(false);
            showError(error.message);
            return [];
        }
    }

    // Function to render cart items
    function renderCartItems(items) {
        const cartItemsContainer = document.getElementById('cartItems');
        cartItemsContainer.innerHTML = '';

        items.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <img src="${item.image}" alt="${item.name}" class="item-image me-3">
                        <div>
                            <h5>${item.name}</h5>
                            <p class="text-muted mb-0">${item.description || ''}</p>
                            ${item.shipDate ? `<small class="text-danger">Estimated Ship Date: ${item.shipDate}</small>` : ''}
                        </div>
                    </div>
                </td>
                <td>$${item.price.toFixed(2)}</td>
                <td>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary btn-quantity" type="button" onclick="updateQuantity(${item.id}, -1)">-</button>
                        <input type="text" class="quantity-input" value="${item.quantity}" readonly>
                        <button class="btn btn-outline-secondary btn-quantity" type="button" onclick="updateQuantity(${item.id}, 1)">+</button>
                    </div>
                </td>
                <td>$${(item.price * item.quantity).toFixed(2)}</td>
            `;
            cartItemsContainer.appendChild(row);
        });

        document.getElementById('itemCount').textContent = items.length;
        updateTotals(items);
    }

    // Function to update quantity
    function updateQuantity(itemId, change) {
        const items = JSON.parse(localStorage.getItem('cartItems') || '[]');
        const item = items.find(i => i.id === itemId);
        if (item) {
            item.quantity = Math.max(1, item.quantity + change);
            localStorage.setItem('cartItems', JSON.stringify(items));
            renderCartItems(items);
        }
    }

    // Function to update totals
    function updateTotals(items) {
        const subtotal = items.reduce((sum, item) => sum + item.price * item.quantity, 0);
        const salesTax = subtotal * 0.1; // Assuming 10% sales tax
        const grandTotal = subtotal + salesTax;

        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('salesTax').textContent = `$${salesTax.toFixed(2)}`;
        document.getElementById('grandTotal').textContent = `$${grandTotal.toFixed(2)}`;
    }

    // Function to show/hide loading spinner
    function showLoading(isLoading) {
        document.getElementById('loadingSpinner').style.display = isLoading ? 'block' : 'none';
    }

    // Function to show error message
    function showError(message) {
        const errorElement = document.getElementById('errorMessage');
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    // Initialize the cart
    async function initCart() {
        const items = await fetchCartItems();
        if (items.length > 0) {
            localStorage.setItem('cartItems', JSON.stringify(items));
            renderCartItems(items);
        }
    }

    // Call initCart when the page loads
    window.addEventListener('load', initCart);
</script>
@endsection