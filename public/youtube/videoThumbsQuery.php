<?php
	//#clear out previous temp thumbs
//	$priModObj[0]->getCheckQuery("TRUNCATE TABLE youtube_thumbs_temp");
//	
//	#get a json string of the channel information
//	$channels = $priModObj[0]->getUserChannel($priModObj[0]->youtubeSourceUser);
//
//	$channels = json_decode($channels);
//	/*SAMPLE URL...
//	https://www.googleapis.com/youtube/v3/search?key=AIzaSyD4iSEuPL4ru12lBtPtvCbCA4UR3BIKmJw&channelId=UCq8Wp_bvOKpqgiLu30UPc5A&part=snippet,id&order=date&maxResults=20*/
//	
//	/*loops through videos and put them into our cms
//	 database so we can use them in the CMS framework*/
//	foreach($channels->items as $entry){
//		if(isset($entry->id->videoId)){
//			try{			
//				$paramsArray = array();
//				$paramsArray["videoName"] = $entry->snippet->title;
//				#$paramsArray["videoDesc"] = $entry->snippet->description;
//				$paramsArray["youtubeVidID"] = $entry->id->videoId;
//				#$paramsArray["videoURL"] = $entry->snippet->thumbnails->default->url;
//				$priModObj[0]->addRecord($paramsArray);
//			
//			}
//			catch(Exception $e){
//				echo "Youtube is currently updating the thumbnails list. Please try again in a few minutes.";
//			}
//		}
//	}
	
	#youtube thumb info is in a cms table, now we can get a query that our module frame can use
	$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
		array("priKeyID",0,false,"priKeyID","ASC")
	);
?>