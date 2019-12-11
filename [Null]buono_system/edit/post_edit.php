<?php
  include_once("../common/db_connect.php");
  $pdo = db_connect();
  $post_id = intval($_GET['post_id']);
  $content = trim(htmlspecialchars($_POST["content_editdb"]));
  try {
    $updata_stmt = $pdo->prepare(
      "UPDATE post SET content=:content_editdb WHERE post_id=:post_id "  
    );
    $updata_stmt->bindParam(':post_id',$post_id,PDO::PARAM_INT);
    $updata_stmt->bindParam(':content_editdb',$content,PDO::PARAM_STR);
    $updata_stmt->execute();

    $user_stmt = $pdo->prepare(
      "SELECT user_name,post.post_id,food_name,content,data,post_date FROM post LEFT OUTER JOIN user ON user.user_id = post.user_id LEFT OUTER JOIN photo_data ON post.post_id = photo_data.post_id ORDER BY post_date DESC ;"  
    );
    $user_stmt->execute();

  } catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
  }
  //var_dump($post_id);
  //var_dump($content);
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
  <title>buono</title>
  <link rel="stylesheet" type="text/css" href="../css/buono.css">
</head>
<body>
  <header>
    <img src="../image/logo.png" alt="">
  </header>
      <div id="edit">
        <h3>編集が完了しました</h3>
        <p>レビュー：<?php echo $content ?></p>
      </div>
</body>
  <p><a href="../buono_main.php">投稿一覧へ</a></p>
</html>        
