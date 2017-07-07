<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class faq extends common{
		public $moduleTable = "faq";
		public $instanceTable = "instance_faq";
		
		public function __construct($isAjax,$pmpmID = 1){		
			parent::__construct($isAjax,$pmpmID);
		
			#mapping infor for pages and user groups
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "faqID";
			$this->mappingArray[0]["fieldName"] = "faqCategoryID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/faq/faqCatMap.php";
		}
	}
		
	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new faq(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new faq(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>