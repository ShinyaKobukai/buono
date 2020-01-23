<?php
session_start();
include("user_check.php");
include_once("../common/db_connect.php");

if( isset($_POST["write_input"]) ){
	foreach( $_POST as $key => $value ){
		$$key = trim(htmlspecialchars($value));
	}
	$pdo = db_connect();;
	$sql = "
	INSERT INTO 
	 chat_post(room_id,user_id,message) 
	VALUES(:rid,:cmade,:ctext)";
	$sth = $pdo->prepare($sql);
	$sth->execute(
		array(
			':rid'=>intval($rid),
			':cmade'=>base64_decode($cmade),
			':ctext'=>$uinput)
	);
}
//--ダイレクトアクセスしてきたら強制送還
header("Location: /event/php/user_chat.php");
exit();
?>
