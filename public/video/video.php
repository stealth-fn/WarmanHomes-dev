<?php		
	##NAME
	if(array_key_exists("vdname",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vdname"] =
		'<div 
			id="vn-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="vn vn-' . $priModObj[0]->className . '"
		>' . 
			$priModObj[0]->queryResults["videoName"] .
		'</div>';
	}
	else{
		$priModObj[0]->domFields["vdnameMeta"] ='
		<meta 
			itemprop="name" 
			content="' . htmlspecialchars($priModObj[0]->queryResults["videoName"]) . '"
		/>
		';
	}
	
	#Banner Text
	if(array_key_exists("vdbTxt",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vdbTxt"] =
		'<div 
			id="vbt-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="cover vbt vbt-' . $priModObj[0]->className . '"
		><div class="bannerTxt">' . 
			$priModObj[0]->queryResults["bannerTxt"] .
		'</div></div>';
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/gallery/galleryImages.php');
	$galleryImageObj = new galleryImage(false);
	$galleryImages = $galleryImageObj->getRecordByID(
		$priModObj[0]->queryResults["galleryImageID"]
	);
	$tmpImg = mysqli_fetch_assoc($galleryImages);
		
	#banner with img 
	if(array_key_exists("bnImg",$priModObj[0]->domFields)){
		
		#get alt attribute text
		if(strlen($tmpImg["imgCaption"]) > 0){
			$tmpAlt = htmlspecialchars($tmpImg["imgCaption"]);
		}
		else{
			$tmpAlt = $_SESSION["seoFolderName"];
		}
					
		$priModObj[0]->domFields["bnImg"] =
		'<div 
			id="bnImg-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="tv bnImg bnImg-' . $priModObj[0]->className . '"
		>';
		
		$priModObj[0]->domFields["bnImg"] .= '
		<img
			alt="'. $tmpAlt .'"
			src="/images/galleryImages/' . $priModObj[0]->queryResults["imageGalleryID"] . '/'.$priModObj[0]->imgPath. '/'. rawurlencode($tmpImg["fileName"]) .'" 
		/>';
		
		$priModObj[0]->domFields["bnImg"] .= '</div>';
	}
	
	#Complete Banner
	if(array_key_exists("banner",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["banner"] =
		'<div 
			id="banner-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="tv banner banner-' . $priModObj[0]->className . '"
		>';
		#only show the html5 videos on non-mobile devices
		#mobile detection script
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/mobileDetect/Mobile_Detect.php");
		$_SESSION["mobileDetect"] = new Mobile_Detect;
		
		# load video if it's desktop
		if(!$_SESSION["mobileDetect"]->isMobile()){
			$priModObj[0]->domFields["banner"] .= '<div id="tv" class="screen mute"></div>';
		}
		# load poster image if it's mobile
		else {
			$priModObj[0]->domFields["banner"] .= '
			<img
				alt="'. $priModObj[0]->queryResults["youtubeVidID"] .'"
				class="isMobile vidImg" 
				src="/images/galleryImages/' . $priModObj[0]->queryResults["imageGalleryID"] . '/'.$priModObj[0]->imgPath. '/'. rawurlencode($tmpImg["fileName"]) .'" 
			/>';
		}
		$priModObj[0]->domFields["banner"] .= '</div>';
	}
	
	#Videothumb Image
	if(array_key_exists("vidImg",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vidImg"] =
		'<div 
			id="vidImg-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="vidImg-' . $priModObj[0]->className . '"
		><img
		alt="'. $priModObj[0]->queryResults["youtubeVidID"] .'"
		src="https://i.ytimg.com/vi/'. $priModObj[0]->queryResults["youtubeVidID"] .'/maxresdefault.jpg"
	/></div>';
		$priModObj[0]->domFields["vidImg"] .= '<div class="overlay"></div>';
	}
?>