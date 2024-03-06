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
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
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
@endsection
