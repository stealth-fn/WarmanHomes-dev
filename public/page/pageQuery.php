<?php
	if(!isset($_SESSION))session_start();

	#show child pages for specified page
	if(isset($_REQUEST["parentPageID"])){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array(
				"parentPageID",$_REQUEST["parentPageID"],true
			)
		);
	}

	#default - only get the root level pages for this language, and admin pages
	else{
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array(
				"domainID",abs($_SESSION["domainID"]),true,
				"pageLevel","1","lessEqual",
				"pageLevel","0","greatEqual"
			)
		);
	}
?>