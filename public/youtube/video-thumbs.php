<?php
	#Videothumb Description
	if(array_key_exists("vidDesc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vidDesc"] =
		'<div 
			id="vidDesc-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="vidDesc vidDesc-' . $priModObj[0]->className . '"
		>'. $priModObj[0]->queryResults["videoDesc"] . '</div>';
	}
	
	#Videothumb Title
	if(array_key_exists("vidTitle",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vidTitle"] =
		'<div 
			id="vidTitle-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="vidTitle vidTitle-' . $priModObj[0]->className . '"
		>'. $priModObj[0]->queryResults["videoName"] . '</div>';
	}
	
	//#Videothumb Image
//	if(array_key_exists("vidImg",$priModObj[0]->domFields)){
//		$priModObj[0]->domFields["vidImg"] =
//		'<div 
//			id="vidImg-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
//			class="vidImg vidImg-' . $priModObj[0]->className . '"
//		><img
//		alt="'. $priModObj[0]->queryResults["youtubeVidID"] .'"
//		class="vidImg" 
//		src="'. preg_replace('/default\.jpg$/', '0.jpg',$priModObj[0]->queryResults["videoURL"]) .'" 
//	/></div>';
//	}
	
	#Videothumb Image
	if(array_key_exists("vidImg",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vidImg"] =
		'<div 
			id="vidImg-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="vidImg-' . $priModObj[0]->className . '"
		><img
		class="vidImg"
		alt="'. $priModObj[0]->queryResults["youtubeVidID"] .'"
		src="https://i.ytimg.com/vi/'. $priModObj[0]->queryResults["youtubeVidID"] .'/default.jpg"
	/></div>';
	}
	
	#Videothumb Code
	if(array_key_exists("vidCode",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vidCode"] =
		'<iframe 
			id="vidCode-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="vidCode vidCode-' . $priModObj[0]->className . '"
			src="https://www.youtube.com/embed/' . $priModObj[0]->queryResults["videoID"] .'?enablejsapi=1"
		></iframe>';
	}
	
	#Videothumb link
	if(array_key_exists("vidLink",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vidLink"] =
		'<a 
			id="vidLink-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="vidLink vidLink-' . $priModObj[0]->className . '"
			href="http://www.youtube.com/watch?v=' . $priModObj[0]->queryResults["videoID"] . '"
		>'. $priModObj[0]->queryResults["videoURL"] . '</div>';
	}
?>
