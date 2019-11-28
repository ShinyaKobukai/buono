<?php
    //データの受け取り
    $content = strval($_GET['content']);

    $dsn = 'mysql:host=localhost;dbname=buono;character=utf8';
    $user = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $user, $password);
        $db -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

    } catch (Exception $e) {
              echo 'エラーが発生しました。:' . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <title>buono 編集</title>
    <link rel="stylesheet" type="text/css" href="buono.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="">
    </header>
        <div id="post">
        <div id ="menu_name">
            <form action="updata_function.php?post_id=<?php echo $row['post_id'] ?>" method="post">
        </div>
            <div id ="review"><p>編集</p></div>
            <div id ="write">
                <textarea name="updata_content"><?php echo $content;?></textarea> 
            </div>
            <p><input type="submit" value="編集する"></p>
        <br /><a href="buono_main.php">投稿一覧へ</a>
            </form>
    </div>
</body>
</html>
