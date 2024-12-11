<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

@include('script.css')

</head>
<body>
    @include('components.header-auth')
  <div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
  
        <!-- Login -->
        <div class="card p-2">

          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5">
              <span class="app-brand-text demo text-heading fw-semibold text-center">Admin Sign Up</span>
          </div>
          <!-- /Logo -->


          <div class="card-body mt-2">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible mb-4" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              </button>
            </div>
            @endif

            @error('email')
            <div class="alert alert-danger alert-dismissible mb-4" role="alert">
              {{ $message }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              </button>
            </div>
            @enderror

            
            <form id="formAuthentication" class="mb-3" action="{{ route('admin.register.post') }}" method="POST">
              @csrf
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required placeholder="Enter your username" autofocus required>
                <label for="username">Username</label>
              </div>
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                <label for="email">Email</label>
              </div>
              <div class="mb-3">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                      <label for="password">Password</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password_confirmation" />
                      <label for="password_confirmation">Password Confirmation</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign up</button>
              </div>
            </div>
            </form>
  
            <p class="text-center">
              <span>Sudah memiliki akun?</span>
              <a href="{{route('admin.login')}}">
                <span>Sign In</span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

@include('script.script')

</html>

