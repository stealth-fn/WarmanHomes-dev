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
	<label for='blogTrim'>
		Display how many characters in content preview? (Emtpy is all)
	</label>
	<input
		type="text" 
		name="blogTrim" 
		maxlength="255"
		id="blogTrim<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('blogTrim'); ?>"
	/>
</div>

<div>
	<label for='titleTrim'>
		Display how many characters in Title preview? (Emtpy is all)
	</label>
	<input
		type="text" 
		name="titleTrim" 
		maxlength="255"
		id="titleTrim<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('titleTrim'); ?>"
	/>
</div>

<div class='radioGroupBlock'>
	<label for='displayRecommended'>
		Display recommended articles?
	</label>
	<span>
		Yes 
		<input
			type="radio"
			name="displayRecommended"
			id="displayRecommendedYes<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('displayRecommended')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		No
		<input
			type="radio"
			name="displayRecommended"
			id="displayRecommendedNo<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('displayRecommended')==0){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div class='radioGroupBlock'>
	<label for='displayRecommended'>
		Date display format
	</label>
	<span>
		One string for day, month, year 
		<input
			type="radio"
			name="blogDateFormatType"
			id="blogDateFormatTypeYes<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('blogDateFormatType')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		Seperate HTML for each date piece
		<input
			type="radio"
			name="blogDateFormatType"
			id="blogDateFormatTypeNo<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('blogDateFormatType')==0){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div>
	<label for='blogDateFormat'>
		Blog Full Date Format (using php date function format)
	</label>
	<input
		type="text" 
		name="blogDateFormat" 
		maxlength="255"
		id="blogDateFormat<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('blogDateFormat'); ?>"
	/>
</div>

<div>
	<label for='blogDayFormat'>
		Blog Day Date Format (using php date function format)
	</label>
	<input
		type="text" 
		name="blogDayFormat" 
		maxlength="255"
		id="blogDayFormat<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('blogDayFormat'); ?>"
	/>
</div>

<div>
	<label for='blogMonthFormat'>
		Blog Month Date Format (using php date function format)
	</label>
	<input
		type="text" 
		name="blogMonthFormat" 
		maxlength="255"
		id="blogMonthFormat<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('blogMonthFormat'); ?>"
	/>
</div>

<div>
	<label for='blogYearFormat'>
		Blog Year Date Format (using php date function format)
	</label>
	<input
		type="text" 
		name="blogYearFormat" 
		maxlength="255"
		id="blogYearFormat<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('blogYearFormat'); ?>"
	/>
</div>

<div>
	<label for='blogTimeFormat'>
		Blog Time Format (using php date function format)
	</label>
	<input
		type="text" 
		name="blogTimeFormat" 
		maxlength="255"
		id="blogTimeFormat<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('blogTimeFormat'); ?>"
	/>
</div>

<div>
	<label for='blogButtonText'>
		Article Button Text
	</label>
	<input
		type="text" 
		name="blogButtonText" 
		maxlength="255"
		id="blogButtonText<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('blogButtonText'); ?>"
	/>
</div>

<div>
	<label for='linkPageID'>
		Article Page
	</label>
	<div class='moduleFormStyledSelect'>
		<select
			name="specificBlogPageID"
			id="specificBlogPageID<?php echo $_REQUEST["recordID"]; ?>"
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