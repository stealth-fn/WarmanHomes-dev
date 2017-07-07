//create jquery date picker
$(".meetingDate").datepicker({ dateFormat: 'yy-mm-dd'}); 

//the interval to keep check if the file is uploaded
fileLibraryAddEditObj.prototype.frmCheck = "";

//the file name of the previously uploaded file, to see if we should
//upload the file again, or just modify the text cotnent
fileLibraryAddEditObj.prototype.prevFileName = "";

//don't pass the image name to the server from the form with our regular addEditMod function
fileLibraryAddEditObj.prototype.ignoreFields = "fileName";

//keep track if we've updated the file name based off another domain/language record
fileLibraryAddEditObj.prototype.updatedFileName = false;

//add file size rule here because we set our file size parameter dynamically
//we have to call the function after the module loads and the validation is set
fileLibraryAddEditObj.prototype.construct = function(){

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
fileLibraryAddEditObj.prototype.nextFunction = function(){

	//this modules iframe, where we upload the image
	var tempiFrame = $("#" + this.modForm.id + " iframe[class='upload_target']").get(0);

	//only upload the file if they changed it
	if(
		this.prevFileName !== this.modForm.fileName.value && 
		this.modForm.fileName.value.length > 0
	){		
		//change the form properties so we can upload our images
		$s(this.modForm.id).encoding = 'multipart/form-data';
		$s(this.modForm.id).action = '/modules/fileLibrary/uploadFile.php';
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
			var requestParams = 'function=updateRecord&a={ "fileName":"' + $("#" + this.modForm.id + " .innerCurrentFile").get(0).innerHTML + '","priKeyID":"' + this.priKeyID + '"}';
			ajaxPost(updateAjax,this.apiPath,requestParams,false,1,null,false);
			
			this.updatedFileName = true;
		}
		
		//mark this update as complete
		tempiFrame.innerHTML = "1";
		//if all the image file updates are completed or not bulk add/edit
		if(this.requestCheck() || !this.blkEdit) {
			alert("File Library has been updated");
			
			//reset all the iframe values
			this.resetiFrames();
		}
	}
}

fileLibraryAddEditObj.prototype.uploadCheck = function(){
	var ifrmObj = $("#" + this.modForm.id + " iframe[class='upload_target']").contents()[0].body;

	//if the file uploaded successfully
	if(ifrmObj && ifrmObj.innerHTML.length > 0 && ifrmObj.innerHTML === "1"){
		
		//stop checking to see if the image uploaded correctly
		clearInterval(this.frmCheck);
		
		$("#" + this.modForm.id + " .uploadMessage").toggle();

		//all the image file updates are completed
		if(this.requestCheck()) {
			alert("File " + $("#" + this.modForm.id + " input[name='fileDesc']").eq(0).val() + " has been uploaded successfully");
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
			"/cmsAPI/fileLibrary/fileLibrary.php",
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
fileLibraryAddEditObj.prototype.requestCheck = function(){

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
fileLibraryAddEditObj.prototype.resetiFrames = function(){
	//loop through all the iframes
	$(".upload_target").each(function(){
		$(this).html("0");
	});
}

//remove the image file from the server
fileLibraryAddEditObj.prototype.afterModuleDel = function(priKeyID){
	var moduleHttp = ajaxObj();
	ajaxPost(
		moduleHttp,
		"/cmsAPI/fileLibrary/fileLibrary.php",
		"function=removeFile&priKeyID=" + priKeyID
	);	
}
/**************************************************************/