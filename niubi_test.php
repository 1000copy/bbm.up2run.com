<?php
	include("config.inc.php");
	parse_str($_COOKIE[$cookie_name]);
	echo $usr."<br/>";
	echo $hash;
?>