<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class taxes extends common{	
		public $moduleTable = "store_taxes";
		public $settingTable = "instance_store_taxes";
		public $instanceTable = "instance_store_taxes";
		
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "taxID";
			$this->mappingArray[0]["fieldName"] = "productID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/ecommerce/taxes/productTaxMap.php";
			
			$this->mappingArray[1] = array();
			$this->mappingArray[1]["priKeyName"] = "taxID";
			$this->mappingArray[1]["fieldName"] = "countryID";
			$this->mappingArray[1]["apiPath"] = "/cmsAPI/ecommerce/taxes/locationTaxMap.php";
			
			$this->mappingArray[2] = array();
			$this->mappingArray[2]["priKeyName"] = "taxID";
			$this->mappingArray[2]["fieldName"] = "provStateID";
			$this->mappingArray[2]["apiPath"] = "/cmsAPI/ecommerce/taxes/locationTaxMap.php";
		}
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new taxes(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new taxes(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>