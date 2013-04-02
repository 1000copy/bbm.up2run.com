<?php
		include "config.inc.php";
		$id = $_GET['id'];
		$action = $_GET['action'];
		if (!$action){
			$sql = "select id,email from user where id = ${id}";
			$result = mysql_query($sql);
			if (!$result){
				echo mysql_error();
			}else {
				if (mysql_num_rows($result) > 0) {
					$row = mysql_fetch_row($result);
					$email = $row[1];
				} 
			}	
		}else{
			$email = $_POST['email'];
			$sql = "update  user  set email = '${email}' where id='${id}'";
			$result = mysql_query($sql);
			if (!$result){
				echo mysql_error();
			}else {
				header("Location:/user_list.php");
				exit;
			}
		}
?>
<html >
<head>
	<email>users</email>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
	<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >
	<style type="text/css">
	#wrapper {
		width: 600px;
		margin: 20px auto 0;
		font: 1.2em Verdana, Arial, sans-serif;
	}
	</style>
	<script>
		function validateForm()
		{
		var x=document.forms["myForm"]["email"].value;
		if (x==null || x=="")
		  {
		  alert("email of user must be filled out");
		  return false;
		  }
		}
	</script>
</head>
<body>
<? include "banner.php" ?>
<div id="wrapper">
	<h1>user new </h1>
	<form 
	 action="<? echo $_SERVER['PHP_SELF']; ?>?action=save&amp;id=<?echo $id?>" 
	 method="post" 
		onsubmit="return validateForm()" 
		name = "myForm"
		>
		<input type="text" placeholder="user email..." 
			id="email" name="email" value="<? echo ${email};?>"/>*<p>
		<input type="submit" value="保存"/>
	</form>
</div>
</body>
</html>