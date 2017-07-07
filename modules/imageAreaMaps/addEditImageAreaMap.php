<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/imageAreaMap.php");
	$moduleObj = new imageAreaMap(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspot.php");
	$hotspotObj = new hotspot(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotGroup.php");
	$hotspotGroupObj = new hotspotGroup(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotGroupMap.php");
	$hotspotGroupMapObj = new hotspotGroupMap(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotData.php");
	$hotspotDataObj = new hotspotData(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotDataMap.php");
	$hotspotDataMapObj = new hotspotDataMap(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotDataImageAreaMap.php");
	$hotspotDataImageAreaMapObj = new hotspotDataImageAreaMap(false);
		
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/imageAreaMaps/addEditForm.php");
?>