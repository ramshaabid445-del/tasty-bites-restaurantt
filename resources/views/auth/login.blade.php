<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login | Mantis Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="{{ asset('backend/assets/fonts/tabler-icons.min.css') }}" >
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}" id="main-style-link" >
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style-preset.css') }}" >
</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center mb-4">
              <a href="#"><img src="{{ asset('backend/assets/images/logo-dark.svg') }}" alt="logo" class="img-fluid mb-3"></a>
              <h4 class="f-w-500 mb-1">Login to your account</h4>
              <p class="mb-3">Enter your credentials to continue</p>
            </div>
            
            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
              @csrf
              
              <div class="form-group mb-3">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter email address" required autofocus autocomplete="username">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-group mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="d-flex mt-1 justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" name="remember" id="remember_me">
                  <label class="form-check-label text-muted" for="remember_me">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-secondary f-w-400 mb-0">Forgot Password?</a>
                @endif
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
            
            @if (Route::has('register'))
            <div class="d-flex justify-content-between align-items-end mt-4">
              <h6 class="f-w-500 mb-0">Don't have an account?</h6>
              <a href="{{ route('register') }}" class="link-primary">Create Account</a>
            </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>