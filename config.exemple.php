<?php

define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'short');
define('MYSQL_PASSWORD', 'password');
define('MYSQL_DATABASE', 'short');
define('TWITTER_USERNAME', 'Twitter');
define('GOOGLE_PLUS_ID', '+Google');
define('SLUG_SIZE', 5); // The lenght of your slug
if($_SERVER['HTTP_HOST'] == "nlr.pw") {
    define('DEFAULT_URL', 'https://www.newlunarrepublic.fr'); // omit the trailing slash!
	define('FAQ_URL', 'https://www.newlunarrepublic.fr/faq.php');
} else {
    define('DEFAULT_URL', 'https://www.radiobrony.fr'); // omit the trailing slash!
	define('FAQ_URL', 'https://www.radiobrony.fr/faq.php');
}
?>
