<?php
	session_start();
	$user_id = $_SESSION['user_id'];


	try{
		$db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
		$sql = 'select room_id,person_id,user_id,room_name,status from chat where not(status=3) and ((user_id=? and status!=2) or (person_id=? and status!=1)) order by update_time desc';
		$stmt = $db->prepare($sql);
		$stmt->execute(array($user_id,$user_id));
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}

	if(isset($_POST['login'])){
		$room_id = $_POST['room_id'];
		$_SESSION['room_id'] = $room_id;
		$room_name = $_POST['room_name'];
		$_SESSION['room_name'] = $room_name;
		header('Location: chat.php');
    exit;
	}

	if(isset($_POST['exit'])){
		$room_id = $_POST['room_id'];
		$_SESSION['room_id'] = $room_id;
		$person_id = $_POST['person_id'];
		$_SESSION['person_id'] = $person_id;
		header('Location: chat_exit.php');
    exit;
	}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>メッセージ一覧</title>
</head>
<body>
	<h1><?php echo /*$room_name*/'メッセージ' ?></h1>
	<a href="create.php">トークルームを作成</a>
	<?php
		while ($row = $stmt->fetch()):
	?>

		<form action="" method="POST">
			<p>room_name　：　<?php echo $row['room_name'] ?></p>
			<p>メンバー　：　「<?php echo $row['person_id'] ?> ／ <?php echo $row['user_id'] ?>」</p>
			<input type="hidden" name="room_id" value="<?php echo $row['room_id'] ?>">
            <input type="hidden" name="person_id" value="<?php echo $row['person_id'] ?>">
			<input type="hidden" name="room_name" value="<?php echo $row['room_name'] ?>">
			<input type="submit" name="login"  value="入室	"/>
			<input type="submit" name="exit"  value="退室	"/>
			<hr />
		</form>

	<?php
		endwhile;
	?>	
	<a href="../post_list.php">メイン画面に戻る</a>
</body>
</html>