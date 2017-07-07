/************************************************************/
//the interval to keep check if the file is uploaded
importAddEditObj.prototype.frmCheck = "";

//the file name of the previously uploaded file, to see if we should
//upload the file again, or just modify the text cotnent
importAddEditObj.prototype.prevFileName = "";

//don't pass the file name to the server from the form with our regular addEditMod function
importAddEditObj.prototype.ignoreFields = "fileName";

//keep track if we've updated the file name based off another domain/language record
importAddEditObj.prototype.updatedFileName = false;

//add file size rule here because we set our file size parameter dynamically
//we have to call the function after the module loads and the validation is set
importAddEditObj.prototype.construct = function(){

	// it's an old record, we are updating
	if($("form[name=moduleForm] input[name=priKeyID]").val()) {
	
		// populate database fields drop downs
		var priID = $("form[name=moduleForm] input[name=priKeyID]").val();
		this.getModuleFields(document.getElementById('moduleID'+ priID));
		
		if($("form[name=moduleForm] input[name=csvFieldsName]").val()) {
			$('.mapRow').each(function(i, obj) {
				
				var tempOp = '<option value="'+ tempcsvFieldsLine[i] +'" title="'+ tempCsvFieldsName[i] +'">'+ tempCsvFieldsName[i] +'</option>';
				$(this).find('select').empty().append(tempOp);
			});
		}
	}

	//only require the file field on new files
	if(
		(
			//first record in bulk add/edit or regular record
			window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].priKeyID.length === 0 
			||
			//new records through the bulk add/edit
			(
				window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].priKeyID.length > 0 &&
				isNaN(window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].priKeyID)
			)
		)
		&&
		/*adding another domain/language record... it will  
		use previous file unless we upload a new one*/
		(
			getParameterByFromString("recordID",window.location.search).length === 0
		)
	) {
		$("#" + window["<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>"].formID + ' input[name="fileName"]').rules("add", {
			required: true
		});
	}

	//set initial iframe state, can't be done with HTML
	this.resetiFrames();	
}

//submit our form, which submits to an iframe, we can't upload 
//files with ajax, so we do this to make it feel ajaxy still
importAddEditObj.prototype.nextFunction = function(){

	//this modules iframe, where we upload the image
	var tempiFrame = $("#" + this.modForm.id + " iframe[class='upload_target']").get(0);

	//only upload the file if they changed it
	if(
		this.prevFileName !== this.modForm.fileName.value && 
		this.modForm.fileName.value.length > 0
	){		
		//change the form properties so we can upload our images
		$s(this.modForm.id).encoding = 'multipart/form-data';
		$s(this.modForm.id).action = '/modules/import/uploadFile.php';
		$s(this.modForm.id).target = tempiFrame.name;

		//upload the image through an iframe
		$s(this.modForm.id).submit();
		
		//display uploading message
		$("#" + this.modForm.id + " .uploadMessage").toggle();
		
		//disable so they can't multi-click
		$("input[name='moduleAddEditBtn']").attr("disabled", true);
		$("input[name='moduleAddEditDraftBtn']").attr("disabled", true);	
		//enable buttons, change cursor	
		$('html').css('cursor','wait');
		
		//file name has been established
		this.updatedFileName = true;
	
		//checks the innerHTML of our iframe to see if the server has 
		//written to it to let us know it has the image
		this.frmCheck = setInterval(
			this.objRef + ".uploadCheck()",
			100
		);
	}
	else {
		
		//using the file name from another language/domain
		if(!this.updatedFileName) {
			//update our file name in the database
			var updateAjax = ajaxObj();
			var requestParams = 'function=updateRecord';
			ajaxPost(updateAjax,this.apiPath,requestParams,false,1,null,false);
			
			this.updatedFileName = true;
		}
		
		//mark this update as complete
		tempiFrame.innerHTML = "1";
		//if all the image file updates are completed or not bulk add/edit
		if(this.requestCheck() || !this.blkEdit) {
			alert("Import file has been done.");
			
			//reset all the iframe values
			this.resetiFrames();
		}
	}
}

