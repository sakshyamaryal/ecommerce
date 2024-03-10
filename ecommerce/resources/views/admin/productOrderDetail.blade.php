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
        <div class="dropdown">
            <button class="dropdown-toggle" type="button" id="statusFilterDropdown">
                Filter by Status
            </button>
            <div class="dropdown-menu" aria-labelledby="statusFilterDropdown">
                <button style="color: #000;" class="dropdown-item" data-status="completed">Completed</button>
                <button style="color: #000;" class="dropdown-item" data-status="created">Not Completed</button>
            </div>
        </div>
        <div class="tm-notification-items" id="ordersofproduct">
            <!-- Orders will be displayed here -->
            <br><br>
            <div id="ordersContainer">
                @foreach($orders as $order)
                <div class="media tm-notification-item" id="order_{{$order->id}}">
                    <div class="tm-gray-circle"></div>
                    <div class="media-body">
                        <p class="mb-2"><b>{{ $order->user_name }}</b> ({{ $order->email }}) has placed a new order for Product id <b>{{ $order->product_id }}</b>.</p>
                        <span class="tm-small tm-text-color-secondary pull-right"> Order created {{ $order->created_at->diffForHumans() }}</span>

                        @if ($order->status != 'completed')
                        <button class="btn btn-secondary btn-sm accept-order pull-right" style="float: right;" data-order-id="{{ $order->id }}">Accept Order</button>
                        @else
                        <span class="badge badge-success">Completed</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

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
<script>
    function acceptOrder() {
        $('.accept-order').click(function() {
            var orderId = $(this).data('order-id');

            // Display confirmation modal
            swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to accept this order?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, accept it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed to accept the order
                    $.ajax({
                        url: "{{ route('orders.accept', ['id' => ':id']) }}".replace(':id', orderId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // Show success message
                            swal.fire("Order Accepted", "The order has been accepted successfully", "success");

                            // Remove the corresponding div
                            $('#order_' + orderId).remove();
                        },
                        error: function(xhr) {
                            // Show error message if needed
                            swal.fire("Error", "An error occurred while accepting the order", "error");
                        }
                    });
                }
            });
        });
    }
    $(document).ready(function() {
        acceptOrder();
    });
</script>
<script>
    $(document).ready(function() {
        $('.dropdown-item').click(function() {
            var status = $(this).data('status');
            var productId = "{{ $product->id }}"; // Get the product ID
            var token = "{{ csrf_token() }}"; // Get CSRF token

            $.ajax({
                url: "{{ route('orders.statusWiseOrder') }}",
                type: 'POST',
                data: {
                    status: status,
                    productId: productId,
                    _token: token // Include CSRF token
                },
                success: function(response) {
                    console.log(response);
                    $('#ordersContainer').html(response.html);
                    acceptOrder();
                },
                error: function(xhr) {
                    console.error('Error occurred while fetching orders.');
                }
            });
        });
    });
</script>

<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        color: #495057;
        padding: 0.375rem 0.75rem;
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #ffffff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    .dropdown-menu a {
        display: block;
        padding: 0.5rem 1rem;
        color: #343a40;
        text-decoration: none;
    }

    .dropdown-menu a:hover {
        background-color: #f8f9fa;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

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