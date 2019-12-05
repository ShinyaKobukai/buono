<?php
	session_start();

	$user_id = $_POST['user_id'];
	$user_name = $_POST['user_name'];
	$user_icon = $_POST['user_icon'];

	require 'db_connect.php';

	if(isset($_POST['edit'])){
  		
  		if ( empty($_POST['user_name']) || empty($_POST['user_id']) || empty($_POST['user_icon']) ) {
    		$_SESSION["msg"] = '入力してください';
    		//header('Location: buono_main.php');
   			var_dump($user_id);
   			var_dump($user_name);
   			var_dump($user_icon);
   			exit;
   		}

   		$user_id = $_POST['user_id'];
   		$user_name = $_POST['user_name'];
		$user_icon = $_POST['user_icon'];
		var_dump($user_id);
		var_dump($user_name);
		var_dump($user_icon);

   		if( isset($_FILES["user_icon"]) ){
		    $user_icon = file_get_contents($_FILES["user_icon"]["tmp_name"]);
		    $user_icon = str_replace("data:image/jpeg;base64,","",$user_icon);
		    $user_icon = base64_encode($user_icon);
		}
  	
	try {
			// $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
			$edit_stmt = $db->prepare(
				"UPDATE user SET user_name=:user_id,user_name=:user_name,icon=:icon;"
			);
			$edit_stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
			$edit_stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
			$edit_stmt->bindParam(':icon', $user_icon, PDO::PARAM_STR);
			$edit_stmt->execute();


		} catch (PDOException $e) {
			exit('データベース接続失敗。'.$e->getMessage());
		}
	}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>profile edit</title>
</head>
<body>
  <img src="image/logo.png" alt="">
  <div id="form_div">
    <br/>
    <h1>プロフィール設定</h1>
    <form action="profile_edit.php" method="POST" id="form" enctype="multipart/form-data">
		ユーザーID　:　<input type="text" name="user_id" value="" /><br/>
        <br/>
        ユーザー名　:　<input type="text" name="user_name" value="" /><br/>
        <br/>
        <p>アイコンを選択してください</p><input name="user_icon" type="file"><br/>
        <br/>
        <input type="submit" name="edit"  value="設定する"  /><br /><br/>
    </form>
  </div>
  <a href="buono_index.php">トップページに戻る</a></br>
  <a href="buono_write.php">投稿する</a>
</body>
</html>