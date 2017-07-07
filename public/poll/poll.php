<?php

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/poll.php");

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollOption.php");

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollSubOption.php");

	

	$pollObj = new poll(false);

	$pollOptionObj = new pollOption(false);

	$pollSubOptionObj = new pollSubOption(false);

	

	#get the latest poll

	$poll = $pollObj->getMaxRecord();

	

	if(mysqli_num_rows($poll) > 0){

		$x = mysqli_fetch_array($poll); 

		$pollQuestion = $x["pollQuestion"];

		$subPollQuestion = $x["subOptionQuestion"];

		$pollID = $x["priKeyID"];

		$pollOptions = $pollOptionObj->getConditionalRecord(array("pollID",$x["priKeyID"],true));

		$pollSubOptions = $pollSubOptionObj->getConditionalRecord(array("pollID",$x["priKeyID"],true));

		

		if(isset($pollOptions) && mysqli_num_rows($pollOptions) > 0){

			echo "<div id='pollContainer'>";

			if((isset($_SESSION["prevPollID"])==true && $_SESSION["prevPollID"] != $pollID) || isset($_SESSION["prevPollID"])==false){

				echo "<h2 id='pollOption' class='moduleHeader pollOption'>" . $pollQuestion . "</h2>

						<form id='pollForm' name='pollForm' action=''>";

				while($y = mysqli_fetch_array($pollOptions)){

						echo $y['pollOptionDesc'];

						echo "<input 

									type='radio' 

									name='pollOptionID' 

									id='pollOptionID" . $y['priKeyID'] . "' 

									value='" . $y['priKeyID'] . "'

								/>";

				}

				if(isset($pollSubOptions) && mysqli_num_rows($pollSubOptions) > 0){

				?>

				<h2 id="pollSubOp" class="moduleHeader pollSubOp"><?php echo $subPollQuestion;?></h2>

				<?php

					echo "<select name='pollSubOption' id='pollSubOption'>";

						echo "<option value=''>Choose...</option>";

					while($z = mysqli_fetch_array($pollSubOptions)){

							echo "<option name='pollSubOptionID' id='pollSubOptionID" . $z['priKeyID'] . "' value='" . $z['priKeyID'] . "'>

								".$z['pollSubOptionDesc']."

							</option>";

					}

					echo "</select>";

				}

				echo "<input type='button' value='Submit' onclick='castVote()'/>

					<input type='hidden' value='" . $pollID . "' name='pollID' id='pollID' />";

				echo "</form>";

			}

			else{

				echo "<p>Thank you for participating</p>";

			}

				echo "</div>";

		}	

	}

?>