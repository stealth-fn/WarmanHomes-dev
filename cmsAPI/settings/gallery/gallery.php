<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class gallerySettings extends common{	
		public $moduleTable = "settings_image_gallery";
	}

	#ajax, our first parameter is the function name, the other parameters are parameters for that function
	if(isset($_REQUEST["function"])){	
		$moduleObj = new gallerySettings(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
?>