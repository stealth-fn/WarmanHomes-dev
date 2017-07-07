//function to run after the addEdit
galleryAddEditObj.prototype.nextFunction = function(){

	var galID = $("#" + this.formID + " input[name='priKeyID']").val();

	//create the gallery dir tree on the server
	var galleryAjax = ajaxObj();	
	
	//create new folder structture
	if(this.addEdit == 0){
		var requestItemParams = "function=createGalDirTree&galID=" + galID
		
		//make our js object a property of the ajax object to use when the request is complete
		galleryAjax.galObj = this;

		galleryAjax.onreadystatechange=function(){
			if(galleryAjax.readyState==4){
				//let the user add images
				$("#" + galleryAjax.galObj.formID + " input[name='addImg']").prop('disabled', false); 
				return true;
			}
		}	
		ajaxPost(galleryAjax,this.apiPath,requestItemParams,true,true,null,false);
	}
	//we need to resize all the images incase they changed the dimensions
	else{
		var requestItemParams = "function=updateImgSize&galID=" + galID;
		ajaxPost(
			galleryAjax,
			"/cmsAPI/gallery/galleryImages.php",requestItemParams,true,true,null,false
		);
		return true;
	}
}

//let the users start adding images right after they create the gallery
galleryAddEditObj.prototype.addImage = function(){
	atpto_adminTopNav.toggleBlind(
		'<?php echo $priModObj[0]->imageListPageID; ?>',
		true,
		'upc(<?php echo $priModObj[0]->imageListPageID; ?>,"parentPriKeyID=' + this.priKeyID + '");',
		'ntid_adminTopNav<?php echo $priModObj[0]->imageListPageID; ?>',""
	);
}
		
//remove the gallery folder/images from server and db
galleryAddEditObj.prototype.afterModuleDel = function(priKeyID){
    alert('We are here!');
	
	var moduleHttp = ajaxObj();
	ajaxPost(
		moduleHttp,
		"/cmsAPI/gallery/gallery.php",
		"function=removeGal&priKeyID=" + priKeyID,
		true,true,null,false
	);	
}
