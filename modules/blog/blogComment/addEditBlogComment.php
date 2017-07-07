<?php 
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogComment.php");
	$moduleObj = new blogComment(false,$_REQUEST["parentPriKeyID"]);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blog.php");
	$blogObj = new blog(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUsers.php");
	$publicUsersObj = new publicUsers(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/blog/blogComment/addEditForm.php");
?>