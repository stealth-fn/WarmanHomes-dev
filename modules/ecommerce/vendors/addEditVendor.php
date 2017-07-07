<?php	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
	$productsObj = new products(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/gallery.php");
	$galleryObj = new gallery(false);
		
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/productCategories.php");
	$productCategoriesObj = new productCategories(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/prodVenMap.php");
	$prodVendObj = new prodVenMap(false);
	
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/prodCatVendMap.php");
	$prodCatVendObj = new prodCatVendMap(false);
?>