<?php	

	#If we are on the public side
	if($priModObj[0]->priKeyID > 0){ 
		if(isset($_SESSION['sessionSecurityLevel']) && $_SESSION['sessionSecurityLevel'] != 3 ) {
			#list all orders for a user
			if(isset($_SESSION["userID"])){
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
					array("publicUserID",$_SESSION["userID"],true)
				);
			}
			#list a specific user order
			if(isset($_REQUEST["userOrderID"])){
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
					array(
						"publicUserID", $_SESSION["userID"] ,true,
						"priKeyID", $_REQUEST["userOrderID"], true
					)
				);
			}
		}
	}
	
		
	#specific Order
	if(isset($priModObj[0]->orderID)){
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
			array('priKeyID',$priModObj[0]->orderID,true)
		);
	}
?>