importAddEditObj.prototype.uploadCheck = function(){
	var ifrmObj = $("#" + this.modForm.id + " iframe[class='upload_target']").contents()[0].body;

	//if the file uploaded successfully
	if(ifrmObj && ifrmObj.innerHTML.length > 0 && ifrmObj.innerHTML === "1"){
	
		//stop checking to see if the image uploaded correctly
		clearInterval(this.frmCheck);
		
		$("#" + this.modForm.id + " .uploadMessage").toggle();

		//all the image file updates are completed
		if(this.requestCheck()) {
			alert("File " + $("#" + this.modForm.id + " input[name='fileName']").eq(0).val() + " has been uploaded successfully");
			this.resetiFrames();
		}

		//keep track of the file they just uploaded, we don't need to upload it multiple times
		this.prevFileName = this.modForm.fileName.value;
		
		//enable buttons
		this.addEditComplete();
	}
	//there was an error uploading the image
	else if(
		ifrmObj && ifrmObj.innerHTML.length > 0 && 
		//finished updating
		ifrmObj.innerHTML !== "0" &&
		//update error
		ifrmObj.innerHTML !== "1"
	){
		
		//stop checking to see if the image uploaded correctly
		clearInterval(this.frmCheck);
		
		$("#" + this.modForm.id + " .uploadMessage").toggle();

		alert("Error 2: " + ifrmObj.innerHTML);
				
		ajaxPost(
			ajaxObj(),
			"/cmsAPI/import/import.php",
			"function=removeLiveDraftByID&recordID=" + this.priKeyID,
			null,null,null,false
		);
		
		//enable buttons, change cursor
		this.addEditComplete();
		
		//all the image file updates are completed
		if(this.requestCheck()) {
			this.resetiFrames();
		}

	}	
}

//check if all the iframes are finished their requests
importAddEditObj.prototype.requestCheck = function(){

	var completed = false;

	//loop through all the iframes
	$(".upload_target").each(function(){
		//found one that isn't completed, return false
		if($(this).contents()[0].body.innerHTML == "0"){
			completed = false;
		}
		else{
			//all of them are completed
			completed = true;
		}
	});
	
	return completed;
}

//set iframes back to their default state
importAddEditObj.prototype.resetiFrames = function(){
	//loop through all the iframes
	$(".upload_target").each(function(){
		$(this).html("0");
	});
}
/**************************************************************/
var tempDropDownHTML = '';

var tempCsvFieldsName = $("form[name=moduleForm] input[name=csvFieldsName]").val().split(','); 

var tempcsvFieldsLine = $("form[name=moduleForm] input[name=csvFieldsLine]").val().split(','); 	

importAddEditObj.prototype.getModuleFields = function(thisSelect){

	$("input[id*=fileName]").rules("add", "required");
	
	var modulePath = thisSelect.options[thisSelect.selectedIndex].title;
	
	var priID = '';
	if($("form[name=moduleForm] input[name=priKeyID]").val()) {
		priID = $("form[name=moduleForm] input[name=priKeyID]").val();
	}
	
	var dataBaseFields = []; 
	
	if (modulePath != 0) {
		//setup ajax request
		var fieldsAjaxObj = ajaxObj();

		ajaxPost(
			fieldsAjaxObj,
			modulePath,
			"function=getTableFieldJSON",
			false,null,null,false
		);		

		//parse server response
		var dom = JSON.parse(fieldsAjaxObj.responseText);
		var i = 0;
		
		// check to see if we already have csv fields dropdown
		var optionsLen = $('#dbCol-priKeyID option').length;
		// all dropw downs are the same, so we just get the first one
		var dropDownDom = $('#dbCol-priKeyID').html();
		
		//clear out old table fields
		$("#tableFields" + priID).empty();
		
		// we don't have csv fields dropdown already
		if (!tempDropDownHTML) {
			//populate table fields as divs in a container
			for(var y in dom){
				
				dataBaseFields.push(y);
				
				//create DOM object with jquery
				$("#tableFields" + priID).append(
					'<div class="mapRow"><label class="dbColLb" for="dbCol' + i + '">' + y + '</label><select name="dbCol'+ '-' + y +'" class="dbCol" id="dbCol' + '-' + y + '"><option value="" title="">None</option></select></div>'
				);

				i = i+1;
			}
		}
		// we do have it
		else {			
			//populate table fields as divs in a container
			for(var y in dom){

				dataBaseFields.push(y);
				
				if (1 == $("form[name=moduleForm] input[name=updateMapSec]:checked").val()) {
					//create DOM object with jquery
					$("#tableFields" + priID).append(
						'<div class="mapRow"><label class="dbColLb" id="dbCol' + i + '">' + y + '</label><select name="dbCol'+ '-' + y +'" class="dbCol" id="dbCol' + '-' + y + '">'+ tempDropDownHTML +'</select></div>'
					);
				}
				else {
					$("#tableFields" + priID).append(
						'<div class="mapRow"><label class="dbColLb" id="dbCol' + i + '">' + y + '</label><select name="dbCol'+ '-' + y +'" class="dbCol" id="dbCol' + '-' + y + '">'+ '<option value="-1" title="None">None</option>' +'</select></div>'
					);
				}

				i = i+1;
			}
		}		
	}
	else {
		//clear out old table fields
		$("#tableFields" + priID).empty();
		$("input[id*=fileName]").rules("remove", "required");
	}
	
	$("form[name=moduleForm] input[name=dataBaseFields]").val(dataBaseFields.toString());
}

