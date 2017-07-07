<?php	

	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	

	class pollVotes extends common{	

		public $moduleTable = "poll_votes";

				

		/*set a session variable so we know the last poll they participated in, so they

		can't participate in it again*/

		function setPrevPoll($prevPoll){

			if(isset($_SESSION) == false){

				session_start();	

			}

			$_SESSION["prevPollID"] = $prevPoll;

		}

		

		function getPollResults($pollID){			

			parent::openConn();

						

			$result = mysqli_query("SELECT pollOptionID,pollSubOptionID, COUNT(*) as Total 

			FROM poll_votes

			WHERE pollID = " . $GLOBALS["mysqli"]->real_escape_string($pollID) . "

			GROUP BY pollOptionID,pollSubOptionID

			");



			parent::closeConn();											

			return $result;

		}															

	}

	

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/

	if(isset($_REQUEST["function"])){	

		$moduleObj = new pollVotes(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');

	}	

	elseif(isset($_REQUEST["modData"])){

		$moduleObj = new pollVotes(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');

	}

?>