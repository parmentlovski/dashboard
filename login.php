<?php include('functions.php'); 
include('header.php'); ?>

<main id="form-login">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Account Login
				</span>
				<form method="post" action="login.php" >

					<div class="wrap-input100 validate-input" data-validate="Enter username">
						<input class="input100" type="text" id="username" name="username" placeholder="User name">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" id="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button type="submit" class="btn login100-form-btn" name="login_btn">	
							Login
						</button>
					</div>

					<?php echo display_error(); echo display_validation();?>
					

				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>


</main>

<?php include('footer.php'); ?>
