<?
	session_start(); 
	$_SESSION['user_id'] = 1 ;
	$_SESSION['user_name'] = '1000copy';
?>
<html>
<body>
	<? echo "login user id :" . $_SESSION['user_name'] ?>
</body>
</html>