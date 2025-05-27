<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo $this->config->base_url(); ?>" target="_self">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="favicon.ico" rel="icon" type="image/x-icon">
	<title>Cignal Tool - Login</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/cba.css">
</head>
<body>
	<div class="container d-flex align-items-center justify-content-center min-vh-100">
		<div class="text-bg-light rounded-4 col-11 col-md-7 col-lg-5 px-4 py-5 p-lg-5">
			<div class="text-center">
				<img src="images/CIGNAL SUPER logo.png" class="h-auto col-10 col-md-8 mb-5" alt="Cignal Super Logo">
			</div>
			<form action="" method="POST">
				<div class="mb-3">
					<input type="text" name="uname" class="rounded-0 form-control py-2" id="username" placeholder="Username" required>
				</div>
				<div class="mb-4">
					<input type="password" name="paswd" class="rounded-0 form-control py-2" id="password" placeholder="Password" required>
				</div>

				<div class="text-center">
					<button type="submit" class="border-0 bg-transparent col-8 col-md-6">
						<img src="images/B_Login.png" class="w-100" alt="Login button">
					</button>
				</div>
			</form>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>