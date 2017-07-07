<?php	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/productOptionCategoryMap.php");
	$prodOpCatMap = new productOptionCategoryMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
	$productsObj = new products(false);
?>

