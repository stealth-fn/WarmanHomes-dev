<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogCategory.php");
	$blogCategoriesObj = new blogCategory(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogCategoriesMap.php");
	$blogCatMapObj = new blogCategoriesMap(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogRecommendedMap.php");
	$blogRecommendedMapObj = new blogRecommendedMap(false);	

	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUsers.php");
	$publicUsersObj = new publicUsers(false);		
?>



