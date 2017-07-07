<?php
	/*$priModObj[0]->domFields["div"] = "<div class='wrap-".$priModObj[0]->className."'>";
	$priModObj[0]->domFields["/div"] = "</div>";*/

	#not all modules have been setup with domFields
	if(isset($priModObj[0]->domFields)) {
		foreach($priModObj[0]->domFields as $tmpField){
			echo $tmpField;
		}
	}
?>