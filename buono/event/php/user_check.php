<?php
if( !isset($_SESSION["user_id"]) ){
	header("Location: /event/user_login.html");
	exit();
}
?>
