<?php
$thumbWidth   = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('thumbWidth') : $priModObj[0]->moduleSettings["thumbWidth"];
$thumbHeight  = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('thumbHeight') : $priModObj[0]->moduleSettings["thumbHeight"];
$mediumWidth  = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('mediumWidth') : $priModObj[0]->moduleSettings["mediumWidth"];
$mediumHeight = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('mediumHeight') : $priModObj[0]->moduleSettings["mediumHeight"];
$largeWidth   = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('largeWidth') : $priModObj[0]->moduleSettings["largeWidth"];
$largeHeight  = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('largeHeight') : $priModObj[0]->moduleSettings["largeHeight"];
$thumbMethod  = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('thumbMethod') : 0;
$mediumMethod = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('mediumMethod') : 0;
$largeMethod  = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('largeMethod') : 0;
$thumbColour  = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('thumbColour') : 0;
$mediumColour = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('mediumColour') : 0;
$largeColour  = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? $priModObj[0]->displayInfo('largeColour') : 0;

#let them add images once a gallery is created
$disableImg = (is_numeric($priModObj[0]->displayInfo('priKeyID'))) ? false : true; 
?>
<div>
	<label for='galleryName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['galleryName']; ?>
	</label>
	<input 
		type="text" 
		id="galleryName<?php echo $_REQUEST["recordID"]; ?>" 
		name="galleryName" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('galleryName'); ?>"
	/>
</div>
<div>
	<label for='thumbWidth'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['thumbWidth']; ?>
	</label>
	<input 
		type="text" 
		id="thumbWidth<?php echo $_REQUEST["recordID"]; ?>" 
		name="thumbWidth" 
		size="6" 
		maxlength="5" 
		value="<?php echo $thumbWidth; ?>"
	/> 
</div>
<div>
	<label for='thumbHeight'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['thumbHeight']; ?>
	</label>
	<input 
		type="text" 
		id="thumbHeight<?php echo $_REQUEST["recordID"]; ?>" 
		name="thumbHeight" 
		size="6" 
		maxlength="5" 
		value="<?php echo $thumbHeight; ?>"
	/> 
</div>
<div>
	<label for='thumbMethod'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['resizeMethod']; ?>
	</label>
	<div class='moduleFormStyledSelect'>
		<select
			name="thumbMethod"
			id="thumbMethod<?php echo $_REQUEST["recordID"]; ?>"
		>
			<option value="0" <?php if($thumbMethod==0) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['auto']; ?>
			</option>
			<option value="1" <?php if($thumbMethod==1) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToWidth']; ?>
			</option>
			<option value="2" <?php if($thumbMethod==2) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToHeight']; ?>
			</option>
			<option value="3" <?php if($thumbMethod==3) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToBoth']; ?>
			</option>
			<option value="4" <?php if($thumbMethod==4) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['stretchToBoth']; ?>
			</option>
		</select>
	</div>
</div>
<div>
	<label for='thumbColour'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['thumbColour']; ?>
	</label>
	<div class='moduleFormStyledSelect'>
		<select
			name="thumbColour"
			id="thumbColour<?php echo $_REQUEST["recordID"]; ?>"
		>
			<option value="0" <?php if($thumbColour==0) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['none']; ?>
			</option>
			<option value="1" <?php if($thumbColour==1) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['grey']; ?>
			</option>
		</select>
	</div>
</div>
<div>
	<label for='mediumWidth'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['mediumWidth']; ?>
	</label>
	<input 
		type="text" 
		id="mediumWidth<?php echo $_REQUEST["recordID"]; ?>" 
		name="mediumWidth" 
		size="6" 
		maxlength="5" 
		value="<?php echo $mediumWidth; ?>"
	/>
</div>
<div>
	<label for='mediumHeight'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['mediumHeight']; ?>
	</label>
	<input 
		type="text" 
		id="mediumHeight<?php echo $_REQUEST["recordID"]; ?>" 
		name="mediumHeight" 
		size="6" 
		maxlength="5" 
		value="<?php echo $mediumHeight; ?>"
	/>
</div>
<div>
	<label for='mediumMethod'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['resizeMethod']; ?>
	</label>
	<div class='moduleFormStyledSelect'>
		<select
			name="mediumMethod"
			id="mediumMethod<?php echo $_REQUEST["recordID"]; ?>"
		>
			<option value="0" <?php if($mediumMethod==0) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['auto']; ?>
			</option>
			<option value="1" <?php if($mediumMethod==1) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToWidth']; ?>
			</option>
			<option value="2" <?php if($mediumMethod==2) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToHeight']; ?>
			</option>
			<option value="3" <?php if($mediumMethod==3) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToBoth']; ?>
			</option>
			<option value="4" <?php if($mediumMethod==4) echo "selected='selected'";?>>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['stretchToBoth']; ?>
			</option>
		</select>
	</div>
