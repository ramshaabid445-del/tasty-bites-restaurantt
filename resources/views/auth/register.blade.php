<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up | Tasty Bites Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="{{ asset('backend/assets/fonts/tabler-icons.min.css') }}" >
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}" id="main-style-link" >
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style-preset.css') }}" >
</head>
<body data-pc-preset="preset-5" data-pc-direction="ltr" data-pc-theme="light">
  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center mb-4">
              <a href="#"><img src="{{ asset('backend/assets/images/tasty-bites-logo.svg') }}" alt="Tasty Bites" class="img-fluid mb-3"></a>
              <h4 class="f-w-500 mb-1">Sign up</h4>
              <p class="mb-3">Create your account to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
              @csrf
              
              <div class="form-group mb-3">
                <label class="form-label" for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus autocomplete="name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-group mb-3">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter email address" required autocomplete="username">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-group mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-group mb-3">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password" required autocomplete="new-password">
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Sign Up</button>
              </div>
            </form>

            <div class="d-flex justify-content-between align-items-end mt-4">
              <h6 class="f-w-500 mb-0">Already have an Account?</h6>
              <a href="{{ route('login') }}" class="link-primary">Log in here</a>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>