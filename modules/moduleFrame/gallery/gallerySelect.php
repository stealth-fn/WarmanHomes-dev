<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/gallery.php");
	$galleryObj = new gallery(false);

	#only query once, if we're in bulk add/edit
	if(!isset($modGalleries)) {
		#user can only pick from one gallery
		if(isset($priModObj[0]->defaultGalleryID) && is_numeric($priModObj[0]->defaultGalleryID)){
			$modGalleries = $galleryObj->getRecordByID($priModObj[0]->defaultGalleryID);
		}
		#get all galleries by default
		else{
			$modGalleries = $galleryObj->getConditionalRecord(
				array("galleryName","ASC")
			);
		}
	}
	
	while($x = mysqli_fetch_array($modGalleries)){
		if(
			#user specified gallery
			$x["priKeyID" ] == $priModObj[0]->displayInfo('imageGalleryID') || 
			#module instance default
			$x["priKeyID" ] == $priModObj[0]->defaultGalleryID
		){
			echo "<option 
					value=" . $x["priKeyID"] . " 
					selected='selected' 
				>" 
				. $x["galleryName"] . 
				"</option>";
		}
		else{
			echo "<option value=" . $x["priKeyID"] . ">" . $x["galleryName"] . "</option>";
		}
	}
	
	#reset query pointed to reuse it
	if(mysqli_num_rows($modGalleries) > 0) {
		mysqli_data_seek($modGalleries,0);
	}
?>