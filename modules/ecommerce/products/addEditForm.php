<div>
	<label for='productName'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['productName']; ?> </label>
	<input 
		type="text" 
		id="productName<?php echo $_REQUEST["recordID"]; ?>" 
		name="productName" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('productName'); ?>"
	/>
</div>
<div>
	<label for='sku'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['sku']; ?> </label>
	<input 
		type="text" 
		id="sku<?php echo $_REQUEST["recordID"]; ?>" 
		name="sku" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('sku'); ?>"
	/>
</div>
<div>
	<label for='price'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['price']; ?> </label>
	<input 
		type="text" 
		id="price<?php echo $_REQUEST["recordID"]; ?>" 
		name="price" 
		maxlength="9" 
		value="<?php echo $priModObj[0]->displayInfo('price'); ?>"
	/>
</div>
<div>
	<label for='prodLink'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['prodLink']; ?> </label>
	<input 
		type="text" 
		id="prodLink<?php echo $_REQUEST["recordID"]; ?>" 
		name="prodLink" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('prodLink'); ?>"
	/>
</div>
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
	?>
>
	<label for='productCopy'> Product Description </label>
	<textarea 
		id="productCopy<?php echo $_REQUEST["recordID"]; ?>"
		name="productCopy" 
		><?php echo $priModObj[0]->displayInfo('productCopy'); ?></textarea>
</div>
<!--
<div>
	<label for='fileLibraryID'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['fileLibraryID']; ?> </label>
	<div class='moduleFormStyledSelect'>
		<select id="fileLibraryID<?php echo $_REQUEST["recordID"]; ?>" name="fileLibraryID">
			<option>None</option>
			<?php
				include_once($_SERVER['DOCUMENT_ROOT']."/modules/ecommerce/products/fileLibrarySelect.php");
			?>
		</select>
	</div>
</div>
-->
<div>
	<label for='invtQty'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['invtQty']; ?> </label>
	<input 
		type="text" 
		id="invtQty<?php echo $_REQUEST["recordID"]; ?>" 
		name="invtQty" 
		maxlength="10" 
		value="<?php echo $priModObj[0]->displayInfo('invtQty'); ?>"
	/>
</div>
<div class='radioGroupBlock'>
	<label for='allowNegInvt'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['allowNegInvt']; ?> </label>
	<span>Yes
	<input 
			type="radio" 
			name="allowNegInvt" 
			id="allowNegInvtYes<?php echo $_REQUEST["recordID"]; ?>" 
			value="1" 
			<?php if($priModObj[0]->displayInfo('allowNegInvt')==1) echo "checked='checked'"; ?> 
		/>
	</span> <span>No
	<input 
			type="radio" 
			name="allowNegInvt" 
			id="allowNegInvtNo<?php echo $_REQUEST["recordID"]; ?>" 
			value="0" 
			<?php if($priModObj[0]->displayInfo('allowNegInvt')==0) echo "checked='checked'"; ?> 
		/>
	</span> </div>
<div>
	<label for='negInvtMsg'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['negInvtMsg']; ?> </label>
	<input 
		type="text" 
		id="negInvtMsg<?php echo $_REQUEST["recordID"]; ?>" 
		name="negInvtMsg" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('negInvtMsg'); ?>"
	/>
</div>
<div class='radioGroupBlock'>
	<label for='optionQty'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['optionQty']; ?> </label>
	<span> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
	<input
			id="optionQtyYes<?php echo $_REQUEST["recordID"]; ?>"
			name="optionQty"
			type="radio"
			value="1"
			<?php if($priModObj[0]->displayInfo('optionQty')==1){echo "checked='checked'";} ?> 
		/>
	</span> <span> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
	<input
			id="optionQtyNo<?php echo $_REQUEST["recordID"]; ?>"
			name="optionQty"
			type="radio"
			value="0"
			<?php if($priModObj[0]->displayInfo('optionQty')==0){echo "checked='checked'";} ?> 
		/>
	</span> </div>
