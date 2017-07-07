<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class productCategories extends common{
		public $moduleTable = "product_categories";
		public $instanceTable = "instance_product_category";
		/*public $standardMappingArray = array(
			array("LEFT JOIN","product_category_map","product_categories","productCategoryID","priKeyID"),
			array("LEFT JOIN","products","product_category_map","priKeyID","productID"),
			array("LEFT JOIN","product_gallery_map","products","productID","priKeyID"),
			array("LEFT JOIN","image_gallery","product_gallery_map","priKeyID","galleryID")
		);*/
		
		protected $rootCatID = 0;
		
		public function __construct($isAjax,$pmpmID = 1){		
			parent::__construct($isAjax,$pmpmID);
			
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "prodCatID";
			$this->mappingArray[0]["fieldName"] = "prodSubCatID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/ecommerce/productCategories/prodSubCatMap.php";
			
			$this->mappingArray[1] = array();
			$this->mappingArray[1]["priKeyName"] = "productCategoryID";
			$this->mappingArray[1]["fieldName"] = "productID";
			$this->mappingArray[1]["apiPath"] = "/cmsAPI/ecommerce/productCategories/prodCatMap.php";
			
			$this->mappingArray[2] = array();
			$this->mappingArray[2]["priKeyName"] = "productCategoryID";
			$this->mappingArray[2]["fieldName"] = "vendorID";
			$this->mappingArray[2]["apiPath"] = "/cmsAPI/ecommerce/vendors/prodCatVendMap.php";
				
			//used in recursive function getProdCatTree
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/prodSubCatMap.php");
			$_SESSION["prodSubCatObj"] = new prodSubCatMap(false);
		
		}
				
		public function getRootCats($vendorID = false){
			
			if(!$vendorID) {					
				$result = $GLOBALS["mysqli"]->query(
					"SELECT *
					FROM product_categories AS pc 
					WHERE pc.priKeyID 
					NOT IN (SELECT prodSubCatID FROM product_subcategories_map GROUP BY prodSubCatID) 
					GROUP BY 1"
				);
			}
			else {
				$result = $GLOBALS["mysqli"]->query(
					"SELECT * 
					FROM product_categories AS pc
					LEFT JOIN productCategory_vendor_map
					ON (pc.priKeyID = productCategory_vendor_map.productCategoryID)
					WHERE productCategory_vendor_map.vendorID = '" . $GLOBALS["mysqli"]->real_escape_string($vendorID) . "' 
					AND pc.priKeyID 
					NOT IN (SELECT prodSubCatID FROM product_subcategories_map GROUP BY prodSubCatID) 
					GROUP BY 1"
				);
			}
															
			return $result;
		}
		
		public function getCats($parentCatID = false){
			$parentCatID = $parentCatID || "";
			$result = $GLOBALS["mysqli"]->query(
				"SELECT pc.*, galleryID 
				FROM product_categories AS pc
				LEFT JOIN products AS pr
				ON (pc.prodGalID = pr.priKeyID)
				LEFT JOIN product_gallery_map AS pgm
				ON (pr.priKeyID = pgm.productID)
				WHERE pc.priKeyID NOT IN (SELECT prodSubCatID FROM product_subcategories_map)"
			);												
			return $result;
		}
		
		/*this function is more complicated but makes less hits on the database so is WAY faster
		when we have lots of data, returns a multi-dimensional array that is a category tree*/
		public function getProdCatTreeArray($prodCatID,$rootCatID,$level,$catName,$vendorID = false){
			
			//set up root categories
			if($level === 0){				
				
				//query that gets our tree info
				$query = "SELECT
							product_categories.categoryName
							 , product_subcategories_map.prodSubCatID
							 , product_categories.priKeyID as prodCatID
							 , product_categories_1.categoryName AS subCatName
						  FROM
								product_categories
						  LEFT JOIN product_subcategories_map 
							 ON (product_categories.priKeyID = product_subcategories_map.prodCatID)
						  LEFT JOIN product_categories AS product_categories_1
							 ON (product_subcategories_map.prodSubCatID = product_categories_1.priKeyID)";
				
				#only show categories for a specific vendor		 
				if($vendorID) {
					$query .= 
					"LEFT JOIN productCategory_vendor_map
						ON (product_categories.priKeyID = productCategory_vendor_map.productCategoryID)
					 WHERE productCategory_vendor_map.vendorID = '" . $GLOBALS["mysqli"]->real_escape_string($vendorID) . "'";
				}

				$result = $GLOBALS["mysqli"]->query($query);
								
				$_SESSION["prodCatQueryArray"] = array();
				$prodCatTreeArray = array();
				$arrayCnt = 0;
				
				//turn our query into an array
				while($x = mysqli_fetch_assoc($result)){
					$_SESSION["prodCatQueryArray"][$arrayCnt]["categoryName"] = $x["categoryName"];
					$_SESSION["prodCatQueryArray"][$arrayCnt]["prodSubCatID"] = $x["prodSubCatID"];
					$_SESSION["prodCatQueryArray"][$arrayCnt]["prodCatID"] = $x["prodCatID"];
					$_SESSION["prodCatQueryArray"][$arrayCnt]["subCatName"] = $x["subCatName"];
					$arrayCnt++;
				}
				
				#full tree
				if($level==0 && $rootCatID == 0) $rootCats = $this->getRootCats();
				#tree with a specified root
				else if($level==0 && $rootCatID != 0){
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/prodSubCatMap.php");
					$prodSubCatMapObj = new prodSubCatMap(false); 
					$rootCatIDQuery = $prodSubCatMapObj->getConditionalRecord(array("prodCatID",$rootCatID,true));
					$rc = $prodSubCatMapObj->getQueryValueString($rootCatIDQuery,"prodSubCatID",",");
					$rootCats = $this->getConditionalRecordFromList(array("priKeyID",$rc,true));
				}
				
				//loop through root categories
				while($y = mysqli_fetch_assoc($rootCats)){
					
					//create root node
					$prodCatTreeArray[$y["priKeyID"]] = array();
					$prodCatTreeArray[$y["priKeyID"]]["rootID"] = 0;
					$prodCatTreeArray[$y["priKeyID"]]["level"] = 0;
					$prodCatTreeArray[$y["priKeyID"]]["categoryName"] = $y["categoryName"];
					
					//loop through query array and build up tree
					foreach($_SESSION["prodCatQueryArray"] as $key => $value){

						//check if this is our current root
						if($_SESSION["prodCatQueryArray"][$key]["prodCatID"] === $y["priKeyID"]){
							//check if there is a subcategory for this node
							if(is_numeric($_SESSION["prodCatQueryArray"][$key]["prodSubCatID"])){
								//recursive call the child category info
								$prodCatTreeArray[$y["priKeyID"]][$_SESSION["prodCatQueryArray"][$key]["prodSubCatID"]] = 
									$this->getProdCatTreeArray(
										$_SESSION["prodCatQueryArray"][$key]["prodSubCatID"],
										$y["priKeyID"],
										1,
										$_SESSION["prodCatQueryArray"][$key]["subCatName"]
									);
							}
						}
					}
				}
				
				return $prodCatTreeArray;
			}
			//child category
			else{
				//create child node
				$prodCatTreeArray[$prodCatID] = array();
				$prodCatTreeArray[$prodCatID]["rootID"] = $rootCatID;
				$prodCatTreeArray[$prodCatID]["level"] = $level;
				$prodCatTreeArray[$prodCatID]["categoryName"] = $catName;
				
				//loop through query array and build up tree
				foreach($_SESSION["prodCatQueryArray"] as $key => $value){
					//check if this is the  product we're at
					if($_SESSION["prodCatQueryArray"][$key]["prodCatID"] === $prodCatID){
						//check if there is a subcategory for this node
						if($_SESSION["prodCatQueryArray"][$key]["prodSubCatID"] > 0){
							$tmpLevel = $level+1;
							//recursive call the child category info
							$prodCatTreeArray[$prodCatID][$_SESSION["prodCatQueryArray"][$key]["prodSubCatID"]] = 
								$this->getProdCatTreeArray(
									$_SESSION["prodCatQueryArray"][$key]["prodSubCatID"],
									$rootCatID,
									$tmpLevel,
									$_SESSION["prodCatQueryArray"][$key]["subCatName"]
								);
						}
					}
				}

				return $prodCatTreeArray;
			}
			
		}
		
		/*recursively retrieves all product category children for a parent category*/
		public function getAllChildCategories($prodCatID){
			
			$productCatArray = array();
						
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/prodSubCatMap.php");
			$prodSubCatObj = new prodSubCatMap(false);
			$childCategories = $prodSubCatObj->getConditionalRecord(
				array("prodCatID",$prodCatID,true)
			);
			
			while($y = mysqli_fetch_assoc($childCategories)){
				array_push($productCatArray,$y["prodSubCatID"]);
				array_merge($this->getAllChildCategories($y["prodSubCatID"]),$productCatArray);
			}

			return $productCatArray;
		}
		
		public function getProdCatTree($treeArray,$vendID=false){
			
			global $rootCatID;
			global $rootID;
			
			//our keys are the prodCat id's, the values are associative arrays
			foreach($treeArray as $prodCatID => $currentArray){				
				//string since we output as js
				$isRoot = "false";
								
				//+1 for styles
				$treeLevel = $currentArray["level"] + 1;
				$childLevel = $currentArray["level"] + 2;
				
				//$rootCatID = $currentArray["rootID"];
				
				if($treeLevel === 1){
					//get categories that aren't sub categories, they will be our root categories
					$isRoot = "true";
					$rootID = $prodCatID;
					$rootCatID = $prodCatID . "-" . $treeLevel . "-" . $prodCatID;
					#what function we want to run after a category is clicked on
					$afterRun = $this->createInstanceOnclick($prodCatID,$prodCatID,false,$vendID);
				}
				else
					#what function we want to run after a category is clicked on
					$afterRun = $this->createInstanceOnclick($prodCatID,$rootID,false,$vendID);
				
				$onMouseOver = "";
				$onMouseOut = "";
				$onclick = "";
				
				//how many products are in this category
				//$categoryProducts = parent::getAllCategoryProducts($x["priKeyID"]);
				//$catProdQty = mysql_num_rows($categoryProducts);
				
				/*if($prodCatID == 0){
					$rootCatID = $prodCatID . "-" . $treeLevel . "-" . $prodCatID;
				}*/
				
				switch($this->navType){
				case 0: #top nav
					if($this->isSubNav){
						$navPrefix = "satpto_" . $this->className;
					}
					else{
						$navPrefix = "atpto_" . $this->className;
	
					}
					break;
				case 1: #side nav
					if($this->isSubNav){
						$navPrefix = "satpo_" . $this->className;
					}
					else{
						$navPrefix = "atpo_" . $this->className;
					}
					break;
				case 2: #bottom nav
					if($this->isSubNav){
						$navPrefix = "satpbo_" . $this->className;
					}
					else{
						$navPrefix = "atpbo_" . $this->className;
					}
					break;
				}
				
				#0 & 2, top and bottom nav
				/*if($this->navType == 0 || $this->navType == 2){
					$onMouseOver = '$("catChildren' . $prodCatID . '-' . $treeLevel . '-' . $prodCatID . '").style.display="block";
									clearTimeout("naDropTimecatChildren' . $prodCatID . '");
									prevHideID="catChildren' . $prodCatID . '-' . $treeLevel . '-' . $prodCatID . '";';
					$onMouseOut = 'aTPCO.mouseOutTop("' . $prodCatID . '-' . $treeLevel . '-' . $rootID . '")';
					$onclick = 'event.cancelBubble = true;if (event.stopPropagation){event.stopPropagation();}' . $afterRun;
				}
				else{*/
					$onMouseOver = "";
					$onMouseOut = "";
					$onclick = $afterRun . '; return false';
				/*}*/
								
				echo "<div 
						class='nc catTreeLvl" , $treeLevel , " niCat" . $rootID . "_" . $prodCatID . "' 
						id='catContain" , $prodCatID , "-" , $treeLevel , "-" , $rootID , "'  
					  >
						<a 
							class='nc pcatLvl" , $treeLevel , "' 
							id='pcat" , $prodCatID , "-" , $treeLevel , "-" , $rootID , "'
							onclick='" , $onclick , "'
							onmouseout='" , $onMouseOut , "'
							onmouseover='" , $onMouseOver , "'
						>" . 
								"<span class='catProdQty' id='catProdQty-" , $prodCatID , "-" , $rootID ,"'>" , 
									/*$catProdQty*/"" , 
								"</span>" , 
								$currentArray["categoryName"] , 
						"</a>
						<div 
							class='ec catChildren" , $treeLevel , "' 
							id='catChildren" , $prodCatID , "-" , $treeLevel , "-" , $rootID , "'"
							#if we have a prodCatRootID in the request and this category is it, 
							#open its children, currently only setup to work for roots
							 , (isset($_REQUEST["prodCatID"]) && $_REQUEST["prodCatID"] == $prodCatID) ? 
							 "
							 style='display: block'>" : 
							 "
							 style='display: none'
						>";
							
					foreach($currentArray as $subKey => $subValue){
						if(is_numeric($subKey)) echo $this->getProdCatTree($subValue,$vendID);
					}			
				echo "</div>";
				echo "</div>";		  
		  	}
		}
		
		#recursively retrieves all product id's as a list for a specified product category
		public function getAllCategoryProducts($prodCatID,$prodCatParentID){
			
			/*get sub-categories*/
			$prodCatArray = $this->getAllChildCategories($prodCatID);
			/*we want the parent category too*/
			array_push($prodCatArray,$prodCatID);
			$prodCatList = implode(",",$prodCatArray);
			
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/productCategories/prodCatMap.php");
			$prodCatObj = new prodCatMap(false);
			
			/*get the products for the categories, must also belong to parent category*/
			$catProds = $GLOBALS["mysqli"]->query(
			"SELECT pcm.priKeyID, pcm.productID, pcm.productCategoryID
			FROM product_category_map AS pcm
			WHERE pcm.productID 
			IN (
				SELECT productID 
				FROM product_category_map
				WHERE productCategoryID = '" . $GLOBALS["mysqli"]->real_escape_string($prodCatParentID) . "'
			)
			AND
			
			pcm.productCategoryID = '" . $GLOBALS["mysqli"]->real_escape_string($prodCatID) . "'");			
					
			$prodList = $this->getQueryValueString($catProds,"productID",",");
			
			return $prodList;
		}
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new productCategories(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new productCategories(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>