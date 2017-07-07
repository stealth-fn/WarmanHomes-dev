<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class prodSubCatMap extends common{
	
		public $moduleTable = "product_subcategories_map";
		
		protected function getDistinctIDs($prodCatID){		
			
			$result = $GLOBALS["mysqli"]->query(
				"SELECT DISTINCT prodCatID FROM " . 
				$this->moduleTable . " WHERE prodSubCatID  = '" . $GLOBALS["mysqli"]->real_escape_string($prodCatID) . "'"
			);

			if($this->ajax) echo $result;
			else return $result;
		}
		
		#$prodCatID is what we're looking for, $levelCatID is the one we're checking for this time through
		public function getValidCatIDs($prodCatID){
			$levelMatches = $this->getDistinctIDs($prodCatID);		
			$nonValidSubCat = $prodCatID;
			
			if(mysqli_num_rows($levelMatches) > 0){
				while($x = mysqli_fetch_assoc($levelMatches)){
					$nonValidSubCat .= "," . $x["prodCatID"];
				}
			}
			
			/*why was this here?*/
			/*require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');*/
			$productCategoriesObj = new productCategories(false);		
			$validCategories = $productCategoriesObj->getConditionalRecordFromList(array("priKeyID",$nonValidSubCat,false));		
			return $validCategories;
		}
	}
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new prodSubCatMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new prodSubCatMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>