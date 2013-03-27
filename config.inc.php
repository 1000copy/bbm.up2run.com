<?
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
		// $sql = "SHOW TABLES FROM `$database`";
		// 	$result = mysql_query($sql);
		// 	if (mysql_num_rows($result) > 0) {
		// 		echo "<p>Available tables:</p>\n";
		// 		echo "<pre>\n";
		// 		while ($row = mysql_fetch_row($result)) {
		// 			echo "{$row[0]}\n";
		// 		}
		// 		echo "</pre>\n";
		// 	} else {
		// 		echo "<p>The database '" . $database . "' contains no tables.</p>\n";
		// 		echo mysql_error();
		// 	}
	// return result
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
?>