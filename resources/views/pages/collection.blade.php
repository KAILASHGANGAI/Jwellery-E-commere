@extends('layouts.app')

@section('content')
@include('banners.collection-banner')
<div class="container">
    <div class="row">
        
        <!-- Products List -->
        <div class="col-md-12 col-lg-12 p-3 product_black_section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">All Products

                    <select class="form-select d-inline-block w-auto" id="sort">
                        <option selected>20</option>
                        <option value="price-asc">30</option>
                        <option value="price-desc">35</option>
                      
                    </select>
                </h4>

                <!-- Sorting Dropdown -->
                <div>
                    <label for="sort" class="form-label me-2">Sort by:</label>
                    <select class="form-select d-inline-block w-auto" id="sort">
                        <option selected>Default</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="popularity">Popularity</option>
                        <option value="rating">Rating</option>
                        <option value="newest">Newest</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Product Card -->
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="custom-col-5">
                        <div class="single_product">
                            <div class="product_thumb">
                                <a href="#" class="primary_img"><img src="images/product/34.jpg"
                                        alt="product1"></a>
                                <a href="#" class="secondary_img"><img src="images/product/35.jpg"
                                        alt="product1"></a>
                                <div class="quick_button">
                                    <a href="#" data-toggle="modal" data-target="#modal_box"
                                        data-placement="top" data-original-title="quick view">Quick
                                        View</a>
                                </div>
                            </div>
                            <div class="product_content">
                                <div class="tag_cate">
                                    <a href="#">Ring, Necklace,</a>
                                    <a href="#">Earrings</a>
                                </div>
                                <h3><a href="#">Necklace Set</a></h3>
                                <div class="price_box">
                                    <span class="old_price">Rs. 45654</span>
                                    <span class="current_price">Rs. 44015</span>
                                </div>
                                <div class="product_hover">
                                    <div class="product_ratings">
                                        <ul>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product_desc">
                                        <p>This is a gold ring with diamond and Lorem ipsum
                                            dolor sit amet.</p>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li><a href="#" data-placement="top" title="Add to Wishlist"
                                                    data-toggle="tooltip"><span
                                                        class="ion-heart"></span></a></li>
                                            <li class="add_to_cart"><a href="#" title="Add to Cart">Add
                                                    to Cart</a></li>
                                            <li><a href="#" title="Compare"><i
                                                        class="ion-ios-settings-strong"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="custom-col-5">
                        <div class="single_product">
                            <div class="product_thumb">
                                <a href="#" class="primary_img"><img src="images/product/34.jpg"
                                        alt="product1"></a>
                                <a href="#" class="secondary_img"><img src="images/product/35.jpg"
                                        alt="product1"></a>
                                <div class="quick_button">
                                    <a href="#" data-toggle="modal" data-target="#modal_box"
                                        data-placement="top" data-original-title="quick view">Quick
                                        View</a>
                                </div>
                            </div>
                            <div class="product_content">
                                <div class="tag_cate">
                                    <a href="#">Ring, Necklace,</a>
                                    <a href="#">Earrings</a>
                                </div>
                                <h3><a href="#">Necklace Set</a></h3>
                                <div class="price_box">
                                    <span class="old_price">Rs. 45654</span>
                                    <span class="current_price">Rs. 44015</span>
                                </div>
                                <div class="product_hover">
                                    <div class="product_ratings">
                                        <ul>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product_desc">
                                        <p>This is a gold ring with diamond and Lorem ipsum
                                            dolor sit amet.</p>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li><a href="#" data-placement="top" title="Add to Wishlist"
                                                    data-toggle="tooltip"><span
                                                        class="ion-heart"></span></a></li>
                                            <li class="add_to_cart"><a href="#" title="Add to Cart">Add
                                                    to Cart</a></li>
                                            <li><a href="#" title="Compare"><i
                                                        class="ion-ios-settings-strong"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="custom-col-5">
                        <div class="single_product">
                            <div class="product_thumb">
                                <a href="#" class="primary_img"><img src="images/product/34.jpg"
                                        alt="product1"></a>
                                <a href="#" class="secondary_img"><img src="images/product/35.jpg"
                                        alt="product1"></a>
                                <div class="quick_button">
                                    <a href="#" data-toggle="modal" data-target="#modal_box"
                                        data-placement="top" data-original-title="quick view">Quick
                                        View</a>
                                </div>
                            </div>
                            <div class="product_content">
                                <div class="tag_cate">
                                    <a href="#">Ring, Necklace,</a>
                                    <a href="#">Earrings</a>
                                </div>
                                <h3><a href="#">Necklace Set</a></h3>
                                <div class="price_box">
                                    <span class="old_price">Rs. 45654</span>
                                    <span class="current_price">Rs. 44015</span>
                                </div>
                                <div class="product_hover">
                                    <div class="product_ratings">
                                        <ul>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product_desc">
                                        <p>This is a gold ring with diamond and Lorem ipsum
                                            dolor sit amet.</p>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li><a href="#" data-placement="top" title="Add to Wishlist"
                                                    data-toggle="tooltip"><span
                                                        class="ion-heart"></span></a></li>
                                            <li class="add_to_cart"><a href="#" title="Add to Cart">Add
                                                    to Cart</a></li>
                                            <li><a href="#" title="Compare"><i
                                                        class="ion-ios-settings-strong"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="custom-col-5">
                        <div class="single_product">
                            <div class="product_thumb">
                                <a href="#" class="primary_img"><img src="images/product/34.jpg"
                                        alt="product1"></a>
                                <a href="#" class="secondary_img"><img src="images/product/35.jpg"
                                        alt="product1"></a>
                                <div class="quick_button">
                                    <a href="#" data-toggle="modal" data-target="#modal_box"
                                        data-placement="top" data-original-title="quick view">Quick
                                        View</a>
                                </div>
                            </div>
                            <div class="product_content">
                                <div class="tag_cate">
                                    <a href="#">Ring, Necklace,</a>
                                    <a href="#">Earrings</a>
                                </div>
                                <h3><a href="#">Necklace Set</a></h3>
                                <div class="price_box">
                                    <span class="old_price">Rs. 45654</span>
                                    <span class="current_price">Rs. 44015</span>
                                </div>
                                <div class="product_hover">
                                    <div class="product_ratings">
                                        <ul>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                            <li><a href="#"><i class="ion-ios-star-outline"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product_desc">
                                        <p>This is a gold ring with diamond and Lorem ipsum
                                            dolor sit amet.</p>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li><a href="#" data-placement="top" title="Add to Wishlist"
                                                    data-toggle="tooltip"><span
                                                        class="ion-heart"></span></a></li>
                                            <li class="add_to_cart"><a href="#" title="Add to Cart">Add
                                                    to Cart</a></li>
                                            <li><a href="#" title="Compare"><i
                                                        class="ion-ios-settings-strong"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repeat product cards as necessary -->
            </div>
        </div>
    </div>
</div>
@endsection