<?php
	$requestString = "";
	
	#removing duplicate URL parameters helps keep our request strings cleaner
	$_REQUEST = array_unique($_REQUEST);
	foreach($_REQUEST as $key => $value){
		if(
			#the pagination should come from the user
			strpos($key,"pagPage") === false && 
			#this is set manually in the setInstanceModuleParams, because 
			#we overwrite pagPage when we build the pagination DOM
			strpos($key,"currentPagPage") === false &&
			#we don't want the recordIDt hat comes along with the bulk add/edit
			strpos($key,"recordID") === false &&
			#we only want instance params for this module, not any others on this page
			(
				strpos($key,"module") === false || 
				$key === $priModObj[0]->priKeyID
			) &&
			strpos($key,"pageID") === false && 
			strpos($key,"defPageURLParams") === false && 
			#don't need/want cookies
			!isset($_COOKIE[$key])
		){
			#if our key is settings for the instance, and there isn't 
			#the pagPage value already, add it
			if($key == "pmpm" && strpos($value,"ppToken")===false){
				#turn our value into an object so we can easily add our value	
				$tempDecoded = urldecode($value);	
				$tempArray = json_decode($tempDecoded,true);
				
				$appendReqStr = false;
				
				#the pmpm parameter could technically have more than 1 instance
				#loop through those instances and give them the ppToken
				foreach($tempArray as $key2 => $value2){
					$tempArray[$key2]["pagPage"] = "ppToken";
					
					#only make a request string for this mondule instance
					if($key2 == $priModObj[0]->priKeyID) {
						$appendReqStr = true;
					}
				}
				
				if($appendReqStr){
					#turn it back itno our URL string
					$value = json_encode($tempArray);
					$value = rawurlencode($value);
					
					$requestString .= "&amp;" . $key . "=" . $value;
				}
				
			}
			else{
				$requestString .= "&amp;" . $key . "=" . $value;
			}
		}
	}
	
	#add & if the pmpm isn't the first param
	if(strpos($requestString,"ppToken")===false){
		if(strlen($requestString) == 0){
			$requestString .= 'pmpm=%28%22' . $priModObj[0]->priKeyID . '%22%3A%28%22pagPage%22%3A%22ppToken%22%29%29';
		}
		else{
			$requestString .= '&amp;' . 'pmpm=%28%22' . $priModObj[0]->priKeyID . '%22%3A%28%22pagPage%22%3A%22ppToken%22%29%29';
		}
	} 
?>