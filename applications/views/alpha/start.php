<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo $this->config->base_url(); ?>" target="_self">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo base_url('images/CIGNAL SUPER logo.png') ?>" type="image/png">
	<title>Cignal Super</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Squada+One&display=swap">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="header" class="container d-flex justify-content-center align-items-start">
		<img src="images/Logo.png" class="object-fit-contain" alt="Cignal Super Logo">
	</section>
	<section id="content" class="container d-flex flex-column pb-5">
		<h2 class="squada-one-regular">PASSPORT</h2>
		<div class="button-container text-center">
			<p class="text-light mb-0">NOT YET REGISTERED?</p>
			<a href="register"><img src="images/B_Register.png" class="mb-4" alt="Register"></a>
			<p class="text-light mb-0">ALREADY REGISTERED?</p>
			<a href="login"><img src="images/B_Login.png" alt="Login"></a>
		</div>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>