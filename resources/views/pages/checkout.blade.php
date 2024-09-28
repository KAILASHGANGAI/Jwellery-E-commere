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
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <header class="mb-5">
            <h1 class="display-4 golden-text fw-bold">Golden Checkout</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Information</li>
                    <li class="breadcrumb-item">Shipping</li>
                    <li class="breadcrumb-item active golden-text" aria-current="page">Payment</li>
                </ol>
            </nav>
        </header>

        <div class="row">
            <div class="col-md-8">
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
                </div>

                <p class="text-center text-muted mb-4">OR CONTINUE BELOW TO PAY WITH A CREDIT CARD</p>

                <div class="card mb-4">
                    <div class="card-header golden-bg">
                        <h2 class="h5 mb-0">Contact Information</h2>
                    </div>
                    <div class="card-body">
                        <form id="checkoutForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="newsletter">
                                <label class="form-check-label" for="newsletter">Email me with news and offers</label>
                            </div>

                            <h3 class="h5 mt-4 mb-3 golden-text">Shipping Address</h3>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" required>
                                </div>
                                <div class="col">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-select" id="state" required>
                                        <option value="">Choose...</option>
                                        <option>California</option>
                                        <option>New York</option>
                                        <option>Texas</option>
                                        <!-- Add more states as needed -->
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="zip" class="form-label">ZIP</label>
                                    <input type="text" class="form-control" id="zip" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone">
                            </div>
                            <button type="submit" class="btn btn-golden btn-lg w-100">Continue to Shipping</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header golden-bg">
                        <h2 class="h5 mb-0">Your Order</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="/placeholder.svg?height=80&width=80" alt="Product" class="img-fluid rounded me-3"
                                style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <h3 class="h6 mb-0">Handcrafted Golden Jewelry</h3>
                                <p class="text-muted small">Quantity: 1</p>
                            </div>
                            <div class="ms-auto">
                                <span class="fw-bold">$150.00</span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control golden-border"
                                placeholder="Gift card or discount code" aria-label="Gift card or discount code"
                                aria-describedby="apply-code">
                            <button class="btn btn-outline-secondary golden-border golden-text" type="button"
                                id="apply-code">Apply</button>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="fw-bold">$150.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>Calculated at next step</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="h5">Total</span>
                            <span class="h5 golden-text">$150.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-5 text-center">
            <a href="#" class="text-muted me-3">Refund Policy</a>
            <a href="#" class="text-muted me-3">Privacy Policy</a>
            <a href="#" class="text-muted">Terms of Service</a>
        </footer>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkoutForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                // Here you would typically send the form data to a server
                alert(
                    'Form submitted! In a real application, this would process the payment and create the order.');
            });

            const applyCodeBtn = document.getElementById('apply-code');
            applyCodeBtn.addEventListener('click', function() {
                alert(
                    'Discount code applied! In a real application, this would validate the code and update the total.');
            });
        });
    </script>
@endsection
