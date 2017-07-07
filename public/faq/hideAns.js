function toggleFAQChild(faqID){
	var faqAns = document.getElementById("faqAnswer" + faqID);
	
	/*note... we can't use getElementsByName here cause it won't work on IE DOM created elements & it's not w3 valid to have names on div's*/
	var allAns = document.getElementsByClassName("faqAns");

	/*loop through and close previously opened answers*/
	for(i=0;i<allAns.length;i++){
		/*if it isn't the one we want open, and its currently open, close it*/
		if(allAns[i].id != "faqAnswer" + faqID && document.getElementById(allAns[i].id).style.display != "none"){
			Effect.BlindUp(allAns[i].id,{ duration: 0.5});
		}
	}
	
	/*toggle if its opened or closed*/
	if(faqAns.style.display == "none"){
		Effect.BlindDown("faqAnswer" + faqID,{ duration: 0.5});
	}
	else{
		Effect.BlindUp("faqAnswer" + faqID,{ duration: 0.5});
	}
}

function getFAQCat(catID){
	var faqAjax = ajaxObj();	
	ajaxPost(faqAjax,"/cmsAPI/faq/faqCatMap.php","function=getCatFaqs&catID=" + catID,false,0);
	document.getElementById("faqContainer").innerHTML = faqAjax.responseText;
}