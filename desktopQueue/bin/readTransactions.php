<?php

require_once '../vendor/autoload.php';
require_once '../app/TransactionReader.php';

$host = 'localhost';
$dbName = 'jukebox';
$username = 'root';
$password = '';

$reader = new TransactionReader($host, $dbName, $username, $password);
//$reader->run();
$reader->transactionReceived('12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ');

//TODO: přidat k Orderu boolean isGenre, abych do souboru zapsal jen po potvrzení objednávky a id do souboru zapsat z Order entity
