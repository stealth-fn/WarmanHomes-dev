<!--Property Name-->
<div>
	<label for='propertyName'>Propery Name</label>
	<input 
		type="text" 
		id="propertyName<?php echo $_REQUEST["recordID"]; ?>" 
		name="propertyName" 
		value="<?php echo $priModObj[0]->displayInfo('propertyName'); ?>"
	/>
</div>
<!--Property Price-->
<div>
	<label for='price'> Price (Do not include $)</label>
	<input 
		type="text" 
		id="price<?php echo $_REQUEST["recordID"]; ?>" 
		name="price" 
		maxlength="9" 
		value="<?php echo $priModObj[0]->displayInfo('price'); ?>"
	/>
</div>
<!--Property Price Time Frame-->
<?php 
if (strlen($priModObj[0]->displayInfo('propertyPayType')) < 1)
{
	?>
	<div>
	<label for='price'>Price Per ____ (Do not include /)</label>
	
	<input 
		type="text" 
		id="propertyPayType<?php echo $_REQUEST["recordID"]; ?>" 
		name="propertyPayType" 
		maxlength="9" 
		value="mo"
	/>
</div>
	<?php
}
else {
?>
<div>
	<label for='price'>Price Per ____ (Do not include /)</label>
	
	<input 
		type="text" 
		id="propertyPayType<?php echo $_REQUEST["recordID"]; ?>" 
		name="propertyPayType" 
		maxlength="9" 
		value="<?php echo $priModObj[0]->displayInfo('propertyPayType'); ?>"
	/>
</div>

<?php
}

?>
<!--Property Address-->
<div>
	<label for='address'> Address </label>
	<input 
		type="text" 
		id="address<?php echo $_REQUEST["recordID"]; ?>" 
		name="address" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('address'); ?>"
	/>
</div>
<!--Property City and Provice-->
<?php 
if (strlen($priModObj[0]->displayInfo('propertyPayType')) < 1)
{
	?>
	<div>
		<label for='address'> City,Prov </label>
		<input 
			type="text" 
			id="cityProv<?php echo $_REQUEST["recordID"]; ?>" 
			name="cityProv" 
			maxlength="255" 
			value="Saskatoon, SK"
		/>
	</div>
	<?php
}
else {
?>
	<div>
		<div>
		<label for='address'> City,Prov </label>
		<input 
			type="text" 
			id="cityProv<?php echo $_REQUEST["recordID"]; ?>" 
			name="cityProv" 
			maxlength="255" 
			value="<?php echo $priModObj[0]->displayInfo('cityProv'); ?>"
		/>
	</div>
</div>

<?php
}

?>
<!--Property Complete Address, Will be used to auto find location-->
<div>
	<label for='completeAddress'> Complete Address for Seach Map </label>
	<input 
		type="text" 
		id="completeAddress<?php echo $_REQUEST["recordID"]; ?>" 
		name="completeAddress" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('completeAddress'); ?>"
		onblur="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].updateCoordinate(this)"
	/>
</div>
<!--Latitude of Property - Should auto Pop-->
<div>
	<label for='latitude'> Latitude </label>
	<input 
		type="text" 
			id="latitude<?php echo $_REQUEST["recordID"]; ?>" 
			name="latitude" 
			size="45" 
			maxlength="50" 
			value="<?php echo $priModObj[0]->displayInfo("latitude"); ?>"
	/>
</div>
<!--Longitude of Property - Should auto Pop-->
<div>
	<label for='longitude'> Longitude </label>
	<input 
		type="text" 
			id="longitude<?php echo $_REQUEST["recordID"]; ?>" 
			name="longitude" 
			size="45" 
			maxlength="50" 
			value="<?php echo $priModObj[0]->displayInfo("longitude"); ?>"
	/>
</div>
<!--Contact Name-->
<div>
	<label for='contactName'> Contact Name</label>
	<input 
		type="text" 
		id="contactName<?php echo $_REQUEST["recordID"]; ?>" 
		name="contactName" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('contactName'); ?>"
	/>
</div>
<!--Contact Phone-->
<div>
	<label for='contactPhone'> Contact Phone </label>
	<input 
		type="text" 
		id="contactPhone<?php echo $_REQUEST["recordID"]; ?>" 
		name="contactPhone" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('contactPhone'); ?>"
	/>
