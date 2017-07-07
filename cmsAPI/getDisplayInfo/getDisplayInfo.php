<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class getDisplayInfo extends common{	
		public $moduleTable = "instance_get_display_info";
		public $instanceTable = "instance_get_display_info";
				
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
			if(!isset($_SESSION["userDisplayInfo"])){
				$_SESSION["userDisplayInfo"] = $this->userDisplayInfo;
			}
			
		}
		
		public function getDisplayInfo($userInfo){
			
			if(!isset($_SESSION)){
				session_start();
			}
			
			$_SESSION["userDisplayInfo"] = $userInfo;
		}
	}
	
	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new getDisplayInfo(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new getDisplayInfo(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>