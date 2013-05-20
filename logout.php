<?
	session_start(); 
	include "config.inc.php" ;
	$log = new Log;
	$log->warn("is user_name set ?".$_SESSION['user_name']);
	if(isSet($_SESSION['user_name'])){
		unset($_SESSION["user_id"]);  
		unset($_SESSION["user_name"]);
		// $log->warn("is cookie name set ?".$cookie_name);
		// $log->warn("is cookie set ?".$_COOKIE[$cookie_name]);  
		if(isSet($_COOKIE[$cookie_name]))
		{
			setcookie ($cookie_name, '', time() - $cookie_time);
			// $log->warn("is cookie set ?".$_COOKIE[$cookie_name]);  
		}
	}
	session_destroy(); 
	header("Location:/login.php");
?>
