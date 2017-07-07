<div id="moduleContainer">

	<form name="moduleForm" id="moduleForm" action="">

		RSS Feed\Channel Name:<input type="text" id="title" name="title" size="45" maxlength="255" value="<?php echo displayInfo('title'); ?>"/><br />

		Link\URL:<input type="text" id="linkURL" name="linkURL" size="45" maxlength="255" value="<?php echo displayInfo('linkURL'); ?>"/><br />

		RSS Feed\Channel Description:<input type="text" id="description" name="description" size="45" maxlength="255"value=" <?php echo displayInfo('description'); ?>"/><br />

		

		<div id="rssItemContainer">

			<?php

				$addEditButtonValue = "Create RSS Feed";

				

				if(isset($rssItems)){

					$itemIndex = 1;

					while($x = mysqli_fetch_array($rssItems)){

						echo "<div class='moduleSubElement' id='rssDiv" . $itemIndex . "'/>

							<div>

								Title " .$itemIndex . ":<input value=\"" . htmlentities(html_entity_decode($x['title'],ENT_QUOTES),ENT_QUOTES) . "\" id='title" .$itemIndex. "' name='title" .$itemIndex. "' size='75' maxlength='255' type='text'/>

								<input class='modSubElRem' id='removeButton" .$itemIndex. "' name='removeButton" .$itemIndex. "' value='' type='button' onclick='moduleFormObj.required(\"title" . $itemIndex . ",description" . $itemIndex . "\",false);removeItem(" . $itemIndex . ");buildHtml.removeElement(\"rssDiv" . $itemIndex . "\");'/>

							</div>

							<div>

								Link " .$itemIndex . ":<input value=\"" . htmlentities(html_entity_decode($x['linkURL'],ENT_QUOTES),ENT_QUOTES) . "\" id='linkURL" .$itemIndex. "' name='linkURL" .$itemIndex. "' size='75' maxlength='255' type='text'/>

							</div>

							<div>

								Description " .$itemIndex . ":<input value=\"" . htmlentities(html_entity_decode($x['description'],ENT_QUOTES),ENT_QUOTES) . "\" id='description" .$itemIndex. "' name='description" .$itemIndex. "' size='75' maxlength='255' type='text'/>

							</div>

							<input name='rssItemID" .$itemIndex. "' id='rssItemID" .$itemIndex. "' value='" .$x['priKeyID']. "' type='hidden'/>

						</div>

						";

						$itemIndex +=1;

					}

				}

				

				if(isset($addEdit)){

					if($addEdit == 1){

						echo "<input name='priKeyID' id='priKeyID' value='" .$_POST["recordID"]. "' type='hidden'/>";					

						$addEditButtonValue = "Edit RSS Feed";

					}

					else{

						echo "<input name='priKeyID' id='priKeyID' value='0' type='hidden'/>";

					}

				}

			?>

		</div>

		

		<input type="button" id="oneMoreItem" name="oneMoreItem" value="Add Another RSS Item" onclick="anotherItem()"/>

				

		<input type="button" id="moduleAddEditBtn" name="moduleAddEditBtn" value="<?php echo $addEditButtonValue; ?>" onclick="addEditModule(<?php echo $addEdit; ?>,'addEditRSSItem(xmlResponse,addEdit)')"/>

	</form>

</div>