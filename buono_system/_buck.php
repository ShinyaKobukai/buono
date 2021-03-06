<?php
	//データの受け取り
	session_start();
	$_SESSION['user_id'] = $user_id;
	$_SESSION['user_name'] = $user_name;
	foreach($_POST as $key => $val){
		$$key=trim(htmlspecialchars($val)); 
	}

	//タグの切り取りの変数
	$target_text = $content;
	$delimiter_start = "#";
	$delimiter_end = " ";
	$start_position = strpos($target_text, $delimiter_start) + strlen($delimiter_start);
	$length = strpos($target_text, $delimiter_end) - $start_position;
	$tag = substr($target_text, $start_position, $length );

	//必須項目チェック
	if ($food_name == '' || $content == ''){
		header('Location:buono_main.php'); 
		//buono_main.phpに移動
		exit();
	}

	// if(strpos("#", $content)===false){
	// 	header()
	// }
	// $content = trim($content);
	// $content = explode("#", $content);

	//写真データの変数
	$data = file_get_contents($_FILES["photo"]["tmp_name"]);
	$data = str_replace("data:image/jpeg;base64,","",$data);
	$data = base64_encode($data);

	$dsn = 'mysql:host=localhost;dbname=buono;character=utf8';
	$user = 'root';
	$password = '';

	try{

		$db = new PDO($dsn,$user,$password);
		$db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

		if ( isset($tag) ) {
			$tag_stmt = $db->prepare("
			INSERT INTO tag (tag_name) VALUES (:tag)
			");
			$tag_stmt->bindParam(':tag',$tag,PDO::PARAM_STR);
			$tag_stmt->execute();
		}

		$post_stmt = $db->prepare("
			INSERT INTO post (user_id,food_name,content,place,post_date)
			VALUES (:user_id, :food_name, :content, :place, now())
			");

		$post_stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
		$post_stmt->bindParam(':food_name',$food_name,PDO::PARAM_STR);
		$post_stmt->bindParam(':content',$content,PDO::PARAM_STR);
		$post_stmt->bindParam(':place',$place,PDO::PARAM_STR);
		$post_stmt->execute();

		$post_id = $db->lastInsertId('post_id');
		$photo_stmt = $db->prepare("
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