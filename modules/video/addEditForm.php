<div>
	<label for='videoName'>
		Video Title
	</label>
	<input
		type="text"
		id="videoName<?php echo $_REQUEST["recordID"]; ?>"
		name="videoName"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('videoName'); ?>"
	/>
</div>

<div>
	<label for='youtubeVidID'>YouTube Video ID</label>
	<input 
		type="text" 
		id="youtubeVidID" 
		name="youtubeVidID" 
		size="45" 
		maxlength="255" 
		value="<?php echo $priModObj[0]->displayInfo('youtubeVidID'); ?>"
	/>
</div>

<div>
	<label for='startTime'>
		Start Second
	</label>
	<input
		type="number"
		id="startTime<?php echo $_REQUEST["recordID"]; ?>"
		name="startTime"
		min="1"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('startTime'); ?>"
	/>
</div>

<div>
	<label for='endTime'>
		End Second
	</label>
	<input
		type="number"
		id="endTime<?php echo $_REQUEST["recordID"]; ?>"
		name="endTime"
		size="45"
		maxlength="255"
		value="<?php echo $priModObj[0]->displayInfo('endTime'); ?>"
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
	<label for='bannerTxt'>Banner Text</label>
	<textarea 
		name="bannerTxt" 
		id="bannerTxt<?php echo $_REQUEST["recordID"]; ?>"
		cols='100'
		rows='10'
	>
		<?php echo $priModObj[0]->displayInfo('bannerTxt'); ?>
	</textarea>
</div>

<div style="display: none">
<label for='bannerType'>Type of Banner</label>
	<span>
		Youtube Video
		<input 
			type="radio" 
			name="bannerType" 
			id="bannerTypeYoutube<?php echo $_REQUEST["recordID"]; ?>"
			value="0"
			<?php if($priModObj[0]->displayInfo('bannerType')==0){ ?>
				checked="checked"
			<?php } ?>
		/>
	</span>
</div>