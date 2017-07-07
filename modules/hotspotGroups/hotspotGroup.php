<?php
	if(!isset($_SESSION)) session_start();
	
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/imageAreaMaps/hotspotGroup.php");
	
	#admin side
	$_GET["instanceID"] = 
	isset($_GET["instanceID"]) ? $_GET["instanceID"] : 1;
	$hotspotGroupObj = new hotspotGroup(false);
?>

function setHotspotGroupAddEdit(){
	hotspotGroupAddEditObj = new stealthInputCommon();
	hotspotGroupAddEditObj.apiPath = "/cmsAPI/imageAreaMaps/hotspotGroup.php";
	hotspotGroupAddEditObj.moduleAlert = "Hotspot Group";
	var savedColorHex = $("#color").val();
	$("#colorSelector").css('backgroundColor',savedColorHex);
	$("#colorSelector").ColorPicker({
		color: '#0000ff',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector').css('backgroundColor', '#' + hex);
			$('#color').val('#' + hex);
			
		},
		onBeforeShow: function(){
			$(this).ColorPickerSetColor(savedColorHex.substr(1));
		}
	});
}

<?php 
	echo $hotspotGroupObj->generateFormValidation("moduleForm",$hotspotGroupObj->moduleSettings["validateFields"]);
?>
