<? session_start()?>
<?php
	include "config.inc.php";
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
	if(!isSet($_SESSION['user_name']))
	{
		header("Location: login.php");
		exit;
	}
	$uid = $_SESSION['user_id'];
	$user_id = $uid;
	$book = new Book();
	switch ($_POST['rcart']) {
		case 'return':
			$selected = $_POST['selected'];
			// die( $selected);
			// die("some");
			$book -> return_($selected,$uid);    
		    break;
		case 'return_all':
			$book -> return_all($uid);    
		    break;
	}

?>
<html >
<head>
	<title>books return cart </title>
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
	


<h1>books returning cart  </h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search"  method="post" class="form-inline">
	<input type="text" placeholder="some book title..." id="title" name="title" 
	value="<?echo $_POST["title"]; ?>" class="search-query input-medium"/>
	<input type="submit" name="rcart" class="btn-primary" value="search"/>
	<input type="submit" name="rcart" class="btn" value="return_all"/>
	<input type="submit" name="rcart" class="btn" value="return"/>

<table cellpadding="2" class="table table-striped table-bordered">
	<tr>
		<th>#</th>
		<th>No.</th>
		<th>book title</th>
		<!-- <th>state</th> -->
		<th>devoter</th>
	</tr>
<?
	
	$page = $_GET['page'];
	$curr_user_id = $_SESSION["user_id"];
	$title = trim($_POST['title']);
	$pager = new ReturnCartPager($curr_user_id,$page,$title);
	try{
		while ($pager ->next()) {
			$id = $pager -> id ;
			$title = $pager -> title;
			$email = $pager -> email;
			$devote_id = $pager -> devote_id;
			$state = $pager -> state;
			$borrowed = $pager -> state ==1;
			$url_e ="";
			$url_d ="";
			$url_borrow="";
			$url_check="<input type='checkbox' value='${id}' name='selected[]' checked/>";
			if ($devote_id == $curr_user_id){
				 $url_e = "<a  href='book_edit.php?id=".$id."'>Edit</a>&nbsp;" ;
				 $url_d = "<a  href='book_delete.php?id=".$id."'>Del</a>&nbsp;" ;
			
			}
			$bstr = get_state($state);
			// $bstr = $row[4];
			$btn_group = "<div class=''>".$url_e. $url_d.$url_check."</div>" ;
			echo "<tr>" .
			 	  "<td>" . $btn_group. "</td>" . 
			 	  "<td>" . $id . "</td>" .
			 	  "<td>" . $title . "</td>" .
			 	  // "<td>" . $bstr . "</td>" .
			 	  "<td>" . $email . "</td>" ."<tr>";
		}
		
	}catch(Exception $e ){$log = new Log();$log -> warn("${e}");}

?>
</table>
</form>
<?	
	echo $pager -> pager_str();
	echo "totals: " . $pager -> total_records;
?>
</div><!-- end #wrapper -->
</body>
</html>