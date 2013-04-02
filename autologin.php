<?php
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
			$_SESSION['user_name'] = $usr;
		}
	}
}
?>