<?php

function DBConnect($user='root',$pass='',$host='localhost',$dbn='chat_sse'){
	$dsn	= "mysql:host=$host;dbname=$dbn;charset=utf8";
	$pdo  = new PDO($dsn,$user,$pass,array(PDO::ATTR_EMULATE_PREPARES=>false));
	return $pdo;
}

?>