<?php

require 'config.php';

header('Content-Type: text/plain;charset=UTF-8');

$url = isset($_GET['url']) ? urldecode(trim($_GET['url'])) : '';
$s = isset($_GET['s']) ? true : false;
$domain = "http://". $_SERVER['HTTP_HOST'] ."/";

if (in_array($url, array('', 'about:blank', 'undefined', 'http://localhost/'))) {
	die('Enter a URL.');
}

// If the URL is already a short URL on this domain, don’t re-shorten it
if (strpos($url, $domain) === 0) {
	die($url);
}

$db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
$db->set_charset('utf8mb4');

$url = $db->real_escape_string($url);

function randString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$result = $db->query('SELECT slug FROM redirect WHERE url = "' . $url . '" LIMIT 1');
if ($result && $result->num_rows > 0) { // If there’s already a short URL for this URL
	if ($s) {
		die($result->fetch_object()->slug);
	} else {
		die($domain . $result->fetch_object()->slug);
	}
} else {
	$slug = randString(5);
	$is_unique = false;

	while (!$is_unique) {
    	$result = $db->query('SELECT slug FROM redirect WHERE slug = "'. $slug .'" LIMIT 1');
    	if ($result->num_rows == 0) {   // if you don't get a result, then you're good
			$is_unique = true;
			if ($db->query('INSERT INTO redirect (slug, url, date, hits) VALUES ("' . $slug . '", "' . $url . '", NOW(), 0)')) {
				header('HTTP/1.1 201 Created');
				if ($s) {
					echo $slug;
				} else {
					echo $domain . $slug;
				}
				$db->query('OPTIMIZE TABLE `redirect`');
			}
		} else {                   // if you DO get a result, keep trying
        	$slug = randString(5);
		}
	}
}
?>
