;
<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/js/ui.multiselect.js");	
?>
;
publicModulePageMapObj.prototype.construct = function(){
	$("#displayElements<?php echo $_REQUEST["recordID"]; ?>").multiselect();
}

publicModulePageMapObj.prototype.getModuleInfo = function(thisSelect){
	
	//get the display elements for the module
	this.getDisplayElements(thisSelect);
	
	//set the instanceID for our add/edit form for the modules instance table
	this.getmodInsPmpmID(thisSelect.value);
}

//set the instanceID for our add/edit form for the modules instance table
publicModulePageMapObj.prototype.getmodInsPmpmID = function(moduleID){
	var pmpmAjaxObj = ajaxObj();
	
	var requestParams = 'function=getRecordByID&a=' + moduleID;

	ajaxPost(
		pmpmAjaxObj,
		"/cmsAPI/module/module.php",
		requestParams,
		false,null,null,false
	);
	var modInfo = JSON.parse(pmpmAjaxObj.responseText);
	this.modIntID = modInfo.prodIndex0.modInsPmpmID;
}

//setup the instance for the add/edit form instance module
publicModulePageMapObj.prototype.setupInstance = function(){
	this.setupRecord(true,null,
		this.modIntID,
		null,
		{
			inputType:'select',
			inputName:'instanceID', 
			inputDesc: 'instanceDescription'
		}
	);
}

//get the display elements for the module
publicModulePageMapObj.prototype.getDisplayElements = function(thisSelect){

	//setup ajax request
	var pmpmAjaxObj = ajaxObj();
	
	ajaxPost(
		pmpmAjaxObj,
		this.apiPath,
		"function=getDisplayElements&a=" + $(thisSelect).val(),
		false,null,null,false
	);
	
	//clear out old display elements
	$("#" + this.formID + " select[name=displayElements]").find('option').remove();

	//parse server response
	var dom = JSON.parse(pmpmAjaxObj.responseText);
	
	var domEls = dom.domFields;
	
	//populate new display elements as options in select	
	for(var y in domEls){

		//create DOM object with jquery
		$("#" + this.formID + " select[name=displayElements]").append(
			'<option value="' + y + '">' + y + '</option>'
		);
	}
	
	$("#displayElements<?php echo $_REQUEST["recordID"]; ?>").multiselect();
	$(".add-all").trigger("click");
}

//create a css valid class name based off our instance description
publicModulePageMapObj.prototype.createCSSClassName = function(thisField){
	
	//camelize our string
	var cam = camelize(thisField.value);
	
	//only keep alphanumeric characters
	$(this.modForm).find("input[name=className]").val(cam.replace(/[^0-9a-z]/gi, ''));
}

function camelize(str) {
  return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(letter, index) {
    return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
  }).replace(/\s+/g, '');
}
