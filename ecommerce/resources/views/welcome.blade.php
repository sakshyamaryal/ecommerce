@extends('layouts.user.usertemplate')

@section('content')
<section class="carousel">
    <div id="bannerCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active" style="background-image: url('./images/iphone.jpg');">
                <div class="overlay">
                    <div class="banner-text">
                        <h2>Discover Our Latest iPhones</h2>
                        <p>Experience cutting-edge technology</p>
                    </div>
                    <button class="shop-now-btn">Shop Now</button>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item" style="background-image: url('https://ecocart.io/wp-content/uploads/resized/2023/01/iStock-1371318211-1120x455-c-default.jpg');">
                <div class="overlay">
                    <div class="banner-text">
                        <h2>Get 20% off on groceries</h2>
                        <p>All kind of groceries are now available here</p>
                    </div>
                    <button class="shop-now-btn">Shop Now</button>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item" style="background-image: url('https://cdn.fashiola.in/I193956/768x0/trendy-college-outfits-under-rs-3-5k.jpg');">
                <div class="overlay">
                    <div class="banner-text">
                        <h2>Upgrade Your Lifestyle with Our New Clothes</h2>
                        <p>Trendy clothes, exceptional style</p>
                    </div>
                    <button class="shop-now-btn">Shop Now</button>
                </div>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


<section class="products">
    <div class="section-title">
        <div class="line left"></div>
        <span class="featured-products">Featured Products</span>
        <div class="line right"></div>
    </div>

    <!-- Featured Products Slider -->
    <div class="container">
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            @php
                $chunks = array_chunk($products->toArray(), 4);
            @endphp
            @foreach ($chunks as $key => $chunk)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $product)
                            <div class="col-md-3">
                            <a href="{{ route('product.show', ['id' => $product['id']]) }}">
                                    <div class="card">
                                        @if($product['image'])
                                            @php
                                                $images = explode(',', $product['image']);
                                            @endphp
                                            <img src="{{ asset('images/product_images/' . $images[0]) }}" class="card-img-top"  alt="{{ $product['name'] }}">
                                        @else
                                            No Image
                                        @endif
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <h5 class="card-title">{{ $product['name'] }}</h5>
                                            <div class="rating">⭐⭐⭐⭐</div>
                                            <p class="price">Rs. {{ $product['price'] }}</p>
                                            <button class="add-to-cart-btn">Add to Cart</button>
                                            <i class="favorite-icon far fa-heart"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button> -->
    </div>
</div>

</section>
<section class="latest-products">
    <div class="section-title">
        <div class="line left"></div>
        <span class="featured-products">Latest Products</span>
        <div class="line right"></div>
    </div>

    <!-- Featured Products Slider -->
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            @php
                $chunks = array_chunk($products->toArray(), 4);
            @endphp
            @foreach ($chunks as $key => $chunk)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $product)
                            <div class="col-md-3">
                            <a href="{{ route('product.show', ['id' => $product['id']]) }}">
                                    <div class="card">
                                        @if($product['image'])
                                            @php
                                                $images = explode(',', $product['image']);
                                            @endphp
                                            <img src="{{ asset('images/product_images/' . $images[0]) }}" class="card-img-top"  alt="{{ $product['name'] }}">
                                        @else
                                            No Image
                                        @endif
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <h5 class="card-title">{{ $product['name'] }}</h5>
                                            <div class="rating">⭐⭐⭐⭐</div>
                                            <p class="price">Rs. {{ $product['price'] }}</p>
                                            <button class="add-to-cart-btn">Add to Cart</button>
                                            <i class="favorite-icon far fa-heart"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button> -->
    </div>
</section>

@endsection