<?php
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
	} try {
		$db = new PDO($dsn, $user, $password);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
		//プリペアドステートメントを作成
		$stmt = $db->prepare(
			"SELECT * FROM post "	
		);
		$pdo = new PDO('mysql:host=localhost;dbname=buono;charset=utf8','root','',
	array(PDO::ATTR_EMULATE_PREPARES => false));

		//パラメータの割り当て
		$page = $page * $num;
		$stmt->bindParam(':page', $page, PDO::PARAM_INT);
		$stmt->bindParam(':num', $num, PDO::PARAM_INT);
		//クエリの実行
		$stmt->execute();
	} catch (PDOException $e) {
		exit('データベース接続失敗。'.$e->getMessage());
	}
	//var_dump($_FILES);
	
?>

<!DOCTYPE html>
<html lang="jp">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>buono</title>
</head>
<body>
	<h1>buono</h1>
	<p><a href="buono_index.php">トップページに戻る</a></p>
	<form action="buono_write.php" enctype="multipart/form-data" method="post"> 
		<p>ユーザー<input type="text" name="user_name"></p>
		<p>料理名<input type="text" name="menu_name"></p>
		<p>レビュー</p><textarea name="message"></textarea>
		<input name="photo" type="file">
		<p><input type="submit" value="書き込む"></p>
	</form> 
	<hr />
			<?php
				while ($row = $stmt->fetch()):
					$user_name = $row['user_name'] ? $row['user_name'] : '(無題)';
			?>
		<p>名前：<?php echo $row['user_name'] ?></p>
		<p>料理名：<?php echo $row['menu_name'] ?></p>
		<p><?php echo nl2br($row['content'],false) ?></p>
		<p><?php echo '<img src="data:image/gif;base64,' . $row['photo'] . '">'; ?></p>
		<p><?php echo $row['photo'] ?></p>
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
</html>
