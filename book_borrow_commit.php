<?
	session_start();
	include "config.inc.php";
	$user_id = $_SESSION['user_id'];
	$action = $_GET['action'];
	if ($action =="commit"){
		$book = new Book();
		$book->commit($user_id);
	}
?>
<html>
<head>
	<title>Waiting approvision </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
	<link type="text/css" REL="StyleSheet" href="wrapper.css"/>
	</style>
</head>
<body>	
	<? include "banner.php";?>
	<div id="wrapper">
		<h1>Waiting approve  </h1>
		<p>  <?echo $title;?></p>
		<a href="book_list.php" class="btn">back list</a>
		<table cellpadding="2" class="table table-striped table-bordered">
	<tr>
		<th>#</th>
		<th>No.</th>
		<th>book title</th>
		<th>devoter</th>
	</tr>
	
<?
	$page = $_GET['page'];
	if (!$page)
		$page = 1;
	$pagerecords = 10 ;
	$from = ($page-1)*$pagerecords;
	$to = $pagerecords;
	if ($dbcheck) {
		// echo $user_id;
		$sql = "select bo.id ,bo.title ,u2.email 
		from book bo 
		left join user u1 on bo.borrow_user_id = u1.id 
		left join user u2 on bo.devote_id = u2.id 
		where bo.state = 2 and bo.borrow_user_id = ${user_id}
		";//2== commit
		$count_sql = "select count(1) from (${sql}) balias";
		$sql = $sql . " limit ${from},${to}";
		// echo $count_sql;
		$result = db_query($count_sql);
		$row = mysql_fetch_row($result);
		$total_records = $row[0];
		// echo $total_records;
		$result = mysql_query($sql);
		if (!$result){
			echo mysql_error();
		}else
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_row($result)) {
				$devote_id = $row[3];
				$curr_user_id = $_SESSION["user_id"];
				$borrowed = $row[4]==1;
				$url_e ="";
				$url_d ="";
				$url_d = "" ;
				$btn_group = "<div class=''>".$url_d."</div>" ;
				echo "<tr>" .
				 	  "<td>" . $btn_group. "</td>" . 
				 	  "<td>" . $row[0] . "</td>" .
				 	  "<td>" . $row[1] . "</td>" .
				 	  "<td>" . $row[2] . "</td>" .
				 	  "<tr>";
			}
		} 
	}
?>
</table>
<?	
	// include "paginator.php";
	$target = $_SERVER['PHP_SELF'];
	echo getPaginationString($page, $total_records, 
		$pagerecords, 1, $target, $pagestring = "?page=");
	echo "totals: " . $total_records;
	echo "&nbsp; ";
	if (is_login())
	 	echo "user:". $_SESSION["user_name"];
?>
	</div>
</body>
</html>