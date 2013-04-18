<?
date_default_timezone_set('UTC');
?>
<?php
	include_once '../KLogger.php';
	class Log{
		var $file ;
		var $_log ;
		public function Log(){
			
			$this -> file = $_SERVER['DOCUMENT_ROOT']."/test/log1.txt";
			echo $this -> file ;
			$this -> _log= new Logger($this -> file);
			// var_dump($this -> _log);
		}
		// $log->log('Example Notice',Logger::NOTICE);
		// $log->log('Example Warning',Logger::WARNING);
		// $log->log('Example Error',Logger::ERROR);
		// $log->log('Example Fatal',Logger::FATAL);
		// $log->log('要了老命',Logger::FATAL);		
		function warn($msg){
			// echo "abc";
			// var_dump($this -> _log);
			$this-> _log -> log($msg,Logger::WARNING);
		}
	}
	// echo $_SERVER['DOCUMENT_ROOT'];
	// $file = "/Users/lcjun/bbm.up2run.com/test/log.txt";
	$file = $_SERVER['DOCUMENT_ROOT']."/test/log1.txt";
	// echo $_SERVER['PHP_SELF'];
	// echo $_SERVER['PATH_INFO'];
	// echo "<br/>";
	// $file = $_SERVER['PHP_SELF']."/test/log.txt";
	// $file = "/test/log.txt";
	// echo $file ;
	// echo "<br/>";
	// var_dump(is_file($file));
	// echo get_current_user();
	// $log=new Logger($file);
	// $file = "/test/log.txt/not/exists";
	// $log=new Logger($file);
	// try{
	// 	$log->log('Example Notice',Logger::NOTICE);
	// 	$log->log('Example Warning',Logger::WARNING);
	// 	$log->log('Example Error',Logger::ERROR);
	// 	$log->log('Example Fatal',Logger::FATAL);
	// 	$log->log('要了老命',Logger::FATAL);		
	// }
	// catch(Exception $e){
	// 	echo $e->getMessage();
	// }
	$log = new Log();
	$log -> warn("some thing by oo0");
	$log -> warn("some thing by oo1");
	$log -> warn("some thing by oo2");
	// 5.5 才支持
	// finally{ 
	// 	echo "unset";
	// 	unset($log);
	// }

?>