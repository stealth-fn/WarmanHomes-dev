<?php

	session_start();

	

	/*get google development key from settings table*/

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/settings/settings.php");

	$settingsObj = new settings(false);

	$settings = $settingsObj->getRecordByID(1);

	

	while($x = mysqli_fetch_array($settings)){

		$devKey = $x["googleDevKey"];

	}

	

	/*load youtube libraries*/

	include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeLibLoader.php");

	

	/*get user info*/

	$httpClient = Zend_Gdata_AuthSub::getHttpClient($_SESSION['youtubeToken']);

	$yt = new Zend_Gdata_YouTube($httpClient, null, null, $devKey);

	

	// create a new VideoEntry object

	$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

	

	$myVideoEntry->setVideoTitle($_REQUEST["videoTitle"]);

	$myVideoEntry->setVideoDescription($_REQUEST["videoDesc"]);

	// The category must be a valid YouTube category!

	$myVideoEntry->setVideoCategory($_REQUEST["vidCat"]);

	

	// Set keywords. Please note that this must be a comma-separated string

	// and that individual keywords cannot contain whitespace

	$myVideoEntry->SetVideoTags($_REQUEST["tagWords"]);

	$tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';

	$tokenArray = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);

	$tokenValue = $tokenArray['token'];

	$postUrl = $tokenArray['url'];

	$next = 'http://' . $_SERVER['SERVER_NAME'] . '/modules/youtube/youtubeAccount/passToken.php';

?>



<form action="<?php echo $postUrl; ?>?nexturl=<?php echo $next; ?>" method="post" enctype="multipart/form-data" target="upload_target">

	<input name="file" type="file"/>

	<input name="token" type="hidden" value="<?php echo $tokenValue; ?>"/>

	<input value="Upload Video File" type="submit" /> 

</form>

<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>