@extends('layouts.user.usertemplate')

@section('content')

<style>
    .custom-btn:hover {
        background-color: #AD4452 !important;
        color: white !important;
    }

    .cart-details p {
        font-size: 15px;
    }
</style>

<div class="container mt-5">
    <div class="card-header bg-transparent border-0">
        <h2 class="fw-bold px-4" style="color: #991527; font-size: 20px;">Shopping Cart</h2>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    @php
                    $subtotal = 0;
                    $productQuantities = [];
                    @endphp

                    @foreach($productsInCart as $product)
                    @php
                    // Check if the product is already in the productQuantities array
                    if(array_key_exists($product->id, $productQuantities)) {
                    // Increment the quantity
                    $productQuantities[$product->id]['quantity'] += $product->quantity;

                    } else {
                    // Add the product to the productQuantities array
                    $productQuantities[$product->id] = [
                    'quantity' =>  $product->quantity,
                    'price' => $product->price
                    ];
                    }
                    

                    // Calculate the subtotal
                     $subtotal += $product->price * $product->quantity;

                    @endphp
                    @endforeach

                    @foreach($productQuantities as $productId => $productData)
                    @php
                    // Fetch the product details based on the productId
                    $product = $productsInCart->firstWhere('id', $productId);
                    @endphp

                    <p class="m-0 px-1 py-2" style="font-size: 14px; color: #006400; background-color:#e5efe5;">
                        <i class="fa-solid fa-circle-check fa-2xl" style="color: #006400;"></i> &nbsp; You added {{ $product->name }} to your shopping cart.
                    </p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ITEM</th>
                                <th>PRICE</th>
                                <th>QTY</th>
                                <th>SUBTOTAL</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr data-product-id="{{ $productId }}">
                                <td class="border-0">
                                    <div class="py-4">
                                        @if($product->image)
                                        @php
                                        $images = explode(',', $product->image);
                                        @endphp

                                        <img src="{{ asset('images/product_images/' . $images[0]) }}" alt="{{ $product->name }}" class="img-fluid mr-2" style="max-height: 50px;" />

                                        @else
                                        No Image
                                        @endif



                                        {{ $product->name }}
                                    </div>
                                </td>
                                <td class="text-muted border-0">
                                    <div class="py-4">Rs {{ $product->price }}</div>
                                </td>
                                <td class="border-0">
                                    <div class="py-4">
                                        <div class="d-flex">
                                            <button type="button" class="btn border btn-add rounded-0 px-1">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <!-- Display the quantity from the productQuantities array -->
                                            <button type="button" class="btn border number-qty n_{{ $product->id }} rounded-0 px-3" data-quantity="{{ $productData['quantity'] }}">
                                                {{ $productData['quantity'] }}
                                            </button>
                                            <button type="button" class="btn border btn-minus rounded-0 px-1">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <!-- Display the subtotal for this product -->
                                <td class="fw-bold border-0">
                                    <div class="py-4 subtotal_price_{{ $product->id }}" data-pricing="{{ $product->price }}">Rs{{ $productData['quantity'] * $product->price }}</div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn text-uppercase text-muted fw-bold custom-btn" 
    data-bs-toggle="tooltip" data-bs-placement="top" title="View Details" 
    style="background-color: #f4f4f4;">
    View Detail
