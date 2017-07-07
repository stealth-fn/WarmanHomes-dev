<?php

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/gallery.php");

	$galleryObj = new gallery(false);

	

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogGalleryMap.php");

	$productGalleryMapObj = new blogGalleryMap(false);



	$galleries = $galleryObj->getAllRecords();

	$blogGallery = $blogGalleryMapObj->getConditionalRecord("blogID",$_REQUEST["recordID"],true);

	$mappedGallery = 0;

	

	#get the gallery for this product, if there is one

	if(mysqli_num_rows($blogGallery) > 0){

		while($x = mysqli_fetch_array($blogGallery)){

			$mappedGallery = $x["galleryID"];

		}

	}



	while($x = mysqli_fetch_array($galleries)){

		if($x["priKeyID"]== $mappedGallery){

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

?>