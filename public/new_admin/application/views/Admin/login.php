    <!-- <div class="limiter">
		<div class="container-login100" style="background-image: url('<?php echo base_url('login/images/bg-01.jpg')?>');">
			<div class="wrap-login100">
				<?php 
				if($this->session->flashdata('error') !='')
				{
					echo '<div class="alert alert-danger" role="alert">';
					echo $this->session->flashdata('error');
					echo '</div>';
				}
				?>

				<?php 
				if($this->session->flashdata('success_register') !='')
				{
					echo '<div class="alert alert-info" role="alert">';
					echo $this->session->flashdata('success_register');
					echo '</div>';
				}
				?>
				<form class="login100-form validate-form" method="post" action="<?php echo base_url(); ?>Admin/login_proses">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>

					<!-- <div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div> -->
				</form>
			</div>
		</div>

		<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_template/vendor/bootstrap/css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_template/vendor/animate/animate.css');?>">	
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_template/vendor/css-hamburgers/hamburgers.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_template/vendor/select2/select2.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_template/css/util.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_template/css/main.css');?>">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?=base_url('assets/images/landing/imagis.svg');?>" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="<?php echo base_url(); ?>Admin/login_proses">
					<span class="login100-form-title">
						Admin Login
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username" placeholder="username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?=base_url('login_template/vendor/jquery/jquery-3.2.1.min.js');?>"></script>
	<script src="<?=base_url('login_template/vendor/bootstrap/js/popper.js');?>"></script>
	<script src="<?=base_url('login_template/vendor/bootstrap/js/bootstrap.min.js');?>"></script>
	<script src="<?=base_url('login_template/vendor/select2/select2.min.js');?>"></script>
	<script src="<?=base_url('login_template/vendor/tilt/tilt.jquery.min.js');?>"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="<?=base_url('login_template_js/main.js');?>"></script>

</body>
</html>