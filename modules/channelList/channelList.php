var apiPath = "/cmsAPI/channelList/channelList.php";
var moduleAlert = "Channel";

function setQforms(){
	moduleFormObj = new qForm("moduleForm");
	moduleFormObj.required("channelName,population,primaryChannel");
	moduleFormObj.channelName.description = "Channel Name";
	moduleFormObj.population.description = "Channel Population";
    moduleFormObj.population.validateNumeric();
	moduleFormObj.primaryChannel.description = "Primary Channel";
}
