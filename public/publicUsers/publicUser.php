<?php
	#Login Name
	if(array_key_exists("ln",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["ln"] = 
		'<div 
			class="ln-'. $priModObj[0]->className .'"
			id="ln-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["loginName"] . '</div>';
	}

	#Login Password
	if(array_key_exists("lp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["lp"] = 
		'<div 
			class="lp-'. $priModObj[0]->className .'"
			id="lp-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["lp"] . '</div>';
	}

	#First Name
	if(array_key_exists("fn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["fn"] = 
		'<div 
			class="fn-'. $priModObj[0]->className .'"
			id="fn-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["firstName"] . '</div>';
	}

	#Last Name
	if(array_key_exists("lstn",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["lstn"] = 
		'<div 
			class="lstn-'. $priModObj[0]->className .'"
			id="lstn-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["lastName"] . '</div>';
	}

	#Home Phone
	if(array_key_exists("hp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["hp"] = 
		'<div 
			class="hp-'. $priModObj[0]->className .'"
			id="hp-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["homePhone"] . '</div>';
	}

	#Cell Phone
	if(array_key_exists("cp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["cp"] = 
		'<div 
			class="cp-'. $priModObj[0]->className .'"
			id="cp-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["cellPhone"] . '</div>';
	}

	#Work Phone
	if(array_key_exists("wp",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["wp"] = 
		'<div 
			class="wp-'. $priModObj[0]->className .'"
			id="hpp-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $wp[0]->queryResults["workPhone"] . '</div>';
	}

	#Fax
	if(array_key_exists("fx",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["fx"] = 
		'<div 
			class="fx-'. $priModObj[0]->className .'"
			id="fx-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["fax"] . '</div>';
	}

	#Email
	if(array_key_exists("em",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["em"] = 
		'<a 
			class="em-'. $priModObj[0]->className .'"
			href="mailto:' . $priModObj[0]->queryResults["email"] . '"
			id="em-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["email"] . '</a>';
	}

	#Address
	if(array_key_exists("add",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["add"] = 
		'<div 
			class="add-'. $priModObj[0]->className .'"
			id="add-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["address"] . '</div>';
	}

	#City
	if(array_key_exists("ct",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["ct"] = 
		'<div 
			class="ct-'. $priModObj[0]->className .'"
			id="ct-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["city"] . '</div>';
	}

	#Postal/Zip
	if(array_key_exists("pz",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["pz"] = 
		'<div 
			class="pz-'. $priModObj[0]->className .'"
			id="pz-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["postalZip"] . '</div>';
	}

	#Province/State
	if(array_key_exists("pv",$priModObj[0]->domFields)){
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/provState.php');
		$provStateObj = new provState(false);
		$provState = $provStateObj->getRecordByID($priModObj[0]->queryResults["provState"]);
		$provState = mysqli_fetch_assoc($provState);

		$priModObj[0]->domFields["pv"] = 
		'<div 
			class="pv-'. $priModObj[0]->className .'"
			id="pv-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $provState["provState"] . '</div>';
	}

	#Country
	if(array_key_exists("cnt",$priModObj[0]->domFields)){
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/country.php');
		$countryObj = new country(false);
		$countries = $countryObj->getRecordByID($priModObj[0]->queryResults["countryID"]);
		$countries = mysqli_fetch_assoc($countries);

		$priModObj[0]->domFields["cnt"] = 
		'<div 
			class="cnt-'. $priModObj[0]->className .'"
			id="cnt-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $countries["country"] . '</div>';
	}

	#Company
	if(array_key_exists("cpy",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["cpy"] = 
		'<div 
			class="cpy-'. $priModObj[0]->className .'"
			id="cpy-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["company"] . '</div>';
	}

	#Job Title
	if(array_key_exists("jb",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["jb"] = 
		'<div 
			class="jb-'. $priModObj[0]->className .'"
			id="jb-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["jobTitle"] . '</div>';
	}

	#Receive Updates
	if(array_key_exists("ru",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["ru"] = 
		'<div 
			class="ru-'. $priModObj[0]->className .'"
			id="ru-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["receiveUpdates"] . '</div>';
	}

	#Notes
	if(array_key_exists("nt",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["nt"] = 
		'<div 
			class="nt-'. $priModObj[0]->className .'"
			id="nt-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["notes"] . '</div>';
	}

	#Active State
	if(array_key_exists("as",$priModObj[0]->domFields)){
		if($priModObj[0]->queryResults["isActive"] == 1){
			$activeText = "Active";
		}
		else{
			$activeText = "Inactive";
		}

		$priModObj[0]->domFields["as"] = 
		'<div 
			class="as-'. $priModObj[0]->className .'"
			id="as-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $activeText . '</div>';
	}

	#Website
	if(array_key_exists("wb",$priModObj[0]->domFields)){

		if(strpos($priModObj[0]->queryResults["website"],"http://") === false){
			$userWebsite = "http://" . $priModObj[0]->queryResults["website"];
		}
		else{
			$userWebsite = $priModObj[0]->queryResults["website"];
		}

		$priModObj[0]->domFields["wb"] = 
		'<a 
			class="wb-'. $priModObj[0]->className .'"
			id="wb-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $userWebsite . '</a>';
	}

	#User Signature
	if(array_key_exists("us",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["us"] = 
		'<div 
			class="us-'. $priModObj[0]->className .'"
			id="us-'. $priModObj[0]->className.'-'. $priModObj[0]->queryResults["priKeyID"].'"
		>' . $priModObj[0]->queryResults["userSignature"] . '</div>';
	}	

?>