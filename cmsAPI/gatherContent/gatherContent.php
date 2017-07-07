<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class gatherContent extends common{
		public $moduleTable = "instance_gather_content";
		public $instanceTable = "instance_gather_content";
		
		public function __construct($isAjax,$pmpmID=1){	
		}
		
		public function getProjects(){
		}

	}

	#requires and instanceID when we're doing and add/edit, for now this is retrieved from the form
	if(isset($_REQUEST["function"])){
		$moduleObj = isset($_REQUEST["pmpmID"]) ? new gatherContent(true,$_REQUEST["pmpmID"]) : new gatherContent(true);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = isset($_REQUEST["pmpmID"]) ? new gatherContent(true,$_REQUEST["pmpmID"]) : new gatherContent(true);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>