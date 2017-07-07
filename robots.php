<?php
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	
	echo "Sitemap: http://" . $_SERVER['SERVER_NAME'] . "/sitemap.php" . "\r\n";
	
	if (strpos($url,'.stealthinteractive.net') !== false) {
		#dev site
		echo 'User-agent: *' . "\r\n";
		echo 'Disallow: /';
	} else {
		#live site
		echo 'User-agent: *' . "\r\n";
		echo 'Allow: /' . "\r\n";
		echo 'Disallow: /administration/' . "\r\n";
		echo 'Disallow: /ckeditor/' . "\r\n";
		#echo 'Disallow: /css/' . "\r\n";
		#echo 'Disallow: /js/' . "\r\n";
		echo 'Disallow: /public/sendForm.php' . "\r\n";
		echo 'Disallow: /public/newsLetter/newsSend.php';
	}
?>