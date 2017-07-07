<?php

	#Fee Description
	if(array_key_exists("Fee Description",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Fee Description"] = 
		'<div 
			class="description_'. $priModObj[0]->className .'"
			id="description_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["description"] . '</div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Fee Descriptio"] = "";
	}

	#Fee 
	if(array_key_exists("Price",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Price"] = 
		'<div 
			class="price_'. $priModObj[0]->className .'"
			id="price_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"
		>Price: $' . $priModObj[0]->queryResults["price"] . '</div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Price"] = "";
	}


?>