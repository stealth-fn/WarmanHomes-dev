<?php	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/prodSubCatMap.php");
	$prodSubCatObj = new prodSubCatMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
	$productsObj = new products(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/prodCatMap.php");
	$prodCatObj = new prodCatMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/vendor.php");
	$vendorObj = new vendor(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/prodCatVendMap.php");
	$prodCatVendObj = new prodCatVendMap(false);
	
	if(isset($_REQUEST["recordID"]) && is_numeric($_REQUEST["recordID"])) {
		$productCategories = $prodSubCatObj->getValidCatIDs($_REQUEST["recordID"]);
	}
	else { 
		$productCategories = $priModObj[0]->getAllRecords();
	}
?>

