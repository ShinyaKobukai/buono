<?php
  include_once("../common/db_connect.php");
  $pdo = db_connect();
  $post_id = intval($_POST['post_id']);
  $content = trim(htmlspecialchars($_POST["post_edit"]));
  try {
    $updata_stmt = $pdo->prepare(
      "UPDATE post SET content=:content WHERE post_id=:post_id "  
    );
    $updata_stmt->bindParam(':post_id',$post_id,PDO::PARAM_INT);
    $updata_stmt->bindParam(':content',$content,PDO::PARAM_STR);
    $updata_stmt->execute();
    $user_stmt = $pdo->prepare(
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
  <link rel="stylesheet" type="text/css" href="../css/buono.css">
</head>
<body>
  <header>
    <img src="../image/logo.png" alt="">
  </header>
      <div id="name">
        <p>編集が完了しました</font></p>
      </div>
      <div id="post_content">
        <p>レビュー：<?php echo $content ?></p>
      </div>
</body>
  <p><a href="../post_list.php">投稿一覧へ</a></p>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/common.css" type="text/css">
    <link rel="stylesheet" href="../css/register.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <title>Buono -投稿編集-</title>
</head>
<body>
  <header>
    <nav id="menu">
      <ul>
        <li><a href="../home.html"><i class="fas fa-home"></i>ホーム</a></li>
        <li><a href="register.html"><i class="fas fa-user"></i>アカウント作成</a></li>
        <li><a href="login.html"><i class="fas fa-sign-in-alt"></i>ログイン</a></li>
      </ul>
    </nav>
  </header>
<main>
  <div class="regi_info">
    <h1>レビュー編集</h1>
    <form action="edit_result.php" method="post">
      <label for="box">編集が完了しました</label></br>
      <p>レビュー：<?php echo $content ?></p>
    </form>
  </div>
</main>
  <footer>
    <address>&copy;2019 buono All Rights Reserved.</address>
  </footer>
  <script src="../js/all.js"></script>
</body>
</html>