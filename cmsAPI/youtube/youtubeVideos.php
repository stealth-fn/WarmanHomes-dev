<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class youtubeVideos extends common{	
		public $moduleTable = "youtube_videos";
		public $instanceTable = "instance_youtube_player";
		
		/*query our front end settings from the db and set the properties for this class*/
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
		}
	
		public function delVid($videoID){
			include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeLibLoader.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/modules/youtube/youtubeAccount/videoAccountLoader.php");
			$videoEntryToDelete = $yt->getVideoEntry($videoID, null, true);
			$yt->delete($videoEntryToDelete);
		}
		
	}
	
	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new youtubeVideos(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new youtubeVideos(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>