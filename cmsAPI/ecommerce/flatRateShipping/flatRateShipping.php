<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class flatRateShipping extends common{	
		public $moduleTable = "flat_rate";
		public $instanceTable = "flat_rate";
		
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "flatRateID";
			$this->mappingArray[0]["fieldName"] = "productID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/ecommerce/flatRateShipping/flat_rate_product_map.php";
			
			$this->mappingArray[1] = array();
			$this->mappingArray[1]["priKeyName"] = "flatRateID";
			$this->mappingArray[1]["fieldName"] = "postalID";
			$this->mappingArray[1]["apiPath"] = "/cmsAPI/ecommerce/flatRateShipping/flat_rate_postal_map.php";
		}
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new flatRateShipping(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new flatRateShipping(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>