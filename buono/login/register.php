<?php
  if(isset($_POST['register'])){
    if ( empty($_POST['user_id']) || empty($_POST['password']) || empty($_POST['re_pass']) ) {
      //$_SESSION["msg"] = '入力してください';
      header('Location: register.html');
      exit;    
    }

    if ( $_POST['password'] != $_POST['re_pass'] ) {
      //$_SESSION["msg"] = '同じパスワードを入力してください';
      header('Location: register.html');
      exit;    
    }

    foreach($_POST as $key => $val){
        $$key=trim(htmlspecialchars($val)); 
    }

    if( isset($_FILES["user_icon"]) ){
      $user_icon = file_get_contents($_FILES["user_icon"]["tmp_name"]);
      $user_icon = str_replace("data:image/jpeg;base64,","",$user_icon);
      $user_icon = base64_encode($user_icon);
    }

      try{
        $db = new PDO('mysql:host=localhost;dbname=buono;character=utf8','root','');
        //ユーザーID重複チェック
        $pre_sql = 'SELECT user_id FROM user WHERE user_id=?';
        $stmt = $db->prepare($pre_sql);
        $stmt->execute(array($user_id));
        $result = $stmt->fetch();

    
        while($result == true){
          //$_SESSION["msg"] = 'そのユーザーは既に存在しています。';
          header('Location: register.html');
          exit;    
        }

        //データベースにアカウント情報を登録
        if (!empty($user_icon)) {
          $sql = 'insert into user(user_id,password,user_name,icon) values(?,?,?,?)';
          $stmt = $db->prepare($sql);
          $stmt->execute(array($user_id,$password,$user_name,$user_icon));
          $stmt = null;
          $db = null;
        }
        if (empty($user_icon)) {
          $sql = 'insert into user(user_id,password,user_name) values(?,?,?)';
          $stmt = $db->prepare($sql);
          $stmt->execute(array($user_id,$password,$user_name));
          $stmt = null;
          $db = null;
        }
        header('Location: login.html');
        exit;
      } catch (PDOException $e){
        echo $e->getMessage();
        exit;
      }
    }
?>