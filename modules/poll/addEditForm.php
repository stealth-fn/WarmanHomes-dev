<div id="moduleContainer">

	<form name="moduleForm" id="moduleForm" action="">

	<div>

		<label for='pollQuestion'>Poll Question:</label>

		<input 

						type="text" 

						id="pollQuestion" 

						name="pollQuestion" 

						size="45" 

						maxlength="255" 

						value="<?php echo displayInfo('pollQuestion') ?>"

		/>

	</div>

	

	<div id="pollOptionsContainer">

			<?php

				

				if(isset($pollOptions)){

					$itemIndex = 1;

					while($x = mysqli_fetch_array($pollOptions)){

						echo "<div class='moduleSubElement' id='pollOptionDiv" . $itemIndex . "'/>

							<div id='pollOptionInput" . $itemIndex . "'>

							<input class='modSubElRem' id='removeButton" .$itemIndex. "' name='removeButton" .$itemIndex. "' type='button' class='buttonDeleteSmall' onclick='moduleFormObj.required(\"pollOptionDesc" . $itemIndex . "\",false);removePollOption(" . $itemIndex . ");buildHtml.removeElement(\"pollOptionDiv" . $itemIndex . "\");'/>

								<label for='pollOptionDesc" . $itemIndex . "'>Option " .$itemIndex . "</label>" . 

								"<input 

										value='" . htmlentities(html_entity_decode($x['pollOptionDesc'],ENT_QUOTES),ENT_QUOTES) . "' 

										id='pollOptionDesc" .$itemIndex. "' 

										name='pollOptionDesc" .$itemIndex. "'

										class='pollOptionDesc'

										maxlength='255' 

										type='text'

									/>

							</div>

							<div id='pollOptionCount" . $itemIndex . "'><span>" . ($y['subOptionCounter'] == 0 ? "No" : $y['subOptionCounter']) . " Votes</span><input value='0' id='optionCounter" . $itemIndex . "' name='optionCounter" . $itemIndex . "' type='hidden'/></div>

							<input name='pollOptionID" .$itemIndex. "' id='pollOptionID" .$itemIndex. "' value='" .$x['priKeyID']. "' type='hidden'/>

						</div>

						";

						$itemIndex +=1;

					}

				}

			?>

		</div>

		<div>

			<input type="button" id="oneMorePollOption" class="buttonAddSmall" name="oneMorePollOption" value="Add Option" onclick="anotherOption()"/>	

		</div>

		<div>

			<label for='subOptionQuestion'>Sub-Option Question:</label>

			<input 

							type="text" 

							id="subOptionQuestion" 

							name="subOptionQuestion" 

							maxlength="255" 

							value="<?php echo displayInfo('subOptionQuestion') ?>"

			/>

		</div>

		

		<div id="pollSubOptionsContainer">

			<?php	

				if(isset($pollSubOptions)){

					$itemIndex = 1;

					while($y = mysqli_fetch_array($pollSubOptions)){

						echo "<div class='moduleSubElement' id='pollSubOptionDiv" . $itemIndex . "'/>

							<div id='pollSubOptionInput" . $itemIndex . "'>

							<input class='modSubElRem' id='removeButton" .$itemIndex. "' name='removeButton" .$itemIndex. "' type='button' class='buttonDeleteSmall' onclick='moduleFormObj.required(\"pollOptionDesc" . $itemIndex . "\",false);removePollSubOption(" . $itemIndex . ");buildHtml.removeElement(\"pollSubOptionDiv" . $itemIndex . "\");'/>

								<label for='pollSubOptionDesc" . $itemIndex . "'>Sub Option " .$itemIndex . "</label>" . 

								"<input 

										value='" . htmlentities(html_entity_decode($y['pollSubOptionDesc'],ENT_QUOTES),ENT_QUOTES) . "' 

										id='pollSubOptionDesc" .$itemIndex. "' 

										name='pollSubOptionDesc" .$itemIndex. "' 

										class='pollSubOptionDesc'

										maxlength='255' 

										type='text'

									/>

							</div>

							<div id='pollSubOptionCount" . $itemIndex . "'><span>" . ($y['subOptionCounter'] == 0 ? "No" : $y['subOptionCounter']) . " Votes</span><input value='0' id='subOptionCounter" . $itemIndex . "' name='subOptionCounter" . $itemIndex . "' type='hidden'/></div>

							<input name='pollSubOptionID" .$itemIndex. "' id='pollSubOptionID" .$itemIndex. "' value='" .$y['priKeyID']. "' type='hidden'/>

						</div>

						";

						$itemIndex +=1;

					}

				}

				

				if(isset($addEdit)){

					if($addEdit == 1){

						echo "<input name='priKeyID' id='priKeyID' value='" .$_POST["recordID"]. "' type='hidden'/>";					

						$addEditButtonValue = "Save Changes";

					}

					else{

						echo "<input name='priKeyID' id='priKeyID' value='0' type='hidden'/>";

						$addEditButtonValue = "Create Poll";

					}

				}

			?>		

		</div>

		<div>

			<input type="button" id="oneMorePollSubOption" class="buttonAddSmall" name="oneMorePollSubOption" value="Add Sub-Option" onclick="anotherSubOption()"/>		

		</div>

		

		<input 

			type="button" 

			id="moduleAddEditBtn" 

			name="moduleAddEditBtn" 

			value="<?php echo $addEditButtonValue; ?>" 

			onclick="addEditModule(this,'addEditPollOptions()')"

		/>

	</form>	

</div>