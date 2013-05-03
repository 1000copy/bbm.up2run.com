<?
	session_start(); 
?>
<? 
include "config.inc.php" ;
?>
<?php
	$user_id = $_SESSION['user_id'];
	// echo $user_id;
	if (!$user_id)
		die("没有登录，不能上传");
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
	if ($action){
		define ('SITE_ROOT', realpath(dirname(__FILE__)));
		$src = $_FILES["file"]["tmp_name"];
		$dst_dir = SITE_ROOT."/upload/";
	    $dst =  $dst_dir . $_FILES["file"]["name"];
		if( !is_dir($dst_dir)) 
	    {
	        die("上传目录 ".$dst_dir." 不存在");
	    }
		if( !is_writeable($dst_dir) )
	    {
	        die("上传目录 ".$dst_dir." 无法写入");
	    }
	  
		if ($_FILES["file"]["error"] > 0)
		{
		  $error =  $_FILES["file"]["error"] ;
		  switch($error)
            {
                case 1 : die("上传文件大小超出 php.ini:upload_max_filesize 限制<br>");
                case 2 : die("上传文件大小超出 MAX_FILE_SIZE 限制<br>");
                case 3 : die("文件仅被部分上传<br>");
                case 4 : die("没有文件被上传<br>");
                case 5 : die("找不到临时文件夹<br>");
                case 6 : die("文件写入失败<br>");
            }
		}
		else
		{
			function fileext($filename)
			{
			    return substr(strrchr($filename, '.'), 1);
			}
			/* 设置允许上传文件的类型 */
			$type=array("csv","txt");
			if( !in_array( strtolower( fileext($dst) ),$type) )
			{
			    $text=implode(",",$type);
			    echo "只能上传以下类型文件: ",$text,"<br>";
			}
			move_uploaded_file($src,$dst);
			$file = fopen($dst,'r');
			while(!feof($file)) { 
				$line = trim(fgets($file));
				if (!empty($line)){
					$sql = "insert into book (title,devote_id)values('${line}',${user_id})";
					$result = mysql_query($sql);
					if (!$result){
						echo mysql_error();
					}
				}
			}
			fclose($file);
			unlink($dst);
			header("Location:/book_list.php");
			exit;

		}
	}
?>
<html >
<head>
	<title>books</title>
	<? bs_here();?>
</head>
<body>
	<? include "banner.php" ;?>
	<!-- <div id="wrapper"> -->
		<h1>books upload</h1>
		<p>
		<ol>
		<li> 文件请以csv为扩展名
		<li> 每行一本书的书名
		</ol>
		就像这样：
		<pre>
		-----文件开始
		uml distilled
		uml精粹
		-----文件结束
		</pre>
		<form 
			action="<?php echo $_SERVER['PHP_SELF']; ?>?action=upload"  
			method="post"
			enctype="multipart/form-data">
			<input type="hidden" name="max_file_size" value="3554432">
			<label for="file">File:</label>
			<input type="file" name="file" id="file" placeholder="some csv file..."><br>
			<input type="submit" name="submit" value="Submit">
		</form>
	<!-- </div> -->
</body>
</html>