<?php
session_start();
if(isset( $_GET['msg'])){
  $er_msg = $_GET['msg'];
}else{
  $er_msg = '';
}


if(isset($_POST['login'])){
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  $user_id = $_POST['user_id'];
  
  try{
    $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
    $sql = 'select count * from user where user_id=? and password=?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($user_id,$password));
    $result = $stmt->fetch();
    $stmt = null;
    $db = null;

    if($result[0] != 0){
      header('Location: buono_main.php');
      exit;
    } else {
      $er_msg = 'ユーザー名またはパスワードに誤りがあります。';
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
  <link rel="stylesheet" href="buono_index.css">
	<title>ログイン画面</title>
</head>
<body>
  <img src="image/logo.png" alt="">
  <?php
    if(isset($_SESSION["msg"])){
      echo "<h3>{$_SESSION["msg"]}</h3>".PHP_EOL;
      $_SESSION["msg"] = null;
    }
  ?>
	<h1>ログイン画面</h1>
	<form action="login.php" method="POST">
    <?php if($er_msg !== null && $er_msg !==''){echo $er_msg.'<br>';} ?>
    ユーザーID<input type="text" name="user_id" value="" /><br/>
		パスワード<input type="password" name="password" value=""/><br/>
		<input type="submit" name="login"  value="ログイン"/>
	</form>
	<a href="register.php">新規登録</a><br />
</body>
</html>
