<html>
<head>
	<title>bbm.up2run.com</title>
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
</head>
<body>
<div id="index">
	<h1>It works!</h1>
	<?	include "paginator.php";
		$target = $_SERVER['PHP_SELF'];
		echo getPaginationString(1, 20, 15, 1, $target, $pagestring = "?page=");
	?>
</div>
</body></html>


