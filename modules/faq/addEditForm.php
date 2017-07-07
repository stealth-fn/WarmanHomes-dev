<div>
	<label for='faqQuestion'>Question</label>
	<input 
		type="text" 
		id="faqQuestion<?php echo $_REQUEST["recordID"]; ?>" 
		name="faqQuestion" 
		size="45" 
		maxlength="255" 
		value="<?php echo trim($priModObj[0]->displayInfo('faqQuestion')); ?>"
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
	<label for='faqAnswer'>Answer</label>
	<textarea 
		name="faqAnswer" 
		id="faqAnswer<?php echo $_REQUEST["recordID"]; ?>"
		cols='100'
		rows='10'
	>
		<?php echo trim($priModObj[0]->displayInfo('faqAnswer')); ?>
	</textarea>
</div>
<?php
	#Get all of the FAQ categories
	$faqCategories = $faqCategoryObj->getAllRecords();
	
	if(mysqli_num_rows($faqCategories) > 0){
		echo "
		<div class='moduleSubElement'>
			<h3 onclick=\"$('#faqCategories" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
				FAQ Categories<span>&lt; click to toggle visibility</span>
			</h3>
			<div 
				id='faqCategories" . $_REQUEST["recordID"] . "' 
				class='adminShowHideChild'
			>";
			while($x = mysqli_fetch_array($faqCategories)){
			#check to see if this one is mapped already, if it is, check it off
			if(isset($_REQUEST["recordID"])){
				$catMapped = $faqCatMap->getConditionalRecord(
					array("faqID",$_REQUEST["recordID"],true,"faqCategoryID",$x["priKeyID"],true)
				);
			}
			
			if(isset($catMapped) && mysqli_num_rows($catMapped) > 0){
				echo "
					<div>
						<input 
							id='faqCategoryID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
							type='checkbox' 
							checked='checked' 
							name='faqCategoryID' 
							class='categorisedPost" . $x["priKeyID"] . "' 
							value='" . $x["priKeyID"] . "'
						/>
						<span>" . htmlentities(html_entity_decode($x["faqCategory"],ENT_QUOTES),ENT_QUOTES) . "</span>
					</div>";
			}
			else{
				echo "
					<div>
						<input 
							id='faqCategoryID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
							type='checkbox' 
							name='faqCategoryID' 
							class='categorisedPost" . $x["priKeyID"] . "' 
							value='" . $x["priKeyID"] . "'
						/>
						<span>" . htmlentities(html_entity_decode($x["faqCategory"],ENT_QUOTES),ENT_QUOTES) . "</span>
					</div>";
			}
		}
		echo "
			</div>
		</div>";
	}
?>	
