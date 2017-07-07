<?php
	if(isset($_REQUEST["parentPriKeyID"])){
		$parentParams = "&amp;parentPriKeyID=" . $_REQUEST["parentPriKeyID"];
	}
	else{
		$parentParams = "";
	}

	#The products module appends an additonal number to the end of the priKey. getting rid of this addtional number so that all the buttons work correctly.
	#This is undone at the end of the file
	$tempPriKey = $priModObj[0]->queryResults["priKeyID"];
	$priModObj[0]->queryResults["priKeyID"] = strtok($priModObj[0]->queryResults["priKeyID"], '_');
	
	#If isDraft field exists			        
 	if(strpos($priModObj[0]->tableRecords,"isDraft") !== false){
	 	if($priModObj[0]->queryResults["draftPriKeyID"]== 0 && $priModObj[0]->queryResults["isDraft"]== false){
		?>
		
			<a
				class="moduleItemEdit"
				href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?>
				&amp;recordID=<?php echo $priModObj[0]->queryResults["priKeyID"]; ?><?php echo $parentParams; ?>"
				id="moduleItemEdit<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>"
				onclick="upc(
					<?php echo $priModObj[0]->addEditPageID; ?>,
					'recordID=<?php echo $priModObj[0]->queryResults["priKeyID"]; ?><?php echo $parentParams; ?>'
			
				); return false" 
				title="Edit"
			>
			Edit
			</a>
			
			<a 
				class="moduleItemDelete"
				href=""
				id="moduleItemDelete<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>"
				onclick="window['<?php echo $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"]; ?>'].moduleDelete(
				'<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>',this
				); return false"
				title="Delete"
			>
			Delete
			</a>
			
		<?php
		}
		
		else if($priModObj[0]->queryResults["livePriKeyID"]== 0  && $priModObj[0]->queryResults["isDraft"]==  true){ 
	 	?>
		
			<a
				class="moduleItemEditDraft"
				href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?>
				<?php echo $parentParams; ?>"
				id="moduleItemDraftEdit<?php echo $priModObj[0]->queryResults["draftPriKeyID"]; ?>"
				onclick="upc(
				<?php echo $priModObj[0]->addEditPageID; ?>,
				'recordID=<?php echo $priModObj[0]->queryResults["draftPriKeyID"]; ?><?php echo $parentParams; ?>'
				); return false" 
				title="Draft Edit"
			>
			Draft Edit
			</a> 
			 
			 <a 
				class="moduleItemDeleteDraft"
				href=""
				id="moduleItemDeleteDraft<?php echo $priModObj[0]->queryResults["draftPriKeyID"]; ?>"
				onclick="window['<?php echo $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"]; ?>'].moduleDelete(
				'<?php echo $priModObj[0]->queryResults["draftPriKeyID"]; ?>',this
				); return false"
				title="Draft Delete"
			>
			Draft Delete
			</a>
			
		<?php
	 	}
		
		else if(($priModObj[0]->queryResults["livePriKeyID"]> 0 && $priModObj[0]->queryResults["draftPriKeyID"]>0)){ 
	 	?>
			<a
				class="moduleItemEditDraft"
				href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?>
				<?php echo $parentParams; ?>"
				id="moduleItemDraftLiveEdit<?php echo $priModObj[0]->queryResults["draftPriKeyID"]; ?>"
				onclick="upc(
				<?php echo $priModObj[0]->addEditPageID; ?>,
				'recordID=<?php echo $priModObj[0]->queryResults["draftPriKeyID"]; ?><?php echo $parentParams; ?>'
				); return false" 
				title="Draft Edit"
			>
			Draft Edit
			</a> 
			
			<a 
				class="moduleItemDeleteDraft"
				href=""
				id="moduleItemDeleteDraftLive<?php echo $priModObj[0]->queryResults["draftPriKeyID"];?>"
				onclick="window['<?php echo $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"]; ?>'].moduleDelete(
				'<?php echo $priModObj[0]->queryResults["draftPriKeyID"]; ?>',this
				); return false "
				title="Draft Delete"
			>
			Draft Delete
			</a>
			
			<a
				class="moduleItemEdit"
				href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?>
				<?php echo $parentParams; ?>"
				id="moduleItemEdit<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>"
				onclick="upc(
					<?php echo $priModObj[0]->addEditPageID; ?>,
					'recordID=<?php echo $priModObj[0]->queryResults["priKeyID"]; ?><?php echo $parentParams; ?>'
				); return false" 
				title="Edit"
			>
			Edit
			</a>
			
			<a 
				class="moduleItemDelete"
				href=""
				id="moduleItemDelete<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>"
				onclick="window['<?php echo $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"]; ?>'].moduleDelete(
				'<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>',this
				); return false"
				title="Delete"
			>
			Delete
			</a>	
		
		<?php
		 }
		 
	}
	# display all the buttons
	else if ($priModObj[0]->adminButtons == 1) {
	?>
			<a
				class="moduleItemEdit"
				href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?>
				<?php echo $parentParams; ?>"
				id="moduleItemEdit<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>"
				onclick="upc(
					<?php echo $priModObj[0]->addEditPageID; ?>,
					'recordID=<?php echo $priModObj[0]->queryResults["priKeyID"]; ?><?php echo $parentParams; ?>'
			
				); return false" 
				title="Edit"
			>
			Edit
			</a>
			
			<a 
				class="moduleItemDelete"
				href=""
				id="moduleItemDelete<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>"
				onclick="window['<?php echo $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"]; ?>'].moduleDelete(
				'<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>',this
				); return false"
				title="Delete"
			>
			Delete
			</a>
			
	<?php
	} #display only Edit button
	else if ($priModObj[0]->adminButtons == 2) {
	?>
		<a
			class="moduleItemEdit"
			href="/index.php?pageID=<?php echo $priModObj[0]->addEditPageID; ?>
			<?php echo $parentParams; ?>"
			id="moduleItemEdit<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>"
			onclick="upc(
				<?php echo $priModObj[0]->addEditPageID; ?>,
				'recordID=<?php echo $priModObj[0]->queryResults["priKeyID"]; ?><?php echo $parentParams; ?>'

			); return false" 
			title="Edit"
		>
		Edit
		</a>
	<?php
		}
	# display none of the buttons
	else {
	?>
	
	<?php
	}
 	$priModObj[0]->queryResults["priKeyID"] = $tempPriKey;
	?>