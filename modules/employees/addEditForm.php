<div>
	<label for='employeeName'>Employee Name</label>
	<input
		type="text" 
		name="employeeName" 
		maxlength="255"
		id="employeeName<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('employeeName'); ?>"
	/>
</div>

<div>
	<label for='employeeTitle'>Employee Title</label>
	<input
		type="text" 
		name="employeeTitle" 
		maxlength="255"
		id="employeeTitle<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $priModObj[0]->displayInfo('employeeTitle'); ?>"
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
	<label for='employeeBio'>Employee's Biography</label>
	<textarea 
		name="employeeBio" 
		id="employeeBio<?php echo $_REQUEST["recordID"]; ?>"
		cols='100'
		rows='10'
	>
		<?php echo $priModObj[0]->displayInfo('employeeBio'); ?>
	</textarea>
</div>