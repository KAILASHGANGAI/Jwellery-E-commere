@extends('layouts.app')
@section('style')
<style>
   
   
    .terms-section {
        padding: 30px 0;
    }

    .terms-section h2 {
        color: #a8741a;
        margin-bottom: 20px;
    }

    .terms-section p {
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .terms-section ul {
        padding-left: 20px;
    }

    .terms-section ul li {
        margin-bottom: 10px;
    }
</style>
@endsection
@section('content')
    <x-banner title="Terms and Conditions" image="{{ asset('images/banner/bg-1.jpg') }}" subTitle=" " />

    <div class="container">
        <div class="row">
            <div class="col-sm-8 mx-auto my-3">
                <!-- Terms and Conditions Sections -->
                <div class="container terms-section">
                    <div class="row">
                        <!-- Introduction -->
                        <div class="col-lg-12 mb-5">
                            <h2>Introduction</h2>
                            <p>Welcome to Jewelry Store. By using our website and purchasing our products, you agree to
                                comply with and
                                be bound by the following terms and conditions. Please review them carefully before placing
                                your
                                order.</p>
                        </div>

                        <!-- Purchases -->
                        <div class="col-lg-12 mb-5">
                            <h2>Purchases</h2>
                            <p>By placing an order with us, you agree that you are over 18 years of age and legally capable
                                of entering
                                into binding contracts. All orders are subject to acceptance and availability.</p>
                            <ul>
                                <li>We reserve the right to refuse any order at our discretion.</li>
                                <li>Pricing and availability of products are subject to change without notice.</li>
                                <li>In case of an error in pricing, we will inform you and give you the option to proceed or
                                    cancel
                                    the order.</li>
                            </ul>
                        </div>

                        <!-- Payment -->
                        <div class="col-lg-12 mb-5">
                            <h2>Payment</h2>
                            <p>We accept various forms of payment, including credit cards, PayPal, and other methods as
                                displayed at
                                checkout. Payments must be made in full at the time of purchase.</p>
                            <ul>
                                <li>All transactions are secure, and your payment information will be protected.</li>
                                <li>In the event of payment failure, the order will not be processed.</li>
                                <li>We do not store your credit card information.</li>
                            </ul>
                        </div>

                        <!-- Shipping and Delivery -->
                        <div class="col-lg-12 mb-5">
                            <h2>Shipping and Delivery</h2>
                            <p>We aim to deliver your purchase within the estimated delivery time, but we cannot guarantee
                                any delivery
                                dates. Once the order is dispatched, you will receive tracking information via email.</p>
                            <ul>
                                <li>Shipping times may vary depending on your location.</li>
                                <li>We are not responsible for any delays caused by third-party delivery services.</li>
                                <li>Customs fees and import taxes are the responsibility of the customer.</li>
                            </ul>
                        </div>

                        <!-- Returns and Refunds -->
                        <div class="col-lg-12 mb-5">
                            <h2>Returns and Refunds</h2>
                            <p>If you are not satisfied with your purchase, you may return it within 30 days of delivery for
                                a refund
                                or exchange. Items must be returned in their original, unused condition.</p>
                            <ul>
                                <li>Return shipping costs are the responsibility of the customer.</li>
                                <li>Refunds will be processed within 5-7 business days of receiving the returned item.</li>
                                <li>We reserve the right to refuse returns if the item is not in its original condition.
                                </li>
                            </ul>
                        </div>

                        <!-- Intellectual Property -->
                        <div class="col-lg-12 mb-5">
                            <h2>Intellectual Property</h2>
                            <p>All content on this website, including but not limited to text, images, logos, and designs,
                                is the
                                intellectual property of Jewelry Store or its content suppliers. Unauthorized use of any
                                materials
                                from this site is strictly prohibited.</p>
                        </div>

                        <!-- Liability -->
                        <div class="col-lg-12 mb-5">
                            <h2>Liability</h2>
                            <p>We are not responsible for any indirect, incidental, or consequential damages arising from
                                the use of
                                our website or products. Our liability is limited to the total price of the goods purchased
                                by you.</p>
                        </div>

                        <!-- Governing Law -->
                        <div class="col-lg-12 mb-5">
                            <h2>Governing Law</h2>
                            <p>These terms and conditions are governed by and construed in accordance with the laws of [Your
                                Country].
                                Any disputes relating to these terms and conditions will be subject to the exclusive
                                jurisdiction of
                                the courts of [Your Country].</p>
                        </div>

                        <!-- Changes to Terms and Conditions -->
                        <div class="col-lg-12 mb-5">
                            <h2>Changes to Terms and Conditions</h2>
                            <p>We reserve the right to update or modify these terms and conditions at any time without prior
                                notice.
                                Your continued use of the website after any changes signifies your acceptance of the updated
                                terms and
                                conditions.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
