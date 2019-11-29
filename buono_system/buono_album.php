<?php  

	$dsn = 'mysql:host=localhost;dbname=buono;character=utf8';
	$user = 'root';
	$password = '';

	try{
		$db = new PDO($dsn,$user,$password,array(PDO::ATTR_EMULATE_PREPARES=>false));
		$posid_stmt = $db->prepare(
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
    <title>buono</title>
</head>
<body>
    <h1>buono</h1>
<?php
	//var_dump($posid_stmt);
	while ($result = $posid_stmt->fetch()):
?>
    <p><?php 
			if(empty($result["data"]) == null){
				echo '<p><img src="data:image/jpeg;base64,' . $result["data"] . '" width="90%" height="auto"></p>'; 
			}
	?></p>
<?php endwhile;?>
    <p>
        <a href="buono_index.php">トップページに戻る</a>
        <a href="buono_write.php">投稿する</a>
    </p>
</body>
</html>