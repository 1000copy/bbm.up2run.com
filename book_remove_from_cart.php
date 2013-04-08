<?
	include "config.inc.php";
	$id = $_GET['id'];
	$sql = "update  book set state = 0 where id='${id}'"; // 0 = normal
	$result = mysql_query($sql);
	if (!$result){
		echo mysql_error();
	}else {
		header("Location:/book_list.php");
		exit;
	}
?>
