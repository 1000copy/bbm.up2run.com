<?
	include "config.inc.php";
	$which = $_POST['action'];
	if ($which =="clear"){
		$d = new DB;
		try{
			$sql = "delete from borrow";
			$d -> query($sql);
			$sql = "delete from borrow_detail";
			$d -> query($sql);
		}catch(Exception $e ){
			$log = new Log;
			$log -> warn("$e");
			$log -> warn($sql);
		}
	}
	if ($which =="search"){
		$title = $_POST["title"];
	}
	class BookLogPager extends Pager{
		private $sql ;
		public $from ;
		public $to ;
		public $titles ;
		public $is_borrow ;
		public function __construct($user_id,$page,$title){
			$this -> sql = "
				select u1.email as email1,u2.email as email2, tt.titles ,tt.is_return from 
				(
				     select b.devote_user_id,b.borrow_user_id ,
				     GROUP_CONCAT(bd.title SEPARATOR ',' ) titles,
				     bd.borrow_id ,b.is_return
				     from borrow b left join 
				          (
				          	select bk.title,bdetail.borrow_id,bk.id 
				          	from borrow_detail bdetail 
				          	left join book bk on bdetail.book_id = bk.id 
				          )
				     bd on b.id = bd.borrow_id group by bd.borrow_id
				) tt 
				left join user u1 on tt.devote_user_id = u1.id 
				left join user u2 on tt.borrow_user_id = u2.id 
			";
			parent::__construct($this-> sql,$page,$title);
		}
		public function next(){
			$row = $this -> db -> fetch_row($this -> result);
			if ($row){
				$this -> from = $row[0] ;
				$this -> to = $row[1] ;
				$this -> titles = $row[2] ;
				$this -> is_borrow = $row[3] !=1 ?"borrow":"return" ;
				return true;
			}else return false;
		}

	}

?>
<html >
<head>
	<title>book log </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
	<? bs_here();?>
	<link type="text/css" REL="StyleSheet" href="wrapper.css"/>
</head>
<body>
<? include "banner.php" ?>
<div id="wrapper">
<h1>books log </h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search"  method="post" class="form-inline">
	<input type="text" placeholder="some book title..." id="title" name="title" 
	value="<?echo $_POST["title"]; ?>" class="search-query input-medium"/>
	<input type="submit" name="action" class="btn-primary" value="search"/>
	<input type="submit" name="action" class="btn" value="clear"/>


<table cellpadding="2" class="table table-striped table-bordered">
	<tr>
		<th>#</th>
		<th>borrorw? </th>
		<th>devote user </th>
		<th>borrow user</th>
		<th>books</th>
	</tr>
<?
	
	$page = $_GET['page'];
	$curr_user_id = $_SESSION["user_id"];
	$title = trim($_POST['title']);
	$p = new BookLogPager($curr_user_id,$page,$title);
	try{
		while ($p ->next()) {
			echo "<tr>" .
			 	  "<td></td>" . 
			 	  "<td>{$p->is_borrow}</td>" .
			 	  "<td>{$p->from}</td>" .
			 	  "<td>{$p->to}</td>" .
			 	  "<td>{$p->titles}</td><tr>";
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