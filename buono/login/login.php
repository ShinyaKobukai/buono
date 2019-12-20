<?php
  session_start();
  include_once("../common/db_connect.php");
  $pdo = db_connect();
  if(isset( $_GET['msg'])){
    //$er_msg = $_GET['msg'];
  }else{
    //$er_msg = '';
  }


  if(isset($_POST['login'])){
    $password = $_POST['password'];
    $user_id = $_POST['user_id'];
    print("loginに関するパラメータを受け取りました");
    $_SESSION['user_id'] = $user_id;
    
    try{
      print("sqlを開始します");
      $sql = 'select count(*) from user where user_id=? and password=?';
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array($user_id,$password));
      $result = $stmt->fetch();
      $stmt = null;
      $pdo = null;

      if($result[0] != 0){
        header('Location: ../post_list.php');
        exit;
      } else {
        //$er_msg = 'ユーザー名またはパスワードに誤りがあります。';
      }
    }  catch (PDOException $e){
      echo $e->getMessage();
      exit;
    }
  }
?>