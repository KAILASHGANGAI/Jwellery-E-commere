@extends('layouts.app')

@section('content') 

@include('banners.welcome')
@include('banners.banner-collection')
@include('products.featured-products')

@include('banners.tranding-banner')

@include('products.best-selling-products')
@include('blogs.index-blogs')

@include('banners.instagram')

@include('banners.suscribe')

@include('banners.two-banner')
@endsection