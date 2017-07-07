<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotData.php");
	$moduleObj = new hotspotData(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/imageAreaMap.php");
	$imageAreaMapObj = new imageAreaMap(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotDataImageAreaMap.php");
	$hotspotDataImageAreaMapObj = new hotspotDataImageAreaMap(false);
		
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/hotspotData/addEditForm.php");
?>