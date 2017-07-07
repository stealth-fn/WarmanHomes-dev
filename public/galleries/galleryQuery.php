<?php
	#gallery is mapped to a module... ex product module
	if(isset($priModObj[1]) && isset($priModObj[1]->queryResults["imageGalleryID"])){ 
		$priModObj[0]->galleryID = $priModObj[1]->queryResults["imageGalleryID"];
	}

	#get specific gallery
	if(is_numeric($priModObj[0]->galleryID)) {
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array("image_gallery.priKeyID",$priModObj[0]->galleryID,true)
		);
	}

	#setup galleries based off info of first image
	$y = mysqli_fetch_assoc($priModObj[0]->primaryModuleQuery);
	#size type																
	if($priModObj[0]->imgSize == 0){
		 $priModObj[0]->imgSizePath = "thumb";
		 $priModObj[0]->imgSizeWidth = $y["thumbWidth"];
		 $priModObj[0]->imgSizeHeight = $y["thumbHeight"];
	}	
	elseif($priModObj[0]->imgSize == 1){
		 $priModObj[0]->imgSizePath = "medium";
		 $priModObj[0]->imgSizeWidth = $y["mediumWidth"];
		 $priModObj[0]->imgSizeHeight = $y["mediumHeight"];
	}
	elseif($priModObj[0]->imgSize == 2){
		 $priModObj[0]->imgSizePath = "large";
		 $priModObj[0]->imgSizeWidth = $y["largeWidth"];
		 $priModObj[0]->imgSizeHeight = $y["largeHeight"];
	}
	elseif($priModObj[0]->imgSize == 3){
		 $priModObj[0]->imgSizePath = "original";
		 $priModObj[0]->imgSizeWidth = "";
		 $priModObj[0]->imgSizeHeight = "";
	}
	
	#lightbox size type			
	if($priModObj[0]->lightbox){													
		if($priModObj[0]->lightboxImgSize == 0) $priModObj[0]->lightboxImgSizePath = "thumb";
		elseif($priModObj[0]->lightboxImgSize == 1) $priModObj[0]->lightboxImgSizePath = "medium";
		elseif($priModObj[0]->lightboxImgSize == 2) $priModObj[0]->lightboxImgSizePath = "large";
		elseif($priModObj[0]->lightboxImgSize == 3) $priModObj[0]->lightboxImgSizePath = "original";
	}
?>