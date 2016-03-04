<?php

/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 4. 3. 2016
 * Time: 23:34
 */
class TransactionReadingThread extends Thread {

	/** @var callable */
	protected $onTransactionObtained;

	public function __construct()
	{
	}

	public function run() {
		$host = 'localhost';
		$dbName = 'jukebox';
		$username = 'root';
		$password = '';
		$reader = new TransactionReader($host, $dbName, $username, $password);
		$reader->onTransactionObtained = $this->onTransactionObtained;
//		$reader->run();
		$reader->transactionReceived('153kXRdBULL7wCDwBFY418n6EN52zd4Yts');
	}

	public function setTransactionObtainedCallback(callable $callback)
	{
		$this->onTransactionObtained = $callback;
	}

}
