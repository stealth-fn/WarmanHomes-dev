<div>
	<label for='blogName'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['blogName']; ?>
	</label>
	<input
		type="text"
		id="blogName<?php echo $_REQUEST["recordID"]; ?>"
		name="blogName"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('blogName'); ?>"
	/>
</div>

<div>
	<label for='blogDescription'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['blogDescription']; ?>
	</label>
	<input
		type="text"
		id="blogDescription<?php echo $_REQUEST["recordID"]; ?>"
		name="blogDescription"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('blogDescription'); ?>"
	/>
</div>
<div>
	<label for='blogAuthorID'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['blogAuthorID']; ?>
	</label>
	<div class='moduleFormStyledSelect'>
		<select
			name="blogAuthorID"
			id="blogAuthorID<?php echo $_REQUEST["recordID"]; ?>"
		>
			<option>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['selectAuthor']; ?>
			</option>
			<?php
				$usersQuery = $publicUsersObj->getAllRecords();
				while($x = mysqli_fetch_array($usersQuery)){
					
					if($x['priKeyID'] == $priModObj[0]->displayInfo('blogAuthorID')){
						$selected = 'selected="selected"';
					}
					else{
						$selected = '';
					}
			?>
					<option 
						value="<?php echo $x['priKeyID'];?>"
						<?php echo $selected; ?>
					>
					<?php echo $x['firstName'] . ' ' . $x['lastName'];?>
					</option>
			<?php
				}
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
	<textarea 
		name="blogCopy" 
		id="blogCopy<?php echo $_REQUEST["recordID"]; ?>"
	><?php echo $priModObj[0]->displayInfo('blogCopy'); ?></textarea>
</div>
 <?php
	#we need to format the time from 24 to 12 hour, and make the date manually
	if(strlen($priModObj[0]->displayInfo('postDate')) > 0){
		$editDate = date("Y-m-d",strtotime($priModObj[0]->displayInfo('postDate')));
	}
	else{
		$editDate = date("Y-m-d",$_SERVER['REQUEST_TIME']);
	}
	
	if(strlen($priModObj[0]->displayInfo('postTime')) > 0){
		$editTime = date("g:i a",strtotime($priModObj[0]->displayInfo('postTime')));
	}
	else{
		$hourPlus = date("g")+2;
		$hourPlus = $hourPlus > 12 ? $hourPlus-12 : $hourPlus;
		$editTime = $hourPlus . date(":i a");
	}
?>

<div>
	<label for='postTime'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['postTime']; ?>
	</label>
	<input
		class="postTime noBulkExpand"
		name="postTime"
		type="text"
		maxlength="20"
		id="postTime<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $editTime; ?>"
	/>
</div>
<div>
	<label for='postDate'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['postDate']; ?>
	</label>
	<input
		class="postDate noBulkExpand"
		maxlength="20"
		name="postDate"
		id="postDate<?php echo $_REQUEST["recordID"]; ?>"
		type="text"
		value="<?php echo $editDate; ?>"
	/>
</div>

<?php
	#categories for this blog
	$blogCategories = $blogCategoriesObj->getAllRecords();

	#categories mapped to this blog
	$mappedCats = $blogCatMapObj->getConditionalRecord(
		array("blogID",$priModObj[0]->displayInfo('priKeyID'),true)
	);
	$mappedCatIDList = $blogCatMapObj->getQueryValueString($mappedCats,"blogCategoryID",",");
	$mappedCatArray = explode(",",$mappedCatIDList);

	if(mysqli_num_rows($blogCategories) > 0){
?>
		<div class='moduleSubElement'>
			<h3  
				onclick="$('#blogModuleBlogCats<?php echo $_REQUEST["recordID"]; ?>').toggle()" 
				class="adminShowHideParent"
			>
				<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['blogCats']; ?>
				<span>
					<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand']; ?>
				</span>
			</h3>
			<div 
				id='blogModuleBlogCats<?php echo $_REQUEST["recordID"]; ?>' 
				class='adminShowHideChild'
			>
		<?php
			while($x = mysqli_fetch_assoc($blogCategories)){
				$checked = "";
				if(in_array($x["priKeyID"],$mappedCatArray) !== false){
					$checked = "checked='checked'";
				}
		?>

				<div>
					<input 
						type='checkbox' 
						<?php echo $checked; ?> 
						id='blogCategoryID<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
						name='blogCategoryID' 
						class='blogCategoryID<?php echo $x["priKeyID"]; ?>' 
						value='<?php echo $x["priKeyID"]; ?>'
					/>
					<span><?php echo $x["blogCatTitle"]; ?></span>
				</div>

		<?php
			}
			echo "</div></div>";
	}

	#recommended blogs
	$recommendedBlogs = $priModObj[0]->getAllRecords();

	#blogs mapped to this blog
	$mappedBlogs = $blogRecommendedMapObj->getConditionalRecord(
		array("blogID",$priModObj[0]->displayInfo('priKeyID'),true)
	);
	$mappedBlogIDList = $blogRecommendedMapObj->getQueryValueString($mappedBlogs,"recommendedBlogID",",");
	$mappedBlogArray = explode(",",$mappedBlogIDList);
?>
<div class='moduleSubElement'>
	<h3  
		onclick="$('#blogModuleRecommendedBlogs<?php echo $_REQUEST["recordID"]; ?>').toggle()" 
		class="adminShowHideParent"
	>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['relatedArticles']; ?>
		<span>
			<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['toggleExpand']; ?>
		</span>
	</h3>
	<div id='blogModuleRecommendedBlogs<?php echo $_REQUEST["recordID"]; ?>' class='adminShowHideChild'>
	<?php
		while($x = mysqli_fetch_assoc($recommendedBlogs)){
			$checked = "";
			if(in_array($x["priKeyID"],$mappedBlogArray) !== false){
				$checked = "checked='checked'";
			}
	?>

		<div>
			<input 
				type='checkbox' 
				<?php echo $checked; ?> 
				id='recommendedBlog<?php echo $x["priKeyID"]; ?>_<?php echo $_REQUEST["recordID"]; ?>' 
				name='recommendedBlogID' 						
				class='recommendedBlogID' 
				value='<?php echo $x["priKeyID"]; ?>'
			/>
			<span><?php echo $x["blogName"]; ?></span>
		</div>

		<?php
	}
?>
	</div>
</div>