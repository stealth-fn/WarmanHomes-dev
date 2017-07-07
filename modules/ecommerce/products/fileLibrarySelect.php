<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibrary.php");
	$fileLibraryObj = new fileLibrary(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryProductMap.php");
	$fileLibraryProductMapObj = new fileLibraryProductMap(false);

	$libraryFiles = $fileLibraryObj->getAllRecords();
	$productFile = $fileLibraryProductMapObj->getConditionalRecord(array("productID",$_REQUEST["recordID"],true));
	$mappedFile = 0;
	
	#get the gallery for this product, if there is one
	while($x = mysqli_fetch_array($productFile)){
		$mappedFile = $x["fileLibraryID"];
	}

	while($x = mysqli_fetch_array($libraryFiles)){
		if($x["priKeyID"]== $mappedFile){
			echo "<option 
						value=" . $x["priKeyID"] . " 
						selected='selected' 
				>" 
				. $x["fileDesc"] . 
				"</option>";
		}
		else{
			echo "<option value=" . $x["priKeyID"] . ">" . $x["fileDesc"] . "</option>";
		}
	}
?>