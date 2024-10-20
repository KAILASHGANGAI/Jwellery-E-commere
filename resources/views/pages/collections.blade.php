@extends('layouts.app')

@section('content')
    <x-mini-banner title="Collections" subTitle="Collections" link="{{ route('all.collections') }}"
        image="{{ asset('images/banner/bg-1.jpg') }}" />
    <div class="container-sm col-lg-12 my-5">

        @foreach ($collections as $collection)
            @if ($collection->children->count() > 0)
                <div class="section_title">
                    <h2>{{ $collection->title }}</h2>
                </div>
                <div class="row">
                    @foreach ($collection->children as $child)
                        <div class="col-sm-3 p-3">
                            <a href="{{ route('collections', $child->slug) }}" class="text-decoration-none">
                                <div class="product-item">
                                    <div class="product-image">
                                        {{-- check if file exist if not default --}}
                                        <img src="{{ asset($child->file_path ?? 'images/default-img.jpg') }}"
                                            alt="{{ $child->title }}" class="img-fluid">
                                    </div>
                                    <h5 class="product-title  text-center">{{ $child->title }}</h5>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
    </div>
@endsection
