<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/dataSet.php');
	
	abstract class common extends dataSet {
		public $ajax;
		public $moduleSettings = array();

		
		#isAjax - usually determines our return type
		#$pmpm - either pmpm id, or the query return
		public function __construct($isAjax,$pmpm=null){
			parent::__construct($isAjax);

			/*sometimes when we use our common functions we
			want it to ignroe instance parameters*/
			$this->ignoreInstance = false;

			#determine if this class is being used for ajax or not... 
			#ajax - returns JSON, php returns query resource
			if($isAjax){
				$this->ajax = true;
				
				/*we want to remove the $_REQUEST["function"]... our object is already created
				at it knows its an ajax object... now we can include other class files 
				in our function calls without them acting like we're using them for ajax*/
				if(isset($_REQUEST["function"])){
					$GLOBALS["ajaxRunFunction"] = $_REQUEST["function"];
					unset($_REQUEST["function"]);
				}
				
				if(isset($_REQUEST["modData"])){
					$GLOBALS["ajaxmodData"] = $_REQUEST["modData"];
					unset($_REQUEST["modData"]);
				}
			}
			else $this->ajax = false;
			
			#make the table records as a property of the object
			if(isset($this->moduleTable) && strlen($this->moduleTable) > 0){
				$tableRec = $this->getTableColumns();
				$this->tableRecords = $this->getQueryValueString($tableRec,"Field",",");
			}
			else $this->tableRecords = 0;

			#setup public module page map instance
			if(!is_null($pmpm)) {
				$this->setInstanceModuleParams($pmpm,1);
			}
			
			#module settings - all instances of this module

			#module settings - this instance
			if(isset($this->instanceID)) {
				$this->getSettings($this->instanceID);
			}
			else{
				$this->getSettings();
			}
		}
		
		public function getCheckQuery($query){
			$GLOBALS["mysqli"]->set_charset('utf8');

			$result = $GLOBALS["mysqli"]->query($query);
			
			if(!$result) {
				echo $query . " " . $GLOBALS["mysqli"]->error;
			}
			else {
				return $result;
			}
		}
		
		public function commonReturn($query){
			if($this->ajax) {
				echo $this->myySQLQueryToJSON($this->getCheckQuery($query));
			}
			else return $this->getCheckQuery($query);
		}
			
		#active - true - only query records with active=1
		public function getAllRecords($active = true){
			#if the module has an ordinal value
			$ordinalStr = 
				strpos($this->tableRecords,"ordinal") ? 
				" ORDER BY ORDINAL ASC, priKeyID ASC" : " ORDER BY priKeyID ASC";
				
			$activeString = 
				(strpos($this->tableRecords,"isActive") && $active) ? 
				" WHERE isActive = 1 " : " ";
				
			#only return the record qty specified - pagination				
			global $priModObj;
			
			if(
				(strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") !== false ||
				strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") !== false) &&
				#not a module level > 2
				!isset($priModObj[1]) &&
				!$this->ignoreInstance
			){
				if(isset($this->priKeyID) && isset($this->currentPagPage)){
					#if there isn't a currentPagPage its probably a level > 2 module
					if(!isset($this->currentPagPage)) {
						$this->currentPagPage = 1;
					}
					
					#probably being called in some API file, not set with the module
					if(
						!isset($this->displayQty) || 
						isset($this->displayQty) && $this->displayQty == -1
					) {
						$this->displayQty = "2147483647";
					}
					
					$startRec = $this->currentPagPage * $this->displayQty;
					$dspQty = $this->displayQty;
					$ordinalStr .= " LIMIT " . $startRec . "," . $dspQty;
				}
			}

			return $this->commonReturn(
				"SELECT * FROM " . $this->moduleTable . $activeString . $ordinalStr
			);		 
		}
		
		public function getRecordByID($priKeyID){
	
			#if an emtpy string is passed, don't return records of ID 0
			$negateZero = ($priKeyID === "") ? " AND priKeyID <> 0" : "";

			return $this->commonReturn(
				"SELECT * FROM " . $this->moduleTable . 
				" WHERE priKeyID = '" . $GLOBALS["mysqli"]->real_escape_string($priKeyID) . "'" . $negateZero . 
				" LIMIT 1"
			);
		}
		
		public function getRecordLimit($limitCount, $limitField, $descAsc){		
			return $this->commonReturn(
				"SELECT * FROM " . $this->moduleTable . 
				" ORDER BY " . $GLOBALS["mysqli"]->real_escape_string($limitField) . " " . $GLOBALS["mysqli"]->real_escape_string($descAsc) . 
				" LIMIT " . $GLOBALS["mysqli"]->real_escape_string($limitCount)
			);		
		}
		
		public function getFieldByPriKeyID($fieldName,$priKeyID){				
			return $result = $this->getCheckQuery(
				"SELECT `" . $GLOBALS["mysqli"]->real_escape_string($fieldName) .  "`" . 
				" FROM " . $this->moduleTable . 
				" WHERE priKeyID = '" . $GLOBALS["mysqli"]->real_escape_string($priKeyID) . "' LIMIT 1"
			);
			if($this->ajax) while($x = mysqli_fetch_assoc($result)) echo $x[$fieldName];
			else return $result;
		}
				
		#get the maximum primary key for a specified table
		public function getMaxRecord(){					
			$result = $this->getCheckQuery("SELECT max(priKeyID) AS priKeyID FROM " . $this->moduleTable);
						
			#get the record for that key
			if(mysqli_num_rows($result) > 0){
				while($x = mysqli_fetch_assoc($result)) $latestRec = $this->getRecordByID($x["priKeyID"]);
				return $this->commonReturn($latestRec);
			}
			else{
				if($this->ajax) echo $result;
				else return $result;
			}	
		}

		/*getConditionalRecord(
			array(field,value,operator...orderByField,orderType),
			array(
				array(joinType,table1,table2,field1,field2)
			)...
		)*/
		public function getConditionalRecord(){
			#get and escape our params
			$argsArray = func_get_args();#all parameters
			$paramArray = $argsArray[0];#WHERE conditions
			$joinArray = isset($argsArray[1]) ? $argsArray[1] : array();#JOIN conditions
			$paramCnt = count($paramArray);#number of tokens in WHERE clause
			$joinCnt = count($joinArray);#number of JOINs
			$searchOperator = isset($argsArray[2]) ? $argsArray[2] : "AND";
			
			#only return the query string, used for the cart query
			$qString = isset($argsArray[3]) ? $argsArray[3] : false;
			
			#override active in db
			$activeOverride = false;
			
			#escape WHERE params		
			for($i = 0; $i<$paramCnt; $i++) {
				$paramArray[$i] = $GLOBALS["mysqli"]->real_escape_string($paramArray[$i]);
			}
			#escape JOIN params
			for($i = 0; $i<$joinCnt; $i++) {
				for($j = 0; $j<4; $j++) { 
					$joinArray[$i][$j] = $GLOBALS["mysqli"]->real_escape_string($joinArray[$i][$j]);
				}
			}
			
			$selectStart = "SELECT ";#start of query
			if($joinCnt > 0){ #we have JOIN conditions
				$selectStart .= $this->moduleTable . ".*, "; #main table
				$joinStr = "";
				for($i = 0; $i<$joinCnt; $i++){#loop through JOINs
					
					$selectStart .= $joinArray[$i][1] . ".*,"; #what tables we want 
					#build up JOIN string
					$joinStr .= $joinArray[$i][0] . " " . $joinArray[$i][1] . " ON "
								. $joinArray[$i][1] . "." . $joinArray[$i][3] .  "=" 
								. $joinArray[$i][2] . "." . $joinArray[$i][4] . " ";
				}
				#overwrite JOIN tables priKeyID's with primary module tables
				$selectStart .= $this->moduleTable . ".priKeyID as priKeyID FROM " . $this->moduleTable . " ";
				$selectStart .= $joinStr;
			}
			else $selectStart .= " * FROM " . $this->moduleTable; #no JOINS
				
			$ordinalStr = "";
			$queryCondition = "";
			
			#set up sql condition
			$i = 0;
			while($i+3<=$paramCnt){
				
				#if the field name is table.field, break it down, and santizie the field name
				$tempField = explode(".",$paramArray[$i]);
				
				if(count($tempField) > 1){
					$fieldArg = "`" . $tempField[0] . "`.`" . $tempField[1] . "`";
				}
				else{
					$fieldArg = "`" . $tempField[0] . "`";
				}
				
				$fieldValue = $paramArray[$i + 1];
				$fieldOperator = $paramArray[$i + 2];
						
				if(strlen($queryCondition) === 0) $queryCondition = " WHERE ";
				
				#we are manually overriding the db active field, modified after the loop
				if(
					!$activeOverride && 
					strpos($paramArray[$i],"isActive") !== false
				) {
					$activeOverride = true;
				}
				
				$nullSearch = false; #if we have an asc or desc option it won't exist

				if($fieldOperator === "great") $condOperator = ">";
				elseif($fieldOperator === "greatEqual") $condOperator = ">=";
				elseif($fieldOperator === "less") $condOperator = "<";
				elseif($fieldOperator === "lessEqual") $condOperator = "<=";
				elseif($fieldOperator === "like") $condOperator = " LIKE";
				elseif($fieldOperator == true) $condOperator = "=";	
				else{
					$condOperator = "<>";
					$nullSearch = true;
				}
				
				#wrap our LIKE strings in %'s
				if($fieldOperator === "like"){
					$fieldValue = "%" . $fieldValue . "%";
				}
				
				/*put single quotes around strings but not 
				numbers so our operators can compare numbers*/
				if(!is_numeric($fieldValue)){
					$fieldValue = " '" . $fieldValue  . "'";
				}
				
				if($i >= 3) {
					#if doing a negative condition, put in the ( for the NULL condition
					if($nullSearch){
						$queryCondition .= " " . $searchOperator . " (" . $fieldArg . $condOperator . $fieldValue;
					}
					else {
						$queryCondition .= " " . $searchOperator . " " . $fieldArg . $condOperator . $fieldValue;
					}
				}
				else {
					#if doing a negative condition, put in the ( for the NULL condition
					if($nullSearch){
						$queryCondition .= " (" . $fieldArg . $condOperator . $fieldValue;
					}
					else {
						$queryCondition .= $fieldArg . $condOperator . $fieldValue;
					}
				}	
				
				#we want to include null values with our not equal too select statements
				if($nullSearch) $queryCondition .= " OR " . $fieldArg . " IS NULL";
				
				#if doing a negative condition, put in the ( for the NULL condition
				if(($i >= 3 && $nullSearch) || ($i == 0 && $nullSearch)) {
					$queryCondition .= ")";
				}
								
				$i += 3;
			
			}
						
			#if the table had a draft field, display the live data only. Display draft data only if the record has only draftPriKeyID
			if(strpos($this->tableRecords,"isDraft")) {
				
				#editing a draft record
				if(isset($this->isDraft) && $this->isDraft == 1){
					$queryCondition .= 
					" AND ((draftPriKeyID>0 AND isDraft= true) 
					  OR(isDraft= false))";
				}
				#listing records
				else{
					$queryCondition .= 
					" AND ((livePriKeyID IS NULL AND draftPriKeyID>0 AND isDraft= true) 
					  OR(isDraft= false))";
				}
			}
			
			#If it is bulk side and table contains isDraft field, do not display the draft data
			if(isset($this->bulkMod) && strpos($this->tableRecords,"isDraft")) {
				$queryCondition .= " AND (draftPriKeyID IS NULL
									 OR isDraft = false)";
			}
			
			#get the maximum primary key for a specified table
			#if the module has an ordinal value
			if(strpos($this->tableRecords,"ordinal")) {
				$ordinalStr = " ORDER BY $this->moduleTable.ordinal, $this->moduleTable.priKeyID";
			}
			
			#if table has an active field, only select active records, unless they specify otherwise
			if(strpos($this->tableRecords,"isActive") && !$activeOverride) {
				$queryCondition .= " AND isActive = 1";
			}
			
			#if not divisible by 3, then we have an ORDER BY clause...
			if($paramCnt%3 != 0){
				/*find out if there is 1 or 2 extra parameters....
				1 extra param... asc or desc, use the priKeyID
				2 extra params....
					1st - field to order by
					2nd - asc or desc*/
				$extraParms = abs((floor($paramCnt/3) * 3) - $paramCnt);
				
				#need this type check === 
				#(NOT SURE IF THIS IS THE CASE OR WHAT PROBLEMS ARISE IF IT'S SET TO ===
				#BUT RIGHT NOW ONLY == WORKS)
				if($extraParms == 1){
					#the last parameter can bee ASC or DESC to determine the order
					if($paramArray[$paramCnt-1] === "ASC") $ordinalStr = " ORDER BY priKeyID ASC";
					elseif($paramArray[$paramCnt-1] === "DESC") $ordinalStr = " ORDER BY priKeyID DESC";
					elseif($paramArray[$paramCnt-1] === "RAND()") $ordinalStr = " ORDER BY RAND()";
				}
				elseif($extraParms == 2){
					#the last parameter can bee ASC or DESC to determine the order
					if($paramArray[$paramCnt-1] === "ASC")
						$ordinalStr = " ORDER BY " . $paramArray[$paramCnt - 2] . " ASC";
					elseif($paramArray[$paramCnt-1] === "DESC")
						$ordinalStr = " ORDER BY " . $paramArray[$paramCnt - 2] . " DESC";
				}
			}
			
			#only return the record qty specified - pagination				
			global $priModObj;
			
			if(
				(strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") !== false ||
				strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") !== false) &&
				#not a module level > 2
				!isset($priModObj[1])
			){
				#if there isn't a currentPagPage its probably a level > 2 module
				# Fateme - For CSV Export we need to query the whole thing without considering the pagination settings
				if((!isset($this->currentPagPage)) || (isset($this->currentPagPage) && $this->currentPagPage == 'ppToken') || isset($_REQUEST["csvDump"])) {
					$this->currentPagPage = 1;
				}
				
				#probably being called in some API file, not set with the module
				# Fateme - For CSV Export we need to query the whole thing without considering the pagination settings
				if(
					!isset($this->displayQty) || 
					isset($this->displayQty) && $this->displayQty == -1 || isset($_REQUEST["csvDump"])
				) {
					$this->displayQty = "2147483647";
				}
					
				$startRec = ($this->currentPagPage-1) * $this->displayQty;
				$dspQty = $this->displayQty;
				$ordinalStr .= " LIMIT " . $startRec . "," . $dspQty;
			}
			
			#make sure we don't have duplicates in our query
			$queryCondition .= " GROUP BY " . $this->moduleTable . ".priKeyID";
			
			#echo $selectStart . $queryCondition . $ordinalStr;
			#if we are paginating, just return the records we need		
			if($qString){
				return $selectStart . $queryCondition . $ordinalStr;
			}
			else{
				return $this->commonReturn($selectStart . $queryCondition . $ordinalStr);			
			}			
		}
		
		/*always has an odd number of params, 
		the first param in a pair is the table field name, 
		the second param is a list
		the third param is if it's a positive or negative condition
		
		if there are sets of three parameters afterwards its the same as getConditionalRecord()...
		
		the first param in a pair is the table field name, 
		the second param in the pair is the record value
		the third param is if it's a positive or negative condition*/
		public function getConditionalRecordFromList(){ 
			#get and escape our params
			$argsArray = func_get_args();#all parameters
			$paramArray = $argsArray[0];#where conditions
			$joinArray = isset($argsArray[1]) ? $argsArray[1] : array();#join conditions
			$paramCnt = count($paramArray);#number of tokens in WHERE clause
			$joinCnt = count($joinArray);#number of JOINs
			
			#override active in db
			$activeOverride = false;
				
			#escape WHERE params	
			for($i = 0; $i<$paramCnt; $i++) {
				$paramArray[$i] = $GLOBALS["mysqli"]->real_escape_string($paramArray[$i]);
			}
			#escape JOIN params
			for($i = 0; $i<$joinCnt; $i++){
				for($j = 0; $j<4; $j++) $joinArray[$i][$j] = $GLOBALS["mysqli"]->real_escape_string($joinArray[$i][$j]);
			}
			
			$queryCondition = " WHERE ";

			$selectStart = "SELECT ";#start of query
			if($joinCnt > 0){ #we have JOIN conditions
				$selectStart .= $this->moduleTable . ".*, "; #main table
				$joinStr = "";
				for($i = 0; $i<$joinCnt; $i++){#loop through JOINs
					$selectStart .= $joinArray[$i][1] . ".*,"; #what tables we want 
					#build up JOIN string
					$joinStr .= $joinArray[$i][0] . " " . $joinArray[$i][1] . " ON "
								. $joinArray[$i][1] . "." . $joinArray[$i][3] .  "=" 
								. $joinArray[$i][2] . "." . $joinArray[$i][4] . " ";
				}
				#overwrite JOIN tables priKeyID's with primary module tables
				$selectStart .= $this->moduleTable . ".priKeyID as priKeyID FROM " . $this->moduleTable . " ";
				$selectStart .= $joinStr;
			}
			else $selectStart .= " * FROM " . $this->moduleTable; #no JOINS
						
			#if the list is empty, we need to send empty quotes, or it won't query properly
			$mySQLList = strlen($paramArray[1]) === 0 ? "''" : $paramArray[1];

			$escapedField = $GLOBALS["mysqli"]->real_escape_string($paramArray[0]);
			$queryCondition .= $paramArray[2] ? 
			$escapedField . " IN (" . $mySQLList . ")" : $escapedField . " NOT IN (" . $mySQLList . ")";
			
			#loop through parameters and setup SQL condition
			for ($i=3; $i+3<=$paramCnt; $i += 3){
				
				#we are manually overriding the db active field, modified after the loop
				if(
					!$activeOverride && 
					strpos($paramArray[$i],"isActive") !== false
				) {
					$activeOverride = true;
				}
				
				
				#if the field name is table.field, break it down, and santizie the field name
				$tempField = explode(".",$paramArray[$i]);
				
				if(count($tempField) > 1){
					$fieldArg = "`" . $tempField[0] . "`.`" . $tempField[0] . "`";
				}
				else{
					$fieldArg = "`" . $tempField[0] . "`";
				}
				
			 	#extra where clauses after the list
				$fieldOperator = $paramArray[$i + 2];
				
				if($fieldOperator === "great") $condOperator = ">";
				elseif($fieldOperator === "greatEqual") $condOperator = ">=";
				elseif($fieldOperator === "less") $condOperator = "<";
				elseif($fieldOperator === "lessEqual") $condOperator = "<=";
				elseif($fieldOperator === "like") $condOperator = " LIKE";
				elseif($fieldOperator == true) $condOperator = "="; 
				else{
				 $condOperator = "<>";
				 $nullSearch = true;
				}
				
				$queryCondition .= " AND " . $fieldArg . $condOperator . " '" . $paramArray[$i + 1] . "'";
			}
			
			#if table has an active field, only select active records, unless they specify otherwise
			if(strpos($this->tableRecords,"isActive") && !$activeOverride) {
				$queryCondition .= " AND isActive = 1";
			}
			
			#if the module has an ordinal value
			$ordinalStr = strpos($this->tableRecords,"ordinal") ? " ORDER BY $this->moduleTable.ordinal, $this->moduleTable.priKeyID" : "";
			
			#if not divisible by 3, then we have an order by clause...
			if(count($paramArray)%3 != 0){
				/*find out if there is 1 or 2 extra parameters....
				1 extra param... asc or desc, use the priKeyID
				2 extra params...
					1st - field to order by
					2nd - asc or desc*/
				$extraParms = abs((floor($paramCnt/3) * 3) - $paramCnt);
				
				if($extraParms == 1){
					#the last parameter can bee ASC or DESC to determine the order
					if($paramArray[$paramCnt - 1] === "ASC") $ordinalStr = " ORDER BY priKeyID ASC";
					elseif($paramArray[$paramCnt - 1] === "DESC") $ordinalStr = " ORDER BY priKeyID DESC";
					elseif($paramArray[$paramCnt - 1] === "LIST") 
						$ordinalStr = " ORDER BY FIELD(" . $paramArray[0] . ", " . $paramArray[1] . ")";
				}
				elseif($extraParms == 2){
					#the last parameter can bee ASC or DESC to determine the order
					if($paramArray[$paramCnt-1] === "ASC")
						$ordinalStr = " ORDER BY " . $paramArray[$paramCnt - 2] . " ASC";
					elseif($paramArray[$paramCnt-1] === "DESC")
						$ordinalStr = " ORDER BY " . $paramArray[$paramCnt - 2] . " DESC";
					elseif($paramArray[$paramCnt-1] === "LIST")
						$ordinalStr = " ORDER BY FIELD(" . $paramArray[0] . ", " . $paramArray[1] . ")";
				}
			}
			
			#only return the record qty specified - pagination
			global $priModObj;
				
			if(
				(strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") !== false ||
				strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") !== false) &&
				#not a module level > 2
				!isset($priModObj[1])
			){
				#if there isn't a currentPagPage its probably a level > 2 module
				if(!isset($this->currentPagPage)) {
					$this->currentPagPage = 1;
				}
				
				#probably being called in some API file, not set with the module
				if(
					!isset($this->displayQty) || 
					isset($this->displayQty) && $this->displayQty == -1
				) {
					$this->displayQty = "2147483647";
				}
					
				$startRec = ($this->currentPagPage-1) * $this->displayQty;
				$dspQty = $this->displayQty;
				$ordinalStr .= " LIMIT " . $startRec . "," . $dspQty;
			}
			
			#make sure we don't have duplicates in our query
			$queryCondition .= " GROUP BY " . $this->moduleTable . ".priKeyID";

			return $this->commonReturn($selectStart . $queryCondition . $ordinalStr);				
		}			
		
		public function addRecord(){	
			$paramArray = func_get_arg(0);								
			$finalParamValues = array();			
			$fieldNames = array();
			$tableFields = $this->getTableColumns(); #get table fields
			
			$queryValueContainer = array();		
			$defType = "";
									
			#build query string
			while($f =  mysqli_fetch_assoc($tableFields)){
			
				#don't add the priKeyID
				if($f["Field"] != "priKeyID"){

					#if it's a groupID and we aren't passing a group ID, get the latest groupID
					if($f["Field"] == "groupID" && !is_numeric($paramArray[$f["Field"]])) {
						$tempMaxResult = $this->getCheckQuery(
							"SELECT MAX(groupID) as groupID FROM $this->moduleTable"
						);
						 
						$tempMax = mysqli_fetch_assoc($tempMaxResult);
						$tempMaxID = $tempMax["groupID"];
						$paramArray[$f["Field"]] = $tempMaxID+1;
					}
					
					#if it's a priKeyID field,
					if($f["Field"] == "priKeyID") {
						$priKeyID = $paramArray[$f["Field"]];						
					}
										
					#if it's a isDraft field,
					if($f["Field"] == "isDraft") {
						$isDraft = $paramArray[$f["Field"]];						
					}				
						
					#if it's a livePrikeyID field, select the data of livePrikeyID
					if($f["Field"] == "livePriKeyID") {
						$livePriKeyID = $paramArray[$f["Field"]];						
					}				
						
					#if it's a draftPrikeyID field, select the data of draftPrikeyID
					if($f["Field"] == "draftPriKeyID") {
						$draftPriKeyID = $paramArray[$f["Field"]];						
					}				
	
					#if we need a default value
					if(isset($this->addDefault[$f["Field"]])){
					
						$defType = $this->addDefault[$f["Field"]];
						
						if($defType === "dateStamp")$paramArray[$f["Field"]] = date("Y-m-d");
						elseif($defType === "timeStamp")$paramArray[$f["Field"]] = date("H:i:s");
						elseif($defType === "defaultOff")$paramArray[$f["Field"]] = "0";			
						elseif($defType === "defaultOn")$paramArray[$f["Field"]] = "1";
						#keep current database value
						elseif($defType === "dbSet")$paramArray[$f["Field"]] = $key;	
						elseif($defType === "publicUser"){
							if(!isset($_SESSION['userID']))$paramArray[$f["Field"]] = "0";
							else $paramArray[$f["Field"]] = $_SESSION['userID'];
						}
						elseif($defType=="phpSessionID"){
							session_start();
							$paramArray[$f["Field"]] = "'" . session_id() . "'";
						}
						elseif($defType=="postalFormat"){
							$paramArray[$f["Field"]] = $this->getCleanPostalFormat($paramArray[$f["Field"]]);
						}
						#other value specified in the constructor
						else{
							$paramArray[$f["Field"]] = $defType;
						}
					}

					array_push($fieldNames,$f["Field"]);
				
					#urldecode is required since it needs to stay encoded in the json
					if(isset($paramArray[$f["Field"]])) {
						if(
							isset($this->moduleSettings["encryptFields"]) && 
							in_array($f["Field"],$this->moduleSettings["encryptFields"])
						){
							$tempValue = "'" . $GLOBALS["mysqli"]->real_escape_string(
								$this->encString(
									$f["Field"],
									urldecode(
										trim($paramArray[$f["Field"]])
									),
									true
								)
							) . "'";
						}
						else{
							$tempValue = "'" . $GLOBALS["mysqli"]->real_escape_string(
								urldecode(trim($paramArray[$f["Field"]]))
							) . "'";
						}
					}
					else $tempValue = '""';
					
					#get proper default for numeric fields
					$tempValue = $this->getDefaultFieldValue($f["Field"],$tempValue);
					
					array_push($finalParamValues,$tempValue);
				}
				
				#reset default type
				$defType = "";
			}
			
			#build query string
			$tableFieldStr = implode(",",$fieldNames);
			$valueString = implode(",",$finalParamValues);
			$query = "INSERT INTO " . $this->moduleTable . " (" . $tableFieldStr . ") VALUES(". $valueString .")";

			#run query get record id
			$result = $this->getCheckQuery($query);					
			$newRec = $GLOBALS["mysqli"]->insert_id;
			
			#if the table has isDraft field, set the priKeyIDs to new priKeyID
			if(isset($isDraft)) {
				$draftArray = array();
				$liveArray = array();
				
				$draftArray["draftPriKeyID"] = $newRec;
				$draftArray["priKeyID"] = $newRec;
				
				$liveArray["livePriKeyID"] = $newRec;
				$liveArray["priKeyID"] = $newRec;
					
				#ajax - returns JSON. Set the ajax as a false so php returns query resource
				$tempAjax = $this->ajax;
				$this->ajax = false;
				
				#check whether it is draft or live and update the draftPriKeyID and LivePriKeyID while
				#adding the data. 1 is draft and 0 is live.
				if($isDraft==1){
					$newRec = $this->updateRecord($draftArray);
				}
				else if($isDraft==0){
					$newRec = $this->updateRecord($liveArray);	
				}
				
				$this->ajax = $tempAjax;
			}
			
			#if isDraft field exists, update the prikeyIDs for liveDraft or draftLive data.
			//if( (isset($livePriKeyID)) || (isset($draftPriKeyID)) ) {
			if(isset($isDraft)) {
				
				$exliveArray = array();
				$exdraftArray = array();
				
				$exdraftArray["draftPriKeyID"] = $newRec;
				$exdraftArray["livePriKeyID"] = $livePriKeyID;
				$exdraftArray["priKeyID"] = $livePriKeyID;
				
				$exliveArray["livePriKeyID"] = $newRec;
				$exliveArray["priKeyID"] = $draftPriKeyID;
				
				#ajax - returns JSON. Set the ajax as a false so php returns query resource
				$tempAjax = $this->ajax;
				$this->ajax = false;
				
				#If draftPriKeyID is null, update the draftPrikeyID as new PrikeyID where pirKeyID is livePriKeyID
				#do same for livePrikeyID as well
				if(($livePriKeyID>0) && ($draftPriKeyID==null)){
					$this->updateRecord($exdraftArray);
				}
				else if(($draftPriKeyID>0) && ($livePriKeyID==null)){
					$this->updateRecord($exliveArray);
				}
			
				$this->ajax = $tempAjax;
			}	
		
			#this record is mapped to others
			if(isset($this->mappingArray)) {
				$this->addEditModuleMappings($newRec,$paramArray);
			}

			if($this->ajax) echo trim($newRec);
			else return trim($newRec);	
		}
		
		public function updateRecord(){
			$paramArray = func_get_arg(0);	
			$queryValueContainer = array();		
			$defType = "";
			$tableFields = $this->getTableColumns(); #get table fields
									
			#build query string			
			while($f =  mysqli_fetch_assoc($tableFields)){
				$defType = ""; #reset default type
			
				if($f["Field"] != "priKeyID"){ #don't add the priKeyID
					if(isset($this->updateDefault[$f["Field"]])){ #if we need a default value
						$defType = $this->updateDefault[$f["Field"]];
						
						if($defType === "dateStamp") $paramArray[$f["Field"]] = date("Y-m-d");				
						elseif($defType === "timeStamp") $paramArray[$f["Field"]] = date("H:i:s");						
						elseif($defType === "defaultOff") $paramArray[$f["Field"]] = "0";					
						elseif($defType === "defaultOn") $paramArray[$f["Field"]] = "1";
						#keep current database value
						elseif($defType === "dbSet") $paramArray[$f["Field"]] = $f["Field"];					
						elseif($defType === "publicUser"){
							if(!isset($_SESSION['userID'])) $paramArray[$f["Field"]] = "0";		
							else $paramArray[$f["Field"]] = $_SESSION['userID'];							
						}
						elseif($defType==="phpSessionID"){
							if(!isset($_SESSION)) session_start();
							$paramArray[$f["Field"]] = "'" . session_id() . "'";
						}
						elseif($defType=="postalFormat"){
							$paramArray[$f["Field"]] = $this->getCleanPostalFormat($paramArray[$f["Field"]]);
						}
						#other value specified in the constructor
						else{
							$paramArray[$f["Field"]] = $defType;
						}
					}
				
					#if we don't pass a value, use current database value
					if(!isset($paramArray[$f["Field"]]) || $defType == "dbSet") {
						$tempValue = $f["Field"];
					}
					#urldecode is required since it needs to stay encoded in the json
					else{
						if(isset($this->moduleSettings["encryptFields"]) && in_array($f["Field"],$this->moduleSettings["encryptFields"])){
							$tempValue = "'" . $GLOBALS["mysqli"]->real_escape_string($this->encString($f["Field"],trim($paramArray[$f["Field"]]),true)) . "'";
						}
						else{
							$tempValue = "'" . $GLOBALS["mysqli"]->real_escape_string(trim($paramArray[$f["Field"]])) . "'";
						}
						
						#get proper default for numeric fields
						$tempValue = $this->getDefaultFieldValue($f["Field"],$tempValue);
					}
			
					$queryValueString = $f["Field"] . "=" . $tempValue;
					array_push($queryValueContainer,$queryValueString);
				}
			}
						
			#build and run query
			$valueString = implode(",",$queryValueContainer);
			$query = "UPDATE " . $this->moduleTable . "  SET " . $valueString . " WHERE priKeyID ='". $GLOBALS["mysqli"]->real_escape_string($paramArray["priKeyID"])."'";
			$result = $this->getCheckQuery($query);

			#this record is mapped to others
			if(isset($this->mappingArray)) {
				$this->addEditModuleMappings($paramArray["priKeyID"],$paramArray);
			}
													
			#return the ID we just updated
			if($this->ajax) echo trim($paramArray["priKeyID"]);
			else return trim($paramArray["priKeyID"]);		
		}
		
		/*in strict mode, we cannot try to insert empty strings
		into integer fields in mysql. so we check the value
		we're trying to pass, check the field type, if we are 
		passing and empty string, and it's an interger field,
		check to see if we allow NULLS and if there is a default
		value.*/
		public function getDefaultFieldValue($field, $insertValue){
			
			#field we're updating is just going to use the existing value
			if($field == $insertValue){
				return $insertValue;
			}
			
			$sanitizedField = $GLOBALS["mysqli"]->real_escape_string($field);
			
			#get this field information
			$tableResults =  $GLOBALS["mysqli"]->query("
				SHOW COLUMNS FROM " . $this->moduleTable . " WHERE Field = '" . $sanitizedField . "'"
			);	
			$x = mysqli_fetch_assoc($tableResults);
						
			#value is a numeric type, check for default, or use NULL
			if(
				strpos($x["Type"],"int") !== false ||
				strpos($x["Type"],"numeric") !== false ||
				strpos($x["Type"],"decimal") !== false ||
				strpos($x["Type"],"float") !== false ||
				strpos($x["Type"],"double") !== false ||
				strpos($x["Type"],"bit") !== false
			){
				#empty string
				if(trim(strlen($insertValue)) == 0) {	
					/*we have an empty string that should be a 
					number, look for default value, or use NULL	*/		
					if(strlen($x["Default"]) > 0){
						$insertValue = $x["Default"];
					}
					else{
						$insertValue = "NULL";
					}
					
					return $insertValue;
				}
				#string isn't empty, use it
				else{
					#remove the quotes to check if its numeric or not
					$tempCheck = str_replace("'","",$insertValue);
					#if its a number use that
					if(is_numeric($tempCheck)){
						return $insertValue;
					}
					#check the default value
					elseif(is_numeric($x["Default"])){
						return $x["Default"];
					}
					#not a number, NULL it out
					else{
						return "NULL";
					}
				}
			}
			#not meric type, use value
			else{
				return $insertValue;
			}
		}
		
		public function addEditModuleMappings($priKeyID,$paramArray){
			
			/*keep our mapping classes in an associative array and call them from there
			we can only include each class once, but as we loop through the records we
			need to call the same class many times. the key to the array is the class path
			*/
			if(!isset($this->mapModule)){
				$this->mapModule = array();
			}

			#loop through mapping arrays
			$mapLen = count($this->mappingArray);	
			for($x = 0; $x < $mapLen; $x++){
				/*only do the mapping stuff if we are 
				passing in mapping functionality parameters*/
				if(isset($paramArray[$this->mappingArray[$x]["fieldName"]])) {
					#loop through settings for this mapping array
					#create object for our mapping class, which is the most recent created class
					include_once($_SERVER['DOCUMENT_ROOT'].$this->mappingArray[$x]["apiPath"]);
					
					if(!isset($this->mapModule[$this->mappingArray[$x]["apiPath"]])) {
						$recentClasses = get_declared_classes();
						$mappingClass = end($recentClasses);
						$this->mapModule[$this->mappingArray[$x]["apiPath"]] = new $mappingClass(false);
					}

					$this->mapModule[$this->mappingArray[$x]["apiPath"]]->removeRecordsByCondition(
						$this->mappingArray[$x]["priKeyName"],$priKeyID
					);

					#loop through the records to be mapped to this module
					$recIDs = explode(",", $paramArray[$this->mappingArray[$x]["fieldName"]]);
	
					if(strlen($recIDs[0]) > 0) {
						$recQty = count($recIDs);
						for($y = 0; $y < $recQty; $y++){

							#insert record into mapping table
							$tempMapArray = array();
							$tempMapArray[$this->mappingArray[$x]["priKeyName"]] = $priKeyID;
							$tempMapArray[$this->mappingArray[$x]["fieldName"]] = $recIDs[$y];
							$this->mapModule[$this->mappingArray[$x]["apiPath"]]->addRecord($tempMapArray);
						}
					}
				}
			}
			
			return true;
		}
		
		#when we add bulk records we want to add the priKeyID to the priKeyID form field
		#we build up an array of the priKeyID fields mapping to the added/edited priKeyID
		public function bulkAddEdit($addEditData){
			
			#we don't want the ajax returns on our addRecord and updateRecord functions
			$tempAjax = $this->ajax;
			$this->ajax = false;
			
			#array to store our priKeyID's
			$arrayID = array();
			
			foreach($addEditData as $updateData){
				
				$arrayID[$updateData["priKeyField"]] = array();
				
				#adding a new record
				if(isset($updateData["priKeyID"]) && is_numeric($updateData["priKeyID"])){
					$arrayID[$updateData["priKeyField"]]["priKeyID"] = $this->updateRecord($updateData);
				}
				#updating an existing record
				else{
					$arrayID[$updateData["priKeyField"]]["priKeyID"] = $this->addRecord($updateData);
				}
				
				#get our groupID for our recent update/added record
				$tempBulkRec = $this->getRecordByID($arrayID[$updateData["priKeyField"]]["priKeyID"]);
				$tmpBlkRec = mysqli_fetch_assoc($tempBulkRec);
				
				$arrayID[$updateData["priKeyField"]]["groupID"] =$tmpBlkRec["groupID"];
			}
					
			#reset ajax
			$this->ajax = $tempAjax;
						
			#return JSON or php array of added/edited arrays
			if($this->ajax) echo json_encode($arrayID);
			else return $arrayID;
		}
		
		public function setupRecord(){
			#set our pmpm as a $_GET again for easier access in the include
			$_GET["pmpmID"] = func_get_arg(0);
			
			#query results set in pages.php getPage
			global $pageInfo;

			if(
				!isset($_REQUEST["recordID"]) && 
				(	#adding through the build add/edit
					!isset($this->isTemplate) || 
					(isset($this->isTemplate) && $this->isTemplate==0)
				)
			) { 
				#setup the module instance for bulk modifications
				$_REQUEST["bulkMod"] = true;
				#we need a uniqueID if we are bulk adding
				$_REQUEST["recordID"] = uniqid("tempBlkAdd");
			}

			include($_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/pages/pageModuleBuild.php");
			
			$moduleArray = array();
			$moduleArray["DOM"] = $beforeModuleCode . $afterModuleCode;
			$moduleArray["JS"] = $_GET["moduleScripts"];
			$moduleArray["CSS"] = $_GET["moduleStyles"];
			
			if($this->ajax) echo json_encode($moduleArray);
			else return $moduleArray;	
		}
		
		#this function is called through the JSONParse.php, in the future we might want to use ajaxParse
		#since its JSONParse our $recordList param is an array of all the POST\GET parameters, so we need 
		#specificy the array location to get our priKeyIDList
		public function updateRecordOrder(){
			$paramArray = func_get_arg(0);
			$recordArray = explode(",",$paramArray["recordList"]);
			
			#update our records ordinal field in the order that they come in at
			$rc = count($recordArray);
			$i = 0;
			while($i < $rc){
				$paramsArray = array();
				$paramsArray["ordinal"] = $i;
				$paramsArray["priKeyID"] = $recordArray[$i];
				
				#the object will most likely be ajax, and we don't want to echo the updated id's, so we supress output
				ob_start();
				$this->updateRecord($paramsArray);
				ob_end_clean();

				$i++;
			}
		}
	
		#remove live and draft for a specific record
		public function removeLiveDraftByID($recordID){
			
			#we don't want the ajax returns on removeLiveByID function
			$tempAjax = $this->ajax;
			$this->ajax = false;
			
			$finalLiveRecord = $this->getRecordByID($recordID);
			$liveResult = mysqli_fetch_assoc($finalLiveRecord);
			echo $this->priKeyID = $liveResult["priKeyID"];
		
			#If a table contains isDraft field
			if(strpos($this->tableRecords,"isDraft") !== false){		
				$this->isDraft = $liveResult["isDraft"];
				$this->draftPriKeyID = $liveResult["draftPriKeyID"];
				$this->livePriKeyID = $liveResult["livePriKeyID"];
				
				/*if the live and draft are null, its probably an old record
				therefore we should make the livePriKeyID equal to the priKeyID*/
				if($this->draftPriKeyID == NULL && $this->livePriKeyID == NULL){
					$this->livePriKeyID = $liveResult["priKeyID"];
				}
								
				#update draftPrikeyID to null 
				$finalLiveArray = array();
				$finalLiveArray["draftPriKeyID"] = ' ';
				$finalLiveArray["priKeyID"] = $this->livePriKeyID;
				
				/*
				check the condition for draft data
				delete the draft data if users click on DraftDelete link,
				delete the live if users click on live Delete link,
				update draftPriKeyID as null for the live data 
				and delete the draft data if both live and draft data exist, and if users
				click on DraftDelete link,
				delete both live and draft data if both live and draft data exist, and if users click on Delete link
				*/
				

				#only live record
				if($this->draftPriKeyID == NULL && $this->isDraft == false && is_numeric($this->livePriKeyID)){
					return $this->removeRecordByID($this->livePriKeyID);
				}
				#this is a draft with no live record
				else if($this->livePriKeyID == NULL && $this->isDraft == true){
					return $this->removeRecordByID($this->draftPriKeyID);
				}
				#delete draft, update live to remove draft
				else if($this->livePriKeyID > 0 && $this->isDraft == true){
					$this->updateRecord($finalLiveArray);
					return $this->removeRecordByID($this->draftPriKeyID);
				}
				#remove live and draft
				else if($this->draftPriKeyID > 0 && $this->isDraft == false){
					$this->removeRecordByID($this->draftPriKeyID);
					$this->removeRecordByID($this->livePriKeyID);
				}
			}
			else {
				$this->removeRecordByID($this->priKeyID);
			}
				
			$this->ajax = $tempAjax;		
		}
		
		#remove record by priKeyID
		public function removeRecordByID($recordID){	
			$tempAjax = $this->ajax;
			$this->ajax = true;
			$tempReturn = $this->getCheckQuery(
				"DELETE FROM " . $this->moduleTable . " WHERE priKeyID = " . $GLOBALS["mysqli"]->real_escape_string($recordID)  . " LIMIT 1"
			);
			$this->ajax = $tempAjax;	

			return $tempReturn;
		}
		
		public function removeRecordsByCondition($fieldName, $recordID){					
			return $this->getCheckQuery(
				"DELETE FROM " . $this->moduleTable . " WHERE `" . $GLOBALS["mysqli"]->real_escape_string($fieldName) . "` = " . $GLOBALS["mysqli"]->real_escape_string($recordID)
			);														
		}
		
		#Delete a file or recursively delete a directory @param string $str Path to file or directory 
		public function recursiveDelete($str){
			if(is_file($str))return @unlink($str);		
			elseif(is_dir($str)){
				$scan = glob(rtrim($str,'/').'/*');
				foreach($scan as $index=>$path) $this->recursiveDelete($path);
				return @rmdir($str);
			}
		}
		
		#returns the number of days in a given month for a given year
		public function monthDayAmount($someMonth, $someYear){
			return date("t", strtotime($someYear . "-" . $someMonth . "-01"));
		}
		
		/*security levels
		0 - anyone
		1 - must be logged in
		2 - users data
		3 - admin
		4 - super admin*/
		public function checkSecurityLevel($functionName){	
			$sanitizedFunction = $GLOBALS["mysqli"]->real_escape_string($functionName);
			if(!isset($_SESSION)) session_start();
			if(!isset($_SESSION['sessionSecurityLevel'])) {
				$_SESSION['sessionSecurityLevel'] = 0;
			}
						
			#we only need to do security checks on ajax calls
			if(!isset($GLOBALS["ajaxRunFunction"]) && !isset($GLOBALS["ajaxmodData"])) {
				return true;
			}
						
			#check to see if funtion is mapped in our security table
			$tableResults =  $GLOBALS["mysqli"]->query("
				SHOW COLUMNS FROM class_security WHERE Field = '" . $sanitizedFunction . "'"
			);

			if(mysqli_num_rows($tableResults) > 0){
				$result = $GLOBALS["mysqli"]->query("
					SELECT " . $sanitizedFunction . " as secLvl 
					FROM class_security WHERE classTableName = '" . $this->moduleTable . "'"
				);
						
				#only do security checks on classes that we've setup
				if(mysqli_num_rows($result) > 0){
					$i = mysqli_fetch_assoc($result);
					
					if($i["secLvl"] <= $_SESSION['sessionSecurityLevel']){
						#evaluate if this is a record the user can updated
						if($i["secLvl"] == 2){}
						return true;
					}
					else return "Security level too low";
				}
				else return "Module security not set";
				
				return true;
			}
			#not mapped, assume it's not secure
			else return "Function security not set";
		}
		
		public function get_include_contents($filename,$args=null) {
			if(is_file($filename)){
				if (PHP_VERSION_ID < 50600)
				{
					//These are settings that can be set inside code
					iconv_set_encoding("internal_encoding", "UTF-8");
					iconv_set_encoding("input_encoding", "UTF-8");
					iconv_set_encoding("output_encoding", "UTF-8");
				}
				elseif (PHP_VERSION_ID >= 50600)
				{
					ini_set("default_charset", "UTF-8");
				}
				ob_start("ob_iconv_handler");
				include $filename;
				$contents = ob_get_contents();
				ob_end_clean();
				return $contents;
			}
			return false;
		}
		
		#use to get values from module setting tables, publ
		public function getTableColumns($table = false){
			
			#use parameter if passed. passed when setting up module object, not instance object
			$table = $table ? $table : $this->moduleTable;
			$tableResults = $GLOBALS["mysqli"]->query("SHOW COLUMNS FROM " . $table);
			return $tableResults;
		}		
		
		#make setting table values properties of this object
		public function setModuleSettings(){
			
			#determine if there are domain specific settings for this module
			$tableFields = $this->getTableColumns($this->settingTable);
			$domainSettings = false;
			while($x = mysqli_fetch_assoc($tableFields)) {
				if($x["Field"] == "domainID"){
					$domainSettings = true;
					break;
				}
			}
			mysqli_data_seek($tableFields, 0);
			
			#get settings based on query if needed
			if($domainSettings) {
				#user the same settings instance for the public and admin side
				$settingsQuery = "SELECT * FROM $this->settingTable WHERE domainID = " . abs($GLOBALS["mysqli"]->real_escape_string($_SESSION["domainID"]));
			}
			else{
				$settingsQuery = "SELECT * FROM $this->settingTable";
			}
			
			
			$y = mysqli_fetch_assoc(
				$GLOBALS["mysqli"]->query($settingsQuery)
			);

			while($x = mysqli_fetch_assoc($tableFields)) {
				if($x["Field"] != "priKeyID"){
					$this->$x["Field"] = $y[$x["Field"]];
				}
			}
		}
		
		#dynamically creates javascript functions with specified parameters
		#we should set this so it takes x number of parameters, maybe in an array
		public function createInstanceOnclick($priKeyID=false,$parentID=false,$pageID=false,$miscID=false){
			$jsFunctions = explode("?^^?",$this->onclickEvent);
			$jsFunParams = explode("?^^?",$this->onclickParams);
			$onclickStr = "";
			$i = 0;
			
			foreach($jsFunctions as $js){
				if($priKeyID) $params = str_replace("{priKeyID}",$priKeyID,$jsFunParams[$i]);
				if($parentID) $params = str_replace("{parentID}",$parentID,$params);
				if($pageID) $params = str_replace("{pageID}",$pageID,$params);
				else $params = str_replace("{pageID}",$_GET["pageID"],$params);
				
				if(strlen($onclickStr) === 0) $onclickStr = $jsFunctions[$i] . "(" . $params . ")";
				else $onclickStr .= ";" . $onclickStr;

				$i++;
			}
			
			return $onclickStr;
		}
		
		#takes a specified field from a query and puts it into a delimited string
		public function getQueryValueString($mysqlQuery,$fieldName,$delimiter = ","){
			$returnString = "";
			
			if(mysqli_num_rows($mysqlQuery) > 0){
				mysqli_data_seek($mysqlQuery,0);
				while($x = mysqli_fetch_assoc($mysqlQuery)){
					if(strlen($returnString) === 0) $returnString = $x[$fieldName];			
					else $returnString .= $delimiter . $x[$fieldName];				
				}
				mysqli_data_seek($mysqlQuery,0);
			}
			
			return $returnString;
		}
			
		public function setInstanceModuleParams(
			$pmpm, #either the pmpmID or the records for the pmpm
			$parentRecordID = false
		){
			global $priModObj;
			
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/publicModulePageMap.php");
			$moduleObj = new module(false,NULL);
			$pageModuleMapObj = new publicModulePageMap(false,NULL);

			#if the queries haven't been previously setup
			if(is_numeric($pmpm)){
				#get pageID, moduleID and instanceID for this module instance
				$tmpPagModuleMap = $pageModuleMapObj->getRecordByID($pmpm);
				$tmpPMM = mysqli_fetch_assoc($tmpPagModuleMap);

				$pmpm = $moduleObj->getModuleInfoQuery(NULL,$tmpPMM["priKeyID"]);	
				$pmpm = mysqli_fetch_assoc($pmpm);	
				
				/*may 4th - jared - this was causing smaller ajax requests
				to ajaxParse.php to not work, as it was throwing in
				an extra parameter into our function calls, ex, using 
				getConditionalRecord to call gallery images for a chosen
				gallery on a module*/
				/*if(!isset($_GET["pageID"])) {
					$_GET["pageID"] = $tmpPMM["pageID"];
				}*/
			}
			
			$moduleTable = $moduleObj->getTableColumns();
			$pageModuleMapTable = $pageModuleMapObj->getTableColumns();
			
			#we create a JSON object that we use for our modulee properties on the client side
			$jsInstanceProp = array();
			
			$jsInstanceProp["modProp"] = array();
			$jsInstanceProp["instanceProp"] = array();
			
			#general module settings
			while($x = mysqli_fetch_assoc($moduleTable)){

				#language labels are stored in JSON, don't need them in the js object
				if($x["Field"] == "languageLabels"){
					$this->{$x["Field"]} = json_decode($pmpm[$x["Field"]],true);
				}
				else{
					$this->{$x["Field"]} = $pmpm[$x["Field"]];
					$jsInstanceProp["modProp"][$x["Field"]] = $pmpm[$x["Field"]];
				}
			}
			
			#public module page map settings
			while($x = mysqli_fetch_assoc($pageModuleMapTable)){
				$this->{$x["Field"]} = $jsInstanceProp["instanceProp"][$x["Field"]] = $pmpm[$x["Field"]];
			}
			
			#module settings
			if(isset($this->settingTable) && strlen($this->settingTable) > 0){
				$this->setModuleSettings();
			}
						
			#use it when we're putting modules in modules
			$this->originalClassName = $this->className;

			/*instance table settings - can can't include this in getModuleInfoQuery, because
			getModuleInfoQuery isn't a function of our $priModObj, its a function of the module
			class/object, so we don't know what the instance table is*/
			if(
				isset($this->instanceTable) && 
				strlen($this->instanceTable) > 0 && 
				is_numeric($this->instanceID)
			){
				$instanceTable = $this->getTableColumns($this->instanceTable);

				$instanceRecords = $this->getCheckQuery(
					"SELECT * FROM $this->instanceTable WHERE priKeyID = ".
					$GLOBALS["mysqli"]->real_escape_string($this->instanceID)
				);
					
				#loop through table fields
				while($x = mysqli_fetch_assoc($instanceTable)){ 
					/*we don't want the priKeyID of the instance 
					table to be the priKeyID of our priModObj*/
					if($x["Field"] != "priKeyID"){
						#loop through records
						while($y = mysqli_fetch_assoc($instanceRecords)) {
							if(
								!isset($this->{$x["Field"]}) || 
								(isset($this->{$x["Field"]}) && strlen($y[$x["Field"]]))
							){
								$this->{$x["Field"]} = $jsInstanceProp["instanceProp"][$x["Field"]] = $y[$x["Field"]];
							}
						}
						if(mysqli_num_rows($instanceRecords) > 0) {
							mysqli_data_seek($instanceRecords,0);
						}
					}
				}
			}
			
			
			#if the module level is 2 or greater, the class name is level1 and level2 appended
			#this way we still have correct jsobjects and unique id's
			/*if($moduleLevel > 1){
				$this["className"] = $this["className"] . $this["className".(-1)] . "_" . $parentRecordID;
				$jsInstanceProp["className"] = $_GET["className"];
			}*/

			/*to keep our instance module URL params seperate they're passed in a JSON object. parse this 
			object and add to our $_REQUEST["module".$x] array where $x is the priKeyID of the
			public_module_page_map*/
			#JSON needs double quotes, but our client is using singles right now... should just be fixed			
			include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/pmpmParse.php");

			if(isset($requestPMPM) && isset($requestPMPM[$this->priKeyID])){

				foreach($requestPMPM[$this->priKeyID] as $key => $value){
					#only set once per instance
					#if(!isset($this->$key)){
						$this->$key = $value;

						#setup module fram pagination value
						if($key == "pagPage") {
							$this->pagPage = $value;
						}
					#}
				}
			}
						
			#DEFAULT FROM public_pages - set in pages.php 
			if(isset($_REQUEST["defPageURLParams"]) && strlen($_REQUEST["defPageURLParams"]) > 0){
				$defURLArray = explode('&',$_REQUEST["defPageURLParams"]);
				foreach($defURLArray as $value){
					$tempArray = explode( '=', $value );
					$this->{$tempArray[0]} = $tempArray[1];
					
					#parameter isn't for a module instance
					if($tempArray[0] !== "pmpm") {
						#default page parameters need to be $_REQUESTs too, used for disqus
						$_REQUEST[$tempArray[0]] = $tempArray[1];
					}
					#pmpm json type string passed through defPageURLParams
					else if(
						!isset($_REQUEST["pmpm"]) && 
						/*look in the string to make sure these   
						defPageURLParams are for this instance*/
						strpos($tempArray[1],'"' . $this->priKeyID . '":') !== false &&
						!isset($_GET["pmpmSet"])
					){
						$_REQUEST[$tempArray[0]] = $tempArray[1];
						
						#determine if we've set a $_REQUEST
						$_GET["pmpmSet"] = true;
					}
					#actualy GET/POST from the browser. attach it to our defPageURLParams
					else if(
						isset($_REQUEST["pmpm"]) && 
						/*look in the string to make sure these   
						defPageURLParams are for this instance*/
						strpos($tempArray[1],'"' . $this->priKeyID . '":') !== false && 
						!isset($_GET["pmpmSet"])
					){
						#existing pmpm
						$_REQUEST["pmpm"] = urldecode($_REQUEST["pmpm"]);
						$_REQUEST["pmpm"]= str_replace("(","{",$_REQUEST["pmpm"]);
						$_REQUEST["pmpm"] = str_replace(")","}",$_REQUEST["pmpm"]);
						$tempReqJSON = json_decode($_REQUEST["pmpm"],true);
						
						#page defaults
						$tempArray[1] = str_replace("(","{",$tempArray[1]);
						$tempArray[1] = str_replace(")","}",$tempArray[1]);
						$tempJSON = json_decode($tempArray[1],true);
						
						#combine arrays
						$_REQUEST["pmpm"] = json_encode(array_merge($tempReqJSON,$tempJSON));
						
						#determine if we've set a $_REQUEST
						$_GET["pmpmSet"] = true;
					}
				}
			}
			
			/*DEFAULTS FROM public_module_page_map- done after the pages
			to overwrite the same param from pages, since the public_module_page_map
			is more specific per instance*/
			if(strlen($this->defURLString) > 0){
				$defURLArray = explode('&',$this->defURLString);
				foreach($defURLArray as $value){
					$tempArray = explode( '=', $value );
					$this->{$tempArray[0]} = $tempArray[1];
				}
			}
			
			#if we overrideRequests is set to 0, add URL parameters to this object
			if(isset($_REQUEST)){
				#loop through all request variables
				foreach($_REQUEST as $key => $value){
					#if the parameter isn't on this object, or it is
					#but we are allowed to override it
					if(
						!isset($this->{$key}) ||
						(isset($this->{$key}) && $this->overrideRequests == 0)
					) {
						#pmpm URL string
						if($key == "pmpm"){
			 
							/*for some reason a www redirect to non-www wasn't working with
							our pmpm parameter unless we urldecode it here*/ 
							
							$_REQUEST["pmpm"] = urldecode($_REQUEST["pmpm"]);
							      
							$tempJSON = json_decode($_REQUEST["pmpm"],true);
										 
							#our JSON was invalid. replace {} with () and try again
							if($tempJSON === NULL){
								$_REQUEST["pmpm"] = str_replace("(","{",$_REQUEST["pmpm"]);
								$_REQUEST["pmpm"] = str_replace(")","}",$_REQUEST["pmpm"]);
					
								$tempJSON = json_decode($_REQUEST["pmpm"],true);
							}
							
							if($tempJSON !== NULL){
								#loop through all the pmpm's in the string
								foreach($tempJSON as $key2 => $value2){
									#this is the pmpm for our current instance
									if($this->priKeyID == $key2){
										#loop through its properties
										foreach($value2 as $key3 => $value3){
											#once again check to see if this property is on
											#the object and if we can overwrite it
											if(
				 
												!isset($this->{$key3}) ||
												(isset($this->{$key3}) && $this->overrideRequests == 0)
				 
											) {
												$this->{$key3} = $value3;
											}
										}
									}
								}
							}
						}
						#regular request sting
						else{
							$this->{$key} = $_REQUEST[$key];
						}
					}
				}
			}
			
			if(isset($this->pagPage)){
				#set pagPage in another location since we over write it next
				$this->currentPagPage = $this->pagPage;
			}
			#replace ppToken with the pagPag when we create the pagination
			if(!isset($this->pagPage)){
				$this->pagPage = "ppToken";
			}
			
			#set this module to be bulk add/edit
			if(isset($_REQUEST["bulkMod"])){
				$this->bulkMod = $_REQUEST["bulkMod"];
			}
			
			/*if this is a level 2 or greater module, append the prikeyID 
			of the parent to the class name to keep unique id's in the html*/
			$objQty = count($priModObj);
			
			for($x = 0; $x < $objQty; $x++) {
				if(isset($priModObj[$x]) && isset($priModObj[$x]->queryResults)) {
					#used in the DOM
					$this->className .= $priModObj[$x]->queryResults["priKeyID"];
					#used for the JS objects
					$jsInstanceProp["instanceProp"]["className"] .= $priModObj[$x]->queryResults["priKeyID"];
				}
			}
		
			#used in the setModuleScript
			$this->jsonInstanceProp = json_encode($jsInstanceProp);
		}
		
		public function myySQLQueryToJSON($mySQLResult){
			$toBeJSON = array(); #array to be turned into JSON

			#build mutli dim. array from query. make it associative with pseudo index for easy JS access
			if(mysqli_num_rows($mySQLResult) > 0){
				mysqli_data_seek($mySQLResult,0);
				for($x = 0; $i = mysqli_fetch_assoc($mySQLResult); $x++) {
					$toBeJSON["prodIndex" . $x] = $i;
				}
				mysqli_data_seek($mySQLResult,0);
			}

			return json_encode($toBeJSON);
		}
		
		#returns number of dimensions in a multi dimensional array
		public function countdim($array){
   			if (is_array(reset($array))) $return = countdim(reset($array)) + 1;		
  		 	else $return = 1;
   			return $return;
  		}
			
		public function getUniqueName($fileName,$nameCnt){
			$fileNameInfo = pathinfo($fileName);
			
			#create the new file name
			$newFileName = $nameCnt . "_" . $fileNameInfo["filename"] . "." . $fileNameInfo["extension"];
			#the file name field in the db table must be fileName
			$nameCheck = $this->getConditionalRecord(array("fileName",$newFileName,true));
			
			#if its unique, return it
			if(mysqli_num_rows($nameCheck) > 0) return $this->getUniqueName($fileName,$nameCnt + 1);
			else return $newFileName;
		}
		
		#Helper function for displayInfo, if we ever need to change implementation, 
		#or simply decrypt a single record free from a result object, this is the way
		public function processRecord($record){

			#we can accept a mysql resource or an associative array
			if(
				#old mysql connection, maybe not needed
				#gettype($record) === "resource"
				gettype($record) === "object"
			) {
				if(!isset($this->bulkMod) && mysqli_num_rows($record) > 0){
					mysqli_data_seek($record,0);
				}
				$record = mysqli_fetch_assoc($record);
			}

			#if we don't have fields to decrypt then just return the row!
			if (!isset($this->moduleSettings["encryptFields"])) {
				return $record; 
			}
			#check to see if any of the fields to decrypt are in our results!
			if(gettype($record) === "array"){
				foreach($record as $key => $val){
					$tVal = "";
					if(in_array($key,$this->moduleSettings["encryptFields"])){
						$tVal = $this->encString($key,$val,true,false);
					}
					$record[$key] = (!empty($tVal)) ? $tVal : $val;
				}
				return $record;
			}
		}
		
		#gets a specific record from our query, and HTML sanitizes it
		public function displayInfo($arrayField){
			$y = $this->processRecord($this->queryResults);

			return htmlentities(
				html_entity_decode($y[$arrayField],ENT_QUOTES, "UTF-8"),
				ENT_QUOTES, 
				"UTF-8"
			); 
		}
		
		#changes a shortcode into the actual html for the module
		public function getModuleContents(
			$modulePath,$pmpmID,$pageInfo
		){
			global $priModObj;
			#cms framework modules
			if(isset($priModObj) && isset($priModObj[0]) && gettype($priModObj) !== "NULL"){
				#setup the query for this module
				include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleQuerySet.php");
				
				if(!isset($_GET["moduleRunScripts"])) $_GET["moduleRunScripts"] = "";
				$_GET["moduleRunScripts"] .=  $priModObj[0]->runFunction;
										
				#setup auto timers for the fade/clickslide modules
				include($_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/pages/moduleAutoSet.php");
			}
			
			$moduleCode = "";
				
			#we can't use get_include_contents because we need the $pMod query for file paths
			ob_start();	
			include($modulePath);
			$buffer = ob_get_contents();	
			ob_end_clean();
			
			#if we're using a short code
			if(isset($pageInfo) && strpos($pageInfo['pageCode'], "pmpmID" . $pmpmID) !== false){
				
				#determine short code type
				if(strpos($pageInfo['pageCode'], '<div id="pmpmID' . $pmpmID) !== false){
					$tempstr = '~<div id="pmpmID' . $pmpmID . '">.*</div>~';
				}
				elseif(strpos($pageInfo['pageCode'], '[pmpmID' . $pmpmID . ']') !== false){
					$tempstr = '/\[pmpmID' . $pmpmID . '\]/';
				}
				
				$tempReplace = uniqid();
				
				#replace regular expression with module code
				#If there are reguar expression characters in the buffer they will not be 
				#stripped out
				#\^${}[]()+?|<>-&
				$moduleCode = 
						preg_replace(
							$tempstr,
							$tempReplace,
							$pageInfo['pageCode']
						
					);
				#replace the unique string placed in the pageCode in the step above with the 
				#buffer contents
				$moduleCode = str_replace(
					$tempReplace,
					$buffer,
					$moduleCode
					
				);	
			}
			else {
				$moduleCode = $buffer;
			}
			
			return $moduleCode;
		}
		
		# Utility function to encode a string in base64 while remaining URI safe (replace + and / with - and _)
		public function base64UrlEncode($data){
			return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
		}
		
		# Utility function to decode a URI safe base64 string (replace - and _ with + and /)
		public function base64UrlDecode($base64){
			return base64_decode(strtr($base64, '-_', '+/'));
		}
		
		#Returns a hashed value of a string using a specified strength (defaults to sha1, which matches the corresponding js function)
		#
		# params:
		# $field - the field name
		# $string - the value to encrypt/hash
		# $encrypt - whether to encrypt (using AES) or hash (SHA256), defaults to hash
		# $direction - optional parameter, only needed when $encrypt = true; true will encrypt, false will decrypt
		#
		#  returns:
		#	The hashed / encrypted / decrypted string.
		#
		public function encString($field,$string,$encrypt=false,$direction=true){
			if(!$encrypt){
				return hash("sha256",$_SESSION["salt"] . $string);
			}
			else{
				require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/library/AES/AES.php');
				$crypto = new AES();
				$key = $crypto->pbkdf2(strrev($field),$_SESSION["salt"],2000,32);
				if($direction){
					return $crypto->encrypt($string, $key,true);
				}
				else{
					return $crypto->decrypt($string,$key,true);
				}
			}
		}
			
		#Generic function to generate the $(formID).validate() function for a given module instance
		#Also sets the list of required fields
		public function generateFormValidation($formID,$ruleString){
			$this->moduleSettings["requiredFormFields"] = array();
			if(empty($formID) || empty($ruleString)) return "";
			$validateFunction = "$('#".$formID."').validate({\n";
			$rules = $messages = "";
			#separate the fields
			$fields = explode("##", $ruleString);
			foreach($fields as $field){
				$field = explode("=>",$field);  #field[0] - fieldName // field[1] - rules
				$field[0] = trim($field[0]); #trim whitespaces
				$field[1] = trim($field[1]); #trim whitespaces 
				#iterate through each rule for the field
				$ruleArray = explode("&&",$field[1]);
				$subRules = $subMessages = "";
				foreach($ruleArray as $rule){
					$rule = explode("::",$rule); #rule[0] - condition name // rule[1] - condition parameter // rule[2] - condition message
					$rule[0] = trim($rule[0]); #trim whitespaces
					$rule[1] = trim($rule[1]); #trim whitespaces
					$rule[2] = trim($rule[2]); #trim whitespaces
					$subRules .= (!empty($rule[0]) && !empty($rule[1])) ? "\n\t\t\t" . $rule[0] . ": \t" . (($rule[0] == "pattern" || $rule[1] == "false" || $rule[1] == "true") ? $rule[1] : "'" . $rule[1] . "'") . "," : ""; #append rule to list if condition and param exist
					$subMessages .= (!empty($rule[0]) && !empty($rule[1]) && !empty($rule[2])) ? "\n\t\t\t" . $rule[0] . ":\t'" . $rule[2] . "'," : ""; #append message to list if condition and message exist
					if(strtolower($rule[0]) == "required" && !empty($field[0])){
						$this->moduleSettings["requiredFormFields"][] = $field[0];
					}
				}
				#add the field to the string of rules and messages if rules are present
				$rules .= (!empty($field[0]) && !empty($subRules)) ? "\n\t\t" . $field[0] . ": {" . trim($subRules,",") .  "\n\t\t}" . ",": "";
				$messages .= (!empty($field[0]) && !empty($subMessages)) ? "\n\t\t" . $field[0] . ": {" . trim($subMessages,",") .  "\n\t\t}" . ",": "";
			}
			$rules = (!empty($rules)) ? "\trules: {" .  trim($rules,",") . "\n\t}\n" : ""; #Don't return an empty parameter!
			$messages = (!empty($messages)) ? ",\tmessages: {" . trim($messages,",") . "\n\t}": "";
			return $validateFunction . $rules . $messages . "\n});";
		}
				
		#Fetch our module settings from the settings_modules table.
		protected function getSettings($instanceID = 0){

			$setQuery = $this->getCheckQuery(
				"SELECT * FROM settings_modules 
				WHERE moduleName = '" . $this->moduleTable . "' 
				AND (instanceID = '" . $GLOBALS["mysqli"]->real_escape_string($instanceID) . "' OR instanceID = '0' )"
			); 
			$settingsArray = array();
			while($setting = $setQuery->fetch_assoc()){#for each record
				switch(strtolower(trim($setting["paramType"]))){#trim and lowercase to make sure we're consistent
					case "string":
					case "str":
					case "text": #string / text / novel / etc.
						$settingsArray[$setting["paramName"]] = $setting["paramValue"];
						break;
					case "boolean":
					case "bool": # yes,no,true,false,0,1,on,off all work! if an invalid value is read we set it as NULL
						$settingsArray[$setting["paramName"]] = filter_var($setting["paramValue"], FILTER_VALIDATE_BOOLEAN,FILTER_NULL_ON_FAILURE);
						break;
					case "integer":
					case "int": # any number, can be in hex, octal, etc.
						if(filter_var($setting["paramValue"], FILTER_VALIDATE_INT)){
							$settingsArray[$setting["paramName"]] = intval($setting["paramValue"]);
						}
						else{
							$settingsArray[$setting["paramName"]] = NULL;
						}
						break;
					case "float":
					case "decimal": # any decimal number / float
						if(filter_var($setting["paramValue"], FILTER_VALIDATE_FLOAT) !== false){
							$settingsArray[$setting["paramName"]] = floatval($setting["paramValue"]);
						}
						else{
							$settingsArray[$setting["paramName"]] = NULL;
						}
						break;
					case "array":
					case "arr": #any array (as a comma separated list of strings, must be quoted strings as the explode expects them!
						$tmpArr = explode("\",\"",trim($setting["paramValue"],"\""));
						$settingsArray[$setting["paramName"]] = (!empty($tmpArr)) ? $tmpArr : NULL;
						break;
					case "narray":
					case "namedarray":
						$tempArr = explode(",",trim($setting["paramValue"]));
						$settingsArray[$setting["paramName"]] = array();
						foreach($tempArr as $kvpair){
							$kv = explode('=>',trim($kvpair,'"'));
							$settingsArray[$setting["paramName"]][trim($kv[0],'"')] = trim($kv[1],'"');
						}	 
						break;
				}
			}
			$this->moduleSettings = $settingsArray;
		}
		
		public function getModuleInstances(){
		}
		
		/**
		 * truncate_html()
		 *
		 * Truncates a HTML string to a given length of _visisble_ (content) characters.
		 * E.g. 
		 * "This is some <b>bold</b> text" has a visible/content length of 22 characters, 
		 * though the total string length is 29 characters.
		 * This function allows you to limit the visible/content length whilst preserving any HTML formatting.
		 *
		 * @param string $html
		 * @param int $length
		 * @param string $ending
		 * @return string
		 * @access public
		 */
		public function truncate_html($html, $length = 100, $ending = '...'){
			if (!is_string($html)) {
				trigger_error('Function \'truncate_html\' expects argument 1 to be an string', E_USER_ERROR);
				return false;
			}
		
			if (strlen(strip_tags($html)) <= $length) {
				return $html;
			}
			$total = strlen($ending);
			$open_tags = array();
			$return = '';
			$finished = false;
			$final_segment = '';
			$self_closing_elements = array(
				'area',
				'base',
				'br',
				'col',
				'frame',
				'hr',
				'img',
				'input',
				'link',
				'meta',
				'param'
				);
			$inline_containers = array(
				'a',
				'b',
				'abbr',
				'cite',
				'em',
				'i',
				'kbd',
				'span',
				'strong',
				'sub',
				'sup'
				);
			while (!$finished) {
				if (preg_match('/^<(\w+)[^>]*>/', $html, $matches)) { // Does the remaining string start in an opening tag?
					// If not self-closing, place tag in $open_tags array:
					if (!in_array($matches[1], $self_closing_elements)) {
						$open_tags[] = $matches[1];
					}
					// Remove tag from $html:
					$html = substr_replace($html, '', 0, strlen($matches[0]));
					// Add tag to $return:
					$return .= $matches[0];
				} elseif (preg_match('/^<\/(\w+)>/', $html, $matches)) { // Does the remaining string start in an end tag?
					// Remove matching opening tag from $open_tags array:
					$key = array_search($matches[1], $open_tags);
					if ($key !== false) {
						unset($open_tags[$key]);
					}
					// Remove tag from $html:
					$html = substr_replace($html, '', 0, strlen($matches[0]));
					// Add tag to $return:
					$return .= $matches[0];
				} else {
					// Extract text up to next tag as $segment:
					if (preg_match('/^([^<]+)(<\/?(\w+)[^>]*>)?/', $html, $matches)) {
						$segment = $matches[1];
						// Following code taken from https://trac.cakephp.org/browser/tags/1.2.1.8004/cake/libs/view/helpers/text.php?rev=8005.
						// Not 100% sure about it, but assume it deals with utf and html entities/multi-byte characters to get accureate string length.
						$segment_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $segment));
						// Compare $segment_length + $total to $length:
						if ($segment_length + $total > $length) { // Truncate $segment and set as $final_segment:
							$remainder = $length - $total;
							$entities_length = 0;
							if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $segment, $entities, PREG_OFFSET_CAPTURE)) {
								foreach($entities[0] as $entity) {
									if ($entity[1] + 1 - $entities_length <= $remainder) {
										$remainder--;
										$entities_length += strlen($entity[0]);
									} else {
										break;
									}
								}
							}
							// Otherwise truncate $segment and set as $final_segment:
							$finished = true;
							$final_segment = substr($segment, 0, $remainder + $entities_length);
						} else {
							// Add $segment to $return and increase $total:
							$return .= $segment;
							$total += $segment_length;
							// Remove $segment from $html:
							$html = substr_replace($html, '', 0, strlen($segment));
						}
					} else {
						$finshed = true;
					}
				}
			} // end of while
			
			// Check for spaces in $final_segment:
			if (strpos($final_segment, ' ') === false && preg_match('/<(\w+)[^>]*>$/', $return)) { // If none and $return ends in an opening tag: (we ignore $final_segment)
				// Remove opening tag from end of $return:
				$return = preg_replace('/<(\w+)[^>]*>$/', '', $return);
				// Remove opening tag from $open_tags:
				$key = array_search($matches[3], $open_tags);
				if ($key !== false) {
					unset($open_tags[$key]);
				}
			} else { // Otherwise, truncate $final_segment to last space and add to $return:
				// $spacepos = strrpos($final_segment, ' ');
				$return .= substr($final_segment, 0, strrpos($final_segment, ' '));
			}
			
			$return = trim($return);
			$len = strlen($return);
			$last_char = substr($return, $len - 1, 1);
			
			// if the last character is > we need to skip 
			if (!((preg_match('/[a-zA-Z0-9>]/', $last_char)))) {
				$return = substr_replace($return, '', $len - 1, 1);
			}
			
			// Add closing tags:
			$closing_tags = array_reverse($open_tags);
			$ending_added = false;
			foreach($closing_tags as $tag) {
				if (!in_array($tag, $inline_containers) && !$ending_added) {
					$return .= $ending;
					$ending_added = true;
				}
				$return .= '</' . $tag . '>';
			}
			return $return;
		}
		
		public function getCleanURLStr($string){
			#Replaces all spaces with hyphens.
			$string = str_replace(' ', '-', $string);
			
			#Removes special chars.
			$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
			
			#Replaces multiple hyphens with single one.
			#return preg_replace('/-+/', '-', $string);
			return $string;
		}
		
		public function getCleanPostalFormat($string){
			#Make everything uppercase
			$string = strtoupper($string);
			#Removes all spaces
			$string = str_replace(' ', '', $string);
			#return formatted postal code
			return $string;
		}
		
		public function getTableFieldJSON(){
			#echo array_flip($this->tableRecords);
			$tableFields = explode(',' , $this->tableRecords);
			echo json_encode(array_flip($tableFields));
			
			#var_dump($tableFields);
			#echo json_encode($tableFields);
			#echo ($tableFields);
			
		}
		
		#get a CSV dump for records currently listed for this module
		public function getCSVDump(){	
			
			mysqli_data_seek($this->primaryModuleQuery,0);
			if(mysqli_num_rows($this->primaryModuleQuery) > 0){
				#put table field names as headers in csv
				$row = mysqli_fetch_assoc($this->primaryModuleQuery);
				$line = "";
				$comma = "";
				#loop through the keys
				foreach($row as $key=>$value) {
					$line .= $comma . '"' . str_replace('"', '""', $key) . '"';
					$comma = ",";
				}
				$line .= "\n";

				#set the query back to start so we  can loop through the data
				mysqli_data_seek($this->primaryModuleQuery,0);
				#append query data
				while($row = mysqli_fetch_assoc($this->primaryModuleQuery)) {

					$comma = "";
					foreach($row as $value) {
						$line .= $comma . '"' . str_replace('"', '""', html_entity_decode($value)) . '"';
						$comma = ",";
					}
					$line .= "\n";

				}

				echo $line;
			}
		}
		
		public function importRecord(){	
			$paramArray = func_get_arg(0);								
			$finalParamValues = array();			
			$fieldNames = array();
			$tableFields = $this->getTableColumns(); #get table fields
			
			$queryValueContainer = array();		
			$defType = "";
									
			#build query string
			while($f =  mysqli_fetch_assoc($tableFields)){

				#if it's a groupID and we aren't passing a group ID, get the latest groupID
				if($f["Field"] == "groupID" && !is_numeric($paramArray[$f["Field"]])) {
					$tempMaxResult = $this->getCheckQuery(
						"SELECT MAX(groupID) as groupID FROM $this->moduleTable"
					);

					$tempMax = mysqli_fetch_assoc($tempMaxResult);
					$tempMaxID = $tempMax["groupID"];
					$paramArray[$f["Field"]] = $tempMaxID+1;
				}

				#if it's a priKeyID field,
				if($f["Field"] == "priKeyID") {
					$priKeyID = $paramArray[$f["Field"]];						
				}

				#if it's a isDraft field,
				if($f["Field"] == "isDraft") {
					$isDraft = $paramArray[$f["Field"]];						
				}				

				#if it's a livePrikeyID field, select the data of livePrikeyID
				if($f["Field"] == "livePriKeyID") {
					$livePriKeyID = $paramArray[$f["Field"]];						
				}				

				#if it's a draftPrikeyID field, select the data of draftPrikeyID
				if($f["Field"] == "draftPriKeyID") {
					$draftPriKeyID = $paramArray[$f["Field"]];						
				}				

				#if we need a default value
				if(isset($this->addDefault[$f["Field"]])){

					$defType = $this->addDefault[$f["Field"]];

					if($defType === "dateStamp")$paramArray[$f["Field"]] = date("Y-m-d");
					elseif($defType === "timeStamp")$paramArray[$f["Field"]] = date("H:i:s");
					elseif($defType === "defaultOff")$paramArray[$f["Field"]] = "0";			
					elseif($defType === "defaultOn")$paramArray[$f["Field"]] = "1";
					#keep current database value
					elseif($defType === "dbSet")$paramArray[$f["Field"]] = $key;	
					elseif($defType === "publicUser"){
						if(!isset($_SESSION['userID']))$paramArray[$f["Field"]] = "0";
						else $paramArray[$f["Field"]] = $_SESSION['userID'];
					}
					elseif($defType=="phpSessionID"){
						session_start();
						$paramArray[$f["Field"]] = "'" . session_id() . "'";
					}
					#other value specified in the constructor
					else{
						$paramArray[$f["Field"]] = $defType;
					}
				}

				array_push($fieldNames,$f["Field"]);

				#urldecode is required since it needs to stay encoded in the json
				if(isset($paramArray[$f["Field"]])) {
					if(
						isset($this->moduleSettings["encryptFields"]) && 
						in_array($f["Field"],$this->moduleSettings["encryptFields"])
					){
						$tempValue = "'" . $GLOBALS["mysqli"]->real_escape_string(
							$this->encString(
								$f["Field"],
								urldecode(
									trim($paramArray[$f["Field"]])
								),
								true
							)
						) . "'";
					}
					else{
						$tempValue = "'" . $GLOBALS["mysqli"]->real_escape_string(
							urldecode(trim($paramArray[$f["Field"]]))
						) . "'";
					}
				}
				else $tempValue = '""';

				#get proper default for numeric fields
				$tempValue = $this->getDefaultFieldValue($f["Field"],$tempValue);

				array_push($finalParamValues,$tempValue);
				
				
				#reset default type
				$defType = "";
			}
			
			#build query string
			$tableFieldStr = implode(",",$fieldNames);
			$valueString = implode(",",$finalParamValues);
			$query = "INSERT INTO " . $this->moduleTable . " (" . $tableFieldStr . ") VALUES(". $valueString .")";

			#run query get record id
			$result = $this->getCheckQuery($query);					
			$newRec = $GLOBALS["mysqli"]->insert_id;
			
			#if the table has isDraft field, set the priKeyIDs to new priKeyID
			if(isset($isDraft)) {
				$draftArray = array();
				$liveArray = array();
				
				$draftArray["draftPriKeyID"] = $newRec;
				$draftArray["priKeyID"] = $newRec;
				
				$liveArray["livePriKeyID"] = $newRec;
				$liveArray["priKeyID"] = $newRec;
					
				#ajax - returns JSON. Set the ajax as a false so php returns query resource
				$tempAjax = $this->ajax;
				$this->ajax = false;
				
				#check whether it is draft or live and update the draftPriKeyID and LivePriKeyID while
				#adding the data. 1 is draft and 0 is live.
				if($isDraft==1){
					$newRec = $this->updateRecord($draftArray);
				}
				else if($isDraft==0){
					$newRec = $this->updateRecord($liveArray);	
				}
				
				$this->ajax = $tempAjax;
			}
			
			#if isDraft field exists, update the prikeyIDs for liveDraft or draftLive data.
			//if( (isset($livePriKeyID)) || (isset($draftPriKeyID)) ) {
			if(isset($isDraft)) {
				
				$exliveArray = array();
				$exdraftArray = array();
				
				$exdraftArray["draftPriKeyID"] = $newRec;
				$exdraftArray["livePriKeyID"] = $livePriKeyID;
				$exdraftArray["priKeyID"] = $livePriKeyID;
				
				$exliveArray["livePriKeyID"] = $newRec;
				$exliveArray["priKeyID"] = $draftPriKeyID;
				
				#ajax - returns JSON. Set the ajax as a false so php returns query resource
				$tempAjax = $this->ajax;
				$this->ajax = false;
				
				#If draftPriKeyID is null, update the draftPrikeyID as new PrikeyID where pirKeyID is livePriKeyID
				#do same for livePrikeyID as well
				if(($livePriKeyID>0) && ($draftPriKeyID==null)){
					$this->updateRecord($exdraftArray);
				}
				else if(($draftPriKeyID>0) && ($livePriKeyID==null)){
					$this->updateRecord($exliveArray);
				}
			
				$this->ajax = $tempAjax;
			}	
		
			#this record is mapped to others
			if(isset($this->mappingArray)) {
				$this->addEditModuleMappings($newRec,$paramArray);
			}

			if($this->ajax) echo trim($newRec);
			else return trim($newRec);	
		}
	}
?>