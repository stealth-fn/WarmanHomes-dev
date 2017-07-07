<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/productCategories.php");
	$productCategoriesObj = new productCategories(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/vendor.php");
	$vendorObj = new vendor(false);
?>