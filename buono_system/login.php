<?php

  session_start();
  $user_id = $_POST['user_id'];
  $_SESSION['user_id'] = $user_id;

  $er_msg = '';

  $password = $_POST['password'];
  $user_id = $_POST['user_id'];
  try{
    $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
    $sql = 'select count(*) from user where user_id=? and password=?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($user_id,$password));
    $result = $stmt->fetch();
    $stmt = null;
    $db = null;

    if($result[0] != 0){
      header('Location: buono_main.php');
      exit;
    } else {
      header('Location: index.php?msg=ユーザー名またはパスワードに誤りがあります。');
      $er_msg = 'ユーザーidまたはパスワードに誤りがあります。';
      echo $er_msg;
    }
  }  catch (PDOException $e){
    echo $e->getMessage();
    exit;
  }
?>