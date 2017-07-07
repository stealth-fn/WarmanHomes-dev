<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotGroup.php");
	$moduleObj = new hotspotGroup(false);
		
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/hotspotGroups/addEditForm.php");
?>