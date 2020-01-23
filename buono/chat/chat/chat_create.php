<?php
    include_once("../common/db_connect.php");
    session_start();
    $pdo = db_connect();
    //データの受け取り
    $p_id = $_GET['user_id'];
    $u_id = $_SESSION['user_id'];
    
    try{
    //データベースに格納
    $sql = 'insert into chat(room_id,person_id,user_id,room_name,create_time) values(?,?,?,?,now())';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array('',$p_id,$u_id,'無題'));
    $room_id = $pdo->lastInsertId('room_id');
    $stmt = null;
    $db = null;
    $_SESSION['room_id'] = $room_id;
    $_SESSION['room_name'] = '無題';
    //$_SESSION['person_id'] = $person_id;
    header('Location: chat.php');
    exit;
  }  catch (PDOException $e){
    echo $e->getMessage();
    exit;
  }
?>