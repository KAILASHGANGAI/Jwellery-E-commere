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
        <div class="row">
            <div class="col-sm-8 p-3">
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

            </div>
            <div class="col-sm-4">
                <div class="row justify-content-end  p-3">
                    <div class=" mt-4">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span id="subtotal">NPR. 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                {{-- <span>Sales Tax (13% VAT):</span> --}}
                                {{-- <span id="salesTax">NPR. 0.00</span> --}}
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="coupon" class="form-label">Coupon Code:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="coupon">
                                <button class="btn btn-outline-secondary" type="button">Add Coupon</button>
                            </div>
                        </div> --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Grand total:</h4>
                            <h4 id="grandTotal">NPR. 0.00</h4>
                        </div>
                        <div class="alert alert-success" role="alert">
                            <span> Congrats, you're eligible for Free Shipping. </span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-dark w-100">Check out</a>
                    </div>
                </div>
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
                console.log(response)
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
            console.log(items)
            items.forEach(item => {
                const row = document.createElement('tr');
                var imageUrl = '{{ asset('/') }}' + item.product.images[0].image_path;
                row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <img src="${imageUrl}" alt="${item.product.title}" class="item-image me-3">
                        <div>
                            <h5>${item.product.title}</h5>
                            <p class="text-muted mb-0">${item.description || ''}</p>
                            ${item.shipDate ? `<small class="text-danger">Estimated Ship Date: ${item.shipDate}</small>` : ''}
                        </div>
                    </div>
                </td>
                <td>NPR.    ${item.unit_price}</td>
                <td>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary btn-quantity" type="button" onclick="updateQuantity(${item.id}, -1)">-</button>
                        <input type="text" class="quantity-input" value="${item.quantity}" readonly>
                        <button class="btn btn-outline-secondary btn-quantity" type="button" onclick="updateQuantity(${item.id}, 1)">+</button>
                    </div>
                </td>
                <td>NPR.    ${(item.unit_price * item.quantity).toFixed(2)}</td>
            `;
                cartItemsContainer.appendChild(row);
            });

            document.getElementById('itemCount').textContent = items.length;
            updateTotals(items);
        }

        // Function to update quantity
        function updateQuantity(itemId, change) {
            console.log(itemId, change)
            // ajax call to updare quantity
            fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        itemId,
                        change
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    initCart()
                })
        }

        // Function to update totals
        function updateTotals(items) {
            console.log(items)
            const subtotal = items.reduce((sum, item) => sum + item.unit_price * item.quantity, 0);
            // const salesTax = subtotal * 0.13; // Assuming 13% sales tax
            const grandTotal = subtotal; // + salesTax;

            document.getElementById('subtotal').textContent = `NPR. ${subtotal.toFixed(2)}`;
            // update cart-total on nav 
            document.getElementById('cart-total').textContent = `NPR. ${subtotal.toFixed(2)}`;
            // document.getElementById('salesTax').textContent = `NPR. ${salesTax.toFixed(2)}`;
            document.getElementById('grandTotal').textContent = `NPR. ${grandTotal.toFixed(2)}`;
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
            console.log(items)
            if (items.cartItems.length > 0) {
                // localStorage.setItem('cartItems', JSON.stringify(items));
                renderCartItems(items.cartItems);
            }
        }



        // Call initCart when the page loads
        window.addEventListener('load', initCart);
    </script>
@endsection
