<?php
	#insert a module to the current one, example gallery in a product

	#through ajax. quick add/edit or add edit form of another mdule
	if(isset($_POST["function"]) && $_POST["function"] == "setupRecord"){
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/standardContent/standardContent.php");
		
		#the ajax parse code at the bottom of the class file will call our setupRecord function
		$standardContentObj = new standardContent(true,NULL);
	}
	elseif(isset($priModObj)){ 
		$childMod = $priModObj[0]->setupRecord($recursivePmpmID);
	}
	else{
		$childMod = $this->setupRecord($recursivePmpmID);
	}

	if(!isset($_POST["function"])){
		echo $childMod["DOM"];	
	}
?>