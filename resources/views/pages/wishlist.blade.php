@extends('layouts.app')
@section('style')
    <style>
           .wishlist-table th {
            text-transform: uppercase;
            font-weight: bold;
        }
        .wishlist-table tbody tr {
            vertical-align: middle;
        }
        .wishlist-table .product-title {
            font-weight: bold;
        }
        .wishlist-table .product-sku {
            font-size: 0.9rem;
            color: gray;
        }
        .wishlist-table .old-price {
            text-decoration: line-through;
            color: gray;
        }
        .wishlist-table .new-price {
            color: #ff4500;
            font-weight: bold;
        }
        .wishlist-table .stock-status {
            color: green;
        }
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .added-date {
            font-size: 0.8rem;
            color: gray;
        }
    </style>
@endsection
@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4"><i class="fas fa-heart"></i> Wishlist</h2>
    <div id="wishlistContainer">Loading wishlist...</div>

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        // Get product IDs from local storage
        let productIds = (localStorage.getItem('wishlist'));
        console.log(productIds);
        if (productIds && productIds.length > 0) {
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
                    $('#wishlistContainer').empty(); // Clear loading message
                    if (response.length > 0) {
                        response.forEach(function(product) {
                            $('#wishlistContainer').append(`
                                <div class="wishlist-item">
                                    <h5>${product.title}</h5>
                                    <p>Price: ${product.price}</p>
                                    <img src="${product.image}" alt="${product.title}" style="width: 100px;">
                                </div>
                            `);
                        });
                    } else {
                        $('#wishlistContainer').text('No products found in your wishlist.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching wishlist products:', error);
                    $('#wishlistContainer').text('Failed to load wishlist.');
                }
            });
        } else {
            $('#wishlistContainer').text('Your wishlist is empty.');
        }
    });
</script>
@endsection
