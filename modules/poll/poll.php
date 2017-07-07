<?php

	Header("content-type: application/x-javascript");

?>

var pollOptionNumber = 1;

var pollSubOptionNumber = 1;



var apiPath = "/cmsAPI/poll/poll.php";

var moduleAlert = "Poll";



var ckEditArray = new Array();

ckEditArray[""] = "";

			

function setQforms(){

	moduleFormObj = new qForm("moduleForm");

	moduleFormObj.required("pollQuestion");

	moduleFormObj.pollQuestion.description = "Poll Question";

	

	<?php

		include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/poll.php");

		include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollOption.php");

		include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/poll/pollSubOption.php");

		

		$pollObj = new poll(false);

		$pollOptionObj = new pollOption(false);

		$pollSubOptionObj = new pollSubOption(false);

		

		if(isset($_GET["recordID"])){

			$polls = $pollObj->getRecordByID($_GET["recordID"]);

			$pollOptions = $pollOptionObj->getConditionalRecord(array("pollID",$_GET["recordID"],true));

			$pollSubOptions = $pollSubOptionObj->getConditionalRecord(array("pollID",$_GET["recordID"],true));

		}

								

		if(isset($pollOptions)){

			$pollOptionNumber = 1;

			$pollSubOptionNumber = 1;

			

			

			while($x = mysqli_fetch_array($pollOptions)){

				echo "

				moduleFormObj.addField('pollOptionDesc' + " . $pollOptionNumber .");

				/*set descriptions*/

				moduleFormObj.pollOptionDesc" . $pollOptionNumber .".description='Poll Option Description " . $pollOptionNumber . "';

				moduleFormObj.required('pollOptionDesc" . $pollOptionNumber . "');

				";

				$pollOptionNumber +=1;

			}

			

			while($y = mysqli_fetch_array($pollSubOptions)){

				echo "

				moduleFormObj.addField('pollSubOptionDesc' + " . $pollSubOptionNumber .");

				/*set descriptions*/

				moduleFormObj.pollSubOptionDesc" . $pollSubOptionNumber .".description='Poll Sub-Option Description " . $pollSubOptionNumber . "';

				moduleFormObj.required('pollSubOptionDesc" . $pollSubOptionNumber . "');

				";

				$pollSubOptionNumber +=1;

			}

			

			echo "pollOptionNumber = " . $pollOptionNumber . ";";

			echo "pollSubOptionNumber = " . $pollSubOptionNumber . ";";

		}

		

	?>



}



function anotherOption(){



	//new divs to organize it in

	pollOptionsGroupContainer = buildHtml.createDivHTMLElement(

																"pollOptionDiv" + pollOptionNumber,

																"moduleSubElement",

																null,

																null,

																"pollOptionsContainer"

																);

	

	//append newly created DOM elements to the existing container

	newPollOptionDiv =  buildHtml.createDivHTMLElement(

														"pollOpGrp"+ pollOptionNumber,

														null,

														null,

														null,

														"pollOptionDiv" + pollOptionNumber

														);

	

	//create the new text fields

	pofL =  buildHtml.createHTMLFieldCaption(

											"Poll Option Description " + pollOptionNumber + ":",

											"pollOpGrp"+ pollOptionNumber

											);

											

	pof = buildHtml.createTextHTMLElement(

											"pollOptionDesc" + pollOptionNumber,

											null,

											75,

											255,

											"pollOpGrp"+ pollOptionNumber,

											null,

											"pollOptionDesc"

											);

											

	idf = buildHtml.createHiddenHTMLElement(

											"pollOptionID" + pollOptionNumber,

											0,

											"pollOpGrp"+ pollOptionNumber

											);

											

	cntf = buildHtml.createHiddenHTMLElement(

											"optionCounter" + pollOptionNumber,

											0,

											"pollOpGrp"+ pollOptionNumber

											);

											

	removeButton = buildHtml.createButtonHTMLElement(

													"removeButton" + pollOptionNumber,

													"",

													"moduleFormObj.required('pollOptionDesc" + pollOptionNumber + "',false);removePollOption(" + pollOptionNumber + ");buildHtml.removeElement('" + "pollOptionDiv" + pollOptionNumber + "');",

													"pollOpGrp"+ pollOptionNumber,"modSubElRem"

													);

		

	//update qforms

	moduleFormObj.addField("pollOptionDesc" + pollOptionNumber);

	//set descriptions

	moduleFormObj["pollOptionDesc" + pollOptionNumber].description = "Poll Option" + pollOptionNumber;

	//make the appropriate required fields

	moduleFormObj.required("pollOptionDesc" + pollOptionNumber);

		

	pollOptionNumber++;

	

}



