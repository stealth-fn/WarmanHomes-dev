<?php	
	#a public user is modifying their own account
	if(isset($priModObj[0]->publicUser) && 
		$priModObj[0]->publicUser == 1
	) {
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getRecordByID($_SESSION["userID"]);
	}
	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/country.php');
	$countryObj = new country(false);
	$countries = $countryObj->getConditionalRecord(array("isActive",1,true));

	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/provState.php');
	$provStateObj = new provState(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroups.php");
	$publicUserGroupObj = new publicUserGroup(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroupMap.php");
	$publicUserGroupMapObj = new publicUserGroupMap(false);
?>