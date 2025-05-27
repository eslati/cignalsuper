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
		<h3>REGISTRATION</h3>
		<div class="reg-form">
			<form id="regForm" action="" method="POST">
				<div class="mb-4">
					<label for="name">NAME</label><br>
					<input type="text" id="name" name="name" placeholder="NAME" required>
				</div>
				<div class="mb-4">
					<label for="name">EMAIL</label><br>
					<input type="email" id="email" name="email" placeholder="EMAIL" required>
				</div>
				<div class="mb-5">
					<label for="mobile">MOBILE NUMBER</label><br>
					<input type="text" id="mobile" name="mobile" placeholder="09XX XXX XXXX" pattern="09\d{2}\d{3}\d{4}" maxlength="11" required>
				</div>
				<div class="pp-checkbox d-flex flex-nowrap justify-content-center align-items-center mb-2">
					<input type="checkbox" id="terms" name="privacy-policy" class="text-center" required>
					<label for="privacy-policy" class="text-light mb-0">I understand and agree to the <a target="_blank" href="privacy" class="text-light">Privacy Policy</label>
				</div>
				<div class="text-center">
					<button type="submit"><img src="images/B_Submit.png" alt="Submit"></button>
				</div>
			</form>
		</div>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		const checkbox = document.getElementById("terms");
		const form = document.getElementById("regForm");
		checkbox.addEventListener("invalid", function (e) {
			e.target.setCustomValidity("Please check the Privacy Policy box to agree and proceed.");
		});
		checkbox.addEventListener("change", function (e) {
			e.target.setCustomValidity("");
		});
	</script>
</body>
</html>