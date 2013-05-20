<? session_start()?>
<?php
	include "config.inc.php";
	login_required();
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
	$page = $_GET['page'];
	$get_user_id = $_GET['user'];
	if (!$page)
		$page = 1;
	$pagerecords = 10 ;
	$from = ($page-1)*$pagerecords;
	$to = $pagerecords;
	if (!$dbcheck) {die();}
	$sql = "
		select b.id ,b.title ,u.email as devoter_name,b.devote_id,b.state ,b.borrow_user_id ,
		u1.email as b_name
		from book b 
		left join user u on b.devote_id = u.id
		left join user u1 on b.borrow_user_id = u1.id		
	 ";
	$add_where = false;
	$title = trim($_POST['title']);
	if ($action=="search" && $title != "" ){
		$sql = $sql . " where title like '%". $title ."%' ";
		$add_where = true ;
	}
	if ($get_user_id){
		if ($add_where)
			$sql = $sql." and ";
		else 
			$sql = $sql." where ";
		$sql = $sql."devote_id = {$get_user_id}";
	}
	$count_sql = "select count(1) from (${sql}) balias";
	$sql = $sql . " limit ${from},${to}";
	$db = new DB;
	$total_records = $db -> query_1_1($count_sql);
?>
<html >
<head>
	<title>books</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
	<? bs_here();?>
	<link type="text/css" REL="StyleSheet" href="wrapper.css"/>
</head>
<body>
<? include "banner.php" ?>
<div id="wrapper">
<h1>books/<? echo $total_records;?> </h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search&user=<?echo $get_user_id;?>"  method="post" class="form-inline">
	<i class ="icon-search"></i><input type="text" placeholder="some book title..." id="title" name="title" 
	value="<?echo $_POST["title"]; ?>" class="search-query input-medium"/>
		<input type="submit" value="search" class="btn-primary "/>
		<a href ="book_new.php" class="btn">new book</a>
		<a href ="book_upload.php" class="btn">upload</a>
</form>
<table  class="table table-striped table-bordered">
	<tr>
		<th>#</th>
		<th>No.</th>
		<th>book title</th>
		<th>state</th>
		<th>devoter</th>
		<th>borrower</th>
	</tr>
<?
	$result = $db -> query($sql);
	if (mysql_num_rows($result) == 0) {die();}
	while ($row = mysql_fetch_row($result)) {
		$devote_id = $row[3];
		$curr_user_id = $_SESSION["user_id"];
		$borrowed = $row[4]!=0;
		$url_e ="";
		$url_d ="";
		$url_borrow="";
		if (!$borrowed)
			$url_borrow = "<a class='' href='book_borrow.php?id=".$row[0]."'>Borrow</a>&nbsp;" ;
		if ($devote_id == $curr_user_id){
			 $url_e = "<a  href='book_edit.php?id=".$row[0]."'>Edit</a>&nbsp;" ;
			 $url_d = "<a  href='book_delete.php?id=".$row[0]."'>Del</a>&nbsp;" ;
		
		}
		$bstr = get_state($row[4]);
		$btn_group = "<div class=''>".$url_e. $url_d.$url_borrow."</div>" ;
		echo "<tr>" .
		 	  "<td>" . $btn_group. "</td>" . 
		 	  "<td>" . $row[0] . "</td>" .
		 	  "<td>" . $row[1] . "</td>" .
		 	  "<td>" . $bstr . "</td>" .
		 	  "<td>" .abbr($row[2]) . "</td>".
		 	  "<td>" . abbr($row[6]) . "</td>".
		 	  "<tr>";
	}
?>
</table>
<?	
	$target = $_SERVER['PHP_SELF'];
	echo getPaginationString($page, $total_records, 
		$pagerecords, 1, $target, $pagestring = "?page=");
?>
</div><!-- end #wrapper -->
</body>
</html>