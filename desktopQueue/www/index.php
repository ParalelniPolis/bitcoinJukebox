<?php
require_once '../vendor/autoload.php';
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bitcoin Jukebox by Paralelní Polis">

	<title>Bitcoin Jukebox</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.1.1/material.blue_grey-teal.min.css" />
	<link rel="stylesheet" href="/bitcoinJukebox/desktopQueue/www/css/style.css">

	<script defer src="https://code.getmdl.io/1.1.1/material.min.js"></script>

</head>
<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
	<header class="mdl-layout__header">
		<div class="mdl-layout__header-row">
			<audio id="player" controls></audio>
		</div>
	</header>
	<div class="mdl-layout__drawer">
		<span class="mdl-layout-title">Bitcoin Jukebox</span>
		<nav class="mdl-navigation" id="queue-list">
		</nav>
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
	<main class="mdl-layout__content">
		<div class="page-content">
			<div class="mdl-grid" id="songs-wrapper">
				<!-- DATA INSERT HERE -->
			</div>
		</div>
	</main>
</div>

<script src="/bitcoinJukebox/desktopQueue/www/js/qrcode.min.js"></script>
<script src="/bitcoinJukebox/desktopQueue/www/js/app.js"></script>
</body>
</html>
