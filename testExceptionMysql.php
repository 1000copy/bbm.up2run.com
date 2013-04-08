
<h1>MySQL connection test</h1>

<?
	include "config.inc.php";
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
