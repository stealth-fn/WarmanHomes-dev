<?php		
	#NAME
	if(array_key_exists("moduleName",$priModObj[0]->domFields)){
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
		$moduleObj = new module(false);
		$moduleInfo = $moduleObj->getRecordByID($priModObj[0]->queryResults["moduleID"]); 
		$modName = mysqli_fetch_assoc($moduleInfo);
		
		$priModObj[0]->domFields["moduleName"] = 
		'<div 
			id="modn-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="modn modn-' . $priModObj[0]->className . '"
		>' . 
			$modName["moduleName"] .
		'</div>';
	}
?>