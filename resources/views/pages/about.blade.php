@extends('layouts.app')

@section('content')

@include('banners.about-banner')

<section id="about-us" class="py-5">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <h2 class="display-4">About Us</h2>
                <p class="lead">
                    We are a passionate team dedicated to providing the best products and services. With years of experience, we strive to exceed our customers' expectations by delivering quality and excellence in everything we do.
                </p>
                <p>
                    Our journey began with a simple idea: to make a positive impact on our community. Today, we continue to innovate and push the boundaries of what's possible, always with our customers' needs in mind.
                </p>
            </div>
            {{-- <div class="col-lg-6">
                <img src="your-image.jpg" class="img-fluid rounded" alt="About Us Image">
            </div> --}}
        </div>
    </div>
</section>

@endsection