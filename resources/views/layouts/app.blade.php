<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Jewelry</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('includes.metadata')
    @include('includes.links')
</head>
@yield('style')
<body>
    <div class="home_black_version">
        @include('includes.navbar')

        @yield('content')

        @include('includes.footer')
    </div>

    <!-- Modal section starts -->
    <div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal_body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="modal_tab">
                                    <div class="tab-content product-details-large">
                                        <!-- Dynamically loaded images will go here -->
                                        <div id="modal_product_images">
                                            <!-- Product images loaded dynamically -->
                                        </div>
                                    </div>
                                    <div class="modal_tab_button">
                                        <ul class="nav product_navactive owl-carousel d-inline-flex"
                                            id="modal_product_thumbnails">
                                            <!-- Dynamically loaded thumbnails will go here -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12">
                                <div class="modal_right">
                                    <div class="modal_title mb-10">
                                        <h2 id="modal_product_name">Product Name</h2>
                                    </div>
                                    <div class="modal_price mb-10">
                                        <span class="new_price" id="modal_product_price">Rs. 0</span>
                                        <span class="old_price" id="modal_product_old_price">Rs. 0</span>
                                    </div>
                                    <div class="see_all">
                                        <a href="#" id="see_all">See All Features</a>
                                    </div>
                                    <div class="modal_add_to_cart mb-15">
                                        <form id="modal_add_to_cart_form" action="javascript:void(0)">
                                            <input type="number" id="modal_product_quantity" min="1"
                                                value="1">
                                            <input type="hidden" id="modal_product_id">
                                            <input type="hidden" id="modal_product_sku">
                                            <input type="hidden" id="modal_variation_id">
                                            <button type="submit">Add To Cart</button>
                                            <a class="add_to_wishlist btn btn-dark" href="javascript:void(0)"
                                                id="wishlist-btn" data-placement="top" title="Add to Wishlist"
                                                data-toggle="tooltip">
                                                <span class="ion-heart"></span></a>

                                        </form>

                                    </div>
                                    {{-- <div class="modal_description mb-15">
                                        <p id="modal_product_description">Description will be here</p>
                                    </div> --}}
                                    <div class="modal_social">
                                        <h2>Share this Product</h2>
                                        <ul>
                                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                            <li><a href="#"><i class="ion-social-rss"></i></a></li>
                                            <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                            <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal section ends -->


    <!-- modal section ends -->
    @include('includes.scripts')
    @yield('scripts')
    <script>
        window.isAuthenticated = @json(auth()->check());
        // Reusable function to add a product to the cart
        function addToCart(cardDetails, element) {

            if (!window.isAuthenticated) {
                window.location.href = "{{ route('login') }}";
            }

            // Optional: Disable the button and show a loading state
            element.prop('disabled', true).text('Adding...');

            // Perform AJAX request to add the product to the cart
            $.ajax({
                url: "{{ route('cart.add') }}", // Laravel route for adding to cart
                type: "POST",
                data: cardDetails,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token for security
                },
                success: function(response) {

                    // card-total 
                    $('#cart-total').text(formatPriceNepali(response.totalAmount));
                    // card aquantity
                    $('#cart-quantity').text(response.totalQuantity);
                    // Handle success response, such as updating the cart UI
                    alert("Product added to cart successfully!");

                    // Re-enable the button and reset the text
                    element.prop('disabled', false).text('Add to Cart');

                    // Optionally update the cart icon or total number of items in the cart
                    updateCartUI(response.cart);

                    // Optionally close the modal if it's a modal submission
                    $('#modal_box').modal('hide');
                },
                error: function(error) {
                    // Handle error, such as showing a message to the user
                    console.error("Error adding product to cart:", error);

                    // Re-enable the button in case of error
                    element.prop('disabled', false).text('Add to Cart');
                }
            });
        }

        // Handle Add to Cart button click (outside modal)
        $(document).on('click', '.add_to_cart_button', function(event) {
            event.preventDefault();
            //check auth of laravel auth

            var product_id = $(this).data('id');
            var variation_id = $(this).data('varination-id');
            var sku = $(this).data('sku');
            var unitPrice = $(this).data('price');
            // var discount = $(this).data('discount');
            // var discountCode = $(this).data('discount-code');
            var quantity = 1;
            var cardDetails = {
                "product_id": product_id,
                "variation_id": variation_id,
                "sku": sku,
                "quantity": quantity,
                "unit_price": unitPrice,
                // "discount": discount,
                // "discountCode": discountCode
            };
            console.log(cardDetails);
            // Call reusable function to add the product to the cart
            addToCart(cardDetails, $(this));
        });

        // Handle Add to Cart form submission from the modal
        $(document).on('submit', '#modal_add_to_cart_form', function(event) {
            event.preventDefault();

            // Get product ID and quantity from the modal form
            var product_id = $('#modal_product_id').val();
            var variation_id = $('#modal_variation_id').val();
            var sku = $('#modal_product_sku').val();
            var unitPrice = $('#modal_product_price').attr('data-price')
            // var discount = $('#modal_product_discount').val();
            // var discountCode = $('#modal_product_discount_code').val();
            var quantity = $('#modal_product_quantity').val();

            var cardDetails = {

                "product_id": product_id,
                "variation_id": variation_id,
                "sku": sku,
                "quantity": quantity,
                "unit_price": unitPrice,
                // "discount": discount,
                // "discountCode": discountCode
            };
            console.log(cardDetails);
            // Call reusable function to add the product to the cart
            addToCart(cardDetails, $(this).find('button'));
        });

        // Function to update the cart UI (like cart item count)
        function updateCartUI(cart) {
            // Example: Update the total cart items in the UI
            var totalItems = cart.length;
            $('#cart_items_count').text(totalItems);

            // Optionally update other parts of the cart UI like total price, etc.
            // $('#cart_total_price').text(cart.total_price);
        }

        // Event listener for the wishlist button (outside modal)
        $(document).on('click', '.add_to_wishlist', function(e) {
            e.preventDefault();
            let productId = $(this).data('product-id');
            addToWishlist(productId);
        })


        // Function to add product to localStorage uniquely
        function addToWishlist(productId) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

            // Add product only if it's not already in the wishlist
            if (!wishlist.includes(productId)) {
                wishlist.push(productId);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                alert('Item added to local wishlist!');
            } else {
                alert('Item is already in your local wishlist.');
            }
        }

        // When "Quick View" button is clicked
        $(document).on('click', '.quick_view_button', function() {
            // Retrieve product data from data attributes
            var productId = $(this).data('id');
            var productName = $(this).data('name');
            var productPrice = $(this).data('price');
            var productOldPrice = $(this).data('old-price');
            var productDescription = $(this).data('description');
            var productSku = $(this).data('sku');
            var productVariationId = $(this).data('varination-id');
            var productImages = $(this).data('images');
            var slug = $(this).data('slug');
            console.log(slug);
            var viewUrl = '{{ route('product-details', ':slug') }}';
            viewUrl = viewUrl.replace(':slug', slug);
            // Update the modal with product details
            $('#modal_product_id').val(productId);
            $('#modal_box .modal_title h2').text(productName);
            $('#modal_box .modal_price .new_price').text('Rs. ' + productPrice);
            $('#modal_product_price').attr('data-price', productPrice);

            $('#modal_box .modal_price .old_price').text('Rs. ' + productOldPrice);
            $('#modal_box .modal_description p').html(productDescription);
            $('#modal_box #modal_product_sku').val(productSku);
            $('#modal_box #modal_variation_id').val(productVariationId);
            $('#modal_box #see_all').attr('href', viewUrl);
            // Update product images in the modal
            var imageHtml = '';
            var thumbnailHtml = '';
            $.each(productImages, function(index, image) {
                const imageSrc = '{{ asset('') }}' + image.image_path ??
                    '{{ asset('images/default-img.jpg') }}';
                imageHtml += `
                    <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="tab${index + 1}" role="tabpanel">
                        <div class="modal_tab_img">
                            <a href="#"><img src="${imageSrc}" alt="${productName}"></a>
                        </div>
                    </div>`;
                                thumbnailHtml += `
                    <li style="cursor: pointer; width: 50px; height: 50px;" class="nav-item">
                        <a href="#tab${index + 1}" class="nav-link ${index === 0 ? 'active' : ''}" data-toggle="tab" role="tab"
                            aria-controls="tab${index + 1}" aria-selected="${index === 0}">
                            <img src="${imageSrc}" height="50" alt="Product Thumbnail">
                        </a>
                    </li>`;
            });

            // Append images to the modal
            $('#modal_box .product-details-large').html(imageHtml);
            $('#modal_box .product_navactive').html(thumbnailHtml);
            // Open the modal
            $('#modal_box').modal('show');

            let wishlistBtn = $('#modal_box #wishlist-btn');

            if (!wishlistBtn.attr('data-product-id')) {
                // If no `data-product-id` exists, assign the new productId
                wishlistBtn.attr('data-product-id', productId);
                console.log(`Product ID ${productId} assigned to the wishlist button.`);
            } else {
                console.log(`Wishlist button already has a product ID: ${wishlistBtn.attr('data-product-id')}`);
            }

        });
    </script>

</body>

</html>
