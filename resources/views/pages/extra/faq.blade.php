@extends('layouts.app')
@section('style')
    <style>
       
        .faq-section {
            padding: 30px 0;
        }

        .faq-section .accordion-button {
            color: #a8741a;
            font-weight: bold;
        }

        .faq-section .accordion-button:focus {
            box-shadow: none;
        }

        .faq-section .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
        }

        .faq-section .accordion-item {
            border-color: #d19c97;
        }

        .faq-section .accordion-body {
            line-height: 1.7;
            padding-left: 2rem;
        }
    </style>
@endsection
@section('content')
    <x-banner title=" Asked Questions" image="{{ asset('images/banner/bg-1.jpg') }}" subTitle="Frequently" />
    <div class="container">
        <div class="row">
            <ldiv class="col-sm-8 mx-auto my-3">
                <!-- FAQ Section -->
                <div class="container faq-section">
                    <div class="accordion" id="faqAccordion">
                        <!-- Question 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeadingOne">
                                <button class="accordion-button btn" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                                    What materials are your jewelry made of?
                                </button>
                            </h2>
                            <div id="faqCollapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Our jewelry is made from high-quality materials including sterling silver, 14k and 18k
                                    gold, and
                                    platinum. We also use genuine gemstones such as diamonds, sapphires, rubies, and
                                    emeralds. Each product
                                    description includes details about the specific materials used.
                                </div>
                            </div>
                        </div>

                        <!-- Question 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeadingTwo">
                                <button class="accordion-button collapsed  btn" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                                    How do I care for my jewelry?
                                </button>
                            </h2>
                            <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    To keep your jewelry looking its best, we recommend storing it in a jewelry box or pouch
                                    when not in
                                    use. Avoid exposure to chemicals, perfumes, and harsh cleaning agents. Clean your pieces
                                    with a
                                    soft cloth and, if needed, mild soap and water. For more delicate pieces, we recommend
                                    professional
                                    cleaning.
                                </div>
                            </div>
                        </div>

                        <!-- Question 3 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeadingThree">
                                <button class="accordion-button collapsed btn" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqCollapseThree" aria-expanded="false"
                                    aria-controls="faqCollapseThree">
                                    What is your return policy?
                                </button>
                            </h2>
                            <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We offer a 30-day return policy on all purchases. Items must be returned in their
                                    original condition,
                                    unused, and in their original packaging. Custom or personalized items are
                                    non-refundable. Please
                                    contact our customer service team to initiate a return.
                                </div>
                            </div>
                        </div>

                        <!-- Question 4 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeadingFour">
                                <button class="accordion-button collapsed btn" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
                                    Do you offer international shipping?
                                </button>
                            </h2>
                            <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we offer international shipping to select countries. Shipping costs and delivery
                                    times vary
                                    based on the destination. You will see the shipping options available to your country
                                    during
                                    checkout. Please note that customs duties and import taxes may apply and are the
                                    responsibility of the
                                    buyer.
                                </div>
                            </div>
                        </div>

                        <!-- Question 5 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeadingFive">
                                <button class="accordion-button collapsed btn" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqCollapseFive" aria-expanded="false" aria-controls="faqCollapseFive">
                                    How do I track my order?
                                </button>
                            </h2>
                            <div id="faqCollapseFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Once your order has been dispatched, you will receive an email with tracking
                                    information. You can
                                    use the tracking number provided to check the status of your delivery on the courier’s
                                    website.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </ldiv>
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection