<div>
	<label for='postalCode'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['postalCode']; ?>
	</label>

	<input
		type="text" 
		name="postalCode" 
		maxlength="255"
		id="postalCode<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('postalCode'); ?>"
	/>

</div>