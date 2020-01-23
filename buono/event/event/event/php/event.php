<?php
header('Content-Type: text/event-stream; charset=utf-8');
header('Cache-Control: no-store');
//for nginx
header('X-Accel-Buffering: no');
//別ドメイン許可
header("Access-Control-Allow-Origin: *");

$user = 'root';
$pass = '';
$host = 'localhost';
$dbn = 'chat_sse';
$dsn = "mysql:host={$host};dbname={$dbn};charset=utf8";
$pdo = new PDO($dsn,$user,$pass,array(PDO::ATTR_EMULATE_PREPARES=>false));
$sql = "SELECT * FROM t_chat";
$sth = $pdo->prepare($sql);
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$count = 0;
$limit = count($result);

while(true) {
	$count++;
	$dt = new DateTime('now',new DateTimeZone('Asia/Tokyo'));
	$xtime = $dt->format('His');
	//送信したい単位で空白行を1行入れないと送信されないそのため、\n\n
	printf("data: %s\n\n", json_encode([
		'time' => $dt->format('Y-m-d H:i:s'),
		'word' => 'テストチャット送信サンプル'.$result[$count]["ctext"],
	]));

	if( $count >= $limit ){
	printf("data: %s\n\n", json_encode([
		'time' => $dt->format('Y-m-d H:i:s'),
		'word' => "END-OF-STREAM",
	]));
	}
	ob_end_flush();
	flush();
	sleep(1);//--1秒おきに
}
exit();
?>
