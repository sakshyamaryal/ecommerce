@extends('layouts.user.usertemplate')

@section('content')

<div class="container mt-4">
    <hr>

    <div class="row">
        <div class="col-md-6">
            <!-- Swiper -->
            <div class="swiper-container">
                <div class="swiper-wrapper">

                    @if($product->image)
                    @php
                    $images = explode(',', $product->image);
                    @endphp
                    @foreach($images as $image)
                    <div class="swiper-slide">
                        <div class="image-container">
                            <img src="{{ asset('images/product_images/' . $image) }}" alt="{{ $product->product_name }}">
                        </div>
                    </div>

                    @endforeach
                    @else
                    <div class="swiper-slide">
                        <div class="image-container">
                            <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
                        </div>
                    </div>

                    @endif



                </div>

                <div class="swiper-pagination"></div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <div class="col-md-6">
            <h2><strong>{{ $product->product_name }}</strong></h2>

            <!-- Product Information -->
            <p>⭐⭐⭐⭐</p>
            <h2>Rs {{ $product->product_price }}</h2>
            <p>{{ $product->product_description }}</p>
            <p><strong>Availability:</strong> {{ $product->product_available_stock > 0 ? 'In Stock' : 'Out of Stock' }}</p>
            <p><strong>Product Number:</strong> {{ $product->product_id }}</p>
            <p><strong>Price is inclusive of VAT</strong></p>
            <hr>
            <div class="container-fluid">
                <div class="d-flex">
                    <button type="button" class="btn border btn-add rounded-0 px-1">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn border number-qty rounded-0 px-3" data-quantity="1">
                        1
                    </button>
                    <button type="button" class="btn border btn-minus rounded-0 px-1">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-dark ms-3 add-to-cart" data-product-id="{{ $product->product_id }}">
                        <i class="fas fa-cart-plus"></i> ADD TO CART
                    </button>
                    <button class="btn border rounded-0 ms-4 favorite-button" data-productfav="{{ $product->product_id }}">
                    @if($product->like_id)
                        <i class="fa-solid fav-icon fa-heart fa-lg text-danger"></i>
                    @else
                        <i class="fa-regular fav-icon fa-heart fa-lg"></i>
                    @endif
                </button>

                    <button class="btn border rounded-0 ms-4">
                        <i class="fa-solid fa-chart-simple"></i>
                    </button>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="menu-container">
        <div class="menu text-uppercase fw-bold" onclick="toggleContent('details')">Details</div>
        <div class="menu text-uppercase fw-bold" onclick="toggleContent('moreInfo')">More Information</div>
        <div class="menu text-uppercase fw-bold" onclick="toggleContent('reviews')">Reviews</div>
        <div class="menu text-uppercase fw-bold" onclick="toggleContent('likeProducts')">Like Products</div>
    </div>

    <div id="details" class="content active">
        <p class="text-secondary">{{ $product->product_description }}</p>
    </div>
    <div id="moreInfo" class="content">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
    <div id="reviews" class="content">
        <p>Reviews content goes here...</p>
    </div>
    <div id="likeProducts" class="content">
        <p>Like Products content goes here...</p>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Plus button click event
        $('.btn-add').on('click', function() {
            var quantityBtn = $(this).siblings('.number-qty');
            var quantity = parseInt(quantityBtn.text());
            quantityBtn.text(quantity + 1);
            quantityBtn.data('quantity', quantity + 1);
        });

        $('.btn-minus').on('click', function() { 
            var quantityBtn = $(this).siblings('.number-qty');
            var quantity = parseInt(quantityBtn.text()); 
            if (quantity > 1) {
                quantityBtn.text(quantity - 1);
                quantityBtn.data('quantity', quantity - 1);
            }
        });
    });
</script>


<script>
    $(document).ready(function() {

        $('.add-to-cart').on('click', function() {
            var productId = $(this).data('product-id');
            var quantity = $('.number-qty').data('quantity');
            alert(quantity);
            if ('{{ auth()->check() }}') {
                $.ajax({
                    url: '/add-to-cart',
                    type: 'POST',
                    data: {
                        productId: productId,
                        quantity: quantity
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Success', response.message, 'success');

                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            } else {
                Swal.fire('You must be logged in to continue', '', 'warning');

            }
        });

    });

    $('.favorite-button').on('click', function() {
    var productId = $(this).data('productfav');
    var isFavorite = $(this).find('i').hasClass('text-danger');

    if ('{{ auth()->check() }}') {
        $.ajax({
            url: '/addToFavorites',
            type: 'POST',
            data: {
                product_id: productId,
                is_favorite: isFavorite ? 0 : 1 // 1 if adding to favorites, 0 if removing
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
             
                if (response === 'liked') {
                    Swal.fire('Success', 'Product added to favorites!', 'success');
                    $('.favorite-button[data-productfav="' + productId + '"]').addClass('text-danger');
                    $('.favorite-button[data-productfav="' + productId + '"] i').removeClass('fa-regular').addClass('fa-solid').css('color', 'red');
                } else if (response === 'unliked') {
                    Swal.fire('Success', 'Product removed from favorites!', 'success');
                    $('.favorite-button[data-productfav="' + productId + '"]').removeClass('text-danger');
                    $('.favorite-button[data-productfav="' + productId + '"] i').removeClass('fa-solid').addClass('fa-regular').css('color', 'black');
                }

            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    } else {
        Swal.fire('You must be logged in to continue', '', 'warning');
    }
});

</script>

@endsection