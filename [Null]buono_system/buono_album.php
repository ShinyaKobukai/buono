<?php  
	include_once("common/db_connect.php");
	$pdo = db_connect();
	try{
		$posid_stmt = $pdo->prepare(
			"SELECT A.post_id,B.data FROM post as A,photo_data As B WHERE A.post_id = B.post_id"
		);
		$posid_stmt->execute();
		}catch(PDOEXception $e){
			die('エラー：'.$e->getMessage());
	}
?>

<html lang="jp">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/buono.css">
    <title>buono</title>
</head>
<body>
    <h1>buono</h1>
	<?php while ($result = $posid_stmt->fetch()): ?>
    <p><?php if(empty($result["data"]) == null){ echo '<p><a href="buono_main.php?post_id='.$result["post_id"].'"><img src="data:image/jpeg;base64,' . $result["data"] . '" width="60%" height="auto"></a></p>'; } ?></p>
	<?php endwhile;?>
    <p>
        <a href="buono_index.php">トップページに戻る</a>
        <a href="buono_main.php">投稿する</a>
    </p>
</body>
</html>