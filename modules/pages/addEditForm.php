<div>
	<label for='pageName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['pageName']; ?>
	</label>
	<input
		type="text"
		id="pageName<?php echo $_REQUEST["recordID"]; ?>"
		name="pageName"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('pageName'); ?>"
	/>
</div>
<div>
	<label for='pageTitle'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['pageTitle']; ?>
	</label>
	<input
		type="text"
		id="pageTitle<?php echo $_REQUEST["recordID"]; ?>"
		name="pageTitle"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('pageTitle'); ?>"
	/>
</div>
<div>
	<label for='navLabel'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['navLabel']; ?>
	</label>
	<input
		type="text"
		id="navLabel<?php echo $_REQUEST["recordID"]; ?>"
		name="navLabel"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('navLabel'); ?>"
	/>
</div>
<div>
	<label for='redirect301'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['redirect301']; ?>
	</label>
	<input
		type="text"
		id="redirect301<?php echo $_REQUEST["recordID"]; ?>"
		name="redirect301"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('redirect301'); ?>"
	/>
</div>
<div>
	<label for='metaWords'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['metaWords']; ?>
	</label>
	<input
		type="text"
		id="metaWords<?php echo $_REQUEST["recordID"]; ?>"
		name="metaWords"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('metaWords'); ?>"
	/>
</div>
<div>
	<label for='metaDesc'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['metaDesc']; ?>
	</label>
	<input
		type="text"
		id="metaDesc<?php echo $_REQUEST["recordID"]; ?>"
		name="metaDesc"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('metaDesc'); ?>"
	/>
</div>
<div>
	<label for='linkPageURL'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['linkPageURL']; ?>
	</label>
	<input
		type="text"
		id="linkPageURL<?php echo $_REQUEST["recordID"]; ?>"
		name="linkPageURL"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('linkPageURL'); ?>"
	/>
</div>
<div>
	<label for='defPageURLParams'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['defPageURLParams']; ?>
	</label>
	<input
		type="text"
		id="defPageURLParams<?php echo $_REQUEST["recordID"]; ?>"
		name="defPageURLParams"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('defPageURLParams'); ?>"
	/>
</div>
<?php
	/*we want to show all the pages, but it will only show the displayQty by 
	default, so we temporatily change it to get all the pages*/
	$priModObj[0]->ignoreInstance = true;
	$publicPages = $priModObj[0]->getConditionalRecord(
		array("priKeyID","0","great","pageName","ASC")
	);
?>
<div>
	<label for='parentPageSelect'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['parentPageSelect']; ?>
	</label>
	<div class='moduleFormStyledSelect'>
		<select
			name="parentPageSelect"
			id="parentPageSelect<?php echo $_REQUEST["recordID"]; ?>"
			onchange="window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].parentPageChoose(this)"
		>
			<option value="0,0">None</option>
			<?php
				while($ppages = mysqli_fetch_assoc($publicPages)){
					#a page can't be its own parent
					if($ppages["priKeyID"] != $priModObj[0]->displayInfo('priKeyID')){
						if($ppages["priKeyID"] == $priModObj[0]->displayInfo('parentPageID')){
							echo "
								<option
									selected='selected'
									value='" . $ppages["priKeyID"] . "," . $ppages["pageLevel"] . "'
								>" .
									htmlentities(
										html_entity_decode(
											$ppages["pageName"],ENT_QUOTES, "UTF-8"
										),ENT_QUOTES, "UTF-8"
									) .
								"</option>";
						}
						else{
							echo "
								<option
									value='" . $ppages["priKeyID"] . "," . $ppages["pageLevel"] .
								"'>" . htmlentities(
										html_entity_decode(
											$ppages["pageName"],ENT_QUOTES, "UTF-8"
										),ENT_QUOTES, "UTF-8"
									) .
								 "</option>";
						}
					}
				}
				mysqli_data_seek($publicPages,0);
			?>
		</select>
	</div>
