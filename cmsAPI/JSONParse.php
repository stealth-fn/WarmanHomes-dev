<?php
	#convert modData to an associative array
	$argsArray = json_decode($GLOBALS["ajaxmodData"],true);
	$paramsArray = array();
	$paramsArray[0] = $argsArray;
	
	$secChk = $moduleObj->checkSecurityLevel($argsArray["function"]);
	
	#call api function with associative array of parameters
	if(gettype($secChk) === "boolean") {
		call_user_func_array(array($moduleObj, $argsArray["function"]),$paramsArray);
	}
	else echo $secChk . ' ' . $moduleObj->moduleTable;
?>