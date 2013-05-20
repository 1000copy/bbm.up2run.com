<?
	include_once "paginator.php";
	// error_reporting(E_ALL ^ E_NOTICE);
	// header('Cache-control: private'); // IE 6 FIX
	// // always modified 
	// header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT'); 
	// // HTTP/1.1 
	// header('Cache-Control: no-store, no-cache, must-revalidate'); 
	// header('Cache-Control: post-check=0, pre-check=0', false); 
	// // HTTP/1.0 
	// header('Pragma: no-cache');
	$hostname ="127.0.0.1";
	$username = "root";
	$password = "";
	$database = "bb";
	$ddd = NULL;
	$link = mysql_connect("$hostname", "$username", "$password");
	if (!$link) {
		echo "<p>Could not connect to the server '" . $hostname . "'</p>\n";
    	echo mysql_error();
	}
	if ($database) {
    	$dbcheck = mysql_select_db("$database");
    	mysql_query("set names utf8;");
		if (!$dbcheck) {
        	echo mysql_error();
		}
	}
	try{
		$ddd  = new DB();
		
    }catch(Dbe $e){
    	echo $e->getMessage();
    }
	function db_query($sql){
		return mysql_query($sql);
	}
	// return int : row count
	function db_row_count( $ds ){
		return mysql_num_rows($ds);
	}
	// return row
	function db_fetch_row( $ds ){
		return mysql_fetch_row($ds);
	}
	function is_login(){
		return isset($_SESSION["user_name"]);  
	}
	// autologin
	function login_verify_ok($usr,$password_hash){
		// echo $usr.$password_hash;
		$sql = "select email,id ,fullname from user 
			where email='${usr}' and password = '${password_hash}'";
		$result = db_query ($sql);
		// echo $sql ;
		if (!$result || db_row_count($result) == 0 ){
			// echo "nono";
			return false;
		}
		{
			// echo "yes";
			$row = db_fetch_row($result);
			$_SESSION['user_id'] = $row[1];
			$_SESSION['user_name'] = $row[0];
			$_SESSION['email'] = $row[0];
			$_SESSION['fullname'] = $row[2];
			return true ;
		}
	}
	function login_required(){
		if(!isSet($_SESSION['user_name']))
		{
			header("Location: login.php");
			exit;
		}
	}
	function bs_here(){
		echo '
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >
			<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
			<link type="text/css" REL="StyleSheet" href="wrapper.css"/>
		'
		;
	}
	function abbr($s){
		$r = substr($s,0,6).'...';
		if ($r=='...')return '';
		return $r;
		// return $s;
	}
	function get_state($state){
		switch ($state)
		{
		case 0:
		  return 'normal';
		case 1:
		  return 'incart';
		case 2:
		  return 'commit';
		case 3:
		  return 'accept';
		case 4:
		  return 'return commit';
		default:
		  return 'error state';
		}
	}
	class Dbe extends Exception{}
	class DB {
		var $result ;
		function _construct(){
			$link = $this -> connect($hostname, $username, $password);
			$dbcheck = $this ->select("$database");
	    	$this->query("set names utf8;");
		}
		public function connect($hostname, $username, $password){
			return $this->db_check( mysql_connect($hostname, $username, $password));
		}
		public function select($db){
			return $this->db_check(mysql_select_db($db));
		}
		public function query ($sql){
			$log = new Log;
			$log -> warn($sql);
			$this->result = $this->db_check(mysql_query($sql));
			return $this -> result;
		}
		public function query_array ($sql,$column){
			$log = new Log;
			$log -> warn($sql);
			$result = $this->db_check(mysql_query($sql));
			$arr = Array();
			while($row = $this -> fetch_row($result)){
				array_push($arr,$row[$column]);
			}
			return $arr ;
		}
		public function query_1_1 ($sql){
			$arr = $this->query_array($sql,0);
			return $arr[0] ;
		}
		public function num_rows($result){
			return $this->db_check(mysql_num_rows($result));
		}
		public function is_empty($result){
			return $this -> num_rows($result) == 0 ;
		}
		
		public function fetch_row($result){
			return mysql_fetch_row($result);
		}
		function db_check($r){
			if (!$r)
				throw new Exception(mysql_error());
			return $r;
		}
	}
	// date_default_timezone_set('UTC');
	date_default_timezone_set('Asia/Chongqing');
	include_once 'KLogger.php';
	class Log{
		var $file ;
		var $_log ;
		public function Log(){
			$this -> file = $_SERVER['DOCUMENT_ROOT']."/test/log1.txt";
			// echo $this -> file ;
			$this -> _log= new Logger($this -> file);
			// var_dump($this -> _log);
		}
		public function warn($msg){
			// echo "abc";
			// var_dump($this -> _log);
			$this-> _log -> log($msg,Logger::WARNING);
		}
		public function notice($msg){
			// echo "abc";
			// var_dump($this -> _log);
			$this-> _log -> log($msg,Logger::NOTICE);
		}
		public function error($msg){
			// echo "abc";
			// var_dump($this -> _log);
			$this-> _log -> log($msg,Logger::ERROR);
		}
		public function fatal($msg){
			// echo "abc";
			// var_dump($this -> _log);
			$this-> _log -> log($msg,Logger::FATAL);
		}
	}
	class Book {
		private $log ;
		function __construct(){
			$this -> log = new Log();
		}
		// depreciated
		function commit($user_id){
			try{
				// set to commit state
				$sql = "update book set state = 2 where borrow_user_id='${user_id}' and state=1";
				$d = new DB();
				$result = $d->query($sql);
				$sql = "select b.devote_id , GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email
					from book b left join user u on b.devote_id = u.id 
					where state = 2 and borrow_user_id =${user_id} 
					group by b.devote_id";
				$result = $d->query($sql);
				$from =  $_SESSION['user_name'];
				while ($row = $d->fetch_row($result)){
					$email = $row[2];
					$books = $row[1];
					$this -> send_mail($email,$books,$from,"borrow book notifycation");
					$this -> log -> warn("send apply mail: ${books} to ${email} from ${from} ");
				}
			}catch (Exception $e ){$this -> log -> warn($e->getMessage());}

		}
		function reject_all($uid,$from){
			$log = new Log();
			$d = new DB();
			try{
				$subject = "Your apply for book is rejected ";
				$sql = "
					select borrow_user_id,GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email
					from book b
					left join user u on b.borrow_user_id = u.id 
					where state =1 and devote_id =${uid} and borrow_user_id is not null
					group by borrow_user_id
				";
				$result = $d -> query($sql);
				while ($row = $d -> fetch_row($result)){
					$message = $row[1] ;
					$to = $row[2];
					$log->warn("reject:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
				}
				$sql = "update book set state = 0 , borrow_user_id=null 
					where state = 1 and devote_id =${uid}"; 
				$log->warn("reject:${to},${message},from ${from}");
				$result = $d -> query($sql);
			}catch (Exception $e ){
				$this -> log -> warn("${e}");
				// why it(-> getMessage ) does not work ?
				// $this -> log -> warn($e->getMessage());
			}
		}
		function approve_all($uid,$user_name){
			try{
				// GROUP_CONCAT 后多一个空格，然后，调试了半小时！ shit could not be worse
				$sql = "
					select borrow_user_id,GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email,
					GROUP_CONCAT(b.id SEPARATOR ',' )
					from book b
					left join user u on b.borrow_user_id = u.id 
					where state = 1 and devote_id =${uid} and borrow_user_id is not null
					group by borrow_user_id
				";
				$d = new DB();
				$result = $d -> query($sql);
				$subject = "Your apply for book is approved ";
				$from = $user_name ;
				while ($row = $d -> fetch_row($result)){
					// mail 
					$message = $row[1] ;
					$to = $row[2];
					$this -> log->warn("approved_all:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
					// log
					$book_ids= $row[3];
					$arr_of_book_id = explode(",",$book_ids);
					$borrow_user_id = $row[0];
					$this->log__($uid,$borrow_user_id,$arr_of_book_id);
				}
				// update book state 
				$sql = "update book set state = 3 where state = 1 and devote_id =${uid}"; 
				$result = $d -> query($sql);
				
			}catch(Exception $e){
				$this -> log -> warn("${e}");
			}
		}
		function log__($devote_user_id,$borrow_user_id,$arr_of_book_id){
			$d = new DB;
			$log = new Log;
			$log->warn("books:{$arr_of_book_id}");
			try{
				$w = getdate();
				$sql = "
					insert into borrow (devote_user_id,borrow_user_id,w)
					values({$devote_user_id},{$borrow_user_id},now())";
				$d -> query($sql);
				$sql = "SELECT LAST_INSERT_ID()";
				$last_insert_id = $d -> query_1_1($sql);
				foreach ($arr_of_book_id as &$book_id) {
					$sql = "
						insert into borrow_detail(borrow_id,book_id)
						values({$last_insert_id},{$book_id})";
					$d -> query($sql);
				}
			}catch(Exception $e){$log = new Log;$log->warn("{$e}");}
		}
		function return_confirm($selected,$user_id){
			$this -> log -> warn ("{$selected}");
			$id_list = implode(",",$selected);
			$d = new DB();
			try{
				$sql = "
					select borrow_user_id,GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email,
					GROUP_CONCAT(b.id SEPARATOR ',' )
					from book b
					left join user u on b.borrow_user_id = u.id 
					where 
					state = 3 and 
					b.id in ('${id_list}') and 
					devote_id =${user_id} and 
					borrow_user_id is not null
					group by borrow_user_id
				";
				
				$result = $d -> query($sql);
				$subject = "Your return for book is confirmed";
				$from = $user_name ;
				while ($row = $d -> fetch_row($result)){
					// mail 
					$message = $row[1] ;
					$to = $row[2];
					$this -> log->warn("return_confirm_all:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
					// log
					$book_ids= $row[3];
					$arr_of_book_id = $selected;
					$borrow_user_id = $row[0];
					$this->log_return($user_id,$borrow_user_id,$arr_of_book_id);
				}
				//
				$sql = "update book set state = 0 ,borrow_user_id = null 
						where state = 3 and devote_id ='${user_id}'";
				$result = $d -> query($sql);
			}catch(Exception $e ){$l = new Log;$l->warn("$e");}
		}
		function return_confirm_all($user_id){
			$d = new DB();
			try{
				$sql = "
					select borrow_user_id,GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email,
					GROUP_CONCAT(b.id SEPARATOR ',' )
					from book b
					left join user u on b.borrow_user_id = u.id 
					where state = 3 and devote_id =${user_id} and borrow_user_id is not null
					group by borrow_user_id
				";
				
				$result = $d -> query($sql);
				$subject = "Your return for book is confirmed";
				$from = $user_name ;
				while ($row = $d -> fetch_row($result)){
					// mail 
					$message = $row[1] ;
					$to = $row[2];
					$this -> log->warn("return_confirm_all:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
					// log
					$book_ids= $row[3];
					$arr_of_book_id = explode(",",$book_ids);
					$borrow_user_id = $row[0];
					$this->log_return($user_id,$borrow_user_id,$arr_of_book_id);
				}
				//
				$sql = "update book set state = 0 ,borrow_user_id = null 
			where state = 3 and devote_id ='${user_id}'";//2==commit
				$result = $d -> query($sql);
			}catch(Exception $e ){$l = new Log;$l-warn("$e");}
		}
		function log_return($devote_user_id,$borrow_user_id,$arr_of_book_id){
			$d = new DB;
			$log = new Log;
			$log->warn("books:{$arr_of_book_id}");
			try{
				$sql = "
					insert into borrow (devote_user_id,borrow_user_id,is_return,w)
					values({$devote_user_id},{$borrow_user_id},1,now())";
				$d -> query($sql);
				$sql = "SELECT LAST_INSERT_ID()";
				$last_insert_id = $d -> query_1_1($sql);
				foreach ($arr_of_book_id as &$book_id) {
					$sql = "
						insert into borrow_detail(borrow_id,book_id)
						values({$last_insert_id},{$book_id})";
					$d -> query($sql);
				}
			}catch(Exception $e){$log = new Log;$log->warn("{$e}");$log -> warn($sql);}
		}
		/// $selected == array of [book id]
		function approve($selected,$uid){
			$id_list = implode(",",$selected);
			$d = new DB;
			try{
				// mail to borrowers
				$from = $_SESSION["user_name"];
				$subject = "Your apply for book is approved(partly) ";
				$sql = "
					select borrow_user_id,GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email,
					GROUP_CONCAT(b.id SEPARATOR ',' ) 
					from book b
					left join user u on b.borrow_user_id = u.id 
					where 
					state = 1 and devote_id =${uid} and borrow_user_id is not null
					and b.id in ($id_list)
					group by borrow_user_id
				";
				$result = $d -> query($sql);
				while ($row = $d -> fetch_row($result)){
					$message = $row[1] ;
					$to = $row[2];
					$this -> log->warn("approved:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
					// log
					$book_ids= $row[3];
					$arr_of_book_id = explode(",",$book_ids);
					$borrow_user_id = $row[0];
					$this->log__($uid,$borrow_user_id,$arr_of_book_id);
				}
				// update state = 3 
				$sql = "update book set state = 3 where id in(${id_list})";
				$result = $d -> query($sql);
				
			}catch(Exception $e){
				$this -> log -> warn("${e}");
			}
		}
		function log_data($uid){
			$d = new DB;
			try{
				// mail to borrowers
				$sql = "
					select borrow_user_id,u.email as b_email,u1.email as d_email,
					 GROUP_CONCAT(b.title SEPARATOR ',' ) ,
					from borrow b
					left join user u on b.borrow_user_id = u.id 
					left join user u1 on b.devote_user_id = u.id 
					left join borrow_detail bd on b.id = bd.borrow_id
					
					group by borrow.id
				";
				$result = $d -> query($sql);
				while ($row = $d -> fetch_row($result)){
					$message = $row[1] ;
					$to = $row[2];
					$this -> log->warn("approved:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
					// log
					$book_ids= $row[3];
					$arr_of_book_id = explode(",",$book_ids);
					$borrow_user_id = $row[0];
					$this->log__($uid,$borrow_user_id,$arr_of_book_id);
				}
				// update state = 3 
				$sql = "update book set state = 3 where id in(${id_list})";
				$result = $d -> query($sql);
				
			}catch(Exception $e){
				$this -> log -> warn("${e}");
			}
		}
		function reject($selected,$uid){
			$id_list = implode(",",$selected);
			$d = new DB;
			try{
				// mail to borrowers
				$from = $_SESSION["user_name"];
				$subject = "Your apply for book is approved(partly) ";
				$sql = "
					select borrow_user_id,GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email
					from book b
					left join user u on b.borrow_user_id = u.id 
					where 
					state = 1 and devote_id =${uid} and borrow_user_id is not null
					and b.id in ($id_list)
					group by borrow_user_id
				";
				$result = $d -> query($sql);
				while ($row = $d -> fetch_row($result)){
					$message = $row[1] ;
					$to = $row[2];
					$this -> log->warn("rejected:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
				}
				// update state = normal
				$sql = "update book set state = 0 , borrow_user_id =null where id in(${id_list})";
				$result = $d -> query($sql);
				
			}catch(Exception $e){
				$this -> log -> warn("${e}");
			}
		}
		private function send_mail($to,$message,$from,$subject){
			if ($this->is_notify($to)){
				$headers = "From: $from";
				mail($to,$subject,$message,$headers);
			}
		}
		private function is_notify($to){
			$d = new DB;
			$notify = $d->query_1_1("select notify from user where email ='${to}'");
			return $notify == 1;
		}
	}


	class Pager{
		public $total_records;
		public $result ;
		public $db ;
		public $count_sql;
		private $sql;
		public $page;
		public $pagerecords;
		function __construct($sql,$page,$title){
			$this -> db = $db = new DB;
			try{
				if (!$page)
					$page = 1;
				$this -> page = $page ;
				$this->pagerecords = 10 ;
				$from = ($page-1)*$this->pagerecords;
				$to = $this->pagerecords;
				//
				if($title != "")
					$sql = $sql . " and title like '%". $title ."%' ";
				$this -> count_sql = "select count(1) from (${sql}) balias";
				$this -> sql = $sql . " limit ${from},${to} ";
				// echo $sql;
				// echo $count_sql;
				$this -> total_records = $db -> query_1_1 ($this -> count_sql);
				$this -> result = $db -> query($this -> sql);
			}catch(Exception $e){
				$log = new Log();
				$log -> warn("${e}");
				$log -> warn($this -> count_sql);
				$log -> warn($this -> sql);
			}
		}
		public function pager_str(){
			return getPaginationString(
				$this -> page, 
				$this->total_records, 
				$this -> pagerecords, 
				1,
				$_SERVER['PHP_SELF'], 
				"?page=");
		}
	}
	class ReturnCartPager extends Pager{
		private $sql ;
		public $id ;
		public $title ;
		public $email ;
		public $devote_id ;
		public $state ;
		
		public function __construct($user_id,$page,$title){
			$this -> sql = "
			select b.id ,b.title ,u.email,b.devote_id,b.state ,u1.email as borrow_email
			from book b 
			left join user u on b.devote_id = u.id 
			left join user u1 on b.borrow_user_id = u1.id 
			where u1.id = ${user_id} and state= 3 
		";
			parent::__construct($this-> sql,$page,$title);
		}
		public function next(){
			$row = $this -> db -> fetch_row($this -> result);
			if ($row){
				$this -> id = $row[0] ;
				$this -> title = $row[1] ;
				$this -> email = $row[2] ;
				$this -> devote_id = $row[3];
				$this -> state = $row[4] ;
				return $row;
			}else return false;
		}

	}
	$cookie_name = 'siteAuth';
	$cookie_time = (3600 * 24 * 30); // 30 days
	function try_autologin(){
		$log = new Log ;
		$log -> warn("cookie verify begin");
		if(!$_SESSION['user_name'] && isSet($cookie_name) && isSet($_COOKIE[$cookie_name]))
		{
			parse_str($_COOKIE[$cookie_name]);
			$log -> warn("cookie verify $usr ,$hash");
			login_verify_ok($usr,$hash);
		}
	}
	try_autologin();
	
?>