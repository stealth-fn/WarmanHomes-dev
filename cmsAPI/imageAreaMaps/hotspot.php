<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class hotspot extends common{
		public $moduleTable = "hotspots";
	}
	
	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new hotspot(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new hotspot(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>