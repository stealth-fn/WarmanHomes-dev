<?php
	#the FAQ categoryID from the parent module query
	if(isset($priModObj[1]) && isset($priModObj[1]->queryResults["priKeyID"])){
		$priModObj[0]->faqCatID = $priModObj[1]->queryResults["priKeyID"];
	}
	
	#if we are looking for FAQ's from a specific category
	if(isset($priModObj[0]->faqCatID)) {
		
		#array to contain SQL joins
		$mappingArray = array(
			array("LEFT JOIN","faq_category_map","faq","faqID","priKeyID"),
			array("LEFT JOIN","faq_categories","faq_category_map","priKeyID","faqCategoryID")
		);
		
		#query of the FAQ's in the specified category
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecordFromList(
			array(
				"faq_categories.priKeyID",$priModObj[0]->faqCatID,true,
			),$mappingArray
		);

	}
?>