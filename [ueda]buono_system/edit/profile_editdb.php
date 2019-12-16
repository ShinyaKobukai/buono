<?php
	include_once("../common/db_connect.php");
	session_start();
	if(isset($_POST['edit'])){
   		if ( empty($_POST['user_name']) || empty($_POST['user_id']) || empty($_POST['password'])) {
     		$_SESSION["msg"] = '入力してください';
     		header('Location: profile_edit.php');
    		exit;
 		}
		foreach($_POST as $key => $val){
			$$key=trim(htmlspecialchars($val)); 
		}
	if( isset($_FILES["user_icon"]) ){
	    $user_icon = file_get_contents($_FILES["user_icon"]["tmp_name"]);
	    $user_icon = str_replace("data:image/jpeg;base64,","",$user_icon);
	    $user_icon = base64_encode($user_icon);
  	}
	try {
			$pdo = db_connect();
			$sql = "UPDATE user SET user_name = ?, icon = ? WHERE user_id = ? AND password = ?";
			$stmt = $pdo->prepare($sql);
    		$stmt->execute(array($user_name,$user_icon,$user_id,$password));

			if (empty($user_icon)) {
				$_SESSION["msg"] = 'アイコンが設定されませんでした。';
				header('Location: profile_edit.php');
    			exit;
			}

		} catch (PDOException $e) {
			exit('データベース接続失敗。'.$e->getMessage());
		}
		header('Location: ../buono_main.php');
	}
?>