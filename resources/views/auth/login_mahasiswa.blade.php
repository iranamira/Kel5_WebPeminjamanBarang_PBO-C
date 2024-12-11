<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

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
              <span class="app-brand-text demo text-heading fw-semibold text-center">Login</span>
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

            
            <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your UNDIP SSO email" autofocus>
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
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
            </form>
  
            <p class="text-center">
              <span>Belum memiliki akun?</span>
              <a href="{{route('mahasiswa.register')}}">
                <span>Sign Up</span>
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