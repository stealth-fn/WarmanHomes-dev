<?php
	#Production Option Category Description
	if(array_key_exists("podc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["podc"] = 
		'<div 
			class="podc_'. $priModObj[0]->className .'"
			id="podc_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["productOptionCategoryDesc"] . '</div>';
	}
	
	#PRODUCTS BELONG TO AN OPTION
	#if(array_key_exists("prbo",$priModObj[0]->domFields)){
		#$priModObj[0]->domFields["prbo"] = '
		#<a
		#	class="prbo prbo-'. $priModObj[0]->className.' sb"
		#	href="/index.php?pageID=-160"&amp;prodOpt='. $priModObj[0]->queryResults["priKeyID"].'
		#	id="prbo-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  
		#	onclick="atpto_adminTopNav.toggleBlind(\'-160\',true,0,\'upc(-160,\\\'&amp;prodOpt='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_adminTopNav--160\',event);return false"
		#>Edit Products</a>';
	#}
?>