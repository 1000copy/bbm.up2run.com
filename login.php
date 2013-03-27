<?
	session_start(); 
?>
<?
	include "config.inc.php";
	$action = $_GET['action'];
	if ($action=="login"){
		$fullname = $_POST['users'];
		$password = $_POST['password'];
		$result = db_query ("select fullname ,password from user where fullname='${fullname}'");
		if (!$result){
			die (mysql_error());
		}
		if (db_row_count($result) >0 ){
			$row = db_fetch_row($result);
			if ($row[1] == md5($password)){
				$_SESSION['user_id'] = $user_id ;
				$_SESSION['user_name'] = $row[0];
				header("Location:/book_list.php");
			}else{
				die("user / password do not match");	
			}
		}else
			die("user / password do not match - 1");	

	}else{
		// $result = db_query ("select id,fullname from user ");
		// if (!$result){
		// 	die (mysql_error());
		// }
		// if(db_row_count($result) == 0 )
		// {
		// 	exit ;
		// }
	}
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >
	<style type="text/css">
	#wrapper {
		width: 600px;
		padding-top: 100px;
		margin: 20px auto 0;
		font: 1.2em Verdana, Arial, sans-serif;
	}
	</style>
</head>
<body>
	<div id="wrapper">
		<h1>login </h1>
		<form action="<? echo $_SERVER['PHP_SELF'] ?>?action=login" method="post">
		<input type="text" placeholder="email" name="users" class="input" /><br/>
		<input type="password" placeholder="password" name="password" class="input" /><br/>
	  	<input type="submit" value="登录" class="btn" />
	  	<a href="user_new.php" class="btn">注册</a>
		</form>
	</div>
</body>
</html>