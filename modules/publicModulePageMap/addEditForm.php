<div>
	<label for='instanceDesc'>
		Description (Ex. Home Page Blog, Product Page Listing, etc...)
	</label>
	<input
		type="text"
		id="instanceDesc<?php echo $_REQUEST["recordID"]; ?>"
		name="instanceDesc"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('instanceDesc'); ?>"
		onkeyup="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].createCSSClassName(this)"
	/>
</div>

<div>
<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
	$pagesObj = new pages(false);
	$publicPages = $pagesObj->getConditionalRecord(
		array("priKeyID","0","great")
	); 
?>
	<label for='pageID'>
		What page is this module on?
	</label>
	<div class='moduleFormStyledSelect'>
		<select name="pageID" id="pageID<?php echo $_REQUEST["recordID"]; ?>">
			<option value="-1">Every Page</option>
			<?php
				while($pages = mysqli_fetch_assoc($publicPages)){
					if($pages["priKeyID"] == $priModObj[0]->displayInfo('pageID')){
						$selected = "selected='selected'";
					}
					else{
						$selected = "";
					}
					
					echo "
						<option
							" . $selected . "
							value='" . $pages["priKeyID"] . 
						"'>" .
							htmlentities(
								html_entity_decode(
									$pages["pageName"],ENT_QUOTES, "UTF-8"
								),ENT_QUOTES, "UTF-8"
							) .
						"</option>";
				}
				mysqli_data_seek($publicPages,0);
			?>
		</select>
	</div>
</div>

<div>
<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
	$moduleObj = new module(false);
	$modules = $moduleObj->getConditionalRecord(
		array("priKeyID","stealth",false,"moduleName","ASC")
	); 
?>
	<label for='moduleID'>
		What module?
	</label>
	<div class='moduleFormStyledSelect'>
		<select 
			name="moduleID" id="moduleID<?php echo $_REQUEST["recordID"]; ?>"
			onchange="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].getModuleInfo(this)"
		>
			<option value="0">None</option>
			<?php
				while($mod = mysqli_fetch_assoc($modules)){
					if($mod["priKeyID"] == $priModObj[0]->displayInfo('moduleID')){
						$selected = "selected='selected'";
					}
					else{
						$selected = "";
					}
					
					echo "
						<option
							" . $selected . "
							value='" . $mod["priKeyID"] . 
						"'>" .
							htmlentities(
								html_entity_decode(
									$mod["moduleName"],ENT_QUOTES, "UTF-8"
								),ENT_QUOTES, "UTF-8"
							) .
						"</option>";
				}
				mysqli_data_seek($modules,0);
			?>
		</select>
	</div>
</div>

<div>
<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
	$moduleObj = new module(false);
	$modules = $moduleObj->getConditionalRecord(
		array("priKeyID","stealth",false,"moduleName","ASC")
	); 
?>
	<label for='instanceID'>
		What instance?
	</label>
	<div class='moduleFormStyledSelect'>
		<select 
			name="instanceID" id="instanceID<?php echo $_REQUEST["recordID"]; ?>"
			onchange="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].getDisplayElements(this)"
		>
			<option value="0">None</option>
			<?php
				while($mod = mysqli_fetch_assoc($modules)){
					if($mod["priKeyID"] == $priModObj[0]->displayInfo('moduleID')){
						$selected = "selected='selected'";
					}
					else{
						$selected = "";
					}
					
					echo "
						<option
							" . $selected . "
							value='" . $mod["priKeyID"] . 
						"'>" .
							htmlentities(
								html_entity_decode(
									$mod["moduleName"],ENT_QUOTES, "UTF-8"
								),ENT_QUOTES, "UTF-8"
							) .
						"</option>";
				}
				mysqli_data_seek($modules,0);
			?>
		</select>
	</div>
	<input 
		type="button" 
		class="addSubModBtn"
		value="+"
		onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].setupInstance()"
	/>
</div>

<div>
	<label for='displayElements'>
		What elements to show for the module?
	</label>
	<select 
		name="displayElements" 
		id="displayElements<?php echo $_REQUEST["recordID"]; ?>"
	></select>
</div>

