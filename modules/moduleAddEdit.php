<?php
	global $moduleQuery;#query for the module record

	if(isset($_REQUEST["recordID"]) && is_numeric($_REQUEST["recordID"])){#if there is a record ID
		$moduleObj->addEdit = true;
		$moduleQuery = $moduleObj->getRecordByID($_REQUEST["recordID"]);
	}
	else{
		$moduleObj->addEdit = false;
	}
?>