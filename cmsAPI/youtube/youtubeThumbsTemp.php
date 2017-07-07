<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class youtubeThumbsTemp extends common{	
		public $moduleTable = "youtube_thumbs_temp";
		public $instanceTable = "instance_youtube_player";
		
		public function getUserChannel($channelID){
			$ch = curl_init(); #create curl resource
			#set url
			curl_setopt(
				$ch, 
				CURLOPT_URL, 
				"https://www.googleapis.com/youtube/v3/search?key=AIzaSyD4iSEuPL4ru12lBtPtvCbCA4UR3BIKmJw" .
				"&channelId=" . $channelID .
				"&part=snippet,id&order=date&maxResults=50"
			);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); #return the transfer as a string
			$output = curl_exec($ch); #$output contains the output string
			curl_close($ch);  #close curl resource to free up system resources
			
			if($this->ajax) echo $output;
			else return $output;
		}
	}

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new youtubeThumbsTemp(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new youtubeThumbsTemp(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>