$('#fileName').change(function(e) {
		        
	var file = $("#fileName").prop("files")[0]; //get the file
	var csvFeildsString= "", csvColumns = []; 

	if (file.name.indexOf(".csv") < 0) {
	  alert("You can only select .csv files");
	  $("#fileName").val("");
	}
	else {
		if (e.target.files != undefined) {
			var reader = new FileReader();

			reader.onload = function(e) {
				// get the whole of the file
				var fileContent = e.target.result;

				// \n is line separator
				fileContent = fileContent.split('\n');

				// fileContent[0] is the field titles in csv file
				// remove double quotations from string
				csvFeildsString = fileContent[0].replace(/"+/g, '');
				csvColumns = csvFeildsString.split(',');

				tempDropDownHTML = '<option value="-1" title="None">None</option>';
				
				// loop through csvColumns array and make doms for csv fields dropdowns
				for (var j = 0; j < csvColumns.length; j++) {
					tempDropDownHTML = tempDropDownHTML + '<option value="'+ j +'" title="' + csvColumns[j] + '">'+ csvColumns[j] +'</option>';
				}
				
				window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].populateUpdatedDropDown();
			};

			reader.readAsText(e.target.files.item(0));
		}

		return false;
	}
});


importAddEditObj.prototype.populateUpdatedDropDown = function(){
	
	if($('.dbCol')[0]) {
		// populate new values
		if (1 == $("form[name=moduleForm] input[name=updateMapSec]:checked").val()) {
			$('.dbCol').empty();
			
			if (tempDropDownHTML) {
				$('.dbCol').append(tempDropDownHTML);
			}
			else {
				$('.dbCol').append('<option value="-1" title="None">None</option>');
			}
		}
		else {
			if ($("form[name=moduleForm] input[name=csvFieldsName]").val().split(',').length == $("form[name=moduleForm] input[name=dataBaseFields]").val().split(',').length) {
			
				$('.mapRow').each(function(i, obj) {
					var tempOp = '<option value="'+ tempcsvFieldsLine[i] +'" title="'+ tempCsvFieldsName[i] +'">'+ tempCsvFieldsName[i] +'</option>';
					$(this).find('select').empty().append(tempOp);
				});
				
			}
			else {
				$('.dbCol').empty();
				$('.dbCol').append('<option value="-1" title="None">None</option>');
			}
		}
	}
}

importAddEditObj.prototype.populateOldDropDown = function(){
	if($('.dbCol')[0]) {
		$('.dbCol').empty();
		$('.dbCol').append('<option value="-1" title="None">None</option>');
	}
}

importAddEditObj.prototype.preFunction = function(){
	
	var csvFieldsName = []; 
	var csvFieldsLine = []; 
	
	$('.mapRow').each(function() {	
		csvFieldsLine.push($(this).find('select').find(':selected').val());
		csvFieldsName.push($(this).find('select').find(':selected').text());
		
	});
	
	$("form[name=moduleForm] input[name=csvFieldsName]").val(csvFieldsName.toString());
	
	$("form[name=moduleForm] input[name=csvFieldsLine]").val(csvFieldsLine.toString());
	
	return true; 
}


$("form[name=moduleForm] input[name=updateMapSec]").change(
	function(){
		window['<?php echo $priModObj[0]->className . $_REQUEST["recordID"]; ?>'].populateUpdatedDropDown();
});