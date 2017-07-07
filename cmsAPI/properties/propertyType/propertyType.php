<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class propertyType extends common{
		public $moduleTable = "property_type";
		public $instanceTable = "instance_property_type";
		
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
		
		$this->mappingArray = array();			
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "propertyID";
			$this->mappingArray[0]["fieldName"] = "typeID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/properties/propertyType/propTypeMap.php";
		
	}}
	
	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new propertyType(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new propertyType(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
		
?>