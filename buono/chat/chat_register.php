<?php
	session_start();
  try{
	  $message_id = $_SESSION['message_id'];
	  $room_id = $_SESSION['room_id'];
	  $user_id = $_SESSION['user_id'];
    $message = $_SESSION['message'];
    include_once("../common/db_connect.php");
    $pdo = db_connect();
    $sql = '
      INSERT INTO chat_post (room_id,user_id,message,post_time) 
      values(?,?,?,now())';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($room_id,$user_id,$message));

    $sql = 'update chat set update_time = now() where room_id=?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($room_id));
    $stmt = null;
    $db = null;
  	header('Location: chat.php');
  	exit;
  } catch (PDOException $e){
  	echo $e->getMessage();
  	exit;
	}
?>
