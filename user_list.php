<? session_start()?>
<?php
	include "config.inc.php";
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
	login_required();
?>
<html >
<head>
	<title>users</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
	<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >
	<style type="text/css">
	#wrapper {
		width: 600px;
		margin: 60px auto 0;
		padding-top: 200px；
		font: 1.2em Verdana, Arial, sans-serif;
	}
	</style>
</head>
<body>
<? include "banner.php" ?>
<div id="wrapper">
<h1>users </h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search"  method="post" class="form-inline">
	<input type="text" placeholder="some user name ..." id="email" name="email" 
	value="<?echo $_POST["title"]; ?>" class="search-query input-medium"/>
	<input type="submit" value="search" class="btn-primary"/>
	<? if (is_login()) { ?>
		<a href ="user_new.php" class="btn">new</a>
	<?}else{?>
		<a href="login.php" class="btn">login</a>
	<? } ?>
</form>
<table cellpadding="2" class="table table-striped table-bordered">
	<tr>
		<th>#</th>
		<th>No.</th>
		<th>email</th>
	</tr>
<?
	$page = $_GET['page'];
	if (!$page)
		$page = 1;
	$pagerecords = 10 ;
	$from = ($page-1)*$pagerecords;
	$to = $pagerecords;
	if ($dbcheck) {
		$sql = "select id  ,email from user u ";
		if ($action=="search"){
			$email = trim($_POST['email']);
			if($email != "")
				$sql = $sql . " where email like '%". $email ."%' ";
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
				$url_e = "<a href='user_edit.php?id=".$row[0]."'>Edit</a>&nbsp;" ;
				$url_d = "<a href='user_delete.php?id=".$row[0]."'>Del</a>" ;
				echo "<tr>" .
					  "<td>" . $url_e. $url_d. "</td>" . 
					  "<td>" . $row[0] . "</td>" .
					  "<td>" . $row[1] . "</td>" .
					  "<tr>";
			}
		} 
	}
?>
</table>
<?	
	include "paginator.php";
	$target = $_SERVER['PHP_SELF'];
	echo getPaginationString($page, $total_records, 
		$pagerecords, 1, $target, $pagestring = "?page=");
	echo "totals: " . $total_records;
	echo "&nbsp; ";
	if (is_login())
	 	echo "user:". $_SESSION["user_name"];
?>


</div><!-- end #wrapper -->
</body>
</html>