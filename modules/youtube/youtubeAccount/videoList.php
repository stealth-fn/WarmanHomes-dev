<?php
	$videoCnt = 0;
	foreach($userVideos as $entry){
		echo '<table id="youtubeInfo' . $entry->getVideoId() . '"><tbody><tr><td rowspan="2">';
		
		$thumbnails = $entry->getVideoThumbnails();
		echo '<img alt="" src="' . $thumbnails[0]['url'] . '"/><br /><br />';
		
		echo '</td><td>';
		echo $entry->getVideoTitle() . '<br />' . '</td>';
		
		/*create the string differently depending if we're using this include for js or php*/
		if(isset($jsStr)){
			$delVidClick = "\"deleteVideo(\"" . $entry->getVideoId() . "\")\"";
			$videoDesc = str_replace("'","\'",$entry->getVideoDescription());
		}
		else{
			$delVidClick = '"deleteVideo(\'' . $entry->getVideoId() . '\')"';
			$videoDesc = $entry->getVideoDescription();
		}
		
		echo '<td><input type="button" onclick=' . $delVidClick . ' name="removeButton' .$videoCnt . '" id="removeButton' .$videoCnt . '" value="" class="modSubElRem"></td>';
		echo '<tr><td>' . $videoDesc . "<br />";
	
		echo "</td></tr></tbody></table>";
		$videoCnt++;
	}
?>