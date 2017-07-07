<?php
#File Description
if(array_key_exists("fileDesc",$priModObj[0]->domFields)){
	ob_start();
?>
	<div 
		id="fileDesc-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
		class="fileDesc-<?php echo $priModObj[0]->className; ?>"
	 >
		<?php echo $priModObj[0]->queryResults['fileDesc'];?>
	</div>
<?php
	$priModObj[0]->domFields["fileDesc"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
#File Name
if(array_key_exists("fileName",$priModObj[0]->domFields)){
	ob_start();
?>
<div 
	id="fileName-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
	class="fileName-<?php echo $priModObj[0]->className;?>" 
>
	<?php echo $priModObj[0]->queryResults['fileName'];?>
</div>
<?php
	$priModObj[0]->domFields["fileName"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
#File Link
if(array_key_exists("fileLink",$priModObj[0]->domFields)){
	ob_start();
?>
	<a 
		href="/fileLibrary/<?php echo $priModObj[0]->queryResults['fileName']; ?>" 
		target="_blank"
		class="arrowLk"
	></a>
<?php
	$priModObj[0]->domFields["fileLink"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
#File Link in Lightbox
if(array_key_exists("fileLnkLbox",$priModObj[0]->domFields)){
	ob_start();
?>
	<a 
		id="fileLnkLbox-<?php echo $priModObj[0]->className . "-" . $priModObj[0]->queryResults['priKeyID'];?>" 
		class="fileLnkLbox-<?php echo $priModObj[0]->className;?> pdflink" 
		href="http://docs.google.com/gview?url=http://<?php echo $_SERVER['HTTP_HOST'];?>/fileLibrary/<?php echo $priModObj[0]->queryResults['fileName']; ?>&embedded=true"
	>Read More</a>
<?php
	$priModObj[0]->domFields["fileLnkLbox"] =  ob_get_contents();
	ob_end_clean();
}
?>

<?php
#EMBED CODE FOR PDF
if(array_key_exists("pdfLnk",$priModObj[0]->domFields)){
	$priModObj[0]->domFields["pdfLnk"] = '
	<div 
		class="pdfLnk pdfLnk-' . $priModObj[0]->className . '" 
		id="pdfLnk-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
		<div class="iframeCon">
		' . $priModObj[0]->queryResults["embedCode"] .'
	</div>
	</div>';
}


#Description
if(array_key_exists("description",$priModObj[0]->domFields)){
	$priModObj[0]->domFields["description"] = "";
	if(strlen($priModObj[0]->queryResults["description"]) > 0) {
		$priModObj[0]->domFields["description"] = '<div><span class="description">'.$priModObj[0]->queryResults["description"].'</span></div>';	
	}
}

#Category
if(array_key_exists("category",$priModObj[0]->domFields)){
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryCategory.php");
	$fileLibCatObj = new fileLibraryCategory(false,NULL);
	$fileLibCats = $fileLibCatObj->getAllRecords();
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryCatMap.php");
	$fileLibCatMapObj = new fileLibraryCatMap(false,NULL);
	
	#Subjects mapped to this File
	$mappedCats = $fileLibCatMapObj->getConditionalRecord(
		array("fileLibraryID",$priModObj[0]->displayInfo('priKeyID'),true)
	);
	$mappedCatIDList = $fileLibCatMapObj->getQueryValueString($mappedCats,"fileLibraryCategoryID",",");
	$mappedCatArray = explode(",",$mappedCatIDList);

	$priModObj[0]->domFields["category"] = "";

	if(mysqli_num_rows($fileLibCats) > 0){
		
		$priModObj[0]->domFields["category"] = "<div>";
		
		while($x = mysqli_fetch_assoc($fileLibCats)){
			if(in_array($x["priKeyID"],$mappedCatArray) !== false){
				$priModObj[0]->domFields["category"] .= '<span class="category">'.$x["fileCatDesc"].'</span> ';
			}
		}
		
		$priModObj[0]->domFields["category"] .= "</div>";
		
	}
}
?>
