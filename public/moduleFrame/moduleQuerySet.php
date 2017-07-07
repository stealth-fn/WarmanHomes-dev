<?php
	#set a default recordID
	if(!isset($_REQUEST["recordID"])) $_REQUEST["recordID"] = "";

	#get a specific record
	#default queries can be overwritten from the templateQueryFile	
	if(
		#editing a record, or bulk adding a record
		(strlen($_REQUEST["recordID"]) > 0 && isset($_REQUEST["pmpmID"])) ||
		#adding a new record, without the bulk add/edit
		($priModObj[0]->isTemplate==0 && !isset($priModObj[0]->bulkMod))
	) {
		#get the group for this record, and then get the record we want within the group
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getRecordByID($_REQUEST["recordID"]);
		
		#get the correct group record, used for multi-lingual and domain records
		if(strpos($priModObj[0]->tableRecords,"domainID") !== false) {		
			$tmpResult = mysqli_fetch_assoc($priModObj[0]->primaryModuleQuery);
				
			if(
				#if the record doesn't have a groupID find the
				#current max one and set it to that 
				strlen($tmpResult["groupID"]) == 0 &&
				#adding a new record, without the bulk add/edit
				($priModObj[0]->isTemplate==0 && !isset($priModObj[0]->bulkMod))
			) {
				#query for the largest groupID
				$tempMaxResult = $this->getCheckQuery(
					"SELECT MAX(groupID) as groupID FROM " . $priModObj[0]->moduleTable
				);
				
				#get from query, increment it				
				$tempMax = mysqli_fetch_assoc($tempMaxResult);
				$tempMaxID = $tempMax["groupID"];
				$tempMaxID = $tempMaxID + 1;
				
				#set our groupID in our object
				$priModObj[0]->groupID = $tempMaxID;
				
				#update groupID
				$paramsArray = array();
				$paramsArray["groupID"] = $tempMaxID;
				$paramsArray["priKeyID"] = $_REQUEST["recordID"];
				
				#unset our mappings array, we don't want to do that here
				unset($priModObj[0]->mappingArray);
				
				$priModObj[0]->updateRecord($paramsArray);
			}
			else{
				#set the groupID for this data/object
				$priModObj[0]->groupID = $tmpResult["groupID"];		
			}
			
			#get the correct group record, used for multi-lingual and domain records
			
			#determine what language to load in
			
			#loading in a record to edit
			if(isset($_REQUEST["recLng"]) && !isset($_REQUEST["lng"])) {
				#loading in the language for a module item
				#$_SESSION["lngDmnID"] set for the addEditFrame domainID
				#$_SESSION["lngDmnID"] = $tmpLang = $_REQUEST["recLng"];
				$tmpLang = $_REQUEST["recLng"];
				
			}
			else {
				#default for the session
				$tmpLang = $_SESSION["lngDmnID"];
			}

			#since we are targeting a record, we want to include inactive ones
			if(strpos($priModObj[0]->tableRecords,"isActive") !== false) {
				#the record we want based off of the group an domain
				#they will never have an active state of 10, so it returns active and inactive
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
					array(
						"groupID",$priModObj[0]->groupID,true,
						"domainID",$tmpLang,true,
						"isActive","10",false
					)
				);
			}
			#the record we want based off of the group and domain
			#Set isDraft as true so that the data will display when a user clicks on DraftEdit link 
			#if live and draft data exist on the same row.
			else if(strpos($priModObj[0]->tableRecords,"isDraft") !== false) {
				$priModObj[0]->isDraft = $tmpResult["isDraft"];

				if($priModObj[0]->isDraft == 1){
					$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
						array(
							"groupID",$priModObj[0]->groupID,true,
							"domainID",$tmpLang,true,
							$priModObj[0]->moduleTable . ".isDraft","1",true
						)
					);
				}
				else{
					#the record we want based off of the group an domain
					$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
						array(
							"groupID",$priModObj[0]->groupID,true,
							"domainID",$tmpLang,true,
							$priModObj[0]->moduleTable . ".isDraft","1",false
						)
					);
				}
				
			}
			else{
				#the record we want based off of the group an domain
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
					array(
						"groupID",$priModObj[0]->groupID,true,
						"domainID",$tmpLang,true
					)
				);
			}
			
		}
	}
	#default list queries
	elseif($priModObj[0]->isTemplate!=2){

		#determine what language to load in
		
		#loading in a record to edit
		if(isset($_REQUEST["recLng"]) && !isset($_REQUEST["lng"])) {
			#loading in the language for a module item
			#$_SESSION["lngDmnID"] set for the addEditFrame domainID
			#$_SESSION["lngDmnID"] = $tmpLang = $_REQUEST["recLng"];
			$tmpLang = $_REQUEST["recLng"];
			
		}
		else {
			#default for the session
			$tmpLang = $_SESSION["lngDmnID"];
		}
	
		#array of sql joints for default query, set in module class api
		if(!isset($priModObj[0]->standardMappingArray)) {
			$priModObj[0]->standardMappingArray = array();
		}
				
		if(!isset($priModObj[0]->primaryModuleQuery)){
			#we have a domainID in the table records
			if(strpos($priModObj[0]->tableRecords,"domainID") !== false) {
				$tempDomainField = $priModObj[0]->moduleTable . ".domainID";
				
				#if we want to list archived/active records or not
				if(isset($priModObj[0]->archived) && $priModObj[0]->archived == 0){
					$paramsArray = array(
						$tempDomainField, $tmpLang, true,
						$priModObj[0]->moduleTable . ".isActive","1",true
					);
				}
				elseif(isset($priModObj[0]->archived) && $priModObj[0]->archived == 1){
					$paramsArray = array(
						$tempDomainField, $tmpLang, true,
						$priModObj[0]->moduleTable . ".isActive","0",true
					);
				}
				else{
					$paramsArray = array(
						$tempDomainField, $tmpLang, true
					);
				}
				
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
					$paramsArray, 
					$priModObj[0]->standardMappingArray
				);
				
			}
			#no domain
			else{
				#if we want to list archived/active records or not
				if(isset($priModObj[0]->archived)  && $priModObj[0]->archived == 0){
					$paramsArray = array(
						$priModObj[0]->moduleTable . ".priKeyID", "stealth", false,
						$priModObj[0]->moduleTable . ".isActive","1",true
					);
				}
				elseif(isset($priModObj[0]->archived) && $priModObj[0]->archived == 1){
					$paramsArray = array(
						$priModObj[0]->moduleTable . ".priKeyID", "stealth", false,
						$priModObj[0]->moduleTable . ".isActive","0",true
					);
				}
				else{
					$paramsArray = array(
						$priModObj[0]->moduleTable.".priKeyID", "stealth", false
					);
				}
				
				$priModObj[0]->primaryModuleQuery = $priModObj[0]->getConditionalRecord(
					$paramsArray, 
					$priModObj[0]->standardMappingArray
				);
			}
		}
	}
	
	/*Overwrite default query for this module. For add/edit modules this probably 
	loads in other classes. This must come after the defauts, because we might need a
	prikeyID for mappings, or a primaryModuleQuery for other settings.*/
	if(
		strlen($priModObj[0]->templateQueryFile) > 0 && 
		#not to be used on the admin side as a default query
		!isset($priModObj[0]->archived)
	) {
		include($_SERVER['DOCUMENT_ROOT'].$priModObj[0]->templateQueryFile);
	}

	#user was going to a friendly URL on initial page load
	if($priModObj[0]->isPrimaryPageModule && isset($_GET["initPage"]) && isset($_SESSION["lastURI"])){
		
		#function to remove all special characters, except dashes from a string
		$priModObj[0]->getCheckQuery('DROP FUNCTION IF EXISTS fn_getCleanURLStr;');
		$priModObj[0]->getCheckQuery(
			"CREATE FUNCTION fn_getCleanURLStr( str CHAR(255) ) RETURNS CHAR(255) 
				BEGIN 
				  DECLARE i, len SMALLINT DEFAULT 1; 
				  DECLARE ret CHAR(255) DEFAULT ''; 
				  DECLARE c CHAR(1); 
				  SET len = CHAR_LENGTH( str ); 
				  REPEAT 
					BEGIN 
					  SET c = MID( str, i, 1 ); 
					  IF c REGEXP '[[:alnum:]]' OR c = '-' THEN
						SET ret=CONCAT(ret,c); 
					  END IF; 
					  SET i = i + 1; 
					END; 
				  UNTIL i > len END REPEAT; 
				  RETURN ret; 
				END;"
		);
	
		$priModObj[0]->primaryModuleQuery = $priModObj[0]->getCheckQuery(
			'SELECT * from `' . $priModObj[0]->moduleTable . "`" . 
			' WHERE fn_getCleanURLStr(REPLACE(`' . $priModObj[0]->primaryPageModuleTitleField . "`,' ','-')) = " .
			' REPLACE("' . $priModObj[0]->getCleanURLStr($GLOBALS["mysqli"]->real_escape_string($_SESSION["lastURI"])) . '"," ","-")'
		);

		if(
			isset($_GET["hasLastEmptyURI"]) && $_GET["hasLastEmptyURI"] &&  
			mysqli_num_rows($priModObj[0]->primaryModuleQuery) == 0
		){
			#404 page
			header("Location: /index.php?pageID=-5");
		}
	}
	
	#if its an empty query we still want to load our module, set to true when adding/editing
	$loopOnce = false;
?>