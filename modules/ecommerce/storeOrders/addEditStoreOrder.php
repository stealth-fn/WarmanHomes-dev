<?php	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUsers.php");
	$publicUsersObj = new publicUsers(false, NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/country.php');
	$countryObj = new country(false, NULL);
	$countries = $countryObj->getConditionalRecord(array("isActive",1,true));

	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/provState.php');
	$provStateObj = new provState(false, NULL);
?>

