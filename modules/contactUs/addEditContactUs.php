<?php
	# Fetch CMS Setting from DB
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings/cmsSettings.php");
		$cmsSettingsObj = new cmsSettings(false, NULL);
?>