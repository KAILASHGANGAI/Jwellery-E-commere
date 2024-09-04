@extends('layouts.app')

@section('content')

@include('banners.contact-banner')
<section id="contact-us" class="py-5">
    <div class="container">
        <div class="row">
            <!-- Address Section -->
            <div class="col-lg-6 mb-4">
                <h2 class="display-5">Contact Us</h2>
                <p class="lead">
                    We'd love to hear from you! Whether you have a question about our services, pricing, or anything else, our team is ready to answer all your questions.
                </p>
                <h5 class="mt-4">Our Address</h5>
                <p>
                    <strong>Office:</strong> 1234 Main Street, Suite 500<br>
                    Springfield, IL 62704<br>
                    <strong>Email:</strong> contact@yourdomain.com<br>
                    <strong>Phone:</strong> (123) 456-7890
                </p>
            </div>

            <!-- Get in Touch Form -->
            <div class="col-lg-6">
                <h5 class="mb-4">Get in Touch</h5>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Your Name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Your Email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection