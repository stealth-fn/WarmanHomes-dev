<div>
	<label for='productOptionCategoryDesc'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['productOptionCategoryDesc']; ?>
	</label>
	<input 
		type="text" 
		id="productOptionCategoryDesc<?php echo $_REQUEST["recordID"]; ?>" 
		name="productOptionCategoryDesc" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('productOptionCategoryDesc'); ?>"
	/>
</div>
<div>
	<label for='notInvMessage'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['notInvMessage']; ?>
	</label>
	<input 
		type="text" 
		id="notInvMessage<?php echo $_REQUEST["recordID"]; ?>" 
		name="notInvMessage" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('notInvMessage'); ?>"
	/>
</div>

<div class='radioGroupBlock'>
	<label for='optionGroupType'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['optionGroupType']; ?>
	</label><br />
	<span>
		<label for='optionGroupType'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['optionGroupTypeRadio']; ?>
		</label>
		<input
			id="optionGroupTypeRad<?php echo $_REQUEST["recordID"]; ?>"
			name="optionGroupType"
			type="radio"
			value="0"
			<?php if($priModObj[0]->displayInfo('optionGroupType')==0){echo "checked='checked'";} ?> 
		/>
	</span>
	<span>
		<label for='optionGroupType'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['optionGroupTypeCheck']; ?>
		</label>
		<input
			id="optionGroupTypeChk<?php echo $_REQUEST["recordID"]; ?>"
			name="optionGroupType"
			type="radio"
			value="1"
			<?php if($priModObj[0]->displayInfo('optionGroupType')==1){echo "checked='checked'";} ?> 
		/>
	</span>
	<span>
		<label for='optionGroupType'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['optionGroupTypeDropDown']; ?>
		</label>
		<input
			id="optionGroupTypeSelect<?php echo $_REQUEST["recordID"]; ?>"
			name="optionGroupType"
			type="radio"
			value="2"
			<?php if($priModObj[0]->displayInfo('optionGroupType')==2){echo "checked='checked'";} ?> 
		/>
	</span>
	<span>
		<label for='optionGroupType'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['optionGroupTypeList']; ?>
		</label>
		<input
			id="optionGroupTypeList<?php echo $_REQUEST["recordID"]; ?>"
			name="optionGroupType"
			type="radio"
			value="3"
			<?php if($priModObj[0]->displayInfo('optionGroupType')==3){echo "checked='checked'";} ?> 
		/>
	</span>
</div>

<div class='radioGroupBlock'>
	<span>
		<label for='optionRequired'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['optionRequired']; ?>
		</label><br />
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
		<input
			id="optionRequiredYes<?php echo $_REQUEST["recordID"]; ?>"
			name="optionRequired"
			type="radio"
			value="1"
			<?php if($priModObj[0]->displayInfo('optionRequired')==1){echo "checked='checked'";} ?> 
		/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
		<input
			id="optionRequiredNo<?php echo $_REQUEST["recordID"]; ?>"
			name="optionRequired"
			type="radio"
			value="0"
			<?php if($priModObj[0]->displayInfo('optionRequired')==0){echo "checked='checked'";} ?> 
		/>
	</span>
</div>

<div class='radioGroupBlock'>
	<span>
		<label for='optionQtyField'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['optionQtyField']; ?>
		</label><br />
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
		<input
			id="optionQtyFieldYes<?php echo $_REQUEST["recordID"]; ?>"
			name="optionQtyField"
			type="radio"
			value="1"
			<?php if($priModObj[0]->displayInfo('optionQtyField')==1){echo "checked='checked'";} ?> 
		/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
		<input
			id="optionQtyFieldNo<?php echo $_REQUEST["recordID"]; ?>"
			name="optionQtyField"
			type="radio"
			value="0"
			<?php if($priModObj[0]->displayInfo('optionQtyField')==0){echo "checked='checked'";} ?> 
		/>
	</span>
</div>

<div class='radioGroupBlock'>
	<span>
		<label for='allowInvOption'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['allowInvOption']; ?>
		</label><br />
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>
		<input
			id="allowInvOptionYes<?php echo $_REQUEST["recordID"]; ?>"
			name="allowInvOption"
			type="radio"
			value="1"
			<?php if($priModObj[0]->displayInfo('allowInvOption')==1){echo "checked='checked'";} ?> 
		/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>
		<input
			id="allowInvOptionNo<?php echo $_REQUEST["recordID"]; ?>"
			name="allowInvOption"
			type="radio"
			value="0"
			<?php if($priModObj[0]->displayInfo('allowInvOption')==0){echo "checked='checked'";} ?> 
		/>
	</span>
</div>
<?php
	#options/products for this category
	$productOptions = $productsObj->getAllRecords();
	
	#options/products mapped to this category
	$prodOpMapped = $prodOpCatMap->getConditionalRecord(
		array("productOptionCategoryID",$_REQUEST["recordID"],true)
	);
	$mappedProdIDList = $prodOpCatMap->getQueryValueString(
		$prodOpMapped,"productID",","
	);
	
	$mappedProdArray = explode(",",$mappedProdIDList);
	
	#list products/options we use for this product category
	if(mysqli_num_rows($productOptions) > 0){
?>
		<h2 
			class="adminShowHideParent"
			onclick="$('#prodOpCatMapped<?php echo $_REQUEST["recordID"]; ?>').toggle()"
		>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['prodOpCatMapped']; ?>
		</h2>
		<div id="prodOpCatMapped<?php echo $_REQUEST["recordID"]; ?>" class="adminShowHideChild">
<?php
		while($x = mysqli_fetch_assoc($productOptions)){
			
			$cString = "";
			if(in_array($x["priKeyID"],$mappedProdArray)){
				$cString = "checked='checked'";
			}
			echo "<div>" . $x["productName"] . " 
					<input 
						type='checkbox' 
						$cString
						name='productID' 
						id='productID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "' 
						value='" . $x["priKeyID"] . "'
					/>
				</div>";
		}
		
		echo "</div>";
	}
?>		