<?php
	include_once("common/db_connect.php");
	session_start();
	if(!isset($_SESSION['user_id'])){
		header("Location: login/login.php");
		//print("user_idがないでござる");
		exit();
	}
	//1ページに表示させるコメントの数
	$num = 10;
	//ページ数が指定されているとき
	$page = 0;
	if(isset($_GET['page']) && $_GET['page'] > 0){
		$page = intval($_GET['page']) -1;
	}
	try {
		//データベースに接続
		$pdo = db_connect();
		//プリペアドステートメントを作成
		$user_stmt = $pdo->prepare(
			"SELECT * FROM user,post WHERE post.user_id = user.user_id ORDER BY post_date DESC LIMIT :page, :num"	
		);
		//パラメータの割り当て
		$page = $page * $num;
		$user_stmt->bindParam(':page', $page, PDO::PARAM_INT);
		$user_stmt->bindParam(':num', $num, PDO::PARAM_INT);
		//クエリの実行
		$user_stmt->execute();

	} catch (PDOException $e) {
		exit('データベース接続失敗。'.$e->getMessage());
	}
?>


<!DOCTYPE html>
<html lang="jp">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>buono</title>
	<link rel="stylesheet" type="text/css" href="css/buono.css">
</head>
<body>
	<header>
		<img src="image/logo.png" alt="">
	<div id="loupe">
     	<a href="search/search_form.php"><img src="image/search.jpeg" alt="検索"></a>
    </div>
	</header>
		<div id="post">
			<div id ="menu_name">
			<form action="buono_write.php" enctype="multipart/form-data" method="post">
				<p><input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>"></p></br>
				<p><img src="image/food_menu.png" alt="menu" width="16" height="16"><input type="text" name="food_name" placeholder="メニューの名前を入力してください（必須）" size="40" maxlength="20"></p> 
			</div>
				<div id ="review">	
					<p><img src="image/content.png" alt="review:" width="16" height="16"><textarea name="content" placeholder="感想を入力してください（必須）" rows="4" cols="31"></textarea></p>
				</div>
				<p><img src="image/balloon.png" alt="場所" width="16" height="16"><input type="text" name="place" placeholder="場所を入力してください（任意）" size="40" maxlength="20"></p> 
				<div id ="write">
						<p><input type="file" name="photo[]" id="photo" multiple="multiple" accept="image/jpeg,*.jpg" /></p>
						<input type="hidden" id="base64" name="date" value="" />
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
					if(empty($row['content']) == null){
						echo '<div id="icon"><img src="data:image/jpg;base64,' . $row['icon'] . '" width="10%" height="auto"></div>'; 
						echo $row['user_name'];
					}
				?>
			</div>
			<div id="Post_content">
				<p><img src="image/food_menu.png" alt="menu:" width="16" height="16">　<?php echo $row['food_name'] ?></p>
				<p><img src="image/content.png" alt="review:" width="16" height="16">　<?php echo nl2br($row['content'],false) ?></p>
					<?php 
							$post = $row['post_id'];
							try{
								$sql = $pdo->prepare("SELECT p.post_id,p.data FROM photo_data AS p,post WHERE :post = p.post_id AND p.post_id = post.post_id ORDER BY post_id DESC");
								$sql->bindParam(':post',$post,PDO::PARAM_INT);
								$sql->execute();
							}catch(PDOException $e){
								echo "エラー：" . $e->getMessage();
							}
					while ($line = $sql->fetch()) {
						$photo = $line['post_id'];
						if ($post == $photo) {
							if(empty($line['data'])==null){
														echo '<p><img src="data:image/jpeg;base64,' . $line['data'] . '" height="auto" width="45%"></p>';
							}
						}
					}
					?>
				<p><img src="image/balloon.png" alt="場所" width="16" height="16"><?php echo $row['place'] ?></p>
				<p><img src="image/clock.png" alt="date:" width="16" height="16">　<?php echo $row['post_date'] ?></p>
				<p>
				</p>
					<a href="edit/content_delete.php?post_id=<?php echo $row['post_id'] ?>">削除</a>
				<p><a href="edit/content_edit.php?content=<?php echo $row['content'] ?>&amp;post_id=<?php echo $row['post_id'] ?>">編集</a></p>
			</div>
		</div>
<?php
	endwhile;

	//ページ数の表示
	try{
		//プリペアドステートメント作成
		$stmt = $pdo->prepare("SELECT COUNT(*) FROM post");
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
<p><a href="buono_index.html">メニュー画面に戻る</a></p>
<p><a href="edit/profile_edit.php">プロフィールを変更する</a></p>
<p><a href="login/login.php">ログイン</a></p>
</html>