<?php
  include_once("common/db_connect.php");
  session_start();
  if(!isset($_SESSION['user_id'])){
    header("Location: login/login.php");
    //print("user_idがないでござる");
    exit();
  }
  if (isset($_SESSION['user_id'])) {
    $login_user = $_SESSION['user_id'];
  }
  //1ページに表示させるコメントの数
  $num = 10;
  //ページ数が指定されているとき
  $page = 0;
  if(isset($_GET['page']) && $_GET['page'] > 0){
    $page = intval($_GET['page']) -1;
  }
  try {
    //データベースに接続
    $pdo = db_connect();
    //プリペアドステートメントを作成
    $user_stmt = $pdo->prepare(
      " SELECT
        user.user_id,
        user.user_name,
        user.icon,
        post.post_id,
        post.food_name,
        post.content,
        post.place,
        post.post_date,
        tag.tag_id,
        tag.tag_name
        FROM 
        user,
        post
        left outer join
        (post_tag join tag on tag.tag_id = post_tag.tag_id)
        on post.post_id = post_tag.post_id
        WHERE 
        post.user_id = user.user_id
        ORDER BY 
        post_date 
        DESC
        LIMIT 
        :page, :num"  
    );
    //パラメータの割り当て
    $page = $page * $num;
    $user_stmt->bindParam(':page', $page, PDO::PARAM_INT);
    $user_stmt->bindParam(':num', $num, PDO::PARAM_INT);
    //クエリの実行
    $user_stmt->execute();

  } catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <link rel="stylesheet" href="css/post_form.css" type="text/css">
    <link rel="stylesheet" href="css/post_list.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <title>Buono -投稿一覧-</title>
</head>
<body>
  <header>
    <nav id="menu">
      <ul>
        <li><a href="home.html"><i class="fas fa-home"></i>ホーム</a></li>
        <li><a href="login/register.html"><i class="fas fa-user"></i>アカウント作成</a></li>
        <li><a href="login/login.html"><i class="fas fa-sign-in-alt"></i>ログイン</a></li>
        <li><a href="edit/profile_edit.html"><i class="fas fa-user-cog"></i>プロフィール編集</a></li>
        <li><a href="post_list.php"><i class="far fa-comments"></i>ポスト</a></li>
      </ul>
    </nav>
  </header>
<main>
  <?php
  while ($row = $user_stmt->fetch()):
    $food_name = $row['food_name'] ? $row['food_name'] : '(無題)';
?>
    <div id="TimeLine">     
      <div id="Post_content">
      <div class="name">
        <?php 
          if(empty($row['content']) == null){
            echo '<div class="icon">
                    <img src="data:image/jpg;base64,' . $row['icon'] . ' "> '.$row['user_name'].'</div>';
          }
        ?>
      </div>
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
                            echo '<div class="content_photo"><img src="data:image/jpeg;base64,' . $line['data'] . '" height="auto" width="45%"></div>';
              }
            }
          }
          ?>
        <div class="info">
          <div class ="food_name"><img src="img/food_menu.png" alt="menu:" width="16" height="16"><?php echo $row['food_name'] ?></div>
          <div class="place"><img src="img/balloon.png" alt="場所" width="16" height="16"><?php echo $row['place'] ?></div>
          <div class="date"><img src="img/clock.png" alt="date:" width="16" height="16"><?php echo $row['post_date'] ?></div>
        </div>
        <div class="content"><img src="img/content.png" alt="review:" width="16" height="16">　<?php echo nl2br($row['content'],false) ?></div>
        <?php 
          //タグが存在した場合の処理
          if (isset($row['tag_name'])) {
            echo '<div class="hash">' .$row['tag_name']. '</div>';
          } 
          //ログインの中ユーザーのみ削除と編集のボタンを出す
          if ($login_user == $row['user_id']) {
            echo 
              '<div class="button">
                <div class="edit"><a href="edit/content_edit.php?content='.$row['content'].'&amp;post_id='.$row['post_id'].'">編集</a></div>
                <div class="delete"><a href="edit/content_delete.php?post_id='.$row['post_id'].'">削除</a></div>
              </div>';
          }
        ?>
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
  echo '<p>';
  for ($i=1; $i <= $max_page; $i++) { 
    echo '<a href="post_list.php?page='. $i .'">'.$i. '</a>&nbsp;';
  }
  echo '</p>';

?>
</main>
<div id="post_button">
  <button>
    <img src="img/post_icon.png" id="open" alt="ボタン" />
  </button>
</div>
<div id="black-layer"></div>
<div id="flex-area">
  <div id="post_form">
    <div id ="menu_name">
      <p id="top_form">投稿</p>
      <form action="post_write.php" enctype="multipart/form-data" method="post">
          <p><input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>"></p></br>
          <p><img src="image/food_menu.png" alt="menu:" width="16" height="16"><input type="text" name="food_name" placeholder="メニューの名前を入力してください（必須）" size="40" maxlength="20"></p> 
        </div>
          <div id ="review">  
            <p><img src="image/content.png" alt="review:" width="16" height="16"><textarea name="content" placeholder="感想を入力してください（必須）" rows="4" cols="31"></textarea></p>
          </div>
          <p><img src="image/balloon.png" alt="場所:" width="16" height="16"><input type="text" name="place" placeholder="場所を入力してください（任意）" size="40" maxlength="20"></p> 
          <div id ="write">
              <p><input type="file" name="photo[]" id="photo" multiple="multiple" accept="image/jpeg,*.jpg" /></p>
              <input type="hidden" id="base64" name="date" value="" />
              <p><input type="submit" value="投稿する"></p></br>
          </div>  
        </div>
      </form> 
  </div>
</div>
  <footer>
    <address>&copy;2019 buono All Rights Reserved.</address>
  </footer>
 
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/post-form.js"></script>
  <script src="js/all.js"></script>
</body>
</html>
