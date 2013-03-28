<?
	session_start(); 
	$user_id = $_SESSION["user_name"];
	unset($_SESSION["user_id"]);  
	unset($_SESSION["user_name"]);  
	session_destroy(); 
	header("Location:/book_list.php");
?>
