<?php
	#PRODUCT NAME
	if(array_key_exists("vn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["vn"] = '
		<div 
			class="vn vn-' . $priModObj[0]->className . '" 
			id="vn-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">
			' . htmlspecialchars($priModObj[0]->queryResults["vendorName"]) .'
		</div>';
	}

	#link to another page
	if(array_key_exists("venLink",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["venLink"] = '
		<a
			class="vnb vnb-' . $priModObj[0]->className .'sb" 
			href="/index.php?pageID=' . $_GET["pageID"] .'&amp;vendID=' . $priModObj[0]->queryResults["priKeyID"] .'" 
			id="vnb-' . $priModObj[0]->className .'-' . $priModObj[0]->queryResults["priKeyID"] .'" 
			onclick="' .
				$priModObj[0]->createInstanceOnclick(
					$priModObj[0]->queryResults["priKeyID"],
					false,
					$_GET["pageID"]
				)
			 . 'return false" 		
		>
			'. $priModObj[0]->onclickBtnText .'
		</a>';
	}
?>