function anotherSubOption(){

	

	//new div to organize it in

	pollSubOptionsGroupContainer = buildHtml.createDivHTMLElement(

																"pollSubOptionDiv" + pollSubOptionNumber,

																"moduleSubElement",

																null,

																null,

																"pollSubOptionsContainer"

																);

																

	//append newly created DOM elements to the existing container

	newPollSubOptionDiv =  buildHtml.createDivHTMLElement(

															"pollSubOpGrp"+ pollSubOptionNumber,

															null,

															null,

															null,

															"pollSubOptionDiv" + pollSubOptionNumber

															);

	

	//create the new text fields

	pofL =  buildHtml.createHTMLFieldCaption(

											"Poll Sub-Option Description " + pollSubOptionNumber + ":",

											"pollSubOpGrp"+ pollSubOptionNumber

											);

											

	psof = buildHtml.createTextHTMLElement(

											"pollSubOptionDesc" + pollSubOptionNumber,

											null,

											75,

											255,

											"pollSubOpGrp"+ pollSubOptionNumber,

											null,

											"pollSubOptionDesc"

											);

											

	idf = buildHtml.createHiddenHTMLElement(

											"pollSubOptionID" + pollSubOptionNumber,

											0,

											"pollSubOpGrp"+ pollSubOptionNumber

											);

											

	scntf = buildHtml.createHiddenHTMLElement(

											"subOptionCounter" + pollSubOptionNumber,

											0,

											"pollSubOpGrp"+ pollSubOptionNumber

											);

											

	removeButton = buildHtml.createButtonHTMLElement(

													"removeButton" + pollSubOptionNumber,

													"",

													"moduleFormObj.required('pollSubOptionDesc" + pollSubOptionNumber + "',false);removePollSubOption(" + pollSubOptionNumber + ");buildHtml.removeElement('" + "pollSubOptionDiv" + pollSubOptionNumber + "');",

													"pollSubOpGrp"+ pollSubOptionNumber,

													"modSubElRem"

													);

						

	//update qforms

	moduleFormObj.addField("pollSubOptionDesc" + pollSubOptionNumber);

	//set descriptions

	moduleFormObj["pollSubOptionDesc" + pollSubOptionNumber].description = "Poll Sub-Option" + pollSubOptionNumber;

	//make the appropriate required fields

	moduleFormObj.required("pollSubOptionDesc" + pollSubOptionNumber);

		

	pollSubOptionNumber++;

	

}

		

function addEditPollOptions(){

	var pOptions = document.getElementsByClassName("pollOptionDesc");

	var pSubOptions = document.getElementsByClassName("pollSubOptionDesc");

	

	var pollID = document.getElementById("priKeyID").value;

	

	var pOptionAjax = ajaxObj();

	var pSubOptionAjax = ajaxObj();

	

	//we need to check if we are updating or adding, we can't remove all of them then

	//add them again because they are mapped to votes, so the priKeyID's can't change

	

	pOpQty = pOptions.length;

	

	for(var i = 0; i < pOpQty; i++){

		//DOM identifier for this option

		pOpQtyNum = pOptions[i].id.substring(14,pOptions[i].id.length);

		

		//check if  there is a priKeyID for this option, if there is, update, otherwise, add

		pOpPriKeyID = document.getElementById("pollOptionID" + pOpQtyNum).value;

		

		var modData = new Object();

		

		if(pOpPriKeyID == 0){

			modData["function"] = "addRecord";

		}

		else{

			modData["function"] = "updateRecord";

			modData["priKeyID"] = document.getElementById("pollOptionID" + pOpQtyNum).value;

		}

		

		modData["pollID"] = pollID;

		modData["pollOptionDesc"] = pOptions[i].value;

		

		//toJSON is from the prototype library

		var modJson = "modData=" + encodeURIComponent(Object.toJSON(modData));

		ajaxPost(

				pOptionAjax,

				"/cmsAPI/poll/pollOption.php",

				modJson,

				false,

				1,

				"application/x-www-form-urlencoded"

				);

	}

	

	pSubOpQty = pSubOptions.length;

	

	for(var i = 0; i < pSubOpQty; i++){

		//DOM identifier for this option

		pSubOpQtyNum = pSubOptions[i].id.substring(17,pSubOptions[i].id.length);

		

		//check if  there is a priKeyID for this option, if there is, update, otherwise, add

		pSubOpPriKeyID = document.getElementById("pollSubOptionID" + pSubOpQtyNum).value;



		var modData = new Object();

		

		if(pSubOpPriKeyID == 0){

			modData["function"] = "addRecord";

		}

		else{

			modData["function"] = "updateRecord";

			modData["priKeyID"] = document.getElementById("pollSubOptionID" + pSubOpQtyNum).value;

		}

		

		modData["pollID"] = pollID;

		modData["pollSubOptionDesc"] = pSubOptions[i].value;

		

		//toJSON is from the prototype library

		var modJson = "modData=" + encodeURIComponent(Object.toJSON(modData));

		ajaxPost(

				pSubOptionAjax,

				"/cmsAPI/poll/pollSubOption.php",

				modJson,

				false,

				1,

				"application/x-www-form-urlencoded"

				);

	}



}



function removePollOption(pollOptionNumber){

	var pollOptionAjax = ajaxObj();

	var pollOptionID = document.getElementById("pollOptionID" + pollOptionNumber).value;

	ajaxPost(pollOptionAjax,"/cmsAPI/poll/pollOption.php","function=removeRecordByID&pollOptionID=" + pollOptionID);

}



function removePollSubOption(pollSubOptionNumber){

	var pollSubOptionAjax = ajaxObj();

	var pollSubOptionID = document.getElementById("pollSubOptionID" + pollSubOptionNumber).value;

	ajaxPost(pollSubOptionAjax,"/cmsAPI/poll/pollSubOption.php","function=removeRecordByID&pollSubOptionID=" + pollSubOptionID);

}