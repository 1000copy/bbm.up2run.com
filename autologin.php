<?php
// 这里的循环include 害死人啊。
// include "config.inc.php";
if(isSet($cookie_name))
{
	// Check if the cookie exists
	if(isSet($_COOKIE[$cookie_name]))
	{

		parse_str($_COOKIE[$cookie_name]);
		if (login_verify_ok($usr,$hash))
		{
			// Register the session
			// echo $usr ;
			// $_SESSION['user_name'] = $usr;

			// $_SESSION['user_id'] = get_userid_by_email($usr);
		}
	}
}
?>