<?php

$navPrefix = "";
switch($priModObj[0]->navType){
	case 0: #top nav
		if($priModObj[0]->isSubNav){
			$navPrefix = "sacatTp_";
		?>
			sacatTp_<?php echo $priModObj[0]->className ?> = new accordionTree('<?php echo $priModObj[0]->className ?>',<?php echo $priModObj[0]->navType; ?>,<?php echo $priModObj[0]->toggleSpeed; ?>);
			accordionTreeObjs.sacatTp_<?php echo $priModObj[0]->className ?> = sacatTp_<?php echo $priModObj[0]->className ?>;
		<?php
		}
		else{
			$navPrefix = "catTp_";
		?>
			catTp_<?php echo $priModObj[0]->className ?> = new accordionTree('<?php echo $priModObj[0]->className ?>',<?php echo $priModObj[0]->navType; ?>,<?php echo $priModObj[0]->toggleSpeed; ?>);
			accordionTreeObjs.atpto_<?php echo $priModObj[0]->className ?> = catTp_<?php echo $priModObj[0]->className ?>;
		<?php	
		}
		break;
	case 1: #side nav
		if($priModObj[0]->isSubNav){
			$navPrefix = "sacatSd_";
		?>
			sacatSd_<?php echo $priModObj[0]->className ?> = new accordionTree('<?php echo $priModObj[0]->className ?>',<?php echo $priModObj[0]->navType; ?>,<?php echo $priModObj[0]->toggleSpeed; ?>);
			accordionTreeObjs.sacatSd_<?php echo $priModObj[0]->className ?> = sacatSd_<?php echo $priModObj[0]->className ?>;
		<?php
		}
		else{
			$navPrefix = "catSd_";
		?>
			catSd_<?php echo $priModObj[0]->className ?> = new accordionTree('<?php echo $priModObj[0]->className ?>',<?php echo $priModObj[0]->navType; ?>,<?php echo $priModObj[0]->toggleSpeed; ?>);
			accordionTreeObjs.catSd_<?php echo $priModObj[0]->className ?> = catSd_<?php echo $priModObj[0]->className ?>;
		<?php
		}
		break;
	case 2: #bottom nav
		if($priModObj[0]->isSubNav){
			$navPrefix = "sacatBt_";
		?>
			sacatBt_<?php echo $priModObj[0]->className ?> = new accordionTree('<?php echo $priModObj[0]->className ?>',<?php echo $priModObj[0]->navType; ?>,<?php echo $priModObj[0]->toggleSpeed; ?>);
			accordionTreeObjs.sacatBt_<?php echo $priModObj[0]->className ?> = sacatBt_<?php echo $priModObj[0]->className ?>;
		<?php
		}
		else{
			$navPrefix = "atpbo_";
		?>
			catBt_<?php echo $priModObj[0]->className ?> = new accordionTree('<?php echo $priModObj[0]->className ?>',<?php echo $priModObj[0]->navType; ?>,<?php echo $priModObj[0]->toggleSpeed; ?>);
			accordionTreeObjs.catBt_<?php echo $priModObj[0]->className ?> = catBt_<?php echo $priModObj[0]->className ?>;
		<?php
		}
		break;
	
}

	#page refreshing with a category. set JS for its child div being open
	/*if(isset($_REQUEST["prodCatID"])) {
		echo 'aTPCO.lastExpandedRoot="' , $_REQUEST["prodCatID"] , '-1-' , $_REQUEST["prodCatID"] , '";';
		echo 'toggledID="' , $_REQUEST["prodCatID"] , '-1-' , $_REQUEST["prodCatID"] , '";';
	} */
?>