<div>
	<label for='beforeAfter'>
		Display before, after, or inside the content?
	</label>
	<span>
		Before Content
		<input
			type="radio"
			name="beforeAfter"
			id="beforeAfterBefore<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('beforeAfter')==0){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		After Content
			<input
				type="radio"
				name="beforeAfter"
				id="beforeAfterAfter<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('beforeAfter')==1){echo "checked='checked'";} ?>
			/>
	</span>
	
	<span>
		Inside Content  
			<input
				type="radio"
				name="beforeAfter"
				id="beforeAfterContent<?php echo $_REQUEST["recordID"]; ?>"
				value="2"
				<?php if($priModObj[0]->displayInfo('beforeAfter')==2){echo "checked='checked'";} ?>
			/>
			<br />
			<span>
				Copy and paste the following into the page content.
			</span>
			<br />
			<span>
				&lt;div id=&quot;pmpmID(NUMID)&quot;&gt;&lt;!--(DESC)--&gt;&lt;/div&gt;
			</span>
	</span>
</div>

<div>
	<label for='headerText'>
		Module Header Text
	</label>
	<input
		type="text"
		id="headerText<?php echo $_REQUEST["recordID"]; ?>"
		name="headerText"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('headerText'); ?>"
	/>
</div>

<div>
	<label for='className'>
		CSS Class Name
	</label>
	<input
		type="text"
		id="className<?php echo $_REQUEST["recordID"]; ?>"
		name="className"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('className'); ?>"
	/>
</div>

<div>
	<label for='instanceDisplayType'>
		How do you want to list the records?
	</label>
	<div class='moduleFormStyledSelect'>
		<select 
			name="instanceDisplayType" 
			id="instanceDisplayType<?php echo $_REQUEST["recordID"]; ?>"
		>
			<option 
				value="0" 
				<?php 
					if($priModObj[0]->displayInfo('className') == 0) {
						$selected = "selected='selected'";
					}
				?>
			>Fade</option>
			
			<option value="1" 
				<?php 
					if($priModObj[0]->displayInfo('className') == 1) {
						$selected = "selected='selected'";
					}
				?>
			>List All</option>
			
			<option value="2" 
				<?php 
					if($priModObj[0]->displayInfo('className') == 2) {
						$selected = "selected='selected'";
					}
				?>
			>List with Pagination</option>
			
			<option value="3" 
				<?php 
					if($priModObj[0]->displayInfo('className') == 3) {
						$selected = "selected='selected'";
					}
				?>
			>Slide</option>
		</select>
	</div>
</div>

<div class='radioGroupBlock'>
	<label for='expandContractMIs'>
		Open and close the record when you click on it?
	</label>
	<span>
		Yes
		<input
			type="radio"
			name="expandContractMIs"
			id="expandContractMIs<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('expandContractMIs')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		No
		<input
			type="radio"
			name="expandContractMIs"
			id="expandContractMIs<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('expandContractMIs')==0){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div class='radioGroupBlock'>
	<label for='autoChange'>
		Automatically rotate through records? (Example slide or fade automatically?)
	</label>
	<span>
		Yes
		<input
			type="radio"
			name="autoChange"
			id="autoChange<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('autoChange')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		No
		<input
			type="radio"
			name="autoChange"
			id="autoChange<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('autoChange')==0){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div>
	<label for='autoChangeDuration'>
		How many milliseconds to wait before auto-rotating?
	</label>
	<input
		type="text"
		id="autoChangeDuration<?php echo $_REQUEST["recordID"]; ?>"
		name="autoChangeDuration"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('autoChangeDuration'); ?>"
	/>
</div>

<div class='radioGroupBlock'>
	<label for='autoChangeMouseOverDisable'>
		Disable auto-rotate on mouse over?
	</label>
	<span>
		Yes
		<input
			type="radio"
			name="autoChangeMouseOverDisable"
			id="autoChangeMouseOverDisable<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('autoChangeMouseOverDisable')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		No
		<input
			type="radio"
			name="autoChangeMouseOverDisable"
			id="autoChangeMouseOverDisable<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('autoChangeMouseOverDisable')==0){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div class='radioGroupBlock'>
	<label for='beforeAfter'>
		Direction of auto-rotation?
	</label>
	<span>
		Left
		<input
			type="radio"
			name="autoChangeDirection"
			id="autoChangeDirection<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('autoChangeMouseOverDisable')==0){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		Right
		<input
			type="radio"
			name="autoChangeDirection"
			id="autoChangeDirection<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('autoChangeMouseOverDisable')==1){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div>
	<label for='changeEffectDuration'>
		How many seconds the effect should take. (Ex 3, 2.5, etc)
	</label>
	<input
		type="text"
		id="changeEffectDuration<?php echo $_REQUEST["recordID"]; ?>"
		name="changeEffectDuration"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('changeEffectDuration'); ?>"
	/>
</div>

<div>
	<label for='effectEasing'>
		Jquery effect easing. (linear, swing, easeinQuad, etc)
	</label>
	<input
		type="text"
		id="effectEasing<?php echo $_REQUEST["recordID"]; ?>"
		name="effectEasing"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('effectEasing'); ?>"
	/>