</a>

                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button type="button" class="btn btn-link text-decoration-none text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" data-dltid="{{ $product->id }}" class="btn  btn-delete btn-link text-decoration-none text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>

                            </tr>


                            <tr>
                                <td class="border-0"></td>
                                <td class="border-0"></td>
                                <td class="border-0"></td>
                                <td class="border-0">
                                    <button type="button" class="btn text-uppercase text-muted fw-bold custom-btn btn-update-cart" data-product-id="{{ $productId }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Cart" style="background-color: #f4f4f4;">
                                        Update Cart
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form action="">
                                        <div class="input-group mb-3">
                                            <label for="codeInput" class="visually-hidden"></label>
                                            <input type="text" class="form-control" id="codeInput" placeholder="Enter discount code" aria-label="Enter the code" aria-describedby="applyBtn" style="max-width: 190px;">
                                            <button type="button" class="btn text-uppercase text-muted fw-bold custom-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details" style="background-color: #f4f4f4; min-width: 120px;" id="applyBtn">
                                                Apply
                                            </button>

                                        </div>
                                    </form>


                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="container border p-3" id="summary">
                <h5 class="mb-4 fw-bold">SUMMARY</h5>
                <hr>
                <div class="mb-3 cart-details">
                    <p class="fw-bold">Estimate Shipping and Tax</p>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted">Subtotal:</p>
                            <p class="text-muted">Shipping:</p>
                            <p class="text-muted">Tax:</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <!-- Display the calculated subtotal -->
                            <p class="text-muted">Rs{{ $subtotal }}</p>
                            <p class="text-muted">Rs0.00</p>
                            <!-- Assuming tax is fixed -->
                            <p class="text-muted">Rs{{ number_format($subtotal * 0.115, 2) }}</p>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="fw-bold">Order Total:</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <!-- Total including tax -->
                            <h5 class="fw-bold">Rs{{ number_format($subtotal + ($subtotal * 0.115), 2) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column align-items-center justify-content-center">
                    <button type="button" class="btn btn-dark productcheckout mb-2 w-100 fw-bold px-4 py-2"> &nbsp;&nbsp; <i class="fas fa-arrow-right" style="color: white;"></i>
                    </button>GO TO CHECKOUT
                    <p class="fw-bold mt-4" style="color: #991527;">Check Out With Multiple Address</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        // CSRF Token
        var csrfToken = "{{ csrf_token() }}";

        // Update Quantity
        $('.btn-add, .btn-minus').click(function() {
            var productId = $(this).closest('tr').data('product-id');
            var quantity = $(this).hasClass('btn-add') ? 1 : -1; // Determine whether to increment or decrement

            // Update quantity displayed on the frontend
            var newQuantity = parseInt($('.n_' + productId).attr('data-quantity')) + quantity;

            if (newQuantity > 0) {
                var unitPrice = parseFloat($('.subtotal_price_' + productId).attr('data-pricing'));
                var subtotalPrice = unitPrice * newQuantity;
                console.log(unitPrice);
                $('.subtotal_price_' + productId).text(subtotalPrice.toFixed(2));

                $('.n_' + productId).text(newQuantity).attr('data-quantity', newQuantity);
                // calculateSubtotal();
            }


        });

        // Update Cart
        $('.btn-update-cart').click(function() {
            var productId = $(this).data('product-id');
            var quantity = parseInt($('.n_' + productId).attr('data-quantity'));

            // Send AJAX request to update cart
            $.ajax({
                url: "{{ route('cart.update') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    product_id: productId,
                    quantity: quantity
                },
                success: function(data) {
                    // $('#summary').load(location.href + ' #summary');
                    Swal.fire({
                    icon: 'success',
                    title: 'Item Deleted Successfully!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose: function() {
                        // Refresh the page after deleting
                        location.reload();
                    }
                });
                }
            });
        });

        // Delete Item
        $('.btn-delete').click(function() {
            var productId = $(this).data('dltid');

            // Send AJAX request to delete item from cart
            $.ajax({
                url: "{{ route('cart.delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    product_id: productId
                },
                success: function(data) {
                    // Remove item from cart on the frontend
                    $('tr[data-product-id="' + productId + '"]').remove();

                    // Recalculate subtotal
                    calculateSubtotal();
                    Swal.fire({
                    icon: 'success',
                    title: 'Item Deleted Successfully!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose: function() {
                        // Refresh the page after deleting
                        location.reload();
                    }
                });
                }
            });
        });

        // Function to recalculate subtotal
        // Function to recalculate subtotal, shipping, and tax
        function calculateSubtotal() {
            var subtotal = 0;
            $('.fw-bold > div').each(function() {
                var quantity = parseInt($(this).find('.number-qty').text());
                var price = parseFloat($(this).closest('tr').find('.text-muted').text().replace('Rs ', ''));
                subtotal += quantity * price;
            });

            // Update subtotal displayed on the frontend
            $('.subtotal').text('Rs' + subtotal.toFixed(2));

            // Calculate shipping (assuming it's fixed)
            var shipping = 0;
            $('.shipping').text('Rs' + shipping.toFixed(2));

            // Calculate tax
            var tax = subtotal * 0.115;
            $('.tax').text('Rs' + tax.toFixed(2));

            // Update total including tax and shipping
            var total = subtotal + shipping + tax;
            $('.total').text('Rs' + total.toFixed(2));
        }

    });


    $('.productcheckout').on('click', function() {
    var productIds = []; // Array to store product IDs
    $('.cart-item').each(function() {
        productIds.push($(this).data('product-id'));
    });

    $.ajax({
        url: '{{ route("orders.checkoutitems") }}',
        type: 'POST',
        data: {
            product_ids: productIds,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Handle success
            Swal.fire('Success', 'Order placed successfully!', 'success');
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error);
        }
    });
});


</script>



@endsection