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
</head>
<body>
<div id="wrapper">
	
<?php
	include "config.inc.php";
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
?>


<h1>books </h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search"  method="post">
	<input type="text" placeholder="some book title..." id="title" name="title" 
	value="<?echo $_POST["title"]; ?>"/>
	<input type="submit" value="search"/>
	<a href ="book_new.php">new book</a>
</form>
<table cellpadding="2">
	<tr>
		<th>OP</th>
		<th>id</th>
		<th>book title</th>
	</tr>
<?
	
	$page = $_GET['page'];
	if (!$page)
		$page = 1;
	$pagerecords = 10 ;
	$from = ($page-1)*$pagerecords;
	$to = $page*$pagerecords;
	if ($dbcheck) {
		$sql = "select id ,title  from book";
		if ($action=="search"){
			$title = trim($_POST['title']);
			if($title != "")
				$sql = $sql . " where title like '%". $title ."%' ";
			
			//echo $sql ;
		}
		$count_sql = "select count(1) from (${sql}) balias";
		$sql = $sql . " limit ${from},${to}";
		// echo $sql;
		// echo $count_sql;
		$result = mysql_query($count_sql);
		$row = mysql_fetch_row($result);
		$total_records = $row[0];
		// echo $total_records;
		$result = mysql_query($sql);
		if (!$result){
			echo mysql_error();
		}else
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_row($result)) {
				 $url_e = "<a href='book_edit.php?id=".$row[0]."'>Edit</a>&nbsp;" ;
				 $url_d = "<a href='book_delete.php?id=".$row[0]."'>Del</a>" ;
				 echo "<tr>" .
				 	  "<td>" . $url_e. $url_d. "</td>" . 
				 	  "<td>" . $row[0] . "</td>" .
				 	  "<td>" . $row[1] . "</td>" ."<tr>";
			}
		} 
	}
?>
</table>
<?	
	include "paginator.php";
	$target = $_SERVER['PHP_SELF'];
	echo getPaginationString($page, $total_records, $pagerecords, 1, $target, $pagestring = "?page=");
?>
</div><!-- end #wrapper -->
</body>
</html>