<?php
	include_once("../common/db_connect.php");
	$pdo = db_connect(); 
	$input = $_POST['food_name'];
	$food_name = $input;
	$input = '%'.$input.'%';
	try{
		$stmt = $pdo->prepare("SELECT * FROM post,user,photo_data WHERE post.user_id = user.user_id AND post.post_id = photo_data.post_id AND post.food_name LIKE :food_name ORDER BY post_date DESC");
		$stmt->bindParam(':food_name', $input,PDO::PARAM_STR);
		$stmt->execute();
	}catch(PDOException $e){
		echo "エラー：" . $e->getMessage();
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Buono:検索結果</title>
	<link rel="stylesheet" href="../css/buono.css" />
</head>
<body>
	<header>
		<h1><a href="../buono_main.php"><img src="../image/logo.png" alt=""><a href="main.php"></a></h1>
	</header>
	</br>
	<div id="result"><img src="../image/loope.png" alt="">　検索ワード　<?php echo "：".$food_name; ?></div>
	</br>
	<?php
		while ($row = $stmt->fetch()):
		$title = $row['food_name'] ? $row['food_name'] : '（無題）';
	?>
	<!-- 投稿されたデータをHTMLで表示する -->
			<div id="TimeLine">
				<div id="name"><?php echo $title ?></div>
				<div id="Post_content">
					<p style="margin-left: 0.2rem;"><?php echo $row['user_name'] ?> <span style="opacity: 0.5;"><?php echo $row['user_id'] ?></span></p>
					<p><?php echo nl2br($row['content'], false) ?></p>
					<p><?php echo '<img src="data:image/jpeg;base64,' . $row['data'] . '"width="45%" height="auto">'; ?></p>
					<p><?php echo $row['post_date'] ?></p>
				</div>
			</div>
	<?php
		endwhile;
	?>
	</div>
	<div id="main">
		<a href="../buono_main.php">投稿に戻る</a>
	</div>
</body>
</html>