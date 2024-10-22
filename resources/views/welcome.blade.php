@extends('layouts.app')

@section('content') 

@include('banners.welcome')

@include('includes.collections')

@include('banners.banner-collection')

@include('products.offered-products')
@include('products.featured-products')

@include('banners.tranding-banner')

@include('products.best-selling-products')
@include('blogs.blogs-section')

@include('products.branches')
@include('banners.instagram')

@include('banners.suscribe')

@include('banners.two-banner')
@endsection