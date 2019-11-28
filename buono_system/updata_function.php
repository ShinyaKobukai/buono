<?php
  $post_id = intval($_GET['post_id']);
  $content = trim(htmlspecialchars($_POST["updata_content"]));
  $dsn = 'mysql:host=localhost;dbname=buono;character=utf8';
  $user = 'root';
  $password = '';
  $driver_options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
  ];

  try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

    $updata_stmt = $db->prepare(
      "UPDATE post SET content=:content"  
    );
    $updata_stmt->execute();

    $user_stmt = $db->prepare(
      "SELECT user_name,post.post_id,food_name,content,data,post_date FROM post LEFT OUTER JOIN user ON user.user_id = post.user_id LEFT OUTER JOIN photo_data ON post.post_id = photo_data.post_id ORDER BY post_date DESC ;"  
    );
    $user_stmt->execute();

  } catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
  }
  var_dump($post_id);
  var_dump($content);
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
  </header>
      <div id="name">
        <p>編集が完了しました</font></p>
      </div>

      <div id="post_content">
        <p><?php echo $content ?></p>
      </div>
</body>
  <p><a href="buono_main.php">投稿一覧へ</a></p>
</html>        
