function getFAQCat(catID){
	var faqAjax = ajaxObj();	
	ajaxPost(faqAjax,"/cmsAPI/faq/faqCatMap.php","function=getCatFaqs&catID=" + catID,false,0);
	document.getElementById("faqContainer").innerHTML = faqAjax.responseText;
}