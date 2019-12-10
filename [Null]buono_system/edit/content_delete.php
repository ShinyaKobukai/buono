<?php 
	include_once("../common/db_connect.php");
	$pdo = db_connect();
	//データの受け取り
	$post_id = intval($_GET['post_id']);
	try{
		$del_stmt = $pdo -> prepare(
			"DELETE FROM photo_data WHERE post_id=:post_id"
		);
		$del_stmt->bindParam(':post_id', $post_id, PDO::PARAM_STR);
		$del_stmt->execute();
		$del_stmt = $pdo -> prepare(
			"DELETE FROM post WHERE post_id=:post_id"
		);
		$del_stmt->bindParam(':post_id', $post_id, PDO::PARAM_STR);
		$del_stmt->execute();
	}catch(PDOException $e){
		echo "えらー:" . $e->getMessage();
	}
	header("Location: ../buono_main.php");
	exit();
?>