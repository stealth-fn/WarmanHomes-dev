<div id="moduleContainer">
	<form name="moduleForm" id="moduleForm" action="">
		<div>
			<label for='videoDesc'>Video Title</label>
			<input 
				type="text" 
				id="videoDesc" 
				name="videoDesc" 
				size="45" 
				maxlength="255" 
				value="<?php echo displayInfo('videoDesc'); ?>"
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
				value="<?php echo displayInfo('youtubeVidID'); ?>"
			/>
		</div>
		<?php			
			$addEditButtonValue = "Create YouTube Video";
			
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
		
		<input type="button" id="moduleAddEditBtn" name="moduleAddEditBtn" value="<?php echo $addEditButtonValue; ?>" onclick="addEditModule(<?php echo $addEdit; ?>)"/>			
	</form>	
</div>
<div id='moduleHelp'>
<h2>Help<a href='#' id='helpHideButton' title=''>hide</a></h2>
<p id='helpText'><?php displayInfo('moduleHelp')?></p>
</div>