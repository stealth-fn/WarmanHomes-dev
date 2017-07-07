<div>
	<label for='propertyType'>
		Property Type Name
	</label>
	<input 
		type="text" 
		id="propertyType<?php echo $_REQUEST["recordID"]; ?>" 
		name="propertyType" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('propertyType'); ?>"
	/>
</div>

<div>
	<label for='propertyTypeDescription'>
		Property Type Description
	</label>
	<input 
		type="text" 
		id="propertyTypeDescription<?php echo $_REQUEST["recordID"]; ?>" 
		name="propertyTypeDescription" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('propertyTypeDescription'); ?>"
	/>
</div>

<?php
	$properies = $propertyObj->getAllRecords();
	
	if($properies->num_rows > 0){
		echo "
			<div 
				class='moduleSubElement'
			>
				<h3 onclick=\"$('#categorisedPosts" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
					Properties with this type<span>&lt; click to toggle visibility</span>
				</h3>
				<div 
					id='categorisedPosts" . $_REQUEST["recordID"] . "' 
					class='adminShowHideChild'
				>";
				while($x = mysqli_fetch_array($properies)){
					/*check to see if this one is mapped already, if it is, check it off*/
					if(isset($_REQUEST["recordID"])){
					 $typeMapped = $propTypeMapObj->getConditionalRecord(
						array("propertyID",$_REQUEST["recordID"],true,
							"typeID",$x["priKeyID"],true
						)	
						);
					 
					}
					if ($typeMapped->num_rows > 0){
						$checked = "checked='checked'";
					}
					else {
						$checked = "";
					}
	
					echo  "
						<div>
							<input 
								type='checkbox' 
								".$checked."
								name='typeID' 
								id='propertyID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
								class='propertyCity" . $x["priKeyID"] . "' 
								value='" . $x["priKeyID"] . "'
							/><span>" . $x["propertyName"] . "</span>
						</div>
					";
		}
		echo "
				</div>
			</div>
		";
	}
?>

