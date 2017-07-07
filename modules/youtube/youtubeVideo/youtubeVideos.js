var apiPath = "/cmsAPI/youtube/youtubeVideos.php";
var moduleAlert = "YouTube Video";

function setQforms(){	
	moduleFormObj = new qForm("moduleForm");
	moduleFormObj.required("videoDesc,youtubeVidID");
	moduleFormObj.videoDesc.description = "Video Description";
	moduleFormObj.youtubeVidID.description = "YouTube Video ID";
}