<?php
	#CATEGORY CHILDREN LINK
	if(array_key_exists("chcat",$priModObj[0]->domFields)){	
		$priModObj[0]->domFields["chcat"] = '
		
		<a
		class="chcat chcat-'. $priModObj[0]->className.' sb"
		href="/index.php?pageID='. $priModObj[0]->pageID .'&prodCatID='. $priModObj[0]->queryResults["priKeyID"].'" 
		id="chcat-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'" 
		onclick="atpto_tNav.toggleBlind(\''. $priModObj[0]->pageID .'\',true,0,\'upc('. $priModObj[0]->pageID .',\\\'prodCatID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_tNav-' . $priModObj[0]->pageID . '\',event);return false"
	>'.$priModObj[0]->queryResults["categoryName"].'</a>';
	}
	
	#CATEGORY NAME
	if(array_key_exists("prcn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["prcn"] = '
		<div 
			class="prcn prcn-' . $priModObj[0]->className . '" 
			id="prcn-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">' . $priModObj[0]->queryResults["categoryName"] .'
		</div>';
	}
	
	#CATEGORY DESCRIPTION
	if(array_key_exists("prcd",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["prcd"] = '
		<div 
			class="prcd prcd-' . $priModObj[0]->className . '" 
			id="prcd-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">' . $priModObj[0]->queryResults["categoryDescription"] .'
		</div>';
	}
	
	#PRODUCTS
	if(
		array_key_exists("prcpl",$priModObj[0]->domFields) &&
		isset($priModObj[0]->instanceProductListID) &&
		is_numeric($priModObj[0]->instanceProductListID)
	){
		#put child module into output buffer
		ob_start();
		$recursivePmpmID = $priModObj[0]->instanceProductListID;
		$priModObj[0]->prodCatID = $priModObj[0]->queryResults["priKeyID"];
		include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");
		$tmpProdCode = ob_get_contents();
		ob_end_clean();
		
		$priModObj[0]->domFields["prcpl"] = $tmpProdCode;
	}
	elseif(array_key_exists("prcpl",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["prcpl"] = '<div class="mfmc"></div>';
	}
	
	#SUB-CATEGORIES
	if(
		array_key_exists("prsub",$priModObj[0]->domFields) &&
		isset($priModObj[0]->instanceProductListID) &&
		is_numeric($priModObj[0]->instanceProductListID)
	){
		#put child module into output buffer
		ob_start();
		$recursivePmpmID = $priModObj[0]->instanceSubCatID;
		$priModObj[0]->parentCatID = $priModObj[0]->queryResults["priKeyID"];
		include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");
		$tmpProdCode = ob_get_contents();
		ob_end_clean();
		
		$priModObj[0]->domFields["prsub"] = $tmpProdCode;
	}
	elseif(array_key_exists("prsub",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["prsub"] = '<div class="mfmc"></div>';
	}
			
	#BODY
	if(array_key_exists("pbody",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pbody"] = 
		'<div 
			class="prdCatBody prdCatBody-'.$priModObj[0]->className.'"
			id="prdCatBody'.$priModObj[0]->className.'-'.$priModObj[0]->queryResults["priKeyID"].'"
		>';
		
		if($priModObj[0]->copyTrim > 0){
			#strip tags from preview text
			$copyText = strip_tags($priModObj[0]->queryResults["categoryCopy"]);
			
			#we don't want to truncate in the middle of a word
			while(
				$priModObj[0]->copyTrim > 0 &&
				$priModObj[0]->copyTrim < $copyText &&
				isset($copyText[$priModObj[0]->copyTrim]) &&
				$copyText[$priModObj[0]->copyTrim] != " "

			){
				$priModObj[0]->copyTrim--;
			}
			
			if(strlen($copyText) > $priModObj[0]->copyTrim){
				$copyText = substr($copyText,0,$priModObj[0]->copyTrim).'...';
			}
			
			$priModObj[0]->domFields["pbody"] .= $copyText;
			
		} 
		else{
			$copyText = $priModObj[0]->queryResults["categoryCopy"];
			$priModObj[0]->domFields["pbody"] .= $priModObj[0]->queryResults["categoryCopy"];
		}

		$priModObj[0]->domFields["pbody"] .= 
		'</div>';
	}
	
	#PRODUCTS BELONG TO A CATEGORY
	if(array_key_exists("prbc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["prbc"] = '
		<a
			class="prbc prbc-'. $priModObj[0]->className.' sb"
			href="/Store%20Products?&amp;pmpm=(%27-1105%27:(%27prodCatID%27:%27'.$priModObj[0]->queryResults["priKeyID"].'%27))"
			id="prbc-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"';  
			$priModObj[0]->domFields["prbc"] .= "
				onclick=\"atpto_adminTopNav.toggleBlind('-102',0,'upc(-102,&#34;pmpm=(%27-1105%27:(%27prodCatID%27:%27".$priModObj[0]->queryResults["priKeyID"]."%27))&#34;)','ntid_adminTopNav-102',event);return false\" 
			";
	
			$priModObj[0]->domFields["prbc"] .= '>Edit Products</a>' ;
	
	}
?>

