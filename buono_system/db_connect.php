<?php  
	function db_connect(){
		$db = 'mysql:host=localhost;dbname=buono;character=utf8';
		$user = 'root';
		$password = '';
		$driver_options = [
		    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_EMULATE_PREPARES => false,
		];

		$pdo = new PDO(
		     $db,
		     $user,
		     $password,
		     $driver_options
		);
		return $pdo;
	}
?>