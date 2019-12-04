<?php
session_start();

if(isset($_POST['register'])){
  //print('画像があるときの処理を実行中');
  if ( empty($_POST['user_name']) || empty($_POST['password']) || empty($_POST['user_name']) ) {
    $_SESSION["msg"] = '入力してください';
    header('Location: index.php');
    exit;    
  }

  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  $user_id = $_POST['user_id'];

  if( isset($_FILES["user_icon"]) ){
    $user_icon = file_get_contents($_FILES["user_icon"]["tmp_name"]);
    $user_icon = str_replace("data:image/jpeg;base64,","",$user_icon);
    $user_icon = base64_encode($user_icon);
  }
    try{
      $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
      //ユーザーID重複チェック
      $pre_sql = 'SELECT user_id FROM user WHERE user_id=?';
      $stmt = $db->prepare($pre_sql);
      $stmt->execute(array($user_id));
      $result = $stmt->fetch();

  
      while($result == true){
        echo 'そのユーザーIDは既に存在しています。';
        exit;
      }

      //データベースにアカウント情報を登録
      if (!empty($user_icon)) {
        $sql = 'insert into user(user_id,password,user_name,icon) values(?,?,?,?)';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($user_id,$password,$user_name,$user_icon));
        $stmt = null;
        $db = null;
      }
      if (empty($user_icon)) {
        $sql = 'insert into user(user_id,password,user_name) values(?,?,?)';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($user_id,$password,$user_name));
        $stmt = null;
        $db = null;
      }
      header('Location: index.php');
      exit;
    } catch (PDOException $e){
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
  <!-- <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> -->
  <title>新規登録画面</title>
</head>
<body>
  <img src="image/logo.png" alt=""  id="title" />
  <div id="form_div">
    <br/>
    <h1>新規登録画面</h1>
    <form action="register.php" method="POST" id="form" enctype="multipart/form-data">

        ユーザーID　:　<input type="text" name="user_id" value="" /><br/>
        <br/>
        ユーザー名　:　<input type="text" name="user_name" value="" /><br/>
        <br/>
        パスワード　:　<input type="password" name="password" value="" /><br/>
        <br/>
        <p>アイコンを選択してください</p><input name="user_icon" type="file"><br/>
        <br/>
        <input type="submit" name="register"  value="新規登録"  /><br /><br/>
    </form>
  </div>
</body>
</html>
