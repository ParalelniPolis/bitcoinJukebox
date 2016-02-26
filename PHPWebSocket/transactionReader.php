<?php

require('vendor/autoload.php');

function human_filesize($bytes, $decimals = 2) {
	$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

//https://github.com/Devristo/phpws/blob/master/examples/echo_client.php
$loop = \React\EventLoop\Factory::create();
$logger = new \Zend\Log\Logger();
$writer = new Zend\Log\Writer\Stream("php://output");
$logger->addWriter($writer);

$options = [];
$options['ssl']['local_cert'] = "democert.pem";
$options['ssl']['allow_self_signed'] = true;
$options['ssl']['verify_peer'] = false;
//$client = new \Devristo\Phpws\Client\WebSocket("ws://echo.websocket.org/", $loop, $logger);

$client = new \Devristo\Phpws\Client\WebSocket("wss://ws.blockchain.info/inv", $loop, $logger, $options);

$addresses = [];
for ($i = 0; $i < 1000; $i++) {
	$addresses[] = md5($i);
}
$addressCounter = 0;

$client->on("connect", function() use ($logger, $client){
	$logger->notice("Connected to websocket.");
	$client->send('{"op":"unconfirmed_sub"}');
});
$client->on("message", function(\Devristo\Phpws\Messaging\WebSocketMessage $message) use ($client, $logger, $addresses, &$addressCounter) {
//	$logger->notice("Got message: ". $message->getData());
	$data = json_decode($message->getData(), true);
	$output = $data['x']['out'];
	$outAddresses = [];
	foreach ($output as $receiver) {
		if (!isset($receiver['addr'])) { //some outputs does not have address, dafuq?
			continue;
		}

		$address = $receiver['addr'];
//		echo $address . PHP_EOL;
//		$outAddresses[] = $address;
		if (in_array($address, $addresses)) {
			echo "Yay, we got money." . PHP_EOL;
		}

		$addressCounter++;
		if ($addressCounter % 100 == 0) {
			echo $addressCounter . PHP_EOL;
			$stats = date("Y-m-d H:i:s") . ', used memory: ' . human_filesize(memory_get_usage()) . ', allocated memory: ' . human_filesize(memory_get_usage(true)) . ', addresses read and compared: ' . $addressCounter . PHP_EOL;
			file_put_contents('stats.txt', $stats, FILE_APPEND);
		}
	}
//	echo implode(', ', $outAddresses) . PHP_EOL;
//	$client->close();
});

//$loop->futureTick(function() use ($client) {
//	echo 'future tick' . PHP_EOL;
//} );
//$loop->nextTick(function() use ($client) {
//	echo 'next tick' . PHP_EOL;
//} );

$client->open();
$loop->run();