<?php
if($priModObj[0]->isFlatRate) {
?>
<?php
$flatRate = $flatRateObj->getAllRecords();
	
	if($flatRate->num_rows > 0){
		echo "
			<div 
				class='moduleSubElement'
			>
				<h3 onclick=\"$('#flateRate" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
					Flate Rate Shipping Fee <span>&lt; click to toggle visibility</span>
				</h3>
				<div 
					id='flateRate" . $_REQUEST["recordID"] . "' 
					class='adminShowHideChild'
				>";
				while($x = mysqli_fetch_array($flatRate)){
					/*check to see if this one is mapped already, if it is, check it off*/
					
					 $flatRateMapped = $flatRateProdMapObj->getConditionalRecord(
						array(
							"productID",$_REQUEST["recordID"],true,
							"flatRateID",$x["priKeyID"],true
						)
						);
					$checked = "";
					if ($flatRateMapped->num_rows > 0){
						$checked = "checked='checked'";
					}
					echo  "
						<div>
							<input 
								type='checkbox' 
								".$checked."
								name='flatRateID' 
								id='flatRateID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
								class='propertiesCities" . $x["priKeyID"] . "' 
								value='" . $x["priKeyID"] . "'
							/><span>" . $x["description"] . "</span>
						</div>
					";
		}
		echo "
				</div>
			</div>
		";
	}
}
else {
?>
<div class='moduleSubElement'>
	<!--If Canada Post is enabled-->
	<?php
	$weight = "false";
	$dimensions = "false";
	$requiredMark = "";
	$message = "";

	#Canada Post is Enabled - Dimensions &amp; Weight are required for shipping
	if ($priModObj[0]->isCanadaPost) {
		$weight = "true";
		$dimensions = "true";
		$requiredMark = "*";
		$message = ' - Canada Post is Enabled - Dimensions &amp; Weight are required - ';
	}
	#Purolator is Enabled - Weight is required for shipping
	if ($priModObj[0]->isPurolator) {
		$weight = "true";
		$requiredMark = "*";
		$message .= ' - Purolator Enabled -  Weight is required -';
	}
		
	echo "<p style='color: red; text-align: center;'><strong>" . $message . "</strong></p>";
	
	?>
	<h3 onclick="$('#productModuleShippingInfo<?php echo $_REQUEST["recordID"]; ?>').toggle()" class="adminShowHideParent"> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shippingHeader']; 
	if($weight !== "" || $dimensions !== "") {
		echo ' ' . $requiredMark;
	}	
		?> <span>&lt; click to toggle visibility</span> </h3>
	<div 
		id='productModuleShippingInfo<?php echo $_REQUEST["recordID"]; ?>' 
		class='adminShowHideChild'
	>
		<div>
			<label for='prodLen'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['prodLen']; ?> </label>
			<input 
				type="text" 
				id="prodLen<?php echo $_REQUEST["recordID"]; ?>"
				name="prodLen" 
				maxlength="3" 
				required="<?php echo $dimensions; ?>"
				value="<?php echo $priModObj[0]->displayInfo('prodLen'); ?>"
			/>
		</div>
		<div>
			<label for='prodWidth'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['prodWidth']; ?> </label>
			<input 
				type="text" 
				id="prodWidth<?php echo $_REQUEST["recordID"]; ?>"
				name="prodWidth" 
				maxlength="3" 
				required="<?php echo $dimensions; ?>"
				value="<?php echo $priModObj[0]->displayInfo('prodWidth'); ?>"
			/>
		</div>
		<div>
			<label for='prodHeight'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['prodHeight']; ?> </label>
			<input 
				type="text" 
				id="prodHeight<?php echo $_REQUEST["recordID"]; ?>"
				name="prodHeight" 
				maxlength="3" 
				required="<?php echo $dimensions; ?>"
				value="<?php echo $priModObj[0]->displayInfo('prodHeight'); ?>"
			/>
		</div>
		<div>
			<label for='prodWeight'> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['prodWeight']; ?> </label>
			<input 
				type="text" 
				id="prodWeight<?php echo $_REQUEST["recordID"]; ?>"
				name="prodWeight" 
				maxlength="6" 
				required="<?php echo $weight; ?>"
				value="<?php echo $priModObj[0]->displayInfo('prodWeight'); ?>"
			/>
		</div>
	</div>
</div>
<?php
}
#categories for this product
$productCategories = $productCategoriesObj->getAllRecords();

#categories mapped to this product
$mappedCats = $prodCatObj->getConditionalRecord(
	array("productID",$_REQUEST["recordID"],true)
);
$mappedCatIDList = $prodCatObj->getQueryValueString($mappedCats,"productCategoryID",",");
$mappedCatArray = explode(",",$mappedCatIDList);

