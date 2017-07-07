<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogTag.php");
	$moduleObj = new blogTag(false);
		
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/blog/blogTag/addEditForm.php");	
?>