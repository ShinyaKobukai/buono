<?php
	session_start();
	if(!isset($_SESSION['user_id'])){
		header("Location: index.php");
		exit();
	}
	

	//1ページに表示させるコメントの数
	$num = 10;
	//データベースに接続
	$dsn = 'mysql:host=localhost;dbname=buono;character=utf8';
	$user = 'root';
	$password = '';
	$driver_options = [
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_EMULATE_PREPARES => false,
	];
	

	$pdo = new PDO(
	     $dsn,
	     $user,
	     $password,
	     $driver_options
	);

//ページ数が指定されているとき
	$page = 0;
	if(isset($_GET['page']) && $_GET['page'] > 0){
		$page = intval($_GET['page']) -1;
	}

	try {
		$db = new PDO($dsn, $user, $password);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
		//プリペアドステートメントを作成

		$user_stmt = $db->prepare(
			"SELECT user_name,post.post_id,food_name,content,data,place,post_date FROM post LEFT OUTER JOIN user ON user.user_id = post.user_id LEFT OUTER JOIN photo_data ON post.post_id = photo_data.post_id ORDER BY post_date DESC ;"	
		);

		$pagenum_stmt = $db->prepare(
			"SELECT * FROM post ORDER BY post_id DESC LIMIT :page, :num"	
		);

		//パラメータの割り当て
		$page = $page * $num;
		$pagenum_stmt->bindParam(':page', $page, PDO::PARAM_INT);
		$pagenum_stmt->bindParam(':num', $num, PDO::PARAM_INT);
		//$pagenum_stmt->bindParam(':post_id',$post_id,PDO::PARAM_STR);
		//クエリの実行
		$user_stmt->execute();
		$pagenum_stmt->execute();

	} catch (PDOException $e) {
		exit('データベース接続失敗。'.$e->getMessage());
	}
	// var_dump($post_id);
	// exit();
	
	
?>

<!DOCTYPE html>
<html lang="jp">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>buono</title>
	<link rel="stylesheet" type="text/css" href="buono.css">
</head>
<body>
	<header>
		<img src="logo.png" alt="">
	<div id="loupe">
     	<a href="search.html"><img src="search.jpeg" alt="検索"></a>
    </div>
	</header>
		<div id="post">
			<div id ="menu_name">
			<form action="buono_write.php" enctype="multipart/form-data" method="post">
				<p><input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>"></p></br>
				<p><img src="image/food_menu.png" alt="menu" width="16" height="16"><input type="text" name="food_name" placeholder="メニューの名前を入力してください（必須）"></p> 
			</div>
				<div id ="review">	
					<p><img src="image/content.png" alt="review:" width="16" height="16"><textarea name="content" placeholder="感想を入力してください（必須）"></textarea></p>
				</div>
				<p><img src="image/balloon.png" alt="場所" width="16" height="16"><input type="text" name="place" placeholder="場所を入力してください（任意）"></p> 
				<div id ="write">
						<input name="photo" type="file">
						<p><input type="submit" value="書き込む"></p></br>
				</div>
				
			</div>
			</form> 
	<hr />
<?php
	while ($row = $user_stmt->fetch()):
		$food_name = $row['food_name'] ? $row['food_name'] : '(無題)';
?>
		<div id="TimeLine">			
			<div id="name">
			<?php 
				if(empty($row['content']) == null)
				{
					echo $row['user_name'];
				}
			?>
			</div>
			<div id="Post_content">
				<p><img src="image/food_menu.png" alt="menu:" width="16" height="16">　<?php echo $row['food_name'] ?></p>
				<p><img src="image/content.png" alt="review:" width="16" height="16">　<?php echo nl2br($row['content'],false) ?></p>
				<p><?php 
					if(empty($row['data']) == null){
										echo '<p><img src="data:image/jpeg;base64,' . $row['data'] . '" width="45%" height="auto"></p>'; 
									}
					?></p>
				<p><img src="image/balloon.png" alt="場所" width="16" height="16"><?php echo $row['place'] ?></p>
				<p><img src="image/clock.png" alt="date:" width="16" height="16">　<?php echo $row['post_date'] ?></p>
				<p>
					<a href="content_delete.php?post_id=<?php echo $row['post_id'] ?>">削除</a>
				</p>
				<p><a href="content_edit.php?content=<?php echo $row['content'] ?>&amp;post_id=<?php echo $row['post_id'] ?>">編集</a></p>
			</div>
		</div>
<?php
	endwhile;

	//ページ数の表示
	try{
		//プリペアドステートメント作成
		$stmt = $db->prepare("SELECT COUNT(*) FROM post");
		//クエリの実行
		$stmt->execute();
	}catch(PDOException $e){
		echo "えらー：" . $e->getMessage();
	}

	//コメントの件数を取得
	$comments = $stmt->fetchColumn();
	//ページ数を計算
	$max_page = ceil($comments / $num);
	echo '<p>';
	for ($i=1; $i <= $max_page; $i++) { 
		echo '<a href="buono_main.php?page='. $i .'">'.$i. '</a>&nbsp;';
	}
	echo '</p>';

?>
</body>
<p><a href="buono_index.php">メニュー画面に戻る</a></p>
<p><a href="index.php">ログイン</a></p>
</html>