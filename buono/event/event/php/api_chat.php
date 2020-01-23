<?php
session_start();
// include("user_check.php");
include("../../common/db_connect.php");

//このヘッダーでイベントストリーミング配信型になる
header('Content-Type: text/event-stream; charset=utf-8');
header('Cache-Control: no-store');
header('Connection: keep-alive');
//for nginx
header('X-Accel-Buffering: no');
//別ドメイン許可
header("Access-Control-Allow-Origin: *");

//date_default_timezone_set('Asia/Tokyo');

$room_id = $_SESSION['room_id'];
$count = 0;
$lastestid = 0;
$pdo = db_connect();
$sql = "SELECT * FROM chat_post WHERE room_id=?";
$sth = $pdo->prepare($sql);
$sth->execute(array($room_id));
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$limit = count($result);

for($i=0; $i<$limit; $i++){
	$chat = array(
		"message_id"  =>$result[$i]["message_id"],
		"room_id"     =>$result[$i]["room_id"],
		"user_id"     =>$result[$i]["user_id"],
		"message"     =>$result[$i]["message"],
		"post_time"		=>$result[$i]["post_time"]
	);
	//--push通信をあえてpingイベントとして送信する
	push($i,json_encode($chat,true),"ping");
	$lastestid = $i;
}

function push($id,$json,$event='message'){
	echo 'id: '   .$id    .PHP_EOL;
	echo 'event: '.$event .PHP_EOL;
	echo 'data: ' .$json  .PHP_EOL.PHP_EOL;
	clearstatcache();
	ob_end_flush();
	flush();
	//sleep(1);//あえて1秒おきにしない
}//--end function

?>