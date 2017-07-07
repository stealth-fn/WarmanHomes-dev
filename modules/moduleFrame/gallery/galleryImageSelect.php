<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/galleryImages.php");
	$galleryImageObj = new galleryImage(false);
	
	#existing record
	if(is_numeric($priModObj[0]->displayInfo('imageGalleryID'))){
		$galleryImages = $galleryImageObj->getConditionalRecord(
			array("galleryID",$priModObj[0]->displayInfo('imageGalleryID'),true)
		);
	}
	#default from public_module_page_map
	elseif(is_numeric($priModObj[0]->defaultGalleryID)){
        $galleryImages = $galleryImageObj->getConditionalRecord(
            array("galleryID",$priModObj[0]->defaultGalleryID,true)
        );
    }
	#lists all of them
	else{
		$galleryImages = $galleryImageObj->getConditionalRecord(
			array("galleryID","stealth",true)
		);
	}

	while($x = mysqli_fetch_assoc($galleryImages)){
		if($x["priKeyID" ]== $priModObj[0]->displayInfo('galleryImageID')){
			echo "<option 
					value=" . $x["priKeyID"] . " 
					selected='selected' 
				>" 
				. $x["imgCaption"] . 
				"</option>";
		}
		else{
			echo "<option value=" . $x["priKeyID"] . ">" . $x["imgCaption"] . "</option>";
		}
	}
	
	mysqli_data_seek($galleryImages,0);
?>