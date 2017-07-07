<?php
	session_start();
	
	/*load youtube libraries*/
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeLibLoader.php");
	
	/*take our token and make it a session token to reuse*/
	if(isset($_GET["token"])){
		$_SESSION["youtubeToken"] = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET["token"]);
	}
	
	/*get user info*/
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeAccount/videoAccountLoader.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>StealthCMS Pass Youtube Info</title>
<script type="text/javascript">
	<!--
		function loginForm(){
			var blogContainer = window.opener.document.getElementById("blogVidContainer");
			blogContainer.innerHTML = '\n\
			<?php
				echo '<select id="youtubeVid" name="youtubeVid">';
				foreach($userVideos as $entry){
					echo '<option value="' . $entry->getVideoId() . '">' . $entry->getVideoTitle() . '</option>';
				}				
				echo '</select>';
			?>
			';
			window.close();
		}	
	// -->
</script>
</head>
<body onload="loginForm()">
</body>
</html>