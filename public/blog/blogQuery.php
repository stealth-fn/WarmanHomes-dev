<?php	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogCategory.php");
	$blogCategoryObj = new blogCategory(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogCategoriesMap.php");
	$blogCategoriesMapObj = new blogCategoriesMap(false,NULL);
		
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogTagMap.php");
	$blogTagMapObj = new blogTagMap(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogTag.php");
	$blogTagObj = new blogTag(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogRecommendedMap.php");
	$blogRecMapObj = new blogRecommendedMap(false,NULL);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUsers.php");
	$publicUsersObj = new publicUsers(false,NULL);

	#blogs by search term
	if(isset($_REQUEST['blogSearchTerm'])){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->querySearchTerm(
			$_REQUEST['blogSearchTerm']
		);
	}
	elseif(isset($_GET["parentBlogID"])){
		$recommendedBlogIDList = $priModObj[0]->getRecommendedBlogs(
			$priModObj[1]->primaryModuleQuery["priKeyID"]
		);
		
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecordFromList(
			array("blog.priKeyID",$recommendedBlogIDList,true)
		);
	}
	#blog for a specific month
	elseif( 
		isset($priModObj[0]->viewBlogMonth) &&
		isset($priModObj[0]->viewBlogYear)
	){
		#set our date ranges
		
		$year = $priModObj[0]->viewBlogYear;
		$month = $priModObj[0]->viewBlogMonth;	
		
		$minDate = $year . "-" . $month . "-" . "01";	
		
		$daysQty = $priModObj[0]->monthDayAmount(
			$priModObj[0]->viewBlogMonth,
			$priModObj[0]->viewBlogYear
		);	
		
		$maxDate = $year . "-" . $month . "-" . $daysQty;
		
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array(
					"postDate",$minDate,"greatEqual",
		 			"postDate",$maxDate,"lessEqual",
					"postDate","DESC"
		 	)
		);
		
	}
	#earlier than the last few months
	elseif(isset($priModObj[0]->viewEarlier)){
		$beforeDate = date("Y-n-d",mktime(0,0,0,1,1,date('Y')-4));
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array("postDate",$beforeDate,"less","blog.postDate","DESC")
		);
	}
	#specific blog
	elseif(isset($priModObj[0]->blogKeyID)){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array('blog.priKeyID',$priModObj[0]->blogKeyID,true)
		);
	}
	elseif(isset($priModObj[0]->blogName)){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			$priModObj[0]->buildQueryString($priModObj[0]->blogName)
		);
	}
	#view blogs for a certain category
	elseif(
		isset($priModObj[0]->blogCategoryID) ||
		(isset($_REQUEST["parentPriKeyID"]))
	){
		
		if(isset($_REQUEST["parentPriKeyID"])) {
			$priModObj[0]->blogCategoryID = $_REQUEST["parentPriKeyID"];
		}
		
		$catBlogIDList = "";
		if(isset($priModObj[0]->blogCategoryID)){
			$catBlogIDList .= $blogCategoryObj->getAllCategoryBlogs(
				$priModObj[0]->blogCategoryID,
				$priModObj[0]->blogCategoryID
			);
		}

		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecordFromList(
			array(
				"blog.priKeyID",$catBlogIDList,true,
				"blog.postDate","DESC"
			)
		);
	}
	#blogs for a specific tag
	elseif(isset($priModObj[0]->viewBlogTagID)){
		$tagBlogs = $blogTagMapObj->getConditionalRecord(
			array("blogTagID",$priModObj[0]->viewBlogTagID,true)
		);
		$blogIDList = $blogTagMapObj->getQueryValueString($tagBlogs,"blogID",",");
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecordFromList(
			array("blog.priKeyID",$blogIDList,true,"blog.postDate","DESC")
		);
	}
	else{
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array("blog.priKeyID",0,false,"blog.postDate","DESC")
		);
	}

	#we can set up seperate pages for blog category listing pages, that's what we are seeing below
	/*$viewCategoriesPage = $priModObj[0]->sortByCategoriesPageID;
	$viewTagsPage = $priModObj[0]->sortByTagPageID;
	$viewDatesPage = $priModObj[0]->sortByDatePageID;
	$viewArticlePage = $priModObj[0]->specificBlogPageID;*/
?>
