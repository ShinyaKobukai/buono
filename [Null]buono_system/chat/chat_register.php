<?php
	session_start();
  try{
	  $message_id = $_SESSION['message_id'];
	  $room_id = $_SESSION['room_id'];
	  $user_id = $_SESSION['user_id'];
    $message = $_SESSION['message'];
    $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
    $sql = 'insert into chat_post(room_id,user_id,message) values(?,?,?)';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($room_id,$user_id,$message));
    $stmt = null;
    $db = null;
  	header('Location: private.php');
  	exit;
  } catch (PDOException $e){
  	echo $e->getMessage();
  	exit;
	}
?>