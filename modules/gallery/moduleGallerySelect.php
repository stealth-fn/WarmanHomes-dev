<?php
	/*INCLUDE THIS FILE WHERE YOU NEED A GALLERY DROP DOWN TO MAP TO THE MODULE*/
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/gallery.php");
	$galleryObj = new gallery(false);

	#only query once, if we're in bulk add/edit
	if(!isset($modGalleries)) {
		$modGalleries = $galleryObj->getAllRecords();
	}
	
	echo '<select id="galleryID' . $_REQUEST["recordID"] . '" name="galleryID">';
	
	while($x = mysqli_fetch_array($modGalleries)){
		
		#$tempModMapID should be the galleryID mapped to the module which calls this includes
		if($tempModMapID == $x["priKeyID"]){
			$tempSelectedString = 'selected="selected"';
		}
		else{
			$tempSelectedString = "";
		}
		
		echo "<option 
				value=" . $x["priKeyID"] . " 
				" . $tempSelectedString . "
			>" 
			. $x["galleryName"] . 
			"</option>";
		
	}
	
	echo "</select>";
	
	#reset query pointed to reuse it
	if(mysqli_num_rows($modGalleries) > 0) {
		mysqli_data_seek($modGalleries,0);
	}
?>