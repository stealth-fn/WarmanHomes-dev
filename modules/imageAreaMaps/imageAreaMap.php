<?php
	if(!isset($_SESSION)) session_start();
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/imageAreaMap.php");
	
	#admin side
	$_GET["instanceID"] = 
	isset($_GET["instanceID"]) ? $_GET["instanceID"] : 1;
	$imageAreaMapObj = new imageAreaMap(false);
?>

function setImageAreaMapAddEdit(){
	imageAreaMapAddEditObj = new stealthInputCommon();
	imageAreaMapAddEditObj.apiPath = "/cmsAPI/imageAreaMaps/imageAreaMap.php";
	imageAreaMapAddEditObj.moduleAlert = "Image Area Map";
	
	imageAreaMapAddEditObj.addHotspot = function(){
		var increment = parseInt($(".hotspotsCounter:last").val())+1;
		var newHotspot = $(".hotspotFirstContainer:last").clone().appendTo('#imageAreaMapHotspotsContainerInner');
		newHotspot.attr('id','hotspotFirstContainer'+increment);
		newHotspot.find('h3.hotspotsTitle').html('Hotspot '+increment);
		newHotspot.find('input.modSubElRem').attr('onclick','imageAreaMapAddEditObj.removeHotspot('+increment+')');
		newHotspot.find('input[type=text]').val('');
		newHotspot.find('input[type=checkbox]').attr('checked',false);
		newHotspot.find('input[type=hidden].hotspotsCounter').val(increment);
		newHotspot.find('input[type=hidden].hotspotID').val('');
		newHotspot.find('div.hotspotGroup').attr('class','hotspotGroup'+increment+' hotspotGroup');
		newHotspot.find('input[type=checkbox].hotspotGroupID').attr('class','hotspotGroupID'+increment+' hotspotGroupID');
		newHotspot.find('div.hotspotData').attr('class','hotspotData'+increment+' hotspotData');
		newHotspot.find('input[type=text].hotspotDataValue').attr('class','hotspotDataValue'+increment+' hotspotDataValue');
		newHotspot.find('input[type=hidden].hotspotDataID').attr('class','hotspotDataID'+increment+' hotspotDataID');
	}
	
	imageAreaMapAddEditObj.removeHotspot = function(hotspotID){
		if($s("hotspotFirstContainer"+hotspotID).value == ""){
			$("#hotspotFirstContainer"+hotspotID).remove();
		}
		else{
			var hotspotKeyID = $("#hotspotFirstContainer"+hotspotID).find('.hotspotID').val();
			var hotspotAjax = ajaxObj();
			ajaxPost(
				hotspotAjax,
				"/cmsAPI/imageAreaMaps/hotspot.php",
				"function=removeRecordsByCondition&field=priKeyID&value=" + hotspotKeyID,
				false,
				1,null,false
			);
			$("#hotspotFirstContainer"+hotspotID).remove();
		}
	}
	
	imageAreaMapAddEditObj.nextFunction = function(){
		var hotspotsAjax = ajaxObj();
		var hotspots = $$s("hotspotFirstContainer");
		var hotspotsLen = hotspots.length-1;
		var hotspotName = $$s("hotspotName");
		var coordinates = $$s("coordinates");
		var hotspotID = $$s("hotspotID");
		var hotspotCounter = $$s("hotspotsCounter");
		var hotspotGroupsDataAjax = ajaxObj();
				
		//loop through our hotspots and add/update them
		if(hotspots.length > 0){
			for(var i = hotspotsLen; i >= 0; i--){
				currentIncrement = hotspotCounter[i].value;
				var modDataHotspots = {};
				//determine whether it's a new hotspot or not
				modDataHotspots.function = "addRecord";
				var newHotspot = true;
				if(hotspotID[i].value != ""){
					modDataHotspots.function = "updateRecord"
					modDataHotspots.priKeyID = hotspotID[i].value;
					newHotspot = false;
				}
				modDataHotspots.hotspotName = hotspotName[i].value;
				modDataHotspots.coordinates = coordinates[i].value;
				modDataHotspots.imageAreaMapID = $("#priKeyID").val();
				
				var modJsonHotspots = "modData=" + encodeURIComponent(JSON.stringify(modDataHotspots));
			
				ajaxPost(
					hotspotsAjax,
					"/cmsAPI/imageAreaMaps/hotspot.php",
					modJsonHotspots,
					false,
					1,
					"application/x-www-form-urlencoded",false
				);
			
				hotspotID[i].value = hotspotsAjax.responseText;
				//add group mappings for current hotspot
				var hotspotGroups = $$s("hotspotGroup"+currentIncrement);
				var hotspotGroupsLen = hotspotGroups.length -1;
				var hotspotGroupID = $$s("hotspotGroupID"+currentIncrement);
				//remove hotspot group mappings, re-add all of them. easier this way
				ajaxPost(
					hotspotGroupsDataAjax,
					"/cmsAPI/imageAreaMaps/hotspotGroupMap.php",
					"function=removeRecordsByCondition&field=hotspotID&priKeyID=" + hotspotID[i].value,
					false,
					1,null,false
				);
				
				for(var j = hotspotGroupsLen; j >= 0; j--){

					if(hotspotGroupID[j].checked == true){
						var modDataHotspotGroups = {};
						modDataHotspotGroups.function = "addRecord";
						modDataHotspotGroups.hotspotGroupID = hotspotGroupID[j].value;
						modDataHotspotGroups.hotspotID = hotspotID[i].value;
						
						var modJsonHotspotGroups = "modData=" + encodeURIComponent(JSON.stringify(modDataHotspotGroups));
						ajaxPost(
							hotspotGroupsDataAjax,
							"/cmsAPI/imageAreaMaps/hotspotGroupMap.php",
							modJsonHotspotGroups,
							false,
							1,
							"application/x-www-form-urlencoded",false
						);
					}
				}
				
				//add data mappings for current hotspot
				var hotspotData = $$s("hotspotData"+currentIncrement);
				var hotspotDataLen = hotspotData.length -1;
				var hotspotDataID = $$s("hotspotDataID"+currentIncrement);
				var hotspotDataValue = $$s("hotspotDataValue"+currentIncrement);
				
				//remove hotspot group mappings, re-add all of them. easier this way
				ajaxPost(
					hotspotGroupsDataAjax,
					"/cmsAPI/imageAreaMaps/hotspotDataMap.php",
					"function=removeRecordsByCondition&field=hotspotID&priKeyID=" + hotspotID[i].value,
					false,
					1,null,false
				);
					
				for(var k = hotspotDataLen; k >= 0; k--){
					var modDataHotspotData = {};
					modDataHotspotData.function = "addRecord";
					modDataHotspotData.hotspotDataID = hotspotDataID[k].value;
					modDataHotspotData.hotspotID = hotspotID[i].value;
					modDataHotspotData.hotspotDataValue = hotspotDataValue[k].value;
					
					var modJsonHotspotData = "modData=" + encodeURIComponent(JSON.stringify(modDataHotspotData));
					ajaxPost(
						hotspotGroupsDataAjax,
						"/cmsAPI/imageAreaMaps/hotspotDataMap.php",
						modJsonHotspotData,
						false,
						1,
						"application/x-www-form-urlencoded",false
					);
				}
			}
		}
	}
}

<?php 
	echo $imageAreaMapObj->generateFormValidation("moduleForm",$imageAreaMapObj->moduleSettings["validateFields"]);
?>