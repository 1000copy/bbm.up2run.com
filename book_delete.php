<?
	include "config.inc.php";
	$id = $_GET['id'];
	$sql = "delete from book where id='${id}'";
	$result = mysql_query($sql);
	if (!$result){
		echo mysql_error();
	}else {
		header("Location:/");
		exit;
	}
?>
