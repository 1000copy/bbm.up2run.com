<?
	session_start(); 
	include "config.inc.php" ;
	if(isSet($_SESSION['user_name'])){
		unset($_SESSION["user_id"]);  
		unset($_SESSION["user_name"]);  
		if(isSet($_COOKIE[$cookie_name]))
		{
			setcookie ($cookie_name, '', time() - $cookie_time);
		}
	}
	session_destroy(); 
	header("Location:/book_list.php");
?>
