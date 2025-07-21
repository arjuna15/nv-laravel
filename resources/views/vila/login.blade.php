<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- SB Admin 2 CSS -->
  <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">

  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-7 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4"><b>Admin</b> Login</h1>
                <p class="mb-4">Masuk untuk melanjutkan</p>
              </div>

              @if ($errors->any())
                  <div class="alert alert-danger">
                      {{ $errors->first() }}
                  </div>
              @endif

              <form class="user" method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" name="username" value="{{ old('username') }}" required placeholder="Masukkan Username...">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-user" name="password" required placeholder="Masukkan Password...">
                </div>
                <div class="form-group">
                  <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                    <label class="custom-control-label" for="remember">Ingat saya</label>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Masuk
                </button>
              </form>

            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- SB Admin 2 Scripts -->
  <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
