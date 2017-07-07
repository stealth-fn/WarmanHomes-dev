<?php
	$secChk = $moduleObj->checkSecurityLevel($GLOBALS["ajaxRunFunction"]);

	if(
		isset($moduleObj->moduleTable) &&
		strlen($moduleObj->moduleTable) > 0 &&
		gettype($secChk) !== "boolean"
	){
			echo $secChk . ' ' . $moduleObj->moduleTable;
	}
	else{		
		$paramsArray = array();

		#we don't want cookie info, so no $_REQUEST, only POST or GET allowed
		if(count($_POST) > 1) $ajaxArray = $_POST;
		else if(count($_GET) > 1) $ajaxArray = $_GET;

		#if we have parameters for our function
		if(count($ajaxArray) > 1){
			$postCnt = 1;
			
			foreach($ajaxArray as $key => $postPass){
				
				#we don't want the opengraph info that we set in settings
				if($key !== "openGraph"){
					#JSON from client, first character is a {
					if(is_string($postPass) && substr($postPass,0,1) === "{") {
						$postPass = json_decode($postPass,true);
					}
					#don't put the function name in our param array
					if($postCnt > 1) {
						array_push($paramsArray,$postPass);
					}

					$postCnt++;
				}
			}
		}

		#call function with params from client
		call_user_func_array(array($moduleObj, $GLOBALS["ajaxRunFunction"]),$paramsArray);
	}
?>

