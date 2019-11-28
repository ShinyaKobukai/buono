<?php

		$dsn = 'mysql:host=localhost;dbname=buono;charset=utf8';
		$user = 'root';
		$password = '';

		$input = $_POST['food_name'];
		$input = '%'.$input.'%';

		try{
			$db = new PDO($dsn, $user, $password);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$stmt = $db->prepare("SELECT * FROM post,user,photo_data WHERE post.user_id = user.user_id AND post.post_id = photo_data.post_id AND post.food_name LIKE :food_name ORDER BY post_date DESC");
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
	<link rel="stylesheet" href="main.css" />
	<link rel="stylesheet" href="search.css" />
	<link rel="stylesheet" href="header.css" />
</head>
<body>
	<header>
		<h1><a href="main.php">Buono</a></h1>
	</header>
	<?php
		while ($row = $stmt->fetch()):
		$title = $row['food_name'] ? $row['food_name'] : '（無題）';
	?>
	<!-- 投稿されたデータをHTMLで表示する -->
			<div id="TimeLine">
				<div id="Food"><?php echo $title ?></div>
				<div id="Post_content">
					<p style="margin-left: 0.2rem;"><?php echo $row['user_name'] ?> <span style="opacity: 0.5;"><?php echo $row['user_id'] ?></span></p>
					<p><?php echo nl2br($row['content'], false) ?></p>
					<p><?php echo '<img src="data:image/jpeg;base64,' . $row['data'] . '">'; ?></p>
					<p><?php echo $row['post_date'] ?></p>
				</div>
			</div>
	<?php
		endwhile;
	?>
	</div>
	<div id="main">
		<a href="buono_main.php">×</a>
	</div>
</body>
</html>