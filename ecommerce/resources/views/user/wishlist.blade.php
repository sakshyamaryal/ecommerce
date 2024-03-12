@extends('layouts.user.usertemplate')


@section('content')
<style>
  .product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    /* Creates 4 equal columns */
    gap: 20px;
    /* Adjust the gap between items as needed */
  }

  .product-item {
    width: 100%;
    /* Takes the full width of the grid cell */
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: box-shadow 0.3s ease;
    padding: 10px 0px;
    position: relative;

  }

  .product-item:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    /* Box shadow on hover */
  }

  .product-title {
    font-size: 20px;
    text-align: center;
  }

  .product-title:hover {
    color: #8F0707;
  }

  .product-price-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .product-image {
    max-width: 100%;
    height: auto;
  }

  .add-to-cart-button {
    font-size: 14px;
    padding: 10px 5px;
    background-color: #f4f4f4;
    border: none;
    text-transform: uppercase;
    font-weight: 600;
    color: #6c757d;
    transition: 0.3 ease;
  }

  .add-to-cart-button:hover {
    background-color: #000;
    color: #fff;
  }

  .wishlist-buttons {
    background-color: #0088cc;
    color: #fff;
    text-transform: uppercase;
    font-weight: 700;
    padding: 10px 20px;
  }

  .wishlist-buttons:hover {
    background-color: #8F0707;
    color: #fff;
  }
</style>

<div class="container">
  <div class="row">
    <div class="col-3">
      <!-- Content for the first column (takes up 3 units) -->
      <div class="feature-section border px-4 py-4">
        <h2 style="font-size: 15px">Featured</h2>

        <!-- Featured Product 1 -->
        @if(count($products) > 0)
        <div class="products-container">
          @php
          $totalProducts = count($products);
          $startIndex = $totalProducts - 3;
          if ($startIndex < 0) $startIndex=0; // Ensure startIndex doesn't go below 0 @endphp @for($i=$startIndex; $i < $totalProducts; $i++) @php $product=$products[$i]; @endphp <div class="featured-product d-flex">
            <div class="featured-image-container d-flex justify-content-center align-items-center">
              <!-- <img src="{{ $product->image }}" alt="{{ $product->name }}" width="100" height="100"> -->
              <img src="https://iplanet.one/cdn/shop/files/iPhone_15_Pro_Max_Natural_Titanium_PDP_Image_Position-1__en-IN_fb4edf23-fd9d-4921-ab06-aec128ba2698.jpg?v=1695436281" alt="Brand 1 Logo" width="100" height="100">
            </div>
            <div class="product-details d-flex flex-column ps-4">
              <a href="{{ route('product.show', ['id' => $product->id]) }}" style="color: black;">
                <p style="font-size: 14px;">{{ $product->name }}</p>
              </a>
              <p style="font-size: 14px;">⭐⭐⭐</p>
              <img src="https://logowik.com/content/uploads/images/apple8110.logowik.com.webp" width="20" height="20">
              <h5 class="fw-bold my-3">Rs {{ $product->price }}</h5>
            </div>
        </div>
        <hr>
        @endfor
      </div>
      @else
      <p>No featured products available</p>
      @endif

    </div>
  </div>


  <div class="col-9">
    <div class="product-grid">

      @foreach($products as $product)
      <div class="product-item">
        <div class="product-image-container">
          <!-- Use the product image from the fetched data -->
          <!-- <img src="{{ $product->image }}" class="product-image"> -->
          @if($product->image)
          @php
          $images = explode(',', $product->image);
          @endphp
          <img src="{{ asset('images/product_images/' . $images[0]) }}" alt="{{ $product->name }}" class="product-image">
          @else
          No Image
          @endif
        </div>
        <a href="{{ route('product.show', ['id' => $product->id]) }}" style="color: black;">
          <h3 class="product-title">{{ $product->name }}</h3>
        </a>

        <p class="product-review">⭐⭐⭐⭐</p>
        <div class="product-price-container">
          <img src="https://via.placeholder.com/20x20" alt="Product Image" class="product-image">
          <h5 class="mt-3">Rs.{{ $product->price }}</h5>
        </div>

        <button class="add-to-cart-button" style="font-size: 14px;" data-btnproductid="{{ $product->id }}"> Buy Now</button>
        <div class="flex">
          <!-- <a href="" class="text-danger">Edit</a> -->
          <a href="" class="text-danger remove" data-btnproductid="{{ $product->id }}">Remove</a>
        </div>
      </div>
      @endforeach

    </div>

    <!-- <div class="flex gap-2">
                <button class="btn wishlist-buttons">Update Wishslist</button>
                <button class="btn wishlist-buttons">Share Wishslist</button>
            </div> -->

  </div>

</div>
</div>
<script>
  $('.add-to-cart-button').on('click', function() {
    var productId = $(this).data('btnproductid');

    $.ajax({
      url: '/makeOrder',
      type: 'POST',
      data: {
        product_id: productId,
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

  $('.remove').on('click', function(e) {
    e.preventDefault();
    var productId = $(this).data('btnproductid');

    // Send AJAX request to remove the product from the wishlist
    $.ajax({
      url: '/addToFavorites',
      type: 'POST',
      data: {
        product_id: productId,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        // Handle success
        if (response === 'unliked') {
          // Remove the product item from the UI
          $(e.target).closest('.product-item').remove();
          Swal.fire('Success', 'Product removed from wishlist!', 'success');
        }
      },
      error: function(xhr, status, error) {
        // Handle error
        console.error(error);
      }
    });
  });
</script>

@endsection