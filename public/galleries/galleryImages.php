<?php
	#GALLERY IMAGE
	if(array_key_exists("img",$priModObj[0]->domFields)){		

		if(isset($priModObj[0]->lightbox) && $priModObj[0]->lightbox){
			$lightBoxOpen = '
			<a
				class="fancyBoxLink"
				data-fancybox-group="gallery' .$priModObj[0]->className . "_" . $priModObj[0]->queryResults["galleryID"] .'"
				href="/images/galleryImages/'.  $priModObj[0]->queryResults["galleryID"] . "/" . $priModObj[0]->lightboxImgSizePath . "/" . rawurlencode($priModObj[0]->queryResults["fileName"]) .'" 
				title="' . $priModObj[0]->queryResults["imgCaption"] .'" 
			>';
			$lightClose = '</a>';
		}
		else{
			$lightBoxOpen = '';
			$lightClose = '';
		}		

		$priModObj[0]->domFields["img"] =
		$lightBoxOpen . '
		<img 
			alt="'. strip_tags($priModObj[0]->queryResults["imgCaption"]) .'"
			class="gimg gimg-'. $priModObj[0]->className .'" 
			id="gimg-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
			src="/images/galleryImages/' . $priModObj[0]->queryResults["galleryID"] . "/" . $priModObj[0]->imgSizePath . "/" . rawurlencode($priModObj[0]->queryResults["fileName"]) .'" 
		/>' . $lightClose;
	}

	#IMAGE CAPTION
	if(array_key_exists("icp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["icp"] =
		'<div 
			class="icp icp-'. $priModObj[0]->className . '" 
			id="icp-'. $priModObj[0]->className .'-'. $priModObj[0]->queryResults["priKeyID"] .'"
		>
			' . $priModObj[0]->queryResults["imgCaption"] .'
		</div>';
	}
	
	#IMAGE DESCRIPTION
	if(array_key_exists("idc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["idc"] =
		'<div 
			class="idc idc-'. $priModObj[0]->className .'"
			id="idc-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'" 
		>
			' . $priModObj[0]->queryResults["imgDesc"] .'
		</div>';
	}


	#IMAGE COPY CONTENT
	if(array_key_exists("cnt",$priModObj[0]->domFields)){		

		if($priModObj[0]->copyLen > 0) {			
			$tempCopy = strip_tags(
				substr($priModObj[0]->queryResults['imageCopy'],0,$priModObj[0]->copyLen)
			);
		}
		else {
			$tempCopy = $priModObj[0]->queryResults["imageCopy"];
		}		

		$priModObj[0]->domFields["cnt"] =
		'<div class="icc icc-' . $priModObj[0]->className .'">
			' . $tempCopy . '
		</div>';
	}
?>

<?php
   
   #UPC Update in the CMS
   if(array_key_exists("linkP",$priModObj[0]->domFields)){
	   
	    include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
  		$pagesObj = new pages(false);
  		$galLinkPage = $pagesObj->getRecordByID($priModObj[0]->queryResults["linkPageID"]);
  		$glp = mysqli_fetch_assoc($galLinkPage);
  ?>
    <a 
     class="featuredLink"
     title="<?php echo $priModObj[0]->queryResults["imgCaption"]; ?>" 
     onclick="atpto_tNav.toggleBlind(<?php echo $priModObj[0]->queryResults["linkPageID"]; ?>,0,'upc(<?php echo $priModObj[0]->queryResults["linkPageID"]; ?>,&quot;galleryImageID=<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>&quot;)',this,event);return false;"
    >
    </a>
  <?php
   }
  ?>
