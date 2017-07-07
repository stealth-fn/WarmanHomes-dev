<?php	

	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	class instancePropSearch extends common{	
		public $moduleTable = "instance_property_search";
		public $instanceTable = "instance_property_search";
		
		public function __construct($isAjax,$pmpmID = 1){

			parent::__construct($isAjax,$pmpmID);			

		}

	}


	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/

	if(isset($_REQUEST["function"])){	
		$moduleObj = new instancePropSearch(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}

	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instancePropSearch(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');

	}

?>