<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/channelList/channelList.php");
	$moduleObj = new channelList(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/channelList/addEditForm.php");	
?>