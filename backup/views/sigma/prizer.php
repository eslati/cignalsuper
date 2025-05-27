<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo $this->config->base_url(); ?>" target="_self">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="favicon.ico" rel="icon" type="image/x-icon">
	<title><?php echo $this->session->name; ?> - Claim</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/cba.css">
</head>
<body>
	<div class="container my-5">
		<div class="text-end">
			<a href="cadminl23/logout" id="logoutBtn" class="btn btn-danger shadow rounded-pill align-middle px-md-4 px-3 py-2">LOGOUT</a>
		</div>
		<div class="shadow text-bg-light rounded w-100 p-4 mt-3">
			<h2 class="fs-4 fw-bold"><?php echo $this->session->name; ?> - Claim Prize</h2>
			<hr>
			<div id="reader" width="400px"></div>
			<pre id="pmon">
			</pre>
		</div>
	</div>
	<script type="text/javascript" src="https://unpkg.com/html5-qrcode"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		$( document ).ready( function() {
			pMon();
			const html5QrCode = new Html5Qrcode( 'reader' );
			const qrCodeSuccessCallback = ( decodedText, decodedResult) => {
				html5QrCode.pause();
				$.post( 'Cadminl23/claim', { prc: decodedText } )
					.done( function( data ) {
						alert( data );
						pMon();
						html5QrCode.resume();
					} );
			};
			const config = { fps: 20, qrbox: { width: 200, height: 200 } };
			html5QrCode.start( { facingMode: 'environment' }, config, qrCodeSuccessCallback );
		} );
		
		function pMon() {
			$.get( 'Cadminl23/pmon' ).done( function( data ) {
				$( '#pmon' ).html ( data );
			} );
		}
	</script>
</body>
</html>
