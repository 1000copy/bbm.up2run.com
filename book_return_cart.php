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
	<link rel="StyleSheet" href="wrapper.css" type="text/css"/>
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
	$p = new ReturnCartPager($curr_user_id,$page,$title);
	try{
		while ($p ->next()) {
			$url_e ="";
			$url_d ="";
			$url_borrow="";
			$url_check="<input type='checkbox' value='{$p->id}' name='selected[]' checked/>";
			if ($p->devote_id == $curr_user_id){
				 $url_e = "<a  href='book_edit.php?id={$p->id}'>Edit</a>&nbsp;" ;
				 $url_d = "<a  href='book_delete.php?id={$p->id}'>Del</a>&nbsp;" ;
			}
			$bstr = get_state($p->state);
			// $bstr = $row[4];
			$btn_group = "<div class=''>".$url_e. $url_d.$url_check."</div>" ;
			echo "<tr>" .
			 	  "<td>" . $btn_group. "</td>" . 
			 	  "<td>{$p->id}</td>" .
			 	  "<td>{$p->title}</td>" .
			 	  "<td>{$p->email}</td>" ."<tr>";
		}
		
	}catch(Exception $e ){$log = new Log();$log -> warn("${e}");}

?>
</table>
</form>
<?	
	echo $p -> pager_str();
	echo "totals: " . $p -> total_records;
?>
</div><!-- end #wrapper -->
</body>
</html>