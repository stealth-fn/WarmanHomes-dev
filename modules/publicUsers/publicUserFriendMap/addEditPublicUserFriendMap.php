<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserFriendMap/publicUserFriendMap.php");
	$moduleObj = new publicUserFriendMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/publicUsers/publicUserFriendMap/addEditForm.php");	
?>