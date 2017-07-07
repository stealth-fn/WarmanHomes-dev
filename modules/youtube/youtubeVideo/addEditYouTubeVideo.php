<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/youtube/youtubeVideos.php");
	$moduleObj = new youtubeVideos(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/youtube/youtubeVideo/addEditForm.php");	
?>