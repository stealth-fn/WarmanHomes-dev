<div>
	<label for='faqCategory'>FAQ Category Name</label>
	<input 
		type="text" 
		id="faqCategory<?php echo $_REQUEST["recordID"]; ?>" 
		name="faqCategory" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('faqCategory'); ?>"
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
	<label for="faqCategoryDesc">FAQ Category Description</label>
	<textarea 
		name="faqCategoryDesc" 
		id="faqCategoryDesc<?php echo $_REQUEST["recordID"]; ?>"
	><?php echo $priModObj[0]->displayInfo('faqCategoryDesc'); ?></textarea>
</div>

<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/faq/faq.php");
	$faqObj = new faq(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/faq/faqCatMap.php");
	$faqCatMapObj = new faqCatMap(false);
	$faqPosts = $faqObj->getAllRecords();
	
	if(mysqli_num_rows($faqPosts) > 0){
		echo "
			<div class='moduleSubElement'>
				<h3 
					onclick=\"$('#categorisedPosts" . $_REQUEST["recordID"] . "').toggle()\" 
					class=\"adminShowHideParent\"
				>FAQs In This Category <span>&lt; click to toggle visibility</span>
				</h3>
				<div 
					id='categorisedPosts" . $_REQUEST["recordID"] . "' 
					class='adminShowHideChild'
				>
		";
		
		while($x = mysqli_fetch_array($faqPosts)){
			/*check to see if this one is mapped already, if it is, check it off*/
			if(isset($_REQUEST["recordID"])){
				$catMapped = $faqCatMapObj->getConditionalRecord(
					array(
						"faqCategoryID",$_REQUEST["recordID"],
						true,"faqID",$x["priKeyID"],true
					)
				 );
			}
			if(isset($catMapped) && mysqli_num_rows($catMapped) > 0){
				echo  "
					<div>
						<input 
							type='checkbox' 
							checked='checked' 
							name='faqID' 
							id='faqID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
							class='faqPost" . $x["priKeyID"] . "' 
							value='" . $x["priKeyID"] . "'
						/><span>" . $x["faqQuestion"] . "</span>
					</div>
				";
			}
			else{
				echo "
					<div>
						<input 
							type='checkbox' 
							name='faqID' 
							id='faqID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
							class='faqPost" . $x["priKeyID"] . "' 
							value='" . $x["priKeyID"] . "'
						/><span>" . $x["faqQuestion"] . "</span>
					</div>";
			}
		}
		echo "
				</div>
			</div>
		";
	}
?>