</div>

<div>
	<label for='displayQty'>
		How many records to display?
	</label>
	<div class='moduleFormStyledSelect'>
		<select name="displayQty" id="displayQty<?php echo $_REQUEST["recordID"]; ?>">
			<option value="-1">All Records</option>
			<?php
				$i = 1;
				
				while($i < 100){
										
					if($priModObj[0]->displayInfo('displayQty') == $i){
						$dspSelected = 'selected="selected"';
					}
					else{
						$dspSelected = '';
					}
					
					echo "<option " . $dspSelected . ">" . $i . "</option>";
					
					$i++;
				}
			?>
		</select>
	</div>
</div>

<div class='radioGroupBlock'>
	<label for='clickScroll'>
		Sliding axis for click slide.
	</label>
	<span>
		X - axis
		<input
			type="radio"
			name="clickScroll"
			id="clickScroll<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('clickScroll')==0){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		Y - Axis
		<input
			type="radio"
			name="clickScroll"
			id="clickScroll<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('clickScroll')==1){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div class='radioGroupBlock'>
	<label for='isThumb'>
		Is thumbnails?
	</label>
	<span>
		Yes
		<input
			type="radio"
			name="isThumb"
			id="isThumb<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('isThumb')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		No
		<input
			type="radio"
			name="isThumb"
			id="isThumb<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('isThumb')==0){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div>
<?php
	$pmpmRecords = $priModObj[0]->getAllRecords(); 
?>
	<label for='thumbParentID'>
		What module instance is this thumbnails for?
	</label>
	<div class='moduleFormStyledSelect'>
		<select name="thumbParentID" id="thumbParentID<?php echo $_REQUEST["recordID"]; ?>">
			<option value="">None</option>
			<?php
				while($mod = mysqli_fetch_assoc($pmpmRecords)){
					if($mod["priKeyID"] == $priModObj[0]->displayInfo('thumbParentID')){
						$selected = "selected='selected'";
					}
					else{
						$selected = "";
					}
					
					echo "
						<option
							" . $selected . "
							value='" . $mod["priKeyID"] . 
						"'>" .
							htmlentities(
								html_entity_decode(
									$mod["desc"],ENT_QUOTES, "UTF-8"
								),ENT_QUOTES, "UTF-8"
							) .
						"</option>";
				}
				mysqli_data_seek($modules,0);
			?>
		</select>
	</div>
</div>

<div class='radioGroupBlock'>
	<label for='clickThumbs'>
		Display thumbnails?
	</label>
	<span>
		Yes
		<input
			type="radio"
			name="clickThumbs"
			id="clickThumbs<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('clickThumbs')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		No
		<input
			type="radio"
			name="clickThumbs"
			id="clickThumbs<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('clickThumbs')==0){echo "checked='checked'";} ?>
		/>
	</span>
</div>

<div>
<?php
	$pmpmRecords = $priModObj[0]->getAllRecords(); 
?>
	<label for='clickThumbsPmpmID'>
		What module instance to use for thumbnails?
	</label>
	<div class='moduleFormStyledSelect'>
		<select name="clickThumbsPmpmID" id="clickThumbsPmpmID<?php echo $_REQUEST["recordID"]; ?>">
			<option value="">None</option>
			<?php
				while($mod = mysqli_fetch_assoc($pmpmRecords)){
					if($mod["priKeyID"] == $priModObj[0]->displayInfo('clickThumbsPmpmID')){
						$selected = "selected='selected'";
					}
					else{
						$selected = "";
					}
					
					echo "
						<option
							" . $selected . "
							value='" . $mod["priKeyID"] . 
						"'>" .
							htmlentities(
								html_entity_decode(
									$mod["desc"],ENT_QUOTES, "UTF-8"
								),ENT_QUOTES, "UTF-8"
							) .
						"</option>";
				}
				mysqli_data_seek($modules,0);
			?>
		</select>
	</div>
</div>

<div>
	<label for='paginateLinkQty'>
		How many pagination page links to display at a time.
	</label>
	<div class='moduleFormStyledSelect'>
		<select name="paginateLinkQty" id="paginateLinkQty<?php echo $_REQUEST["recordID"]; ?>">
			<?php
				$i = 1;
				
				while($i < 100){
										
					if($priModObj[0]->displayInfo('paginateLinkQty') == $i){
						$dspSelected = 'selected="selected"';
					}
					else{
						$dspSelected = '';
					}
					
					echo "<option " . $dspSelected . ">" . $i . "</option>";
					
					$i++;
				}
			?>
		</select>
	</div>
</div>