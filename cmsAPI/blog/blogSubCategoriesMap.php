<?php	

	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	

	class blogSubcategoriesMap extends common{

		public $moduleTable = "blog_subcategories_map";

		

		protected function getDistinctIDs($blogCatID){		

			

			$result = mysqli_query("SELECT DISTINCT blogCatID FROM " . $this->moduleTable . " WHERE blogSubCatID  = '" . $GLOBALS["mysqli"]->real_escape_string($blogCatID) . "'");

			

			if($this->ajax == true){

				echo $result;

			}

			else{

				return $result;

			}			

		}

		

		/*$blogCatID is what we're looking for, $levelCatID is the one we're checking for this time through*/

		public function getValidCatIDs($blogCatID){

			$levelMatches = $this->getDistinctIDs($blogCatID);		

			$nonValidSubCat = $blogCatID;

			

			if(mysqli_num_rows($levelMatches) > 0){

				while($x = mysqli_fetch_array($levelMatches)){

					$nonValidSubCat .= "," . $x["blogCatID"];

				}

			}

			

			$blogCategoriesObj = new blogCategory(false);		

			$validCategories = $blogCategoriesObj->getConditionalRecordFromList("priKeyID",$nonValidSubCat,false);		

			return $validCategories;

		}

	}

	

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/

	if(isset($_REQUEST["function"])){	

		$moduleObj = new blogSubcategoriesMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');

	}	

	elseif(isset($_REQUEST["modData"])){

		$moduleObj = new blogSubcategoriesMap(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');

	}

?>