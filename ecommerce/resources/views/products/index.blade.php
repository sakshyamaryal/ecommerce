@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <p class="text-black mt-5 mb-5">Welcome back, <b>Admin</b></p>
        </div>
    </div>
    
    

    <div class="container mt-5">
        <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-products">
                    <!-- <h2 class="tm-block-title">Product List</h2> -->

                    <div class="tm-product-table-container">
                    <div class="btn-group " role="group" aria-label="Status Filter">
                        <a href="{{ route('products.index', ['status' => 'active']) }}" class="btn btn-success">Active</a>
                        <a href="{{ route('products.index', ['status' => 'inactive']) }}" class="btn btn-secondary">Inactive</a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">All</a>
                    </div>
                    <br>
                        <table class="table table-hover tm-table-small tm-product-table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Available Stock</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Images</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr class="tm-product-row">
                                    <th scope="row"><input type="checkbox" class="select-product" data-product-id="{{ $product->id }}" /></th>
                                    <td class="tm-product-name">{{ $product->name }}</td>
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
                                        <a href="{{ route('products.edit', $product->id) }}" style="color:white" class="tm-product-edit-link tm-product-delete-link">
                                            <i class="far fa-edit tm-product-edit-icon"></i>
                                        </a>
                                        <form id="deleteForm{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="tm-product-delete-link" onclick="confirmDelete('{{ $product->id }}')">
                                                        <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                                    </a>
                                        </form>
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- table container -->
                    <a href="{{url('products/create')}}" class="btn btn-primary btn-block text-uppercase mb-3">Add new product</a>
                    <button id="deleteSelectedBtn" class="btn btn-primary btn-block text-uppercase">
                        Delete selected products
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
</div>


<!-- 
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
</div> -->

<script>
    $(document).ready(function() {
        $('.view-orders').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            alert(productId);
            $('#ordersModal').modal('show');

            $.ajax({
                url: '/products/' + productId + '/orders',
                type: 'GET',
                success: function(response) {
                    // Populate modal with orders data
                    // Assuming you have a modal with id 'ordersModal' and a body with id 'ordersModalBody'
                    $('#ordersModalBody').empty();
                    if (response.length > 0) {
                        var ordersHtml = '';
                        $.each(response, function(index, order) {
                            ordersHtml += '<p>Order ID: ' + order.id + '</p>';
                            // Add more order details as needed
                        });
                        $('#ordersModalBody').html(ordersHtml);
                    } else {
                        $('#ordersModalBody').html('<p>No orders found for this product.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
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

    $(document).ready(function() {
        // Function to delete selected products
        function deleteSelectedProducts(productIds) {
            $.ajax({
                url: '{{ route("products.deleteSelected") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    productIds: productIds
                },
                success: function(response) {
                    alert(response.message);
                    // Reload the page or update the product list as needed
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred while deleting selected products.');
                }
            });
        }

        // Event listener for delete selected products button
        $('#deleteSelectedBtn').click(function() {
            var selectedProductIds = [];
            $('.select-product:checked').each(function() {
                selectedProductIds.push($(this).data('product-id'));
            });

            if (selectedProductIds.length > 0) {
                if (confirm('Are you sure you want to delete the selected products?')) {
                    deleteSelectedProducts(selectedProductIds);
                }
            } else {
                alert('Please select at least one product to delete.');
            }
        });
    });
</script>

@endsection