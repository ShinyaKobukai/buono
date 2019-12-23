<?php
	session_start();

	$user_id = $_SESSION['user_id'];
	$room_id = $_SESSION['room_id'];
	$room_name = $_SESSION['room_name'];

	try{
		$db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
		$sql = 'select chat_post.message_id,chat_post.user_id,chat_post.message,user.user_name from chat_post left outer join user on user.user_id=chat_post.user_id where chat_post.room_id=?';
		$stmt = $db->prepare($sql);
		$stmt->execute(array($room_id));
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
?>
<?php
	if(isset($_POST['send']) && !empty($_POST['message'])){
	  try{
		$message_id = $_POST['message_id'];
		$message = $_POST['message'];
		$_SESSION['message_id'] = $message_id;
		$_SESSION['message'] = $message;
		$db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
	    header('Location: chat_register.php');
	    exit;
		} catch (PDOException $e){
    	echo $e->getMessage();
    	exit;
  	}
  	if ( empty($_POST['message']) ) {
  		header('Location: chat.php');
  	}
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $room_name; ?></title>
</head>
<body>
	<div>
		<div><a href="message_list.php"><img src="" alt="メッセージ一覧に戻る" /></a></div>
		<div><?php echo $room_name;	 ?></div>
	</div>
	<!-- <div>新しいメッセージを作成</div><br /> -->
	<div>
	<?php
		while ($row = $stmt->fetch()):
	?>
<!-- 		<p>message_id ：　<?php echo $row['message_id'] ?></p> -->
		<p>投稿した人　：　<?php echo $row['user_name'] ?></p>
		<p>投稿した人　：　<?php echo $row['user_id'] ?></p>
		<p>内容　　　　：　<?php echo $row['message'] ?></p>
		<hr />
	<?php
		endwhile;
	?>
	</div>


	<form action="" method="POST" id="form">
    <div><input type="text" name="message" value="" /></div>
    <div><input type="submit" name="send"  value="送信" /></div>
  </form>

	<script src="chat.js"></script>
</body>
</html>