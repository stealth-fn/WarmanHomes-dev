<?php 
	#stealth DOM framework
	if($priModObj[0]->isTemplate == 0 || $priModObj[0]->isTemplate == 1){
		$modContents = $priModObj[0]->getModuleContents(
			$_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFrame.php",
			$priModObj[0]->priKeyID,$pageInfo
		);		
	}
	#regular DOM file
	elseif($priModObj[0]->isTemplate == 2 || $priModObj[0]->isTemplate == 3){
		$modContents = $priModObj[0]->getModuleContents(
			$_SERVER['DOCUMENT_ROOT'].$priModObj[0]->includeFile,
			$priModObj[0]->priKeyID,$pageInfo
		);
	}
	
	#if we're using a short code
	if(isset($pageInfo) && strpos($pageInfo['pageCode'], "pmpmID" . $pMod["priKeyID"]) !== false){
		
		#replace the short code with the module
		$pageInfo['pageCode'] = $modContents;
	}
	else {
		#appears after pageText
		if($pMod["beforeAfter"]==1) {
			$afterModuleCode .= $modContents;
		}
		#appears before pageText
		else{
			$beforeModuleCode .= $modContents;
		}
	}

	if(
		$priModObj[0]->isTemplate == 0 && $priModObj[0]->isTemplate == 1 &&
		$priModObj[0]->isTemplate == 2 && $priModObj[0]->isTemplate == 3
	){
		echo "isTemplate not set in modules table";
	}

	if(!isset($_GET["moduleStyles"])) {
		$_GET["moduleStyles"] = "";
	}
	
	#if it's an add/edit module, get the default form styling
	if($priModObj[0]->isTemplate == 0){
		ob_start();
		include($_SERVER['DOCUMENT_ROOT']."/css/addEditForm.php");
		$_GET["moduleStyles"] .= ob_get_contents();
		ob_end_clean();
	}

	/*bulk add/edit styles - don't get child/recursive module 
	styles, just put them with the parent instance*/
	if(count($priModObj) == 1) {
		if(isset($priModObj[0]->bulkMod)) {
			$_GET["moduleStyles"] .= $priModObj[0]->get_include_contents(
				$_SERVER['DOCUMENT_ROOT'].'/css/bulkAddEdit.css'
			);
		}
		#styles for the module
		else{
			ob_start();
			if(strlen($priModObj[0]->cssLink) > 0){
				include($_SERVER['DOCUMENT_ROOT'].$priModObj[0]->cssLink);
			}
			
			#load in rating system styles
			if($priModObj[0]->hasRating == 1){
				include_once($_SERVER['DOCUMENT_ROOT']."/css/js/rating/jquery.rating.css");
			}
			
			$_GET["moduleStyles"] .= ob_get_contents();
			ob_end_clean();
			
			#if we're loading up a form for a quick edit
			if(
				$priModObj[0]->isTemplate == 0 &&
				isset($_REQUEST["pmpmID"]) &&
				is_numeric($_REQUEST["recordID"])
			){
				$_GET["moduleStyles"] .= $priModObj[0]->get_include_contents(
					$_SERVER['DOCUMENT_ROOT']."/css/addEditForm.php"
				);
			}
		}
	}
?>