if(mysqli_num_rows($productCategories) > 0){
?>
<div class='moduleSubElement'>
<h3 onclick="$('#productModuleProdCats<?php echo $_REQUEST["recordID"]; ?>').toggle()" class="adminShowHideParent"> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['productCategoryID']; ?> <span>&lt; click to toggle visibility</span> </h3>
<div 
		id='productModuleProdCats<?php echo $_REQUEST["recordID"]; ?>' 
		class='adminShowHideChild'
	>
<?php
			while($x = mysqli_fetch_array($productCategories)){
				$checked = "";
				if(in_array($x["priKeyID"],$mappedCatArray) !== false){
					$checked = "checked='checked'";
				}
		?>
<div>
	<input 
				type='checkbox' <?php echo $checked; ?> 
				id='category<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
				name='productCategoryID' 
				class='productCategory' 
				value='<?php echo $x["priKeyID"]; ?>'
			/>
	<span><?php echo $x["categoryName"]; ?></span> </div>
<?php	
			}
		echo "
	</div>
</div>";
}
	
#vendors for this product
$storeVendors = $vendorObj->getAllRecords();
#vendors mapped to this product
$vendMapped = $prodVendObj->getConditionalRecord(
	array("productID",$_REQUEST["recordID"],true)
);
$mappedVendIDList = $prodCatObj->getQueryValueString($vendMapped,"vendorID",",");
$mappedVendArray = explode(",",$mappedVendIDList);

if(mysqli_num_rows($storeVendors) > 0){
?>
<div class='moduleSubElement'>
<h3 onclick="$('#productModuleProdVendors<?php echo $_REQUEST["recordID"]; ?>').toggle()" class="adminShowHideParent"> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['vendorID']; ?> <span>&lt; click to toggle visibility</span> </h3>
<div 
			id='productModuleProdVendors<?php echo $_REQUEST["recordID"]; ?>'
			class='adminShowHideChild'
		>
<?php
				while($x = mysqli_fetch_assoc($storeVendors)){
			
					$checked = "";
					if(in_array($x["priKeyID"],$mappedVendArray) !== false){
						$checked = "checked='checked'";
					}
			?>
<div>
	<input 
				type='checkbox' 
				<?php echo $checked; ?> 
				id='vendor<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>'
				name='vendorID' 
				class='productVendor' 
				value='<?php echo $x["priKeyID"]; ?>'
			/>
	<span><?php echo $x["vendorName"]; ?></span> </div>
<?php
				}
		echo "
	</div>
</div>";
	}
						
	#options/product categories for this product
	$productOptionCategories = $productOptionCategoryObj->getAllRecords();
	#options/products categories mapped to this product
	$prodCatOpMapped = $optionCategoryProductMapObj->getConditionalRecord(
		array("productID",$_REQUEST["recordID"],true)
	);
	$mappedProdOpCatIDList = $productOptionCategoryObj->getQueryValueString(
		$prodCatOpMapped,"productOptionCategoryID",","
	);
	$mappedProdOpCatArray = explode(",",$mappedProdOpCatIDList);
	
	#list products/option categories we use for this product
	if(mysqli_num_rows($productOptionCategories) > 0){
?>
<div class='moduleSubElement'>
<h3
				class="adminShowHideParent"
				onclick="$('#prodOpCatMapped<?php echo $_REQUEST["recordID"]; ?>').toggle()" 
			> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['productOptionCategoryID']; ?> <span>&lt; click to toggle visibility</span> </h3>
<div 
			id='prodOpCatMapped<?php echo $_REQUEST["recordID"]; ?>' 
			class='adminShowHideChild'
		>
<?php
		while($x = mysqli_fetch_assoc($productOptionCategories)){
			
			$checked = "";
			if(in_array($x["priKeyID"],$mappedProdOpCatArray) !== false){
				$checked = "checked='checked'";
			}
		?>
<div>
	<input 
					type='checkbox' <?php echo $checked; ?> 
					id='productOptionCategoryID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
					name='productOptionCategoryID' 
					class='productOption' 
					value='<?php echo $x["priKeyID"]; ?>'
				/>
	<span><?php echo $x["productOptionCategoryDesc"]; ?></span> </div>
<?php	
		}
		echo "</div></div>";
	}
?>
<!--
<div>
	<input 
		type="button"
		name="addFeature"
		class="buttonAddSmall"
		id="addFeature<?php echo $_REQUEST["recordID"]; ?>"
		value="Add Feature"
		onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].addProdFeatureField()"
	/>
