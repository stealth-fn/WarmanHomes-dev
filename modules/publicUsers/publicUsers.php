//need properties prototyped and none
publicUserObj.prototype.encryptFields = "<?php echo implode(",",$priModObj[0]->moduleSettings["hashFields"]); ?>";
publicUserObj.prototype.ignoreFields = "";

//if updating, don't require password
publicUserObj.prototype.construct = function(){
	if($("form[name=moduleForm] input[name=priKeyID]").val()) {
		$("form[name=moduleForm] input[name=loginPassword]").each(
			function(index,element){
				//the form may not have validation rules, so try/catch
				try{
					$(this).rules('add', {required: false });
				}
				catch(e){
				}
			}
		);
		
		$("form[name=moduleForm] input[name=loginPasswordVeri]").each(
			function(index,element){
				//the form may not have validation rules, so try/catch
				try{
					$(this).rules('remove', 'equalTo');
				}
				catch(e){
				}
			}
		);
	
		//if updating, determine if we ignore the password or not
		publicUserObj.prototype.ignoreFields += (publicUserObj.prototype.ignoreFields.length>0) ? ",loginPassword" : "loginPassword"; 
	
		//don't ignore the password field if there is a new one
		$("form[name=moduleForm] input[name=loginPassword]").bind(
			'blur',
			function(){
				//ignore the field
				if($("form[name=moduleForm] input[name=loginPassword]").val().length === 0){
					publicUserObj.prototype.ignoreFields += (publicUserObj.prototype.ignoreFields.length>0) ? ",loginPassword" : "loginPassword";
				}
				//remove from the ignore list, do for comma list and by itself
				else{
					publicUserObj.prototype.ignoreFields = repSubstr(
						publicUserObj.prototype.ignoreFields,"loginPassword",""
					);
				}
			}
		);
	}
}

publicUserObj.prototype.emailAdmin = function(){

	var publicUserModule = ajaxObj();
	var requestParams = "function=notifyAdmin&newUserID=" + $(this.modForm).find('input[name=priKeyID]').val();
	
	ajaxPost(publicUserModule,"/cmsAPI/publicUsers/publicUsers.php",requestParams,true);

	if(<?php echo $priModObj[0]->selfAddPubUser;?> == 0){
		alert("<?php echo $priModObj[0]->adminApproveAlertText;?>");
	}
	else alert("<?php echo $priModObj[0]->selfAddAlertText;?>");

}

publicUserObj.prototype.emailUser = function(){

	var currentState = $(this.modForm).find('input:radio[name=isActive]:checked').val();
	var publicUserModule = ajaxObj();
	var requestParams = "function=notifyUser&publicUserID=" + $(this.modForm).find('input[name=priKeyID]').val();

	ajaxPost(publicUserModule,"/cmsAPI/publicUsers/publicUsers.php",requestParams);

	<?php 
		#let the admin know whats going on
		if(!isset($GLOBALS['isPublic'])){
	?>
		alert("An email has been sent to the user to alert them of their account activation");
	<?php
		 } 
	?>
}

//before we create the user check to see if the email and user name are available
publicUserObj.prototype.preFunction = function(){

	var publicUserModule = ajaxObj();

	//depending on how the instance is setup, the loginName may not exist
	if($(this.modForm).find('input[name=loginName]').length > 0 &&
		//only check to see if it's available, if it's changed
		$(this.modForm).find('input[name=loginName]').val().trim() !==
		$(this.modForm).find('input[name=loginNameCompare]').val().trim()
	){

		var checkName = $(this.modForm).find('input[name=loginName]').val();
		var requestParams = "function=checkAccountAvail&f=loginName&v=" + checkName;

		ajaxPost(
			publicUserModule,
			"/cmsAPI/publicUsers/publicUsers.php",
			requestParams,
			false,null,null,false
		);
		
		if(publicUserModule.responseText == 1){
			alert("<?php echo $priModObj[0]->unavailableUserNameText;?>");
			return false;
		}
	}

	//depending on how the instance is setup, the loginName may not exist
	if($(this.modForm).find('input[name=email]').length > 0 &&
		//only check to see if it's available, if it's changed
		$(this.modForm).find('input[name=email]').val().trim() !==
		$(this.modForm).find('input[name=emailCompare]').val().trim()
	){

		var checkEmail = $(this.modForm).find('input[name=email]').val();
		var requestParams = "function=checkAccountAvail&f=email&v=" + checkEmail;

		ajaxPost(
			publicUserModule,
			"/cmsAPI/publicUsers/publicUsers.php",
			requestParams,
			false,null,null,false
		);

		if(publicUserModule.responseText == 1){
			alert("<?php echo $priModObj[0]->unavailableUserNameText;?>");
			return false;
		}
	}
	
	return true;

}

publicUserObj.prototype.nextFunction = function(){

	//this is a new account	
	if($(this.modForm).find('input[name=preActive]').length === 0){
		<?php if(isset($GLOBALS['isPublic'])){?>this.emailAdmin();<?php }?>

		//notify the user that they have create an account
		this.emailUser();

		//log the user in automatically
		if(this.autoLogin == 1){
			/*this is an object we create of all our login instances
			we will populate of its user/pass fields and submit it to
			login the user*/

			//doesn't matter which object we use, just get the first one
			var userLoginObj = window[Object.keys(loginObjStorage)[0]];
		
			//we overwrite the backup page, so we backup the one the object has set
			var tempLoginPageID = userLoginObj.loginPageID;
			userLoginObj.loginPageID = this.createGoto;

			//populate the login fields
			//user name
			$("#lif-" + userLoginObj.moduleClassName + "1 input[name='username']").val(
				$(this.modForm).find('input[name=loginName]').val()
			);

			//password
			$("#lif-" + userLoginObj.moduleClassName + "1 input[name='password']").val( 
				$(this.modForm).find('input[name=loginPassword]').val()
			);

			//login the user
			userLoginObj.publicLogin('', $s("lbp-" + userLoginObj.moduleClassName + "1"));

			//change the loginPageID back to what it was
			userLoginObj.loginPageID = tempLoginPageID;
		}

		//we didn't auto login, go to specified page
		if(this.autoLogin == 0 && !isNaN(this.createGoto)){
			upc(this.createGoto);
		}
				
		//create preActive form field so we don't send out alerts if they do an immediate edit
		$('<input id="preActive' + this.priKeyID +'" name="preActive' + this.priKeyID +'" type="hidden"/>').appendTo(
			"#" + this.modForm.id
		);
	}

	//clear out the password field, its only updated when a change is made
	if($(this.modForm).find('input[name=loginPassword]')){
		$(this.modForm).find('input[name=loginPassword]').val("");
	}
}