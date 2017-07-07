<?php	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/property.php");
	$propertyObj = new property(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/propertyType/propertyType.php");
	$propertyTypeObj = new propertyType(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/propertyType/propTypeMap.php");
	$propTypeMapObj = new propTypeMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/propertyCity/propertyCity.php");
	$propertyCityeObj = new propertyCities(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/propertyCity/propCityMap.php");
	$propCityMapObj = new propCityMap(false);
?>

