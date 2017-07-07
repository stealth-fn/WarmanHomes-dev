<div id="moduleContainer">
	<form name="moduleForm" id="moduleForm" action="">
		<div>
		<label for="channelName">Name</label>
        <input 
            type="text" 
            id="channelName" 
            name="channelName"
            maxlength="20" 
            value="<?php echo displayInfo('channelName'); ?>"
        />
    </div>
    <div>
		<label for="population">Population</label>
        <input 
            type="text" 
            id="population" 
            name="population"
            maxlength="5" 
            value="<?php echo displayInfo('population'); ?>"
        />
    </div>
    <div>
    	<label for="channelPass">Password</label>
        <input 
            type="text" 
            id="channelPass" 
            name="channelPass"
            maxlength="15" 
            value="<?php echo displayInfo('channelPass'); ?>"
        />
    </div>
    <div class='radioGroupBlock'>
		<label for="primaryChannel">Main Channel</label>
		<span>
					Yes <input
							    type="radio" 
					            id="primaryChannel1" 
					            name="primaryChannel"
					            value="1" <?php if(displayInfo('primaryChannel')==1){echo "checked='checked'";} ?>
						/>
				</span><span>
					No <input
					        	type="radio" 
					            name="primaryChannel" 
					            id="primaryChannel0" 
					            value="0" <?php if(displayInfo('primaryChannel')==0){echo "checked='checked'";} ?>
						/>
				</span>
		</div>
		
		<?php
			$addEditButtonValue = "Create Channel";
			
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
