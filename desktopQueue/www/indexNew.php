<?php
require_once '../vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bitcoin Jukebox by Paralelní Polis">
	<title>Bitcoin Jukebox</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="">

	<title>Bitcoin Jukebox</title>


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="/bitcoinJukebox/desktopQueue/www/css/styleNew.css">

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>

<div id="wrapper">

	<!-- Sidebar -->
	<div id="sidebar-wrapper">
		<audio id="player" controls></audio>
		<div id="queue-list">
			<a class="mdl-navigation__link" data-url="/bitcoinJukebox/songs/c36aac46-e37e-4ab3-987f-9f31d65ffca1">20 - Elder Tale no Waltz.mp3</a><a class="mdl-navigation__link" data-url="/bitcoinJukebox/songs/2ab1c32f-57de-4200-a5aa-90df210f431f">01 - 'Log Horizon' Main Theme.mp3</a>
			<a class="mdl-navigation__link" data-url="/bitcoinJukebox/songs/c36aac46-e37e-4ab3-987f-9f31d65ffca1">20 - Elder Tale no Waltz.mp3</a><a class="mdl-navigation__link" data-url="/bitcoinJukebox/songs/2ab1c32f-57de-4200-a5aa-90df210f431f">01 - 'Log Horizon' Main Theme.mp3</a>
			<a class="mdl-navigation__link" data-url="/bitcoinJukebox/songs/c36aac46-e37e-4ab3-987f-9f31d65ffca1">20 - Elder Tale no Waltz.mp3</a><a class="mdl-navigation__link" data-url="/bitcoinJukebox/songs/2ab1c32f-57de-4200-a5aa-90df210f431f">01 - 'Log Horizon' Main Theme.mp3</a>
		</div>
		<div style="bottom: 0px; position: absolute">
			Objednej si skladbu z mobilu:
			<img src="data:image/png;
			<?php
			$renderer = new \BaconQrCode\Renderer\Image\Png();
			$renderer->setHeight(256);
			$renderer->setWidth(256);
			$writer = new \BaconQrCode\Writer($renderer);
			echo "base64," . base64_encode($writer->writeString(getHostByName(getHostName()) . '/bitcoinJukebox/adminAndMobile'));
			?>
			" class="qr-image">
		</div>
	</div>
	<!-- /#sidebar-wrapper -->

	<!-- Page Content -->
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1>Bitcoin Jukebox</h1>

				</div>
			</div>
		</div>
	</div>
	<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script src="/bitcoinJukebox/desktopQueue/www/js/qrcode.min.js"></script>
<script src="/bitcoinJukebox/desktopQueue/www/js/app.js"></script>


</body>

</html>
