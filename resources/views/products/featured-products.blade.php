<section class="product_section p_section1 product_black_section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="product_area">
                    <div class="product_tab_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a href="#featured" class="tab-link active" data-category="featured">Featured</a>
                            </li>
                            <li>
                                <a href="#arrivals" class="tab-link" data-category="new">New Arrivals</a>
                            </li>
                            <li>
                                <a href="#onsale" class="tab-link" data-category="onsale">On-Sale</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <!-- Featured Products -->
                        <div class="tab-pane fade show active">
                            <div class="product_container row" id="product-container">

                            </div>
                        </div>

                        <!-- Repeat similar structure for New Arrivals and On-Sale Products -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        // Function to load products by category
        function loadProducts(category = 'featured') {
            $.ajax({
                url: '{{ route('web.products') }}', // Your endpoint
                method: 'GET',
                data: {
                    tag: category,
                    pagination: 12,
                    order: 'created_at',
                    orderType: 'desc'
                }, // Send the selected category
                success: function(response3) {
                    // Clear the current products
                    $('#product-container').empty();

                    // Loop through the products and append them to the container
                    response3.forEach(function(product) {
                        const primaryImage = product.images[0].image_path ??
                            '{{ asset('images/default-img.jpg') }}';
                        const secondaryImage = product.images[1].image_path ??
                            primaryImage ??
                            '{{ asset('images/default-img.jpg') }}';
                        let viewUrl = '{{ route('product-details', 'slug') }}';

                        // Replace 'slug' with the actual product slug
                        viewUrl = viewUrl.replace('slug', product.slug);

                        $('#product-container').append(`
                            <div class="single_product  col-sm-6  col-md-4 col-lg-2 mx-auto">
                            <div class="product_thumb">
                                <!-- Dynamically populate primary image (first image in the array) -->
                                <a href="${viewUrl}" class="primary_img">
                                    <img src="${primaryImage}" alt="${product.title}">
                                </a>
                                <!-- Dynamically populate secondary image (second image in the array if exists) -->
                                <a href="${viewUrl}" class="secondary_img">
                                    <img src="${secondaryImage}" alt="${product.title}">
                                </a>
                                <div class="quick_button">
                                    <!-- Quick View button with dynamic product data -->
                                    <a href="javascript:void(0)" class="quick_view_button" 
                                    data-toggle="modal" data-target="#modal_box"
                                    data-id="${product.id}" 
                                    data-slug="${product.slug}"
                                    data-name="${product.title}" 
                                    data-price="${product.price}" 
                                    data-old-price="${product.compare_price}" 
                                    data-description="${product.description}" 
                                    data-sku="${product.variations[0].sku}"
                                    data-varination-id="${product.variations[0].id}"
                                    data-images='${JSON.stringify(product.images)}'>
                                        Quick View
                                    </a>
                                </div>
                            </div>
                            <div class="product_content">
                                <div class="tag_cate">
                                    <a href="#">${product.collections}</a>
                                </div>
                                <h3><a href="${viewUrl}">${product.title}</a></h3>
                                <div class="price_box">
                                    <span class="old_price">Rs. ${product.compare_price}</span>
                                    <span class="current_price">Rs. ${product.price}</span>
                                </div>
                                <div class="product_hover">
                                    <div class="product_ratings">
                                        <ul>
                                            <li><a href="javascript:void(0)"><i class="ion-ios-star-outline text-warning"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="ion-ios-star-outline text-warning"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="ion-ios-star-outline text-warning"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="ion-ios-star-outline text-warning"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="ion-ios-star-outline text-warning"></i></a></li>
                                        </ul>
                                    </div>
                            
                                    <div class="action_links">
                                        <ul>
                                            <li><a id="wishlist-btn" class="add_to_wishlist" href="javascript:void(0)"  data-placement="top" data-product-id="${product.id}" title="Add to Wishlist" data-toggle="tooltip"><span class="ion-heart"></span></a></li>
                                            <!-- Add to Cart button with dynamic product data -->
                                            <li class="add_to_cart">
                                                <a href="javascript:void(0)" data-id="${product.id}" data-price="${product.price}" data-sku="${product.variations[0].sku}" data-varination-id="${product.variations[0].id}" class="add_to_cart_button" title="Add to Cart">Add to Cart</a>
                                            </li>
                                        
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                </div>
                            </div>
                    `);
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching products:', xhr);
                }
            });
        }

        // Load featured products by default when page loads
        loadProducts();

        // Handle tab link clicks
        $('.tab-link').on('click', function(event) {
            event.preventDefault(); // Prevent default anchor behavior
            // Remove active class from all tabs
            $('.tab-link').removeClass('active');

            // Add active class to the clicked tab
            $(this).addClass('active');

            // Get the category from data attribute
            const category = $(this).data('category');
            console.log(category);

            // Fetch products based on the selected category
            loadProducts(category);
        });
    });
</script>
