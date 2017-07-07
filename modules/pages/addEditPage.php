<?php	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroupPageMap.php");
	$publicUserGroupPageMapObj = new publicUserGroupPageMap(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroups.php");
	$publicUserGroupObj = new publicUserGroup(false);
?>