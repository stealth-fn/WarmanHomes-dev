<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class vendor extends common{
		public $moduleTable = "store_vendors";
		public $settingTable = "instance_vendors";
		public $instanceTable = "instance_vendors";
		
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);

			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "vendorID";
			$this->mappingArray[0]["fieldName"] = "productID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/ecommerce/vendors/prodVenMap.php";
			
			$this->mappingArray[1] = array();
			$this->mappingArray[1]["priKeyName"] = "vendorID";
			$this->mappingArray[1]["fieldName"] = "productCategoryID";
			$this->mappingArray[1]["apiPath"] = "/cmsAPI/ecommerce/vendors/prodCatVendMap.php";
		}
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new vendor(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new vendor(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>