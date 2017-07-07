<?php
	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/calendar/calendarEvents.php");
	$moduleObj = new calendarEvent(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/moduleAddEdit.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/modules/calendarEvents/addEditForm.php");	
?>