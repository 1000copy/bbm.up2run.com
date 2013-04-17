<?
	$path = "pato/to/not/exists/file";
	echo "<br/>verbose by warning";
	echo "<br/>";
	echo "<br/>";
	// $fh = fopen($path, 'r') or die('Could not open file');  
	$fh = fopen($path, 'r') ;
	echo "<br/>";
	echo "<br/>";
	echo "<br/>no warning by @ operator";
	$fh = @fopen($path, 'r') ;
	echo "<br/>";
	echo "<br/>";
	echo "<br/>detail error";
	print_r(error_get_last());
	echo "<br/>";
	echo "<br/>";
	echo "<br/>detail error msg ";
	$arr = error_get_last();
	echo($arr['message']);
	echo "<br/>";
	echo "<br/>";
	
?>
<p>
Q: 
I'm using fopen to read from a file

$fh = fopen($path, 'r') or die('Could not open file');
Now I contantly get error Could not open file. 
I checked the file path and even changed the permissions of the file to 777. 
Is there a way I can get a detailed error report as why the file 
can't be opened similar to mysql_error()?

A: 

Turn on error reporting, or, in a production environment (from PHP 5.2.0 onwards)
 you should also be able to use error_get_last().


Q: what does it means: @ in front of function ?
A: Role of "@" is to ignore the function is called the error message.

</p>