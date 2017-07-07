<div>
	<label for='fileCatDesc'>File Library Category Name</label>
	<input 
		type="text" 
		id="fileCatDesc<?php echo $_REQUEST["recordID"]; ?>" 
		name="fileCatDesc" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('fileCatDesc'); ?>"
	/>
</div>

<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibrary.php");
	$fileLibObj = new fileLibrary(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryCatMap.php");
	$fileLibCatMapObj = new fileLibraryCatMap(false);
	$libFiles = $fileLibObj->getAllRecords();
	
	if(mysqli_num_rows($libFiles) > 0){
		echo "
			<div class='moduleSubElement'>
				<h3 
					onclick=\"$('#categorisedPosts" . $_REQUEST["recordID"] . "').toggle()\" 
					class=\"adminShowHideParent\"
				>Files In This Category <span>&lt; click to toggle visibility</span>
				</h3>
				<div 
					id='categorisedPosts" . $_REQUEST["recordID"] . "' 
					class='adminShowHideChild'
				>
		";
		
		while($x = mysqli_fetch_array($libFiles)){
			/*check to see if this one is mapped already, if it is, check it off*/
			if(isset($_REQUEST["recordID"])){
				$catMapped = $fileLibCatMapObj->getConditionalRecord(
					array(
						"fileLibraryCategoryID",$_REQUEST["recordID"],
						true,"fileLibraryID",$x["priKeyID"],true
					)
				 );
			}
			if(isset($catMapped) && mysqli_num_rows($catMapped) > 0){
				echo  "
					<div>
						<input 
							type='checkbox' 
							checked='checked' 
							name='fileLibraryID' 
							id='fileLibraryID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
							class='libFile" . $x["priKeyID"] . "' 
							value='" . $x["priKeyID"] . "'
						/><span>" . $x["fileDesc"] . "</span>
					</div>
				";
			}
			else{
				echo "
					<div>
						<input 
							type='checkbox' 
							name='fileLibraryID' 
							id='fileLibraryID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
							class='libFile" . $x["priKeyID"] . "' 
							value='" . $x["priKeyID"] . "'
						/><span>" . $x["fileDesc"] . "</span>
					</div>";
			}
		}
		echo "
				</div>
			</div>
		";
	}
?>