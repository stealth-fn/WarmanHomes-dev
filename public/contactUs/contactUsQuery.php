<?php
#specific contact form
if(isset($priModObj[0]->contactKeyID)){
  $priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
	  array('contactUs.priKeyID',$priModObj[0]->contactKeyID,true)
  );
}
?>