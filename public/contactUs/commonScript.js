//get a reference error in safair if we don't create this version global variable
var pageID, version; 

//has to be declared or we recieve and error in loadCKEditor()
var CKEDITOR_BASEPATH = '/ckeditor/';

//don't always want/need jquery collections
$s = function(id){return document.getElementById(id);} 
$$s = function(cName){if(document.getElementsByClassName) return document.getElementsByClassName(cName);}
$$$s = function(eName){return document.getElementsByName(eName);}

//Return an SHA256 digest of a string object
String.prototype.sha256 = function(){
	return sha256_digest(this.salt+this);
}

//http://coveroverflow.com/a/11381730/989439
function mobCheck() {
	var check = false;
	(function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
}
var isMobile = mobCheck();

$.validator.setDefaults({//set defaults on jquery form validation
	onkeyup:false, onclick:false,	onfocusout:false, //only check when we 'submit' form	 
	focusCleanup: false, //Don't remove classes when we select a field
	focusInvalid: true, //Autofocus on first invalid field
	errorClass: "invalid", //invalid css class
	validClass: "valid", // valid css class
	errorPlacement: function(){},
	ignoreTitle:true,
	highlight: function(element, errorClass, validClass) { // Add error classes for styling
       $(element).addClass(errorClass).removeClass(validClass);
	   
	   var tempLabel = $(element.form).find("label[for='" + $(element).attr('name') + "']");
       if(tempLabel && tempLabel.length > 0) {
		   tempLabel.addClass(errorClass + "Label");
	   }
    },
    unhighlight: function(element, errorClass, validClass) { // Remove error classes
			   
		var tempLabel = $(element.form).find("label[for='" + $(element).attr('name') + "']");
		if(tempLabel && tempLabel.length > 0) {
			tempLabel.removeClass(errorClass + "Label");
		}
       $(element).removeClass(errorClass).addClass(validClass);
	},
	showErrors: function(errorMap, errorList) { //display error messages in a modal dialog
		var formErrMsg = "\n\t\t<span class='modalErrorMsg'>There were errors with your form. Please make sure you have filled in all required fields with the proper info.</span>\n\t\t<span class='modalErrorMsg'>Click anywhere to hide this message</span>\n\t\t<div>\n\t\t\t<ul>";
		var formErrs = "";
		$.each(errorMap,function(index,value) {
			
			//get the ID of the element
			var tempID = $$$s(index)[0].id;

			//error field description comes from label
			if(
				typeof tempID !== "undefined" && tempID.length > 0 &&
				$("label[for='"+tempID+"']") && $("label[for='"+tempID+"']").length > 0
			){
				var field = $("label[for='"+tempID+"']").html();
			}
			//error field description comes from title
			else if($("[name='" + index + "']").attr("title")){
				var field =$("[name='" + index + "']").attr("title");
			}
			//error field description comes from input name
			else{
				
				var tempName = $("[name='"+index+"']").attr("name");
				if(tempName){
					var field = $("[name='"+index+"']").attr("name").split(" ")[0];
				}
				else{
					var field = "";
				}
			}

			formErrs += "\n\t\t\t\t<li><span>" + field + "</span>" + value + "</li>";
	});
		formErrMsg += formErrs + "\n\t\t\t</ul>\n\t\t</div>";
		if(formErrs.length){ //If we have errors!
			buildModal("formError-"+this.currentForm.id,formErrMsg,null,true,true,1,null,null,440) //Display a modal dialog
		}
		this.defaultShowErrors(); //Apply the label classes, etc.
	},
	messages:{
	    required: "This field is required.",
	    remote: "Please fix this field.",
	    email: "Please enter a valid email address.",
	    url: "Please enter a valid URL.",
	    phoneUS: "Please enter a valid phone number.",
	    date: "Please enter a valid date.",
	    dateISO: "Please enter a valid date (ISO).",
	    number: "Please enter a valid number.",
	    digits: "Please enter only digits.",
	    creditcard: "Please enter a valid credit card number.",
	    equalTo: "Please enter the same value again.",
	    accept: "Please enter a value with a valid extension.",
	    maxlength: $.validator.format("Please enter no more than {0} characters."),
	    minlength: $.validator.format("Please enter at least {0} characters."),
	    rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
	    range: $.validator.format("Please enter a value between {0} and {1}."),
	    max: $.validator.format("Please enter a value less than or equal to {0}."),
	    min: $.validator.format("Please enter a value greater than or equal to {0}.")
	},
	ignore: []
});

//valid time
$.validator.addMethod(
	"time", 
	function(value, element) {  
	    return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?([\s]?[AaPp][Mm])?$/i.test(value);  
    }, 
    "Please enter a time in the format HH:MM. AM/PM is optional."
);

//doesn't accept field defaults as valid input
$.validator.addMethod("defaultInvalid", function(value, element) {
    return !(element.value == element.defaultValue);
},
    "This field is required."
);

/* Function: buildModal
/	 Purpose: displays a modal dialog
/		id: id for the dialog (for styling!)
/		inner: the content to be displayed
/		parent: the parent element to display it over
/		fullScreen: whether or not it should take up the full browser window
/		fixed: positioning, false = absolute, useful for when displaying over a smaller element and requires regular flow, true = fixed, useful for overlaying entire page
/		closeType: how it closes, 0 = timed, 1 = click anywhere, 2 = close modal button, string = button ID
/		closeTime: for closeType = 0, defines length of time before it closes
/		boxHeight: height of inner box
/		boxWidth: width of inner box
/		modClass: additional classes
*/
function buildModal(
	id,inner,parent,fullScreen,fixed,closeType,closeTime,boxHeight,boxWidth,event,modalClass
){
	//default close type
	if(closeType !== 0 && closeType !== 1 && closeType.length === 0) closeType = 0;  
	// default close time
	closeTime = closeTime || 3000; 
	parent = parent || document.body;
	modalClass = modalClass || "";
	cls = (id.indexOf("formError") != -1) ? "formError " + id : "common"; 
	var modal = $("<div class='modal modal-" + cls + " " + modalClass + "'  id='" + id + "'></div>").append(
		$("<div class='modalInner'></div>").append($(inner))
	);
	$(parent).append(modal); //Append our modal dialog to our parent
	var wid = (fullScreen) ? $(window).width() : $(parent).outerWidth();
	var heig = (fullScreen) ? $(window).height() : $(parent).outerHeight();
	var pos = fixed ? "fixed" : "absolute";
	
		$("#"+ id).css({ //Position and size our modal overlay
			display: 'none',
			height: heig + 'px',
			left: '0px',
			position: pos,
			top: '0px',
			width: wid + 'px',
			zIndex: '9999'
		}).fadeIn();
		
		// Set the max height of the inner container
		var inHeight = boxHeight || ((fullScreen) ? $(window).height() * (2 / 3) :  $(parent).outerHeight() * (2 / 3)); 
		var inWidth = boxWidth || ((fullScreen) ? $(window).width() * (2 / 3) :  $(parent).outerWidth() * (2 / 3));
		
		$("#"+ id + " .modalInner").css({ //Set up the position and size styling for the modal box, the rest can be styled in our standardStyles
			height: 'auto',
			maxHeight: inHeight + "px",
			left: '0px',
			overflow: 'hidden',
			paddingBottom: '40px', // Take into account our error list size
			position: 'fixed',
			left: (($("#" + id).width() - inWidth) / 2) + 'px',
			top: (($("#" + id).height() - inHeight)  / 2) + 'px',
			width:  inWidth + 'px'
		});
		
		inHeight = (boxHeight == null) ? $("#" + id + " .modalInner").outerHeight() : inHeight;  
		//Animate show the box!
		$("#" + id + "  .modalInner").css({height:'0px'}).animate({height:inHeight+"px"},500); 

		if(!isNaN(closeType)){ //Set up our close listeners
			if(!closeType){ //Timed
				window.setTimeout(  
				    function() {  
				        $("#" + id).fadeOut().remove(); 
				    },  
				    closeTime  
				);
			}
			//default modal cose button
			else if(closeType===2){
				//create the button
				$(".modalInner").append(
					$('<div class="modalClose">X</div>')
				);
				//js to remove the modal
				$(".modalClose").on("click",function(){
					$(this).parent().parent().fadeOut().remove();
				});
			}
			else{ //Click anywhere
				$("#" + id).on("click",function(){
					$(this).fadeOut().remove();
				});
			}
		}
		else{ //Defined element
			$(closeType).on("click",function(){
					$("#" + id).fadeOut().remove();
			}).children().click(function(e){e.stopPropagation();});
		}
		
		if(event){
			event.cancelBubble = true; //prevent event bubbling
			if(event.stopPropagation) event.stopPropagation();
		}
}

//Check if variable is defined and not null
function isset(v){ 
	//they can pass in the name of a global
	if("string" === typeof v) {
		v = window[v];
	}
	return ("undefined" !== typeof v && null !== v);
}

function emptystring(s){
	return (!isset(s) || s.length == 0);
}

function repSubstr(input, from, to) {// Replace from with to in input
   return input.split(from).join(to);
}

//converts a 12 hour time string to a 24 hour time string that is mysql compatible
function timeConvertMysql(timeVal){
	var timeAry = timeVal.split(":");
	var timeHrs = timeAry[0];
	var timeStr = false;
	
	if(timeVal.match(/am/i)) timeStr = timeHrs + ":" + timeAry[1].slice(0,timeAry[1].indexOf(" ",0)) + ":00";
	else if(timeVal.match(/pm/i)){
		timeHrs = parseInt(timeHrs) + 12;
		timeStr = timeHrs + ":" + timeAry[1].slice(0,timeAry[1].indexOf(" ",0)) + ":00";
	}
	return timeStr;
}

function isNumeric(n){
	return !isNaN(parseInt(n,10));
}

//is added for the forms with multiple checkboxes, we require to send all of checkboxe values to client's email
function sendFormValues(formObj,formPriKeyID,activeRecaptcha){
	
	//close any existing open modal messages
	$(".modal-formError").fadeOut().remove();
	
	var formAjax = ajaxObj();//check to see if our form has valid data
	var formCompleted = formObj.validate().form();
	
	if(formCompleted){
		
		if (activeRecaptcha === 1) {
			var response = grecaptcha.getResponse();
			
			if(response.length == 0){
				var formMsg = "<span class='modalValidMsg'>Please verify that you are not a robot.</span>";
				buildModal("formSuccess",formMsg,null,true,true,1,null,null,440); //Display a modal dialog
				activeRecaptcha = 3;
			}
			else {
				activeRecaptcha = 2;
			}
		}
		if (activeRecaptcha !== 3) {
			var paramString = "";
			paramString = formObj.serialize();
			var paramArray = paramString.split("&");

			var params = [];
			var tempA = [];
			for( var i = 0; i <= paramArray.length - 1; i++){
				var paramArr = paramArray[i].split("=");

				if ($.inArray(paramArr[0], tempA)!==-1) {
					params[$.inArray(paramArr[0], tempA)] = params[$.inArray(paramArr[0], tempA)] + "," + paramArr[1];				
				}
				else {
					tempA.push(paramArr[0]);
					//if there is a tite on the input field, use that
					if($("[name='"+paramArr[0]+"']").attr("title")){
						param = encodeURI($("[name='"+paramArr[0]+"']").attr("title"));
					}
					else{
						/*not sure what this was for, but since we serialisze the form anyways i don't know if its needed
						param = paramArr[0].replace(/([A-Z])/g, ' $1').replace(/^./, function(str){ return str.toUpperCase(); });*/
						param = paramArr[0];
					}

					params.push(param + "=" + paramArr[1]);

				}

			}

			//extra parameter so we know we're sending the form value from this script
			//should prevent blank forms from being sent
			params.push("scriptSend=1");
			params.push("formPriKeyID=" + formPriKeyID);

			paramString = params.join("&");

			formAjax.formObj = formObj;
			formAjax.onreadystatechange=function(){
				if(formAjax.readyState===4){
					var formSubmittedMsg = "<span class='modalValidMsg'>Your information has been submitted!<br /><span class='smaller'>Click anywhere to hide this message.</span></span>";
					buildModal("formSuccess",formSubmittedMsg,null,true,true,1,null,null,440); //Display a modal dialog
					formObj[0].reset();
					if (activeRecaptcha === 2) {
						grecaptcha.reset();
					}
					return true;
				}
			};

			/*in the future maybe we can expand on this 
			and see how many people drop out of forms?*/
			gaTrack(
				"event", 
				{
					"eventCategory":"Form",
					"eventAction":"Form Submitted",
					"eventLabel":"Page - " + pageArray[pageID].name
				}
			);

			ajaxPost(formAjax,"/public/sendForm.php" ,paramString,true,1,null,false);

			return false;
		}
	}
}

function sendBeansteamValues(formObj){
	
	//close any existing open modal messages
	$(".modal-formError").fadeOut().remove();
	
	var formAjax = ajaxObj();//check to see if our form has valid data
	var formCompleted = formObj.validate().form();
	
	if(formCompleted){
		var paramString = "";
		paramString = formObj.serialize();
		var paramArray = paramString.split("&");
		
		var params = [];
		var tempA = [];
		for( var i = 0; i <= paramArray.length - 1; i++){
			var paramArr = paramArray[i].split("=");

			if ($.inArray(paramArr[0], tempA)!==-1) {
				params[$.inArray(paramArr[0], tempA)] = params[$.inArray(paramArr[0], tempA)] + "," + paramArr[1];				
			}
			else {
				tempA.push(paramArr[0]);
				
				param = paramArr[0];
								
				params.push(param + "=" + paramArr[1]);
				
			}
			
		}
		
		//extra parameter so we know we're sending the form value from this script
		//should prevent blank forms from being sent
		params.push("scriptSend=1");
	
		paramString = params.join("&");
		
		/*in the future maybe we can expand on this 
		and see how many people drop out of forms?*/
		gaTrack(
			"event", 
			{
				"eventCategory":"Form",
				"eventAction":"Form Submitted",
				"eventLabel":"Page - " + pageArray[pageID].name
			}
		);
		
		ajaxPost(formAjax,"/public/beansteamSendForm.php",paramString,true,1,null,false);
		
		formAjax.formObj = formObj;
		formAjax.onreadystatechange=function(){
			if(formAjax.readyState===4){
				var formSubmittedMsg = "<span class='modalValidMsg'>"+ formAjax.responseText +"<br /><span class='smaller'>Click anywhere to hide this message.</span></span>";
				buildModal("formSuccess",formSubmittedMsg,null,true,true,1,null,null,440) //Display a modal dialog
				var response = formAjax.responseText.substring(0, 8);
				
				if(response == 'Approved') {
					formObj[0].reset();
					printDiv(paramString);
				}
				return true;
			}
		};
		
		return false;
	}	
}

function ajaxObj(){//ajaxObj
	var xmlhttp = false;
	try {
		xmlhttp = new XMLHttpRequest();
	}
	catch (e) {
		alert("Your browser does not support AJAX");
	}
	return xmlhttp;
}

function ajaxPost(ajaxObject,location,params,async,getPost,contentType,historyTrack,justTrackHist){
	async=isset(async)? async: true;
	getPost=isset(getPost)? getPost: true;
	contentType=isset(contentType)? contentType: "application/x-www-form-urlencoded";
	historyTrack=isset(historyTrack)? historyTrack:true;
	justTrackHist = justTrackHist || false; //used for single page sites
	historyBool=isset(window["historyBool"])? window["historyBool"]:true;
	var urlParams = "";
	//URL parameters without the function or pageID
	var cleanParams;

	try{
		//historyBool is global var that is set in headScripts.php
		if(historyTrack && historyBool){
			//setup ajax bookmark and browser navigation
			var preCaller = "";
			var callerFunction = arguments.callee.caller;	
			var callerFunctionArgs = callerFunction.arguments;			
			var argCnt = callerFunctionArgs.length;
						
			var tempBreak = false;
			var breakEarly = false;
	
			while(!tempBreak){
				//look for histroyBreak argument
				checkArgs = callerFunction.arguments;
				checkArgsCnt = callerFunctionArgs.length;	
				
				//if we have a historyBreak argument we don't go through all the callee functions				
				for(var i = 0; i < checkArgsCnt; i++){

					if(
						typeof checkArgs[i] === "string" &&
						checkArgs[i] === "historyBreak"
					){
			
						callerFunctionArgs = callerFunction.arguments;
						argCnt = callerFunctionArgs.length;
						//callerFunction = preCaller;
						tempBreak = true;
						breakEarly = true;
					}

				}
				
				//keep looping through until we need to the root function. usually an event
				if(!tempBreak){
					var tempCaller = getParentFunctionCall(callerFunction)
					
					if(tempCaller){	
						preCaller = callerFunction;
						callerFunctionArgs = callerFunction.arguments;
						argCnt = callerFunctionArgs.length;			
						callerFunction = tempCaller;
						
					}
					else{
						tempBreak = true;
					}
				}

			}
			
			var callerFunStr = callerFunction.toString();
			var historyFunParams = "";
			
			//break out early. parse out the function name
			if(breakEarly){			
				var tempFunName = callerFunStr.substr(callerFunStr.indexOf("function",0)+9);
				var historyFunName = tempFunName.substr(0,tempFunName.indexOf("(",0));			
			}
			//not breaking out early, parse from event that called it
			else{
				var tempFunName = callerFunStr.substr(callerFunStr.indexOf("{",0)+1);
				var historyFunName = tempFunName.substr(0,tempFunName.indexOf("(",0));
			}

			for(var i = 0; i < argCnt; i++){
				if(historyFunParams.length === 0) historyFunParams = "'" + callerFunctionArgs[i] + "'";
				else historyFunParams = historyFunParams + "," + "'" + callerFunctionArgs[i] + "'";	
			}
			
			//changes URL for bookmarks, and contains page content for foward\back-buttons
			//we don't want the function param or pageID in our URL
			if(params.length > 0 ){
				var regexFunc = new RegExp("[\&]?(function=[a-zA-Z_%]*)");
				var regexPageID = new RegExp("[\&]?(pageID=[\-]?[0-9]*)");
				cleanParams = params.replace(regexFunc,"");
				cleanParams = cleanParams.replace(regexPageID,"");
				cleanParams = cleanParams.replace(/^\&/,"");
				cleanParams = encodeURIComponent(cleanParams);
				
				if(cleanParams.length > 0){
					urlParams = "/" + seoFolderName + "/" + pageArray[pageID].name + "?" + cleanParams;
				}
				else{
					urlParams = "/" + seoFolderName + "/" + pageArray[pageID].name;
				}
			}
		
			historyBool = false;
			historySet = {
				ajaxRunFunction: historyFunName + "(" + historyFunParams + ")", 
				hisUrlParams: urlParams
			};

			//only push if we're doing an ajax call different than the previous one
			if(
				historySet.ajaxRunFunction != History.getState().data.ajaxRunFunction
			) {
				
				//google analtyics
				gaTrack(
					'pageView',
					{
						"page":urlParams, 
						"title":pageArray[pageID].pageTitle
					}
				);
		
				History.pushState(historySet,"",urlParams);
			}
			else {
				History.replaceState(historySet,"",urlParams);
				historyBool = true;
			}
		}
	}
	catch(e){alert("stealth history track error:" + e);}
	
	if(justTrackHist){
		//hacky way for now...
		ajaxObject.ajaxPost = {responseText:'{"priKeyID":'+pageID+'}'};
		ajaxObject.onreadystatechange();
		ajaxObject.abort();
		return;
	}

	if(getPost){
		ajaxObject.open("POST",location,async);
		ajaxObject.setRequestHeader("Content-type", contentType);
		ajaxObject.setRequestHeader("Content-length", params.length);
		ajaxObject.setRequestHeader("Connection", "close");
		
		try{
			ajaxObject.send(params);
		}
		catch(e){
			/*probably no internet connectoin, return 
			404 so we store form info in local storeage*/
			ajaxObject.status = 404;
		}
	}
	else{
		//the location could have params itself already
		if(location.indexOf("?") === -1) params = "?" + params;
		ajaxObject.open("GET",location + params,async);
		ajaxObject.send(null);
		
		try{
			ajaxObject.send(null);
		}
		catch(e){
			/*probably no internet connectoin, return 
			404 so we store form info in local storeage*/
			ajaxObject.status = 404;
		}
	}
}

//google analtyics
function gaTrack(sendType, sendObject) {
	ga('set', sendObject);
	ga('send', sendType);
}

//return the caller of the function object
function getParentFunctionCall(funObj){
	if(funObj.caller) return funObj.caller;
	else return false;
}

function fieldEscape(fieldVal){
	try{ return escape(htmlentities(fieldVal)); } catch(e){ alert(e); }
}

function ckFieldEscape(fieldVal){
	return CKEDITOR.instances[fieldVal].getData();
}

function htmlentities(str) {
	return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function loadSinglePageSite(){
	var currentPage = pageArray[pageID].pageOrder;
	var prevPages = [], nextPages = [];
	
	for(var i in pageArray){ //Grab all of the pages in order, split by the current loaded page
		if(parseInt(i) != pageID){
			if(pageArray[i].pageOrder < currentPage){
				prevPages[pageArray[i].pageOrder - 1] = i; 
			}
			else{
				nextPages[pageArray[i].pageOrder - currentPage - 1] = i; 
			}
		}
	}
	
	if(prevPages.length + nextPages.length <= 1){
		return;
	}
	
	var first = (prevPages.length > 0) ? prevPages.pop() : -1
	if(first === -1) first = (nextPages.length > 0) ? nextPages.shift() : -1; //get the first to load if exists
	var current = first, next = -1;
	
	while(prevPages.length > 0 || nextPages.length > 0){ //loop through the rest and build a chain of pages to load
		if(pageArray[current].pageOrder < pageArray[pageID].pageOrder){ //The current page to load is to the left/top
			next = (nextPages.length > 0) ? nextPages.shift() : (prevPages.length > 0) ? prevPages.pop() : null;
			if(next !== null){
				if(!emptystring(pageArray[current].postUpdate)){
					pageArray[current].tempPost = pageArray[current].postUpdate;
				}
				pageArray[current].postUpdate = "upc("+next+",null,false);";
			}		
		}
		else{
			next = (prevPages.length > 0) ? prevPages.pop() : (nextPages.length > 0) ? nextPages.shift() : null;
			if(next !== null){
				if(!emptystring(pageArray[current].postUpdate)){
					pageArray[current].tempPost = pageArray[current].postUpdate;
				}
				pageArray[current].postUpdate = "upc("+next+",null,false);";
			}
		}
		if(prevPages.length <= 0 && nextPages.length <= 0){
			if(!emptystring(pageArray[next].postUpdate)){
				pageArray[next].tempPost = pageArray[next].postUpdate;
			}
			pageArray[next].postUpdate = "if($s('li')){$('#li').fadeOut(400);}pageID = "+pageID+";";
		}
		else{
			current = next;
		}
		if(prevPages.length === 0 && nextPages.length === 0){
			if(!emptystring(pageArray[pageID].postUpdate))
			pageArray[next].postUpdate += pageArray[pageID].postUpdate;
		}
	}
	upc(first,null,false);
}

function upt(pID){//update pageText container
	var pageAjax = ajaxObj();
	var moduleParams = "function=getRecordByID&pID=" + pID;
	
	pageAjax.onreadystatechange=function(){
		if(pageAjax.readyState===4){
			//JSON parse reponse, update innerHTML of pageText
			$(".pageText").html(JSON.parse(pageAjax.responseText).prodIndex0.pageCode);
			document.title = $(document.createElement('div')).html( JSON.parse(pageAjax.responseText).prodIndex0.pageTitle).text();
			pageID = pID; //update global variable
		}
	}
	ajaxPost(pageAjax,"/cmsAPI/pages/pages.php",moduleParams,true,0,false,true);
}

function upc(pID,moduleParams,hisTrack, hisBreak){//main function for updating pages

	//if the first character in our parameters is a ? remove it
	if(moduleParams) {
		moduleParams = repSubstr(moduleParams,"?","");
	}
	
	// for some reason scrollTo(0,0) doesn't work here so I replaced it with animate one, looks nicer though - Fateme
	/*window.scrollTo(0,0);*/
	$("html, body").animate({ scrollTop: 0 }, "slow");
	
	if(typeof(pageAjax) !== "undefined") pageAjax.abort();//abort previous page updates
	
	if(moduleParams) var moduleParams = "function=getPage&pageID=" + pID + "&" + moduleParams;
	else var moduleParams = "function=getPage&pageID=" + pID;

	//specify if we are tracking history
	if(isset(hisTrack)){
		hisTrack = hisTrack;
	}
	else{
		//changing pages. track history
		if(
			//changing page
			pID !== pageID ||
			//no url parameters, could be there from pagination, search, etc
			(pID == pageID && location.search.length > 0)
		){
			hisTrack = true;
		}
		//same page, don't track history
		else{
			hisTrack = false;
		}
	}
	prevPage = pageID; //we need the previous page if we are appending a page instead of replacing
	pageID = pID; //global variable for pageID
	pID = prevPage; //need to use this just in case we are doing a single page load and need to reset it!
	
	//clear timers and intervals we had for this page
	for(var tempTimer in pageInterTime){
		try{ clearTimeout(pageInterTime[tempTimer]); } catch(e){}
		try{ clearInterval(pageInterTime[tempTimer]); } catch(e){}
		delete(pageInterTime[tempTimer]);
	}
	
	pageAjax = ajaxObj();
	pageAjax.hideEffectComplete = false;
	pageAjax.histTrack = hisTrack;
	
	//show loading gif
	if($s("li")){
		$("#li").fadeTo(400,1,"swing");
	}
	
	if(singlePageSite){
		upcDoUpdate();
	}
	else{
		$(".pcpy").stop().fadeTo(400,0,"swing",
			function(){
				pageAjax.hideEffectComplete = true;
				//only proceed if the ajax request is finished
				if(typeof(pageAjax.responseText) !== 'unknown' && pageAjax.responseText.length > 0){
					upcDoUpdate();
				}
			}
		);
	}
	
	//only proceed if the fade is finished
	pageAjax.onreadystatechange=function(){
		if(pageAjax.readyState===4){
			if(pageAjax.hideEffectComplete){
				upcDoUpdate();
			}
		}
	}
	
	//make the request for the page content
	ajaxPost(
		 pageAjax, //XMLHTTPRequest Object
		"/cmsAPI/pages/pages.php", //API Path
		moduleParams, //url params
		true, //async
		0, //GET
		false, //text/html
		hisTrack, //track history
		(singlePageSite&&pageArray[pageID].pageLoaded)
	);

	//preUpdate function, default fades in the pagecopy and hides the loading gif
	var tempUpdate = new Function(pageArray[prevPage].preUpdate);
	tempUpdate();
}

// Function: upcDoUpdate
// Purpose: helper function for the upc function, removes old scripts and styles if not a single page site.
function upcDoUpdate(){
	if(!singlePageSite){ //If it's not a single page site, remove the script for the modules loaded for the previous page				
		while($s("moduleScript")) $("#moduleScript").remove();
	}				
	if(pageAjax.readyState===4){
		updatePage();//parse response and finalize page update
	}
}

function updatePage(){//finalizes page transition with data retrieved from the server
	pageAjax.pageData = JSON.parse(pageAjax.responseText);
	
	//clear out old styles
	if(!pageArray[pageAjax.pageData.priKeyID].pageLoaded){
		if(navigator.appVersion.indexOf("MSIE") != -1){
				var cssCnt = document.styleSheets.length;
				for(var c = 0; c < cssCnt; c++)
					//ie 7 and 8 handle styleSheets differently in winxp and win7
					//need to look for a title and update the correct one		
					if(document.styleSheets[c].title==="moduleStyles"){
						if(singlePageSite){
							pageAjax.pageData.moduleStyles = document.styleSheets[c].cssText + pageAjax.pageData.moduleStyles;
						}
						document.styleSheets[c].cssText = "";
					}
		}
		else{
			if(singlePageSite){
				pageAjax.pageData.moduleStyles = $("[title='moduleStyles']").text() + pageAjax.pageData.moduleStyles;
			}
			$("[title='moduleStyles']").empty();
		}
	}
	var tempAfterC = pageArray[pageAjax.pageData.priKeyID].afterComplete;
	upcAfterComplete(new Function(tempAfterC));

}

// Function: upcAfterComplete
// Purpose: the replace or append scripts, styles, pageTitle, etc after the ajax call has completed
function upcAfterComplete(transition){
	if(
		(singlePageSite && !pageArray[pageAjax.pageData.priKeyID].pageLoaded) ||
		!singlePageSite
	){
		//build the pagecopy container
		var page = $("<div id='pcpy"+pageAjax.pageData.priKeyID+"' class='pcpy'></div>");

		if(singlePageSite){
			//Build an array of our pages (we can't index an object)
			if(pageArray[prevPage].pageOrder < pageArray[pageAjax.pageData.priKeyID].pageOrder){
				$("[id^='pcpy']:last").after(page);
			}
			else{
				$("#pc").prepend(page);
			}
			pageArray[pageAjax.pageData.priKeyID].pageLoaded = 1;
			page.html(
				pageAjax.pageData.beforeModuleCode +
				pageAjax.pageData.pageCode + 
				pageAjax.pageData.afterModuleCode
			);
		}
		else{
			//put in new content & update the id's of our containers
			$(".pcpy").eq(0).html(
				pageAjax.pageData.beforeModuleCode +
				pageAjax.pageData.pageCode + 
				pageAjax.pageData.afterModuleCode
			)
			.attr("id","pcpy"+pageAjax.pageData.priKeyID);
			
			$(".pc").attr("id","pc"+pageAjax.pageData.priKeyID);
			
			/*if we are forwarding from one page to another, add a class with 
			the page ID of the page we would of went to*/
			$(".pc").attr("class","pc pcLnk"+ pageID);
		}
		
		if(singlePageSite){
			var scriptTag = "moduleScriptHead" + pageAjax.pageData.priKeyID;
		}
		else{
			//must remove old script everytime for FF. can only add .change attribute once
			if($s("moduleScriptHead")) $("#moduleScriptHead").remove();
			var scriptTag = "moduleScriptHead";
		}
		
		//insert new moduleScriptHead, should be flexible enough to allow scripts for all pages
		var tempScript = document.createElement('script');
		tempScript.id = scriptTag;
		document.getElementsByTagName("head")[0].appendChild(tempScript);
		$s(scriptTag).text = pageAjax.pageData.moduleScripts;
		// replace stylesheets
		if(navigator.appVersion.indexOf("MSIE") != -1){
			var cssCnt = document.styleSheets.length;
			for(var c = 0; c < cssCnt; c++){
				//ie 7 and 8 handle styleSheets differently in winxp and win7
				//need to look for a title and update the correct one
				if(document.styleSheets[c].title ==="moduleStyles") {
					document.styleSheets[c].cssText = pageAjax.pageData.moduleStyles;
				}
			}
		}
		else{
			$("[title='moduleStyles']").text(pageAjax.pageData.moduleStyles);
		}
		
		//run page transition functions, and functions for the modules
		try{
		new Function(
			pageAjax.pageData.moduleRunScripts + 
			pageAjax.pageData.modulePageTransition + 
			pageAjax.pageData.pageTransition
		)();
		}
		catch(e){}
	}
	
	try{ 
		if(transition !== null) transition();
	}
	catch(e){
		//Account for a possible error, maybe call default...
	}
	if(pageAjax.histTrack == true){		
		document.title = (singlePageSite) ? 
			pageArray[pageAjax.pageData.priKeyID].pageTitle :
			$(document.createElement('div')).html(pageAjax.pageData.pageTitle).text();
	}
	//postUpdate function, default fades in the pagecopy and hides the loading gif
	var tempPostUp = pageArray[pageAjax.pageData.priKeyID].postUpdate;
			
	if(tempPostUp && tempPostUp.length > 0){
		transition(pageAjax);
	}
	else{
		$(".pcpy").stop().fadeTo(500,1,"swing");
	}
	
	if($s("li")){
		$("#li").stop().fadeOut(400,"swing",function(){
			$(this).hide();
		});
	}

	//update page sub nav links that might redirect to this page
	$(".lpi" + pageAjax.pageData.priKeyID + ".ni" + pageID).addClass("fakeHover");
	
	if(!emptystring(pageArray[pageAjax.pageData.priKeyID].tempPost)){
		pageArray[pageAjax.pageData.priKeyID].postUpdate = pageArray[pageAjax.pageData.priKeyID].tempPost;
		delete pageArray[pageAjax.pageData.priKeyID].tempPost;
	}
	delete pageAjax;
	
	//run standard javascripts that we want on every page
	extraScripts();
}

function extraScripts(){
	//invoke the plugin for IE9 placeholder text
    $('input, textarea').placeholder({customClass:'my-placeholder'});
	
	//attach google analtyics to all phone number hrefs's
	setPhoneTrack();
	
	//invoke fancy box
	setGalleryFancyBox();
}

/*as we create accordionObjects we store them in this parent object
so we can reference them when we login in/out to get member pages*/
var accordionTreeObjs = {};
function accordionTree(navClass,navType,toggleSpeed){
	this.navID = "#navOuter-"+navClass;
	this.navType = navType; //navType, used for generating nav on member sign in
	this.className = navClass;
	this.toggled = false;
	this.toggleSpeed = toggleSpeed;
	this.className = navClass;
	
	this.toggleBlind = function(tID,thisRoot,afterEval,clickObjID,thisEvent){
		//the element that was clicked, has to be passed as a string for the History to work
		var clickObj = $s(clickObjID);

		//prevent event bubbling
		if(thisEvent){
			thisEvent.cancelBubble = true; 
			if(thisEvent.stopPropagation) thisEvent.stopPropagation();
		}
		//change the class on whichever one we clicked so that its marked as clicked
		this.updateAccordianObjs(tID);
		
		if(afterEval.length> 0) {
			var afterRun = new Function(afterEval);
		}
		else{
			var afterRun = new Function("return true");
		}
		
		//get the root parent of the click object
		//var rootParent = $(clickObj).parents(".ntl1").children(".ntp");
		//collapse our nav structure
		//this.collapseNav(rootParent);
		//this.navHover(rootParent,false,thisEvent);
		
		//collapse the children when a page is clicked
		if(this.collapseOnClick){
			$(".navInner .expand").removeClass("expand");
			$(".navInner .hover").removeClass("hover");	
		}
		else{
			$(".ec").removeClass("expand");
			$(clickObj).parent('.ec').addClass("expand");
			$(clickObj).children('.ec').addClass("expand");
		}
		
		afterRun();

		//need properties changes across all instances of the accordionTree object
		if(pageArray[tID].pageLevel<2){
			accordionTree.prototype.lastExpandedRoot = tID ;
		}
		else{
			accordionTree.prototype.lastExpandedRoot = thisRoot;
		}

		accordionTree.prototype.lastExpanded = tID;
		this.toggled = false;
		
		/*backup the nav html as as property of the object to restore 
		this version when we snap out of the responsive nav*/
		if($(".mobileNav").size() == 0){
			this.stealthNav = $s('navOuter-' + this.className).outerHTML;
		}
		
	}
	
	/*backup the nav html as as property of the object to restore 
	this version when we snap out of the responsive nav*/
	this.stealthNav = $s('navOuter-' + this.className).outerHTML;
}

accordionTree.prototype.determineRoot = function(){
	var nc = $(".nc.fakeHover");
	if(nc.length <= 0) return null;
	else{
		return nc.not("[id^='sn']").first().attr('class').split("ni")[1].split(" ")[0];
	}		
}

//updates the state of an element that we've clicked on
accordionTree.prototype.updateAccordianObjs = function(tID){
	//remove fake hover class from any nav objects that may have it
	$(".nc").removeClass('fakeHover');
	//assign fakeHover to all nav items with the same id. regardless of nav menu
	$(".ni" + tID)
		.parents(".nc")
		.andSelf()
		.not('.ntp')
		.addClass("fakeHover",this.toggleSpeed);		
}

//put an extra class on the nav container when we mouse over a link
accordionTree.prototype.navHover = function(lnk,state,e){

	clearTimeout(this.parentHoverTime);
			
	if(state && !$(lnk).parents(".navOuter").hasClass("fakeHover")){		
		$(lnk).parents(".navOuter").addClass("fakeHover");
	}
	else if(!state){
		
		var tempNavObj = this;
		this.parentHoverTime = setTimeout(
			function(){
				tempNavObj.removeParentHover(lnk,state,e);
			},400
		);
		
	}
}

accordionTree.prototype.removeParentHover = function(lnk,state,e){
	$(lnk).parents(".navOuter").removeClass("fakeHover");
}

accordionTree.prototype.collapseNav = function(el){
	// not a child container
	if(!$(el).hasClass("ec")){ 
		$(el).children(".ec").andSelf().removeClass("hover");
		$(el).children(".ec").andSelf().removeClass("expand");
	}
	// child container
	else if(!$(el).parent().hasClass("hover")){ 
		$(el).children(".nc").andSelf().removeClass("hover");
	}
}

accordionTree.prototype.lastExpandedRoot = 0;
accordionTree.prototype.lastExpanded = 0;
accordionTree.prototype.parentHoverTime = 0;

accordionTree.prototype.resNav = function(){
	if(
		this.isResponsive == true &&
		(window.matchMedia &&
		window.matchMedia("(max-width: " + this.triggerPoint + "px)").matches)
		//older browsers
		|| (!window.matchMedia && $(window).width() < this.triggerPoint - 20)
	) {
		//if responsive hasn't been set for this navigation yet
		if($('#navOuter-' + this.className + '.mobileNav').length == 0){
			
			//backup the html so we can restore it if we leave responsive
			this.stealthNav = $s('navOuter-' + this.className).outerHTML;
			
			//create responsive menu button
			if($('#navInner-' + this.className + ' .expandRespNav').length == 0){
				$('#navInner-' + this.className).append(
					'<h2 class="expandRespNav"><i class="fa fa-reorder"></i></h2>'
				);
			}

			$('#navOuter-' + this.className).addClass("closedMobileNav");
			$(".hamburger--" + this.hamburgerAnimation).removeClass("is-active");
								
			//add class to our nav parent so we know we're in mobile mode
			$('#navOuter-' +this.className).addClass("mobileNav");
			
			//loop through our links and attach the onclicks as events
			$('#navOuter-' + this.className + " .nc > a.nc").each(
				function(inex, el){	
					var tempClick = repSubstr(
						$(el).attr('onclick'),"return false",""
					);
					
					tempClick = repSubstr(
						tempClick,"event","null"
					);
								
					$(el).attr('data-onclick',tempClick);
					$(el).removeAttr('onclick');
					$(el).removeAttr('onmouseover');
				}
			);
			
			
			//loop through our links and attach the onclicks as events
			$('#navOuter-' + this.className + " .hc > .nc").each(
				function(inex, el){								
					$(el).after( 
						'<h2><i id="mobileHeader' + $(el).get(0).id + '"></i></h2>' 
					);
				}
			);
			
			if(isMobile) {
				var clickEventType = 'click';
			}
			else {
				var clickEventType = 'click';
			}

			//make hamburger menu expand when nav when clicked
			$("#responsiveBtn-" + this.className).on(clickEventType,{stealthNavObj:this},function(e){

				disabledEventPropagation(e);

				if($("#navOuter-" + e.data.stealthNavObj.className).multilevelpushmenu( 'menuexpanded',
					$(".multilevelpushmenu_wrapper .ltr" )
				)){
					$("#navOuter-" + e.data.stealthNavObj.className).multilevelpushmenu( 'collapse' );
					$(".hamburger--" + e.data.stealthNavObj.hamburgerAnimation).removeClass("is-active");
				}
				else{
					$("#navOuter-" + e.data.stealthNavObj.className).multilevelpushmenu( 'expand' );
				}
				
			});
			
			//run responsive nav script
			$('#navOuter-' + this.className).multilevelpushmenu({
				direction: this.direction,
				menuHeight: this.menuHeight,
				menuWidth: this.menuWidth,
				collapsed: this.collapsed,
				durationSlideDown: 0,
				fullCollapse: true,
				//overlapWidth: accordionTreeObjs[prop].overlapWidth,
				//originalOverlapWidth: accordionTreeObjs[prop].overlapWidth,
				menuInactiveClass: "cMenu",
				swipe:"desktop",
				/*because of the we always want to show our root level
				we need to take some liberties with the way overlapWidth
				is used. we keep track of our levels, and then if we return
				to the root level, we set overlapWidth manually by dividing
				it by whatever level we're currently at.*/
				menuLevel:1,
				mode: 'overlap',
				stealthNavObj: this,
				//jquery object to reference in callbacks
				navObj: '#navOuter-' + this.className,
				//by default the nav should only be as tall as the menu button.
				//remove the css class that dictates this.
				onExpandMenuStart:function(plugOptions){
					
					//sometimes stuff just messes up.... this redraws the menu from scratch
					$('#navOuter-' + arguments[0].stealthNavObj.className).multilevelpushmenu( 'redraw' );

					$(arguments[0].navObj).removeClass("closedMobileNav");
					$(".hamburger--" + arguments[0].stealthNavObj.hamburgerAnimation).addClass("is-active");
					//once expanded change overlap to 0 otherwise
					//menu button vanishes on levels > 1
					if(plugOptions.menuLevel > 1){
						//$(arguments[0].navObj).multilevelpushmenu('option', 'overlapWidth', '0');
					}
					else{
						//$(arguments[0].navObj).multilevelpushmenu('option', 'overlapWidth', plugOptions.originalOverlapWidth);
					}
				},
				onBackItemClick:function(thisEvent, menuLevelObject, clickedItem){
												
					if(clickedItem.menuLevel > 0){
						clickedItem.menuLevel--;
					}

					//make previous clicked elements siblings visible again
					$(thisEvent.target).parent().parent().parent().siblings().removeClass("closedMobileChildren");
					
					//sometimes stuff just messes up.... this redraws the menu from scratch
					$('#navOuter-' + clickedItem.stealthNavObj.className).multilevelpushmenu( 'redraw' );
					
				},
				//if they click on a link with no children, collapse nav
				onItemClick:function(thisEvent, menuLevelObject, clickedItem, plugOptions){

					disabledEventPropagation(thisEvent);
					
					//go to the page the user clicks on
					eval($("#" + clickedItem[0].id + " > a").attr('data-onclick'));
					
					$(plugOptions.navObj).addClass("closedMobileNav");
					$(".hamburger--" + plugOptions.stealthNavObj.hamburgerAnimation).removeClass("is-active");
					
					plugOptions.menuLevel = 1;
					
					$(plugOptions.navObj).multilevelpushmenu(
						'collapse'
					);
				},
				//go to the page the user clicks on
				onGroupItemClick:function(thisEvent, menuLevelObject, clickedItem, plugOptions){

					disabledEventPropagation(thisEvent);
												
					eval($("#" + clickedItem[0].id + " > a").attr('data-onclick'));
					//don't show its children. we control this manually with the arrow
					$(plugOptions.navObj).addClass("closedMobileNav");
					$(".hamburger--" + plugOptions.stealthNavObj.hamburgerAnimation).removeClass("is-active");
					
					//$(plugOptions.navObj).multilevelpushmenu('option', 'overlapWidth', plugOptions.originalOverlapWidth/plugOptions.menuLevel);
					plugOptions.menuLevel = 1;
					$(plugOptions.navObj).multilevelpushmenu(
						'collapse'
					);
				}
			});
			
			//remove href from back button
			$(".backItemClass a").each(
				function(inex, el){	
					$(el).removeAttr('href');
				}
			);
			
			var tempNavObj = this;									
			//loop through our links and attach the onclicks as events
			$('#navOuter-' + this.className + " .hc > .nc").each(
				function(inex, el){								
					//create an icon to expand this page to see its children
					$(el).after( 
						'<a class="childShow" id="childShow' + $(el).get(0).id + '"></a>' 
					);
												
					//javascript to go to children 
					$("#childShow" + $(el).get(0).id).on("click",
						{stealthNavObj:tempNavObj},
						function(event){
							
							disabledEventPropagation(event);
							//get currrent menu level
							var tempMenuLevel = 
								$('#navOuter-' + event.data.stealthNavObj.className).multilevelpushmenu(
									'option', 
									'menuLevel'
								);
							
							//increase the menu level by 1	
							tempMenuLevel++;
							$('#navOuter-' + event.data.stealthNavObj.className).multilevelpushmenu(
								'option', 
								'menuLevel', 
								tempMenuLevel						
							);
							
							//expand to desired menu level
							$('#navOuter-' + event.data.stealthNavObj.className).multilevelpushmenu( 
								'expand' , $(this).next()
							);
							//to manage the fakehovers, we run the click
							//eval($(this).prev().attr('data-onclick'));
							
							//closes siblings of element we just clicked, so everything isn't pushed down
							$(this).parent().siblings(".nc").addClass("closedMobileChildren");
						}
					);
				}
			);
		}
		//redraw mobile nav for responsiveness
		else{
			$('#navOuter-' + this.className).multilevelpushmenu( 'redraw' );
		}
	}
	else{
		//it's currently a responsive nav
		if($('#navOuter-' + this.className + '.mobileNav').length > 0){
			$s('navOuter-' + this.className).outerHTML = this.stealthNav;
		}
		$(".pcpy").off("click");
	} 
}

/* checks window width and sets up mobile styling/functionality if necessary */
responsiveNav = function(){
	//loop through all our navigations
	for(var prop in accordionTreeObjs){
		
		var tempProp = accordionTreeObjs[prop];

		accordionTreeObjs[prop].resNav(tempProp);
	}
}

//once the site loads, run the script for the responsive nav
$(window).load(function(){
	responsiveNav();
});

/* check width on resize and execute transition functions if necessary */
$(window).bind('resize', function() {
	responsiveNav();
});

function enabledEventPropagation(event){
   if (event.stopPropagation){
       event.stopPropagation();
   }
   else if(event){
      event.cancelBubble=true;
   }
}
function disabledEventPropagation(event){
   if (event.stopPropagation){
       event.stopPropagation();
   }
   else if(event){
      event.cancelBubble=true;
   }
}

function stealthCommon(){};
//defaults for input fields that need to be handled in a special manner
//format date and time for mysql
stealthCommon.prototype.timeFields = "";

stealthCommon.prototype.addEditModule = function(blkEdit,addEditDraftBtn){
	
	//try-catch because asyn errors are difficult to detect	
	try{
		/*function to run before module submits, such as
		checking if user and login are available for user
		NOTE the preFunction must return true if you want to continue
		*/
		if(this.preFunction) {
			var preFunc = this.preFunction();
			if(!preFunc) return;
		}
		
		this.addEditDraftBtn = addEditDraftBtn;
		this.blkEdit = blkEdit;
		
		//determine if we are adding or editing the module record			
		if($(this.modForm).find("input[name='priKeyID']").val() == 0) {
			this.addEdit = false;
		}
		else this.addEdit = true;
		
		/*check to see if there is a form validation script, 
		and if there is that our form validates*/
		if(
			typeof($(this.modForm).validate) === "undefined" || 
			$(this.modForm).validate().form()
		){ 
			//disable so they can't multi-click
			$(this.modForm).find("input[name='moduleAddEditBtn']").attr("disabled", false);
			$(this.modForm).find("input[name='moduleAddEditDraftBtn']").attr("disabled", false);
			
			//change cursor to loading icon
			$('html').css('cursor','wait');
			var moduleAjax = ajaxObj(); //prepare our ajax request
			
			//encrypt any sha256 classed fields
			if(this.encryptFields){
				var encFields = this.encryptFields.split(',');
				for (var i = encFields.length - 1; i >= 0; i--){
					this.modForm[encFields[i]].value = this.modForm[encFields[i]].value.sha256();
				}
			}

			//put form fields into a JSON object
			var requestParams = this.getRequestFields(this,blkEdit);
						
			//determine if the we are online or offline
			//determined by a propertly in the module
			if(isset(this.isModOnline)) {
				var onlineCheck = this.isModOnline;
			}
			//not specified by the module, check for connectivity
			else{
				var onlineCheck = this.isOnline();
			}

			//silverline - online
			if(onlineCheck){
				//blk add edit... return our JSON object and send all form JSON objects to the server at once
				if(blkEdit){
					return requestParams;
				}
				//individual record add/edit
				else{
					//if its a public form with an instanceID
					requestParams += isset(this.modForm.instanceID) ? "&instanceID=" + this.modForm.instanceID.value : "";
					
					//pass the instanceID along so we know which to use on the server
					requestParams += "&pmpmID=" + this.pmpmID;

					ajaxPost(
						moduleAjax,
						this.apiPath,
						requestParams,
						false,
						1,
						"application/x-www-form-urlencoded",
						false
					);
					this.addEditResponse = moduleAjax.responseText;
				}
				
				//there was an error, probably wrong security level
				if(isNaN(this.addEditResponse)){
					alert(this.apiPath + this.addEditResponse);
					return false;
				}
				
				/*quick bug fix. for some reason the server is adding a /n breakline to the front of our
				returned returnedID. the php seems fine. could be a server thing? happens on adding and editing
				a record. for now I'm doing a parseInt here to 'fix' the problem - jared*/
			
				//add priKeyID, change submit button text
				if(!this.addEdit){
					$(this.modForm).find("input[name='priKeyID']").val(parseInt(this.addEditResponse));
					this.priKeyID = this.addEditResponse;
				}
				
				//add priKeyIDs for draft and live data, change submit button text when users click on DraftSave and Save Changes Button
				if(this.addEditDraftBtn){
					 $(this.modForm).find("input[name='draftPriKeyID']").val(parseInt(this.addEditResponse));	
					 this.draftPriKeyID = this.addEditResponse;
					$(this.modForm).find("input[name='moduleAddEditDraftBtn']").val("Edit Draft");
				}
				else {
					$(this.modForm).find("input[name='livePriKeyID']").val(parseInt(this.addEditResponse));
					this.livePriKeyID = this.addEditResponse;
					$(this.modForm).find("input[name='moduleAddEditBtn']").val("Edit " + this.moduleAlert);	
				}				
			}
			
			//silverline - offline
			else{
				//they key for our offline idata is the date in milliseconds
				var d = new Date();
				var n = d.getTime(); 
				
				//it encoded, but we don't want that version
				var requestParams = decodeURIComponent(
					this.getRequestFields(this,blkEdit)
				);
								
				localStorage.setItem(n,requestParams);
			}
			
			/*silverline - no matter if this is online or offline
			we want to keep the last ticket available to display*/
			/*var requestParams = decodeURIComponent(
				this.getRequestFields(this,blkEdit,addEditDraftBtn)
			);
			localStorage.setItem("prevTicket",requestParams);*/
						
			//enable add/edit buttons, reset cursor
			this.addEditComplete();
			
			//callback function for submitting a form
			if(this.nextFunction) {
				this.nextFunction();
			}
			
			//if this module was opened by another add/edit module, write record back to parent
			if(window.parent && this.inputType && this.disMsg == 1){
				this.createParentInput();
			}
			
			//quick add/edit, probably through another module
			if(
				this.quickAddEdit && 
				this.disMsg == 1 &&
				$(window.frameElement).parents(".ui-dialog").length > 0 &&
				typeof $(window.frameElement).parents(".ui-dialog").get(0) !== "undefined"
			) {
				//remove jquery ui dialog container
				$(window.frameElement).parents(".ui-dialog").get(0).remove();
			}
			
			if(!this.addEdit && this.disMsg == 1) {
				alert(this.moduleAlert + " has been added");
				
			}
			else if(this.addEdit && this.disMsg == 1) {
				alert(this.moduleAlert + " has been updated");
			}
		}

	}
	catch(e){
		alert("addEdit Mod Error:" + e);
	}
}

/*create and input field for a record created from a submodule,
ie gallery created from blog*/
stealthCommon.prototype.createParentInput = function(){
	if(this.inputType === "select"){
		//create new select option in parent module
		window.parent.$("#" + this.parentFormID + " select[name='"+ this.inputName+"']").append($('<option>', {
    		value: this.modForm.priKeyID.value,
    		text: $(this.modForm[this.inputDesc]).val()
		}));
		
		//select the option that was just created
		window.parent.$("#" + this.parentFormID + " select[name='"+ this.inputName+"']").val(this.modForm.priKeyID.value);
	}
}

stealthCommon.prototype.isOnline = function(){
	//test network connectivity with ajax
	var netTest = ajaxObj();
	
	netTest.onerror = function(){
		return false;
	}
	
	ajaxPost(
		netTest,
		"/public/networkTest.php",
		"",
		false,
		1,
		"application/x-www-form-urlencoded",
		false
	);
	
	if(netTest.status >= 200 && netTest.status < 304){
		return true;
	}
	else{
		return false;
	}
}

//create Object we turn to JSON full of form values
stealthCommon.prototype.getRequestFields = function(prntObj,blkEdit){
	var modData = {};
	
	/*can't use dot notation here or MSIE breaks, probably should 
	of used a smarter value other than 'function'
	
	determine the function on the server to call, add  be for single records or bulk changes
	*/
	
	var modLen = prntObj.modForm.length;
	
	//create and object, that has a property for each checkbox name group as an array
	var tempCheckVal = {};
	var tempCheckNames = $("#" + prntObj.modForm.id + " input[type='checkbox']").each(
		function(){
			if(!tempCheckVal[$(this).attr("name")]) {
				tempCheckVal[$(this).attr("name")] = [];
			}
		}
	);

	for(i=0;i<modLen;i++){
		var modElement = prntObj.modForm.elements[i];

		//ckEditor text fields
		if(isset("CKEDITOR") && CKEDITOR.instances[modElement.id]) {
			modData[modElement.name] = ckFieldEscape(modElement.id);		
		}
		//radio buttons
		else if(modElement.type === "radio") {
			modData[modElement.name] = $(
				"#" + prntObj.modForm.id + ' input[name='+modElement.name+']:checked'
			).val();
		}
		//checkbox
		else if(modElement.type === "checkbox") {
			if($s(modElement.id).checked) {
				tempCheckVal[modElement.name].push($s(modElement.id).value);
			}
		}
		 //time field... must convert 12hr to 24hr for mysql
		else if(
			modElement.name.length > 0 && 
			prntObj.timeFields.indexOf(modElement.name) > -1
		) {
			modData[modElement.name] = timeConvertMysql(modElement.value);
		}
		//regular text field
		else {
			modData[modElement.name] = modElement.value;
		}
	}
	
	//put checkbox values into object
	for(var key in tempCheckVal) {
		modData[key] = tempCheckVal[key].join();
	}
	
	//remove values from any fields that we don't want submitted
	if(prntObj.ignoreFields){
		var ignFields = prntObj.ignoreFields.split(",");
		for (var i = ignFields.length - 1; i >= 0; i--){
			//don't sent it at all
			delete modData[ignFields[i]];
			//this.modForm[ignFields[i]].value='';
		}
	}
	
	//determine the function on the server to call, add or update the data
	modData.priKeyID = $(this.modForm).find("input[name=priKeyID]").val();
	modData.draftPriKeyID=$(this.modForm).find("input[name=draftPriKeyID]").val();	
	modData.livePriKeyID=$(this.modForm).find("input[name=livePriKeyID]").val();

	/*if the draft button exists, we know the draft option is available for this module.
	If a user clicks on draft button, add the data first time then set priKeyID as draftPriKeyID 
	so that it won't change in the next click. Do the same for liveButton */
	if($$s("moduleAddEditDraftBtn")[0]){
		if(this.addEditDraftBtn){
			if(!modData.draftPriKeyID) {
				modData.isDraft = 1;
				modData["function"] ="addRecord";
			}
			else {
				modData.priKeyID= modData.draftPriKeyID;
				modData["function"] ="updateRecord";
			}
		}
		else {
			if(modData.livePriKeyID == "")  {
				modData.isDraft = 0;
			 	modData["function"] ="addRecord";
			}
			else {
				modData.priKeyID = modData.livePriKeyID;
				modData["function"] ="updateRecord";
			}
		}
	}
	//Add and update the data for all other pages who do not have draft button.
	else {
		if(!modData.priKeyID) {
			modData["function"] ="addRecord" ;
		}
		else {
			modData["function"] ="updateRecord";
		}
	}
	
	if(!blkEdit) {
		return "modData=" + encodeURIComponent(JSON.stringify(modData));
	}
	else{ 
		return modData;
	}
	
}

//update all records when we're editing in bulk mode
stealthCommon.prototype.bulkMassAddEdit = function() {
	
	var moduleAjax = ajaxObj();
	
	//all of our module forms

	var addEditForms = $$$s("moduleForm");
	
	//number of forms to loop through
	var formQty = addEditForms.length;
	
	//object to pass to server contain modified form information
	var recordChanges = {};

	for(var x = 0; x < formQty; x++){
		var tempJSObj = addEditForms[x].jsObjName.value;

		//we don't want to display an update message for each record
		//for some modules the update message is disabled by default, such as the gallery images
		var tempUpdateMessage = window[tempJSObj].disMsg;
		window[tempJSObj].disMsg = false;
		
		//put form data into object
		recordChanges[x] = window[tempJSObj].addEditModule(
			true
		);

		//activate individual records saves again
		window[tempJSObj].disMsg = tempUpdateMessage;
	}

	var modJSON = encodeURIComponent(JSON.stringify(recordChanges));
	 
	ajaxPost(
		moduleAjax,
		this.apiPath,
		"function=bulkAddEdit&modData=" + modJSON, 
		false,
		1,
		"application/x-www-form-urlencoded",
		false
	);
	
	/*loop through the priKeyID's and groupID's and add the returned 
	number back to the priKeyID field and groupID field needed for bulk add's*/
	var returnedIDs = JSON.parse(moduleAjax.responseText);
	for(var key in returnedIDs) {
		//priKeyID
		$s(key).value = returnedIDs[key]["priKeyID"];
		//groupID
		if(typeof $s(key).form.groupID !== "undefined") {
			$s(key).form.groupID.value = returnedIDs[key]["groupID"];
		}
			
		//live Pri KeyID
		if(typeof $s(key).form.livePriKeyID !== "undefined") {
			$s(key).form.livePriKeyID.value = returnedIDs[key]["priKeyID"];
		}
	}
	
	//run the callback functions after the new priKeyID's are in place
	for(var x = 0; x < formQty; x++){		
		/*check if this form is valid, doesn't display not-valid 
		errors at this point they are already displayed*/
		/*console.log($(addEditForms[x]).valid());*/
		if(
			typeof($(addEditForms[x]).validate) === "undefined" || 
			$(addEditForms[x]).validate().numberOfInvalids() === 0
		){ 
		
			var tempJSObj = addEditForms[x].jsObjName.value;
		
			//set the new priKeyID on our js object
			window[tempJSObj].priKeyID = addEditForms[x].priKeyID.value;
			
			//callback function for submitting a form
			if(window[tempJSObj].nextFunction) {
				window[tempJSObj].nextFunction();
			}
		}
	}
	
	//enable add/edit buttons, reset cursor
	this.addEditComplete();
	
	//some modules display the completed message in the nextFunction, such as the gallery images
	if(window[tempJSObj].disMsg == true) {
		alert("Changes have been saved.");
	}
}

//quickEdit - if true, editing through the module list, else adding through bulk
stealthCommon.prototype.setupRecord = function(
	quickEdit,thisBtn,primaryPmpmAddEditID,parentPriKeyIDName,parentWriteBack
){
	var moduleAjax = ajaxObj();
	moduleAjax.moduleClassName = this.moduleClassName;

	if(primaryPmpmAddEditID !== null){
		this.primaryPmpmAddEditID = primaryPmpmAddEditID;
	}

	//called from another add/edit module. see if there's a parent module for it
	if(parentPriKeyIDName){
		var parentPriKeyID = $(thisBtn.form[parentPriKeyIDName]).val();
		if(isNaN(parentPriKeyID)){
			var tempParentLabel = $(thisBtn.form).find("label[for="+ parentPriKeyIDName + "]").html();
			alert("Please choose a " + tempParentLabel);
			return false;
		}
	}

	if(!parentPriKeyID){
		var parentPriKeyID = this.parentPriKeyID;
	}
	
	if(!parentWriteBack){
		var parentWriteBack = {};
	}
	
	//not a bulk add/edit
	if(thisBtn !== null && thisBtn.form !== null && typeof thisBtn.form !== "undefined"){
		parentWriteBack.parentFormID = thisBtn.form.id;
	}
	
	var pwb = $.param(parentWriteBack);

	//quick add/edit on public side, or adding a module from within another module
	if(quickEdit === true) {
		var tempPmpmID = this.primaryPmpmAddEditID;
		var tmpPriKeyID = this.priKeyID;
		moduleAjax.quickEdit = true;
		var paramStr = "function=setupRecord&pmpmID=" + tempPmpmID + "&quickEdit=" + quickEdit + "&recordID=" + tmpPriKeyID + "&parentPriKeyID=" + parentPriKeyID + "&" + pwb;
	}
	//bulk adding
	else{
		var tempPmpmID = this.pmpmID;
		moduleAjax.quickEdit = false;
		
		//there there is a parent record ID, such as a galleryID for images
		if($("#parentPriKeyIDBlk") && !isNaN($("#parentPriKeyIDBlk").val())) {
			var parentPriKeyID = $("#parentPriKeyIDBlk").val();
			var parentPriStr = "&parentPriKeyID=" + parentPriKeyID;
		}
		else{
			var parentPriStr = "";
		}
		
		var paramStr = "function=setupRecord&pmpmID=" + tempPmpmID + "&quickEdit=" + quickEdit + parentPriStr + "&" + pwb;
	}

	moduleAjax.onreadystatechange=function(){
		if(moduleAjax.readyState===4){
			var tempMod = JSON.parse(moduleAjax.responseText);

			if(moduleAjax.quickEdit){

				var appendLocation = $(".pcpy").attr('id');
				//load our form into a modal
				//we change the ID of the modal once our module loads				
				$("<iframe class='subAddEditFrame'>" + 
						"<head>" +
						"</head>" +
						"<body>" +
						"</body>" +
					"</iframe>").dialog({
				 		 appendTo: "#" + appendLocation,
						 height:500,
						 width:1024, 
						 maxWidth:"90%",
						 dialogClass: "quickEditContainer",
						 close: function(event, ui) { 
							$(this).dialog('destroy').remove();
						} 
					}); 
				
				$$s('subAddEditFrame')[0].contentDocument.write(
					'<style type="text/css">' + tempMod.CSS + '</style>' +
					'<link rel="stylesheet" type="text/css" href="/css/stealthDefaults.php" />' +  
					'<link rel="stylesheet" type="text/css" href="/css/reset.php" />' + 
					'<link rel="stylesheet" type="text/css" href="/css/admin.php" />' +
					tempMod.DOM +
					'<script src="/js/headScripts.php" type="text/javascript"></script>' +
					'<script type="text/javascript">' + tempMod.JS + ';window=parent;</script>'
				);
			}
			else{
				//insert our DOM at the top of the record list
				$("#mfmcc-" + moduleAjax.moduleClassName).append(tempMod.DOM);
				
				//run javascript
				eval(tempMod.JS);
			}
			
			return true;
		}
	}
	
	ajaxPost(
		moduleAjax,
		"/modules/moduleFrame/recursiveModule.php",
		paramStr,
		false,
		1,
		"application/x-www-form-urlencoded",
		false
	);
}

//enable add/edit buttons, reset cursor
stealthCommon.prototype.addEditComplete = function() {				
	$("input[name='moduleAddEditBtn']").attr("disabled", false);
	$("input[name='moduleAddEditDraftBtn']").attr("disabled", false);		
	$('html').css('cursor','');//remove 'busy' cursor
}

//updates the innerHTML of a parent module with all the records of a child
stealthCommon.prototype.updateParentField = function(pElID){
	var childAjax = ajaxObj();
	var requestParams = 'function=getConditionalRecord&a={ "0":"priKeyID","1":0,"2":"false","3":"DESC"}';
	var winPrtEl = window.opener.document.getElementById(pElID);
	winPrtEl.innerHTML = "";//clear parent select
	
	//do ajax call on this object to get the records, sort DESC so the latest one is selected
	ajaxPost(childAjax,this.apiPath,requestParams,false,1,null,false);
	var domElements = JSON.parse(childAjax.responseText);
	
	//build up parent select
	for(var z in domElements){
		buildParentHtml.createDOMElement(
			"option",
			{
				innerHTML:domElements[z].galleryName,
				value:domElements[z].priKeyID
			},
			winPrtEl
		);
	}
}

//load the scripts for CKEditor and CKFinder and create required instances
stealthCommon.prototype.loadCKEditor = function(priKeyArray){
	
	//loose 'this' in jquery callbacks
	var tmpObj = this;

	if(this.ckEditorFieldName) {
		//check if we have loaded CKEDITOR previously, only need to load it once
		if(!isset("CKEDITOR")){
			//load in ckeditor script with jquery
			$.getScript(
				"/ckeditor/ckeditor.js", 
				function(){
					//check if we've loaded a CKFinder
					if(!isset("CKFinder")) {
						//load CKFINDER
						$.getScript(
							"/ckfinder/ckfinder.js", 
							function(){
								//creates instances
								tmpObj.loadCKInstance(priKeyArray);
							}
						);
					}
					else {
						//creates instances
						tmpObj.loadCKInstance(priKeyArray);
					}

				}
			);
		}
		else{
			//creates instances
			tmpObj.loadCKInstance(priKeyArray);
		}
	}
}

//creates instances for our CKEditor and CKFinder
stealthCommon.prototype.loadCKInstance = function(priKeyArray){
	
	//how many priKeyID's have to loop through
	var recCnt = priKeyArray.length;

	try{
	for(var x = 0; x < recCnt; x++){
	
		//priKeyID of our module instance
		var recPriKey = priKeyArray[x];
		
		//loose 'this' in jquery callbacks
		var tmpObj = this;
		
		//textarea DOM object
		var tempCKFields = this.ckEditorFieldName.split(",");
		var tempArrayLen = tempCKFields.length;

		for(var y = 0; y < tempArrayLen; y++){
			var moduleTextArea = $s(tempCKFields[y] + recPriKey);

			//delete ckeditor if the module is reloaded
			if(
				moduleTextArea &&
				typeof CKEDITOR.instances[moduleTextArea.id] !== "undefined"
			){
				CKEDITOR.remove(CKEDITOR.instances[moduleTextArea.id]);
			}

			//Create ckfinder instance
			var tempCK = CKEDITOR.replace(moduleTextArea.id,{filebrowserBrowseUrl: '/ckfinder/ckfinder.html', filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', filebrowserWindowWidth: '1000', filebrowserWindowHeight: '700'});
			
			CKEDITOR.config.autoParagraph = false;
			
			//allow custom HTML so ckeditor doesn't try to fix/remove it for us
			CKEDITOR.config.allowedContent = true;
			
			//turns off template replace all content by default
  			CKEDITOR.config.templates_replaceContent = false;
			
			//load in our custom template file
			CKEDITOR.config.templates_files = [
				'/ckeditor/stealthTemplate.js'
			];
						
			//allows div's instead h tags
			CKEDITOR.dtd.h1.div = 1;
			CKEDITOR.dtd.h2.div = 1;
			CKEDITOR.dtd.h3.div = 1;
			CKEDITOR.dtd.h4.div = 1;
			CKEDITOR.dtd.h5.div = 1;
			
			CKEDITOR.config.entities = true;
			CKEDITOR.config.entities_additional = '#34,#39';
			
			//lets the user pick pages from the stealth cms to link to
			CKEDITOR.config.extraPlugins = 'stealthCMSLink';
		}
	}
	}
	catch(e){console.log("stealth error loading CKEditor" + e);}
}

stealthCommon.prototype.moduleDelete = function(recordID,thisBtn) {

	//if the record is created from the bulk entries we have a random string
	if(recordID.length > 0 && !isNaN(recordID)) {
		recordID = recordID;
	}
	else{
		recordID = this.priKeyID;
	}

	var comfDel = confirm("Are you sure you want to delete this record?");
	if(comfDel) {
		//deleting a draft that has a live record
		if(
			thisBtn.className == "moduleItemDeleteDraft" &&
			$(thisBtn).siblings(".moduleItemEdit").length > 0
		){
			$(thisBtn).siblings(".moduleItemEditDraft").remove();
			$(thisBtn).remove();
		}
		//otherwise delete a draft by itself, or a live record
		else{
			$(thisBtn).parents(".mi").remove();
		}

		/*callback function for after a record is deleted
		must be BEFORE we remove the record from the  
		database, so we can get the file name etc...*/
		
		try {
			//alert('We are going in! Be afraid');
			galleryImageAddEditObj.afterModuleDel(recordID);
		}catch(e){
			//alert('boo! It didnt work.');
		}
	

		var moduleHttp = ajaxObj();

		moduleHttp.onreadystatechange=function(){
			if(moduleHttp.readyState===4){
				alert("The item has been removed");
			}
		}
	
		ajaxPost(
			moduleHttp,
			this.apiPath,
			"function=removeLiveDraftByID&recordID=" + recordID,
			null,
			null,
			null,
			false
		);
	}
}

//go to add/edit form for this module item in user specified language
stealthCommon.prototype.changeModuleLng = function(){
	
	if(
		window.location.search.indexOf("recordID=") === -1 &&
		typeof this.priKeyID !== "undefined"
	){
		var recIDStr = "&recordID=" + this.priKeyID
	}
	else{
		var recIDStr = "";
	}
	
	upc(
		this.addEditPageID, 
		window.location.search + 
		"&recLng=" + $('#moduleItemLang').val() +
		recIDStr
	);
	return true;
}

//go to a specific pagination page
//refreshPag if we want to refresh the pagination - doesn't work on level 2 modules
stealthCommon.prototype.paginateModule = function(
	requestParams,thisDiv,thisPagPage,refreshPag,historyTrack
){
	var refreshPag=isset(refreshPag)?refreshPag:false;
	var pagAjax = ajaxObj();
	var pagNums = $(".pgc-" + this.moduleClassName);
	var historyTrack = isset(historyTrack)?historyTrack:true;
	
	//remove the clicked class from the pagination link
	$(".pgc-" + this.moduleClassName).removeClass("pgcClicked");
	
	// It's nicer to scroll up to the beginning of the module instead of top of the page - Added by Fateme 
	animatedScroll("mfmc-" + this.moduleClassName);
	
	//set the recently clicked pag-page link
	if(thisDiv) thisDiv.className = thisDiv.className + " pgcClicked";
	
	//went directly to a pagination page
	if(thisPagPage) this.pagPage = thisPagPage;
	
	/*make our object properties, properties of the ajax  
	object so we can access them in the ajax repsonse*/
	pagAjax.modObj = this;
	pagAjax.moduleClassName = this.moduleClassName;
	pagAjax.pagAjax = requestParams;
	pagAjax.refreshPag = refreshPag;
	pagAjax.requestParams = requestParams;
	pagAjax.moduleID = this.moduleID;
	pagAjax.instanceID = this.instanceID;
	pagAjax.afterPaginate = this.afterPaginate;
	pagAjax.historyTrack = historyTrack;
	pagAjax.afterPaginate = this.afterPaginate;
	
	pagAjax.onreadystatechange=function(){
		if(pagAjax.readyState===4){
			
			var tempMod = JSON.parse(pagAjax.responseText);
						
			if(
				//regular pagination
				$s("mfp-" + pagAjax.moduleClassName) || 
				//login module
				pagAjax.moduleID == 37
			){
				$s("mfmcc-" + pagAjax.moduleClassName).innerHTML = tempMod.DOM;
				
				//run javascript
				eval(tempMod.JS);
				
				//for now, only for the login module
				if(pagAjax.moduleID == 37){
					/*append our styles, right now its primary used
					for nav styleing differences on silver line
					-so it would seem we should NOT be using the title attribute on the style tag
					for our jquery selector, we will make sure to keep our pagnation tag as the 3rd tag */				
					if(navigator.appVersion.indexOf("MSIE") != -1){
						//ie 7 and 8 handle styleSheets differently in winxp and win7
						//need to look for a title and update the correct one
						document.styleSheets[2].cssText = tempMod.STYLES;
					}
					else{
						$("#pagStyles").text(tempMod.STYLES);
					}
				}

				//javascript objects can have an afterPaginate callback, ex
				//galleryImageMIObj.prototype.afterPaginate = "doSomething();";
				if(typeof pagAjax.afterPaginate !== "undefined"){
					try{ 
						//this.afterPaginate can be a string of a function object
						if(typeof pagAjax.afterPaginate === "string"){
							(new Function(pagAjax.afterPaginate))();
						}
						else{
							pagAjax.afterPaginate();
							
							//call standard extra scripts after ajax call
							extraScripts();
						}
					}
					catch(e){
						//Account for a possible error, maybe call default...
					}
				}
			}
			//using history from a page without the paginate container. do upc instead
			else{
				//get pageID from requestParams
				var pgID = getParameterByFromString("pageID",thisDiv);
				//update page without history, since its the paginate we want in the history
				//upc(pgID,pagAjax.requestParams,false);
				upc(prevPage,pagAjax.requestParams,false);
			}
			
			if($("#mfp-" + pagAjax.moduleClassName + " .pgcClicked + .pgcHidden").length > 0){
				pagAjax.modObj.nextPrevPages(1);
			}
			
			/*refresh the pagination - doesn't work on level 2 modules
			put in the pagAjax because we set a session variable on that 
			ajax request that our pagination refresh uses*/
			if(pagAjax.refreshPag){
				var pagNavAjax = ajaxObj();
				
				//attach the class name to the ajax obj so we can use it in the onreadystatechange function
				pagNavAjax.moduleClassName = pagAjax.moduleClassName;
				
				pagNavAjax.onreadystatechange=function(){
					//don't need to do if we're doing a upc
					if($s("mfp-" + pagAjax.moduleClassName)){
						if(pagNavAjax.readyState===4) {
							$s("mfp-" + pagAjax.moduleClassName).innerHTML = pagNavAjax.responseText;
						}
					}
				}
				
				ajaxPost(
					pagNavAjax,
					"/public/moduleFrame/modulePaginate.php",
					pagAjax.requestParams,
					true,
					0,
					null,
					0
				);
			}
		}
	}
			
	//regular pagination
	if(document.getElementById("mfmcc-" + pagAjax.moduleClassName)){
		ajaxPost(
			pagAjax,
			"/public/moduleFrame/moduleInstanceSet.php",
			pagAjax.requestParams,
			true,
			0,
			null,
			pagAjax.historyTrack
		);
	}
	//using history from a page without the paginate container. do upc instead
	else{
		if(!isset("tempParams")) {
			tempParams = "";
		}
		document.location = document.URL + "/" + tempParams;
		location.reload();
		return true;
	}
}

//go up/down a pagination page
stealthCommon.prototype.nextPrevPagPage = function(pagePageDir,requestParams){

	//next page
	if(pagePageDir && (parseInt(this.pagPage) < parseInt(this.maxPagPage))){
		this.pagPage++;
		requestParams = repSubstr(
            requestParams,'%22pagPage%22%3A%22ppToken%22','"pagPage":"' + this.pagPage + '"'
        );
		
		window[this.moduleClassName].paginateModule(
			requestParams,
			$s("pgc-" + this.moduleClassName + "-" + this.pagPage),
			this.pagPage,
			false,
			true
		);
	}
	//previous page
	else if(!pagePageDir && (parseInt(this.pagPage)-1 > 0)){
		this.pagPage--;
		requestParams = repSubstr(
            requestParams,'%22pagPage%22%3A%22ppToken%22','"pagPage":"' + this.pagPage + '"'
        );
		
		window[this.moduleClassName].paginateModule(
			requestParams,
			$s("pgc-" + this.moduleClassName + "-" + this.pagPage),
			this.pagPage,
			false,
			true
		);
	}

}

//show the desired pagination page links
stealthCommon.prototype.nextPrevPages = function(pagePageDir){
	
	//get the first visible page link
	var firstEl = $(".pgc.pgcVisible").first();
	//get the last visible page link
	var lastEl = $(".pgc.pgcVisible").last();
	
	//hide all the page links
	$(".pgc").removeClass("pgcVisible").addClass("pgcHidden");		
			
	//show next set of page links
	if(pagePageDir) {		
		//show the paginateLinkQty qty of siblings for lastEl element
		for(var x = 1; x <= this.paginateLinkQty; x++){
			$(lastEl).next().removeClass("pgcHidden").addClass("pgcVisible");
			lastEl = $(lastEl).next();
		}
	}
	else{
		//show the paginateLinkQty qty of siblings for lastEl element
		for(var x = 1; x <= this.paginateLinkQty; x++){
			$(firstEl).prev().removeClass("pgcHidden").addClass("pgcVisible");
			firstEl = $(firstEl).prev();
		}
	}
	
	//get the first visible page link
	var firstEl = $(".pgc.pgcVisible").first();
	//get the last visible page link
	var lastEl = $(".pgc.pgcVisible").last();

	//check to see if we should hide or show the next/previous buttons
	if($(firstEl).prevAll(".pgc").length < 1){
		$s("mfprvi-" + this.moduleClassName).style.display = "none";
	}
	else{
		$s("mfprvi-" + this.moduleClassName).style.display = "inline-block";
	}
	
	if($(lastEl).nextAll(".pgc").length < this.paginateLinkQty){
		$s("mfni-" + this.moduleClassName).style.display = "none";
	}
	else{
		$s("mfni-" + this.moduleClassName).style.display = "inline-block";
	}
}

//modules items be click slid should be float:left position:relative
stealthCommon.prototype.clickSlide = function(slideDir,childSlideClass,thisThumb){

	if(this.slideFinished){
		this.slideFinished = false;	
		//main module frame				
		var mf = $s("mfmcc-" + this.moduleClassName); 
		//storage container
		var ms = $s("clss-" + this.moduleClassName); 
		//current visible objects
		var cObjs = $("#mfmcc-" + this.moduleClassName + " .mi-" + this.moduleClassName); 
		//objects in storage
		var stObjs = $("#clss-" + this.moduleClassName + " .mi-" + this.moduleClassName); 		
		var tempModClass = this.moduleClassName;
		var tempModChildClass = childSlideClass;
		var tempChangeEffectDuration = this.changeEffectDuration;
		var tempEffectEasing = this.effectEasing;

		if(this.slideAxis == 0){
			//the base of where our new elements are positioned, and how far they slide				
			var slideDistance = mf.offsetWidth;
			
			//distance left or right
			if(slideDir) slideDistance = slideDistance * -1;
			
			//we're always accessing the first item, since we're removing them
			for(var i = 0; i < this.holdQty; i++){
				//create temp objs if stObjs is empty
				if(!stObjs[0]){
				
					//properties of temp dom object
					var tID = this.moduleClassName + "tmpObj" + i;
					var tClass = cObjs[i].className + " tmpObj";
					
					//create DOM object with jquery
					var tmpSObj = $('<div class="' + tClass + '" id="' + tID + '"></div>');
										
					tmpSObj = tmpSObj.get(0);
				}
				else if(slideDir) {
					tmpSObj = stObjs[0];
				}
				else {
					tmpSObj = stObjs[stObjs.length-1];
				}
				
				//style of the object we're sliding
				var tSt = tmpSObj.style; 

				if(slideDir){
					
					//place the element in the module frame
					mf.appendChild(tmpSObj); 
					
					//set the height and width of any empty js created tmp divs
					if(!stObjs[0]){
						$(tmpSObj).height($(tmpSObj).prev().height());
						$(tmpSObj).width($(tmpSObj).prev().width());
					}
					
					tSt.position = "absolute";
					tSt.top = cObjs[i].offsetTop - parseInt(cObjs.eq(i).css("marginTop")) + "px";
					//how far it should be offset
					tSt.left = mf.offsetWidth + cObjs[i].offsetLeft  - parseInt(cObjs.eq(i).css("margin-left")) + "px"; 
				}
				else{
										
					//place the element in the module frame
					mf.insertBefore(tmpSObj,cObjs[0]); 
					
					//set the height and width of any empty js created tmp divs
					if(!stObjs[0]){
						$(tmpSObj).height($(tmpSObj).prev().height());
						$(tmpSObj).width($(tmpSObj).prev().width());
					}
					
					tSt.position = "absolute";
					tSt.top = cObjs[i*2].offsetTop - parseInt(cObjs.eq(i*2).css("marginTop")) + "px";
					//how far it should be offset
					var tempoffsetLeft = cObjs[i*2].offsetWidth + cObjs[i*2].offsetLeft + parseInt(cObjs.eq(i*2).css("margin-left"));

					tSt.left = (tempoffsetLeft * -1) + "px";
				}
				
				var cObjs = $("#mfmcc-" + this.moduleClassName + " .mi-" + this.moduleClassName); 
				var stObjs = $("#clss-" + this.moduleClassName + " .mi-" + this.moduleClassName);	
				//thumb equivalent obj
				var tObjs = $("#mfmcc-" + this.childClassName + " .mi-" + this.childClassName); 
				
				//visible element's priKeyID from id attr
				var tmpSObjPriKeyID = tmpSObj.id.substring(tmpSObj.id.lastIndexOf("-")+1,tmpSObj.id.length);
				
				//look for current element's equivalent in thumb mfmc and set its selected class
				for(var t = 0; t < tObjs.length; t++){
					tObjs[t].className = repSubstr(tObjs[t].className,"clicked","");
					if(tObjs[t].id.indexOf(tmpSObjPriKeyID) != -1) {
						tObjs[t].className = tObjs[t].className + " clicked";
					}
				}
			}	

			/*when we are doing multiple images at once, the callback of the first ones
			  finish before the later effects even start. use use this counter to keep track 
			  of where we're at so we can do what we need in the callback on the last effect*/
			var tempCount = tempHq = this.holdQty * 2;

			for(var b = 0; b < tempHq; b++){
				if(cObjs[b]){
					cObjs.eq(b).animate(
						{left:"+=" + slideDistance},
						{
							//why doesn't this work without eval? - jared
							duration:eval(tempChangeEffectDuration),
							easing:eval(tempEffectEasing),
							complete:function(){
								tempCount--; //counter to keep track of what effect we're on
								
								if(!tempCount){ //reset styling, push elements back into storage
									var cObjs = $("#mfmcc-" + tempModClass + " .mi-" + tempModClass); 
									var stObjs = $("#clss-" + tempModClass + " .mi-" + tempModClass);

									for(var s = 0; s < tempHq; s++){
										//elements going into storage
										if(s < window[tempModClass].holdQty){
											if(slideDir){
												var tempCoStyle = cObjs[0].style;
												tempCoStyle.top = tempCoStyle.right = tempCoStyle.left = "auto";
												tempCoStyle.position = "relative";
												ms.appendChild(cObjs[0]);
											}
											else{
												var thisObjLoc = cObjs.length-1;
												var tempCoStyle = cObjs[thisObjLoc].style;
												tempCoStyle.top = tempCoStyle.right = tempCoStyle.left = "auto";
												tempCoStyle.position = "relative";
												
												//the storage container might be empty if the holdQty is the 
												//same as the number of elements in the storage container
												if(stObjs[0]) {
													ms.insertBefore(cObjs[thisObjLoc],stObjs[0]);														
												}
												else {
													ms.appendChild(cObjs[thisObjLoc]);
												}
											}
											var cObjs = $("#mfmcc-" + tempModClass + " .mi-" + tempModClass); 
											var stObjs = $("#clss-" + tempModClass + " .mi-" + tempModClass);
										}
										//visible items
										else{
											var thisObjLoc = s-window[tempModClass].holdQty;
											var tempCoStyle = cObjs[thisObjLoc].style;
									
											tempCoStyle.top = tempCoStyle.right = tempCoStyle.left = "auto";
											tempCoStyle.position = "relative";
											//last item
											if(s===tempHq-1){
												window[tempModClass].slideFinished = true;
												//if a child thumb nail is clicked
												if(tempModChildClass) {
													window[tempModChildClass].parentSlide(thisThumb);
												}
											}
										}
									}//loop through pushing hidden elements
								}//counter for what effect we're on																						
							}//jquery call back function
						}//jquery animate options
					);//jquery animate effect
				}//if the element exists
				else break;
			}//if element in for loop exists
		}//for loop
	}//if slideFinished
} //clickSlide function closer
	
stealthCommon.prototype.parentSlide = function(thisDiv){

	var tempClass = $(".mfmcc").find('div[id*="mfmcc-' + this.parentClassName + '"]');
		/*.parents(".mfmc") //get this elements root .mfmc
		.prev(".mfmc") // get the parent of the parentClassName, must be the parents prev sibling
		.find('div[id^="mfmcc-' + this.parentClassName + '"]'); //and get the parenClassName container*/
		
	var tempParentElement = tempClass.get(0).id;
	var tempParentClassName = repSubstr(tempParentElement,"mfmcc-","");

	var parentItem = $s(repSubstr(thisDiv.id,this.moduleClassName,tempParentClassName));
	var parentFrame = $s("mfmcc-" + tempParentElement);

	//clear thumb click style			
	var thisThumbs = $(".mi-" + this.moduleClassName); 
	var thumbQty = thisThumbs.length;
	
	$(parentFrame).find(".clicked").removeClass("clicked");
	$(thisDiv).addClass("clicked");
	
	//check if the correct item is in its parent
	if(parentItem.parentNode.id !== "mfmcc-" + tempParentClassName) {
		window[tempParentClassName].clickSlide(1,this.moduleClassName,thisDiv);
	}
}
//fadeDir - order of elements to fade through
stealthCommon.prototype.fadeRotate = function(fadeDir){
	//try/catch is primarily incase we're in mid fade when we change pages
	try{
		if(this.slideFinished){
			this.slideFinished = false;		
			var mf = $s("mfmcc-" + this.moduleClassName); //main module frame
			var ms = $s("clss-" + this.moduleClassName); //storage container
			var cObjs = $("#mfmcc-" + this.moduleClassName + " .mi-" + this.moduleClassName); //current visible objects
			var stObjs = $("#clss-" + this.moduleClassName + " .mi-" + this.moduleClassName); //objects in storage
			var tempModClass = this.moduleClassName;
			var tempChangeEffectDuration = this.changeEffectDuration;
			var tempEffectEasing = this.effectEasing;
			if(stObjs.length === 0) return true;
			//make the child transparent and give it the same positioning 
			//properties as the element currently in the module container
			for(var x = 0; x<this.holdQty; x++){
				var sCnt = fadeDir ? 0 : stObjs.length+x-this.holdQty;
							
				//if there are more items in the cObj than the stObj we need to make place holder items
				if(!isset(stObjs[sCnt])) {
					//create DOM object with jquery
                    var newAppend = $('<div class="' + cObjs[x].className + " tmpObj" + '" id="' + this.moduleClassName + "tmpObj" + x + '"></div>');                    
                    
					newAppend = newAppend.get(0);
				}
				else {
					var tempPos = cObjs.eq(0).css("position");
                    
                    if(tempPos === "relative" || tempPos === "absolute"){
                        tempPos = "absolute";
                    }
                    else if(tempPos === "fixed"){
                        tempPos = "fixed";
                    }

					var newAppend = stObjs[sCnt];		
					newAppend.style.opacity = 0;
					newAppend.style.position = tempPos;
					newAppend.style.left = $(cObjs[x]).position().left + "px";
					newAppend.style.top = $(cObjs[x]).position().top + "px";
				}
	
				mf.appendChild(newAppend);//append it in the container
	
				//jquery doesn't use live references like native getElementByClassName
				//once MSIE 9 is the lowest we support, change to getElementByClassName
				cObjs = $("#mfmcc-" + this.moduleClassName + " .mi-" + this.moduleClassName); 
				stObjs = $("#clss-" + this.moduleClassName + " .mi-" + this.moduleClassName);
			}
			
			var tempHq = this.holdQty;
			var tempCount = this.holdQty;
			
			//effect type
			if(this.instanceDisplayType == 0){
				var transEff = "fadeTo";
				var newElFrom = 0;
				var oldElTo = 0;
				var newElTo = 1;
				var oldElFrom = 1
			}
					
			for(var x = 0; x<this.holdQty; x++){
				
				//thumb equivalent obj
				var tObjs = $("#mfmcc-" + this.childClassName + " .mi-" + this.childClassName); 			
				//visible element's priKeyID from id attr
				var cObjPriKeyID = cObjs[this.holdQty + x].id.substring(cObjs[this.holdQty + x].id.lastIndexOf("-")+1,cObjs[this.holdQty + x].id.length);

				//look for current element's equivalent in thumb mfmc and set its selected class
				for(var t = 0; t < tObjs.length; t++){
					tObjs[t].className = repSubstr(tObjs[t].className,"clicked","");
					
					//get the id of this module items thumbnail
					var tempThumbID = repSubstr(
						cObjs[this.holdQty + x].id,
						this.moduleClassName,
						this.childClassName
					);
					
					if(tempThumbID == tObjs[t].id) {
					//if(tObjs[t].id.indexOf(cObjPriKeyID) != -1) {
						tObjs[t].className = tObjs[t].className + " clicked";
					}
				}
				
				//for some unknown reason the tempChangeEffectDuration needs eval or it doesn't work? - jared
				cObjs.eq(this.holdQty + x)[transEff](
					eval(tempChangeEffectDuration),
					newElTo,
					tempEffectEasing,
					function(effect){
						try{
							$(this).css({left:"",top:"",position:"",opacity:""});
						}
						catch(e){}
					});
				cObjs.eq(x)[transEff](
					eval(tempChangeEffectDuration),
					oldElTo,
					tempEffectEasing, 
					function(effect){
						//try/catch is primarily incase we're in mid fade when we change pages
						try{
							tempCount--;
							//we need place this item into storage
							//if its the last one move faded into storate
							//if its a tmpObj, delete it
							if(!tempCount){
								for(var z = 0; z<tempHq; z++){
									var cObjs = $("#mfmcc-" + tempModClass + " .mi-" + tempModClass);
									var stObjs = $("#clss-" + tempModClass + " .mi-" + tempModClass);
		
									if(fadeDir) ms.appendChild(cObjs[0]);
									else{
										if(stObjs[0]) ms.insertBefore(cObjs[0],stObjs[z]);
										else ms.appendChild(cObjs[0]);
									}
									var cObjs = $("#mfmcc-" + tempModClass + " .mi-" + tempModClass);
									var stObjs = $("#clss-" + tempModClass + " .mi-" + tempModClass);										
								}
							}
							
							window[tempModClass].slideFinished = true;
							}
						catch(e){
						}
					}//callback
				);//effect
			}//for loop
		}//if our previous effect is finised
	}//try/catch
	catch(e){
	}
}

stealthCommon.prototype.parentFade = function(thisDiv){

	//gets the .mfmcc of the parent we are controlling
	var parentDiv = $("#" + thisDiv.id).parent().parent().prev().children(".mfmcc").get(0);
		
	var tempParentElement = parentDiv.id;
	
	//gets the parent class name even if its a level 2 or greater module
	var tempParentClassName = repSubstr(tempParentElement,"mfmcc-","");
	var parentItem = $s(repSubstr(thisDiv.id,this.moduleClassName,tempParentClassName));

	//parent module JS object
	var po = window[tempParentClassName]; 

	if(po.slideFinished){
		po.slideFinished = false;
				
		//main module frame
		var mf = $s("mfmcc-" + tempParentClassName); 
		//storage container
		var ms = $s("clss-" + tempParentClassName); 
		
		var tempClassName = this.moduleClassName;
				
		//current visible objects
		var cObjs = $("#mfmcc-" + tempParentClassName + " .mi-" + tempParentClassName); 
		
		//objects in storage
		var stObjs = $("#clss-" + tempParentClassName + " .mi-" + tempParentClassName); 

		//if the desired image isn't the one already been displayed or currently fading in
		if($("#mfmcc-" + tempParentClassName).has("#" + parentItem.id).length == 0){

			//backup the declared position of the element
			po.tempPos = $(cObjs[0]).css("position");
			po.tempLeft = $(cObjs[0]).css("left");
			po.tempRight = $(cObjs[0]).css("right") ;
			po.tempTop = $(cObjs[0]).css("top");
			po.tempBottom = $(cObjs[0]).css("bottom");

			parentItem.style.opacity = 0;
			parentItem.style.position = "absolute";
			parentItem.style.left = $(cObjs[0]).position().left + "px";
			parentItem.style.right = $(cObjs[0]).position().right + "px";
			parentItem.style.top = $(cObjs[0]).position().top + "px";
			parentItem.style.bottom = $(cObjs[0]).position().bottom + "px";

			/*insertCurrent - the location in the storage that we are placing the previous div
			  this.currIndex - the location that the now visible one belongs in the storage
			  figure out the index of the item currently being displayed in the parent*/
			if(!isset(po.currIndex)) {
				po.currIndex = 0;
			}
				
			//loop through the storage to find out the index of our desired item
			var tempStorLen = stObjs.length;
			for(var x = 0; x < tempStorLen; x++){
				if(stObjs[x].id === parentItem.id){
					po.currIndex = x;
					break;
				}
			}
			
			//append it in the container
			mf.appendChild(parentItem); 
			
			//jquery doesn't use live references like native getElementByClassName
			//once MSIE 9 is the lowest we support, change to getElementByClassName
			cObjs = $("#mfmcc-" + tempParentClassName + " .mi-" + tempParentClassName); 
			stObjs = $("#clss-" + tempParentClassName + " .mi-" + tempParentClassName);

			var tempHQ = po.holdQty;
			
			//clear thumb click style
			$(".mi-" + this.moduleClassName).removeClass("clicked"); 
			$(thisDiv).addClass("clicked");
			
			//reference the jquery object, not the DOM object
			for(var x = 0; x<tempHQ; x++){
				//needs square brackets for the object params
				cObjs.eq(po.holdQty + x).fadeTo(
					eval(this.changeEffectDuration),
					1,
					eval(this.effectEasing),
					function(){
						//restore the position of the element that faded in
						this.style.position = po.tempPos;
						this.style.left = po.tempLeft;
						this.style.right = po.tempRight;
						this.style.top = po.tempTop;
						this.style.bottom = po.tempPos;
					}
				);
				cObjs.eq(x).fadeTo(
					eval(this.changeEffectDuration),
					0,
					eval(this.effectEasing),
					function(){
						ms.appendChild(this);
						
						//prevents thumb controls and parent left/right from getting out of sync
						this.style.display = "block";						

						//place all the children before the selected one 
						//behind it so the left/right arrows still work
						for(var y = 0; y < po.currIndex; y++) {
							ms.appendChild(stObjs[0 + y]);
						}
						po.slideFinished = true;
					}
				);
			}
		}
		else{
			po.slideFinished = true;
		}
	}
}

stealthCommon.prototype.disQtyChange = function(thisSelect, urlParams){
	
	//get the qty the user wants to see
	var tmpDspQty = $(thisSelect).val();

	//add the display qty to the params if it isn't in there
	if(urlParams.indexOf("displayQty") === -1){
		urlParams = repSubstr(urlParams, 'ppToken%22', 'ppToken%22,%22displayQty%22:' + tmpDspQty);
	}

	//update the display qty to what the user selected
	urlParams = urlParams.replace(/(displayQty"):\d+/gm,"$1:" + tmpDspQty);

	var navObj = isset("atpto_adminTopNav") ? atpto_adminTopNav : atpto_tNav;

	navObj.toggleBlind(
		pageID,
		true,
		'upc(' + pageID + ',\'' + urlParams + '\');',
		'ntid_adminTopNav' + pageID
		,""
	);
}

//add another record from the add/edit form
stealthCommon.prototype.addAnother = function(modPageID, modParams){
	
	var conf = confirm("Do you want to add another? Unsaved changes will be lost");
	
	if(conf){
		if(isset(this.isModOnline)) {
			var onlineCheck = this.isModOnline;
		}
		//not specified by the module, check for connectivity
		else{
			var onlineCheck = this.isOnline();
		}

		if(onlineCheck){
			upc(modPageID,modParams);
		}
		else{
			document.location = "/index.php?pageID=" + modPageID + modParams;
		}
	}
	else{
		return false;
	}
	
}

//submit user rating vote, value is the rating value
stealthCommon.prototype.moduleRating = function(value){
	
	var rateAjax = ajaxObj();
	var moduleParams = "function=addRating&v=" + value + "&r=" + this.priKeyID + "&m=" + this.moduleID;
	
	rateAjax.onreadystatechange=function(){
		if(rateAjax.readyState===4){
			
			//return -1 if the user has already voted
			if(rateAjax.responseText == -1){
				alert("Only one vote per item");
			}
		}
	}
	
	//send request
	ajaxPost(
		rateAjax, //XMLHTTPRequest Object
		"/cmsAPI/module/moduleRecordRating.php", //API Path
		moduleParams, //url params
		true, //async
		0, //GET
		false, //text/html
		false //track history
	);
}

stealthCommon.prototype.getGalleryImages = function(){
	var galID = $("#" + this.formID + " select[name=imageGalleryID]").val();
	var galleryAjax = ajaxObj();
	
	//attach the formID so we can use it in our ajax callback
	galleryAjax.formID = this.formID;
    
	galleryAjax.onreadystatechange=function(){
		if(galleryAjax.readyState==4) {
			var imgObj = JSON.parse(galleryAjax.responseText);
			$("#" + this.formID + " select[name=galleryImageID]").text("");

			//update our select with new provinces and states
			for(var z in imgObj){
				var optionAtt = imgObj[z]["imgCaption"];
                var optionVal = imgObj[z]["priKeyID"];
				
				$('<option>').val(optionVal).text(optionAtt).appendTo("#" + galleryAjax.formID + " select[name=galleryImageID]");
			}
		}
	}
	
	var requestParams = 'function=getConditionalRecord&a={ "0":"galleryID","1":"' + galID + '","2":"true"}';
	
	ajaxPost(
		galleryAjax,
		"/cmsAPI/gallery/galleryImages.php",
		requestParams,
		true,
		0,null,false
	);	

}

function showTimePicker(timeField){
	//destroy any existing instances
	$(timeField).scroller('destroy');
	
	//create a new scroller that fits well for the window size
	var temp = $(timeField).scroller({
		preset: 'time',
		mode: "scroller",
		display: "modal",
		width:$(window).width()*0.25,
		height:$(window).height()*0.20,
		stepMinute:15
	});

	//display the scroller
	$(timeField).scroller('show');
}

//get the url param from a string
function getParameterByFromString(name,urlParamString){
	name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	var regexS = "[\\?&]" + name + "=([^&#]*)";
	var regex = new RegExp(regexS);
	var results = regex.exec(urlParamString);
	if(results == null)  return "";
	else return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function clearField(textField){
	if(textField.defaultValue == textField.value) textField.value = "";
}

function backToDefault(textField){
	if(textField.value == "") textField.value = textField.defaultValue;
}

//adds onfocus and onblur event handlers to all text fields within an element which call the functions: "clearField" and "backToDefaut" respectively
function activateShowHideFields(elID){
	var inputs = $s(elID).getElementsByTagName("input");
	var textareas = $s(elID).getElementsByTagName("textarea");
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].type == "text"){
			inputs[i].onfocus = function(){
				clearField(this);
			}
			inputs[i].onblur = function(){
				backToDefault(this);
			}
		}
	}
	for(var i = 0; i < textareas.length; i++){
		textareas[i].onfocus = function(){
			clearField(this);
		}
		textareas[i].onblur = function(){
			backToDefault(this);
		}
	}
}

function getProvStates(provStateFieldID,countryFieldID){
	var provAjax = ajaxObj();
	var countryCode = $s(countryFieldID).value;
	provAjax.provStateFieldID = provStateFieldID;
	
	provAjax.onreadystatechange=function(){
		//clear out existing provinces and states
		$s(provAjax.provStateFieldID).innerHTML = "";
		
		if(provAjax.readyState===4){
			var provObj = JSON.parse(provAjax.responseText);
			
			//update our select with new provinces and states
			for(var z in provObj){	
				//create DOM object with jquery
				var tmpSObj = $("#" + provAjax.provStateFieldID).append('<option id="provState' + provObj[z]["priKeyID"] + '" value="' + provObj[z]["priKeyID"] + '">' + provObj[z]["provState"] + '</option>');
			}
		}	
	}
	
	/*fetch provinces and states for selected country - pass JSON to become php array
	the cart uses the countryCode, the users module uses the countryID... determine which param to use*/
	if(isNumeric(countryCode)) var queryField = "countryID";
	else var queryField = "countryCode";

	var requestParams = 'function=getConditionalRecord&a={ "0":"' + queryField + '","1":"' + countryCode + '","2":"true"}';	
	ajaxPost(provAjax,"/cmsAPI/location/provState.php",requestParams,true,0,null,false);
}

function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // IE 12 => return version number
       return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}

function setGalleryFancyBox(){
	$('.fancyBoxLink').fancybox({
		openEffect	: 'none',
		closeEffect	: 'none',
		showNavArrows : true,
		showCloseButton : true,
		opacity: true,
		helpers: {
			overlay: {
				locked: false
			}
		},
		//enable swiping on touch devices. doesn't detect in windows 10
		afterShow: function() {
			if ('ontouchstart' in document.documentElement){
				$('.fancybox-nav').css('display','none');
				$('.fancybox-wrap').swipe({
					swipe : function(event, direction) {
						if (direction === 'left' || direction === 'up') {
							$.fancybox.prev( direction );
						} else {
							$.fancybox.next( direction );
						}
					}
				});
			}
		}

	});
}

function setPhoneTrack(){
	$('a[href^="tel:"]').on("click", function(){			
			gaTrack(
			"event", 
			{
				"eventCategory":"Phone",
				"eventAction":"Clicked " + $(this).attr("href"),
				"eventLabel":"Page - " +pageArray[pageID].name
			}
		);
		}
	);
}

function precise_round(num,decimals){
	var sign = num >= 0 ? 1 : -1;
	return (Math.round((num*Math.pow(10,decimals))+(sign*0.001))/Math.pow(10,decimals)).toFixed(decimals);
}

function animatedScroll(el) {
	var target = "#" + el;
	$('html,body').animate({
		scrollTop: ($(target).offset().top - 100)},
		'slow');
}
///////////////////////////////////////////////////////////////
function sendContactFormValues(formObj,formPriKeyID,activeRecaptcha){
	
	//close any existing open modal messages
	$(".modal-formError").fadeOut().remove();
	
	var formAjax = ajaxObj();//check to see if our form has valid data
	var formCompleted = formObj.validate().form();
	
	if(formCompleted){
		
		if (activeRecaptcha === 1) {
			var response = grecaptcha.getResponse();
			
			if(response.length == 0){
				var formMsg = "<span class='modalValidMsg'>Please verify that you are not a robot.</span>";
				buildModal("formSuccess",formMsg,null,true,true,1,null,null,440); //Display a modal dialog
				activeRecaptcha = 3;
			}
			else {
				activeRecaptcha = 2;
			}
		}
		if (activeRecaptcha !== 3) {
			
			var fd = new FormData();
			
			// for multiple files
			if($('#fileToUpload').length) {
				var ins = document.getElementById('fileToUpload').files.length;
				for (var i = 0; i < ins; i++) {
					fd.append("file" + i, document.getElementById('fileToUpload').files[i]);
				}
			}

			var other_data = formObj.serializeArray();		
			$.each(other_data,function(key,input){
				
				fd.append(input.name,input.value);
			});
			
			//extra parameter so we know we're sending the form value from this script
			//should prevent blank forms from being sent
			fd.append("scriptSend","1");
			
			fd.append("formPriKeyID",formPriKeyID);
			
			console.log('other data ',other_data);
			console.log('formdata ',fd);

			formAjax.formObj = formObj;
			formAjax.onreadystatechange=function(){
				if(formAjax.readyState===4){
					var formSubmittedMsg = "<span class='modalValidMsg'>Your information has been submitted!<br /><span class='smaller'>Click anywhere to hide this message.</span></span>";
					buildModal("formSuccess",formSubmittedMsg,null,true,true,1,null,null,440); //Display a modal dialog
					formObj[0].reset();
					if (activeRecaptcha === 2) {
						grecaptcha.reset();
					}
					return true;
				}
			};

			/*in the future maybe we can expand on this 
			and see how many people drop out of forms?*/
			gaTrack(
				"event", 
				{
					"eventCategory":"Form",
					"eventAction":"Form Submitted",
					"eventLabel":"Page - " + pageArray[pageID].name
				}
			);
			

			formAjax.open("POST","/public/sendFormNew.php",true);
			formAjax.setRequestHeader("Content-length", fd.length);
			formAjax.setRequestHeader("Connection", "close");

			try{
				formAjax.send(fd);
			}
			catch(e){
				/*probably no internet connectoin, return 
				404 so we store form info in local storeage*/
				ajaxObject.status = 404;
			}	

			return false;
		}
	}
}