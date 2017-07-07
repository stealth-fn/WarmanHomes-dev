<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ecommerce/vendors/vendor.php');
	
	class instanceVendors extends vendor{	
		public $moduleTable = "instance_vendors";
		
		public function __construct($isAjax,$instanceID){		
			parent::__construct($isAjax);
			
			$this->setInstance($instanceID);
		}
	}

	if(isset($_REQUEST["function"])){	
		$moduleObj = new instanceVendor(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instanceVendor(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>