</div>
<div>
	<label for='mediumColour'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['mediumColour']; ?>
	</label>
	<div class='moduleFormStyledSelect'>
		<select
			name="mediumColour"
			id="mediumColour<?php echo $_REQUEST["recordID"]; ?>"
		>

			<option value="0" <?php if($mediumColour==0) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['none']; ?>

			</option>

			<option value="1" <?php if($mediumColour==1) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['grey']; ?>

			</option>

		</select>

	</div>

</div>

<div>

	<label for='largeWidth'>

		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['largeWidth']; ?>

	</label>

	<input 

		type="text" 

		id="largeWidth<?php echo $_REQUEST["recordID"]; ?>" 

		name="largeWidth" 

		size="6" 

		maxlength="5" 

		value="<?php echo $largeWidth; ?>"

	/>

</div>

<div>

	<label for='largeHeight'>

		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['largeHeight']; ?>

	</label>

	<input 

		type="text" 

		id="largeHeight<?php echo $_REQUEST["recordID"]; ?>" 

		name="largeHeight" 

		size="6" 

		maxlength="5" 

		value="<?php echo $largeHeight; ?>"

	/> 

</div>

<div>

	<label for='largeMethod'>

		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['resizeMethod']; ?>

	</label>

	<div class='moduleFormStyledSelect'>

		<select

			name="largeMethod"

			id="largeMethod<?php echo $_REQUEST["recordID"]; ?>"

		>

			<option value="0" <?php if($largeMethod==0) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['auto']; ?>

			</option>

			<option value="1" <?php if($largeMethod==1) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToWidth']; ?>

			</option>

			<option value="2" <?php if($largeMethod==2) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToHeight']; ?>

			</option>

			<option value="3" <?php if($largeMethod==3) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['scaleToBoth']; ?>

			</option>

			<option value="4" <?php if($largeMethod==4) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['stretchToBoth']; ?>

			</option>

		</select>

	</div>

</div>

<div>

	<label for='largeColour'>

		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['largeColour']; ?>

	</label>

	<div class='moduleFormStyledSelect'>

		<select

			name="largeColour"

			id="largeColour<?php echo $_REQUEST["recordID"]; ?>"

		>

			<option value="0" <?php if($largeColour==0) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['none']; ?>

			</option>

			<option value="1" <?php if($largeColour==1) echo "selected='selected'";?>>

				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['grey']; ?>

			</option>

		</select>

	</div>

</div>

<?php

	if(isset($_REQUEST["recordID"])){

		$galleries = $priModObj[0]->getConditionalRecord(

			array("priKeyID",$_REQUEST["recordID"],false)

		);

	}

	else{

		$galleries = $priModObj[0]->getAllRecords();

	}

				

	if(mysqli_num_rows($galleries) > 0){

		echo "

		<div class='moduleSubElement'>

			<h3 

				onclick=\"$('#categoryProducts" . $_REQUEST["recordID"] . "').toggle()\" 

				class=\"adminShowHideParent\"

			>Group with the following libraries" .

				" <span>&lt; click to toggle visibility</span>

			</h3>

			<div id='categoryProducts' class='adminShowHideChild'>";

		if(isset($_REQUEST["recordID"])){

			$childGalleries = $priModObj[0]->getChildGalleries($_REQUEST["recordID"]);

		}

		if(isset($childGalleries) && mysqli_num_rows($childGalleries) > 0){

			while($x = mysqli_fetch_assoc($childGalleries)){

				$children[] = $x["childGalleryID"];

			}

		}

		else $children = array();

		while($x = mysqli_fetch_assoc($galleries)){

			/*check to see if this one is mapped already, if it is, check it off*/

			$checked = in_array($x["priKeyID"],$children) ? "checked='checked'" : "";

?>

		

		<div>

			<input 

				type='checkbox' 

				<?php echo $checked; ?> 

				id='childGalleryID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 

				name='childGalleryID' 

				class='childGallery' 

				value='<?php echo $x["priKeyID"]; ?>'

			/>

			<span><?php echo $x["galleryName"]; ?></span>

		</div>

		

		<?php

		}
		echo "</div></div>";
	}
?>

<input 
	class="moduleIndexButton"
	<?php if($disableImg)  echo 'disabled="disabled"';?>
	id="addImg<?php echo $_REQUEST["recordID"]; ?>"
	name="addImg"
	onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].addImage();return false" 
	type="button" 
	value="<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['addImage']; ?>" 
/>		