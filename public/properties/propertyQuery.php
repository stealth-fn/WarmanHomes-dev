<?php
	if(isset($priModObj[0]->propertyID)){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecordFromList(
			array("properties.priKeyID",$priModObj[0]->propertyID,true)
		);
	}
	
	if(isset($priModObj[0]->searchParams)){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->propertySearch(
			$priModObj[0]->searchParams
		);
	}
	
?>