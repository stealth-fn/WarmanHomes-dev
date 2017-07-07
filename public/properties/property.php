<?php
	
	#OPEN WRAPPER
	if(array_key_exists("owrap",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["owrap"] = '
		<div
			class="owrap owrap-'. $priModObj[0]->className .'"
			id="owrap' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] .'" 	
		>';
	}
	
	#CLOSE WRAPPER
	if(array_key_exists("cwrap",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["cwrap"] = '
		</div>';
	}

	#Property Name
	if(array_key_exists("propertyName",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["propertyName"] = '
		<div 
			class="propertyName propertyName-' . $priModObj[0]->className . '" 
			id="propertyName-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			' . htmlspecialchars($priModObj[0]->queryResults["propertyName"]) .'
		</div>';
	}
	
	#ADRESS
	if(array_key_exists("address",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["add"] = '
		<div 
			class="add add-' . $priModObj[0]->className . '" 
			id="add-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			' . htmlspecialchars($priModObj[0]->queryResults["address"]) .'
		</div>';
	}
	
	#City, Prov
	if(array_key_exists("cityProv",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["cityProv"] = '
		<div 
			class="cityProv cityProv-' . $priModObj[0]->className . '" 
			id="cityProv-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			' . htmlspecialchars($priModObj[0]->queryResults["cityProv"]) .'
		</div>';
	}
	
	#COMPLETE ADDRESS
	if(array_key_exists("completeAddress",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["comAdd"] = '
		<div 
			class="comAdd comAdd-' . $priModObj[0]->className . '" 
			id="comAdd-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			' . htmlspecialchars($priModObj[0]->queryResults["address"]) . ' - ' . htmlspecialchars($priModObj[0]->queryResults["completeAddress"]) .', SK
		</div>';
	}
	
	#MAP WITH PINNED LOCATIONS OF ALL PROPERTIES 
	if(array_key_exists("multiMap",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["comAdd"] = '
		<div id="googleMultiMap" style="width:100%;min-height:380px;"></div>';
	}
	
	#MAP OF ONLY SINGLE SELECTED PROPERTY 
	if(array_key_exists("singleMap",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["comAdd"] = '
		<div id="googleMap" style="width:100%;min-height:380px;"></div>';
	}
	
	#MORE DETAILS - Bedroom / Bathroom / Price
	if(array_key_exists("moreInfo",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["moreInfo"] = '
		<div 
			class="moreInfo moreInfo-' . $priModObj[0]->className . '" 
			id="moreInfo-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			' ;
			if ($priModObj[0]->queryResults["numOfBedrooms"] == 0) {
					$priModObj[0]->domFields["moreInfo"] .= '<div class="bedroom">Bachelor</div>';
			}
			else {
					$priModObj[0]->domFields["moreInfo"] .= '<div class="bedroom">'. htmlspecialchars($priModObj[0]->queryResults["numOfBedrooms"]) . '</div>';
			}
			$priModObj[0]->domFields["moreInfo"] .= '<div class="bathroom">'. htmlspecialchars($priModObj[0]->queryResults["numOfBathrooms"]) . '</div>';
			$priModObj[0]->domFields["moreInfo"] .= '<div class="price">$'. htmlspecialchars($priModObj[0]->queryResults["price"]) . '/'. htmlspecialchars($priModObj[0]->queryResults["propertyPayType"]) .'</div>';
			$priModObj[0]->domFields["moreInfo"] .='</div>';
	}
	
	#number of bedrooms 
	if(array_key_exists("bedrooms",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["bedrooms"] = '
		<div class="hpsku hpsku-' . $priModObj[0]->className .'"> 
			' . htmlspecialchars($priModObj[0]->queryResults["numOfBedrooms"]) .'
		</div>';
	}
	
	#VIEW Property Description BUTTON
	if(array_key_exists("vpd",$priModObj[0]->domFields)){
		$urlString = 'atpto_tNav.toggleBlind(\''.$priModObj[0]->propertyDetailPageID.'\',0,\'upc('.$priModObj[0]->propertyDetailPageID.',&#34;pmpm%3D(%22'.$priModObj[0]->detailPmpmID.'%22%3A(%22propertyID%22%3A%22'.$priModObj[0]->queryResults["priKeyID"].'%22))&#34;);\',\'ntid_tNav-'.$priModObj[0]->propertyDetailPageID.'\',event);return false';
		#print_r($priModObj[0]);
		$priModObj[0]->domFields["vpd"] = '				
		<div class="vpd vpd-'. $priModObj[0]->className.'"><a
			class="vpd vpd- sb" 
				href="index.php?pageID='.$priModObj[0]->propertyDetailPageID.'&amp;pmpm={\''.$priModObj[0]->detailPmpmID.'\':{\'propertyID\':\''. $priModObj[0]->queryResults["priKeyID"] . '\'}}"
				id="vpd-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'" 
				onclick="'.$urlString .'"
		>
			'. $priModObj[0]->viewPropBtnText.'
		</a></div>';
	}
		
	#APPLY NOW BTN
	if(array_key_exists("appBtn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["appBtn"] = '				
		<div class="applyBtnWrapper"><div class="btn center"><a
			class="applyBtn" 
			href="/index.php?pageID=2478&amp;propertyID='. $priModObj[0]->queryResults["priKeyID"].'" 
			id="appBtn-'. $priModObj[0]->className.'-'.$priModObj[0]->queryResults["priKeyID"].'" 
			onclick="atpto_tNav.toggleBlind(\'2478\',0,\'upc(2478,\\\'propertyID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_tNav-2478\',event);return false"
			
		>Apply Now
		</a></div><span>Apply online for this suite.</span></div>';
	}
	
	#WRAP ALL PRODUCT DOM ELEMENTS IN FORM
	if(array_key_exists("pfc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pfc"] = '</form>';
	}
	
	#Back Button
	if(array_key_exists("backBtn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["backBtn"] = '				
		<div class="backLink"><a href="/Properties" onclick="goBack(); return false"><img src="/images/Property-Arrow.png" width="6" height="9" alt=""/>Back</a></div>';
	}
	
	#WRAP ALL PRODUCT DOM ELEMENTS IN FORM
	if(array_key_exists("pfc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pfc"] = '</form>';
	}
	
	
#PROPERTY DESCRIPTION
	if(array_key_exists("propertyDescription",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["prdc"] = '<div class="descriptionWrapper"><div class="prdc prdc-'. $priModObj[0]->className.'">';
		$priModObj[0]->domFields["prdc"] .= $priModObj[0]->queryResults["propertyDesc"];
		$priModObj[0]->domFields["prdc"] .= '</div>';
	}
	
	
#SHORT ABOUT
	if(array_key_exists("shortAbout",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["shortAbout"] = 
		'<div 
			class="shortAbout shortAbout-' . $priModObj[0]->className . '" 
			id="shortAbout-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			' ;
			$priModObj[0]->domFields["shortAbout"] .= '<div class="building">'. htmlspecialchars($priModObj[0]->queryResults["propertyName"]) . '</div>';
			$priModObj[0]->domFields["shortAbout"] .= '<div class="cityProv">'. htmlspecialchars($priModObj[0]->queryResults["cityProv"]) . '</div>';
			if ($priModObj[0]->queryResults["numOfBedrooms"] == 0) {
					$priModObj[0]->domFields["shortAbout"] .= '<div class="bedroom">Bachelor</div>';
			}
			else {
					$priModObj[0]->domFields["shortAbout"] .= '<div class="bedroom">'. htmlspecialchars($priModObj[0]->queryResults["numOfBedrooms"]) . '</div>';
			}
			$priModObj[0]->domFields["shortAbout"] .= '<div class="bathroom">'. htmlspecialchars($priModObj[0]->queryResults["numOfBathrooms"]) . '</div>';
			$priModObj[0]->domFields["shortAbout"] .= '<div class="vpd vpd-'. $priModObj[0]->className.'"><a
			class="vpd vpd- sb" 
				href="index.php?pageID=2465&amp;pmpm={\'369\':{\'propertyID\':\''. $priModObj[0]->queryResults["priKeyID"] . '\'}}"
				id="vpd-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'" 
				onclick="atpto_tNav.toggleBlind(\'2481\',0,\'upc(2481,&#34;pmpm={\\\'369\\\':{\\\'propertyID\\\':\\\''. $priModObj[0]->queryResults["priKeyID"] . '\\\'}}&#34;);\',\'ntid_tNav-2481\',event);return false"
		><img alt="Houses for rent Saskatoon" class="titleBanner" src="/images/Property-Arrow.png" style="width: 9px height: 6px" />
			</a></div>';
			$priModObj[0]->domFields["shortAbout"] .='</div>';
	}
	
	#PROPERTY DISAPLAY CONTENT	
	if(array_key_exists("propertyDetails",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["propertyDetails"] = '<div class="propertyDetails propertyDetails-'. $priModObj[0]->queryResults["priKeyID"] .'">
			<table class="propertyDetails propertyDetails-'. $priModObj[0]->className.'">
				<tr>';
		$priModObj[0]->domFields["propertyDetails"] .= '<td>
			<div class="heading"><span class="propertyName left">'. htmlspecialchars($priModObj[0]->queryResults["propertyName"]) . '</span>
			<span class="cityProv left">'. htmlspecialchars($priModObj[0]->queryResults["cityProv"]) . '</span>';
		$priModObj[0]->domFields["propertyDetails"] .= '<div class="price right">$'. htmlspecialchars($priModObj[0]->queryResults["price"]) . '/'. htmlspecialchars($priModObj[0]->queryResults["propertyPayType"]) .'</div></div>';
		$priModObj[0]->domFields["propertyDetails"] .= '<div class="lineInfo"><div class="contactInfo">
			<span id="basicText">Call for more information</span>
			<span>'. htmlspecialchars($priModObj[0]->queryResults["contactPhone"]) . '</span>
			<span> '. htmlspecialchars($priModObj[0]->queryResults["contactName"]) . ' </span>
		</div>';
		$priModObj[0]->domFields["propertyDetails"] .= '<div class="lineRoom">
			<div class="bedroom">'. htmlspecialchars($priModObj[0]->queryResults["numOfBedrooms"]) . '</div>';
		$priModObj[0]->domFields["propertyDetails"] .= '<div class="bathroom">'. htmlspecialchars($priModObj[0]->queryResults["numOfBathrooms"]) . '</div>
			</div>
			<div class="backLink"><a href="/Search" onclick="goBack()"><img src="/images/Property-Arrow.png" width="6" height="9" alt=""/>Back</a></div>
			
			
			';
			$priModObj[0]->domFields["propertyDetails"] .= '</div>';
			#GALLERY
				if(isset($priModObj[0]->queryResults["imageGalleryID"]) &&
					is_numeric($priModObj[0]->queryResults["imageGalleryID"])
				){ 
					#put child module into output buffer
					ob_start();
					$recursivePmpmID = $priModObj[0]->galleryPmpmID;
					include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");
					$tmpGalCode = ob_get_contents();
					ob_end_clean();
					
					$priModObj[0]->domFields["propertyDetails"] .= $tmpGalCode;
				}
				elseif(array_key_exists("modGal",$priModObj[0]->domFields)){
					$priModObj[0]->domFields["propertyDetails"] .= '<div class="mfmc"></div>';
				}
				
		
		$priModObj[0]->domFields["propertyDetails"] .= '</td>';
		#Second Section
		$priModObj[0]->domFields["propertyDetails"] .= '<td>
			<div class="heading">
				<div class="propertyName">'. htmlspecialchars($priModObj[0]->queryResults["propertyName"]) . '</div>
				<div class="cityProv">'. htmlspecialchars($priModObj[0]->queryResults["cityProv"]) . '</div>
			</div>';
		$priModObj[0]->domFields["propertyDetails"] .= '<div 
			class="hplink gmap hplink-' . $priModObj[0]->className . '" 
			id="hplink-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			 <div id="googleSingleMap" style="width:100%;min-height:637px;"></div>
	
		</div>';
		$priModObj[0]->domFields["propertyDetails"] .= '</td>';
		$priModObj[0]->domFields["propertyDetails"] .= '</tr></table></div>';
		
	}
	
	
?>
