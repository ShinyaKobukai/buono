<?php
session_start();
// include("user_check.php");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<title>SPAユーザーチャット | chat_sse</title>
	<link rel="stylesheet" href="/event/css/user_chat.css" />
</head>
<body data-owner="<?php echo $_SESSION["correct"];?>">
<div id="wrapper">
	<h1 class="theme">JS-fetchによるform遷移なしの自動更新テスト</h1>
	<ul id="sample"></ul>
	<footer>

		<input type="hidden" name="cmade" id="cmade" value="<?php echo $_SESSION["correct"];?>" />
		<div class="uinput">
			<label for="uinput" class="icon"><i class="far fa-comment-dots"></i></label>
			<input type="text" name="uinput" id="uinput" value="" placeholder="チャット発言" />
			<button type="submit" id="submit" name="write_input">発言する</button>
		</div>
		<button id="reset"><i class="fas fa-undo-alt"></i></button>

	</footer>
</div><!-- /#wrapper -->
<script src="/test/event/js/all.js"></script>
<script src="/test/event/js/spa_chat.js"></script>
</body>
</html>
