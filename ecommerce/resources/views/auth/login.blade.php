@extends('layouts.user.usertemplate')


@section('content')
<style>
    /* Center aligning the form */
    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      
    }

    
    .customer-login {
      font-weight: bold;
      font-family: 'Poppins', sans-serif;
    }

    
    .registered-customer {
      font-weight: bold;
      font-family: 'Poppins', sans-serif;
    }

    .fyp{
        text-decoration: none;
    }

    
    input[type="text"],
    input[type="password"] {
      font-family: 'Poppins', sans-serif;
    }


    .full-width-btn {
      width: 100%;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 14px; 
      padding: 10px 16px; 
      height: 50px;
      border-radius: 0;
    }

    .required {
      color: red;
    }
    form .form-control:focus {
    box-shadow:none;
    
}


</style>
<div class="login-container">
    <div class="col-md-6">
        <h2 class="text-center mb-5 customer-login"> Login</h2>
        <h4 class="mb-3 registered-customer">Registered Customers</h4>
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="mb-3">
                <div class="d-block mb-2 text-muted">If you have an account, sign in with your email address.</div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label text-muted">Email<span class="required">*</span></label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="username" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-muted">Password<span class="required">*</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 fyp">
                <a href="#" class="d-block mb-2 link-secondary">Forgot Your Password?</a>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark btn-lg full-width-btn mb-2">SIGN IN</button>
            </div>
            <div class="mb-3">
            <a href="{{ route('signup') }}" class="btn btn-dark btn-lg full-width-btn mb-2">CREATE ACCOUNT</a>
            </div>
            <div class="mb-3">
                <span class="required">* Required Fields</span>
            </div>
        </form>
    </div>
</div>


@endsection
