<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class productPriceLevel extends common{
		public $moduleTable = "product_price_levels";
		public $instanceTable = "instance_product_price_level";
		
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "productPriceLevelID";
			$this->mappingArray[0]["fieldName"] = "publicUserGroupID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/ecommerce/products/productPriceLevels/productPriceLevelUserGroupMap.php";			
		}
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new productPriceLevel(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new productPriceLevel(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>