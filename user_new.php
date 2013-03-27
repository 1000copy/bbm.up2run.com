<? session_start()?>
<?php
	include "config.inc.php";
	$action = htmlspecialchars($_GET['action'], ENT_QUOTES);
	// echo $action;
	if ($action == "new"){
		$fullname = $_POST['inputEmail'];
		$password = $_POST['inputPassword'];
		$md5 = md5($password);
		if ($md5){
			$sql ="insert into user (fullname,password)values('${fullname}','${md5}')";
			$result = db_query($sql);
			if (!$result )
				die(mysql_error());
			else
				header("Location:/book_list.php");
		}else
			die("不能生成md5");
	}
?>
<html >
<head>
	<title>books</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<LINK REL="StyleSheet" HREF="paginator.css" TYPE="text/css" >
	<LINK REL="StyleSheet" HREF="bootstrap/css/bootstrap.min.css" TYPE="text/css" >
	<style type="text/css">
	#wrapper {
		width: 600px;
		padding-top: 100px;
		margin: 20px auto 0;
		font: 1.2em Verdana, Arial, sans-serif;
	}
	</style>
	<script type="text/javascript">
	function isEmail(email,msg) {
	  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  var answer = regex.test(email);
	  if (!answer)
	  	alert(msg);
	  return answer;
	}
	function isPassword(p,msg){
		var answer = false;
		answer = p.length != 0;
		if (!answer)
			alert(msg);
		return answer;
	}
	function check(){
	  	var a = document.forms[0].elements['inputEmail'].value;
	  	var p = document.forms[0].elements['inputPassword'].value;
		return isEmail(a,'请输入email') && isPassword(p,'请输入密码');
	}
	</script>
</head>
<body>
<div id="wrapper">

<h1>user new </h1>

<form class="form-horizontal" 
	onsubmit="return check();" 
	action="<?php echo $_SERVER['PHP_SELF']; ?>?action=new"  method="post" >
  <form class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" name="inputEmail" placeholder="Email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" name="inputPassword" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn">Create</button>
    </div>
  </div>
</form>
</div><!-- end #wrapper -->
</body>
</html>