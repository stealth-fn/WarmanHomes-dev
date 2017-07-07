<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class instanceNav extends common{
		public $moduleTable = "instance_nav";
		public $instanceTable = "instance_nav";
		
		public function __construct($isAjax,$pmpmID){		
			parent::__construct($isAjax,$pmpmID);
		}
	}

	if(isset($_REQUEST["function"])){
		$moduleObj = new instanceNav(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instanceNav(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>