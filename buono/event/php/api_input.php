<?php
session_start();
include("user_check.php");
include_once("../common/db_connect.php");

if( isset($_POST["write_input"]) ){
	foreach( $_POST as $key => $value ){
		$$key = trim(htmlspecialchars($value));
	}
	$pdo = db_connect();;
	$sql = "INSERT INTO t_chat(ctext,cmade) VALUES(:ctext,:cmade)";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':ctext'=>$uinput,':cmade'=>base64_decode($cmade)));
}
//--ダイレクトアクセスしてきたら強制送還
header("Location: /event/php/user_chat.php");
exit();
?>
