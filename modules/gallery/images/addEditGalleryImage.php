<?php
if(
	isset($_REQUEST["parentPriKeyID"]) && 
	isset($priModObj[0]->bulkMod) &&
	#don't query images if we're adding another record from the bulk add/edit
	!isset($_REQUEST["quickEdit"])
) {
	#lists the images for this gallery on the bulk add/edit
	$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
		array(
			"galleryID",$_REQUEST["parentPriKeyID"],true,
		)
	);
}
?>