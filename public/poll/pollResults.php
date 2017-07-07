<?php

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/poll.php");

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollOption.php");

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollSubOption.php");

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollVotes.php");

	

	$pollObj = new poll(false);

	$pollOptionObj = new pollOption(false);

	$pollSubOptionObj = new pollSubOption(false);

	$pollVotesObj = new pollVotes(false);

	

	$poll = $pollObj->getAllRecords();

	

	echo "<div id='pollResultsContainer'><h2 class='moduleHeader'>Poll Results</h2>";

	while($x = mysqli_fetch_array($poll)){

	

		echo "<p 

				class='pollQuestion' 

				onclick='togglePollResult(" . $x["priKeyID"] . ")'

				>" .

				$x["pollQuestion"]. 

			"</p>";

			

		$pollResultInfo = $pollVotesObj->getPollResults($x["priKeyID"]);

		

		echo "<div 

				class='pollQuestionResultsContainer' 

				id='pollQuestionResultsContainer". $x["priKeyID"] .

			  "'>";

		while($y = mysqli_fetch_array($pollResultInfo)){

		

			$pollOption = $pollOptionObj->getRecordByID($y["pollOptionID"]);

			$pollSubOption = $pollSubOptionObj->getRecordByID($y["pollSubOptionID"]);

			

			$pollOptionDesc = "";

			$pollSubOptionDesc = "";

			

			$z = mysqli_fetch_array($pollOption);

			$pollOptionDesc = $z["pollOptionDesc"];

			

			$a = mysqli_fetch_array($pollSubOption);

			$pollSubOptionDesc = $a["pollSubOptionDesc"];

				

			echo "<p class='pollResultItem'>" . 

					$pollSubOptionDesc . " - ". $pollOptionDesc .":". $y["Total"] . 

				 "</p>";			

		}

		echo" </div>";	

	} 

	echo "</div>";

	

?>