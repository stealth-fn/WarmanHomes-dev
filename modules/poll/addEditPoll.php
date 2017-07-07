<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/poll.php");
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollOption.php");
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollSubOption.php");
	
	$moduleObj = new poll(false);
	$pollOptionObj = new pollOption(false);
	$pollSubOptionObj = new pollSubOption(false);
		
	if(isset($_POST["recordID"])){
		$pollOptions = $pollOptionObj->getConditionalRecord(array("pollID",$_POST["recordID"],true));
		$pollSubOptions = $pollSubOptionObj->getConditionalRecord(array("pollID",$_POST["recordID"],true));
	}
	
	include($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include($_SERVER['DOCUMENT_ROOT']."/modules/poll/addEditForm.php");
?>