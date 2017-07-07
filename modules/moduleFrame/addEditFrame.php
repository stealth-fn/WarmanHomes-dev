<?php						
	#don't override the ID on bulk adding
	if(
		!isset($priModObj[0]->bulkMod) ||
		isset($priModObj[0]->bulkMod) && !isset($_GET["pmpmID"])
	){
		$_REQUEST["recordID"] = $priModObj[0]->queryResults["priKeyID"];
	}
?>
	<form 
		action="#" 
		class="moduleForm<?php echo $priModObj[0]->className; ?>"
		id="moduleForm<?php echo $_REQUEST["recordID"]; ?>" 
		method="post"
		name="moduleForm"
	>
		<?php
			#bulk add/edit
			if(isset($_REQUEST["bulkMod"]) && $_REQUEST["bulkMod"] == true 
			&& strpos($priModObj[0]->tableRecords,"groupID") !== false/*&&
				isset($priModObj[0]->queryResults["groupID"]) && 
				is_numeric($priModObj[0]->queryResults["groupID"])*/
			){
				if(is_numeric($priModObj[0]->queryResults["groupID"])){
					$tmpGroupID = $priModObj[0]->queryResults["groupID"];
				}
				else{
					$tmpGroupID = "";
				}
			}
			#editing a record
			elseif(isset($priModObj[0]->groupID) && is_numeric($priModObj[0]->groupID)){;
				$tmpGroupID = $priModObj[0]->groupID;
			}
			else{
				$tmpGroupID = "";
			}
		?>
		
		<input
			id='groupID<?php echo $_REQUEST["recordID"]; ?>'
			name='groupID'
			type='hidden'
			value='<?php echo $tmpGroupID; ?>'
		/>
		
		<?php
			#the user is specifying a record language
			if(isset($_REQUEST["recLng"])){
				$tempLangRec = abs($_REQUEST["recLng"]);
			}
			#use the language that is set for the cms
			else{
				$tempLangRec = abs($_SESSION["lngDmnID"]);
			}
		?>
		
		<input
			id='domainID<?php echo $_REQUEST["recordID"]; ?>'
			name='domainID'
			type='hidden'
			value='<?php echo $tempLangRec; ?>'
		/>
			
		<?php
			include($_SERVER['DOCUMENT_ROOT']. $priModObj[0]->templateDOMFile);
			
			#output our selected DOM elements
			include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleDOMElements.php");
			
			#on bulk adding leave the initial priKeyID empty so we know to add
			if(
				!isset($priModObj[0]->bulkMod) ||
				isset($priModObj[0]->bulkMod) && !isset($_GET["pmpmID"]
			)){ 
				$addEditID = $priModObj[0]->queryResults["priKeyID"];
			}
			else{
				$addEditID = "";
			}
		?>
		
		<input
			id='priKeyID<?php echo $_REQUEST["recordID"]; ?>'
			name='priKeyID'
			type='hidden'
			autocomplete='off'
			value='<?php echo $addEditID; ?>'
		/>
		
		<?php
			#this module can have galleries and images mapped to it
			if(
				strpos($priModObj[0]->tableRecords,"imageGalleryID") !== false && 
				strpos($priModObj[0]->tableRecords,"galleryImageID") !== false &&
				(
					#...and we can't specifc the html fields for the module
					 !isset($priModObj[0]->domFields) ||
					(
						#... or we can  specific the fields and this one is active
						count($priModObj[0]->domFields) > 0 &&
						array_key_exists("imageGalleryID",$priModObj[0]->domFields)
					)
				)
			
			){
		?>
		
		<div class="addEditGalSelect">
			<label for='imageGalleryID'>Gallery</label>
			<div class='moduleFormStyledSelect'>
				<select 
					onchange="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].getGalleryImages()"
					id="imageGalleryID<?php echo $_REQUEST["recordID"]; ?>"
					name="imageGalleryID"
				>
					<option>None</option>
					<?php
						include($_SERVER['DOCUMENT_ROOT']."/modules/moduleFrame/gallery/gallerySelect.php");
					?>
				</select>
			</div>
		</div>
		
		<div>
			<label for='galleryImageID'>Image From Gallery</label>
			<div class='moduleFormStyledSelect'>
				<select 
					id="galleryImageID<?php echo $_REQUEST["recordID"]; ?>"
					name="galleryImageID"
				>
					<option value="">None</option>
					<?php
						include($_SERVER['DOCUMENT_ROOT']."/modules/moduleFrame/gallery/galleryImageSelect.php");
					?>
				</select>
			</div>
			<input 
				type="button" 
				class="addSubModBtn"
				value="+"
				onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].setupRecord(true,this,-1219,'imageGalleryID',{inputType:'select',inputName:'galleryImageID', inputDesc: 'imgCaption'})"
			/>
		</div>
		
		<?php
			}
		?>
		
		<?php
			#active or not
			if(
				#if the database table has the isActive field
				strpos($priModObj[0]->tableRecords,"isActive") !== false &&
				(
					#...and we can't specifc the html fields for the module
					!isset($priModObj[0]->domFields) ||
					(
						#... or we can  specific the fields and this one is active
						count($priModObj[0]->domFields) > 0 &&
						array_key_exists("ac",$priModObj[0]->domFields)
					)
					
				)
			){  
		?>
			<div class='radioGroupBlock'>
				<label for='isActive'>
					<?php 
						#the module may not have language labels
						if(
							isset($priModObj[0]->languageLabels) &&
							isset($priModObj[0]->languageLabels[$_SESSION["lng"]]) &&
							isset($priModObj[0]->languageLabels[$_SESSION["lng"]]['isActive'])
						){
							echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['isActive'];
						}
						else{
							echo "Active";
						}
					?>
				</label>
				<span>
					<?php
						if(strlen($priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']) > 0){
							echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; 
						}
						else{
							echo "Yes";
						}
					?> 
					<input 
						type="radio" 
						name="isActive" 
						id="isActiveYes<?php echo $_REQUEST["recordID"]; ?>"
						value="1"
						<?php if($priModObj[0]->displayInfo('isActive')==1){ ?>
							checked="checked"
						<?php } ?>
					/>
				</span>
			
				<span>
					<?php
						if(strlen($priModObj[0]->languageLabels[$_SESSION["lng"]]['no']) > 0){
							echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; 
						}
						else{
							echo "No";
						}
					?> 					
					<input 
						type="radio" 
						name="isActive" 
						id="isActiveNo<?php echo $_REQUEST["recordID"]; ?>" 
						value="0"
						<?php if($priModObj[0]->displayInfo('isActive')==0){ ?>
							checked="checked"
						<?php } ?>
					/>
				</span>
			</div>
		<?php } ?>
				
		<?php
			/*when we're adding bulk records we need to pass along the priKeyID field
			along since it's only given a temp field at at the start*/
		?>
			<input
				id='priKeyField<?php echo $_REQUEST["recordID"]; ?>'
				name='priKeyField'
				type='hidden'
				value='priKeyID<?php echo $_REQUEST["recordID"]; ?>'
			/>
			
			<br />
			<input
				class="moduleAddEditBtn"
				id="moduleAddEditItemBtn<?php echo $_REQUEST["recordID"]; ?>"
				name="moduleAddEditBtn"
				onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].addEditModule(false,false)"
				title="Update Record"
				type="button"
				value="Save Changes"
			/>
			
		<?php
			/*If a table contains isDraft field, pass the livePriKeyID */
			if(strpos($priModObj[0]->tableRecords,"isDraft") ){
				
				#we might be editing a record who has as null livePriKeyID, such as
				#if we update a CMS on a version that didn't have live/draft functionality
				if(
					$priModObj[0]->displayInfo('livePriKeyID') == "" &&
					$priModObj[0]->displayInfo('draftPriKeyID') == ""
				){
					$tempLivePriKeyID = $priModObj[0]->displayInfo('priKeyID');
				}
				else{
					$tempLivePriKeyID = $priModObj[0]->displayInfo('livePriKeyID');
				}
		?>
		
			<input
				id='livePriKeyID<?php echo $_REQUEST["recordID"]; ?>'
				name='livePriKeyID'
				type='hidden'
				value='<?php echo $tempLivePriKeyID; ?>'
			/>
			
		<?php
			}
			
			/*If it is not bulk mode and a table contains isDraft field, display Save Draft Button
			and pass the draftPrikeyId */
			if(!isset($priModObj[0]->bulkMod) && strpos($priModObj[0]->tableRecords,"isDraft") !== false){
		?>
		
				<input
					class="moduleAddEditDraftBtn"
					id="moduleAddEditDraftBtn<?php echo $_REQUEST["recordID"];?>"
					name="moduleAddEditDraftBtn"
					onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].addEditModule(false,true)"
					title="Draft Record"
					type= "button" 
					value= "Save Draft"
				/>
				
				<input
					id='draftPriKeyID<?php echo $_REQUEST["recordID"]; ?>'
					name='draftPriKeyID'
					type='hidden'
					value='<?php echo  $priModObj[0]->displayInfo('draftPriKeyID'); ?>'
				/>
				
		<?php
			}
			/*If it is bulk mode and a table contains isDraft field, hide Save Draft Button*/
			if(isset($priModObj[0]->bulkMod) && strpos($priModObj[0]->tableRecords,"isDraft") !== false){
		?>
				<input
					class="moduleAddEditDraftBtn"
					id="moduleAddEditDraftBtn<?php echo $_REQUEST["recordID"];?>"
					name="moduleAddEditDraftBtn"
					onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].addEditModule(false,true)"
					title="Draft Record"
					type= "hidden" 
					value= "Save Draft"
				/>
				
		<?php
			}
			if(isset($_REQUEST["parentPriKeyID"])){
				$parentParams = "&amp;parentPriKeyID=" . $_REQUEST["parentPriKeyID"];
		?>
			<input
				id='parentPriKeyID<?php echo $_REQUEST["recordID"]; ?>'
				name='parentPriKeyID'
				type='hidden'
				value='<?php echo $_REQUEST["parentPriKeyID"]; ?>'
			/>
		<?php
			}
			else{
				$parentParams = "";
			}
			
			foreach($_REQUEST as $key => $value){
				if(
					#the pagination should come from the user
					strpos($key,"pagPage") === false && 
					#this is set manually in the setInstanceModuleParams, because 
					#we overwrite pagPage when we build the pagination DOM
					strpos($key,"currentPagPage") === false &&
					#we don't want the recordIDt hat comes along with the bulk add/edit
					strpos($key,"recordID") === false &&
					#we only want instance params for this module, not any others on this page
					(
						strpos($key,"module") === false || 
						$key === $priModObj[0]->priKeyID
					) &&
					strpos($key,"pageID") === false && 
					#don't need/want cookies
					!isset($_COOKIE[$key])
				){
					$parentParams .= "&amp;" . $key . "=" . $value;
				}
			}
		?>
		<?php 
			# 2 - Edit only option is available
			if($priModObj[0]->adminButtons != 2) {
		?>
		<a
			class="moduleOneMoreBtn"
			id="moduleOneMoreBtn<?php echo $_REQUEST["recordID"]; ?>"
			onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].addAnother(<?php echo $priModObj[0]->addEditPageID; ?>,'<?php echo $parentParams; ?>'); return false"
			title="Add Another"
		>Add Another</a>
		<?php
			}
		?>
		
		<?php 
			#don't show language per item on bulk add/edit
			if(!isset($priModObj[0]->bulkMod)){  
		?>
		<div id="moduleItemLangContainer">
			<label for="moduleItemLang">
				<?php 
					#English
					if(abs($_SESSION["domainID"])==1) {
						echo "Record Language";
					}
					#Japanese
					else if(abs($_SESSION["domainID"])==2) {
						echo "レコード言語";
					}
				?>
			</label>
			
			<select 
				id="moduleItemLang" 
				name="moduleItemLang"
				onchange="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].changeModuleLng()"
			>
				<option value="1" <?php if($tempLangRec==1) echo "selected"; ?>>English</option>
				<option value="2" <?php if($tempLangRec==2) echo "selected"; ?>>日本語</option>
			</select>
		</div>
		<?php } ?>
		
		<?php 
			#only have delete button on bulk add/editing
			if(isset($priModObj[0]->bulkMod)){  
		?>
		<a 
			class="moduleDelBtn"
				href=""
				id="moduleDelBtn<?php echo $_REQUEST["recordID"]; ?>"
				onclick="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].moduleDelete(
				'<?php echo $_REQUEST["recordID"]; ?>',this
				); return false"
				title="Delete"
		>
			X
		</a>

		<?php } ?>
		
		<?php
			#only have the ordinal input if the table has one
			if(strpos($priModObj[0]->tableRecords,"ordinal") !== false){  
		?>
		<input
			id="ordinal<?php echo $_REQUEST["recordID"]; ?>" 
			name="ordinal" 
			type="hidden" 
			value="<?php echo $priModObj[0]->displayInfo('ordinal'); ?>"
		/>
		<?php } ?>
		
		<?php 
			#store the object name in the form for the bulk add/edit 
			if(isset($priModObj[0]->bulkMod)){
		?>
			<input
				id="jsObjName<?php echo $_REQUEST["recordID"]; ?>" 
				name="jsObjName" 
				type="hidden" 
				value="<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"
			/>
		<?php } ?>
				
	</form>
<?php
	#we have been through here at least once, used for empty query results
	$loopOnce = true;
?>

<?php 
	#don't show help on bulk editing
	if(!isset($priModObj[0]->bulkMod)){  
?>
<div id='moduleHelp'>
	<a 
		href='#' 
		id='helpHideButton' 
		onclick='$("#helpText").toggle();return false' 
		title='Show Help for this module'
	>Help</a>
	<div id='helpText'>
		<div id='helpTextWrapper'>
		<a 
			href='#' 
			id='helpCloseButton' 
			onclick='$("#helpText").toggle();return false' 
			title='Hide Help for this module'
		>Close Help</a>
		<?php echo $priModObj[0]->moduleHelp; ?>
	</div></div>
</div>
<?php
	}
?>