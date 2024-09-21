<!-- product section area starts -->
<section class="product_section p_section1 product_black_section bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Bestselling Products</h2>
                </div>
            </div>
            <div class="col-12">
                <div class="product-area">
                    <div class="product_container bottom">
                        <div class="custom-row product_row1">
                            <!-- Products will be dynamically injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product section area ends -->

<script>
    var requestData = {
        tag: 'bestselling', // example data (filter by category)
        order: 'id',
        orderType: 'desc',
        pagination: 10
    };

    function loadProducts() {
        $.ajax({
            url: "{{ route('web.products') }}", // URL for fetching the products
            type: "GET",
            dataType: "json",
            data: requestData,
            success: function(response) {
                var products = response; // Assuming response contains products array
                var productHtml = '';

                // Loop through products and build HTML
                $.each(products, function(index, product) {
                    const primaryImage = product.images[0].image_path ??
                        '{{ asset('images/default-img.jpg') }}';
                    const secondaryImage = product.images[1].image_path ?? primaryImage ??
                        '{{ asset('images/default-img.jpg') }}';
                        let viewUrl = '{{ route('product-details', "slug") }}';

                        // Replace 'slug' with the actual product slug
                        viewUrl = viewUrl.replace('slug', product.slug);


                    productHtml += `
                     <div class="custom-col-5">
    <div class="single_product">
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
                            <a href="javascript:void(0)" data-id="${product.id}" data-price="${product.price}" data-sku="" class="add_to_cart_button" title="Add to Cart">Add to Cart</a>
                        </li>
                      
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
`;
                });

                // Append product HTML to the carousel container
                $(".product_row1").html(productHtml);

                // Reinitialize Slick after adding new items
                $(".product_row1").slick('unslick'); // Remove old instance
                initializeSlick(); // Reinitialize with new products
            },
            error: function(error) {
                console.log("Error fetching products:", error);
            }
        });
    }

    function initializeSlick() {
        $(".product_row1").slick({
            centerMode: true,
            centerPadding: "0",
            slidesToShow: 5,
            arrows: true,
            prevArrow: '<button class="prev_arrow"><i class="ion-chevron-left"></i></button>',
            nextArrow: '<button class="next_arrow"><i class="ion-chevron-right"></i></button>',
            responsive: [{
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    },
                },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    },
                },
            ],
        });
    }

    // Initialize Slick when the page loads
    $(document).ready(function() {
        initializeSlick();

        // Load dynamic products
        loadProducts();
    });

 
</script>