</div>
<!--Number of Bedrooms-->
<div>
	<label for='numOfBedrooms'> Number of Bedrooms </label>
	<input 
		type="text" 
		id="numOfBedrooms<?php echo $_REQUEST["recordID"]; ?>" 
		name="numOfBedrooms" 
		maxlength="9" 
		value="<?php echo $priModObj[0]->displayInfo('numOfBedrooms'); ?>"
	/>
</div>
<!--Number of Bathrooms-->
<div>
	<label for='numOfBathrooms'> Number of Bathrooms </label>
	<input 
		type="text" 
		id="numOfBathrooms<?php echo $_REQUEST["recordID"]; ?>" 
		name="numOfBathrooms" 
		maxlength="9" 
		value="<?php echo $priModObj[0]->displayInfo('numOfBathrooms'); ?>"
	/>
</div>
<?php
	$propertyTypes = $propertyTypeObj->getAllRecords();
	
	if($propertyTypes->num_rows > 0){
		echo "
			<div 
				class='moduleSubElement'
			>
				<h3 onclick=\"$('#propertyTypes" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
					Properties with this type<span>&lt; click to toggle visibility</span>
				</h3>
				<div 
					id='propertyTypes" . $_REQUEST["recordID"] . "' 
					class='adminShowHideChild'
				>";
				while($x = mysqli_fetch_array($propertyTypes)){
					/*check to see if this one is mapped already, if it is, check it off*/
					
					 $typeMapped = $propTypeMapObj->getConditionalRecord(
						array("propertyID",$_REQUEST["recordID"],true,
							"typeID",$x["priKeyID"],true
						)	
						);
					 
					
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
								class='propertyType" . $x["priKeyID"] . "' 
								value='" . $x["priKeyID"] . "'
							/><span>" . $x["propertyType"] . "</span>
						</div>
					";
		}
		echo "
				</div>
			</div>
		";
	}
?>


<?php
	
	$propertyCities = $propertyCityeObj->getAllRecords();
	
	if($propertyCities->num_rows > 0){
		echo "
			<div 
				class='moduleSubElement'
			>
				<h3 onclick=\"$('#properyCity" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
					Properties in this City<span>&lt; click to toggle visibility</span>
				</h3>
				<div 
					id='properyCity" . $_REQUEST["recordID"] . "' 
					class='adminShowHideChild'
				>";
				while($x = mysqli_fetch_array($propertyCities)){
					/*check to see if this one is mapped already, if it is, check it off*/
					
					 $cityMapped = $propCityMapObj->getConditionalRecord(
						array(
							"propertyID",$_REQUEST["recordID"],true,
							"citiesID",$x["priKeyID"],true
						)
						);
					
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
								name='citiesID' 
								id='citiesID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
								class='propertiesCities" . $x["priKeyID"] . "' 
								value='" . $x["priKeyID"] . "'
							/><span>" . $x["cityName"] . "</span>
						</div>
					";
		}
		echo "
				</div>
			</div>
		";
	}
?>


<div
	<?php 
		if(isset($priModObj[0]->bulkMod)) {
			echo '
				class="bulkCKEditor ckEditContainer"
				id="bulkCKEditor' . $_REQUEST["recordID"] . '"
			'; 
		}
		else{
			echo 'class="ckEditContainer"';
		}
		
		if (strlen($priModObj[0]->displayInfo('propertyDesc')) < 1)
		{
			$propertyDescription = '<table class="headers">
										<tbody>
											<tr>
												<td>Description</td>
												<td>Amenities</td>
												<td>Leasing</td>
											</tr>
										</tbody>
									</table>
									<table class="descriptions">
										<tbody>
											<tr>
												<td><div class="tab-content">
														<h3>About the Property</h3>
														<p>No content available</p>
													</div></td>
											</tr>
											<tr>
												<td><div class="tab-content">
														<h3>Perks of the property</h3>
														<p>No content available</p>
													</div></td>
											</tr>
											<tr>
												<td><div class="tab-content">
														<p>No content available</p>
													</div></td>
											</tr>
										</tbody>
									</table>
									';
		}
		else {
			$propertyDescription = $priModObj[0]->displayInfo('propertyDesc');
		}
	?>
>
	<label for='propertyDesc'> Property Description </label>
	<textarea 
		id="propertyDesc<?php echo $_REQUEST["recordID"]; ?>"
		name="propertyDesc" 
		>
		<?php echo $propertyDescription; ?></textarea>
</div>
