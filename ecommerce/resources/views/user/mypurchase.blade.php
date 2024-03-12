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


.filter-options select {
    padding: 8px;
    border-radius: 5px;
}

</style>
<div class="d-flex justify-content-end mb-3">
    <label for="status-filter" class="me-2">Filter by Status:</label>
    <select id="status-filter" onchange="applyFilter()">
        <option value="all" {{ request('status-filter') == 'all' ? 'selected' : '' }}>All</option>
        <option value="created" {{ request('status-filter') == 'created' ? 'selected' : '' }}>Order Pending</option>
        <option value="completed" {{ request('status-filter') == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>
</div>

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
              <!-- <img src="{{ $product->image }}" alt="{{ $product->product_name }}" width="100" height="100"> -->
              <img src="https://iplanet.one/cdn/shop/files/iPhone_15_Pro_Max_Natural_Titanium_PDP_Image_Position-1__en-IN_fb4edf23-fd9d-4921-ab06-aec128ba2698.jpg?v=1695436281" alt="Brand 1 Logo" width="100" height="100">
            </div>
            <div class="product-details d-flex flex-column ps-4">
              <a href="{{ route('product.show', ['id' => $product->id]) }}" style="color: black;">
                <p style="font-size: 14px;">{{ $product->product_name }}</p>
              </a>
              <p style="font-size: 14px;">⭐⭐⭐</p>
              <img src="https://logowik.com/content/uploads/images/apple8110.logowik.com.webp" width="20" height="20">
              <h5 class="fw-bold my-3">Rs {{ $product->product_price }}</h5>
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
          <img src="{{ asset('images/product_images/' . $images[0]) }}" alt="{{ $product->product_name }}" class="product-image">
          @else
          No Image
          @endif
        </div>
        <a href="{{ route('product.show', ['id' => $product->id]) }}" style="color: black;">
          <h3 class="product-title">{{ $product->product_name }}</h3>
        </a>

        <p class="product-review">⭐⭐⭐⭐</p>
        <div class="product-price-container">
          <img src="https://via.placeholder.com/20x20" alt="Product Image" class="product-image">
          <h5 class="mt-3">Rs.{{ $product->product_price }}</h5>
        </div>

       
        <div class="flex">
          
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
    function applyFilter() {
        var selectedValue = document.getElementById("status-filter").value;
        var url = "{{ route('userpurchase') }}";

        if (selectedValue !== 'all') {
            url += '?status-filter=' + selectedValue;
        }

        window.location.href = url;
    }
</script>

@endsection