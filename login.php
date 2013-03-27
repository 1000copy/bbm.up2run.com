<?
	session_start(); 
?>
<?
	include "config.inc.php";
	$action = $_GET['action'];
	if ($action=="login"){
		$user_id = $_POST['users'];
		$result = db_query ("select fullname from user where id=${user_id}");
		if (!$result){
			die (mysql_error());
		}
		$row = db_fetch_row($result);
		$_SESSION['user_id'] = $user_id ;
		$_SESSION['user_name'] = $row[0];
		header("Location:/book_list.php");
	}else{
		$result = db_query ("select id,fullname from user ");
		if (!$result){
			die (mysql_error());
		}
		if(db_row_count($result) == 0 )
		{
			exit ;
		}
	}
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<? echo "login user id :" . $_SESSION['user_name'] ?>
	<form action="<? echo $_SERVER['PHP_SELF'] ?>?action=login" method="post">
	<select name = "users" >
		<?
		while($row = db_fetch_row($result)){// $row[0]
		?>
  			<option value="<? echo $row[0];?>"><?echo $row[1]?></option>
  		<?}?>
  	</select>
  	<input type="submit"/>
	</form>
</body>
</html>