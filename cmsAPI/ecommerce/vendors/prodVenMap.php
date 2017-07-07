<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class prodVenMap extends common{
		public $moduleTable = "product_vendor_map";
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new prodVenMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new prodVenMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>