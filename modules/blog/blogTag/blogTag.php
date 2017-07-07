function setBlogTagAddEdit(){
	
    blogTagAddEditObj = new stealthInputCommon();
    blogTagAddEditObj.apiPath = "/cmsAPI/blog/blogTag.php";
    blogTagAddEditObj.moduleAlert = "Blog Tag";
    
    blogTagAddEditObj.mappingArray = new Array();
    blogTagAddEditObj.mappingArray[0] = new Array();
    blogTagAddEditObj.mappingArray[0]["priKeyName"] = "blogTagID";
    blogTagAddEditObj.mappingArray[0]["fieldName"] = "blogID";
    blogTagAddEditObj.mappingArray[0]["apiPath"] = "/cmsAPI/blog/blogTagMap.php";
    
    blogTagAddEditObj.setQforms = function(){
        moduleFormObj = new qForm("moduleForm");
        moduleFormObj.required("tagText");
        moduleFormObj.tagText.description = "Blog Tag";		
    }
    blogTagAddEditObj.setQforms();
}