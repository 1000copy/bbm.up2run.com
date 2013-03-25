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
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=save"  method="post" 
		onsubmit="return validateForm()" 
		name = "myForm"
		>
		<input type="text" placeholder="book title..." id="title" name="title"/>*<p>
		<input type="text" placeholder="author..." id="author" name="author"/><p>
		<input type="text" placeholder="pub..." id="pub" name="pub"/><p>
		<input type="submit" value="保存并录新"/>
	</form>
</div>
<?php
		include "config.inc.php";
		$action = $_GET['action'];
		if ($action=="save"){
			$title = $_POST['title'];
			$sql = "insert into book (title)values('${title}')";
			$result = mysql_query($sql);
			if (!$result){
				echo mysql_error();
			}else {
				echo "saved ${title} ...";
			}	
		}
?>
</body>
</html>