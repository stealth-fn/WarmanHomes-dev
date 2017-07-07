<?php
#specific blog
if(isset($priModObj[0]->employeeKeyID)){
  $priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
	  array('employees.priKeyID',$priModObj[0]->employeeKeyID,true)
  );
}
?>