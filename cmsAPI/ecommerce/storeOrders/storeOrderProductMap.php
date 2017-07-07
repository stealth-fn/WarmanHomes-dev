<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');	
	class storeOrderProductMap extends common{
		public $moduleTable = "store_order_product_map";
	}

	#ajax, our first parameter is the function name, the other parameters are parameters for that function
	if(isset($_REQUEST["function"])){	
		$moduleObj = new storeOrderProductMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new storeOrderProductMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>