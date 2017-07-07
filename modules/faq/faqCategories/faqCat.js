var apiPath = "/cmsAPI/faq/faqCategories.php";
var moduleAlert = "FAQ Category";

function setQforms(){
	moduleFormObj = new qForm("moduleForm");
	moduleFormObj.required("faqCategory");
	moduleFormObj.faqCategory.description = "FAQ Category";	
}