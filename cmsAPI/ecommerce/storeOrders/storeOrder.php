<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');	
	
	class storeOrder extends common{
		public $moduleTable = "store_orders";
		public $settingTable = "settings_store_orders";
		public $instanceTable = "instance_store_orders";
		
		public function __construct($isAjax,$pmpmID = 1){	
			parent::__construct($isAjax,$pmpmID);
			
			if(isset($_SESSION["adminPub"]) && $_SESSION["adminPub"] > 0){
				$this->addDefault['orderDate'] = "dateStamp";
				$this->addDefault['orderTime'] = "timeStamp";
			}
			
			$this->addDefault['lastUpdated'] = "dateStamp";
			$this->updateDefault['lastUpdated'] = "dateStamp";
			
			$this->addDefault['shipPostalZip'] = "postalFormat";
			$this->updateDefault['shipPostalZip'] = "postalFormat";
			
		}
	}

	if(isset($_REQUEST["function"])){	
		$moduleObj = new storeOrder(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new storeOrder(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>