<?
	session_start(); 

	include "config.inc.php";
	login_required();
?>
<html>
<head>
	<title>bbm.up2run.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >
	<link type="text/css" REL="StyleSheet" href="wrapper.css"/>
</head>
<body>
	<? include "banner.php" ?>	
		<?
			
			$d = new DB;
			$borrowed = 0 ;
			$approved = 100;
			$return_cart = 0;
			$return_commited=0;
			// borrow role 
			$curr_user_id = $_SESSION["user_id"];
			$sql = "select count(*) from book where borrow_user_id = ${curr_user_id} and state = 1";
			$borrowed = $d -> query_1_1($sql);
			$sql = "select count(*) from book where borrow_user_id = ${curr_user_id} and state = 2";
			$commited = $d -> query_1_1($sql);
			$sql = "select count(*) from book where borrow_user_id = ${curr_user_id} and state = 3";
			$return_cart = $d -> query_1_1($sql);
			$sql = "select count(*) from book where borrow_user_id = ${curr_user_id} and state = 4";
			$return_commited = $d -> query_1_1($sql);
			// devote role
			$sql = "select count(*) from book where devote_id = ${curr_user_id} and state = 2";
			$approving = $d -> query_1_1($sql);
			$sql = "select count(*) from book where devote_id = ${curr_user_id} and state = 3";
			$approved = $d -> query_1_1($sql);
			$sql = "select count(*) from book where devote_id = ${curr_user_id} and state = 4";
			$return_confirming = $d -> query_1_1($sql);
			// statics 
			$borrow_totals = 0 ;
			$sql = "select count(*) 
				from borrow  b left join borrow_detail d 
				on b.id = d.borrow_id 
				where is_return = 0 ";
			$borrow_totals = $d -> query_1_1($sql);
			$sql = "select count(*) 
				from borrow  b left join borrow_detail d 
				on b.id = d.borrow_id 
				where is_return = 1 ";
			$return_totals = $d -> query_1_1($sql);
		?>
		<!-- borrow user role -->
		<div class="container" >
			<div class="row" >
				<div class="span3 ">
					<h2>as borrower</h2>
					<p> <a href="book_borrow.php">borrow cart </a> <?echo $borrowed ?>
					<p> <a href="book_borrow_commit.php"> commited</a>  <?echo $commited ?></p>
					<p> <a href="book_return_cart.php">return cart</a> <?echo $return_cart ?></p>
					<p> <a href="book_return_confirm.php">return commit</a> <?echo $return_commited ?></p>
				</div>
				<div class="span3">
					<h2>as devoter </h2>
					<p> <a href="book_approving.php">approving </a> <?echo $approving ?></p>
					<p> <a href="book_return_confirm.php">return confirming </a> <?echo $return_confirming ?></p>
				</div>
				<div class="span3">
					<h2>System</h2>
					<a href="book_log.php" class="btn">history</a>
					<p> <a href="user_list.php" class="btn"> users</a> 
					<p> <a href="book_clear_all.php" class="btn btn-warning">clear all</a>
				</div>
				<div class="span3">
					<h2>Statics</h2>
					<p> borrow totals : <?echo $borrow_totals ?></p>
					<p> return totals : <?echo $return_totals ?></p>
				</div>
			</div>
		</div>
	
</body></html>

