<?php
session_start();
include("user_check.php");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<title>ユーザーチャット | chat_sse</title>
	<link rel="stylesheet" href="/event/css/user_chat.css" />
</head>
<body data-owner="<?php echo $_SESSION["correct"];?>">
<div id="wrapper">
	<h1 class="theme">form遷移ありの自動更新テスト</h1>
	<p><a href="spa_chat.php">遷移なしのSPAチャット</a></p>
	<ul id="sample" class="no_move"></ul>
	<footer>
		<form action="/event/php/api_input.php" method="POST">
		<input type="hidden" name="cmade" value="<?php echo $_SESSION["correct"];?>" />
		<div class="uinput">
			<label for="uinput" class="icon"><i class="far fa-comment-dots"></i></label>
			<input type="text" name="uinput" id="uinput" value="" placeholder="チャット発言" />
			<button type="submit" name="write_input">発言する</button>
		</div>
		</form>
		<button id="reset"><i class="fas fa-undo-alt"></i></button>
	</footer>
</div><!-- /#wrapper -->
<script src="/event/js/all.js"></script>
<script src="/event/js/write_input.js"></script>
<script src="/event/js/user_chat.js"></script>
</body>
</html>
