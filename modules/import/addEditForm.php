<div class="uploadMessage" id="uploadMessage<?php echo $_REQUEST["recordID"]; ?>" style="display:none">
	Uploading File... please wait...
	<img 
		alt="Upload Indicator" 
		class="ajaxFileGif"
		height="19"
		id="ajaxFileGif<?php echo $_REQUEST["recordID"]; ?>" 
		src="/images/Web-Design-Saskatoon-file-upload-loader.gif" 
		width="220"
	/>
</div>

<div>
<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
	$moduleObj = new module(false);
	$modules = $moduleObj->getConditionalRecord(
		array("importCSV","1",true,"moduleName","ASC")
	); 
?>
	<label for='moduleID'>Select Module</label>
	<div class='moduleFormStyledSelect'>
		<select 
			name="moduleID" id="moduleID<?php echo $_REQUEST["recordID"]; ?>"
			onchange="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].getModuleFields(this)"
		>
			<option value="">None</option>
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
							title='" .$mod["primaryAPIFile"] . "'
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
	<label for="fileName">Select File</label>
	<span style="display: block">(only CSV file with utf8 character set is acceptable)</span>
	<input type="file" name="fileName" id="fileName"/>
</div>
<div class='radioGroupBlock'>
	<label for='importType'> Import Type </label>
	<span>Replace
	<input 
			type="radio" 
			name="importType" 
			id="importTypeFull<?php echo $_REQUEST["recordID"]; ?>" 
			value="1" 
			<?php if($priModObj[0]->displayInfo('importType')==1) echo "checked='checked'"; ?> 
		/>
	</span> <span>Add
	<input 
			type="radio" 
			name="importType" 
			id="importTypeAdd<?php echo $_REQUEST["recordID"]; ?>" 
			value="0" 
			<?php if($priModObj[0]->displayInfo('importType')==0) echo "checked='checked'"; ?> 
		/>
	</span> 
</div>

<div class='radioGroupBlock'>
	<label for='updateMapSec'>Update Mapping Section</label>
	<span>Yes
	<input 
			type="radio" 
			name="updateMapSec" 
			id="updateMapSecYes<?php echo $_REQUEST["recordID"]; ?>" 
			value="1" 
			<?php if($priModObj[0]->displayInfo('updateMapSec')==1) echo "checked='checked'"; ?> 
		/>
	</span> <span>No
	<input 
			type="radio" 
			name="updateMapSec" 
			id="updateMapSecNo<?php echo $_REQUEST["recordID"]; ?>" 
			value="0" 
			<?php if($priModObj[0]->displayInfo('updateMapSec')==0) echo "checked='checked'"; ?> 
		/>
	</span> 
</div>

<div id="formpage_3" style="width: 100%;">
	<h2>Mapping Section</h2>
	<div 
		id="tableFields<?php echo $_REQUEST["recordID"]; ?>"
	></div>
</div>

<input
	id='dataBaseFields<?php echo $_REQUEST["recordID"]; ?>'
	name='dataBaseFields'
	type='hidden'
	value='<?php echo $priModObj[0]->displayInfo('dataBaseFields'); ?>'
/>

<input
	id='csvFieldsName<?php echo $_REQUEST["recordID"]; ?>'
	name='csvFieldsName'
	type='hidden'
	value='<?php echo $priModObj[0]->displayInfo('csvFieldsName'); ?>'
/>

<input
	id='csvFieldsLine<?php echo $_REQUEST["recordID"]; ?>'
	name='csvFieldsLine'
	type='hidden'
	value='<?php echo $priModObj[0]->displayInfo('csvFieldsLine'); ?>'
/>

<iframe 
	class="upload_target"
	id="upload_target<?php echo $_REQUEST["recordID"]; ?>" 
	name="upload_target<?php echo $_REQUEST["recordID"]; ?>" 
	src="" 
	style="width:0;height:0;border:0px solid #fff;">
</iframe>







