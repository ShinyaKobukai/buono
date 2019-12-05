<?php
	session_start();
	$user_id = $_POST['user_id'];
	$user_name = $_POST['user_name'];
	$user_icon = file_get_contents($_FILES["user_icon"]["tmp_name"]);
	$user_icon = str_replace("data:image/jpeg;base64,","",$user_icon);
	$user_icon = base64_encode($user_icon);
	require 'db_connect.php';

	if(isset($_POST['edit'])){
  		if ( empty($_POST['user_name']) || empty($_POST['user_id']) || empty($_POST['user_icon']) ) {
    		$_SESSION["msg"] = '入力してください';
    		header('Location: buono_main.php');
   			exit;
   		}
  	
	try {
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