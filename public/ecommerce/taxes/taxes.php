<?php

	#Tax Description/Name

	if(array_key_exists("txd",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["txd"] = 

		'<div 

			class="txd_'. $priModObj[0]->className .'"

			id="txd_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"

		>' . $priModObj[0]->queryResults["taxDesc"] . '</div>';

	}

	

	#Percentage Amount

	if(array_key_exists("txa",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["txa"] = 

		'<div 

			class="txa_'. $priModObj[0]->className .'"

			id="txa_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"

		>' . $priModObj[0]->queryResults["taxAmount"] . '%</div>';

	}

	

	#Whether this tax is applied to shipping

	if(array_key_exists("txshp",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["txshp"] = 

		'<div 

			class="txshp_'. $priModObj[0]->className .'"

			id="txshp_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"

		>Tax Shipping:' . 

			($priModObj[0]->queryResults["shipTax"]==1 ? "Yes" : "No") . 

		'</div>';

	}

?>