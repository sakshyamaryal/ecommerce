<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thira Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{asset('css/styles.css')}}">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>

<body>

  <div class="main">
    <div class="d-flex justify-content-between align-items-center container">
      <!-- Logo -->
      <h1 class="py-2">DIAOGNAL</h1>

      <div class="d-flex justify-content-center align-items-center mt-3">
        <div class="input-group">
          <input type="text" class="form-control custom-search-input" placeholder="Search..." style="border: 1px solid #ccc">
          <span class="input-group-text">
            <i class="fas fa-search"></i>
          </span>
        </div>
      </div>

      <div class="d-flex align-items-center">
        <div class="d-flex align-items-center">
          <i class="fas fa-phone-alt fa-lg mx-2"></i>

          <div class="d-flex flex-column">
            <p class="mx-2 mb-0">CALL US NOW</p>
            <p class="mx-2 mb-0">9861060000 / 9810050001</p>
          </div>
        </div>

        <i class="fa-regular fa-user-circle fa-lg mx-2"></i>
        <i class="fa-regular fa-heart fa-lg mx-2"></i>
        <i class="fas fa-shopping-bag fa-lg mx-2"></i>
      </div>
    </div>
    <hr>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('welcome') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Specials</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Account</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    @yield('content')


    <!-- Footer Section -->
    <footer class="footer bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h5>Contact Us</h5>
            <p>Address: 123 XYZ, City, Country</p>
            <p>Email: info@diaognal.com</p>
            <p>Phone: 123-456-7890</p>
          </div>
          <div class="col-md-3">
            <h5>Quick Links</h5>
            <ul class="list-unstyled">
            <li><a href="{{ route('welcome') }}">Home</a></li>
              <li><a href="#">Products</a></li>
              <li><a href="#">Categories</a></li>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Contact Us</a></li>
            </ul>
          </div>
          <div class="col-md-3">
            <h5>Follow Us</h5>
            <ul class="list-unstyled">
              <li><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
              <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
              <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
              <li><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
              <li><a href="#"><i class="fab fa-youtube"></i> YouTube</a></li>
            </ul>
          </div>
          <div class="col-md-3">
            <h5>Subscribe Newsletter</h5>
            <p>Get all the latest information on events, sales, and offers. Sign up for the newsletter:</p>
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Email Address" aria-label="Email Address" aria-describedby="basic-addon2">
              <button class="btn btn-outline-light" type="button">Subscribe</button>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 text-center">
            <p>&copy; 2024 Diagonal. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/t1c1QQBo1vUV2Hjji/ZiIqezlY+X6+qI5WRVo=" crossorigin="anonymous"></script> -->
  <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $('.favorite-icon').click(function() {
        $(this).toggleClass('active');
      });
    });
  </script>

  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

  <script>
   var swiper = new Swiper('.swiper-container', {
      slidesPerView: 1,
      spaceBetween: 10,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });

    function toggleContent(tab) {
      // Hide all content
      document.querySelectorAll('.content').forEach(content => {
        content.classList.remove('active');
      });

      // Show the selected content
      document.getElementById(tab).classList.add('active');
    }
    
  </script>

</body>

</html>