<?php
    include_once("../common/db_connect.php");
    $pdo = db_connect();
    //データの受け取り
    $post_id = intval($_GET['post_id']);
    $content = strval($_GET['content']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <title>buono 編集</title>
    <link rel="stylesheet" type="text/css" href="../css/buono.css">
</head>
<body>
    <header>
        <img src="../image/logo.png" alt="">
    </header>
        <div id="post">
        <div id ="menu_name">
            <form action="post_edit.php?post_id=<?php echo $post_id?>" method="post">
        </div>
            <div id ="review"><p>編集</p></div>
            <div id ="write">
                <textarea name="content_editdb"><?php echo $content;?></textarea> 
            </div>
            <p><input type="submit" value="編集する"></p>
        <br /><a href="../buono_main.php">投稿一覧へ</a>
            </form>
    </div>
</body>
</html>
