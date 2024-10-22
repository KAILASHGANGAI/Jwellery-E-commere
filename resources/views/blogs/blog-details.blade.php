@extends('layouts.app')
@section('style')
<style>
    .blog-single {
    border-radius: 8px;
    overflow: hidden;
}

.blog-image {
    height: 450px;
    object-fit: cover;
}

.blog-meta {
    font-size: 0.9rem;
    color: #6c757d;
}

.blog-content p {
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.blog-tags .badge {
    margin-right: 0.5rem;
}

.comments-section {
    border-top: 1px solid #e9ecef;
    padding-top: 1.5rem;
}

.comments-section .media {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.comments-section .media img {
    width: 50px;
    height: 50px;
}

.comment-form textarea {
    resize: none;
}
.recent-blogs .list-group-item {
    padding: 0.75rem 1.25rem;
    transition: background-color 0.3s ease;
    border: none;
}

.recent-blogs .list-group-item:hover {
    background-color: #f8f9fa;
}

.blog-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 5px;
}

.blog-title {
    font-size: 1rem;
    font-weight: 500;
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.blog-title:hover {
    color: #007bff;
}


</style>
@endsection
@section('content')
@isset($blog->featured_image)
     {{-- <x-banner :title="$blog->title" :subTitle="$blog->createdBy->name" :link="route('blog.show', $blog->slug)" 
        :image=" asset($blog->featured_image)   " /> --}}
@endisset

<div class="container mt-5">
    <div class="row">
        <!-- Main Blog Content Area -->
        <div class="col-lg-8">
            <!-- Blog Post -->
            <div class="card shadow-sm mb-4 blog-single">
                <!-- Blog Image -->
                <img src="{{ asset($blog->featured_image ?? 'images/default-img.jpg') }}" class="card-img-top blog-image" alt="Blog Image">

                <!-- Blog Details -->
                <div class="card-body">
                    <!-- Blog Title -->
                    <h1 class="card-title">{{ $blog->title }}</h1>

                    <!-- Blog Meta Information -->
                    <div class="blog-meta mb-3">
                        <span class="text-muted">Published on: <strong>{{ $blog->created_at->format('d M Y') }}</strong></span> |
                        <span class="text-muted">By: <strong>{{ $blog->createdBy->name }}</strong></span>
                    </div>

                    <!-- Blog Content -->
                    <p class="card-text blog-content">
                        {!! $blog->content !!}
                    </p>

                    <!-- Blog Tags -->
                    <div class="blog-tags mb-4">
                        <span class="text-muted">Tags:</span>
                        @php
                            $tags = explode(',', $blog->tags ?? $blog->keywords ?? '');
                        @endphp
                        @foreach ($tags as $tag)
                            <a href="#" class="badge badge-warning text-warning">{{ $tag }}</a>
                        @endforeach
                    </div>

                    <!-- Comments Section -->
                    <div class="comments-section mt-5">
                        <h4>Comments (3)</h4>

                        <div class="media mb-4">
                            <img src="path-to-avatar.jpg" alt="User Avatar" class="mr-3 rounded-circle" style="width: 50px;">
                            <div class="media-body">
                                <h6 class="mt-0">User One</h6>
                                This is a sample comment on the blog post.
                            </div>
                        </div>

                        <div class="media mb-4">
                            <img src="path-to-avatar.jpg" alt="User Avatar" class="mr-3 rounded-circle" style="width: 50px;">
                            <div class="media-body">
                                <h6 class="mt-0">User Two</h6>
                                Another comment on the post. Great blog!
                            </div>
                        </div>

                        <!-- Comment Form -->
                        <h5 class="mt-5">Leave a Comment</h5>
                        <form>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea class="form-control" id="comment" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Area -->
        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Categories</h4>
                    <ul class="list-group list-group-flush">
                        @foreach ($categories as  $category)
                             
                        <li class="list-group-item">
                            <a href="">{{ $category->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Recent Posts</h4>
                    <ul class="list-group list-group-flush recent-blogs">
                        @foreach ($recentBlogs as $item)
                        <li class="list-group-item d-flex align-items-center">
                            <!-- Blog Image -->
                            <img src="{{ asset($item->featured_image ?? 'images/default-img.jpg') }}" alt="Blog Image" class="img-fluid blog-thumbnail me-3">
                            
                            <div class="pl-3">
                                 <!-- Blog Title -->
                            <a href="{{ route('blog.show', $item->slug) }}" class="blog-title ">{{ $item->title }}</a> <br>
                            <span>{{ $item->created_at->format('d M Y')  }}</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</div>

    
@endsection
