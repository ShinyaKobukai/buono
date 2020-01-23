<?php
session_start();
include("user_check.php");
include_once("../../common/db_connect.php");
//--送信されてきたリクエストデータを受け取る
$REQUEST = json_decode(file_get_contents('php://input'),true);
//--HTTPメソッド
$METHOD = $_SERVER["REQUEST_METHOD"];
//--チェック用配列
$CHECK = array();
//--すべてのヘッダー情報を取得
$ALLHD = getallheaders();


//--改ざんしずらいヘッダープロパティの確認
foreach( $ALLHD as $key => $val ){
	//--HTTP1.1と2.0対策で小文字化
	if( strtolower($key) == "content-type" && $val == "application/json" ){
		$CHECK[strtolower($key)] = 1;//OK
	}
	if( strtolower($key) == "accept" && $val == "application/json" ){
		$CHECK[strtolower($key)] = 1;//OK
	}
	if( strtolower($key) == "authorization" && $val != "" ){
		$CHECK[strtolower($key)] = 1;//OK
	}
}//--foreach

//--リクエストメソッドがGET以外のときContent-Type / Accept必須
if( $METHOD != "GET" ){
	//--最低限のヘッダー情報をJSで付与して送信していない場合に処理を終了させる
	if( $CHECK["content-type"] != 1 ){
		echo '{"status":"failure","message":"送信形式がJSONではありません"}';
		exit();
	}
	if( $CHECK["accept"] != 1 ){
		echo '{"status":"failure","message":"受信形式がJSONではありません"}';
		exit();
	}
}//end header

switch( $METHOD ){
	case "POST":
		POST_chat();
		break;
	default:
		echo '{"status":"failure"}';
		exit();
}

function POST_chat(){
	//--【重要】
	global $REQUEST,$CHECK,$ALLHD;
// echo json_encode($REQUEST,true);
// exit();


	/*
	if( $CHECK["authorization"] != 1 ){
		//--authorization情報がない
		echo '{"status":"login failed"}';
		exit();
	} else {
		//--トークン文字列32だけを変数に入れる
		$header_token = explode('Bearer ',$ALLHD["authorization"])[1];
	}
	*/
	$pdo = db_connect();
	$sql = "
	INSERT INTO
	 chat_post(room_id,user_id,message)
	VALUES(:rid,:cmade,:ctext)";
	
	$sth = $pdo->prepare($sql);
	$sth->execute(
		array(
			':rid'=>intval($REQUEST["rid"]),
			':ctext'=>$REQUEST["uinput"],
			':cmade'=>base64_decode($REQUEST["cmade"])
		)
	);
	//var_dump($sth);
	//exit;

	//確認
	$sql = "SELECT * FROM chat_post WHERE room_id=:rid AND message=:ctext AND user_id=:cmade";
	$sth = $pdo->prepare($sql);
	$sth->execute(
		array(
			':rid'=>intval($REQUEST["rid"]),
			':ctext'=>$REQUEST["uinput"],
			':cmade'=>base64_decode($REQUEST["cmade"]
		)
		));
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	if( count($result) ){
		echo '{"status":"success","message_id":"'.$result[0]["message_id"].'"}';
	} else {
		echo '{"status":"failure"}';
	}
	exit();
}//--end function

?>