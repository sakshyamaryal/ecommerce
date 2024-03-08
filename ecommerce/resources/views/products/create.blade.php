@extends('layouts.admin.app')

@section('content')
<div class="container tm-mt-big tm-mb-big">
    <div class="row">
        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
            <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                <div class="row">
                    <div class="col-12">
                        <h2 class="tm-block-title d-inline-block">Add New Product</h2>
                    </div>
                </div>
                <div class="row tm-edit-product-row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <form id="addProductForm" enctype="multipart/form-data">

                            <div class="form-group mb-3">
                                <label for="name">Product Name</label>
                                <input id="name" name="name" type="text" class="form-control validate" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control validate tm-small" rows="5" required></textarea>
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
                                    <input id="price" name="price" type="text"  class="form-control validate" data-large-mode="true">
                                </div>
                                <div class="form-group mb-3 col-xs-12 col-sm-6">
                                    <label for="stock">Available Stock</label>
                                    <input id="available_stock" name="available_stock" type="text" class="form-control validate">
                                </div>
                            </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
                        <div class="d-flex flex-column align-items-center">
                            <div class="custom-file mt-3 mb-3">
                                <input id="fileInput" type="file" style="display:none;">

                                <input type="file" class="form-control-file btn btn-primary btn-block mx-auto" id="images" name="images[]" multiple>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block text-uppercase">Add New Product</button>
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
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this); // Create FormData object to handle file upload
        formData.append('_token', '{{ csrf_token() }}');
        $.ajax({
            type: 'POST',
            url: '{{ route("products.store") }}',
            data: formData,
            processData: false, // Prevent jQuery from automatically processing the data
            contentType: false, // Prevent jQuery from automatically setting the content type
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