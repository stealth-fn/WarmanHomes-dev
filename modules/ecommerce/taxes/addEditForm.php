<div>

	<label for='taxDesc'>

		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['taxDesc']; ?>

	</label>

		<input 

			type="text" 

			id="taxDesc<?php echo $_REQUEST["recordID"]; ?>" 

			name="taxDesc" 

			maxlength="255" 

			value="<?php echo $priModObj[0]->displayInfo('taxDesc'); ?>"

		/>

</div>

<div>

	<label for='taxAmount'>

		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['taxAmount']; ?>

	</label>

		<input 

			type="text" 

			id="taxAmount<?php echo $_REQUEST["recordID"]; ?>" 

			name="taxAmount" 

			maxlength="3" 

			value="<?php echo $priModObj[0]->displayInfo('taxAmount'); ?>"

		/>

</div>

<div class='radioGroupBlock'>						

	<label for='shipTax'>

		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shipTax']; ?>

	</label>

	<span>Yes

		<input

			type="radio"

			id="shipTaxYes<?php echo $_REQUEST["recordID"]; ?>"

			name="shipTax"

			value="1"

			<?php if($priModObj[0]->displayInfo('shipTax')==1){echo "checked='checked'";} ?> 

		/>

	</span>

	<span>No

		<input

			type="radio"

			id="shipTaxNo<?php echo $_REQUEST["recordID"]; ?>"

			name="shipTax"

			value="0"

			<?php if($priModObj[0]->displayInfo('shipTax')==0){echo "checked='checked'";} ?> 

		/>

	</span>

</div>

	

<?php

	#list taxable countries

	$countries = $countryObj->getConditionalRecord(array("isActive",1,true));

	if(mysqli_num_rows($countries) > 0){

		echo "<div class='moduleSubElement'>

				<h3 

					class=\"adminShowHideParent\"

					onclick=\"$('#taxableCountries" . $_REQUEST["recordID"] . "').toggle()\" 

				>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['countryTax'] . "

					<span>&lt; " . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span>

				</h3>

				<div id='taxableCountries" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";

				while($x = mysqli_fetch_assoc($countries)){

					if(isset($_REQUEST["recordID"])){

						$countryMapped = $locationTaxMapObj->getConditionalRecord(

							array(

								"countryID",$x["priKeyID"],true,

								"taxID",$_REQUEST["recordID"],true

							)

						);

					}

					

					$checked = "";

					if(isset($countryMapped) && mysqli_num_rows($countryMapped)){

						$y = mysqli_fetch_row($countryMapped);

						mysqli_data_seek($countryMapped,0);

						$checked = 'checked="checked"';

					}

	?>

					<div>

						<input 

							type='checkbox' 

							<?php echo $checked; ?> 

							id='countryID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 

							name='countryID' 

							class='taxableCountry' 

							value='<?php echo $x["priKeyID"]; ?>'

						/>

						<span><?php echo $x["country"]?></span>

					</div>

	<?php

				}

		echo "</div>

		</div>";

	}

	#list provinces and states

	$provStates = $provStateObj->getAllRecords();

	if(mysqli_num_rows($provStates) > 0){

		echo "<div class='moduleSubElement'>

				<h3  

					class=\"adminShowHideParent\"

					onclick=\"$('#taxableProvStates" . $_REQUEST["recordID"] . "').toggle()\" 

				>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['provState'] . "

					<span>&lt; " . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span></h3>

				<div id='taxableProvStates" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";



		while($x = mysqli_fetch_array($provStates)){



			if(isset($_REQUEST["recordID"])){

				$provStateMapped = $locationTaxMapObj->getConditionalRecord(

					array(

						"provStateID",$x["priKeyID"],true,

						"taxID",$_REQUEST["recordID"],true

					)

				);

			}

			

			$checked = "";

			if(isset($countryMapped) && mysqli_num_rows($provStateMapped)){

				$y = mysqli_fetch_row($provStateMapped);

				mysqli_data_seek($provStateMapped,0);

				$checked = 'checked="checked"';

			}

	?>

			<div>

				<input 

					type='checkbox' <?php echo $checked; ?> 

					id='provStateID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 

					name='provStateID' 

					class='taxableProvState' 

					value='<?php echo $x["priKeyID"]; ?>'

				/>

				<span><?php echo $x["provState"]; ?></span>

			</div>

				

		<?php

			}

			echo "</div>";

		}

	?>

	</div>

<?php

	#list products

	$products = $productsObj->getAllRecords();

	if(mysqli_num_rows($products) > 0){

		echo "<div class='moduleSubElement'>

				<h3  

					onclick=\"$('#taxableProducts" . $_REQUEST["recordID"] . "').toggle()\" 

					class=\"adminShowHideParent\"

				>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['taxableProducts'] . "

					<span>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span>

				</h3>

			<div id='taxableProducts" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";



		while($x = mysqli_fetch_array($products)){



			if(isset($_REQUEST["recordID"])){

				$prodMapped = $productTaxMapObj->getConditionalRecord(

					array(

						"productID",$x["priKeyID"],true,

						"taxID",$_REQUEST["recordID"],true 

					)

				);

			}

			

			$checked = "";

			if(isset($prodMapped) && mysqli_num_rows($prodMapped)){

				$y = mysqli_fetch_row($prodMapped);

				mysqli_data_seek($prodMapped,0);

				$checked = 'checked="checked"';

			}

	?>

			<div>

				<input 

					type='checkbox' <?php echo $checked; ?> 

					id='productID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 

					name='productID' class='taxableProvState' 

					value='<?php echo $x["priKeyID"]; ?>'

				/>

				<span><?php echo $x["productName"]; ?></span>

			</div>

	<?php

		}

		echo "</div>

		</div>";

	}

		

?>

