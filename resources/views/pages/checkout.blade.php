@extends('layouts.app')
@section('style')
    <style>
        body {
            background-color: #FFF8E1;
            font-family: Arial, sans-serif;
        }

        .golden-text {
            color: #D4AF37;
        }

        .golden-bg {
            background-color: #D4AF37;
            color: white;
        }

        .golden-border {
            border-color: #D4AF37 !important;
        }

        .btn-golden {
            background-color: #D4AF37;
            color: white;
        }

        .btn-golden:hover {
            background-color: #C4A137;
            color: white;
        }

        #loadingSpinner {
            display: none;
        }

        #cortItems {
            height: 200px;
            overflow-y: scroll;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <header class="mb-5">
            <h1 class="display-4 golden-text fw-bold">Checkout</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Information</li>
                    <li class="breadcrumb-item">Shipping</li>
                    <li class="breadcrumb-item active golden-text" aria-current="page">Payment</li>
                </ol>
            </nav>
        </header>
        <div id="loadingSpinner" class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        @include('admin::includes.errors')
        <form id="checkOut" action="{{ route('place-order') }}"  method="POST">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-8">

                    <div class="card mb-4">
                        <div class="card-header golden-bg">
                            <h2 class="h5 mb-0">Contact Information</h2>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="newsletter" {{ old('newsletter') ? 'checked' : '' }}
                                    class="form-check-input" id="newsletter">
                                <label class="form-check-label" for="newsletter" for="newsletter">Email me with news and
                                    offers</label>
                            </div>

                            <h3 class="h5 mt-4 mb-3 golden-text">Shipping Address</h3>
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" {{ old('address') }}
                                    id="address" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="form-control"
                                        id="city" required>
                                </div>
                                <div class="col">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-select" name="state" id="state" required>
                                        <option value="">Choose...</option>
                                        <option {{ old('state') == 'Koshi' ? 'selected' : '' }} value="Koshi">Koshi
                                        </option>
                                        <option {{ old('state') == 'Madhesh' ? 'selected' : '' }} value="Madhesh">Madhesh
                                        </option>
                                        <option {{ old('state') == 'Bagmati' ? 'selected' : '' }} value="Bagmati">Bagmati
                                        </option>
                                        <option {{ old('state') == 'Gandaki' ? 'selected' : '' }} value="Gandaki">Gandaki
                                        </option>
                                        <option {{ old('state') == 'Lumbini' ? 'selected' : '' }} value="Lumbini">Lumbini
                                        </option>
                                        <option {{ old('state') == 'Karnali' ? 'selected' : '' }} value="Karnali">Karnali
                                        </option>
                                        <option {{ old('state') == 'Sudurpashchim' ? 'selected' : '' }}
                                            value="Sudurpashchim">Sudurpashchim</option>
                                    </select>

                                </div>
                                <div class="col">
                                    <label for="zip" class="form-label">ZIP</label>
                                    <input type="text" name="zip" value="{{ old('zip') }}" class="form-control"
                                        id="zip" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control"
                                    id="phone">
                            </div>
                            <a href="{{ route('web.products') }}" class="btn btn-golden btn-lg w-100">Continue to
                                Shipping</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header golden-bg">
                            <h2 class="h5 mb-0">Your Order</h2>
                        </div>
                        <div class="card-body">
                            <div class="items" id="cortItems">

                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="coupon_code" id="code" value="{{ old('code') }}" class="form-control golden-border"
                                    placeholder="Gift card or discount code" aria-label="Gift card or discount code"
                                    aria-describedby="apply-code">
                                <button class="btn btn-outline-secondary golden-border golden-text" type="button"
                                    id="apply-code">Apply</button>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span class="fw-bold" id="subtotal">NPR. 0.00</span>
                            </div>
                            {{-- <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>Calculated at next step</span>
                        </div> --}}
                            {{-- <div class="d-flex justify-content-between mb-2">
                                <span>Sales Tax</span>
                                <span class="fw-bold" id="salesTax">NPR. 0.00</span>
                            </div> --}}
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h5">Grand Total</span>
                                <span class="h5 golden-text" id="grandTotal">NPR. 150.00</span>
                            </div>
                            <div>
                                <input type="checkbox" name="payment_method" value="cash_on_delivery"  checked id="payment_method">
                                <label for="payment_method">Cash On Delivery !!</label>
                            </div>
                            <button id="checkOut" class="btn btn-golden w-100 my-2">CheckOut Now</button>

                        </div>
                    </div>

                    {{-- <p class="text-center text-muted m-4 ">OR CONTINUE BELOW TO PAY WITH A CREDIT CARD</p>
                <div class="card mb-4">
                    <div class="card-header golden-bg">
                        <h2 class="h5 mb-0">Express Checkout</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-golden">PayPal</button>
                            <button class="btn btn-golden">Stripe</button>
                            <button class="btn btn-golden">Apple Pay</button>
                        </div>
                    </div>
                </div> --}}

                </div>
            </div>
        </form>
        <footer class="mt-5 text-center">
            <a href="#" class="text-muted me-3">Refund Policy</a>
            <a href="#" class="text-muted me-3">Privacy Policy</a>
            <a href="#" class="text-muted">Terms of Service</a>
        </footer>
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
                return [];
            }
        }

        async function initCart() {
            const items = await fetchCartItems();
            console.log(items)
            updateTotals(items.cartItems);
            renderCartItems(items.cartItems);

        }



        // Call initCart when the page loads
        window.addEventListener('load', initCart);

        function showLoading(isLoading) {
            document.getElementById('loadingSpinner').style.display = isLoading ? 'block' : 'none';
        }

        function updateTotals(items) {
            console.log(items)
            const subtotal = items.reduce((sum, item) => sum + item.unit_price * item.quantity, 0);
            // const salesTax = subtotal * 0.13; // Assuming 13% sales tax
            const grandTotal = subtotal ; // + salesTax;

            document.getElementById('subtotal').textContent = `NPR. ${subtotal.toFixed(2)}`;
            // update cart-total on nav 
            document.getElementById('cart-total').textContent = `NPR. ${subtotal.toFixed(2)}`;
            // document.getElementById('salesTax').textContent = `NPR. ${salesTax.toFixed(2)}`;
            document.getElementById('grandTotal').textContent = `NPR. ${grandTotal.toFixed(2)}`;
        }

        // Function to render cart items
        function renderCartItems(items) {
            const cartItemsContainer = document.getElementById('cortItems');
            cartItemsContainer.innerHTML = '';
            console.log(items)
            items.forEach(item => {
                const row = document.createElement('tr');
                var imageUrl = '{{ asset('/') }}' + item.product.images[0].image_path;
                row.innerHTML = `
                      <div class="d-flex mb-3">
                            <img src="${imageUrl}?height=80&width=80" alt="Product" class="img-fluid rounded me-3"
                                style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <h3 class="h6 mb-0">${item.product.title}</h3>
                                  <span class="fw-bold"> Unit Price: NPR. ${item.unit_price}</span> <br>
                                <p class="text-muted small">Quantity: ${item.quantity}</p>
                            </div>
                          
                        </div>
            `;
                cartItemsContainer.appendChild(row);
            });

            document.getElementById('itemCount').textContent = items.length;
            updateTotals(items);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const applyCodeBtn = document.getElementById('apply-code');
            applyCodeBtn.addEventListener('click', function() {
                alert(
                    'Discount code applied! In a real application, this would validate the code and update the total.'
                );
            });
        });
    </script>
@endsection
