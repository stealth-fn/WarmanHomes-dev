blogSideBarObj.prototype.showMonths = function(el) {
	$('.months').hide(); 
    $(el).next().show();
};

blogSideBarObj.prototype.srchCat = function(el,page,pmpmID) {
	var selectObj = el;
	var val = selectObj.options[selectObj.selectedIndex].value;
	if (val=="0"){
		upc(page);
	}
	else  {
		var tempPmpm = "pmpm={\'" + pmpmID + "\':{\'overrideRequests\':\'false\',\'blogCategoryID\':\'" + val + "\'}}"; 
		upc(page,tempPmpm);	
	}
};