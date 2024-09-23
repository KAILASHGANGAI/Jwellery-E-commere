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
                    @if (!$products->count())
                        <div class="col-md-12"></div>
                        <div class="alert alert-danger" role="alert">
                            No Products Found
                        </div>
                    @endif
                    @foreach ($products as $product)
                    <div class="single_product col-lg-2 col-sm-3 col-md-2  mx-auto">
                        <div class="product_thumb">
                            <!-- Dynamically populate primary image (first image in the array) -->
                            <a href="{{ route('product-details', $product->slug) }}" class="primary_img">
                                <img src="{{ asset($product->images[0]->image_path) }}">
                            </a>
                            <!-- Dynamically populate secondary image (second image in the array if exists) -->
                            <a href="{{ route('product-details', $product->slug) }}" class="secondary_img">
                                <img src="{{ asset($product->images[1]->image_path ?? $product->images[0]->image_path) }}"
                                    alt="{{ $product->title }}">
                            </a>

                            <div class="quick_button">
                                <!-- Quick View button with dynamic product data -->
                                <a href="javascript:void(0)" class="quick_view_button" data-toggle="modal"
                                    data-target="#modal_box" data-id="{{ $product->id }}" data-slug="{{ $product->slug }}"
                                    data-name="{{ $product->title }}" data-price="{{ $product->price }}"
                                    data-old-price="{{ $product->compare_price }}"
                                    data-description="{{ $product->description }}"
                                    data-images='{{ json_encode($product->images) }}'>
                                    Quick View
                                </a>
                            </div>
                        </div>
                        <div class="product_content">
                            <div class="tag_cate">
                                <a href="#">{{ $product->collections }}</a>
                            </div>
                            <h3><a href="{{ route('product-details', $product->slug) }}">{{ $product->title }}</a></h3>
                            <div class="price_box">
                                <span class="old_price">Rs. {{ $product->compare_price }}</span> <br>
                                <span class="current_price">Rs. {{ $product->price }}</span>
                            </div>
                            <div class="product_hover">
                                <div class="product_ratings">
                                    <ul>
                                        <li><a href="javascript:void(0)"><i
                                                    class="ion-ios-star-outline text-warning"></i></a></li>
                                        <li><a href="javascript:void(0)"><i
                                                    class="ion-ios-star-outline text-warning"></i></a></li>
                                        <li><a href="javascript:void(0)"><i
                                                    class="ion-ios-star-outline text-warning"></i></a></li>
                                        <li><a href="javascript:void(0)"><i
                                                    class="ion-ios-star-outline text-warning"></i></a></li>
                                        <li><a href="javascript:void(0)"><i
                                                    class="ion-ios-star-outline text-warning"></i></a></li>
                                    </ul>
                                </div>

                                <div class="action_links">
                                    <ul>
                                        <li><a id="wishlist-btn" class="add_to_wishlist" href="javascript:void(0)"
                                                data-placement="top" data-product-id="${{ $product->id }}"
                                                title="Add to Wishlist" data-toggle="tooltip"><span
                                                    class="ion-heart"></span></a></li>
                                        <!-- Add to Cart button with dynamic product data -->
                                        <li class="add_to_cart">
                                            <a href="javascript:void(0)" data-id="{{ $product->id }}"
                                                data-price="{{ $product->price }}" data-sku="{{ $product->variations[0]->sku }}" data-varination-id="{{ $product->variations[0]->id }}"
                                                class="add_to_cart_button" title="Add to Cart">Add to Cart</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Repeat product cards as necessary -->
        </div>
    </div>
    </div>
    </div>
@endsection
