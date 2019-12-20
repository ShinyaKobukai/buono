<?php
	session_start();
  try{
    $room_id = $_SESSION['room_id'];
    $user_id = $_SESSION['user_id'];
    $person_id = $_SESSION['person_id'];


    $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
    $sql = 'select status from chat where room_id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($room_id));
    $row = $stmt->fetch();
    $status_flag = $row['status'];

    //print_r($status_flag);

    if(($status_flag == 1) || ($status_flag == 2)){
      $status_flag = 3;
    } elseif($user_id == $person_id) {
      $status_flag = 1;
    } else {
      $status_flag = 2;
    }


    $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
    $sql = 'update chat set status=? where room_id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($status_flag,$room_id));
    $stmt = null;
    $db = null;
  	header('Location: message_list.php');
  	exit;
  } catch (PDOException $e){
  	echo $e->getMessage();
  	exit;
	}
?>