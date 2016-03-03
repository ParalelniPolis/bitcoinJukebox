<?php

require_once 'vendor/autoload.php';

$master = \BitWasp\BitcoinLib\BIP32::master_key('b861e093a58718e145b9791af35fb111');

$addresses = [];
$addresses[] = 0;
for ($i = 1; $i < 20; $i++) {
	$address = \BitWasp\BitcoinLib\BIP32::build_address($master, $i)[0];
	$addresses[] = $address;
	echo $address . PHP_EOL;
}

for ($i = 1; $i < 20; $i++) {
	$privKey = \BitWasp\BitcoinLib\BIP32::build_key($master, $i);
	$address = \BitWasp\BitcoinLib\BIP32::key_to_address($privKey[0]);
	$same = $address == $addresses[$i];
	echo ($same ? 'true' : 'false') . PHP_EOL;
}
