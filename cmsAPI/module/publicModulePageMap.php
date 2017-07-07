<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class publicModulePageMap extends common{				
		public $moduleTable = "public_module_page_map";
		public $instanceTable = "instance_public_module_page_map";
		
		public function getDisplayElements($moduleID){
			#get the listing module. it should have the same phpClass and be of isTemplate 1
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
			$moduleObj = new module(false,NULL);
			
			$displayModle = $moduleObj->getRecordByID($moduleID);
			
			$dm = mysqli_fetch_assoc($displayModle);
			
			$priModObj = array();
			$priModObj[0] = new stdClass();
			$priModObj[0]->domFields = array();
			$priModObj[0]->ispmpmBuild = true;
				
			include($_SERVER['DOCUMENT_ROOT']. $dm["templateDOMFile"]);		
			
			echo json_encode($priModObj[0]);			
		}
	}

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new publicModulePageMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new publicModulePageMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>