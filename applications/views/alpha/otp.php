<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo $this->config->base_url(); ?>" target="_self">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="favicon.ico" rel="icon" type="image/x-icon">
	<title>Cignal Super - Registration</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Squada+One&display=swap">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="header" class="container d-flex justify-content-center align-items-start">
		<a href="">
			<img src="images/Logo.png" class="object-fit-contain" alt="Cignal Super Logo">
		</a>
	</section>
	<section id="content" class="container d-flex flex-column align-items-center pb-5">
		<h2 class="squada-one-regular">PASSPORT</h2>
		<h3>OTP</h3>
		<div class="reg-form">
			<?php if (!empty($error)): ?>
				<p class="text-light text-center fs-2"><?php echo $error?></p>
			<?php endif; ?>
			<form action="otp" method="POST">
				<div class="mb-5">
					<!-- <label for="otp">OTP</label><br> -->
					<input type="text" id="otp" name="otp" pattern="\d{4}" placeholder="XXXX" maxlength="4" required>
				</div>
				<div class="text-center mb-3">
					<button type="submit"><img src="images/B_Submit.png"  alt="Submit"></button>
				</div>
			</form>

			<form action="resend-otp" method="POST">
				<div class="text-center">
					<button class="text-light fs-5" type="submit">Resend One-Time Password</button>
				</div>
			</form>
		</div>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>