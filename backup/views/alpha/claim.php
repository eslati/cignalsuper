<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo $this->config->base_url(); ?>" target="_self">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="favicon.ico" rel="icon" type="image/x-icon">
	<title>Cignal Super - Thank you</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Squada+One&display=swap">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="home-header" class="container d-flex justify-content-center align-items-start">
		<img src="images/Logo.png" class="object-fit-contain" alt="Cignal Super Logo">
	</section>
	<section id="content" class="container home-content d-flex flex-column pb-5">
		<div id="congratsModal" class="congrats-modal">
			<div class="congrats-modal-content text-center p-3">
				<div class="text-end">
					<a href="" class="text-dark" style="font-size: 2rem;"><i class="bi bi-x"></i></a>
				</div>
				<p class="content-modal-h2">ALL YOU NEED IS ONE!</p>
				<img src="images/CIGNAL SUPER logo.png" alt="Cignal Super logo">
				<p class="content-modal-p1">Thank you</p>
				<p class="content-modal-p2">You have already won and claimed your prize.</p>
			</div>
		</div>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>