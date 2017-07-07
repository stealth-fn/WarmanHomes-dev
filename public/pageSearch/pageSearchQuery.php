<?php	
	if(isset($_REQUEST['searchTerm'])){
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/pages/pageSearch.php');
		$pageSearchObj = new pageSearch(false,$_GET["instanceID"]);
		$_GET["primaryModuleQuery"] = $pageSearchObj->publicPageSearch($_REQUEST['searchTerm']);
	}
?>