<?php
    include_once("../common/db_connect.php");
    $pdo = db_connect();
    //データの受け取り
    $post_id = intval($_GET['post_id']);
    $content = strval($_GET['content']);
?>
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
	<li><a href="../post_list.php"><i class="far fa-comments"></i>ポスト</a></li>
      </ul>
    </nav>
  </header>
<main>
  <div class="regi_info">
    <h1>レビュー編集</h1>
    <form action="edit_result.php" method="post">
      <label for="box">review</label>
      <textarea name="post_edit" cols="15" rows="4" maxlength="20" placeholder="ご意見・ご感想をご記入ください"></textarea>
      <input type="submit" value="編集する">           
    </form>
  </div>
</main>
  <footer>
    <address>&copy;2019 buono All Rights Reserved.</address>
  </footer>
  <script src="../js/all.js"></script>
</body>
</html>

