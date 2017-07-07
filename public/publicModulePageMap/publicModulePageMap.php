<?php
	$priModObj[0]->domFields["pmpmDsc"] = 
	'<div 
		class="pmpmDsc_'. $priModObj[0]->className .'"
		id="pmpmDsc_'. $priModObj[0]->className.'_'. $priModObj[0]->queryResults["priKeyID"].'"
	>' . $priModObj[0]->queryResults["instanceDesc"] . '</div>';
?>