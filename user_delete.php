<?
	include "config.inc.php";
	$id = $_GET['id'];
	$sql = "delete from user where id='${id}'";
	$result = mysql_query($sql);
	if (!$result){
		echo mysql_error();
	}else {
		header("Location:/user_list.php");
		exit;
	}
?>
