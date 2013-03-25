<?
	session_start(); 
?>
<html>
<body>
<? 
	$user_id = $_SESSION["user_name"];
	unset($_SESSION["user_id"]);  
	unset($_SESSION["user_name"]);  
	session_destroy(); 
?>
<h1> logout : <? echo $user_id ?></h1>
</body>
</html>