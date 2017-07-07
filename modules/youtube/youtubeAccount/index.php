<?php
	session_start();
	if(isset($_SESSION['youtubeToken'])){		
		include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeLibLoader.php");
		include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeAccount/videoAccountLoader.php");
		
		echo 'Welcome ' . $userProfileEntry->getUsername() . '<br />
			<form name="uploadForm" id="uploadForm" action="">
			Video Title: <input name="videoTitle" id="videoTitle" type="text"/><br />
			Video Description: <input name="videoDesc" id="videoDesc" type="text"/><br />
			Tag Keywords (Seperated with comma): <input name="tagWords" id="tagWords" type="text"/><br />
			Category: <select name="vidCat" id="vidCat">
						<option selected="" value="">-- Select a category --</option>
						<option value="Autos &amp; Vehicles">Autos &amp; Vehicles</option>
						<option value="Comedy">Comedy</option>
						<option value="Education">Education</option>
						<option value="Entertainment">Entertainment</option>
						<option value="Film &amp; Animation">Film &amp; Animation</option>
						<option value="Gaming">Gaming</option>
						<option value="Howto &amp; Style">Howto &amp; Style</option>
						<option value="Music">Music</option>
						<option value="News &amp; Politics">News &amp; Politics</option>
						<option value="29">Nonprofits &amp; Activism</option>
						<option value="Nonprofits &amp; Activism">People &amp; Blogs</option>
						<option value="15">Pets &amp; Animals</option>
						<option value="Pets &amp; Animals">Science &amp; Technology</option>
						<option value="Sports">Sports</option>
						<option value="Travel &amp; Events">Travel &amp; Events</option>
					</select><br />
			<input type="button" value="Upload Video" onclick="uploadVid()"/><br /><br />';
			
			include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeAccount/videoList.php");
			echo "<br /><br />";
	}
	else{
		echo '<input value="Login" type="button" onclick="getAuthTok()"/>';
	}
?>