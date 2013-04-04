<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
		<a class="brand" href="#">互助借书</a>
		<ul class="nav">
		<li ><a href="/book_list.php">book</a></li>
		<li ><a href="/user_list.php">user</a></li>
		<? if (!is_login()){ ?>
			<li><a href="/login.php" >Login</a></li>
		<?}else{?>
			<li><a href="/logout.php">Logout</a></li>
			<p class="navbar-text pull-right">
            	<a href="#" class="navbar-link"><? echo $_SESSION['user_name']?></a>
            	<a href="#" class="navbar-link"><? echo $_SESSION['user_id']?></a>
        	</p>
		<?}?>
		</ul>
    </div>
  </div>
</div>