<?php

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/instance/breadCrumbs/instanceBreadCrumbs.php");

	$instanceBreadCrumbsObj = new instanceBreadCrumbs(false,$_GET["instanceID"]);

	

	echo '<div id="bCr' . $_GET["className"] . '">';

	

	#build up our breadcrumbs

	for($x = 0; $x < $instanceBreadCrumbsObj->level; $x++){

		

		echo '<div id="cmb-' . $_GET["className"] . '-' . $x . '>';

		

		#page module

		if($instanceBreadCrumbsObj->modLevel . $x == 0 && isset($_REQUEST["pageID"])){

			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");

			$pagesObj = new pages(false);

			$bCrumbQuery = $pagesObj->getFieldByPriKeyID("pageName",$_REQUEST["pageID"]);

		}

		#vendor module

		elseif($instanceBreadCrumbsObj->modLevel . $x == 1 && isset($_REQUEST["vendID"])){

			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/vendor.php");

			$vendorObj = new vendor(false);

			$bCrumbQuery = $vendorObj->getFieldByPriKeyID("vendorName",$_REQUEST["vendID"]);

		}

		#product category module

		elseif($instanceBreadCrumbsObj->modLevel . $x == 2 && isset($_REQUEST["prodCatID"])){

			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/productCategories.php");

			$productCategoriesObj = new productCategories(false);

			$bCrumbQuery = $productCategoriesObj->getFieldByPriKeyID("categoryName",$_REQUEST["prodCatID"]);

		}

		#product module

		elseif($instanceBreadCrumbsObj->modLevel . $x == 4 && isset($_REQUEST["prodID"])){

			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");

			$products = new products(false);

			$bCrumbQuery = $products->getFieldByPriKeyID("productName",$_REQUEST["prodID"]);

		}

		

		echo mysqli_fetch_assoc($bCrumbQuery);

		

		echo '</div>';

	}

	

	echo '</div>';



?>