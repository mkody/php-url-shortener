<?php

require 'config.php';

$url = DEFAULT_URL . '/';

if (isset($_GET['slug'])) {

	$slug = $_GET['slug'];

	$db = new MySQLi(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
	$db->set_charset('utf8mb4');

	if ('@' == $slug) {
		$url = 'https://twitter.com/' . TWITTER_USERNAME;
	} else if (' ' == $slug) { // +
		$url = 'https://plus.google.com/u/0/' . GOOGLE_PLUS_ID . '/posts';
	} else if ('ep' == substr($slug, 0, 2) && is_numeric(substr($slug, 3, 3))) { // episode at NLR
		$slug = substr($slug, 2);
		$db->query('UPDATE nlr SET hits = hits + 1 WHERE slug = "' . $slug . '"');
		$db->close();
		$url = 'http://www.newlunarrepublic.fr/episodes/'. $slug;
	} else if ($slug == "faq") {
		$url = FAQ_URL;
	} else {

		$slug = preg_replace('/[^a-z0-9]/si', '', $slug);

		if (is_numeric($slug) && strlen($slug) > 8) {
			$url = 'https://twitter.com/' . TWITTER_USERNAME . '/status/' . $slug;
		} else {

			$escapedSlug = $db->real_escape_string($slug);
			$redirectResult = $db->query('SELECT url FROM redirect WHERE slug = "' . $escapedSlug . '"');

			if ($redirectResult && $redirectResult->num_rows > 0) {
				$db->query('UPDATE redirect SET hits = hits + 1 WHERE slug = "' . $escapedSlug . '"');
				$url = $redirectResult->fetch_object()->url;
			} else {
				$url = DEFAULT_URL . $_SERVER['REQUEST_URI'];
			}

			$db->close();

		}
	}
}

header('Location: ' . $url, null, 301);

$attributeValue = htmlspecialchars($url);
?>
<meta http-equiv=refresh content="0;URL=<?php echo $attributeValue; ?>"><a href="<?php echo $attributeValue; ?>">Continue</a><script>location.href=<?php echo json_encode($url, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES); ?></script>
