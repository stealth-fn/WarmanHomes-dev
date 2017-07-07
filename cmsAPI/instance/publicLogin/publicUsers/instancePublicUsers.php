<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/publicUsers/publicUsers.php');
	
	class instancePublicUsers extends publicUsers{	
		public $moduleTable = "instance_public_user";
		
		public function __construct($isAjax,$instanceID = 1){		
			parent::__construct($isAjax);
			$this->setInstance($instanceID);
		}
	}

	if(isset($_REQUEST["function"])){	
		$moduleObj = new instancePublicUsers(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instancePublicUsers(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>