<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo $this->config->base_url(); ?>" target="_self">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cignal Super - Home</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Squada+One&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<section id="home-header" class="container d-flex justify-content-center align-items-start">
		<img src="images/Logo.png" class="object-fit-contain" alt="Cignal Super Logo">
	</section>
	<section id="content" class="container home-content d-flex flex-column pb-5">
		<h4 class="pt-4">WELCOME</h4>
		<h3><?php echo $this->session->name; ?></h3>
		<div class="progress-container mx-auto">
			<p>YOUR PROGRESS</p>
			<div class="d-flex flex-row align-items-center gap-2">
				<div class="d-flex flex-column flex-grow-1">
					<progress value="<?php echo $count; ?>" min="0" max="8"></progress>
					<span class="ms-auto"><?php echo $count; ?> of 8 completed</span>
				</div>
				<img src="images/Locked.png" alt="Locked">
			</div>
		</div>
		<p class="digital-tracker-text mx-auto mb-0 py-3">
			THIS IS YOUR DIGITAL TRACKER. 
			<br>
			VISIT THE INSTALLATIONS TO COLLECT BADGES.
		</p>
		<div class="grid-container">
<?php foreach ($badge as $i) : ?>
			<img src="images/logos/<?php echo in_array($i['id'], $play) ? '' : 'BW_', $i['image']; ?>" alt="<?php echo $i['name']; ?>">
<?php endforeach; ?>
		</div>
		<button type="button" class="qr-code-btn pt-sm-5 pt-4" data-bs-toggle="modal" data-bs-target="#qr-modal">
			<img src="images/B_ViewQR.png" alt="View QR Code">
		</button>
		<div class="modal fade" id="qr-modal" tabindex="-1" aria-labelledby="qr-modal-label" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content p-3 rounded-4">
				<button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
					<div class="modal-body d-flex justify-content-center px-2 pt-3 pb-5">
						<img src="qr/<?php echo $this->session->qr; ?>" class="py-5" alt="QR Code">
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>