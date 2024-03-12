@extends('layouts.user.usertemplate')

@section('content')
<style>
   
    .register-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .new-customer {
      font-weight: bold;
      font-family: 'Poppins', sans-serif;
    }

    .create-account {
      font-weight: bold;
      font-family: 'Poppins', sans-serif;
    }

</style>

<div class="register-container">
    <div class="col-md-6">
        <h2 class="text-center mb-5 new-customer">New Customer</h2>
        <h4 class="mb-3 create-account">Create an Account</h4>
        <form method="POST" action="{{ route('signup.submit') }}">
            @csrf

            <div class="mb-3">
                <div class="d-block mb-2 text-muted">If you don't have an account, sign up with your details.</div>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label text-muted">Name<span class="required text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-muted">Email<span class="required text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-muted">Password<span class="required text-danger">*</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label text-muted">Confirm Password<span class="required text-danger">*</span></label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-dark btn-lg full-width-btn mb-2">CREATE ACCOUNT</button>
            </div>

            <div class="mb-3">
                <span class="required text-danger">* Required Fields</span>
            </div>
        </form>
    </div>
</div>

@endsection
