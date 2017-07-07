<?php
	#reset browser specifics styling
	include_once($_SERVER['DOCUMENT_ROOT'].'/css/reset.php');
	#form modal styles
	include_once($_SERVER['DOCUMENT_ROOT'].'/css/modal.php');
	#defaults specific to our cms
	include_once($_SERVER['DOCUMENT_ROOT'].'/css/stealthDefaults.php');
	
	#responsive nav default styling
	include_once($_SERVER['DOCUMENT_ROOT']."/css/jquery.multilevelpushmenu.css");
	
	#customizations to the responsive nav styling
	include_once($_SERVER['DOCUMENT_ROOT']."/css/customResponsive.css");

	#jquery ui styles
	include_once($_SERVER['DOCUMENT_ROOT'].'/css/js/jqueryUI/smoothness.css');
	
	#fancy box
	include_once($_SERVER['DOCUMENT_ROOT'].'/fancybox/source/jquery.fancybox.css');
	
	#animated hamburger menu
	#https://github.com/jonsuh/hamburgers
	include_once($_SERVER['DOCUMENT_ROOT'].'/css/hamburgers.css');
	
	#time picker
	include_once($_SERVER['DOCUMENT_ROOT'].'/css/mobiscroll/mobiscroll.animation.css');
	include_once($_SERVER['DOCUMENT_ROOT'].'/css/mobiscroll/mobiscroll.scroller.css');
	include_once($_SERVER['DOCUMENT_ROOT'].'/css/mobiscroll/mobiscroll.scroller.jqm.css');
	
	#styles specific to this site
	if($_SESSION["domainID"] > 0) {
		include_once($_SERVER['DOCUMENT_ROOT'].'/css/template.php');
	}

	#admin styles
	if($_SESSION["domainID"] < 0) {
		include_once($_SERVER['DOCUMENT_ROOT'].'/css/admin.php');
	}
	
	#$stanPubMods is set in index.php
	while($pMod=mysqli_fetch_assoc($stanPubMods)) {
		#if we're using the stealth framework...
		if($pMod["isTemplate"] == 0 || $pMod["isTemplate"] == 1 || $pMod["isTemplate"] == 3) {		
			#setup the object for the module
			include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleObjectSet.php");
		}
		if(strlen($pMod["cssLink"]) > 0){
			include($_SERVER['DOCUMENT_ROOT'].$pMod["cssLink"]);
		}
	}
	
	#need unset before we build the HTML or we encounter some issues
	if(isset($priModObj)){
        unset($priModObj);
    }
	
	#we reuse this query, reset the pointer
	if(mysqli_num_rows($stanPubMods) > 0) {
		mysqli_data_seek($stanPubMods,0);
	}
?>