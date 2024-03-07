@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Product</div>

                <div class="card-body">
                    <form id="editProductForm" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                        <!-- @csrf -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" min="0" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="available_stock">Available Stock</label>
                            <input type="number" class="form-control" id="available_stock" name="available_stock" value="{{ $product->available_stock }}" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Images</label><br>
                            @if($product->image)
                                @php
                                    $images = explode(',', $product->image);
                                @endphp
                                @foreach($images as $image)
                                    <img src="{{ asset('images/product_images/' . $image) }}" alt="Product Image" style="max-width: 100px;">
                                @endforeach
                            @else
                                No Image
                            @endif
                            <!-- <input type="file" class="form-control-file" id="image" name="image" multiple> -->
                            <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                        </div>
                        <div class="form-group">
                            <label for="is_active">Is Active</label>
                            <select class="form-control" id="is_active" name="is_active" required>
                                <option value="1" {{ $product->is_active == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $product->is_active == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include necessary CSS and JavaScript libraries -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+XtGLeJuZYyWzstwASK+v0hMHvhDLX+va5bXCEhFv/Z6a8r0+s2O6ste7I" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- Include SweetAlert library -->

<script>
$(document).ready(function() {
    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var productId = '{{ $product->id }}'; // Get the product ID
        formData.append('_token', '{{ csrf_token() }}');
        // Append the product ID to the update route
        var updateUrl = '{{ route("products.update", ":id") }}';
        updateUrl = updateUrl.replace(':id', productId);
        
        $.ajax({
            type: 'POST',
            url: updateUrl,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(() => {
                    window.location.href = '{{ route("products.index") }}';
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.message
                });
            }
        });
    });
});
</script>
@endsection
