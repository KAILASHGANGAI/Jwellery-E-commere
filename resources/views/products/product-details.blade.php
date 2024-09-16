@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="modal_tab">
                    <div class="tab-content product-details-large">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <div class="modal_tab_img">
                                <a href="#"><img src="images/product/70.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <div class="modal_tab_img">
                                <a href="#"><img src="images/product/71.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                            <div class="modal_tab_img">
                                <a href="#"><img src="images/product/72.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab4" role="tabpanel">
                            <div class="modal_tab_img">
                                <a href="#"><img src="images/product/73.jpg" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="modal_tab_button">
                        <ul class="nav product_navactive owl-carousel" role="tablist">
                            <li>
                                <a href="#tab1" class="nav-link active" data-toggle="tab" role="tab"
                                    aria-controls="tab1" aria-selected="false"><img src="images/product/70.jpg"
                                        alt=""></a>
                            </li>
                            <li>
                                <a href="#tab2" class="nav-link" data-toggle="tab" role="tab" aria-controls="tab2"
                                    aria-selected="false"><img src="images/product/71.jpg" alt=""></a>
                            </li>
                            <li>
                                <a href="#tab3" class="nav-link button_three" data-toggle="tab" role="tab"
                                    aria-controls="tab3" aria-selected="false"><img src="images/product/72.jpg"
                                        alt=""></a>
                            </li>
                            <li>
                                <a href="#tab4" class="nav-link" data-toggle="tab" role="tab" aria-controls="tab4"
                                    aria-selected="false"><img src="images/product/73.jpg" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="modal_right">
                    <div class="modal_title mb-10">
                        <h2>Women's Necklace</h2>
                    </div>
                    <div class="modal_price mb-10">
                        <span class="new_price">Rs. 51164</span>
                        <span class="old_price">Rs. 54164</span>
                    </div>

                    <div class="modal_add_to_cart mb-15">
                        <form action="#">
                            <input class="bg-white" type="number" min="0" max="100" step="1"
                                placeholder="1">
                            <button type="submit">Add To Cart</button>
                        </form>
                    </div>
                    <div class="  mb-15">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus quibusdam
                            nisi voluptas consequatur tempora, recusandae nemo blanditiis eaque odit
                            voluptatibus voluptatem, ipsa incidunt fugiat a.</p>
                    </div>
                    <div class="modal_social">
                        <h2>Share this Product</h2>
                        <ul>
                            <li class=""><a class="" href="#"><i
                                        class="ion-social-facebook"></i></a></li>
                            <li class=""><a class="" href="#"><i
                                        class="ion-social-twitter"></i></a></li>
                            <li class=""><a class="" href="#"><i class="ion-social-rss"></i></a>
                            </li>
                            <li class=""><a class="" href="#"><i
                                        class="ion-social-googleplus"></i></a></li>
                            <li class=""><a class="" href="#"><i
                                        class="ion-social-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <section class="product_section p_section1 product_black_section mt-4" >
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
                                
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, voluptate</p>
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
