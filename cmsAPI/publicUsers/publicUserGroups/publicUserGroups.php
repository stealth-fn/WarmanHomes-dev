<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class publicUserGroup extends common{

		public $moduleTable = "public_user_groups";
		public $instanceTable = "instance_public_user_groups";
		
		public function __construct($isAjax, $pmpmID=1){		

			parent::__construct($isAjax, $pmpmID);

			#mapping infor for pages and user groups
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "publicUserGroupID";
			$this->mappingArray[0]["fieldName"] = "publicUserID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/publicUsers/publicUserGroups/publicUserGroupMap.php";

			$this->mappingArray[1] = array();
			$this->mappingArray[1]["priKeyName"] = "publicUserGroupID";
			$this->mappingArray[1]["fieldName"] = "pageID";
			$this->mappingArray[1]["apiPath"] = "/cmsAPI/publicUsers/publicUserGroups/publicUserGroupPageMap.php";
		}

	}

	if(isset($_REQUEST["function"])){
		$moduleObj = new publicUserGroup(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new publicUserGroup(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>