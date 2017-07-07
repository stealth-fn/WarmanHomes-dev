<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/publicUsers/publicUsers.php');
	
	class instancePublicUsers extends publicUsers{	
		public $moduleTable = "instance_public_users";
		
		public function __construct($isAjax,$instanceID){		
			parent::__construct($isAjax);
			
			$this->setInstance($instanceID);
		}
	}

	#ajax, our first parameter is the function name, the other parameters are parameters for that function
	if(isset($_REQUEST["function"])){	
		$moduleObj = new instancePublicUsers(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instancePublicUsers(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>