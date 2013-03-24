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
	include "config.inc.php";
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
?>


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
<?
	
	if ($dbcheck) {
		$sql = "select * from book";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_row($result)) {
				 echo "<tr><td>" . $row[0] . "</td>" . "<td>" . $row[1] . "</tr>";
			}
		} 
	}
?>
</table>

</div><!-- end #wrapper -->
</body>
</html>