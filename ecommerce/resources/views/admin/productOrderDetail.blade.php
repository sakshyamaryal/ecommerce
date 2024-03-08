@extends('layouts.admin.app')

@section('content')
<div class="main">


    <div class="container mt-4">
        <hr>
        <div class="row">
            <div class="col-md-6">
                <!-- Swiper -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="d-flex flex-wrap justify-content-center">
                            @if($product->image)
                            @php
                            $images = explode(',', $product->image);
                            @endphp
                            @foreach($images as $image)
                            <div class="swiper-slide">
                                <div class="image-container">
                                    <img src="{{ asset('images/product_images/' . $image) }}" alt="{{ $product->name }}">
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="swiper-slide">
                                <div class="image-container">
                                    <img src="img/product-image.jpg" alt="{{ $product->name }}">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            <div class="col-md-6">
                <h2><strong>{{ $product->name }}</strong></h2>
                <p>⭐⭐⭐⭐</p>
                <h2>Rs{{ $product->price }}</h2>
                <p>{{ $product->description }}</p>
                <p><strong>Availability:</strong> {{ $product->available_stock > 0 ? 'In Stock' : 'Out of Stock' }}</p>
                <p><strong>Total Product Left:</strong> {{ $product->available_stock }}</p>
                <p><strong>Product Id:</strong> {{ $product->id }}</p>
                <p><strong>Price is inclusive of VAT</strong></p>
                <hr>
                <div class="container-fluid">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm mr-1">
                        <i class="fa fa-edit"> Edit Product</i> 
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-overflow">
        <h2 class="tm-block-title">Recent Order List</h2>
        <div class="tm-notification-items">
            @foreach($orders as $order)
                <div class="media tm-notification-item">
                    <div class="tm-gray-circle">
                    </div>
                    <div class="media-body">
                        <p class="mb-2"><b>{{ $order->user_name }}</b> ({{ $order->email }}) has placed a new order for Product id <b>{{ $order->product_id }}</b>. 
                            <a href="{{ route('product.details', ['id' => $order->product_id]) }}">Accept Order</a>
                        </p>
                        <span class="tm-small tm-text-color-secondary">{{ $order->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
<style>

    .swiper-button-next,
    .swiper-button-prev {
        display: none;
        color: #000;
    }

    .swiper-container:hover .swiper-button-next,
    .swiper-container:hover .swiper-button-prev {
        display: flex;
    }

    .col-md-6 {
        overflow: hidden;
        position: relative;
    }

    .swiper-container {
        width: 100%;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-container {
        width: 100%;
        height: 500px;
        overflow: hidden;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }


</style>
@endsection