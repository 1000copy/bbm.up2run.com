<?
	include "config.inc.php";
	$sql = "delete from book ";
	$result = mysql_query($sql);
	if (!$result){
		echo mysql_error();
	}else {
		header("Location:/");
		exit;
	}
?>
