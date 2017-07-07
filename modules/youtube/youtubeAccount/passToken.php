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
			var formContainer = window.opener.document.getElementById("includesContainer");
			formContainer.innerHTML = 
			'Welcome <?php echo $userProfileEntry->getUsername(); ?><br />\n\
			<form name="uploadForm" id="uploadForm" action="">\n\
			Video Title: <input name="videoTitle" id="videoTitle" type="text"/><br />\n\
			Video Description: <input name="videoDesc" id="videoDesc" type="text"/><br />\n\
			Tag Keywords (Seperated with comma): <input name="tagWords" id="tagWords" type="text"/><br />\n\
			<input type="button" value="Upload Video" onclick="uploadVid()"/><br /><br />\n\
			Category: <select name="vidCat" id="vidCat">\n\
						<option selected="" value="">-- Select a category --</option>\n\
						<option value="Autos &amp; Vehicles">Autos &amp; Vehicles</option>\n\
						<option value="Comedy">Comedy</option>\n\
						<option value="Education">Education</option>\n\
						<option value="Entertainment">Entertainment</option>\n\
						<option value="Film &amp; Animation">Film &amp; Animation</option>\n\
						<option value="Gaming">Gaming</option>\n\
						<option value="Howto &amp; Style">Howto &amp; Style</option>\n\
						<option value="Music">Music</option>\n\
						<option value="News &amp; Politics">News &amp; Politics</option>\n\
						<option value="29">Nonprofits &amp; Activism</option>\n\
						<option value="Nonprofits &amp; Activism">People &amp; Blogs</option>\n\
						<option value="15">Pets &amp; Animals</option>\n\
						<option value="Pets &amp; Animals">Science &amp; Technology</option>\n\
						<option value="Sports">Sports</option>\n\
						<option value="Travel &amp; Events">Travel &amp; Events</option>\n\
					</select><br />\n\
			<?php
				/*we use the videoList.php includes in this JS and in php so we have to set a bool to 
				determine how the string is created in the include*/
				$jsStr = true;
				include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeAccount/videoList.php");
			?>';
			window.close();
		}	
	// -->
</script>
</head>
<body onload="loginForm()">
</body>
</html>