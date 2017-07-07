<?php    

	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

		

	class blog extends common{	

		public $moduleTable = "blog";

		public $settingTable = "settings_blog_module";

		public $instanceTable = "instance_blog";

				

		public function __construct($isAjax,$pmpmID = 1){

			parent::__construct($isAjax, $pmpmID);			

			$this->mappingArray[0] = array();

			$this->mappingArray[0]["priKeyName"] = "blogID";

			$this->mappingArray[0]["fieldName"] = "blogCategoryID";

			$this->mappingArray[0]["apiPath"] = "/cmsAPI/blog/blogCategoriesMap.php";

			

			$this->mappingArray[1] = array();

			$this->mappingArray[1]["priKeyName"] = "blogID";

			$this->mappingArray[1]["fieldName"] = "recommendedBlogID";

			$this->mappingArray[1]["apiPath"] = "/cmsAPI/blog/blogRecommendedMap.php";

		}

		

		public function updateFeaturedArticle($blogID){

			#we need to create a gallery image object, we can't use $this 

			#incase this function is being called through an ajax call

			$blogObj = new blog(false);

			

			#first, set all the blog table's featuredArticle fields to 0

			$oldFeaturedBlogs = mysqli_query("UPDATE blog SET featuredArticle = 0 WHERE featuredArticle = 1");

			$blogObj->getCheckQuery($oldFeaturedBlog);



			#then, mark our new blog the featured article

			$paramsArray["featuredArticle"] = 1;

			$paramsArray["priKeyID"] = $blogID;

			$blogObj->updateRecord($paramsArray);

		}

		

		public function getRecommendedBlogs($blogID){

			include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/blog/blogRecommendedMap.php');

			$blogRecommendedMapObj = new blogRecommendedMap(false);

			$recommendedBlogIDsQuery = $blogRecommendedMapObj->getCheckQuery("SELECT * FROM blog_recommended_map WHERE blogID = ".$blogID);

			$recommendedBlogIDsList = $this->getQueryValueString($recommendedBlogIDsQuery,'recommendedBlogID');

			return $recommendedBlogIDsList;

		}

		

		public function querySearchTerm($searchTerm){

			$sanitizedKeywordSearch = $GLOBALS["mysqli"]->real_escape_string($searchTerm);		

			$query = "
				SELECT blog.*, 
				blog.priKeyID as priKeyID FROM blog 
			";
			
			if(strlen($sanitizedKeywordSearch) != 0){

				$query .= " WHERE MATCH
					 	(".$this->moduleSettings['searchFields'].") AGAINST ('".$sanitizedKeywordSearch."' IN BOOLEAN MODE)";
			 	$result = $this->getCheckQuery($query,$this->openConn());
				
				return $result;
			}

		}

	}
	

	if(isset($_REQUEST["function"])){

		$moduleObj = new blog(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');

	}

	elseif(isset($_REQUEST["modData"])){

		$moduleObj = new blog(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');

	}

?>