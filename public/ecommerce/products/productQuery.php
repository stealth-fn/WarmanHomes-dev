<?php
	if(!isset($_SESSION))session_start();
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productFeatures/productFeatures.php");
	$productFeatureObj = new productFeature(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productFeatures/productFeatures2.php");
	$productFeature2Obj = new productFeature2(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/productOptionCategory.php");
	$productOptionCategoryObj = new productOptionCategory(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/productOptionCategoryMap.php");
	$prodOpCatMap = new productOptionCategoryMap(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/optionCategoryProductMap.php");
	$optionCategoryProductMapObj = new optionCategoryProductMap(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/cmsCart/cmsCart.php');
	$cmsCartObj = new cmsCart(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/paypal/paypal.php");
	$paypalSettingsObj = new paypal(false,NULL);
	$payPalsettings = $paypalSettingsObj->getRecordByID(1);
	$ppSet = mysqli_fetch_assoc($payPalsettings);

	#get productids for a category
	$catProdIDList = "";
	
	
	if (isset($_REQUEST["prodCatID"])) $priModObj[0]->prodCatID = $_REQUEST["prodCatID"];
	
	if(isset($priModObj[0]->prodCatID)){ #products from the product category template module
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/productCategories.php");
		$productCategoriesObj = new productCategories(false);
		if(isset($priModObj[0]->prodCatRootID)){
			$catProdIDList .= $productCategoriesObj->getAllCategoryProducts($priModObj[0]->prodCatID,$priModObj[0]->prodCatRootID);
		}
		else{
			$catProdIDList .= $productCategoriesObj->getAllCategoryProducts($priModObj[0]->prodCatID,$priModObj[0]->prodCatID);
		}
		$catProdIDArray = explode(",",$catProdIDList);
	}

	#get productids for a vendor
	/*when we have a vendID in a cat tree we may not have
	a vendor selected yet, so check for numeric value*/
	$vendProdIDList = "";
	if(isset($priModObj[0]->vendID) && is_numeric($priModObj[0]->vendID)){
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/vendors/prodVenMap.php");
		$prodVenMapObj = new prodVenMap(false);
		#query of mapped products
		$mappedProds = $prodVenMapObj->getConditionalRecord(array("vendorID",$priModObj[0]->vendID,true));
		#string/list of mapped products
		$vendProdIDList = $prodVenMapObj->getQueryValueString($mappedProds,"productID");
		$vendProdIDArray = explode(",",$vendProdIDList);
	}

	#get productsIDs that exist in both search criteria
	if(isset($vendProdIDArray) && isset($catProdIDArray)){
		$prodIDArray = array_intersect($catProdIDArray,$vendProdIDArray);
		$prodQueryIDList = implode(",",$prodIDArray);
	}
	#only one of the strings has id's, so use it
	else $prodQueryIDList = $catProdIDList . $vendProdIDList;

	#looking for vendor or category products
	if((isset($priModObj[0]->vendID) || isset($priModObj[0]->prodCatID)) && !isset($priModObj[0]->searchTerm)){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecordFromList(
			array("products.priKeyID",$prodQueryIDList,true),
			$priModObj[0]->standardMappingArray
		);
	}
	else{

		#view a specific product
		if(isset($priModObj[0]->productsID)){
			$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
				array(
					"products.priKeyID",
					$priModObj[0]->productsID,
					true,
					"products.domainID",
					$_SESSION["domainID"],
					true
				),$priModObj[0]->standardMappingArray
			);
			
			#product doesn't exist for this domain
			if(mysqli_num_rows($priModObj[0]->primaryModuleQuery) == 0){
				#get it without the domain
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
				  array(
					  "products.priKeyID",
					  $priModObj[0]->productsID,
					  true
				  ),$priModObj[0]->standardMappingArray
			 	 );
				 
				$tempQuery = mysqli_fetch_assoc($priModObj[0]->primaryModuleQuery);
				$groupID = $tempQuery["groupID"];
				
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
					array(
						"products.groupID",
						$groupID,
						true,
						"products.domainID",
						$_SESSION["domainID"],
						true
					),$priModObj[0]->standardMappingArray
				);
			}
		
		}
		elseif(isset($priModObj[0]->productName)){
			$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
				array(
					"products.priKeyID",
					$priModObj[0]->productName,
					true
				),$priModObj[0]->standardMappingArray
			);
		}
		#view cart
		/*elseif(isset($priModObj[0]->viewCart)){
			$prodIDList = "";
			foreach($_SESSION["cartProductIDs"] as $key => $value){		
				if(strlen($prodIDList) === 0) $prodIDList = $_SESSION["cartProductIDs"][$key]["productID"];
				else $prodIDList .= "," . $_SESSION["cartProductIDs"][$key]["productID"];
			}
			
			$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecordFromList(
				array("products.priKeyID",$prodIDList,true),$priModObj[0]->standardMappingArray
			);
		}*/
		#view cart
		elseif(isset($priModObj[0]->viewCart)){
			#If user has added at lesat one product to the Cart, it is shown
			if (isset($_SESSION["cartProductIDs"]) && count($_SESSION["cartProductIDs"])) {
				#var_dump($_SESSION["cartProductIDs"]);
				$prodQueryArray = array();
				#loop through the cart products
				foreach($_SESSION["cartProductIDs"] as $key => $value){
					
					#loop through each product/option configuration in the cart
					foreach($value as $loc => $cartProd){
						array_push(
							$prodQueryArray,
							"(" . 
							$priModObj[0]->getConditionalRecord(
								array("products.priKeyID",$cartProd["productID"],true)
								,NULL,NULL,true
							) . ")"
						);
					}
				}
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getCheckQuery(
					implode(" UNION ALL ", $prodQueryArray)
				);
			}
			#if the Cart is empty
			else {
				
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
					array("priKeyID","0",true)
				);
			}
		}
		#ecommerce search
		elseif(isset($_REQUEST["searchTerm"])){
			$priModObj[0]->primaryModuleQuery = $priModObj[0]->ecommerceSearch($_REQUEST["searchTerm"]);
		}
	}
?>