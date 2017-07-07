<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/gallery.php");
	$galleryObj = new gallery(false);
	$galleries = $galleryObj->getAllRecords();

	while($x = mysqli_fetch_assoc($galleries)){
		if($x["priKeyID" ]== $priModObj[0]->displayInfo('imageGalleryID')){
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
	
	mysqli_data_seek($galleries,0);
?>