<?php
session_start();
include_once("../common/db_connect.php");

if( isset($_POST["login"]) ){
	foreach( $_POST as $key => $value ){
		$$key = trim(htmlspecialchars($value));
	}
	$pdo = db_connect();
	$sql = "SELECT uid,uname,upass,created_at FROM t_user WHERE uname=:uname AND upass=:upass";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':uname'=>$uid,':upass'=>$pwd));
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	//正しい登録ユーザーなら許可
	if( count($result) ){
		$_SESSION["correct"] = base64_encode($uid);
		header("Location: /event/php/user_chat.php");
		exit();
	} else {
		$_SESSION = array();
		header("Content-Type: text/html;charset=UTF-8");
		echo '<h1>そのユーザーは不正です。ログインしなおしてください。</h1>'.PHP_EOL;
		echo '<a href="/event/user_login.html">ユーザーログインに戻る</a>'.PHP_EOL;
		exit();
	}
}
//--ダイレクトアクセスしてきたら強制送還
header("Location: /event/user_login.html");
exit();
?>
