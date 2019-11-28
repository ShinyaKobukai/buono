<?php

$er_msg = '';

if(isset($_POST['login'])){
  $user = $_POST['user'];
  $password = $_POST['password'];
  try{
    $dsn = new PDO('mysql:host=localhost;dbname=buono;character=utf8');
    $user = 'root';
    $password = '';
    $sql = 'select count * from user where user_name=? and password=?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($user_name,$password));
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
	<title>ログイン画面</title>
</head>
<body>
	<h1>ログイン画面</h1>
	<form action="" method="POST">
    <?php if($er_msg !== null && $er_msg !==''){echo $er_msg.'<br>';} ?>
		ユーザー名<input type="text" name="user" value=""/><br/>
		パスワード<input type="password" name="password" value=""/><br/>
		<input type="submit" name="login"  value="ログイン"/>
	</form>
	<a href="register.php">新規登録</a>
</body>
</html>
