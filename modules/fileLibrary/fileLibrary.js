function setFileLibraryAddEdit(){
	fileLibraryAddEditObj = new stealthInputCommon();
	
	//module properties
	fileLibraryAddEditObj.apiPath = "/cmsAPI/fileLibrary/fileLibrary.php";
	fileLibraryAddEditObj.moduleAlert = "File";
	fileLibraryAddEditObj.frmCheck = "";
	fileLibraryAddEditObj.disMsg = false; //we display upload completed message, don't need default
	
	fileLibraryAddEditObj.addEditFile = function(formBtn){
		var fileCheckName = $("#moduleForm")[0].fileName.value;
		
		fileLibraryAddEditObj.addEditModule(formBtn);
	}
	if($s("priKeyID").value == 0){	
		fileLibraryAddEditObj.nextFunction = function(){
		
			//overwrite current funtion so it only updates next time
			fileLibraryAddEditObj.nextFunction = function(){
				fileLibraryAddEditObj.disMsg = true;
				$s("uploadMessage").style.display = $s("ajaxFileGif").style.display = "none";
			}
			
			$s("uploadMessage").style.display = $s("ajaxFileGif").style.display = "block";
		
			//upload the file, we only do this when they create a new image
			var ifrmObj = $("#upload_target").contents()[0].body;
			if(ifrmObj && ifrmObj.innerHTML.length === 0){
				$("#moduleForm").submit();
			
				//checks the innerHTML of our iframe to see if the server has 
				//written to it to let us know it has the file
				frmCheck = setInterval("fileLibraryAddEditObj.uploadCheck()",100);
			}
			
			var fileID = $s("priKeyID").value;
			var userIDs = "";
			$('[name=userID]').filter(":checked").each(function(){
				userIDs += $(this).val() + ",";
			});
			//create the gallery dir tree on the server
			var userMapObj = ajaxObj();
			userMapObj.onreadystatechange=function(){
				if(userMapObj.readyState==4){
					return true;
				}
			}
			ajaxPost(
				userMapObj,
				"/cmsAPI/fileLibrary/fileLibrary.php",
				"function=mapPublicUsers&fileID=" + fileID + "&userID=" + userIDs.substr(0,userIDs.length - 1),
				true,
				1,null,false
			);
		}
	}
	else{
		//editing an file, nothing to upload
		fileLibraryAddEditObj.nextFunction = function(){
			var fileID = $s("priKeyID").value;
			var userIDs = "";
			$('[name=userID]').filter(":checked").each(function(){
				userIDs += $(this).val() + ",";
			});

			var userMapObj = ajaxObj();
			userMapObj.onreadystatechange=function(){
				if(userMapObj.readyState==4){
					return true;
				}
			}
			ajaxPost(
				userMapObj,
				"/cmsAPI/fileLibrary/fileLibrary.php",
				"function=mapPublicUsers&fileID=" + fileID + "&userID=" + userIDs.substr(0,userIDs.length - 1),
				true,
				1,null,false
			);
		
			fileLibraryAddEditObj.disMsg = true;
			$s("uploadMessage").style.display = $s("ajaxFileGif").style.display = "none";
		}
	}
	
	fileLibraryAddEditObj.uploadCheck = function(){
		var ifrmObj = $("#upload_target").contents()[0].body;

		//if the file uploaded successfully
		if(ifrmObj && ifrmObj.innerHTML.length > 0 && ifrmObj.innerHTML === "1"){
			clearInterval(frmCheck);
			$s("ajaxFileGif").style.display = "none";
			$s("uploadMessage").style.display = "none";
			alert("The file has been uploaded successfully");
			
			//set to true incase they edit image right after adding
			fileLibraryAddEditObj.disMsg = true;
			
			$s("fileName").disabled = true;
			fileLibraryAddEditObj.disMsg = true; //needs to be true for editing
		}
		else if(ifrmObj && ifrmObj.innerHTML.length > 0 && ifrmObj.innerHTML !== "1"){
			clearInterval(frmCheck);
			$s("ajaxFileGif").style.display = "none";
			$s("uploadMessage").style.display = "none";
			alert("Error 2: " + ifrmObj.innerHTML);
			ajaxPost(
				ajaxObj(),
				"/cmsAPI/fileLibrary/fileLibrary.php",
				"function=removeRecordByID&recordID=" + document.getElementById("priKeyID").value
			);
		}
	}
}	


//remove the image file from the server
function afterModuleDel(priKeyID){
	
	alert('We are here!');
	//remove mapped user entries
	var userMapObj = ajaxObj();
	ajaxPost(
		userMapObj,
		"/cmsAPI/fileLibrary/fileLibrary.php",
		"function=mapPublicUsers&fileID=" + priKeyID,
		true,
		1,null,false
	);
	
	alert('We are here!: ' + userMapObj);

	return true;
}