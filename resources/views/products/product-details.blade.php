@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="modal_tab">
                    <div class="tab-content product-details-large">

                        @foreach ($data->images as $key => $image)
                            <div class="tab-pane fade show {{ $key === 0 ? 'active' : '' }} " id="tab{{ $key + 1 }}"
                                role="tabpanel">
                                <div class="modal_tab_img">
                                    <a href="javascript:void(0)"><img src="{{ asset($image->image_path) }}"
                                            alt="{{ $data->title }}"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal_tab_button">
                        <ul class="nav product_navactive owl-carousel" role="tablist">

                            @foreach ($data->images as $key => $image)
                                <li>
                                    <a href="#tab{{ $key + 1 }}" class="nav-link {{ $key === 0 ? 'active' : '' }} "
                                        data-toggle="tab" role="tab" aria-controls="tab{{ $key + 1 }}"
                                        aria-selected="false"><img src="{{ asset($image->image_path) }}" alt=""></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="modal_right">
                    <div class="modal_title mb-10  mt-5">
                        <h2>{{ $data->title }}</h2>
                    </div>
                    <div class="modal_price mb-10">
                        <span class="new_price">Rs. {{ $data->price }}</span>
                        <span class="old_price">Rs. {{ $data->compare_price }}</span>
                    </div>

                    <div class="modal_add_to_cart mb-15">
                        <form id="modal_add_to_cart_form" action="javascript:void(0)">
                            <input type="number" id="modal_product_quantity" min="1" value="1">
                            <input type="hidden" id="modal_product_id"  value="{{ $data->id }}">
                            <input type="hidden" id="modal_product_sku"  value="{{ $data->variations[0]['sku'] }}">
                            <button type="submit">Add To Cart</button>
                            <a class="add_to_wishlist btn btn-dark" href="javascript:void(0)" id="wishlist-btn"
                                data-placement="top" title="Add to Wishlist" data-product-id="{{ $data->id }}" data-toggle="tooltip">
                                <span class="ion-heart"></span></a>

                        </form>
                    </div>
                    <div class=" mb-15">
                        <p>{{ !empty($data->description) ? $data->description : 'No description' }}</p>
                    </div>
                    <div class="modal_social mt-4">
                        <h2>Share this Product</h2>
                        <ul>
                            <li class=""><a class="" href="#"><i class="ion-social-facebook"></i></a></li>
                            <li class=""><a class="" href="#"><i class="ion-social-twitter"></i></a></li>
                            <li class=""><a class="" href="#"><i class="ion-social-rss"></i></a>
                            </li>
                            <li class=""><a class="" href="#"><i class="ion-social-googleplus"></i></a>
                            </li>
                            <li class=""><a class="" href="#"><i class="ion-social-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <section class="product_section p_section1 product_black_section mt-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="product_area">
                        <div class="product_tab_button">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a href="#details" class="active" data-toggle="tab" role="tab"
                                        aria-controls="details" aria-selected="true">Product Details</a>
                                </li>
                                <li>
                                    <a href="#policies" data-toggle="tab" role="tab" aria-controls="policies"
                                        aria-selected="false">Delivary & Return Policy</a>
                                </li>
                                <li>
                                    <a href="#review" data-toggle="tab" role="tab" aria-controls="review"
                                        aria-selected="false">Review</a>
                                </li>

                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="details" role="tabpane1">
                                <div class="product_container">
                                    {{ !empty($data->description) ? $data->description : 'No description' }}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="policies" role="tabpane1">
                                <div class="product_container">

                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, voluptate</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="review" role="tabpane1">
                                <div class="product_container">

                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, voluptate</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
