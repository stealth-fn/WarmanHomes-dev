<?php
	#create form validation
	echo $priModObj[0]->generateFormValidation(
		"passwdResetForm_" . $priModObj[0]->className,
		$priModObj[0]->moduleSettings["validateFields"]
	);
?>

passRsObj.prototype.resetPassRequest = function(){

	if($("#passwdResetForm_" + this.moduleClassName).validate().form()){
		var passReset = ajaxObj();
		
		passReset.onreadystatechange=function(){
			
			if(passReset.readyState===4){
				if(passReset.responseText == 1){
					alert("A new password has been sent to the email address you provided.");
				}
			}	
		}

		var requestParams = 'function=resetForgottenPassword&a=' + $(".passRstEmail_" + this.moduleClassName).val().trim();	
		ajaxPost(
			passReset,
			"/cmsAPI/login/passwordReset.php",
			requestParams,true,0,null,false
		);
	}
}