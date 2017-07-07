function setFaqAddEdit(){
	faqAddEditObj = new stealthInputCommon();
	faqAddEditObj.apiPath = "/cmsAPI/faq/faq.php";
	faqAddEditObj.moduleAlert = "FAQ";
	faqAddEditObj.mappingArray = new Array();
	faqAddEditObj.mappingArray[0] = new Array();
	faqAddEditObj.mappingArray[0]["priKeyName"] = "faqID";
	faqAddEditObj.mappingArray[0]["fieldName"] = "faqCategoryID";
	faqAddEditObj.mappingArray[0]["apiPath"] = "/cmsAPI/faq/faqCatMap.php";
	faqAddEditObj.setQforms = function(){
		moduleFormObj = new qForm("moduleForm");
		moduleFormObj.required("faqQuestion,faqAnswer");
		moduleFormObj.faqQuestion.description = "Question";
		moduleFormObj.faqAnswer.description = "Answer";	
	}
	faqAddEditObj.setQforms();
}