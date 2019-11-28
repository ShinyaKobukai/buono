<?php

if(isset($_POST['register'])){
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  $user_id = $_POST['user_id'];
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
    $sql = 'insert into user(user_id,password,user_name) values(?,?,?)';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($user_id,$password,$user_name));
    $stmt = null;
    $db = null;
    header('Location: index.php');
    exit;
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
  <!-- <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> -->
  <title>新規登録画面</title>
</head>
<body>
  <img src="logo.png" alt=""  id="title" />
  <div id="form_div">
    <br/>
    <h1>新規登録画面</h1>
    <form action="register.php" method="POST" id = "form">
      ユーザーID　:　<input type="text" name="user_id" value="" id="box"/><br/>
      <br/>
      ユーザー名　:　<input type="text" name="user_name" value="" /><br/>
      <br/>
      パスワード　:　<input type="password" name="password" value="" /><br/>
      <br/>
      <input type="submit" name="register"  value="新規登録"  /><br /><br/>
      <a href="index.php" >ログイン</a>
      <p></p><br/>
    </form>
  </div>
</body>
</html>
