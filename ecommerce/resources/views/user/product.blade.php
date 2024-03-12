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

  .chart-button,
  .heart-button,
  .cart-icon {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
  }

  .product-item:hover .chart-button,
  .product-item:hover .heart-button {
    opacity: 1;
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
          @if($product->image)
          @php
          $images = explode(',', $product->image);
          @endphp
          <img src="{{ asset('images/product_images/' . $images[0]) }}" alt="{{ $product->name }}" class="product-image">
          @else
          No Image
          @endif
          <!-- <img src="https://www.olizstore.com/media/catalog/product/cache/08c45697224ec88f7e476fd58ef94e16/m/a/macbook-air-space-gray-config-201810_3.jpeg" alt="{{ $product->name }}" class="product-image"> -->
        </div>
        <a href="{{ route('product.show', ['id' => $product->id]) }}" style="color: black;">
          <h3 class="product-title">{{ $product->name }}</h3>
        </a>

        <p class="product-review">⭐⭐⭐⭐</p>
        <div class="product-price-container">
          <img src="https://via.placeholder.com/20x20" alt="Product Image" class="product-image">
          <h5 class="mt-3">Rs.{{ $product->price }}</h5>
        </div>
        <div class="d-flex gap-2 buttons-container">
          <button type="button" class="btn btn-outline-dark heart-button" onclick="addToFavorites(`{{ $product->id }}`)">
            @if($product->like_id)
            <i class="fas fa-heart icon text-danger"></i>
            @else
            <i class="far fa-heart icon"></i>
            @endif
          </button>
          <button class="add-to-cart-button" style="font-size: 14px;" data-btnproductid="{{ $product->id }}">
            Buy Now
          </button>
          <button type="button" class="btn btn-outline-dark chart-button">
            <i class="fas fa-chart-bar icon"></i>
          </button>
        </div>

      </div>
      @endforeach
    </div>
  </div>

</div>
</div>
<script>
  function addToFavorites(productId) {
    if ('{{ auth()->check() }}') {
      $.ajax({
        url: '/addToFavorites',
        type: 'POST',
        data: {
          product_id: productId
        },
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
          // Handle success
          if (response === 'liked') {
            Swal.fire('Success', 'Product added to favorites!', 'success');
            $('.heart-button i').removeClass('far').addClass('fas').css('color', 'red');
          } else if (response === 'unliked') {
            Swal.fire('Success', 'Product removed from favorites!', 'success');
            $('.heart-button i').removeClass('fas').addClass('far').css('color', 'black');
          }
        },
        error: function(xhr, status, error) {
          // Handle error
          console.error(error);
        }
      });
    } else {
      Swal.fire('You must be logged in to continue', '', 'warning');
    }
  }

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
</script>

@endsection