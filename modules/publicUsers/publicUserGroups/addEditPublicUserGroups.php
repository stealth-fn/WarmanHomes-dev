<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUsers.php");
	$publicUsersObj = new publicUsers(false);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroupMap.php");
	$publicUserGroupMapObj = new publicUserGroupMap(false);
?>