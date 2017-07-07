<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');	
	
	class products extends common{	
		public $moduleTable = "products";
		public $settingTable = "settings_products_module";
		public $instanceTable = "instance_products";
		
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
			$this->mappingArray = array();			
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "productID";
			$this->mappingArray[0]["fieldName"] = "productCategoryID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/ecommerce/productCategories/prodCatMap.php";
			
			$this->mappingArray[1] = array();
			$this->mappingArray[1]["priKeyName"] = "productID";
			$this->mappingArray[1]["fieldName"] = "vendorID";
			$this->mappingArray[1]["apiPath"] = "/cmsAPI/ecommerce/vendors/prodVenMap.php";
				
			$this->mappingArray[2] = array();
			$this->mappingArray[2]["priKeyName"] = "productID";
			$this->mappingArray[2]["fieldName"] = "fileLibraryID";
			$this->mappingArray[2]["apiPath"] = "/cmsAPI/fileLibrary/fileLibraryProductMap.php";
			
			$this->mappingArray[3] = array();
			$this->mappingArray[3]["priKeyName"] = "productID";
			$this->mappingArray[3]["fieldName"] = "productOptionCategoryID";
			$this->mappingArray[3]["apiPath"] = "/cmsAPI/ecommerce/products/productOptions/optionCategoryProductMap.php";
		}
		
		#get the price of a product for a user based on their groups pricing
		public function getUserProductPrice($productID){
			
			if(!isset($_SESSION))session_start();
			
			$pInfo = mysqli_fetch_assoc($this->getRecordById($productID));
			
			#if the user is logged in
			if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] > 0){
				
				#determine if they are in a group
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroupMap.php");
				$publicUserGroupMapObj = new publicUserGroupMap(false);
				$userGroups = $publicUserGroupMapObj->getConditionalRecord(
					array("publicUserID",$_SESSION['userID'],true)
			 	);
				#if they are in a group
				if(mysqli_num_rows($userGroups) > 0){
					$userGroupIDString = $this->getQueryValueString($userGroups,"publicUserGroupID",",");
					
					#get price levels that affect this user
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productPriceLevels/productPriceLevelUserGroupMap.php");
					$productPriceLevelUserGroupMapObj = new productPriceLevelUserGroupMap(false);
					
					$groupPriceLevels = $productPriceLevelUserGroupMapObj->getConditionalRecordFromList(
						array("publicUserGroupID",$userGroupIDString,true)
					);
					#if the users groups are mapped to product price levels
					if(mysqli_num_rows($groupPriceLevels) > 0){
						$priceLevelIDString = $this->getQueryValueString($groupPriceLevels,"productPriceLevelID",",");
						
						#get price level info
						include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productPriceLevels/productPriceLevels.php");
						$productPriceLevelObj = new productPriceLevel(false);
						
						#order them so we get the lowest % in our mysqli_fetch_array
						$productPriceLevels = $productPriceLevelObj->getConditionalRecordFromList(
							array("priKeyID",$priceLevelIDString,true,"levelPercentage","DESC")
						);
						#determine final price for user
						$prodPriceLevel = mysqli_fetch_assoc($productPriceLevels); 
						$userPrice = $pInfo["price"] - ($pInfo["price"] * ($prodPriceLevel["levelPercentage"]/100));
						return round($userPrice,2);
					}#not mapped to price levels
					else return round($pInfo["price"],2);
				}#not in a group
				else return round($pInfo["price"],2);
			}#not logged in
			else return round($pInfo["price"],2);
		}
		
		#return products thats meet search criteria
		public function ecommerceSearch($searchTerm){
			
			#joins for all the tables we would like to search
			$mappingArray = array(
				array("LEFT JOIN","product_category_map","products","productID","priKeyID"),
				array("LEFT JOIN","product_categories","product_category_map","priKeyID","productCategoryID"),
				array("LEFT JOIN","product_vendor_map","products","productID","priKeyID"),
				array("LEFT JOIN","store_vendors","product_vendor_map","priKeyID","vendorID")
			);
		
			#fields with the search term we want to use
			$searchJoinArray = array(
				"products.productName",$searchTerm , "like",
				"products.sku",$searchTerm , "like",
				"products.productCopy",$searchTerm , "like",
				"store_vendors.vendorName",$searchTerm , "like",
				"product_categories.categoryName",$searchTerm , "like"
			);
			
			#search with the OR operator to return all results
			return $this->getConditionalRecord(
				$searchJoinArray, $mappingArray, "OR"
			);

		}
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new products(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new products(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>