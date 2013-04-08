
<h1>MySQL connection test</h1>

<?
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
	$hostname = '127.0.0.1';
	$username = 'root';
	$password = '';
	$database = 'bb';
	try{
		$db = new DB();
		$link = $db ->connect($hostname, $username, $password);
		$sql = "SHOW TABLES FROM `$database`";
		$result = $db->query($sql);
		if ($db->num_rows($result) > 0) {
			echo "<p>Available tables:</p>\n";
			echo "<pre>\n";
			while ($row = $db->fetch_row($result)) {
				echo "{$row[0]}\n";
			}
			echo "</pre>\n";
		}
	}catch (Dbe $e){
		echo $e->getMessage();
	}
	
?>
