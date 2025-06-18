<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.ico') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/animate/animate.css') }}">	
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/css-hamburgers/hamburgers.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/vendor/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login_template/css/main.css') }}">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('assets/images/landing/imagis.svg') }}" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('admin.login') }}">
					@csrf
					<span class="login100-form-title">Admin Login</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username" placeholder="Username" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Login
						</button>
					</div>
				</form>

			</div>
		</div>
	</div>

	<script src="{{ asset('login_template/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('login_template/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('login_template/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('login_template/vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('login_template/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script>
		$('.js-tilt').tilt({ scale: 1.1 })
	</script>
	<script src="{{ asset('login_template/js/main.js') }}"></script>

</body>
</html>
