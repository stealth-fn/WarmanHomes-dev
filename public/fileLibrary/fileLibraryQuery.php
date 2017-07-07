<?php
include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibrary.php");
$fileObj = new fileLibrary(false,NULL);
	
include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryCategory.php");
$fileCategoryObj = new fileLibraryCategory(false,NULL);
	
#Note - This file has been modified for SHRF, If you need to use it on other sites<br>
# do your adjustments, Fateme
if(isset($priModObj[0]->fileCatID)) {
	
	$catFileIDList = "";
	if(isset($priModObj[0]->fileCatID)){
		$catFileIDList .= $fileCategoryObj->getAllCategoryFiles(
				$priModObj[0]->fileCatID
			);
	}
	
	$startDate = date("Y-n-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
	
	// List upcomings
	if(isset($priModObj[0]->priKeyID) && ($priModObj[0]->priKeyID == 415 || $priModObj[0]->priKeyID == 416)) {
			
		$priModObj[0]->primaryModuleQuery = $fileObj->getConditionalRecordFromList(
			array(
				"priKeyID",$catFileIDList,true,
				"meetingDate",$startDate,"greatEqual",
				"meetingDate","ASC"
			)
		);
	} 
	// Archive
	else {		
		$priModObj[0]->primaryModuleQuery = $fileObj->getConditionalRecordFromList(
			array(
				"priKeyID",$catFileIDList,true,
				"meetingDate",$startDate,"less",
				"meetingDate","ASC"
			)
		);
	}
}

if(isset($priModObj[0]->searchParams)){
	$priModObj[0]->primaryModuleQuery = $priModObj[0]->lessonSearch(
		$priModObj[0]->searchParams
	);
}
?>