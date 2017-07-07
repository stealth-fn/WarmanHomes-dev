getDisplayInfoObj.prototype.sendInfo = function(subForm){

	var userValue = subForm.elements["userInfo"].value;
	$.ajax({  
		type: "GET",
		url: "/cmsAPI/getDisplayInfo/getDisplayInfo.php",
		data: "function=getDisplayInfo&userInfo=" + userValue,
		success: function() {
			
			var gotoPage = "<?php echo $priModObj[0]->gotoPage; ?>";
			
			if(gotoPage.length > 0){
				atpto_tNav.toggleBlind('<?php echo $priModObj[0]->gotoPage; ?>',0,'upc(<?php echo $priModObj[0]->gotoPage; ?>)','ntid_tNav<?php echo $priModObj[0]->gotoPage; ?>','');
			}
			else { 
				$$s("displayUserInfoOutter").className += " dspUserInfo";
				$$s("displayUserInfoInner").className += " dspUserInfo";
				
				var tempLen = $$s("displayUserInfoInner").length
				for(var x = 0; x < tempLen; x++){
					$$s("displayUserInfoInner")[x].innerHTML = userValue;
				}
			}
			 
			return false;
		}
	});
};