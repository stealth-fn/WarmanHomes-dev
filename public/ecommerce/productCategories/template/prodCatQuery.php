<?php
	#get children categories
	if(isset($priModObj[1]) && isset($priModObj[1]->parentCatID)){

		#get the child ID's as an array...
		$catArray= $priModObj[0]->getAllChildCategories(
			$priModObj[1]->parentCatID
		);
		
		#...turn to string
		$tempIDs = implode(",",$catArray);
		
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecordFromList(
			array("priKeyID",$tempIDs,"true")
		);
	}
	#only get the root categories
	elseif(isset($priModObj[0]->rootCats)){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getRootCats();
	}
?>