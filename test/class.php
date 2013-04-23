<?
  class Abc{
  	public $def ;
  	public function  __construct(){
  		$this -> def = "icarus";
  	}
  }
  $a = new Abc;
  echo $a-> def ;
  $b ="icarus-b";
?>
<p> 
	<!-- 对象内的成员要嵌入字符串，需要用{}定界 -->
	<?echo "var value is {$a-> def}"?>
	<!-- 简单变量，看起来{}的位置可以比较灵活 -->
	<br/>
	<?echo "delemiter 1 {$b}"?>
	<br/>
	<?echo "delimiter 2 ${b}"?>
	<!-- 更加详细的信息： http://php.net/manual/zh/language.types.string.php -->
</p>