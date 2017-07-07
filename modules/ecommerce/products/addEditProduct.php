<?php	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/productOptionCategory.php");
	$productOptionCategoryObj = new productOptionCategory(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/optionCategoryProductMap.php");
	$optionCategoryProductMapObj = new optionCategoryProductMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productFeatures/productFeatures.php");
	$productFeatureObj = new productFeature(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productFeatures/productFeatures2.php");
	$productFeature2Obj = new productFeature2(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/productCategories.php");
	$productCategoriesObj = new productCategories(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/prodCatMap.php");
	$prodCatObj = new prodCatMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/vendor.php");
	$vendorObj = new vendor(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/prodVenMap.php");
	$prodVendObj = new prodVenMap(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/flatRateShipping/flatRateShipping.php");
	$flatRateObj = new flatRateShipping(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/flatRateShipping/flat_rate_product_map.php");
	$flatRateProdMapObj = new flatRateProdMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryProductMap.php");
	$fileLibraryProductMapObj = new prodVenMap(false);
?>

