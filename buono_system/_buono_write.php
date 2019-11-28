<?php
	//データの受け取り
	$user_name = $_POST['user_name'];
	$content = $_POST['content'];
	$food_name = $_POST['food_name'];
	$photo_data = file_get_contents($_FILES["photo"]["tmp_name"]);
	$photo_data = str_replace("data:image/jpeg;base64,","",$photo_data);
	$photo_data = base64_encode($photo_data);

	//必須項目チェック
	if ($name == '' || $message == ''){
		header('Location:buono_main.php'); 
		//buono_main.phpに移動
		exit();
	}

	$dsn = 'mysql:host=localhost;dbname=buono;character=utf8';
	$user = 'root';
	$password = '';

	try{
		$db = new PDO($dsn,$user,$password);
		$db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
		//プリペアドステートメントを作成
		$stmt = $db->prepare("
			INSERT INTO user (user_name)
			VALUES (:user_name)
			");
		//パラメータを割り当て
		$stmt->bindParam(':name',$name,PDO::PARAM_STR);
		$stmt->execute();

		$stmt = $db->prepare("
			INSERT INTO post (content)
			VALUES (:content)
			");
		$stmt->bindParam(':contente',$food_name,PDO::PARAM_STR);
		$stmt->execute();

		$stmt = $db->prepare("
			INSERT INTO post (food_name)
			VALUES (:food_name)
			");
		$stmt->bindParam(':food_name',$content,PDO::PARAM_STR);
		$stmt->execute();

		$stmt = $db->prepare("
			INSERT INTO photo (photo)
			VALUES (:photo)
			");
		$stmt->bindParam(':photo',$photo,PDO::PARAM_STR);
		$stmt->execute();

		header('Location: buono_main.php');

	}catch(PDOEXception $e){
		die('エラー：'.$e->getMessage());
	}
?>