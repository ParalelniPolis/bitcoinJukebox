<?php
require_once '../vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php
//file_put_contents('jsrender.min.js', file_get_contents('https://cdnjs.cloudflare.com/ajax/libs/jsrender/0.9.72/jsrender.min.js'));
//192.168.0.101
?>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bitcoin Jukebox by Paralelní Polis">
	<title>Bitcoin Jukebox</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="">

	<title>Bitcoin Jukebox</title>


	<?php if (\Nette\Utils\Strings::contains($_SERVER['REQUEST_URI'], 'www')) { ?>
		<link rel="stylesheet" href="bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/mediaelementplayer.css">
	<?php } else { ?>
		<link rel="stylesheet" href="www/bootstrap.min.css">
		<link rel="stylesheet" href="www/css/style.css">
		<link rel="stylesheet" href="www/css/mediaelementplayer.css">
	<?php } ?>

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<style>
		* {
			max-font-size: 5px;
			min-font-size: 5px;
		}
	</style>

</head>

<body>

<div id="wrapper">

	<script id="songTemplate" type="text/x-jsrender">
		<div class="panel panel-default" style="margin-bottom: 0px;">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-9 col-sm-9">
						<a data-url="{{:location}}" data-duration="{{:duration}}">
							<p>Title: {{:title}}</p>
							<p>Author: {{:author}}</p>
						</a>
					</div>
					<div class="col-md-3 col-sm-3 album-icon-wrapper">
						<img class="album-icon" src="{{:album_cover}}">
					</div>
				</div>
			</div>
		</div>
	</script>

	<!-- Sidebar -->
	<div id="sidebar-wrapper">
		<h1>Current playlist</h1>
		<div class="panel panel-default" style="margin-bottom: 0">
			<div class="panel-body" style="padding: 0; text-indent: 5px">
				<div id="audio-container">
					<div id="mep_0" class="mejs-container mejs-audio" style="width: 100%; height: 30px;">
						<div class="mejs-inner">
							<div class="mejs-mediaelement">
								<audio id="player" preload="none" src=""></audio>
							</div>
							<div class="mejs-controls">
								<div class="mejs-time-rail" style="width: 245px;">
									<span class="mejs-time-total" style="width: 240px;">
										<span class="mejs-time-loaded" style="width: 238px;"></span>
										<span class="mejs-time-current" style="width: 0px;"></span>
									</span>
								</div>
								<div class="mejs-time">
									<span class="mejs-currenttime">00:00</span>
									<span> / </span>
									<span class="mejs-duration">00:00</span>
								</div>
							</div>
							<div class="mejs-clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="queue-list">
		</div>
	</div>
	<!-- /#sidebar-wrapper -->

	<!-- Page Content -->
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<h1>Bitcoin Jukebox</h1>
			<h3>Step 1: Read QR code with your mobile phone.</h3>
			<h3>Step 2: Order songs you like.</h3>
			<h3>Step 3: Pay them with bitcoin.</h3>
			<img src="data:image/png;
			<?php
				$renderer = new \BaconQrCode\Renderer\Image\Png();
				$renderer->setHeight(250);
				$renderer->setWidth(250);
				$renderer->setMargin(0);
				$writer = new \BaconQrCode\Writer($renderer);
				$isLocalhost = $_SERVER['SERVER_NAME'] == 'localhost';
				$url = $isLocalhost ? getHostByName(getHostName()) . '/bitcoinJukebox/adminAndMobile' : 'https://jukebox.paralelnipolis.cz/';
				echo "base64," . base64_encode($writer->writeString($url));
			?>
			" class="qr-image">
		</div>
	</div>
	<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
	$connected = @fsockopen("www.google.com", 80) != false;
?>

<?php if($connected) { ?>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jsrender/0.9.72/jsrender.min.js"></script>
<?php } else { ?>
<script src="/bitcoinJukebox/desktopQueue/www/http_code.jquery.com_jquery-1.12.0.js"></script>
<script src="/bitcoinJukebox/desktopQueue/www/http_maxcdn.bootstrapcdn.com_bootstrap_3.3.6_js_bootstrap.js"></script>
<script src="/bitcoinJukebox/desktopQueue/www/jsrender.min.js"></script>
<?php } ?>

<?php if (\Nette\Utils\Strings::contains($_SERVER['REQUEST_URI'], 'www')) { ?>
<script src="js/app.js"></script>
<?php } else { ?>
<script src="www/js/app.js"></script>
<?php } ?>

</body>

</html>
