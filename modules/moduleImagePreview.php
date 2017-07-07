<?php

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/gallery/galleryImages.php");

	$galleryImageObj = new galleryImage(false);

	#get priKeyID for the last inserted gallery image

	$galleryImgQuery = $galleryImageObj->getConditionalRecord(array("priKeyID",$_REQUEST['galleryImageID'],true));

	while($x = mysqli_fetch_array($galleryImgQuery)){

		echo "<img 

				src='/images/galleryImages/".$_REQUEST['parentModuleID'].$_REQUEST['parentModuleName']."/medium/".$x['fileName']."'

				alt='module image'

			  />";

		echo "<input 

				id='galleryImageID'

				name='galleryImageID'

				type='hidden'

				value='".$x['priKeyID']."'

			  />";

	}

?>