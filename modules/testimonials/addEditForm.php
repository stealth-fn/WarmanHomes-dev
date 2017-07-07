<div>
	<label for='testimonialName'>Name</label>
	<input
		type="text" 
		name="testimonialName" 
		maxlength="255"
		id="testimonialName<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('testimonialName'); ?>"
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
	<label for='testimonial'>Testimonial</label>
	<textarea 
		name="testimonial" 
		id="testimonial<?php echo $_REQUEST["recordID"]; ?>"
		cols='100'
		rows='10'
	>
		<?php echo $priModObj[0]->displayInfo('testimonial'); ?>
	</textarea>
</div>
