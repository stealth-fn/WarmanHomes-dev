<?php
	if(!isset($_SESSION))session_start();

	#the gallery ID from the parent module query
	if(isset($priModObj[1]) && isset($priModObj[1]->queryResults["galleryID"])){ 
		$priModObj[0]->galleryID = $priModObj[1]->queryResults["galleryID"];
		$priModObj[0]->parentPriKeyID = $priModObj[1]->queryResults["galleryID"];
	}
	#the gallery ID from the parent module object property
	elseif(isset($priModObj[1]) && isset($priModObj[1]->galleryID)){
		$priModObj[0]->galleryID = $priModObj[1]->galleryID;
		$priModObj[0]->parentPriKeyID = $priModObj[1]->galleryID;
	}
	/*going to the gallery images through the gallery module... 
	example on the admin side, going to the gallery, then listing the images*/
	elseif(isset($_REQUEST["parentPriKeyID"])){
		$priModObj[0]->galleryID = $_REQUEST["parentPriKeyID"];
		$priModObj[0]->parentPriKeyID = $_REQUEST["parentPriKeyID"];
	}
	elseif(isset($_REQUEST["galleryID"])){
		$priModObj[0]->galleryID = $_REQUEST["galleryID"];
		$priModObj[0]->parentPriKeyID = $_REQUEST["galleryID"];
	}
	elseif(isset($priModObj[0]->galleryID)){
        $priModObj[0]->galleryID = $priModObj[0]->galleryID;
		$priModObj[0]->parentPriKeyID = $priModObj[0]->galleryID;
    }
	#there is no galleryID, or the galleryID is 0
	else{
		$priModObj[0]->galleryID = 0;
		$priModObj[0]->parentPriKeyID = 0;
	}

	if(
		/*the images aren't a level 2 module, possibly pagination, 
		so we set some parameters manually*/
		!isset($priModObj[1]) ||
		/*if the galleryInstanceID for these images aren't the same as the level above, it's
		probably thumbnails. thumbnails could use a different instance than the main image
		so we need to change our parent module instance settings*/
		isset($priModObj[1]) && ($priModObj[1]->priKeyID != $priModObj[0]->galleryInstanceID)
	){

		#create a gallery object, it will set itself up wit the parameters we need
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/gallery.php");
		$tempGalObj = new gallery(false, $priModObj[0]->galleryInstanceID);
 
		#copy those parameters to our image object
		if(isset($tempGalObj->lightbox)){
			$priModObj[0]->lightbox = $tempGalObj->lightbox;
			$priModObj[0]->copyLen = $tempGalObj->copyLen;
		}

		if(
			(!isset($priModObj[0]->galleryID) || 
			(isset($priModObj[0]->galleryID) 
				&& (!is_numeric($priModObj[0]->galleryID) ||
				 $priModObj[0]->galleryID == 0
				)
			)) && isset($tempGalObj->galleryID)
		){
			$priModObj[0]->galleryID = $tempGalObj->galleryID;
			$priModObj[0]->parentPriKeyID = $tempGalObj->galleryID;
		}
		#$priModObj[0]->className .= $priModObj[0]->galleryID;

		#folder name/size in the image path															
		if($tempGalObj->imgSize == 0){
			 $priModObj[0]->imgSizePath = "thumb";
		}	
		elseif($tempGalObj->imgSize == 1){
			 $priModObj[0]->imgSizePath = "medium";
		}
		elseif($tempGalObj->imgSize == 2){
			 $priModObj[0]->imgSizePath = "large";
		}
		elseif($tempGalObj->imgSize == 3){
			 $priModObj[0]->imgSizePath = "original";
		}
		
		#we need to specify the folder the lightbox will use
		if($tempGalObj->lightbox){
			if($tempGalObj->lightboxImgSize == 0) $priModObj[0]->lightboxImgSizePath = "thumb";
			elseif($tempGalObj->lightboxImgSize == 1) $priModObj[0]->lightboxImgSizePath = "medium";
			elseif($tempGalObj->lightboxImgSize == 2) $priModObj[0]->lightboxImgSizePath = "large";
			elseif($tempGalObj->lightboxImgSize == 3) $priModObj[0]->lightboxImgSizePath = "original";
		}
		
		#unset it, otherwise we won't have the admin add/edit buttons
		unset($tempGalObj);
		
	}
	#we are using the $priModObj[1] for the gallery
	else{
		$priModObj[0]->lightbox = $priModObj[1]->lightbox;
		$priModObj[0]->copyLen = $priModObj[1]->copyLen;
		
		#folder name/size in the image path															
		if($priModObj[1]->imgSize == 0){
			 $priModObj[0]->imgSizePath = "thumb";
		}	
		elseif($priModObj[1]->imgSize == 1){
			 $priModObj[0]->imgSizePath = "medium";
		}
		elseif($priModObj[1]->imgSize == 2){
			 $priModObj[0]->imgSizePath = "large";
		}
		elseif($priModObj[1]->imgSize == 3){
			 $priModObj[0]->imgSizePath = "original";
		}
		
		#we need to specify the folder the lightbox will use
		if($priModObj[1]->lightbox){
			if($priModObj[1]->lightboxImgSize == 0) $priModObj[0]->lightboxImgSizePath = "thumb";
			elseif($priModObj[1]->lightboxImgSize == 1) $priModObj[0]->lightboxImgSizePath = "medium";
			elseif($priModObj[1]->lightboxImgSize == 2) $priModObj[0]->lightboxImgSizePath = "large";
			elseif($priModObj[1]->lightboxImgSize == 3) $priModObj[0]->lightboxImgSizePath = "original";

		}
	}

	#there may not be a gallery mapped to this module
	if(isset($priModObj[0]->galleryID)) {
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array(
				"galleryID",$priModObj[0]->galleryID,true,
				"domainID", $tmpLang, true
			)
		);

	}
?>
