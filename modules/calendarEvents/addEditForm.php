<div id="moduleContainer">
	<form name="moduleForm" id="moduleForm" action="">
		<div>
			<label for='event_title'>Event Title</label>
			<input 
				type="text" 
				id="event_title" 
				name="event_title" 
				size="45" 
				maxlength="255" 
				value="<?php echo displayInfo('event_title'); ?>"
			/>
		</div>
		<div>
			<label for='event_desc'>Event Description</label>
			<input 
				type="text" 
				id="event_desc" 
				name="event_desc" 
				size="45" 
				maxlength="255" 
				value="<?php echo displayInfo('event_desc'); ?>"
			/>
		</div>
		
		<?php
			/*we need to format the time from 24 to 12 hour, and make the date manually*/
			$editTime = date("g:i a",strtotime(displayInfo('event_time')));
			$editDate = date("m/d/Y",strtotime(displayInfo('event_date')));
		?>
		
		<div>
			<label for='event_time'>Event Time</label>
			<input name="event_time" 
				type="text" 
				maxlength="20" 
				id="event_time" 
				value="<?php echo $editTime; ?>" 
				size="32" 
				onblur="validateDatePicker(this)" 
			/>
			<input name="event_time_picker" type="button" class="buttonTimeSmall" title="Pick A Time" onclick="selectTime(this,document.getElementById('event_time'));"/>	
		</div>
		<div>
			<label for='event_date'>Event Date</label>
			<input 
				maxlength="20" 
				name="event_date" 
				id="event_date" 
				type="text" 
				value="<?php echo $editDate; ?>"
			/>	
		</div>

		<?php			
			$addEditButtonValue = "Create Event";
			
			if(isset($addEdit)){
				if($addEdit == 1){
					echo "<input name='priKeyID' id='priKeyID' value='" .$_POST["recordID"]. "' type='hidden'/>";					
					$addEditButtonValue = "Save Changes";	
				}
				else{
						echo "<input name='priKeyID' id='priKeyID' value='0' type='hidden'/>";
				}
			}
		?>
		<input type="button" id="moduleAddEditBtn" name="moduleAddEditBtn" value="<?php echo $addEditButtonValue; ?>" onclick="addEditModule(this)"/>				
	</form>
</div>
<div id='moduleHelp'>
<h2>Help<a href='#' id='helpHideButton' title=''>hide</a></h2>
<p id='helpText'><?php displayInfo('moduleHelp')?></p>
</div>