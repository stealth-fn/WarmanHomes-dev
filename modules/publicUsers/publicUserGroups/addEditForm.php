<div>
	<label for='groupDesc'>Group Name</label>
	<input 
		type="text" 
		id="groupDesc<?php echo $_REQUEST["recordID"]; ?>" 
		name="groupDesc" 
		size="45" 
		maxlength="100" 
		value="<?php echo $priModObj[0]->displayInfo('groupDesc'); ?>"
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
		name="groupCopy" 
		id="groupCopy<?php echo $_REQUEST["recordID"]; ?>" 
		rows="10" 
		cols="10"> <?php echo $priModObj[0]->displayInfo('groupCopy'); ?>
	</textarea>	
</div>

<?php
	#Get all of the users
	$publicUsers = $publicUsersObj->getAllRecords();

	echo "<div class='moduleSubElement'>

			<h3 onclick=\"$('#availableUsers').toggle()\" class=\"adminShowHideParent\">Users In Group
				<span>&lt; click to toggle visibility</span>
			</h3>

			<div id='availableUsers' class='adminShowHideChild'>";

	while($x = mysqli_fetch_assoc($publicUsers)){

		$mappedPublicUser = $publicUserGroupMapObj->getConditionalRecord(
			array("publicUserID",$x["priKeyID"],true,"publicUserGroupID",$_REQUEST["recordID"],true)
		);

		echo '<div>
				<input
					type="checkbox"
					id="publicUserID' . $x["priKeyID"] . '"
					name="publicUserID"
					value="' . $x["priKeyID"] . '"'
					. ((mysqli_num_rows($mappedPublicUser)>0) ? 'checked="checked"' : "") . '"

				/>
					<span>' . $x["firstName"] . " " . $x["lastName"] . ' - ' . $x["loginName"] . '</span>
			  </div>';

	}

	echo "</div></div>";
?>