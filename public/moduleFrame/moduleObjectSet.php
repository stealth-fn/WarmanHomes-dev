<?php 
	#we store our module objects in an array
	global $priModObj;
    
    #we store our module objects in an array
    if(!isset($priModObj)) {
        $priModObj = array();
    }

	include_once($_SERVER['DOCUMENT_ROOT'] . $pMod["primaryAPIFile"]);
	$tempObj = new $pMod["phpClass"](false,$pMod);

	#store our new object in the first location in the array
	array_unshift($priModObj,$tempObj);

	if(isset($_REQUEST["bulkMod"])){
		$priModObj[0]->bulkMod = true;
	}
	
	#determine what DOM elements to display
	if(strlen($priModObj[0]->displayElements) > 0){
		/*turn our string list to an array, loop through it 
		an create our associative array to store our DOM elements*/
		$tempDom = explode(",",$priModObj[0]->displayElements);
		$priModObj[0]->domFields = array();
		foreach($tempDom as $domKey) {
			if(strpos($domKey,'div.') !== false){
				$divClass = explode('.',$domKey);
				$priModObj[0]->domFields[$domKey] = '<div class="'.$divClass[1].'">';
			}
			else $priModObj[0]->domFields[$domKey] = "";
		}
	}
?>