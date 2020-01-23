<?php
	session_start();

	$user_id = $_SESSION['user_id'];
	$room_id = $_SESSION['room_id'];
	$room_name = $_SESSION['room_name'];

	try{
		include_once("../common/db_connect.php");
  	$pdo = db_connect();
		$sql = '
			SELECT 
			chat_post.message_id,
			chat_post.user_id,
			chat_post.message,
			chat_post.post_time,
			user.user_name
			FROM 
			chat_post left outer join user on
			user.user_id=chat_post.user_id 
			WHERE 
			chat_post.room_id=?';
		$stmt = $pdo->prepare($sql);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/common.css" type="text/css">
    <link rel="stylesheet" href="../css/chat.css" type="text/css">
    <title>Buono -投稿一覧-</title>
</head>
<body>
  <header>
    <nav id="menu">
      <ul>
        <li><a href="../home.html"><i class="fas fa-home"></i>Home</a></li>
        <li><a href="../login/register.html"><i class="fas fa-user"></i>Legister</a></li>
        <li><a href="../login/login.html"><i class="fas fa-sign-in-alt"></i>Login</a></li>
        <li><a href="../edit/profile_edit.html"><i class="fas fa-user-cog"></i>Edit</a></li>
        <li><a href="../post_list.php"><i class="far fa-comments"></i>Posts</a></li>
      </ul>
    </nav>
  </header>
<main>
	<div>
		
		<div><a href="message_list.php"><img src="" alt="メッセージ一覧に戻る" /></a></div>
		<div class="c_name"><?php print($user_id."のチャットルーム") ?></div>
	</div>
	<!-- <div>新しいメッセージを作成</div><br /> -->
	<?php
		while ($row = $stmt->fetch()):
	?>
		<div class="info">
		<!--<p>message_id ：　<?php echo $row['message_id'] ?></p> -->
			<div class="u_info"><?php print($row['user_name'].'　@'.$row['user_id'])  ?></div>
			<div class="message"><?php echo $row['message'] ?></div>
			<div class="date"><?php echo $row['post_time'] ?></div>
		</div>
	<?php
		endwhile;
	?>
	<form action="" method="POST" id="form">
	<div class="send_info">
	    <div><input type="text" name="message" size="20" placeholder="メッセージを入力してください"></div>
	    <div><input type="submit" name="send"  value="送信" /></div>
	</div>
  </form>
  	<script src="../js/jquery-2.1.4.min.js"></script>
  	<script src="../js/all.js"></script>
	<script src="../js/chat.js"></script>
	<script src="../js/all.js"></script>
</main>
<script src="reload.js"></script>
</html>