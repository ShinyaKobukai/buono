<?php

session_start();
if(isset( $_GET['msg'])){
  $er_msg = $_GET['msg'];
}else{
  $er_msg = '';
}

if(isset($_POST['register'])){

  //$room_id = $_POST['room_id'];
  $room_name = $_POST['room_name'];
  $person_id = $_POST['person_id'];
  $user_id = $_SESSION['user_id'];

  try{
    $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
    //$stmt = $db->prepare($pre_sql);
    //$stmt->execute(array($user_id));
    $pre_sql = 'SELECT user_id FROM user WHERE user_id=?';
    $stmt = $db->prepare($pre_sql);
    $stmt->execute(array($person_id));
    $result = $stmt->fetch();
    if(($result == true) && ($person_id != $user_id)){

      //データベースに登録
      $sql = 'insert into chat(room_id,person_id,user_id,room_name,create_time) values(?,?,?,?,now())';
      $stmt = $db->prepare($sql);
      $stmt->execute(array('',$person_id,$user_id,$room_name));
      $room_id = $db->lastInsertId('room_id');
      $stmt = null;
      $db = null;

      $_SESSION['room_id'] = $room_id;
      $_SESSION['room_name'] = $room_name;
      $_SESSION['person_id'] = $person_id;

      header('Location: chat.php');
      exit;

    } else {
      $er_msg = '不正な入力です';
    }

  }  catch (PDOException $e){
    echo $e->getMessage();
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="register.css">
  <title>チャットルーム作成画面</title>
</head>
<body>
  <img src="logo.png" alt=""  id="title" />
  <div id="form_div">
    <br/>
    <h1>チャットルーム作成画面</h1>
    <form action="" method="POST" id = "form">
      <?php if($er_msg !== null && $er_msg !==''){echo $er_msg.'<br>';} ?>
      
      ルーム名　:　<input type="text" name="room_name" value="" /><br/>
      <br/>
      相手のID　:　<input type="text" name="person_id" value="" /><br/>
      <br/>
      <input type="submit" name="register"  value="作成"  /><br /><br/>
      <a href="message_list.php" >戻る</a>
      <p></p><br/>
    </form>
  </div>
</body>
</html>