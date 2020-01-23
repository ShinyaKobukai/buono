<?php
include_once("../common/db_connect.php");

if( isset($_POST["submit"]) ){
	foreach( $_POST as $key => $value ){
		$$key = trim(htmlspecialchars($value));
	}
	$pdo = db_connect();
	$sql = "SELECT uid,uname,upass,created_at FROM t_user WHERE uname=:uname";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':uname'=>$uid));
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	//そのユーザー名が未登録なら許可
	if( !count($result) ){
		$sql = "INSERT INTO t_user(uname,upass) VALUES(:uname,:upass)";
		$sth = $pdo->prepare($sql);
		$sth->execute(array(':uname'=>$uid,':upass'=>$pwd));
		header("Location: /event/user_login.html");
		exit();
	} else {
		/*
		この処理の欠点
		サーバーにいちいち遷移してから登録済みかどうか判定する上で返されること
		フラッド攻撃でノックアウトする処理だが、アクセスの絶対数が高くない場合は問題ない
		解決方法⇒JSで反応するAPI作れ
		遷移型をやめればいい
		*/
		header("Content-Type: text/html;charset=UTF-8");
		echo '<h1>そのユーザーはすでに登録済みです。再度別ユーザーをご登録ください。</h1>'.PHP_EOL;
		echo '<a href="/event/user_regist.html">ユーザー登録に戻る</a>'.PHP_EOL;
		exit();
	}
}
//--ダイレクトアクセスしてきたら強制送還
header("Location: /event/user_regist.html");
exit();
?>
