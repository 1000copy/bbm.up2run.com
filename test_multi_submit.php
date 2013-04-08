<?php
switch ($_POST['calculate']) {
	case 'add':
	    echo $_POST['number_1'] . " + " . $_POST['number_2'] . " = " . ($_POST['number_1']+$_POST['number_2']);
	    break;
	case 'subtract':
	    echo $_POST['number_1'] . " - " . $_POST['number_2'] . " = " . ($_POST['number_1']-$_POST['number_2']);
	    break;
	case 'multiply':
	    echo $_POST['number_1'] . " x " . $_POST['number_2'] . " = " . ($_POST['number_1']*$_POST['number_2']);
	    break;
}

?>
<html><head>Multi-button from with switch/case</head>
<body>

<form action="test_multi_submit.php" method="post"> 
Enter a number: <input type="text" name="number_1" size="3" value="10"> <br> 
Enter another number: <input type="text" name="number_2" size="3" value="2"> <br> 
<input type="submit" name="calculate" value="add"> 
<input type="submit" name="calculate" value="subtract"> 
<input type="submit" name="calculate" value="multiply"> 
</form>

</body>
</html>