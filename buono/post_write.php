<?php
	include_once("common/db_connect.php");
	include_once("common/value.php");
	session_start();
	foreach($_POST as $key => $val){
			$$key=trim(htmlspecialchars($val)); 
		}
	$_SESSION['user_id'] = $user_id;
	//必須項目チェック
	if ($food_name == '' || $content == ''){
		header('Location:post_list.php'); 
		exit();
	}
	//写真データの変数
	// $data = photo();
	try{
		//データベースに接続
		$pdo = db_connect();

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

		for ($i=0; $i<count($_FILES['photo']['tmp_name']); $i++) {
			$data = file_get_contents($_FILES["photo"]["tmp_name"][$i]);
			$data = str_replace("data:image/jpeg;base64,","",$data);
			$data = base64_encode($data);
			$photo_stmt = $pdo->prepare("
			INSERT INTO photo_data (post_id,data) 
			VALUES (:post_id, :data)
			");
			//パラメータを割り当て
			$photo_stmt->bindParam(':post_id',$post_id,PDO::PARAM_INT);
			$photo_stmt->bindParam(':data',$data,PDO::PARAM_STR);
			$photo_stmt->execute();
		}
		//contentに#があった際の処理
		if(strpos($content,'#') !== false){
			if(strpos($content,' ') !== false){
				$tag = explode(" ",$content);
				var_dump($content);
				for ($tag_num=0; $tag_num < count($tag); $tag_num++) {
					$tag_str = trim($tag[$tag_num]);
					if(strpos($tag_str,'#') !== false){
						$stmt = $pdo->prepare("
							INSERT INTO tag (tag_name) VALUES (:tag)
						");
						$stmt->execute(array(':tag'=>$tag_str));
						$tag_id = $pdo->lastInsertId('tag_id');

						$tag_stmt = $pdo->prepare("
							INSERT INTO post_tag (post_id,tag_id) VALUES (:post_id,:tag_id);
						");
						$tag_stmt->bindParam(':post_id',$post_id,PDO::PARAM_STR);
						$tag_stmt->bindParam(':tag_id',$tag_id,PDO::PARAM_STR);
						$tag_stmt->execute();
					}
				}	
			}//--if
		}//--if
		header('Location: post_list.php');
	}catch(PDOEXception $e){
		die('エラー：'.$e->getMessage());
	}
?>