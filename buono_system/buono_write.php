<?php
	//データの受け取り
	include_once("db_connect.php");
	session_start();
	foreach($_POST as $key => $val){
		$$key=trim(htmlspecialchars($val)); 
	}
	$_SESSION['user_id'] = $user_id;
	//必須項目チェック
	if ($food_name == '' || $content == ''){
		header('Location:buono_main.php'); 
		//buono_main.phpに移動
		exit();
	}
	//写真データの変数
	$data = file_get_contents($_FILES["photo"]["tmp_name"]);
	$data = str_replace("data:image/jpeg;base64,","",$data);
	$data = base64_encode($data);
	try{
		//データベースに接続
		$pdo = db_connect();
		if ( isset($tag) ) {
			$stmt = $pdo->prepare("
				INSERT INTO tag (tag_name) VALUES (:tag)
			");
			$stmt->bindParam(':tag',$tag,PDO::PARAM_STR);
			$stmt->execute();
		}
		$stmt = $pdo->prepare("
			INSERT INTO post (user_id,food_name,content,place,post_date)
			VALUES (:user_id, :food_name, :content, :place, now())
			");
		$stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
		$stmt->bindParam(':food_name',$food_name,PDO::PARAM_STR);
		$stmt->bindParam(':content',$content,PDO::PARAM_STR);
		$stmt->bindParam(':place',$place,PDO::PARAM_STR);
		$stmt->execute();
		$post_id = $pdo->lastInsertId('post_id');
		$photo_stmt = $pdo->prepare("
			INSERT INTO photo_data (post_id,data) 
			VALUES (:post_id, :data)
			");
		//パラメータを割り当て
		$photo_stmt->bindParam(':post_id',$post_id,PDO::PARAM_INT);
		$photo_stmt->bindParam(':data',$data,PDO::PARAM_STR);
		$photo_stmt->execute();
		header('Location: buono_main.php');
	}catch(PDOEXception $e){
		die('エラー：'.$e->getMessage());
	}
?>