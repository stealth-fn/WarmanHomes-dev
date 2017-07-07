<?php	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
	$pagesObj = new pages(false, NULL);	
	$publicPages = $pagesObj->getConditionalRecord(
		array("priKeyID","0","great","pageName","ASC")
	);
?>