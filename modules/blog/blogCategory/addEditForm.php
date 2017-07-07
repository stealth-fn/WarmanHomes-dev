<div>
	<label for='blogCatTitle'>Category Name</label>
	<input 
		type="text"
		id="blogCatTitle<?php echo $_REQUEST["recordID"]; ?>" 
		name="blogCatTitle"
		class="blogCatTitle"
		value="<?php echo $priModObj[0]->displayInfo('blogCatTitle'); ?>"
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
	<label for="blogCatDesc">Blog Category Description</label>
	<textarea 
		name="blogCatDesc" 
		id="blogCatDesc<?php echo $_REQUEST["recordID"]; ?>"
	><?php echo $priModObj[0]->displayInfo('blogCatDesc'); ?></textarea>
</div>

<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blog.php");
	$blogObj = new blog(false);
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogCategoriesMap.php");
	$blogCatMapObj = new blogCategoriesMap(false);
	$blogPosts = $blogObj->getAllRecords();
	
	if(mysqli_num_rows($blogPosts) > 0){
		echo "
			<div 
				class='moduleSubElement'
			>
				<h3 onclick=\"$('#categorisedPosts" . $_REQUEST["recordID"] . "').toggle()\" class=\"adminShowHideParent\">
					Posts In This Category<span>&lt; click to toggle visibility</span>
				</h3>
				<div 
					id='categorisedPosts" . $_REQUEST["recordID"] . "' 
					class='adminShowHideChild'
				>";
				while($x = mysqli_fetch_array($blogPosts)){
					/*check to see if this one is mapped already, if it is, check it off*/
					if(isset($_REQUEST["recordID"])){
					$catMapped = $blogCatMapObj->getConditionalRecord(
						array(
							"blogCategoryID",$_REQUEST["recordID"],
							true,"blogID",$x["priKeyID"],true
						)
					 );
				}
				if(isset($catMapped) && mysqli_num_rows($catMapped) > 0){
					echo  "
						<div>
							<input 
								type='checkbox' 
								checked='checked'
								name='blogID' 
								id='blogID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
								class='blogPost" . $x["priKeyID"] . "' 
								value='" . $x["priKeyID"] . "'
							/><span>" . $x["blogName"] . "</span>
						</div>
					";
				}
				else{
					echo "
						<div>
							<input 
								type='checkbox' 
								name='blogID'
								id='blogID" . $x["priKeyID"] . "_" . $_REQUEST["recordID"] . "'
								class='blogPost" . $x["priKeyID"] . "' 
								value='" . $x["priKeyID"] . "'
							/><span>" . $x["blogName"] . "</span>
						</div>
					";
				}
		}
		echo "
				</div>
			</div>
		";
	}
?>

<div class='radioGroupBlock'>
	<label for='includeInSidebar'>
		Include This Category in Sidebar?
	</label>
	<span>
		Yes
		<input
			type="radio"
			name="includeInSidebar"
			id="includeInSidebar<?php echo $_REQUEST["recordID"]; ?>"
			value="1"
			<?php if($priModObj[0]->displayInfo('includeInSidebar')==1){echo "checked='checked'";} ?>
		/>
	</span>
	<span>
		No
		<input
			type="radio"
			name="includeInSidebar"
			id="includeInSidebar<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('includeInSidebar')==0){echo "checked='checked'";} ?>
		/>
	</span>
</div>