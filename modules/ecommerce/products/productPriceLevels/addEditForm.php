<div>
	<label for='priceLevelDesc'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['priceLevelDesc']; ?>
	</label>
	<input 
		type="text" 
		id="priceLevelDesc<?php echo $_REQUEST["recordID"]; ?>" 
		name="priceLevelDesc" 
		maxlength="100" 
		value="<?php echo $priModObj[0]->displayInfo('priceLevelDesc'); ?>"
	/>
</div>
<div>
	<label for='levelPercentage'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['levelPercentage']; ?>
	</label>					
	<input 
		type="text" 
		id="levelPercentage<?php echo $_REQUEST["recordID"]; ?>" 
		name="levelPercentage"
		maxlength="4" 
		value="<?php echo $priModObj[0]->displayInfo('levelPercentage'); ?>"
	/>
</div>
<?php
	#user groups who get this discount
	$publicUserGroups = $publicUserGroupObj->getAllRecords();
	
	if(mysqli_num_rows($publicUserGroups) > 0){
		echo "
			<div class='moduleSubElement'>
				<h3
					onclick=\"$('#discountGroups" . $_REQUEST["recordID"] . "').toggle()\" 
					class=\"adminShowHideParent\"
				>
					" . $priModObj[0]->languageLabels[$_SESSION["lng"]]['discountGroups'] . "
					<span>&lt; " . $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand'] . "</span>
				</h3>
			<div id='discountGroups" . $_REQUEST["recordID"] . "' class='adminShowHideChild'>";
	
			while($x = mysqli_fetch_assoc($publicUserGroups)){
				$mappedUserGroup = $productPriceLevelUserGroupMapObj->getConditionalRecord(
					array(
						"publicUserGroupID", $x["priKeyID"], true, 
						"productPriceLevelID", $_REQUEST["recordID"], true
					)
				);
				$checked='';
				if(mysqli_num_rows($mappedUserGroup) > 0) $checked='checked="checked"';
?>

			<div>
				<input 
					type='checkbox' 
					<?php echo $checked; ?> 
					id='publicUserGroupID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
					name='publicUserGroupID' 
					class='vendorProduct' 
					value='<?php echo $x["priKeyID"]; ?>'
				/>
				<span>
					<?php 
						echo htmlentities(
							html_entity_decode($x["groupDesc"],ENT_QUOTES),ENT_QUOTES
						); 
					?>
				</span>
			</div>

<?php
			}
	echo "
			</div>
		</div>";
	}
?>