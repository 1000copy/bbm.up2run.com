<?php
		include "config.inc.php";
		$id = $_GET['id'];
		$action = $_GET['action'];
		if (!$action){
			$sql = "select id,title from book where id = ${id}";
			$result = mysql_query($sql);
			if (!$result){
				echo mysql_error();
			}else {
				if (mysql_num_rows($result) > 0) {
					$row = mysql_fetch_row($result);
					$title = $row[1];
				} 
			}	
		}else{
			$title = $_POST['title'];
			$sql = "update  book  set title = '${title}' where id='${id}'";
			$result = mysql_query($sql);
			if (!$result){
				echo mysql_error();
			}else {
				header("Location:/");
				exit;
			}
		}
?>
<html >
<head>
	<title>books</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
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
		var x=document.forms["myForm"]["title"].value;
		if (x==null || x=="")
		  {
		  alert("title of book must be filled out");
		  return false;
		  }
		}
	</script>
</head>
<body>

<div id="wrapper">
	<h1>book new </h1>
	<form 
	 action="<? echo $_SERVER['PHP_SELF']; ?>?action=save&amp;id=<?echo $id?>" 
	 method="post" 
		onsubmit="return validateForm()" 
		name = "myForm"
		>
		<input type="text" placeholder="book title..." 
			id="title" name="title" value="<? echo ${title};?>"/>*<p>
		<input type="text" placeholder="author..." id="author" name="author"/><p>
		<input type="text" placeholder="pub..." id="pub" name="pub"/><p>
		<input type="submit" value="保存"/>
	</form>
</div>
</body>
</html>