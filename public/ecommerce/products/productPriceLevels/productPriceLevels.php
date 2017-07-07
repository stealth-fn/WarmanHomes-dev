<?php
	#Price Level Description
	$priModObj[0]->domFields["pld"] = 
	'<div 
		class="pld_'. $priModObj[0]->className .'"
		id="pld_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"
	>' . $priModObj[0]->queryResults["priceLevelDesc"] . '</div>';
	
	#Level Percentage
	$priModObj[0]->domFields["lp"] = 
	'<div 
		class="lp_'. $priModObj[0]->className .'"
		id="lp_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"
	>' . $priModObj[0]->queryResults["levelPercentage"] . '%</div>';
?>