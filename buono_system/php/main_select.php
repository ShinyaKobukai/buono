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