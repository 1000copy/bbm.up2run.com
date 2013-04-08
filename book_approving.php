<? session_start()?>
<?php
	include "config.inc.php";
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
	$act = $_POST['act'];
	if(!isSet($_SESSION['user_name']))
	{
		header("Location: login.php");
		exit;
	}
	$uid = $_SESSION['user_id'];
	$user_name = $_SESSION['user_name'];
	$user_id = $uid;
	$to = "2392349@qq.com";
	// $message = "Hello! This is a simple email message.";
	$message = "--";
	$from = $user_name ;
	$headers = "From: $from";

	if ($act=="approve_all"){
		$sql = "select title from book where state =2 and devote_id =${uid}";
		try{
			$arr = $DB -> query_array($sql,0);
		}catch(Dbe $e){echo $e->getMessage();}
		$subject = "Your apply for book is approved ";
		$message = implode(",",$arr);
		$sql = 'update book set state = 3 where state =2 and devote_id ='.$uid; // 3== accept
		$result = db_query($sql);
		if (!result)
			echo mysql_error();

		
	}
	if ($act=="reject_all"){
		$sql = 'update book set state = 0 where state =2 and devote_id ='.$uid; // 3== accept
		$result = db_query($sql);
		if (!result)
			echo mysql_error();
		$subject = "Your apply for book is rejected ";
	}
	if ($act=="approve"){
		$selected = $_POST['selected'];
		$id_list = implode(",",$selected);
		// echo $id_list;
		// // exit;
		$sql = "update book set state = 3 where id in(${id_list})";
		// echo $sql;
		// exit;
		$result = db_query($sql);
		if (!result)
			echo mysql_error();
		$subject = "Your apply for book is approved(partly) ";
	}
	if ($act=="reject"){
		$selected = $_POST['selected'];
		$id_list = implode(",",$selected);
		$sql = "update book set state = 0 where id in(${id_list})";
		$result = db_query($sql);
		if (!result)
			echo mysql_error();
		$subject = "Your apply for book is reject(partly) ";
	}
	
	mail($to,$subject,$message,$headers);
	// echo "Mail Sent.";
?>
<html >
<head>
	<title>books</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
	<? bs_here();?>
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
	


<h1>books commited </h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search"  method="post" class="form-inline">
	<input type="text" placeholder="some book title..." id="title" name="title" 
	value="<?echo $_POST["title"]; ?>" class="search-query input-medium"/>
	<input type="submit" value="search" class="btn-primary" name="act"/>
	<input type="submit" value="approve_all" class="btn" name="act"/>
	<input type="submit" value="reject_all" class="btn" name="act"/>
	<input type="submit" value="approve" class="btn" name="act"/>
	<input type="submit" value="reject" class="btn" name="act"/>
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
		$sql = "select b.id ,b.title ,u.email,b.devote_id,b.state 
		from book b left join user u on b.devote_id = u.id 
		where u.id = ${user_id} and state=2 ";//commit
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
				$devote_id = $row[3];
				$curr_user_id = $_SESSION["user_id"];
				$borrowed = $row[4]==1;
				$url_e ="";
				$url_d ="";
				$url_borrow="";
				$id = $row[0];
				$url_check="<input type='checkbox' value='${id}' name='selected[]' checked/>";
				if ($devote_id == $curr_user_id){
					 $url_e = "<a  href='book_edit.php?id=".$row[0]."'>Edit</a>&nbsp;" ;
					 $url_d = "<a  href='book_delete.php?id=".$row[0]."'>Del</a>&nbsp;" ;
				
				}
				$bstr = get_state($row[4]);
				// $bstr = $row[4];
				$btn_group = "<div class=''>". $url_check . $url_e. $url_d.$url_borrow."</div>" ;
				echo "<tr>" .
				 	  "<td>" . $btn_group. "</td>" . 
				 	  "<td>" . $row[0] . "</td>" .
				 	  "<td>" . $row[1] . "</td>" .
				 	  // "<td>" . $bstr . "</td>" .
				 	  "<td>" . $row[2] . "</td>" ."<tr>";
			}
		} 
	}
?>
</table>
</form>
<?	
	include "paginator.php";
	$target = $_SERVER['PHP_SELF'];
	echo getPaginationString($page, $total_records, 
		$pagerecords, 1, $target, $pagestring = "?page=");
	echo "totals: " . $total_records;
	echo "&nbsp; ";
	if (is_login())
	 	echo "user:". $_SESSION["user_name"];
	 	echo "uid:".  $_SESSION["user_id"];
	 	// print_r($_SESSION);
?>


</div><!-- end #wrapper -->
</body>
</html>