</div>
<?php
	#features for this product
	$productFeatures = $productFeatureObj->getConditionalRecord(
		array("productID",$_REQUEST["recordID"],true,"featureOrdinal","DESC")
	);
?>
<div id="productFeatureContainer<?php echo $_REQUEST["recordID"]; ?>">
	<?php
		while($x = mysqli_fetch_assoc($productFeatures)){
	?>
	<div id="featureContainer<?php echo $_REQUEST["recordID"]; ?>" class="featureContainer">
		<div>
			<label> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['featureLabel'];?> </label>
			<input
						type="text"
						name="featureLabel"
						class="featureLabel"
						maxlength="255"
						value="<?php echo htmlentities(html_entity_decode($x["featureLabel"],ENT_QUOTES, "UTF-8"),
				ENT_QUOTES, 
				"UTF-8"
			);?>"
					/>
		</div>
		<div>
			<label> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['featureText'];?> </label>
			<input
						type="text"
						name="featureText"
						class="featureText"
						maxlength="255"
						value="<?php echo htmlentities(html_entity_decode($x["featureText"],ENT_QUOTES, "UTF-8"),
				ENT_QUOTES, 
				"UTF-8"
			);?>"
					/>
		</div>
		<div>
			<label> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['featureOrdinal'];?> </label>
			<input
						type="text"
						name="featureOrdinal"
						class="featureOrdinal"
						maxlength="9"
						value="<?php echo htmlentities(html_entity_decode($x["featureOrdinal"],ENT_QUOTES, "UTF-8"),
				ENT_QUOTES, 
				"UTF-8"
			);?>"
					/>
		</div>
		<input
					type="hidden"
					name="featureID<?php echo $_REQUEST["recordID"]; ?>"
					value="<?php echo $x["priKeyID"];?>"
				/>
		<input
					type="button"
					name=""
					class="modSubElRem"
					id=""
					value=""
					onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].removeProdFeature(this)"
				/>
	</div>
	<?php
		}
	?>
</div>
<div>
	<input 
		type="button"
		name="addFeature2"
		class="buttonAddSmall"
		id="addFeature<?php echo $_REQUEST["recordID"]; ?>2"
		value="Add Restaraunt Link"
		onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].addProdFeatureField2()"
	/>
</div>
<?php
	#features for this product
	$productFeatures2 = $productFeature2Obj->getConditionalRecord(
		array("productID",$_REQUEST["recordID"],true,"featureOrdinal","DESC")
	);
?>
<div id="productFeatureContainer<?php echo $_REQUEST["recordID"]; ?>2">
	<?php
		while($x = mysqli_fetch_assoc($productFeatures2)){
	?>
	<div id="featureContainer<?php echo $_REQUEST["recordID"]; ?>2" class="featureContainer2">
		<div>
			<label> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['featureLabel'];?> </label>
			<input
						type="text"
						name="featureLabel2"
						class="featureLabel2"
						maxlength="255"
						value="<?php echo htmlentities(html_entity_decode($x["featureLabel"],ENT_QUOTES, "UTF-8"),
				ENT_QUOTES, 
				"UTF-8"
			);?>"
					/>
		</div>
		<div>
			<label> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['featureText'];?> </label>
			<input
						type="text"
						name="featureText2"
						class="featureText2"
						maxlength="255"
						value="<?php echo htmlentities(html_entity_decode($x["featureText"],ENT_QUOTES, "UTF-8"),
				ENT_QUOTES, 
				"UTF-8"
			);?>"
					/>
		</div>
		<div>
			<label> <?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['featureOrdinal'];?> </label>
			<input
						type="text"
						name="featureOrdinal2"
						class="featureOrdinal2"
						maxlength="9"
						value="<?php echo htmlentities(html_entity_decode($x["featureOrdinal"],ENT_QUOTES, "UTF-8"),
				ENT_QUOTES, 
				"UTF-8"
			);?>"
					/>
		</div>
		<input
					type="hidden"
					name="featureID<?php echo $_REQUEST["recordID"]; ?>2"
					value="<?php echo $x["priKeyID"];?>"
				/>
		<input
					type="button"
					name=""
					class="modSubElRem"
					id=""
					value=""
					onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].removeProdFeature(this)"
				/>
	</div>
	<?php
		}
	?>
</div>
-->