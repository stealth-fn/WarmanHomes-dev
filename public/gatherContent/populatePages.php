<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/gatherContent/gatherContent.php');
	$gatherContentObj = new gatherContent(false, 1);
	$projectList = $gatherContentObj->getProjects();
?>