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
		$result = db_query ("select fullname,id from user where fullname='${fullname}' and password = '${password_hash}'");
		if (!$result ||db_row_count($result) >0 ){
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
	$cookie_name = 'siteAuth';
	$cookie_time = (3600 * 24 * 30); // 30 days
	if(!$_SESSION['user_name'])
	{
		include_once 'autologin.php';
	}
?>