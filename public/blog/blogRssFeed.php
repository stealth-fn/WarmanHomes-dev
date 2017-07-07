<?php
// Sent the correct header so browsers display properly, with or without XSL.
header( 'Content-Type: application/xml' );

include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");

echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";

include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blog.php");
$blogObj = new blog(false);

$rssfeed .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';

$rssfeed .= '<channel>';

$rssfeed .= '<title>Stealth Web Designs RSS feed</title>';

$rssfeed .= '<link>http://www.stealthwd.ca</link>';

$rssfeed .= '<description>News and Blogs from the Stealth Web Design Team</description>';

$rssfeed .= '<atom:link href="http://cmsprod.stealthssd.com/public/blog/blogRssFeed.php" rel="self" type="application/rss+xml" />';

$rssfeed .= '<language>en-us</language>';

$rssfeed .= '<copyright>Copyright (C) '.date('Y').' stealthwd.ca</copyright>';

$allBlogs = $blogObj->getConditionalRecord(array("priKeyID",0,false,"priKeyID","DESC"));

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

function getCleanURLStr($string){
	#Replaces all spaces with hyphens.
	$string = str_replace(' ', '-', $string);

	#Removes special chars.
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

	#Replaces multiple hyphens with single one.
	#return preg_replace('/-+/', '-', $string);
	return $string;
}

while($x = mysqli_fetch_array($allBlogs)){

	$rssfeed .= '<item>';

	$rssfeed .= '<title>'.$x['blogName'].'</title>';

	$rssfeed .= '<link>' . $protocol . $_SERVER['SERVER_NAME'] . '/CMS-Dev/Blog%20Article/' . rawurlencode(getCleanURLStr($x["blogName"])) . '</link>';

	$rssfeed .= '<pubDate>'.date(DATE_RSS, strtotime($x['postDate'])).'</pubDate>';
	
	$rssfeed .= '<description><![CDATA['. $x['blogCopy'] .']]></description>';
	
	# needs to be something unique for each item, if you put real link set isPermalink as true
	$rssfeed .= '<guid isPermaLink="false">blogKeyID'. $x['priKeyID'] .'</guid>';

	$rssfeed .= '</item>';

}

$rssfeed .= '</channel>';

$rssfeed .= '</rss>';

echo $rssfeed;
?>