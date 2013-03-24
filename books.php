<html >
<head>
<title>books</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
#wrapper {
	width: 600px;
	margin: 20px auto 0;
	font: 1.2em Verdana, Arial, sans-serif;
}
</style>
</head>

<body>

<div id="wrapper">

<?php
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
?>

<?php if (!$action) { ?>

<h1>books </h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search"  method="post">
	<input type="text" value="some book title..." name="title"/>
	<input type="submit" value="search"/>
</form>
<table cellpadding="2">
	<tr>
		<th>id</th>
		<th>book title</th>
	</tr>
	<tr>
		<td>1</td>
		<td>悉尼</td>
	</tr>		
	<?
	$arr=array("one", "two", "three","four");
	foreach ($arr as $value)
	{
	  echo "<tr><td>" . $value . "</td>" . "<td>" . $value . "</tr>";
	}
	?>
	<?
	for($i=1;$i<5;$i++)
	{
	  $value = $i ;
	  echo "<tr><td>" . $value . "</td>" . "<td>" . $value . "</tr>";
	}
	?>
</table>

<?php } ?>

<?php if ($action == "search") {

// The variables have not been adequately sanitized to protect against SQL Injection attacks: http://us3.php.net/mysql_real_escape_string

	$title = trim($_POST['title']);
	$hostname ="127.0.0.1";
	$username = "root";
	$password = "";
	$database = "bb";
	$link = mysql_connect("$hostname", "$username", "$password");
	if (!$link) {
		echo "<p>Could not connect to the server '" . $hostname . "'</p>\n";
    	echo mysql_error();
	}
	if ($database) {
    	$dbcheck = mysql_select_db("$database");
		if (!$dbcheck) {
        	echo mysql_error();
		}else{
			echo "<p>Successfully connected to the database '" . $database . "'</p>\n";
			// Check tables
			$sql = "SHOW TABLES FROM `$database`";
			$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0) {
				echo "<p>Available tables:</p>\n";
				echo "<pre>\n";
				while ($row = mysql_fetch_row($result)) {
					echo "{$row[0]}\n";
				}
				echo "</pre>\n";
			} else {
				echo "<p>The database '" . $database . "' contains no tables.</p>\n";
				echo mysql_error();
			}
		}
	}
}
?>
</div><!-- end #wrapper -->
</body>
</html>