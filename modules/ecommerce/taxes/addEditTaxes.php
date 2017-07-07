<?php	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
	$productsObj = new products(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/taxes/productTaxMap.php");
	$productTaxMapObj = new productTaxMap(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/taxes/locationTaxMap.php");
	$locationTaxMapObj = new locationTaxMap(false);
	
	include($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/country.php');
	$countryObj = new country(false);
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/provState.php');
	$provStateObj = new provState(false);
?>

