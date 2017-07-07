<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class poll extends common{
		public $moduleTable = "poll";
	}

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new poll(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new poll(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>