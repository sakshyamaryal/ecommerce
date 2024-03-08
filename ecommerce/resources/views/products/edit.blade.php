@extends('layouts.admin.app')

@section('content')
<div class="container tm-mt-big tm-mb-big">
    <div class="row">
        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
            <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                <div class="row">
                    <div class="col-12">
                        <h2 class="tm-block-title d-inline-block">Edit Product</h2>
                    </div>
                </div>
                <div class="row tm-edit-product-row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <form id="editProductForm" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group mb-3">
                                <label for="name">Product Name</label>
                                <input id="name" name="name" type="text" value="{{ $product->name }}" class="form-control validate" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control validate tm-small" rows="5" required>{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="category">Category</label>
                                <select id="is_active" class="custom-select tm-select-accounts" name="is_active">
                                    <option>Active Status</option>
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group mb-3 col-xs-12 col-sm-6">
                                    <label for="expire_date">Price</label>
                                    <input id="price" name="price" type="text" value="{{ $product->price }}" class="form-control validate" data-large-mode="true">
                                </div>
                                <div class="form-group mb-3 col-xs-12 col-sm-6">
                                    <label for="stock">Available Stock</label>
                                    <input id="available_stock" name="available_stock" type="text" value="{{ $product->available_stock }}" class="form-control validate">
                                </div>
                            </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
                        <div class="d-flex flex-column align-items-center">
                            <div class="tm-product-img-edit mx-auto">
                                <div class="d-flex flex-wrap justify-content-center">
                                    @if($product->image)
                                    @php
                                    $images = explode(',', $product->image);
                                    @endphp
                                    @foreach($images as $image)
                                    <img src="{{ asset('images/product_images/' . $image) }}" alt="Product Image" class="img-fluid mx-2" style="max-width: 80px; max-height: 80px;">
                                    @endforeach
                                    @else
                                    <img src="img/product-image.jpg" alt="Product image" class="img-fluid mx-2" style="max-width: 80px; max-height: 80px;">
                                    @endif
                                </div>
                                <i class="fas fa-cloud-upload-alt tm-upload-icon mt-2" onclick="document.getElementById('fileInput').click();"></i>
                            </div>
                            <div class="custom-file mt-3 mb-3">
                                <input id="fileInput" type="file" style="display:none;">
                                <input type="file" class="form-control-file btn btn-primary btn-block mx-auto" id="images" name="images[]" multiple>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block text-uppercase">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<script>
    $(document).ready(function() {
        $('#editProductForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var productId = '{{$product->id }}'; // Get the product ID
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