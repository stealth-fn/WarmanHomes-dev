function changeSiteLng(siteLgn){

	//we use a drop down on the admin side
	var siteLng = $('#siteLng').val() || siteLgn;	
  
	//remove the leading 
	var urlParams = window.location.search.substring(1,window.location.search.length)

	//put our url parameters into an array
	var paramsArray = urlParams.split("&");
	paramsArray.push("lng=" + siteLng)
	
	//loop through the array to filter out dupilcates
	var arrayLen = paramsArray.length;	
	var paramsObj = {};	
	for(var i = 0; arrayLen > i; i++){
		var tempArray = paramsArray[i].split("=");		
		paramsObj[tempArray[0]] = tempArray[1];
	}
	
	//turn array back into query string
	var str = $.param(paramsObj);

	//go to new URL
	document.location = document.URL + "?" + str;

	return true;
}
