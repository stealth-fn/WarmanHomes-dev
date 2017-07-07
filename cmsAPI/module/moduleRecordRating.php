<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	class moduleRecordRating extends common{
		public $moduleTable = "module_record_ratings";

		/*submit a user rating. we don't do it directly in the ajax
		call because we need to make sure this IP address has only voted once*/
		public function addRating($value,$recordID,$moduleID){
			$this->ajax = false;

			#check to see if the user has voted for this record already
			$voteCheck = $this->getConditionalRecord(
				array(
					"moduleID", $moduleID, true,
					"moduleRecordPriKeyID", $recordID, true,
					"userIPAddress", $_SERVER["REMOTE_ADDR"], true,
				)
			);

			#they have already voted
			if(mysqli_num_rows($voteCheck) > 0) {
				echo "-1";
			}
			
			#they haven't voted yet, add their vote
			else{
				$paramsArray = array();
				$paramsArray["rating"] = $value;
				$paramsArray["moduleRecordPriKeyID"] = $recordID;
				$paramsArray["moduleID"] = $moduleID;
				$paramsArray["userIPAddress"] = $_SERVER["REMOTE_ADDR"];

				$tempPriKeyID = $this->addRecord($paramsArray);
				echo $tempPriKeyID;
			}
		}

		public function getRating($recordID,$moduleID){
			return $this->commonReturn(
				"	SELECT ROUND(AVG(rating)) as rating
					FROM " . $this->moduleTable . " 
					WHERE 
					moduleRecordPriKeyID = " . $GLOBALS["mysqli"]->real_escape_string($recordID) . " AND
					moduleID = " . $GLOBALS["mysqli"]->real_escape_string($moduleID)
			);
		}
	}

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new moduleRecordRating(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}

	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new moduleRecordRating(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}

?>