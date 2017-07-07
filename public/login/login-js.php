<?php
/*when we log in or out we need to update all of our log in boxes
we keep track of all our log in objects here so we can loop through
it and paginate all of our log in boxes*/
?>
//object of log-in objects
if(typeof loginObjStorage === "undefined" || loginObjStorage === null) {
	loginObjStorage = {};
}

<?php
	#1 is always appended onto the end because we load the login module into the moduleframe
	if(!isset($_REQUEST["recordID"])){
		$_REQUEST["recordID"] = "1";
	}
?>

//make the className the index for the object
loginObjStorage["<?php echo $priModObj[0]->className; ?>"] = <?php echo $priModObj[0]->className; ?>;

<?php
	if(isset($_SESSION["userID"]) && $_SESSION["userID"] !=0){
?>
	loginObj.loggedIn = true;
<?php
	}
?>
loginObj.prototype.publicLogin = function(urlParams,loginBtn){
		var login = ajaxObj();

		//since we can have multiple login forms we need to know which one we're using
		var thisForm = loginBtn.form;
		var username = escape($(thisForm).find("input[name='username']").val().replace(/\'/g,"\\'"));
		var password = $(thisForm).find("input[name='password']").val().sha256();

		//get the challenge values
		var pmpmID = escape($(thisForm).find("input[name='pmpmID']").val().replace(/\'/g,"\\'"));
		
		var urlParams=(isset(urlParams))? urlParams: "";
		var response = username.toLowerCase()+":"+password; //build our responsee
		var requestParams = "function=checkUser&username=" + username + 
											  "&response=" + response.sha256() +
											  "&pmpmID=" + pmpmID;

		//attach what we need to the ajax object to use when request is completed  	
		login.form = thisForm;	
		login.loginPageID = this.loginPageID;

		login.onreadystatechange=function(){
			if(login.readyState===4){
				var jsonResponse = JSON.parse(login.responseText);
				if(jsonResponse){
					if(jsonResponse.login_status == "-1"){
						alert("Username not found or invalid username and password combination.");
					}
					else if(jsonResponse.login_status == "-3"){
						alert("Session expired, please refresh the page and try again.");
					}
					else{
						//loop through all our log in instances and update login boxes
						for(var key in loginObjStorage) {
							try{

								var tempLoginObj = loginObjStorage[key];

								//update login boxes, only update if the div exists
								if($s("mfmcc-" + tempLoginObj.moduleClassName)){
									tempLoginObj.paginateModule(
										'pmpm={"' + tempLoginObj.pmpmID + '":{"pagPage":"1"}}',this,1
									);
								}
							}
							catch(e){console.log(e + " " + key);}
						}
						//js to keep track if we're logged in
						tempLoginObj.loggedIn = true;

						refreshNavigation();
						if(!isNaN(parseInt(jsonResponse.loginPageID))){
							upc(parseInt(jsonResponse.loginPageID));
						}
						else if(!isNaN(parseInt(login.loginPageID))){
							upc(parseInt(login.loginPageID));
						}
						else{
							upc(pageID);
						}
					}
				}
				else{
					alert("An error occurred while trying to log in, please refresh the page and try again.")
				}
			}
		}
		ajaxPost(login,"/cmsAPI/login/login.php",requestParams,true,1,null,false);
}

loginObj.prototype.publicLogOut = function(){
	var login = ajaxObj();
	var requestParams = "function=logOut&pmpmID="+this.priKeyID;
	
	login.logoutPageID = this.logoutPageID;
	
	login.onreadystatechange=function(){
		if(login.readyState===4){
			var jsonResponse = JSON.parse(login.responseText);
			
			if(jsonResponse.login_status == "-1"){
				alert("An error occurred while trying to log out, please refresh the page and try again.");
			}
			else{
				//loop through all our log in instances and update login boxes
				for(var key in loginObjStorage) {

					var tempLoginObj = loginObjStorage[key];

					//update login boxes, only update if the div exists
					if($s("mfmcc-" + tempLoginObj.moduleClassName)){
						tempLoginObj.paginateModule('pmpm={"' + tempLoginObj.pmpmID + '":{"pagPage":"1"}}',this,1);
					}
				}
				//js to keep track if we're logged in
				tempLoginObj.loggedIn = false;
				
				alert("You have successfully logged out.");
				refreshNavigation();
				if(!isNaN(parseInt(login.logoutPageID))){
					upc(parseInt(login.logoutPageID));
				}
				else{
					upc(pageID);
				}
			}
		}
	}
	
	ajaxPost(login,"/cmsAPI/login/login.php",requestParams,true,1,null,false);

}

//if they click outside of the login box, hide it
$('body').click(function(e) {
    if (
		!$(e.target).closest('.hideLg').length &&
		e.target.className.indexOf("lb") === -1
	){
        $(".hideLg").hide();
    }
});