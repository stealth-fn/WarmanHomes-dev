<?php
	#City Name
	if(array_key_exists("propertyCity",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["prcn"] = '
		<div 
			class="propertyCity propertyCity-' . $priModObj[0]->className . '" 
			id="propertyCity-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '">' . $priModObj[0]->queryResults["cityName"] .'
		</div>';
	}
	
	#PRODUCTS BELONG TO A CATEGORY
	if(array_key_exists("propertyCities",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["prbc"] = '
		<a
			class="propertyCities propertyCities-'. $priModObj[0]->className.' sb"
			href="/index.php?pageID=-160"&amp;prodCatID='. $priModObj[0]->queryResults["priKeyID"].'
			id="propertyCities-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  
			onclick="atpto_adminTopNav.toggleBlind(\'-160\',true,0,\'upc(-160,\\\'&amp;prodCatID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_adminTopNav--160\',event);return false"
		>Edit Products</a>';
	}
	
	#PRODUCTS BELONG TO A CATEGORY - for public side
	if(array_key_exists("pprbc",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pprbc"] = '
		<a
			class="pprbc pprbc-'. $priModObj[0]->className.' sb"
			href="/index.php?pageID=2462&amp;prodCatID='. $priModObj[0]->queryResults["priKeyID"].'
			" id="pprbc-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"  		
			onclick="atpto_tNav.toggleBlind(\'2462\',0,\'upc(2462,\\\'&amp;prodCatID='. $priModObj[0]->queryResults["priKeyID"].'\\\');\',\'ntid_tNav-2462\',event);return false"
		>'. $priModObj[0]->queryResults["categoryName"] .'</a>';
	}
?>

