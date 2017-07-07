<?php
	#Public User Group Name
	if(array_key_exists("gn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["gn"] = 
		'<div 
			class="gn-'. $priModObj[0]->className .'"
			id="gn-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["groupDesc"] . '</div>';
	}
?>