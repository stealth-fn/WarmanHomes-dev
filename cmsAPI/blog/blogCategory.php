<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class blogCategory extends common{
		public $moduleTable = "blog_categories";
		public $instanceTable = "instance_blog_category";
		
		public function __construct($isAjax,$pmpmID = 1){		
			parent::__construct($isAjax,$pmpmID);
		
			#mapping infor for pages and user groups
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "blogCategoryID";
			$this->mappingArray[0]["fieldName"] = "blogID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/blog/blogCategoriesMap.php";
		}
		
		public function getRootCats(){
			$result = mysqli_query("SELECT bc.priKeyID, bc.blogCatDesc FROM blog_categories AS bc WHERE bc.isRootCat = 1");
			return $result;
		}
		
		/*this function is more complicated but makes less hits on the database so is WAY faster
		when we have lots of data, returns a multi-dimensional array that is a category tree*/
		public function getBlogCatTreeArray($blogCatID,$rootCatID,$level,$catName){
			
			//set up root categories
			if($level === 0){				
				
				//query that gets our tree info
				$query = "SELECT
							blog_categories.blogCatDesc
							 , blog_subcategories_map.blogSubCatID
							 , blog_categories.priKeyID as blogCatID
							 , blog_categories_1.blogCatDesc AS subCatName
						  FROM
								blog_categories
						  LEFT JOIN blog_subcategories_map 
							 ON (blog_categories.priKeyID = blog_subcategories_map.blogCatID)
						  LEFT JOIN blog_categories AS blog_categories_1
							 ON (blog_subcategories_map.blogSubCatID = blog_categories_1.priKeyID)";
				
				$result = mysqli_query($query);
								
				$_SESSION["blogCatQueryArray"] = array();
				$blogCatTreeArray = array();
				$arrayCnt = 0;
				
				//turn our query into an array
				while($x = mysqli_fetch_assoc($result)){
					$_SESSION["blogCatQueryArray"][$arrayCnt]["categoryName"] = $x["blogCatDesc"];
					$_SESSION["blogCatQueryArray"][$arrayCnt]["blogSubCatID"] = $x["blogSubCatID"];
					$_SESSION["blogCatQueryArray"][$arrayCnt]["blogCatID"] = $x["blogCatID"];
					$_SESSION["blogCatQueryArray"][$arrayCnt]["subCatName"] = $x["subCatName"];
					$arrayCnt++;
				}
				
				$rootCats = $this->getRootCats();
				
				//loop through root categories
				while($y = mysqli_fetch_assoc($rootCats)){
					
					//create root node
					$blogCatTreeArray[$y["priKeyID"]] = array();
					$blogCatTreeArray[$y["priKeyID"]]["rootID"] = 0;
					$blogCatTreeArray[$y["priKeyID"]]["level"] = 0;
					$blogCatTreeArray[$y["priKeyID"]]["categoryName"] = $y["blogCatDesc"];
					
					//loop through query array and build up tree
					foreach($_SESSION["blogCatQueryArray"] as $key => $value){

						//check if this is our current root
						if($_SESSION["blogCatQueryArray"][$key]["blogCatID"] === $y["priKeyID"]){
							//check if there is a subcategory for this node
							if(is_numeric($_SESSION["blogCatQueryArray"][$key]["blogSubCatID"])){
								//recursive call the child category info
								$blogCatTreeArray[$y["priKeyID"]][$_SESSION["blogCatQueryArray"][$key]["blogSubCatID"]] = $this->getblogCatTreeArray($_SESSION["blogCatQueryArray"][$key]["blogSubCatID"],$y["priKeyID"],1,$_SESSION["blogCatQueryArray"][$key]["subCatName"]);
							}
						}
					}
				}
				
				return $blogCatTreeArray;
			}
			//child category
			else{
				//loop through query array and build up tree
				foreach($_SESSION["blogCatQueryArray"] as $key => $value){
					//check if this is the  product we're at
					if($_SESSION["blogCatQueryArray"][$key]["blogCatID"] === $blogCatID){
						//check if there is a subcategory for this node
						if(is_numeric($_SESSION["blogCatQueryArray"][$key]["blogSubCatID"])===true){
							//recursive call the child category info
							$blogCatTreeArray[$blogCatID][$_SESSION["blogCatQueryArray"][$key]["blogSubCatID"]] = $this->getBlogCatTreeArray($_SESSION["blogCatQueryArray"][$key]["blogSubCatID"],$rootCatID,$level+1,$_SESSION["blogCatQueryArray"][$key]["subCatName"]);
						}
					}
				}
				
				//create child node
				$blogCatTreeArray[$blogCatID] = array();
				$blogCatTreeArray[$blogCatID]["rootID"] = $rootCatID;
				$blogCatTreeArray[$blogCatID]["level"] = $level;
				$blogCatTreeArray[$blogCatID]["categoryName"] = $catName;
				return $blogCatTreeArray;
			}
			
		}
		
		/*recursively retrieves all blog category children for a parent category*/
		public function getAllChildCategories($blogCatID){
			
			$blogCatArray = array();
						
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogSubCategoriesMap.php");
			$blogSubCatObj = new blogSubcategoriesMap(false);
			
			$childCategories = $blogSubCatObj->getConditionalRecord(array("blogCatID",$blogCatID,true));
			
			while($y = mysqli_fetch_assoc($childCategories)){
				array_push($blogCatArray,$y["blogSubCatID"]);
				array_merge($this->getAllChildCategories($y["blogSubCatID"]),$blogCatArray);
			}
			
			return $blogCatArray;
		}
		
		/*recursively retrieves all products under a specified category and its sub-categories*/
		public function getAllCategoryBlogs($blogCatID,$blogCatParentID){
			
			/*get sub-categories*/
			$blogCatArray = $this->getAllChildCategories($blogCatID);
			
			/*we want the parent category too*/
			array_push($blogCatArray,$blogCatID);
			
			$blogCatList = implode(",",$blogCatArray);
			
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogCategoriesMap.php");
			$blogCatObj = new blogCategoriesMap(false);
			
			/*get the blogs for the categories, must also belong to parent category*/
			$catBlogs = $GLOBALS["mysqli"]->query("SELECT bcm.priKeyID, bcm.blogID, bcm.blogCategoryID
			 FROM blog_categories_map AS bcm
			 WHERE bcm.blogID 
			 IN (
					 SELECT blogID 
					 FROM blog_categories_map
					 WHERE blogCategoryID = " . $GLOBALS["mysqli"]->real_escape_string($blogCatParentID) . "
				)
			 AND
			 bcm.blogCategoryID = " . $GLOBALS["mysqli"]->real_escape_string($blogCatID));
			 
					
			$blogList = $this->getQueryValueString($catBlogs,"blogID",",");

			return $blogList;			
		}
	}
				
	if(isset($_REQUEST["function"])){	
		$moduleObj = new blogCategory(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new blogCategory(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>