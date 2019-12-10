<?php 
    if(isset( $_GET['msg'])){
    $er_msg = $_GET['msg'];
  }else{
    $er_msg = '';
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>profile edit</title>
	<link rel="stylesheet" href="../css/buono.css" />
</head>
<body>
  <header><img src="../image/logo.png" alt=""></header>
  <div id="form_div">
    <br/>
    <h1>プロフィール設定</h1>
    <form action="profile_editdb.php" method="POST" id="form" enctype="multipart/form-data">
        新しいユーザー名　:　<input type="text" name="user_name" value="" /><br/>
        <br/>
        <p>アイコンを選択してください</p><input name="user_icon" type="file"><br/>
        <br/>
		    現在のユーザーID　:　<input type="text" name="user_id" value="" /><br/>
        <br/>
        現在のパスワード　:　<input type="password" name="password" value="" /><br/>
        <input type="submit" name="edit"  value="設定する"  /><br /><br/>
       	<br/>
    </form>
  </div>
  <a href="../buono_index.php">トップページに戻る</a></br>
  <a href="../buono_main.php">投稿する</a>
</body>
</html>