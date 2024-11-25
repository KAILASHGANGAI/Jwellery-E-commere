@extends('layouts.app')
@section('style')
    <style>
        .quantity-input {
            width: 40px !important;
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
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4"><i class="fas fa-heart"></i> Wishlist</h2>

        <div id="wishlistContainer" class="table-responsive">
            <table class="table">
                <thead class="text-center">
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    <!-- Wishlist items will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // Get product IDs from localStorage and parse them
            let productIds = (localStorage.getItem('wishlist'));
            console.log(productIds);

            if (productIds.length > 0) {
                // Automatically make AJAX call when the page loads
                $.ajax({
                    url: '{{ route('wishlist-products') }}', // Replace with your server URL
                    method: 'POST',
                    data: {
                        product_ids: productIds
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // For Laravel apps
                    },
                    success: function(response) {
                        console.log(response);
                        // Process the response
                        $('#orderTableBody').empty(); // Clear loading message
                        if (response.length > 0) {
                            response.forEach(function(product) {

                                var imgurl = "{{ asset('/') }}" + product.images[0]
                                    .image_path;
                                var viewUrl = "{{ route('product-details', ':slug') }}";
                                viewUrl = viewUrl.replace(':slug', product.slug);
                                $('#orderTableBody').append(`
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="${viewUrl}">
                                                       <img src="${imgurl}" alt="${product.title}"  class="item-image me-3" height="100px" width="100px">

                                                    </a>
                                                <div>
                                                    <h5>${product.title}</h5>
                                                    <p class="text-muted mb-0">${product.collections}</p>
                                                    <small class="text-danger">Estimated Ship Date:</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-unit-price="${product.variations[0].price}">${product.variations[0].price}</td>
                                        <td class="text-center">
                                            <div class="input-group d-flex justify-content-center">
                                                <button class="btn btn-outline-secondary btn-quantity" type="button" onclick="updateQuantity(this, -1, '${product.variations[0].price}')">-</button>
                                                <input type="text" class="quantity-input  text-center" value="1" readonly>
                                                <button class="btn btn-outline-secondary btn-quantity " type="button"  onclick="updateQuantity(this, 1, '${product.variations[0].price}')">+</button>
                                            </div>
                                        </td>
                                        <td class="total-price">NRS ${product.variations[0].price}</td>
                                        <td>
                                            <button class="btn btn-danger btn-remove" type="button" onclick="removeFromWishlist('${product.id}')">Remove</button>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#wishlistContainer').html(
                                '<p class="text-center">No products found in your wishlist.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching wishlist products:', error);
                        $('#wishlistContainer').html(
                            '<p class="text-center text-danger">Failed to load wishlist.</p>');
                    }
                });
            } else {
                $('#wishlistContainer').html('<p class="text-center">Your wishlist is empty.</p>');
            }
        });

        function updateQuantity(button, increment, price) {
            let input = $(button).siblings('.quantity-input');
            let currentQuantity = parseInt(input.val());
            if ((currentQuantity > 1 || increment > 0) && (currentQuantity + increment) > 0) {
                input.val(currentQuantity + increment);

                // Update total price for the row
                let row = $(button).closest('tr');
                let unitPrice = price;
                let totalPrice = unitPrice * (currentQuantity + increment);

                row.find('.total-price').text('NPR. '+ `${totalPrice.toFixed(2)}`);

                // You can add an AJAX request to update the quantity in the backend.
            }
        }

        function removeFromWishlist(productId) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            wishlist = wishlist.filter(id => id != productId);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            location.reload(); // Reload the page to reflect the changes
        }
    </script>
@endsection
