<?php

Header("content-type: application/x-javascript");



	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/rss/rssChannel.php");

	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/rss/rssItem.php");

	$rssChannelObj = new rssChannel(false);

	$rssItemObj = new rssItem(false);

	

	if(isset($_GET["recordID"])){

		$rssChannel = $rssChannelObj->getRecordByID($_GET["recordID"]);

		$rssItems = $rssItemObj->getConditionalRecord(array("rssChannelID",$_GET["recordID"],true));

	}

?>

var rssNumber = 1;



var apiPath = "/cmsAPI/rss/rssChannel.php";

var moduleAlert = "RSS Feed";



var ckEditArray = new Array();

ckEditArray[""] = "";

			

function setQforms(){

	moduleFormObj = new qForm("moduleForm");

	moduleFormObj.required("title,linkURL,description");

	moduleFormObj.title.description = "RSS Feed\Channel Name";

	moduleFormObj.linkURL.description = "Link\URL";

	moduleFormObj.description.description = "RSS Feed\Channel Description";

	

	<?php							

		if(isset($rssItems)){

			$itemIndex = 1;

			while($x = mysqli_fetch_array($rssItems)){

				echo "

					moduleFormObj.addField('title' + " . $itemIndex .");

					moduleFormObj.addField('description' + " . $itemIndex .");

					/*set descriptions*/

					moduleFormObj.title" . $itemIndex .".description='Title " . $itemIndex . "';

					moduleFormObj.description" . $itemIndex .".description='Description " . $itemIndex ."';

					moduleFormObj.required('title" . $itemIndex . "');

					moduleFormObj.required('description" . $itemIndex . "');

				";

				$itemIndex +=1;

			}

			

			echo "rssNumber = " . $itemIndex . ";";

		}

	?>

}



function anotherItem(){

	

	/*new div to organize it in*/

	rssGroupContainer = buildHtml.createDivHTMLElement("rssDiv" + rssNumber,"moduleSubElement",null,null,"rssItemContainer");

	

	newRSSDiv1 =  buildHtml.createDivHTMLElement("newsRSSDiv1" + rssNumber,null,null,null,"rssDiv" + rssNumber);

	newRSSDiv2 =  buildHtml.createDivHTMLElement("newsRSSDiv2" + rssNumber,null,null,null,"rssDiv" + rssNumber);

	newRSSDiv3 =  buildHtml.createDivHTMLElement("newsRSSDiv3" + rssNumber,null,null,null,"rssDiv" + rssNumber);

	idf = buildHtml.createHiddenHTMLElement("rssItemID" + rssNumber,0,"rssDiv" + rssNumber);

	

	tfL =  buildHtml.createHTMLFieldCaption("Title " + rssNumber + ":","newsRSSDiv1" + rssNumber);

	tf = buildHtml.createTextHTMLElement("title" + rssNumber,null,75,255,"newsRSSDiv1" + rssNumber);

	removeButton = buildHtml.createButtonHTMLElement("removeButton" + rssNumber,"","moduleFormObj.required('title" + rssNumber + ",description" + rssNumber + "',false);removeItem(" + rssNumber + ");buildHtml.removeElement('" + "rssDiv" + rssNumber + "')","newsRSSDiv1" + rssNumber,"modSubElRem");

	

	lfL =  buildHtml.createHTMLFieldCaption("Link " + rssNumber + ":","newsRSSDiv2" + rssNumber);

	lf = buildHtml.createTextHTMLElement("linkURL" + rssNumber,null,75,255,"newsRSSDiv2" + rssNumber);

	

	dfL =  buildHtml.createHTMLFieldCaption("Description " + rssNumber + ":","newsRSSDiv3" + rssNumber);

	df = buildHtml.createTextHTMLElement("description" + rssNumber,null,75,255,"newsRSSDiv3" + rssNumber);

				

	/*update qforms*/		

	moduleFormObj.addField("title" + rssNumber);

	moduleFormObj.addField("description" + rssNumber);

	

	/*set descriptions*/

	moduleFormObj["title" + rssNumber].description='Title ' + rssNumber;

	moduleFormObj["description" + rssNumber].description='Description ' + rssNumber;

	/*make the appropriate required fields*/

	moduleFormObj.required("title" + rssNumber);

	moduleFormObj.required("description" + rssNumber);

	

	rssNumber++;		

}



/*our item counter*/

var ri = 1;



function addEditRSSItem(xmlResponse,addEdit){

	/*loop through with the rssNumber and add the items*/

	if(ri<=rssNumber){

		if ( typeof(document.getElementById("title" + ri)) != "undefined" && document.getElementById("title" + ri) != null ) {

			var rssItemTitle = fieldEscape(document.getElementById("title"+ri).value);

			var rssItemLink = fieldEscape(document.getElementById("linkURL"+ri).value);

			var rssItemDesc = fieldEscape(document.getElementById("description"+ri).value);

			var rssItemID = document.getElementById("rssItemID"+ri).value;

			

			var rssItemAjax = ajaxObj();



			/*we can add and edit from the same same screen, ie. if they edit a rss feed but then add more items...

			so we need to check to make sure the item is being edited*/

			if(addEdit == 0){

				var requestItemParams = "function=addRecord&rssChannelID=" + xmlResponse + "&title=" + rssItemTitle + "&linkURL=" + rssItemLink + "&description=" + rssItemDesc;

			}

			else if(document.getElementById("rssItemID" + ri).value == 0){

				var requestItemParams = "function=addRecord&rssChannelID=" + xmlResponse + "&title=" + rssItemTitle + "&linkURL=" + rssItemLink + "&description=" + rssItemDesc;

			}

			else{

				var requestItemParams = "function=updateRecord&rssChannelID=" + xmlResponse + "&title=" + rssItemTitle + "&linkURL=" + rssItemLink + "&description=" + rssItemDesc + "&rssItemID=" + rssItemID;

			}

			

			/*update the rssItemID field so we edit instead of adding in the future*/

			ajaxPost(rssItemAjax,"/cmsAPI/rss/rssItem.php",requestItemParams,false);

			document.getElementById("rssItemID" + ri).value = rssItemAjax.responseText;

			ri++;

			addEditRSSItem(xmlResponse,addEdit);

		}

		else{

			ri++;

			addEditRSSItem(xmlResponse,addEdit);

		}

	}

	else{

		ri=1;

		return true;	

	}

}



function removeItem(rssItemID){

	var rssItemAjax = ajaxObj();

	var rssItemID = document.getElementById("rssItemID" + rssItemID).value;

	ajaxPost(rssItemAjax,"/cmsAPI/rss/rssItem.php","function=removeRecordByID&rssItemID=" + rssItemID);

}

