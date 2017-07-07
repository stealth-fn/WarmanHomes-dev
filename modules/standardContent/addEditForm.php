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
	<label for='headerContent'>Header Content</label>
	<textarea 
		name="headerContent" 
		id="headerContent<?php echo $_REQUEST["recordID"]; ?>"
		cols='100'
		rows='10'
	>
		<?php echo $priModObj[0]->displayInfo('headerContent'); ?>
	</textarea>
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
	<label for='footerContent'>Footer Content</label>
	<textarea 
		name="footerContent" 
		id="footerContent<?php echo $_REQUEST["recordID"]; ?>"
		cols='100'
		rows='10'
	>
		<?php echo $priModObj[0]->displayInfo('footerContent'); ?>
	</textarea>
</div>
