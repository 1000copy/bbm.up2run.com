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
		$DB  = new DB();
		$link = $DB ->connect($hostname, $username, $password);
		$dbcheck = $DB->select("$database");
    	$DB->query("set names utf8;");
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
			return $this->db_check(mysql_fetch_row($result));
		}
		function db_check($r){
			if (!$r)
				throw new Dbe(mysql_error());
			return $r;
		}
	}
?>