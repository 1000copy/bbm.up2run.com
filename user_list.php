<? session_start()?>
<?php
	include "config.inc.php";
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
	login_required();
	$page = $_GET['page'];
	if (!$page)
		$page = 1;
	$pagerecords = 10 ;
	$from = ($page-1)*$pagerecords;
	$to = $pagerecords;
	if (!$dbcheck) {die();}
	$sql = "select id  ,email,fullname ,notify from user u ";
	if ($action=="search"){
		$email = trim($_POST['email']);
		if($email != "")
			$sql = $sql . " where email like '%{$email}%' or fullname like '%{$email}%'";
	}
	$count_sql = "select count(1) from (${sql}) balias";
	$sql = $sql . " limit ${from},${to}";
	$d = new DB;
	try{
		$total_records = $d -> query_1_1($count_sql);
		$result = $d -> query($sql);
	}catch(Exception $e){$l = new Log;$l->warn("${e}");};
?>
<html >
<head>
	<title>users</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
	<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >
	<link type="text/css" REL="StyleSheet" href="wrapper.css"/>
</head>
<body>
<? include "banner.php" ?>
<div id="wrapper">
<h1>users/ <?echo $total_records;?></h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search"  method="post" class="form-inline">
	<input type="text" placeholder="some user name ..." id="email" name="email" 
	value="<?echo $_POST["email"]; ?>" class="search-query input-medium"/>
	<input type="submit" value="search" class="btn-primary"/>
	<? if (is_login()) { ?>
		<a href ="user_new.php" class="btn">new</a>
	<?}else{?>
		<a href="login.php" class="btn">login</a>
	<? } ?>
</form>
<? if (mysql_num_rows($result) <= 0) {die("No users");}
else{ ?>
<table cellpadding="2" class="table table-striped table-bordered">
	<tr>
		<th>#</th>
		<th>No.</th>
		<th>fullname</th>
		<th>email</th>
		<th>notify</th>
	</tr>
<?
	
	while ($row = mysql_fetch_row($result)) {
		$notify = $row[3] == 0 ?"false":"true";
		$url_e = "<a href='user_edit.php?id=".$row[0]."'>Edit</a>&nbsp;" ;
		$url_d = "<a href='user_delete.php?id=".$row[0]."'>Del</a>" ;
		echo "<tr>" .
			  "<td>" . $url_e. $url_d. "</td>" . 
			  "<td>" . $row[0] . "</td>" .
			  "<td>" . $row[2] . "</td>" .
			  "<td>" . $row[1] . "</td>" .
			  "<td>" . $notify . "</td>" .
			  "<tr>";
	} 
?>
</table>
<?}?>
<?	
	$target = $_SERVER['PHP_SELF'];
	echo getPaginationString($page, $total_records, 
		$pagerecords, 1, $target, $pagestring = "?page=");
?>


</div><!-- end #wrapper -->
</body>
</html>