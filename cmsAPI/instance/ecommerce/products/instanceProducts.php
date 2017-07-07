<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ecommerce/products/products.php');
	
	class instanceProducts extends products{	
		public $moduleTable = "instance_products";
		
		public function __construct($isAjax,$instanceID){		
			parent::__construct($isAjax);
			
			$this->setInstance($instanceID);
		}
	}

	if(isset($_REQUEST["function"])){	
		$moduleObj = new instanceProducts(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instanceProducts(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>