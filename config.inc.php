<?
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
		$sql = "select email,id from user 
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
		echo '<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >';
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
	$cookie_name = 'siteAuth';
	$cookie_time = (3600 * 24 * 30); // 30 days
	if(!$_SESSION['user_name'] && isSet($cookie_name) && isSet($_COOKIE[$cookie_name]))
	{
		parse_str($_COOKIE[$cookie_name]);
		login_verify_ok($usr,$hash);
	}
	class Dbe extends Exception{}
	class DB {
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
			return $this->db_check(mysql_query($sql));
		}
		public function query_array ($sql,$column){
			$result = $this->db_check(mysql_query($sql));
			$arr = Array();
			while($row = $this -> fetch_row($result)){
				array_push($arr,$row[$column]);
			}
			return $arr ;
		}
		public function num_rows($result){
			return $this->db_check(mysql_num_rows($result));
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
					where state =2 and devote_id =${uid} and borrow_user_id is not null
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
					where state =2 and devote_id =${uid}"; 
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
					select borrow_user_id,GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email
					from book b
					left join user u on b.borrow_user_id = u.id 
					where state =2 and devote_id =${uid} and borrow_user_id is not null
					group by borrow_user_id
				";
				$d = new DB();
				$result = $d -> query($sql);
				$subject = "Your apply for book is approved ";
				$from = $user_name ;
				while ($row = $d -> fetch_row($result)){
					$message = $row[1] ;
					$to = $row[2];
					$this -> log->warn("approved_all:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
				}
				$sql = "update book set state = 3 where state =2 and devote_id =${uid}"; 
				$result = $d -> query($sql);
			}catch(Exception $e){
				$this -> log -> warn("${e}");
			}
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
					select borrow_user_id,GROUP_CONCAT(b.title SEPARATOR ',' ) ,u.email
					from book b
					left join user u on b.borrow_user_id = u.id 
					where 
					state =2 and devote_id =${uid} and borrow_user_id is not null
					and b.id in ($id_list)
					group by borrow_user_id
				";
				$result = $d -> query($sql);
				while ($row = $d -> fetch_row($result)){
					$message = $row[1] ;
					$to = $row[2];
					$this -> log->warn("approved:${to},${message},from ${from}");
					$this -> send_mail($to,$message,$from,$subject);
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
					state =2 and devote_id =${uid} and borrow_user_id is not null
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
		function return_($selected,$uid){
			$this -> log -> warn ("{$selected}");
			$id_list = implode(",",$selected);
			$d = new DB;
			try{
				// update state = return confirm
				$sql = "update book set state = 4  
					where id in(${id_list}) and state =3 and borrow_user_id =${uid}";
				$result = $d -> query($sql);
			}catch(Exception $e){
				$this -> log -> warn("${e}");
				$this -> log -> warn($sql);
			}
		}
		function return_all($uid){
			try{
				// 4 - return 
				$sql = "update book set state = 4 where state =3 and borrow_user_id =${uid}";
				$db = new DB();
				$result = $db -> query($sql);
				header("Location: book_return_confirm.php");
			}catch(Exception $e){
				$log = new Log();
				$log -> warn($e);
			}
		}
		private function send_mail($to,$message,$from,$subject){
			$headers = "From: $from";
			mail($to,$subject,$message,$headers);
		}
	}
?>