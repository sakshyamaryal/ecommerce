@extends('layouts.admin.app')

@section('content')
<div class="container">
            <div class="row">
                <div class="col">
                    <p class="text-white mt-5 mb-5">Welcome back, <b>Admin</b></p>
                </div>
            </div>
            <!-- row -->
            <div class="row tm-content-row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Latest Hits</h2>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Performance</h2>
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller">
                        <h2 class="tm-block-title">Storage Information</h2>
                        <div id="pieChartContainer">
                            <canvas id="pieChart" class="chartjs-render-monitor" width="200" height="200"></canvas>
                        </div>                        
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-overflow">
                        <h2 class="tm-block-title">Recent Order List</h2>
                        <div class="tm-notification-items">

                            @foreach($latestOrders as $order)
                                <div class="media tm-notification-item">
                                    <div class="tm-gray-circle">
                                    
                                    </div>
                                    <div class="media-body">
                                        <p class="mb-2"><b>{{ $order->user_name }}</b> has placed a new order for Product id <b>{{ $order->product_id }}</b>. 
                                            <a href="{{ route('product.details', ['id' => $order->product_id]) }}">View Product Details</a>

                                        </p>
                                        <span class="tm-small tm-text-color-secondary">{{ $order->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                                    
                <div class="col-12 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Product List</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Available Stock</th>
                                        <th>Active</th>
                                        <th>Created At</th>
                                        <th>Images</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td class="tm-product-name">{{ Illuminate\Support\Str::limit($product->name, 20, '...') }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->available_stock }}</td>
                                        <td>
                                            <div class="{{ $product->is_active ? 'tm-status-circle moving' : 'tm-status-circle pending' }}">
                                            </div>
                                                {{ $product->is_active ? 'Yes' : 'No' }}
                                        </td>

                                        <td>{{ $product->created_at }}</td>

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
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm mr-1">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
                                                
                                                <form id="deleteForm{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete('{{ $product->id }}')" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <a href="{{ route('product.details', ['id' => $order->product_id]) }}" class="btn btn-success btn-sm mr-1 mt-1"> <i class="fa fa-eye"></i></a>

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

<script>
    function confirmDelete(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + productId).submit();
            }
        });
    }
</script>
@endsection