<?php
							
if(!isset($_REQUEST["pmpm"])) {
	$buildName = "";
	$cityName = "";
	$propName = "";
	$bedrooms = array();
}
else {	
	$tempJson = json_decode($_REQUEST["pmpm"],true);
	$buildName = $tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["Keyword"];
	$cityName = $tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["City"];
	$propName = $tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["propertyType"];
	$bedrooms = $tempJson[$priModObj[0]->ListPmpmID]["searchParams"]["bedroom"];
}
?>

<div 
	class="propertySearchContainer" 
	id="propertySearch">
<form 
		id="propertySearch" 
		name="propertySearch"  
		onsubmit="propertySearch_<?php echo $priModObj[0]->className; ?>.propertySearch(this); return false"
	>
	<div class="field col1">
		<label>Property Name:</label>
		<input 
				id="Keyword" 
				maxlength="100"
				name="Keyword"  
				type="text"
				<?php
					echo 'value = "'. $buildName .'"';
				?>
			/>
	</div>
	<div class="field col2">
		<div class="cityDropdown">
			<label>City:</label>
			<div>
				<select id="city">
					<option value="0">All Cities</option>
					<?php 
							include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/propertyCity/propertyCity.php");
							$propertyCityeObj = new propertyCities(false);
							$cityList = $propertyCityeObj->getAllRecords();
														
							while($x = mysqli_fetch_array($cityList)){
								
								if ($cityName == $x["priKeyID"]) {
									echo '<option selected value="'. $x["priKeyID"] .'">'. $x["cityName"].'</option>';
								}
								else {
									echo '<option value="'. $x["priKeyID"] .'">'. $x["cityName"].'</option>';
								}
							}
						?>
				</select>
			</div>
		</div>
	</div>
	<div class="field col1">
		<div class="cityDropdown">
			<label>Property Type:</label>
			<div>
				<select id="propertyType">
					<option value="0">All Types</option>
					<?php 
							include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/properties/propertyType/propertyType.php");
							$propertyTypeObj = new propertyType(false);
							$propertyTypeList = $propertyTypeObj->getAllRecords();
														
							while($x = mysqli_fetch_array($propertyTypeList)){
								
								if ($propName == $x["priKeyID"]) {
									echo '<option selected value="'. $x["priKeyID"] .'">'. $x["propertyType"].'</option>';
								}
								else {
									echo '<option value="'. $x["priKeyID"] .'">'. $x["propertyType"].'</option>';
								}
							}
						?>
				</select>
			</div>
		</div>
	</div>
	<?php
	
	$bed1 = "";
	$bed2 = "";
	$bed3 = "";
	$bed4 = "";
	if (count($bedrooms) >= 1 && $bedrooms[0] > 0){
		foreach ($bedrooms as &$value) {
			if ($value == 1) {
				$bed1 = "checked=checked";
			} 
			if ($value == 2) {
				$bed2 = "checked=checked";
			}
			if ($value == 3) {
				$bed3 = "checked=checked";
			}
			if ($value == 4) {
				$bed4 = "checked=checked";
			}
		}
	}	
	?>
	<div class="field col2" id="bdContainer">
		<label>Bedrooms:</label>
		<div id="bedroom">
			<div class="checkbox">
				<label for="bed1">
					
					<input type="checkbox" id="bed1" value="1" 
					<?php echo $bed1  ?> 
					/>
					1 Bedroom</label>
			</div>
			<div class="checkbox">
				<label for="bed2">
					<input type="checkbox" id="bed2" value="2" 
					<?php echo $bed2  ?>
					/>
					2 Bedroom</label>
			</div>
			<div class="checkbox">
				<label for="bed3">
					<input type="checkbox" id="bed3" value="3" 
					<?php echo $bed3  ?>
					/>
					3 Bedroom</label>
			</div>
			<div class="checkbox">
				<label for="bed4">
					<input type="checkbox" id="bed4" value="4" 
					<?php echo $bed4 ?> 
					/>
					4+ Bedroom</label>
			</div>
		</div>
	
	</div>
	<div class="field col1" id="priceSlider">
		<label for="amount">Price range:</label>
		<div id="slider-range"></div>
		<input type="text" id="amount" readonly style="border:0;">
		<input type="hidden" id="minPrice">
		<input type="hidden" id="maxPrice">
	</div>
	<div class="field col2" >
		<label>&nbsp;</label>
		<div class="btn center">
			<input 
			id="formSub"
			name="ecommSearchBtn" 			
			onclick="propertySearch_<?php echo $priModObj[0]->className; ?>.propertySearch(this.form); $('#propertySearch').slideToggle()"
			type="button"
			value="Search" 
		/>
			<input type="submit" style="display:none"/>
		</div>
	</div>
</form>
</div>
<div id="map_canvas"></div>