</div>
<div>
	<label for='linkPageID'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['linkPageID']; ?>
	</label>
	<div class='moduleFormStyledSelect'>
		<select name="linkPageID" id="linkPageID<?php echo $_REQUEST["recordID"]; ?>">
			<option value="0">None</option>
			<?php
				while($ppages = mysqli_fetch_array($publicPages)){
					$linkPageInfo = $priModObj[0]->getRecordByID($ppages["priKeyID"]);
					while($lpage = mysqli_fetch_array($linkPageInfo)){
						if($ppages["priKeyID"] == $priModObj[0]->displayInfo('linkPageID')){
							echo "
								<option
									selected='selected'
									value='" . $ppages["priKeyID"] . 
								"'>" .
									htmlentities(
										html_entity_decode(
											$lpage["pageName"],ENT_QUOTES, "UTF-8"
										),ENT_QUOTES, "UTF-8"
									) .
								"</option>";
						}
						else{
							echo "
								<option
									value='" . $ppages["priKeyID"] . 
								"'>" .
									htmlentities(
										html_entity_decode(
											$lpage["pageName"],ENT_QUOTES, "UTF-8"
										),ENT_QUOTES, "UTF-8"
									) .
								"</option>";
						}
					}
				}
				mysqli_data_seek($publicPages,0);
				
				#Follow instance properties again
				$priModObj[0]->ignoreInstance = false;
			?>
		</select>
	</div>
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
	<label for='pageCode<?php echo $_REQUEST["recordID"]; ?>'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['pageCode']; ?>
	</label>
	<textarea name="pageCode" id="pageCode<?php echo $_REQUEST["recordID"]; ?>" rows="10" cols="10">
		<?php echo $priModObj[0]->displayInfo('pageCode'); ?>
	</textarea>
