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
	<label for='fileDesc'>Title</label>
	<input 
		type="text" 
		id="fileDesc<?php echo $_REQUEST["recordID"]; ?>" 
		name="fileDesc" 
		size="45" 
		maxlength="255" 
		value="<?php echo trim($priModObj[0]->displayInfo('fileDesc')); ?>"
	/>
</div>

<?php
	#file categories
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryCategory.php");
	$fileLibCatObj = new fileLibraryCategory(false);
	$fileLibCats = $fileLibCatObj->getAllRecords();
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryCatMap.php");
	$fileLibCatMapObj = new fileLibraryCatMap(false);

	#categories mapped to this blog
	$mappedCats = $fileLibCatMapObj->getConditionalRecord(
		array("fileLibraryID",$priModObj[0]->displayInfo('priKeyID'),true)
	);
	$mappedCatIDList = $fileLibCatMapObj->getQueryValueString($mappedCats,"fileLibraryCategoryID",",");
	$mappedCatArray = explode(",",$mappedCatIDList);

	if(mysqli_num_rows($fileLibCats) > 0){
?>
		<div class='moduleSubElement'>
			<h3  
				onclick="$('#categorisedPosts<?php echo $_REQUEST["recordID"]; ?>').toggle()" 
				class="adminShowHideParent"
			>
				File Categories <span>&lt; click to toggle visibility</span>
			</h3>
			<div 
				id='categorisedPosts<?php echo $_REQUEST["recordID"]; ?>' 
				class='adminShowHideChild'
			>
		<?php
			while($x = mysqli_fetch_assoc($fileLibCats)){
				$checked = "";
				if(in_array($x["priKeyID"],$mappedCatArray) !== false){
					$checked = "checked='checked'";
				}
		?>

				<div>
					<input 
						type='checkbox' 
						<?php echo $checked; ?> 
						id='fileLibraryCategoryID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
						name='fileLibraryCategoryID' 
						class='fileLibraryCategoryID<?php echo $x["priKeyID"]; ?>' 
						value='<?php echo $x["priKeyID"]; ?>'
					/>
					<span><?php echo $x["fileCatDesc"]; ?></span>
				</div>

		<?php
			}
			echo "</div></div>";
	}
?>

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
		File Name
	</label>
	<input
		type="file" 
		id="fileName<?php echo $_REQUEST["recordID"]; ?>" 
		name="fileName"
		value="<?php echo $fileName; ?>" 
	/>
</div>


<iframe 
	class="upload_target"
	id="upload_target<?php echo $_REQUEST["recordID"]; ?>" 
	name="upload_target<?php echo $_REQUEST["recordID"]; ?>" 
	src="" 
	style="width:0;height:0;border:0px solid #fff;">
</iframe>