<!--js api for youtube-->
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript" src="/js/scripts.php"></script>
<!--this is a compressed version of  
http://ajax.googleapis.com/ajax/libs/prototype/1.6.1.0/prototype.js and our commonScript.js
to make it go here... 
http://closure-compiler.appspot.com/home
add add them in the order above, and copy the code into commonScriptMini.js-->
<!--<script src="/js/commonScriptMini.js" type="text/javascript" ></script>-->
<!--<script src="/js/commonScript.js" type="text/javascript" ></script>
<script src="http://ajax.googleapis.com/ajax/libs/prototype/1.6.1.0/prototype.js" type="text/javascript" ></script>
<script src="/js/scriptaculous-js-1.8.3/src/scriptaculous.js" type="text/javascript"></script>-->

<!--qforms, form validation library-->
<script  type="text/javascript" src="/js/qforms/qforms.js"></script> 
<script  type="text/javascript"> 
   qFormAPI.setLibraryPath("/js/"); 
   qFormAPI.include("*");
</script>

<!-- Load the Really Simple History framework -->
<?php 
	/*the bookmark and forward\backbutton scripts don't get along with CKEditor.... only use if the user isn't logged in to the admin side*/
	/*don't load this if out module is in a pop-up window or IE freaks out*/
	/*if(isset($_GET["moduleID"]) == false && (isset($_SESSION['isLoggedIn']) == false || (isset($_SESSION['isLoggedIn']) == true && $_SESSION['isLoggedIn'] == false))){
		echo '<script type="text/javascript" src="/js/RSH0.6FINAL/json2007.js"></script>
		<script type="text/javascript" src="/js/RSH0.6FINAL/rsh.js"></script>
		<script type="text/javascript"><!--
		try{
			window.dhtmlHistory.create({
				debugMode: false//set this to false, or just don\'t pass in an options bundle, to see real-world, non-debug conditions 
			});
		
			var historyChange = function(newLocation,historyData) {
				eval(historyData);
			}
		}
		catch(e){
			alert(e);
		}
		// -->	
		</script>';
	}*/
?>