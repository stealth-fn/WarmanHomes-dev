<div id="moduleContainer">

	<form name="moduleForm" id="moduleForm" action="" >

		<div>

			<label for='hotspotDataName'>Hotspot Data Field Name</label>

			<input 

	        	name="hotspotDataName" 

	            id="hotspotDataName"

	            type="text"

	            value="<?php echo trim($moduleObj->displayInfo('hotspotDataName')); ?>"

	       	/>

	    </div>

	    <?php

		$imageAreaMaps = $imageAreaMapObj->getAllRecords();

		

		#image area maps mapped to this data field

		$mappedImageAreaMaps = $hotspotDataImageAreaMapObj->getConditionalRecord(array("hotspotDataID",$_REQUEST["recordID"],true));

		$mappedImageAreaMapIDs = $hotspotDataImageAreaMapObj->getQueryValueString($mappedImageAreaMaps,"imageAreaMapID",",");

		$mappedImageAreaMapsArray = explode(",",$mappedImageAreaMapIDs);



		if(mysqli_num_rows($imageAreaMaps) > 0){

		?>

		<div class='moduleSubElement'>

			<h3 onclick="$('#imageAreaMaps').toggle().toggle()" class="adminShowHideParent">Image Area Maps For This Hotspot Data Field

				<span>&lt; click to toggle visibility</span>

			</h3>

			<div id='imageAreaMaps' class='adminShowHideChild'>

				<?php

					while($x = mysqli_fetch_array($imageAreaMaps)){

						$checked = "";

						if(in_array($x["priKeyID"],$mappedImageAreaMapsArray) !== false){

							$checked = "checked='checked'";

						}

				?>

				

				<div>

					<input type='checkbox' <?php echo $checked; ?> id='imageAreaMap<?php echo $x["priKeyID"]; ?>' name='imageAreaMapID' class='imageAreaMap' value='<?php echo $x["priKeyID"]; ?>'/>

					<span><?php echo $x["imageAreaMapName"]; ?></span>

				</div>

				

				<?php	

					}

				echo "

			</div>

		</div>";

		}

	$moduleObj->addEditButtonValue = "Add Hotspot Data";

	

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

            onclick="hotspotDataAddEditObj.addEditModule(this)"

        />				

	</form>	

</div>

<div id='moduleHelp'>

<h2>Help<a href='#' id='helpHideButton' title=''>hide</a></h2>

<p id='helpText'><?php $moduleObj->displayInfo('moduleHelp')?></p>

</div>