<div>
	<label for='vendorName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['vendorName']; ?>
	</label>

	<input 
		type="text" 
		id="vendorName<?php echo $_REQUEST["recordID"]; ?>" 
		name="vendorName" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('vendorName'); ?>"
	/>
</div>

<div>
	<label for='address'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['address']; ?>
	</label>

	<input 
		type="text" 
		id="address<?php echo $_REQUEST["recordID"]; ?>" 
		name="address" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('address'); ?>"
	/>
</div>

<div>
	<label for='city'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['city']; ?>
	</label>

	<input 
		type="text" 
		id="city<?php echo $_REQUEST["recordID"]; ?>" 
		name="city" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('city'); ?>"
	/>
</div>

<div>
	<label for='provState'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['provState']; ?>
	</label>

	<input 
		type="text" 
		id="provState<?php echo $_REQUEST["recordID"]; ?>" 
		name="provState" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('provState'); ?>"
	/>
</div>

<div>

	<label for='postalZip'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['postalZip']; ?>
	</label>

	<input 
		type="text" 
		id="postalZip<?php echo $_REQUEST["recordID"]; ?>" 
		name="postalZip" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('postalZip'); ?>"
	/>

</div>

<div>
   <label for='country'>
   	<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['country']; ?>
   </label>
   <input 
		type="text" 
		id="country<?php echo $_REQUEST["recordID"]; ?>" 
		name="country" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('country'); ?>"
	/>
</div>

<div>

   <label for='url'>
   	<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['url']; ?>
   </label>

   <input 
		type="text" 
		id="url<?php echo $_REQUEST["recordID"]; ?>" 
		name="url" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('url'); ?>"
	/>

</div>

<div>

	<label for='notes'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['notes']; ?>
	</label>

	<textarea 
		name="notes" 
		id="notes<?php echo $_REQUEST["recordID"]; ?>"
	><?php echo $priModObj[0]->displayInfo('notes'); ?></textarea>

</div>
<?php 

	$products = $productsObj->getAllRecords();
	
	if(mysqli_num_rows($products) > 0){

		echo "
		<div class='moduleSubElement'>
			<h3 onclick=\"$('#vendorProducts" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
				" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['products'] .
				" <span>&lt; " . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span>
			</h3>

			<div id='vendorProducts" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";

		while($x = mysqli_fetch_assoc($products)){

			/*check to see if this one is mapped already, if it is, check it off*/
			if(isset($_REQUEST["recordID"])){

				$prodMapped = $prodVendObj->getConditionalRecord(
					array(
						"productID",$x["priKeyID"],true,
						"vendorID",$_REQUEST["recordID"],true
					)
				);
			}

			$checked = "";

			if(isset($prodMapped) && mysqli_num_rows($prodMapped) > 0){
				$checked = "checked='checked'";
			}
		?>

			<div>
				<input 
					type='checkbox' 
					<?php echo $checked; ?> 
					id='productID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
					name='productID' class='vendorProduct' 
					value='<?php echo $x["priKeyID"]; ?>'
				/>
				<span><?php echo $x["productName"]; ?></span>
			</div>
		
		<?php
		}
		echo "</div></div>";
	}
	
	$productCategories = $productCategoriesObj->getAllRecords();

	if(mysqli_num_rows($productCategories) > 0){
		echo "<div class='moduleSubElement'>
			<h3 onclick=\"$('#vendorCategories" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
				" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['prodCats'] . "
				<span>&lt; " . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span>
			</h3>
			<div id='vendorCategories" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";

		while($x = mysqli_fetch_array($productCategories)){

			/*check to see if this one is mapped already, if it is, check it off*/
			if(isset($_REQUEST["recordID"])){

				$catMapped = $prodCatVendObj->getConditionalRecord(
					array(
						"productCategoryID",$x["priKeyID"],true,
						"vendorID",$_REQUEST["recordID"],true
					)
				);
			}

			

			$checked = "";

			if(isset($catMapped) && mysqli_num_rows($catMapped) > 0){
				$checked = "checked='checked'";
			}
		?>

		<div>
			<input 
				type='checkbox' 
				<?php echo $checked; ?> 
				id='productCategoryID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
				name='productCategoryID' 
				class='vendorCategory' 
				value='<?php echo $x["priKeyID"]; ?>'
			/>
			<span><?php echo $x["categoryName"]; ?></span>
		</div>
		
		<?php
		}
		echo "</div></div>";
	}
?>