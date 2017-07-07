<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/faq/faqCategories.php");
	$faqCategoryObj = new faqCategory(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/faq/faqCatMap.php");
	$faqCatMap = new faqCatMap(false);
?>