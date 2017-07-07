/*our priKeyID's/recordID's. we store them in here and then run loadCKEditor 
all at once, otherwise we end up calling in the ckeditor script for each textarea*/
tempObjArray = [];

<?php
	#if its an empty query we still want to load our module
	$loopOnce = false;
	
	#how many queries into the loop are we 
	$qryLoopCnt = 0;
	
	#make sure our query pointer is at it's proper starting location
	if(mysqli_num_rows($priModObj[0]->primaryModuleQuery) > 0) {

		#Hard refresh or UPC
		if(
			isset($priModObj[0]->pagPage) &&
			strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") === false  &&
			strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") === false ||
			#...or paginated and a module level > 1
			(
				(strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") !== false ||
				strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") !== false) &&
				isset($priModObj[1])
			)
			
		){
			#if we are on the first page, don't put the pointer to -10
			$tmpDsp = ($priModObj[0]->pagPage * $priModObj[0]->displayQty) - $priModObj[0]->displayQty;

			if($tmpDsp >= 0){
				$tmpPointer = $tmpDsp;
			}
			else{
				$tmpPointer = 0;
			}

			mysqli_data_seek($priModObj[0]->primaryModuleQuery,$tmpPointer);
		}
		#Pagination, we only query the records we're changing
		else{
			mysqli_data_seek($priModObj[0]->primaryModuleQuery,0);
		}
	}

	while(
		(
			($amq = mysqli_fetch_assoc($priModObj[0]->primaryModuleQuery)) &&
			#...if we're displaying all, or just through through the display quantity
			($priModObj[0]->displayQty == -1 || ($qryLoopCnt < $priModObj[0]->displayQty))
		) || 
		(!$loopOnce)
	){
		
		#don't override the ID on bulk adding
		if(
			!isset($priModObj[0]->bulkMod) ||
			isset($priModObj[0]->bulkMod) && !isset($_GET["pmpmID"]
		)){ 
				$_REQUEST["recordID"] = $amq["priKeyID"];
		}

		#$modInfoArray["isTemplate"] is set 
		#create form validation for this module
		if(isset($priModObj[0]->moduleSettings["validateFields"])) {
			echo $priModObj[0]->generateFormValidation(
				"moduleForm" . $_REQUEST["recordID"],$priModObj[0]->moduleSettings["validateFields"]
			);
		}
?>
		//create instance for our add/edit form object
		/*need to declare the variables using a string in the window object, otheriwse our negative
		priKeyID's will give us an 'invalide assignemtn left-hand side opperator*/
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"] = new window[mIP.instanceProp.className + "Obj"]();

		//empty string if $_REQUEST["recordID"] doesn't exist
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].priKeyID = "<?php echo $_REQUEST["recordID"]; ?>";	
		
		//make the formID a property of the object
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].formID = "moduleForm<?php echo $_REQUEST["recordID"]; ?>";
		
		//make the form object a property of this object for easy reference
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].modForm = $s("moduleForm<?php echo $_REQUEST["recordID"]; ?>");
		
		//keep a string as the name of the object to reference it out of scope... ex in intervals
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].objRef = "<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>";
		
		<?php
			#parent module. ex gallery for gallery images
			if(isset($priModObj[0]->parentPriKeyID)){
		?>
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].parentPriKeyID = "<?php echo $priModObj[0]->parentPriKeyID; ?>";
		<?php
			}
		?>
		
		<?php
			#input type to write back to parent module
			if(isset($_REQUEST["inputType"])){
		?>
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].inputType = "<?php echo $_REQUEST["inputType"]; ?>";
		<?php
			}
		?>
		
		<?php
			#input description field to write back to parent module
			if(isset($_REQUEST["inputDesc"])){
		?>
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].inputDesc = "<?php echo $_REQUEST["inputDesc"]; ?>";
		<?php
			}
		?>
		
		<?php
			#parent form to write back new input element
			if(isset($_REQUEST["parentFormID"])){
		?>
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].parentFormID = "<?php echo $_REQUEST["parentFormID"]; ?>";
		<?php
			}
		?>
		
		<?php
			#name of input field to write back to parent module
			if(isset($_REQUEST["inputName"])){
		?>
		window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].inputName = "<?php echo $_REQUEST["inputName"]; ?>";
		<?php
			}
		?>
		
		<?php
			#record rating
			if($priModObj[0]->hasRating == 1){
		?>
				//set the callback for when the user clicks on a star
				$(".star_<?php echo $priModObj[0]->className . "_" . $_REQUEST["recordID"]; ?>").rating(
					{ 
						callback: function(value, link){ 
							window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].moduleRating(value); 
						}
					}
				);
		<?php
			}
		?>
		
		<?php
			/*if this module is the "primary module" for the page, 
			overwrite the URL to be a friendly version*/
			
			#replace spaces with dashes in our page name
			if($priModObj[0]->isPrimaryPageModule == "1"){
		?>
			//only needs to change the url, everything should be done in ajaxPost
			historyBool = false;
			History.replaceState(
				historySet,
				"",
				"/" + seoFolderName + "/" + pageArray[pageID].name + "/" +
				"<?php echo rawurlencode($priModObj[0]->getCleanURLStr($amq[$priModObj[0]->primaryPageModuleTitleField])); ?>"
			);
			historyBool = true;
		<?php
			}
		?>
				
		//push reference into array
		tempObjArray.push("<?php echo $_REQUEST["recordID"]; ?>");
