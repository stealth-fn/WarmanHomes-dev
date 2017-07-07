<div>
	<label for='instanceDescription'>Instance Description</label>
	<input
		type="text" 
		name="instanceDescription" 
		maxlength="255"
		id="instanceDescription<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('instanceDescription'); ?>"
	/>
</div>

<div>
	<label for='empButtonText'>View Employee Button Text</label>
	<input
		type="text" 
		name="empButtonText" 
		maxlength="255"
		id="empButtonText<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('emButtonText'); ?>"
	/>
</div>

<div>
	<label for='linkPageID'>
		Employee Page
	</label>
	<div class='moduleFormStyledSelect'>
		<select
			name="linkPageID"
			id="linkPageID<?php echo $_REQUEST["recordID"]; ?>"
		>
			<option value="">None</option>
			<?php
				while($ppages = mysqli_fetch_assoc($publicPages)){
					echo "
						<option
							value='" . $ppages["priKeyID"] . 
						"'>" . htmlentities(
								html_entity_decode(
									$ppages["pageName"],ENT_QUOTES, "UTF-8"
								),ENT_QUOTES, "UTF-8"
							) .
						 "</option>";
				}
				mysqli_data_seek($publicPages,0);
			?>
		</select>
	</div>
</div>