@extends('layouts.app')
@section('style')
    <style>
       
    </style>
@endsection
@section('content')
    <x-banner title="Blogs and News" image="{{ asset('images/banner/bg-1.jpg') }}" subTitle="Latest" />

    <div class="container mt-5">
        <div class="row">
            <!-- Main Blog Content Area -->
            <div class="col-lg-8">
                <div class="row">

                    <div class="col-12">
                        <div class="section_title">
                            <h2 class="px-3">{{ $category->title ?? 'All Blogs' }}</h2>
                        </div>
                    </div>

                    @forelse ($blogs as  $blog)
                        <div class="col-sm-6 p-3">
                            <x-blog :blog="$blog" />
                        </div>
                    @empty
                        <h1>No Blogs Available</h1>
                    @endforelse




                    {{ $blogs->links() }}
                </div>

            </div>

            <!-- Sidebar Area -->
            <div class="col-lg-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Categories</h4>
                        <ul class="list-group list-group-flush">
                            @forelse($categories as  $category)
                                <li class="list-group-item">
                                    <a href="{{ route('blog.category', $category->slug) }}">{{ $category->title }}</a>
                                </li>
                            @empty
                                <h1>No Categories</h1>
                            @endforelse




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
                                    <img src="{{ asset($item->featured_image ?? 'images/default-img.jpg') }}"
                                        alt="Blog Image" class="img-fluid blog-thumbnail me-3">

                                    <div class="pl-3">
                                        <!-- Blog Title -->
                                        <a href="{{ route('blog.show', $item->slug) }}"
                                            class="blog-title ">{{ $item->title }}</a> <br>
                                        <span>{{ $item->created_at->format('d M Y') }}</span>
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
