<? session_start()?>
<?php
	include "config.inc.php";

	class BookListPager extends Pager{
		private $sql ;
		public $id ;
		public $title ;
		public $devoter_name ;
		public $devote_id ;
		public $state ;
		public $borrow_user_id ;
		public $b_name ;
		public $get_user_id;
		public function __construct($user_id,$page,$title,$action){
			$this -> sql = "
			select b.id ,b.title ,u.email as devoter_name,b.devote_id,b.state ,b.borrow_user_id ,
			u1.email as b_name
			from book b 
			left join user u on b.devote_id = u.id
			left join user u1 on b.borrow_user_id = u1.id	
		";
			$sql = $this->sql;
			$add_where = false;
			if ($action=="search" && $title != "" ){
				$sql = $sql . " where title like '%". $title ."%' ";
				$add_where = true ;
			}
			$this->get_user_id = $user_id ;
			if ($this->get_user_id){
				if ($add_where)
					$sql = $sql." and ";
				else 
					$sql = $sql." where ";
				$sql = $sql."devote_id = {$this->get_user_id}";
			}
			$this->sql = $sql;
			parent::__construct($this-> sql,$page,$title);
		}
		public function next(){
			$row = $this -> db -> fetch_row($this -> result);
			if ($row){
				$this -> id = $row[0] ;
				$this -> title = $row[1] ;
				$this -> devoter_name = $row[2] ;
				$this -> devote_id = $row[3];
				$this -> state = $row[4] ;
				$this -> borrow_user_id = $row[5] ;
				$this -> b_name = $row[5];
				return true;
			}else return false;
		}
		public function pager_str(){
			return getPaginationString(
				$this -> page, 
				$this->total_records, 
				$this -> pagerecords, 
				1,
				$_SERVER['PHP_SELF']."?user={$this->get_user_id}", 
				"&page=");
		}
	}
	login_required();
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
	$page = $_GET['page'];
	$get_user_id = $_GET['user'];
	$title = trim($_POST['title']);
	$p = new BookListPager($get_user_id,$page,$title,$action);
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
<h1>books/<?echo $p->total_records;?> </h1>

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
	// $result = $db -> query($sql);
	// if (mysql_num_rows($result) == 0) {die();}
	// while ($row = mysql_fetch_row($result)) {
	while($row = $p -> next()){
		// $curr_user_id = $_SESSION["user_id"];
		$url_e ="";
		$url_d ="";
		$url_borrow="";
		if (!$borrowed)
			$url_borrow = "<a class='' href='book_borrow.php?id=".$p->id."'>Borrow</a>&nbsp;" ;
		if ($devote_id == $curr_user_id){
			 $url_e = "<a  href='book_edit.php?id=".$p->id."'>Edit</a>&nbsp;" ;
			 $url_d = "<a  href='book_delete.php?id=".$p->id."'>Del</a>&nbsp;" ;
		
		}
		$bstr = get_state($state);
		$btn_group = "<div class=''>".$url_e. $url_d.$url_borrow."</div>" ;
		echo "<tr>" .
		 	  "<td>" . $btn_group. "</td>" . 
		 	  "<td>" . $p->id . "</td>" .
		 	  "<td>" . $p-> title. "</td>" .
		 	  "<td>" . $bstr . "</td>" .
		 	  "<td>" .abbr($p->devoter_name) . "</td>".
		 	  "<td>" . abbr($p-> b_name) . "</td>".
		 	  "<tr>";
	}
?>
</table>
<?	
	$target = $_SERVER['PHP_SELF'];
	echo $p -> pager_str();
?>
</div><!-- end #wrapper -->
</body>
</html>