</div>
<div class='radioGroupBlock'>
	<label for='isMembersPage'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['isMembersPage']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?> 
			<input
				type="radio"
				name="isMembersPage"
				id="isMembersPageYes<?php echo $_REQUEST["recordID"]; ?>"
				onclick="$('#publicUserGroupContainer<?php echo $_REQUEST["recordID"]; ?>').show()"
				value="1"
				<?php if($priModObj[0]->displayInfo('isMembersPage')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
			<input
				type="radio"
				name="isMembersPage"
				id="isMembersPageNo<?php echo $_REQUEST["recordID"]; ?>"
				onclick="$('#publicUserGroupContainer<?php echo $_REQUEST["recordID"]; ?>').hide()"
				value="0"
				<?php if($priModObj[0]->displayInfo('isMembersPage')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>
		
<div 
	class="publicUserGroupContainer optionsParent"
	id="publicUserGroupContainer<?php echo $_REQUEST["recordID"]; ?>" 
	style=" <?php if($priModObj[0]->displayInfo('isMembersPage')!=1){echo "display:none;";} ?>"
>	
	<div class='radioGroupBlock'>
		<label for='allMembers'>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['allMembers']; ?>
		</label>
		<span>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?> 
				<input
					type="radio"
					name="allMembers"
					id="allMembersYes<?php echo $_REQUEST["recordID"]; ?>"
					value="1"
					<?php if($priModObj[0]->displayInfo('allMembers')==1){echo "checked='checked'";} ?>
				/>
		</span>
		<span>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
				<input
					type="radio"
					name="allMembers"
					id="allMembersNo<?php echo $_REQUEST["recordID"]; ?>"
					value="0"

					<?php if($priModObj[0]->displayInfo('allMembers')==0){echo "checked='checked'";} ?>
				/>
		</span>
	</div>
	<div class="checkBoxGroup toggleOptions">
		<?php
			#get all user groups
			$userGroups = $publicUserGroupObj->getAllRecords();
			
			#check if userGroups are mapped
			$mappedQuery = $publicUserGroupPageMapObj->getConditionalRecord(
				array("pageID",$_REQUEST["recordID"],true)
			);
			$mappedIDList = $publicUserGroupPageMapObj->getQueryValueString(
				$mappedQuery,"publicUserGroupID"
			);
			$mappedIDArray = explode(",",$mappedIDList);
	
			while($x=mysqli_fetch_assoc($userGroups)){
				
				$checked = in_array($x["priKeyID"],$mappedIDArray) ? "checked='checked'" : "";
		?>
		<div>
			<input 
				type='checkbox' 
				<?php echo $checked; ?> 
				id='publicUserGroupID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
				name='publicUserGroupID' 
				value='<?php echo $x["priKeyID"]; ?>'
			/>
			<span><?php echo $x["groupDesc"]; ?></span>
		</div>
		<?php
			}
		?>
	</div>
</div>

<div class='radioGroupBlock'>
	<label for='isNullPage'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['isNullPage']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?> 
		<input
			type="radio"
			name="isNullPage"
			id="isNullPageYes<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('isNullPage')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?>  
			<input
				type="radio"
				name="isNullPage"
				id="isNullPageNo<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('isNullPage')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>

<div class='radioGroupBlock'>
	<label for='isTopStyle'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['isTopStyle']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>  
			<input
				type="radio"
				name="isTopStyle"
				id="isTopStyleYes<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('isTopStyle')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
			<input
				type="radio"
				name="isTopStyle"
				id="isTopStyleNo<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('isTopStyle')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>

<div class='radioGroupBlock'>
	<label for='isSideStyle'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['isSideStyle']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>  
			<input
				type="radio"
				name="isSideStyle"
				id="isSideStyleYes<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('isSideStyle')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
			<input
				type="radio"
				name="isSideStyle"
				id="isSideStyleNo<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('isSideStyle')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>

<div class='radioGroupBlock'>
	<label for='isBotttomStyle'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['isBotttomStyle']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>  
			<input
				type="radio"
				name="isBottomStyle"
				id="isBottomStyleYes<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('isBottomStyle')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
			<input
				type="radio"
				name="isBottomStyle"
				id="isBottomStyleNo<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('isBottomStyle')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>

<div class='optionsParent radioGroupBlock'>
	<label for='showSubNav'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['showSubNav']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?>  
			<input
				type="radio"
				name="showSubNav"
				id="showSubNavYes<?php echo $_REQUEST["recordID"]; ?>"
				onclick="$('#subNavTypeContainer').show()"
				value="1"
				<?php if($priModObj[0]->displayInfo('showSubNav')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
			<input
				type="radio"
				name="showSubNav"
				id="showSubNavNo<?php echo $_REQUEST["recordID"]; ?>"
				onclick="$('#subNavTypeContainer').hide()"
				value="0"
				<?php if($priModObj[0]->displayInfo('showSubNav')==0){echo "checked='checked'";} ?>
			/>
	</span>

	<div 
		class="radioGroupBlock toggleOptions"
		id="subNavTypeContainer<?php echo $_REQUEST["recordID"]; ?>"
		style=" <?php if($priModObj[0]->displayInfo('showSubNav')!=1){echo "display:none;";} ?>"
	>
		<div>
			<label for='subNavType'>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['subNavType']; ?>
			</label>
			<span>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['subNavTypeSide']; ?> 
			</span>
			<input
				type="radio"
				name="subNavType"
				id="subNavTypeYes<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('subNavType')==1){echo "checked='checked'";} ?>
			/>
			<span>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['subNavTypeTop']; ?>
			</span>
			<input
				type="radio"
				name="subNavType"
				id="subNavTypeNo<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('subNavType')==0){echo "checked='checked'";} ?>
			/>
		</div>
		
		<div>
			<label for='subNavCurrentLevel'>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['subNavCurrentLevel']; ?>
			</label>
			<span>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['subNavChildren']; ?> 
			</span>
			<input
				type="radio"
				name="subNavCurrentLevel"
				id="subNavCurrentLevelYes<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('subNavCurrentLevel')==1){echo "checked='checked'";} ?>
			/>
			<span>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['subNavSiblings']; ?>
			</span>
			<input
				type="radio"
				name="subNavCurrentLevel"
				id="subNavCurrentLevelNo<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('subNavCurrentLevel')==0){echo "checked='checked'";} ?>
			/>
            <span>
				Show parents nav structure 
			</span>
			<input
				type="radio"
				name="subNavCurrentLevel"
				id="subNavCurrentLevelAll<?php echo $_REQUEST["recordID"]; ?>"
				value="2"
				<?php if($priModObj[0]->displayInfo('subNavCurrentLevel')==2){echo "checked='checked'";} ?>
			/>
		</div>
	</div>
</div>

<div class='radioGroupBlock'>
	<label for='textOnlyUpdate'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['textOnlyUpdate']; ?>
	</label>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['yes']; ?> 
			<input
				type="radio"
				name="textOnlyUpdate"
				id="textOnlyUpdateYes<?php echo $_REQUEST["recordID"]; ?>"
				value="1"
				<?php if($priModObj[0]->displayInfo('textOnlyUpdate')==1){echo "checked='checked'";} ?>
			/>
	</span>
	<span>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['no']; ?> 
			<input
				type="radio"
				name="textOnlyUpdate"
				id="textOnlyUpdatevNo<?php echo $_REQUEST["recordID"]; ?>"
				value="0"
				<?php if($priModObj[0]->displayInfo('textOnlyUpdate')==0){echo "checked='checked'";} ?>
			/>
	</span>
</div>


<input
	type="hidden"
	name="parentPageID"
	id="parentPageID<?php echo $_REQUEST["recordID"]; ?>"
	value="<?php 
		if(strlen($priModObj[0]->displayInfo('parentPageID')) == 0) {
			echo "0" ;
		}
		else{
			echo $priModObj[0]->displayInfo('parentPageID');
		}
	?>"
/>

<input
	type="hidden"
	name="pageLevel"
	id="pageLevel<?php echo $_REQUEST["recordID"]; ?>"
	value="<?php if($priModObj[0]->displayInfo('pageLevel') >= 1) echo $priModObj[0]->displayInfo('pageLevel'); else echo 1; ?>"
/>