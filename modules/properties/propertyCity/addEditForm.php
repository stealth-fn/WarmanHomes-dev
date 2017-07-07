<div>
	<label for='cityName'> City </label>
	<input 
		type="text" 
		id="cityName<?php echo $_REQUEST["recordID"]; ?>" 
		name="cityName" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('cityName'); ?>"
	/>
</div>

<?php
	$properies = $propertyObj->getAllRecords();
	
	if($properies->num_rows > 0){
		echo "
			<div 
				class='moduleSubElement'
			>
				<h3 onclick=\"$('#propertyCities" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
					Properties in this City<span>&lt; click to toggle visibility</span>
				</h3>
				<div 
					id='propertyCities" . $_REQUEST["recordID"] . "' 
					class='adminShowHideChild'
				>";
				while($x = mysqli_fetch_array($properies)){
					/*check to see if this one is mapped already, if it is, check it off*/
					if(isset($_REQUEST["recordID"])){
					 $cityMapped = $propCityMapObj->getConditionalRecord(
						array(
							"citiesID",$_REQUEST["recordID"],true,
							"propertyID",$x["priKeyID"],true
						)
						);
					}
					if ($cityMapped->num_rows > 0){
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
								name='propertyID' 
								id='propertyID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
								class='cities" . $x["priKeyID"] . "' 
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
