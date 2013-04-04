<?
	session_start(); 
	if($_SESSION['user_name'])
	{
		header("Location: book_list.php");
		exit;
	}
	include "config.inc.php";
	$action = $_GET['action'];
	if ($action=="login"){
		$fullname = $_POST['users'];
		$password = $_POST['password'];
		$autologin = $_POST['autologin'];
		$result = db_query ("select fullname ,password,id from user where email='${fullname}'");
		if (!$result){
			die (mysql_error());
		}
		if (db_row_count($result) >0 ){
			$row = db_fetch_row($result);
			if ($row[1] == md5($password )){
				$_SESSION['user_id'] = $row[2];
				// echo $row[2];
				$_SESSION['user_name'] = $row[0];
				$password_hash = md5($password); 
				$url = 'usr='.$fullname.'&hash='.$password_hash;
				// echo "url:".$url .$cookie_time;
				setcookie ($cookie_name, $url, time() + $cookie_time);
				// echo $_COOKIE[$cookie_name];
				header("Location:/book_list.php");
			}else{
				die("user / password do not match");	
			}
		}else
			die("user / password do not match - 1");	

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
		<input type="checkbox" name="autologin" value="1"/>Remember Me <br/>
	  	<input type="submit" value="登录" class="btn" />
	  	<a href="user_new.php" class="btn">注册</a>
		</form>
	</div>
</body>
</html>