<?
date_default_timezone_set('UTC');
?>
<?php
	include_once '../KLogger.php';
	// echo $_SERVER['DOCUMENT_ROOT'];
	// $file = "/Users/lcjun/bbm.up2run.com/test/log.txt";
	// $file = $_SERVER['DOCUMENT_ROOT']."/test/log.txt";
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
	$file = "/test/log.txt/not/exists";
	$log=new Logger($file);
	try{
		$log->log('Example Notice',Logger::NOTICE);
		$log->log('Example Warning',Logger::WARNING);
		$log->log('Example Error',Logger::ERROR);
		$log->log('Example Fatal',Logger::FATAL);
		$log->log('要了老命',Logger::FATAL);		
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
	// 5.5 才支持
	// finally{ 
	// 	echo "unset";
	// 	unset($log);
	// }

?>