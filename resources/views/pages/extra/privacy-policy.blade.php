@extends('layouts.app')
@section('style')
    <style>
        .policy-header h1 {
            color: #a8741a;
            font-size: 2.5rem;
        }

        .policy-section {
            padding: 30px 0;
        }

        .policy-section h2 {
            color: #a8741a;
            margin-bottom: 20px;
        }

        .policy-section p {
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .policy-section ul {
            padding-left: 20px;
        }

        .policy-section ul li {
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('content')
    <x-banner title="Policy" image="{{ asset('images/banner/bg-1.jpg') }}" subTitle="Return and Exchanges" />

    <div class="container">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <!-- Policy Sections -->
                <div class="container policy-section">
                    <div class="row">
                        <!-- Shipping Policy -->
                        <div class="col-lg-12 my-5 ">
                            <h2>Shipping Policy</h2>
                            <p>We offer free shipping on all orders over $100. Orders are processed within 2-3 business days
                                and
                                shipped
                                via our trusted delivery partners. You will receive a tracking number once your order has
                                been
                                dispatched.</p>
                            <ul>
                                <li>Free shipping on orders over $100</li>
                                <li>Orders processed within 2-3 business days</li>
                                <li>Tracking number provided once dispatched</li>
                                <li>Delivery times vary depending on your location</li>
                            </ul>
                        </div>

                        <!-- Return Policy -->
                        <div class="col-lg-12 mb-5">
                            <h2>Return Policy</h2>
                            <p>We want you to be happy with your purchase. If you're not satisfied, you may return the item
                                within 30
                                days
                                of receiving your order for a full refund or exchange, provided it is unused and in its
                                original
                                condition.</p>
                            <ul>
                                <li>Returns accepted within 30 days of receipt</li>
                                <li>Items must be unused and in their original condition</li>
                                <li>Refunds will be processed within 5-7 business days</li>
                                <li>Return shipping fees are the responsibility of the customer</li>
                            </ul>
                        </div>

                        <!-- Privacy Policy -->
                        <div class="col-lg-12 mb-5">
                            <h2>Privacy Policy</h2>
                            <p>Your privacy is important to us. We are committed to protecting your personal information and
                                ensuring
                                that
                                your shopping experience is safe and secure. Please refer to our detailed privacy policy
                                below.</p>
                            <ul>
                                <li>We collect personal information only for order processing and shipping purposes</li>
                                <li>Your information will never be sold or shared with third parties</li>
                                <li>We use secure payment gateways to protect your financial information</li>
                                <li>You can opt out of our marketing communications at any time</li>
                            </ul>
                        </div>

                        <!-- Terms of Service -->
                        <div class="col-lg-12 mb-5">
                            <h2>Terms of Service</h2>
                            <p>By using our website and making a purchase, you agree to our terms and conditions. We reserve
                                the
                                right to
                                update or modify our policies at any time without prior notice. Please review our terms
                                regularly to
                                stay
                                informed about any changes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
