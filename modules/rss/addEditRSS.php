<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/rss/rssChannel.php");
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/rss/rssItem.php");
	$moduleObj = new rssChannel(false);	
	
	if(isset($_POST["recordID"])){	
		$rssItemObj = new rssItem(false);
		$rssChannel = $moduleObj->getRecordByID($_POST["recordID"]);
		$rssItems = $rssItemObj->getConditionalRecord(array("rssChannelID",$_POST["recordID"],true));
	}
	
	include($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include($_SERVER['DOCUMENT_ROOT']."/modules/rss/addEditForm.php");
?>

