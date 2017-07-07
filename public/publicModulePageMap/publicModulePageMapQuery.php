<?php
	#list public modules
	$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
		array(
			"pageID",-2,"great"
		)
	);
?>