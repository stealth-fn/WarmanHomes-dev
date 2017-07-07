<div class="uploadMessage" id="uploadMessage<?php echo $_REQUEST["recordID"]; ?>" style="display:none">
	<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['uploadMessage']; ?>
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
	<label for='imgCaption'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['imgCaption']; ?>
	</label>
	<input 
			type="text" 
			id="imgCaption<?php echo $_REQUEST["recordID"]; ?>" 
			name="imgCaption" 
			size="45" 
			maxlength="255" 
			value="<?php echo $priModObj[0]->displayInfo('imgCaption'); ?>"
		/>
</div>
<div>
	<label for='imgDesc'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['imgDesc']; ?>
	</label>
		<input 
			type="text" 
			id="imgDesc<?php echo $_REQUEST["recordID"]; ?>"
			name="imgDesc" 
			size="45" 
			maxlength="255" 
			value="<?php echo $priModObj[0]->displayInfo('imgDesc'); ?>"
		/>
</div>
<div>
	<?php
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
		$pagesObj = new pages(false);
		$allPages = $pagesObj->getConditionalRecord(
			array("priKeyID","1","greatEqual","pageName","ASC")
		);
	?>
	<label for='linkPageID'>Page Link</label>
	<div class="moduleFormStyledSelect">
	<select id="linkPageID" name="linkPageID">
		<option>No page...</option>
	<?php
		while($x = mysqli_fetch_assoc($allPages)) {
	?>
		<option 
			<?php
				if($priModObj[0]->displayInfo('linkPageID') == $x["priKeyID"]){
					echo 'selected="selected"';
				}
			?>
			value="<?php echo $x["priKeyID"]; ?>"
		>
			<?php echo $x["pageName"]; ?>
		</option>
	<?php
		}
	?>
	
	
	</select>
	</div>
</div>

<?php	
	
	$fileName = "";
	
	#if this is a new record, check to see if there is an image to use from another domain
	if(strlen($priModObj[0]->displayInfo('fileName')) == 0) {
		
		#query for another image
		$languageRec = $priModObj[0]->getConditionalRecord(
			array(
				"groupID",$tmpGroupID,true
			)
		);
		
		$lr = mysqli_fetch_assoc($languageRec);

		#if there is an image, use that instead
		if(strlen($lr["fileName"]) > 0){
			$fileName = $lr["fileName"];
		}
	}
	#already has an image
	else{
		$fileName = $priModObj[0]->displayInfo('fileName');
	}
	
	if(strlen($fileName) > 0) {
?>
	<div class="currentFile">
		Current File: <span class="innerCurrentFile"><?php echo $fileName;?></span>
	</div>
<?php
	}
?>
<div>
	<label for='fileName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['fileName']; ?>
	</label>
	<input
		type="file" 
		id="fileName<?php echo $_REQUEST["recordID"]; ?>" 
		name="fileName"
		value="<?php echo $fileName; ?>" 
	/>
</div>
<div
	<?php 
		if(isset($priModObj[0]->bulkMod)) {
			echo '
				class="bulkCKEditor ckEditContainer"
				id="bulkCKEditor' . $_REQUEST["recordID"] . '"
			'; 
		}
		else{
			echo 'class="ckEditContainer"';
		}
	?>
>
	<textarea 
		id="imageCopy<?php echo $_REQUEST["recordID"]; ?>" 
		name="imageCopy"
	><?php echo $priModObj[0]->displayInfo('imageCopy'); ?>
	</textarea>
</div>

<input 
	type="hidden" 
	id="galleryID<?php echo $_REQUEST["recordID"]; ?>" 
	name="galleryID" 
	value="<?php echo $_REQUEST["parentPriKeyID"]; ?>"	
/>
	
<iframe 
	class="upload_target"
	id="upload_target<?php echo $_REQUEST["recordID"]; ?>" 
	name="upload_target<?php echo $_REQUEST["recordID"]; ?>" 
	src="" 
	style="width:0;height:0;border:0px solid #fff;">
</iframe>  