<?php
		#quick edit for module list items, only when logged in as admin
		if(
			#logged in as an admin
			isset($_SESSION['sessionSecurityLevel']) && 
			$_SESSION['sessionSecurityLevel'] ==3 &&
			#is a module list item
			$priModObj[0]->isTemplate == 1 &&
			#has a mapped add/edit module
			is_numeric($priModObj[0]->primaryPmpmAddEditID)
		) {
?> 
			$("#<?php echo $priModObj[0]->miPrefix; ?>_<?php echo $priModObj[0]->className; ?>_<?php echo $_REQUEST["recordID"]; ?> .moduleQuickEdit").on(
				"click",
				function(event){
					window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].setupRecord(
						true,this,window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].primaryPmpmAddEditID,null,null
					);
				}
			);
<?php
		}
		
		$qryLoopCnt++;
			
		#only loop through once if there aren't any records or we're adding an new record
		$loopOnce = true;
	}
?>

//initialize any CKEditors for this instance of this module
if(tempObjArray.length > 0){
	window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].loadCKEditor(tempObjArray);
}
//initialize any time pickers for this instance of this module
if(window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].timeFields.length > 0){
	var tempArray = window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].timeFields.split(",");

	//loop through all our time fields by class
	for(var x = 0; x < tempArray.length; x++) {
		var tempClassArray = $$s(tempArray[x]);

		//loop through all the elements with that class
		for(var y = 0; y < tempClassArray.length; y++) {
			
			tempClassArray[y].onclick = function(){
				showTimePicker(this);
			};
		}
	}
}

<?php
	#on bulk add/editing set the CKEditor so we can toggle it to display it
	if(isset($priModObj[0]->bulkMod)){
?>
	//if we have ckeditor field on this module
	if(window["<?php echo $priModObj[0]->jsObject;?>"].prototype.ckEditorFieldName){
		$(".bulkCKEditor").bind(
			"click",
			function(event){
				//prevent the ckeditor from closing when we click inside of it
				event.stopPropagation();

				//attach toggle even
				$("#" + this.id + " > *[class^='cke_']").show();

				//add the transparent background on the bulk edit ckeditor
				$("html").addClass("bulkCover");
			}
		);
		
		//close open ckeditors
		$('html').bind(
			"click",
			function(event){
				//if the user clicks outside of a ckeditor dialog box
				if(
					!$(event.target).is(".cke_dialog") &&
					!$(event.target).parents(".cke_dialog").length > 0
				){
					$(".bulkCKEditor > *[class^='cke_']").hide();
					$(".bulkCover").removeClass("bulkCover");
				}
			}
		);
	}
<?php
	}
?>

<?php
	//only let our record list be sortable
	if($priModObj[0]->isTemplate == 1){
?>

/*not the login module. login module must be isTemplate 1, because we update 
the innerHTML of it using the paginate function. we don't want it sortable*/
if(window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].moduleID != 37){
	if($$s("moduleContainer") && $$s("moduleContainer").length > 0){
		//only let level one modules be sortable
		$(".pcpy > #mfmc-<?php echo $priModObj[0]->className; ?> #mfmcc-<?php echo $priModObj[0]->className; ?>").sortable({
			items:".mi-<?php echo $priModObj[0]->className; ?>",
			update:function(nativeEvent,ui){
				try{					
					//send out JSON object to the server to update the order of the records
					var sortAjax = ajaxObj();
					var modData = {};
					modData["function"] = "updateRecordOrder";
					
					//create a delimited list of our id's
					var idArray = JSON.stringify(
						$("#mfmcc-<?php echo $priModObj[0]->className; ?>").sortable("serialize")
					).split("&");
					var tempLen = idArray.length;
					
					for (var i = 0; i < tempLen; i++){
						idArray[i] = parseInt(
							idArray[i].substring(idArray[i].indexOf("=")+1, idArray[i].length)
						);
					}
					
					var idList = idArray.join(",");
	
					modData.recordList = idList;
					var modJson = encodeURIComponent(JSON.stringify(modData));
					
					ajaxPost(
						sortAjax,
						window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].apiPath,
						"modData=" + modJson,
						false,
						null,
						null,
						false
					);
				}
				catch(e){
					alert(e);
				}
			}}
		);
	}
}
<?php
	}
?>
//call the 'constructor' for this module
if(typeof window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].construct !== "undefined"){
	window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].construct();
}

setGalleryFancyBox();