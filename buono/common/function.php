<?php

  //�Z�b�V�����̊J�n
  session_start();

  //�f�[�^�x�[�X�ڑ�
  function db_connect(){
    $db = 'mysql:host=localhost;dbname=buono;character=utf8';
    $user = 'root';
    $password = '';
    $driver_options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO(
         $db,
         $user,
         $password,
         $driver_options
    );
    return $pdo;
  }

  //���O�C���L���̃`�F�b�N
  function login_check() {
    if( !isset($_SESSION["user_id"]) ){
      header("Location: index.php");
      exit();
    }
  }

  //���O�C���̗L���ɂ�郁�j���[�\���̊��蓖��
  /*
  function menu() {
    if(!empty($_SESSION['user_id'])){
      echo '<li><a href="logout.php"><i class="fas fa-sign-in-alt"></i> <span>���O�A�E�g</span></a></li>
            <li><a href="post_list.php"><i class="far fa-comments"></i>���e</a></li>';
    }else{
      echo '<li><a href="login/register.html"><i class="fas fa-user"></i>�A�J�E���g�쐬</a></li>
            <li><a href="login/login.html"><i class="fas fa-sign-in-alt"></i> <span>���O�C��</span></a></li>';
    }
  }
  */

  //�p�����[�^
  function parameter(){
    $P['user_name'] = trim(htmlspecialchars($_POST['user_name']));
    $P['password'] = trim(htmlspecialchars($_POST['password']));
    $P['user_id'] = trim(htmlspecialchars($_POST['user_id']));
    $P['content'] = trim(htmlspecialchars($_POST['content']));
    $P['food_name'] = trim(htmlspecialchars($_POST['food_name']));
    $P['place'] = trim(htmlspecialchars($_POST['place']));
    return $P;
  }

  function photo(){
    $data = file_get_contents($_FILES["photo"]["tmp_name"]);
    $data = str_replace("data:image/jpeg;base64,","",$data);
    $data = base64_encode($data);
    return $data;
  }

?>