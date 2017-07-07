function getCalendar(mon,yr){
	
	var calAjax = ajaxObj();
	calAjax.onreadystatechange=function(){
		if(calAjax.readyState==4){
			buildHtml.removeElement("calendarContainer");
			document.getElementById("pageCopy").innerHTML = document.getElementById("pageCopy").innerHTML + calAjax.responseText;
		}
	}
	
	if ( typeof(mon) == "undefined" || mon == null ) {
		var requestParams = ''; 
	}
	else{
		var requestParams = "month=" + mon + "&year=" + yr;
	}
	
	ajaxPost(calAjax,"/public/calendarEvents/calendarSmall/calendarEvents.php",requestParams);
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}