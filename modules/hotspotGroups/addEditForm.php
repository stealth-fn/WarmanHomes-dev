<div id="moduleContainer">
	<form name="moduleForm" id="moduleForm" action="" >
		<div>
			<label for='hotspotGroupName'>Hotspot Group Name</label>
			<input 
	        	name="hotspotGroupName" 
	            id="hotspotGroupName"
	            type="text"
	            value="<?php echo trim($moduleObj->displayInfo('hotspotGroupName')); ?>"
	       	/>
	    </div>
	    <div>
	    	<label for="color">Color</label>
	    	<div id="colorSelector"></div>
	    	<input
	    		type="hidden"
	    		class="color"
	    		name="color"
	    		id="color"
	    		value="<?php echo trim($moduleObj->displayInfo('color')); ?>"
	    	/>
	    </div>

	<?php
	$moduleObj->addEditButtonValue = "Add Hotspot Group";
	
	if(isset($moduleObj->addEdit)){
		if($moduleObj->addEdit){
			echo "<input 
					name='priKeyID' 
					id='priKeyID' 
					value='" .$_REQUEST["recordID"]. "' 
					type='hidden'
				/>";
			$moduleObj->addEditButtonValue = "Save Changes";
		}
		else{
			echo "<input name='priKeyID' id='priKeyID' value='0' type='hidden'/>";
		}
	}
	?>
        
		<input 
        	type="button" 
            id="moduleAddEditBtn" 
            name="moduleAddEditBtn" 
            value="<?php echo $moduleObj->addEditButtonValue; ?>" 
            onclick="hotspotGroupAddEditObj.addEditModule(this)"
        />				
	</form>	
</div>
<div id='moduleHelp'>
<h2>Help<a href='#' id='helpHideButton' title=''>hide</a></h2>
<p id='helpText'><?php $moduleObj->displayInfo('moduleHelp')?></p>
</div>