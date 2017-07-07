<?php
	#clickslide/fadethrough storage container
	if(
		($priModObj[0]->instanceDisplayType == 0 ||
		$priModObj[0]->instanceDisplayType == 4 ||
		$priModObj[0]->instanceDisplayType == 3) &&
		#hack for the login module...
		$priModObj[0]->moduleID!=37	
	){
		$qryQty = mysqli_num_rows($priModObj[0]->primaryModuleQuery);
		
		#reset our primaryModuleQuery
		#why did we reset it....?
		/*if we reset it we would put all of the items into the storage
		we only want the remaining items to go into the storage*/
		/*if($qryQty > 0) {
			mysqli_data_seek($priModObj[0]->primaryModuleQuery,$qryQty-1);
		}*/
				
		$priModObj[0]->clickStorage = "1";
		
		#click slide data setup
		$queryCnt = $priModObj[0]->displayQty;
	?>
		<div class="clss" id="clss-<?php echo $priModObj[0]->className;?>">
			<?php 
				#remaing module items
				include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFrameItems.php");
			?>
		</div>
<?php
		$priModObj[0]->clickStorage = "0";
	}
?>