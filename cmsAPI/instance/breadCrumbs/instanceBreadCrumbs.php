<?php
	#most instance modules extend another module, not common, 
	#but breadcrumbs don't belong to one specific module
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class instanceBreadCrumbs extends common{	
		public $moduleTable = "instance_bread_crumbs";
		public $modLevel = array();
		
		public function __construct($isAjax,$instanceID){		
			parent::__construct($isAjax);
			
			$this->setInstance($instanceID);
			
			/*0 - pages 1 - vendors  2 - product categories 3 - products loop through
			our modulePriorityList and set the module types to different levels*/
			$tempMod = explode(",",$this->modulePriority);
			$modCnt = count($tempMod);
			for($x = 0; $x < $modCnt; $x++){
				$this->modLevel[$x] = $tempMod[$x];
			}
			
			#how many potential levels we have on this breadcrumb
			$this->level = $modCnt;
		}
	}

	#ajax, our first parameter is the function name, the other parameters are parameters for that function
	if(isset($_REQUEST["function"])){	
		$moduleObj = new instanceBreadCrumbs(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instanceBreadCrumbs(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>