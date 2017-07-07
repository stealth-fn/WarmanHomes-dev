<?php
	#GALLERY NAME
	if(array_key_exists("gn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["gn"] = 
		'<div 
			class="gn gn-'. $priModObj[0]->className .'"
			id="gn-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["galleryName"] . '</div>';
	}
		
	#IMAGES
	if(array_key_exists("galImg",$priModObj[0]->domFields)){
		#put child module into output buffer
		ob_start();
		$recursivePmpmID = $priModObj[0]->imagePmpmID;
		$priModObj[0]->galleryID = $priModObj[0]->queryResults["priKeyID"];
		
		include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");
		$priModObj[0]->domFields["galImg"] = ob_get_contents();
		ob_end_clean();
	}
	elseif(array_key_exists("galImg",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["galImg"] = '<div class="mfmc"></div>';
	}
	#GALLERY IMAGE PAGE LINK
	if(array_key_exists("galIp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["galIp"] = '
		<a
			class="galIp galIp-'. $priModObj[0]->className.' sb adminLstLnk"
			href="/index.php?pageID='. $priModObj[0]->imageListPageID.'"&amp;parentPriKeyID='. $priModObj[0]->queryResults["priKeyID"].'
			id="galIp-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  
			onclick="atpto_adminTopNav.toggleBlind(\''. $priModObj[0]->imageListPageID.'\',\''. $priModObj[0]->imageListPageID.'\',\'upc('. $priModObj[0]->imageListPageID.',\\\'&amp;parentPriKeyID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_adminTopNav-'. $priModObj[0]->imageListPageID.'\',event);return false"
		>'. $priModObj[0]->imageLinkText.'</a>';
	}
?>