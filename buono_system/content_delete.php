<?php 
	//データの受け取り
	$post_id = intval($_GET['post_id']);

	//必須項目チェック
	$dsn = 'mysql:host=localhost;dbname=buono;character=utf8';
	$user = 'root';
	$password = '';
	
	try{
		$db = new PDO($dsn, $user, $password);
		$db -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

		$del_stmt = $db -> prepare(
			"DELETE FROM photo_data WHERE post_id=:post_id"
		);
		$del_stmt->bindParam(':post_id', $post_id, PDO::PARAM_STR);
		$del_stmt->execute();
		
		$del_stmt = $db -> prepare(
			"DELETE FROM post WHERE post_id=:post_id"
		);
		$del_stmt->bindParam(':post_id', $post_id, PDO::PARAM_STR);
		$del_stmt->execute();
		
	}catch(PDOException $e){
		echo "えらー:" . $e->getMessage();
	}
	header("Location: buono_main.php");
	exit();
?>