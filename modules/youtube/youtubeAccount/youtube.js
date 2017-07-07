function uploadVid(){
	delete window["moduleFormObj"];
	moduleFormObj = new qForm("uploadForm");
	moduleFormObj.required("videoTitle,videoDesc");
	moduleFormObj.videoTitle.description = "Video Title";
	moduleFormObj.videoDesc.description = "Video Description";
	moduleFormObj.vidCat.description = "Category";
	moduleFormObj.tagWords.description = "Tag Keywords";
	
	moduleFormObj.videoTitle.validateAlphaNumeric();
	moduleFormObj.videoDesc.validateAlphaNumeric();
	moduleFormObj.tagWords.validateNoSpace();
	
	var formCompleted = qFormAPI.validate("uploadForm");
	
	if(formCompleted){
		var vt = document.getElementById("videoTitle").value;
		var vd = document.getElementById("videoDesc").value;
		var vkw = document.getElementById("tagWords").value;
		var vc = document.getElementById("vidCat").value;
		
		/*kinda hacky... use the recordID field to pass these....*/
		var params = "&videoTitle=" + vt + "&videoDesc=" + vd + "&tagWords=" + vkw + "&vidCat=" + vc;
		moduleAdd('/modules/youtube/youtubeAccount/videoUpload.php',params,'','/modules/youtube/youtubeAccount/videoUpload.js','/modules/youtube/youtubeAccount/videoUpload.css','');
	}
}

function getAuthTok(){
	var authTokHTTP = ajaxObj();
	ajaxPost(authTokHTTP,"/cmsAPI/youtube/youtubeUser.php","function=getAuthTok",false,0);
	window.open(authTokHTTP.responseText,"Youtube_Token");
}

function getBlogAuthTok(){
	var authTokHTTP = ajaxObj();
	ajaxPost(authTokHTTP,"/cmsAPI/youtube/youtubeUser.php","function=getBlogAuth",false,0);
	window.open(authTokHTTP.responseText,"Youtube_Token");
}

function deleteVideo(vidID){
	var delVid = confirm("Are you sure you want to delete this video?");
	if(delVid){
		var delVidHTTP = ajaxObj();
		ajaxPost(delVidHTTP,"/cmsAPI/youtube/youtubeVideos.php","function=delVid&vidID=" + vidID,false,0);
		buildHtml.removeElement("youtubeInfo" + vidID);
	}
}