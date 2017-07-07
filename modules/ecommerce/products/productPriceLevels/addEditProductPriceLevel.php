<?php	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroups.php");
	$publicUserGroupObj = new publicUserGroup(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productPriceLevels/productPriceLevelUserGroupMap.php");
	$productPriceLevelUserGroupMapObj = new productPriceLevelUserGroupMap(false);
?>