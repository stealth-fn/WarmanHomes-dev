<div>
	<label for='categoryName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['categoryName']; ?>
	</label>
	<input 
		type="text" 
		id="categoryName<?php echo $_REQUEST["recordID"]; ?>" 
		name="categoryName" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('categoryName'); ?>"
	/>
</div>
<div>
	<label for='categoryDecription'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['categoryDescription']; ?>
	</label>
	<input 
		type="text" 
		id="categoryDescription<?php echo $_REQUEST["recordID"]; ?>" 
		name="categoryDescription" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('categoryDescription'); ?>"
	/>
</div>

<div class="ckEditContainer">
<div	
	<?php 
		if(isset($priModObj[0]->bulkMod)) {
			echo '
				class="bulkCKEditor"
				id="bulkCKEditor' . $_REQUEST["recordID"] . '"
			'; 
		}
	?>
>
	<textarea 
		name="categoryCopy" 
		id="categoryCopy<?php echo $_REQUEST["recordID"]; ?>"
	><?php echo $priModObj[0]->displayInfo('categoryCopy'); ?></textarea>
</div>
</div>

<?php		
	#list the categories that we can use as a sub category
	if(mysqli_num_rows($productCategories) > 0){
		echo "<div class='moduleSubElement'>
				<h3 
					onclick=\"$('#subCategories" . $_REQUEST["recordID"] . "').toggle()\" 
					class=\"adminShowHideParent\"
				>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['subcategories'] .
				" <span>&lt; " . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span>
				</h3>
				<div id='subCategories" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";
				
		while($x = mysqli_fetch_assoc($productCategories)){
			/*check to see if this one is mapped already, if it is, check it off*/
			if(isset($_REQUEST["recordID"])){
				$catMapped = $prodSubCatObj->getConditionalRecord(
					array(
						"prodCatID",$_REQUEST["recordID"],true,
						"prodSubCatID",$x["priKeyID"],true
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
			id='subCategory<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
			name='prodSubCatID' 
			class='subCategory' 
			value='<?php echo $x["priKeyID"]; ?>'
		/>
		<span><?php echo $x["categoryName"]; ?></span>
	</div>
			
	<?php
		}
		echo "</div></div>";
	}
	
	$storeVendors = $vendorObj->getAllRecords();
	
	if(mysqli_num_rows($storeVendors) > 0){
		echo "<div class='moduleSubElement'>
				<h3 
					onclick=\"$('#categoryVendors" . $_REQUEST["recordID"] . "').toggle()\" 
					class=\"adminShowHideParent\"
				>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['vendors'] . 
				" <span>&lt; " . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span>
				</h3>
			<div id='categoryVendors" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";
		while($x = mysqli_fetch_assoc($storeVendors)){
			#check to see if this one is mapped already, if it is, check it off
			if(isset($_REQUEST["recordID"]))
				$vendMapped = $prodCatVendObj->getConditionalRecord(
					array(
						"productCategoryID",$_REQUEST["recordID"],
						true,"vendorID",$x["priKeyID"],true
					)
				);
			
			$checked = "";
			if(isset($vendMapped) && mysqli_num_rows($vendMapped) > 0) {
				$checked = "checked='checked'";
			}
		?>
		
		<div>
			<input 
				type='checkbox' .
				<?php echo $checked; ?> 
				id='vendor<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
				name='vendorID' 
				class='categoryVendor' 
				value='<?php echo $x["priKeyID"]; ?>'
			/>
			<span><?php echo $x["vendorName"]; ?></span>
		</div>
		
		<?php
		}
		echo "</div></div>";
	}
	
	$products = $productsObj->getAllRecords();
	
	if(mysqli_num_rows($products) > 0){
		echo "<div class='moduleSubElement'>
				<h3 
					onclick=\"$('#categoryProducts" . $_REQUEST["recordID"] . "').toggle()\" 
					class=\"adminShowHideParent\"
				>" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['products'] .
				" <span>&lt; " . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span>
			</h3><div id='categoryProducts" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";
		while($x = mysqli_fetch_assoc($products)){
			/*check to see if this one is mapped already, if it is, check it off*/
			if(isset($_REQUEST["recordID"]))
				$catMapped = $prodCatObj->getConditionalRecord(
					array(
						"productID",$x["priKeyID"],true,
						"productCategoryID",$_REQUEST["recordID"],true
					)
				);
			
				$checked = "";
				$useImage = "";
				
				if(isset($catMapped) && mysqli_num_rows($catMapped) > 0) {
					$checked = "checked='checked'";
				}
				if($priModObj[0]->displayInfo('imageGalleryID') == $x["priKeyID"]) {
					$useImage = "checked='checked'";
				}
		?>
		
		<div>
			<input 
				type='checkbox' 
				<?php echo $checked; ?> 
				id='product<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
				name='productID' 
				class='categoryProduct' 
				value='<?php echo $x["priKeyID"]; ?>'
			/>
			<span><?php echo $x["productName"]; ?></span>
			<div>
				<input 
					type='radio' 
					<?php echo $useImage; ?> 
					id='imageGalleryID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
					name='imageGalleryID' 
					class='categoryProduct' 
					value='<?php echo $x["priKeyID"]; ?>'
				/>
				<span>
				<?php 
					echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['catImg']; ?>
				</span>
			</div>
		</div>
		
		<?php
		}
		$useImage = ($priModObj[0]->displayInfo('imageGalleryID') == 0) ? "checked='checked'" : "";
		echo "
			<div>
				<input 
					type='radio'".$useImage."
					id='imageGalleryIDNone' 
					name='imageGalleryID' 
					class='categoryProduct' 
					value='null'
				/><span>" . 
				$priModObj[0]->languageLabels[$_SESSION["lng"]]['notCatImg'] 
				. "</span>
			</div>";
		echo "</div></div>";
	}
	?>