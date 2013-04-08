<?php
	session_start();
	include("config.inc.php");
	parse_str($_COOKIE[$cookie_name]);
	echo "user_id:".$_SESSION['user_id']."<br/>";
	echo "user_name:".$_SESSION['user_name']."<br/>";
	echo $usr."<br/>";
	echo $hash;
?>