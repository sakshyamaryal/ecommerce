@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Product List</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Available Stock</th>
                                    <th>Active</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Images</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->available_stock }}</td>
                                    <td>{{ $product->is_active ? 'Yes' : 'No' }}</td>
                                    <td>{{ $product->created_at }}</td>
                                    <td>{{ $product->updated_at }}</td>
                                    <td>
                                        @if($product->image)
                                           @php
                                                $images = explode(',', $product->image);
                                           @endphp
                                           <img src="{{ asset('images/product_images/' . $images[0]) }}" alt="Product Image" style="max-width: 100px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <button class="btn btn-info view-orders" data-product-id="{{ $product->id }}">
                                            <i class="fa fa-eye"></i> View Orders
                                        </button>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="ordersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ordersModalLabel">Orders for Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ordersModalBody">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.view-orders').on('click', function (e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            alert(productId);
            $('#ordersModal').modal('show');

            $.ajax({
                url: '/products/' + productId + '/orders',
                type: 'GET',
                success: function (response) {
                    // Populate modal with orders data
                    // Assuming you have a modal with id 'ordersModal' and a body with id 'ordersModalBody'
                    $('#ordersModalBody').empty();
                    if (response.length > 0) {
                        var ordersHtml = '';
                        $.each(response, function (index, order) {
                            ordersHtml += '<p>Order ID: ' + order.id + '</p>';
                            // Add more order details as needed
                        });
                        $('#ordersModalBody').html(ordersHtml);
                    } else {
                        $('#ordersModalBody').html('<p>No orders found for this product.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection



