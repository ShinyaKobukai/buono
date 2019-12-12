<?php
	include_once("../common/db_connect.php");
	$pdo = db_connect(); 

	if(empty($_POST['word']) == null){
		$input = $_POST['word'];
	}else if (empty($_POST['food_name']) == null) {
		$input = $_POST['food_name'];
	}
	$num = 10;
	$page = 0;
	if(isset($_GET['page']) && $_GET['page'] > 0){
		$page = intval($_GET['page']) -1;
	}

	$storage = $input;
	try{
		if(strpos($input,'#') !== false){
			$input = '%'.$input.'%';
			$stmt = $pdo->prepare("
				SELECT * FROM post,user,tag WHERE post.user_id = user.user_id AND tag.tag_name LIKE :tag ORDER BY post_date DESC LIMIT :page, :num
			");
			$page = $page * $num;
			$stmt->bindParam(':tag', $input,PDO::PARAM_STR);
			$stmt->bindParam(':page', $page, PDO::PARAM_INT);
			$stmt->bindParam(':num', $num, PDO::PARAM_INT);
			$stmt->execute();
		}else{
			$input = '%'.$input.'%';
			$stmt = $pdo->prepare("SELECT * FROM post,user WHERE post.user_id = user.user_id AND post.food_name LIKE :food_name ORDER BY post_date DESC LIMIT :page, :num");
			$page = $page * $num;
			$stmt->bindParam(':food_name', $input,PDO::PARAM_STR);
			$stmt->bindParam(':page', $page, PDO::PARAM_INT);
			$stmt->bindParam(':num', $num, PDO::PARAM_INT);
			$stmt->execute();
		}
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
	<div id="result"><img src="../image/loope.png" alt="">　検索ワード　<?php echo "：".$storage; ?></div>
	</br>
<?php
	while ($row = $stmt->fetch()):
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
		echo '<div id="page">';
		for ($i=1; $i <= $max_page; $i++) { 
			if(empty($_POST['word']) == null){
				echo '<form action="search_result.php?page='. $i .'" name="form'.$i.'" method="post"><input type="hidden" name="word" value="'.$_POST['word'].'" /><p><a href="javascript:form'.$i.'.submit()">'.$i. '</a></p></form>&nbsp;';
			}else if (empty($_POST['food_name']) == null) {
				echo '<form action="search_result.php?page='. $i .'" name="form'.$i.'" method="post"><input type="hidden" name="word" value="'.$_POST['food_name'].'" /><p><a href="javascript:form'.$i.'.submit()">'.$i. '</a></p></form>&nbsp;';
			}
		}
		echo '</div>';
	?>
	</div>
	<div id="main">
		<a href="../buono_main.php">投稿に戻る</a>
	</div>
</body>
</html>