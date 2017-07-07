<?php
	if(!isset($_SESSION)) session_start();
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotData.php");
	
	#admin side
	$_GET["instanceID"] = 
	isset($_GET["instanceID"]) ? $_GET["instanceID"] : 1;
	$hotspotDataObj = new hotspotData(false);
?>

function setHotspotDataAddEdit(){
	hotspotDataAddEditObj = new stealthInputCommon();
	hotspotDataAddEditObj.apiPath = "/cmsAPI/imageAreaMaps/hotspotData.php";
	hotspotDataAddEditObj.moduleAlert = "Hotspot Data";
	
	hotspotDataAddEditObj.mappingArray = [];
	hotspotDataAddEditObj.mappingArray[0] = [];
	hotspotDataAddEditObj.mappingArray[0].priKeyName = "hotspotDataID";
	hotspotDataAddEditObj.mappingArray[0].fieldName = "imageAreaMapID";
	hotspotDataAddEditObj.mappingArray[0].apiPath = "/cmsAPI/imageAreaMaps/hotspotDataImageAreaMap.php";
}

<?php 
	echo $hotspotDataObj->generateFormValidation("moduleForm",$hotspotDataObj->moduleSettings["validateFields"]);
?>
