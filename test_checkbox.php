<?
  $action = $_GET['action'];
  if ($action='r'){
  	$box = $_POST['box'];
  	print_r($box);
  }
?>
<!-- 
	checkbox 的数组用法
	1. 所有 checkbox 命名name = identity[] ;就是名字后加入[]
	2. php 可以用 $box = $_POST['box']; 取出数组，内容为checked的values的集合。
	   比如 check value=1 checked /check value=2  /check value=3 checked/ 那么得到的数组就是0=>1 1=>3
	3. 可以用in_array 判断是否一个value在数组内
 -->
<form method="post" action="<? echo $_SERVER['PHP_SELF']; ?>?action=r" >
    <input type="checkbox" name="box[]" value='0'
    	<?php if (in_array(0,$box)) echo "checked"; ?>><br>
    <input type="checkbox" name="box[]" value='1'
    	<?php if (in_array(1,$box)) echo "checked"; ?>><br>
    <input type="checkbox" name="box[]" value='2'
    	<?php if (in_array(2,$box)) echo "checked"; ?>><br>
    <p>
    <input type="submit" value="Submit">
</form>