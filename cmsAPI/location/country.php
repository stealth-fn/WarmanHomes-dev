<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class country extends common{
		public $moduleTable = "countries";
	}
		
	if(isset($_REQUEST["function"])){
		$moduleObj = new country(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
?>