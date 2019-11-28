<?php

if(isset($_POST['register'])){
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  try{
    $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
    $sql = 'insert into user(password,user_name) values(?,?)';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($password,$user_name));
    $stmt = null;
    $db = null;
    header('Location: buono_main.php');
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
  <title>新規登録画面</title>
</head>
<body>
  <h1>新規登録画面</h1>
  <form action="" method="POST">
    ユーザー名<input type="text" name="user_name" value=""/><br/>
    パスワード<input type="password" name="password" value=""/><br/>
    <input type="submit" name="register"  value="新規登録"/>
  </form>
</body>
</html>