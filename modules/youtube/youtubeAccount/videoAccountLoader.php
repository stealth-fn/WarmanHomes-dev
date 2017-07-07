<?php
	if(isset($_REQUEST["function"])){
		unset($_REQUEST["function"]);
	}
	
	/*get google development key from settings table*/
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/settings/settings.php");
	$settingsObj = new settings(false);
	$settings = $settingsObj->getRecordByID(1);
	
	$x = mysql_fetch_array($settings);
	$devKey = $x["googleDevKey"];
	
	/*get user info*/
	$httpClient = Zend_Gdata_AuthSub::getHttpClient($_SESSION['youtubeToken']);
	$yt = new Zend_Gdata_YouTube($httpClient, null, null, $devKey);
	$yt->setMajorProtocolVersion(2);
	$userProfileEntry = $yt->getUserProfile("default");
	$userVideos = $yt->getUserUploads("default");
?>