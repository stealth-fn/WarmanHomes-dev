<?php
	#JSON needs double quotes, but our client is using singles right now... should just be fixed
	
	/*swtiching from {} to () for our JSON. {} are marked as 'unsafe' characters for url's
	and we've had issues with our links, especially sharing in social media. to make sure
	our old links work we will still decode the {}, but if that doesn't work, we will try to
	convert our {} to () and then decode the JSON again*/
	if(isset($_REQUEST["pmpm"])) {
		global $requestPMPM;
		$_REQUEST["pmpm"] = str_replace("'",'"',$_REQUEST["pmpm"]);
		$requestPMPM = json_decode($_REQUEST["pmpm"],true);
	
		#our JSON was invalid. replace {} with () and try again
		if($requestPMPM === NULL){
			$_REQUEST["pmpm"] = str_replace("(","{",$_REQUEST["pmpm"]);
			$_REQUEST["pmpm"] = str_replace(")","}",$_REQUEST["pmpm"]);

			$requestPMPM = json_decode($_REQUEST["pmpm"],true);
		}
	}
?>