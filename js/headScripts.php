<?php
	if(!isset($_SESSION)) session_start();
	Header("content-type: application/x-javascript");
	
	#include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
	
	if($_SESSION["shrinkScripts"] == 0 || $_SESSION["shrinkScripts"] == 1){
		include_once($_SERVER['DOCUMENT_ROOT']."/js/scriptsCompile.php");
	}
	
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/stealthJquery.js") . ";" .PHP_EOL;#jquery form validation
	
	echo file_get_contents("http://www.google.com/jsapi") . PHP_EOL;#google api loader	
	#echo file_get_contents("https://www.google.com/recaptcha/api.js" ) . PHP_EOL;#google reCAPTCHA loader	
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/jquery.validate.min.js") . ";" .PHP_EOL;#jquery form validation
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/jquery.ui.timepicker.min.js") . ";" .PHP_EOL;#timepicker plugin for ui
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/additional-methods.min.js") . ";" .PHP_EOL;#additional validation methods
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/sha256.js") . PHP_EOL;#SHA256 encryption
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/inputmask/jquery.inputmask.bundle.min.js") . ";" .PHP_EOL;#jquery input Mask
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/history/jquery.history.js") . ";" .PHP_EOL;#history.js	
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/jquery.multilevelpushmenu.min.js") . ";" .PHP_EOL;#responsive nav
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/fancybox/source/jquery.fancybox.pack.js") . ";" .PHP_EOL;#fancy box
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/fancybox/source/jquery.touchSwipe.js") . ";" .PHP_EOL;#fancy box - mobile swipe
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/fancybox/source/jquery.fancybox-buttons.js") . ";" .PHP_EOL;#fancy box - mobile swipe
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/commonScriptMini.js") . ";" .PHP_EOL;#stealth custom scripts
	
	#shim for ie9 css placeholder. remove once ie9 is no longer supported
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/placeholder.js") . ";" .PHP_EOL;#stealth custom scripts

	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/js/jquery.appear.js") . ";" .PHP_EOL;#check if element is visible
	$scriptContent = "";
	
	#js array mapping pageID's to pageNames. primary used with history.js library
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
	$pagesObj = new pages(false, NULL);	
	$order = 1;	
	$pnArray = getPageArray($pagesObj,null,$order,false);
	echo "pageArray = " . json_encode($pnArray) . ";";
	
	function getPageArray($pagesObj,$currentPage,&$order,$rootPageID){
		
		#child page
		if($currentPage){
			$currentLevel = $pagesObj->getConditionalRecord(
				array(
					"parentPageID",$currentPage["priKeyID"],true,
					"linkPageURL","",true,
					"ordinal ASC, priKeyID ",
					"ASC"
				)
			);
			
			$isRootPage = false;
		}
		#root pages
		else{
			$currentLevel = $pagesObj->getConditionalRecord(
				array(
					"pageLevel",1,true,
					"linkPageURL","",true,
					"ordinal ASC, priKeyID ","ASC"
				)
			);
			
			$isRootPage = true;
		}
		$pnArray = array();
		#loop through the current level, starting with the root
		while($x = mysqli_fetch_assoc($currentLevel)){
			
			if($isRootPage || !$rootPageID){
				$rootPageID = $x["priKeyID"];
			}
			
			if($x["priKeyID"] != -1){
				$loaded = ($_GET["pageID"] == $x["priKeyID"]) ? 1 : 0;
				$pnArray[$x["priKeyID"]] = array(
					"name"=>$x["pageName"],
					"pageTitle"=>$x["pageTitle"],
					"pageOrder"=>$order++,
					"pageLoaded"=> $loaded,
					"preUpdate"=>$x["preUpdate"],
					"afterComplete"=>$x["afterComplete"],
					"postUpdate"=>$x["postUpdate"],
					"members"=>$x["isMembersPage"],
					"parentPageID"=>$x["parentPageID"],
					"pageLevel"=>$x["pageLevel"],
					"rootPageID"=>$rootPageID
				);
				$children = getPageArray($pagesObj,$x,$order,$rootPageID);
				foreach($children as $key=>$value){
					$pnArray[$key] = $value;
				}
			}
		}
		
		#before we return, append pages with pageLevel 0 to our array
		$currentLevel = $pagesObj->getConditionalRecord(
			array(
				"pageLevel",0,true,
				"linkPageURL","",true,
				"ordinal ASC, priKeyID ","ASC"
			)
		);
		while($x = mysqli_fetch_assoc($currentLevel)){
			if($x["priKeyID"] != -1){
				$loaded = ($_GET["pageID"] == $x["priKeyID"]) ? 1 : 0;
				$pnArray[$x["priKeyID"]] = array(
					"name"=>$x["pageName"],
					"pageTitle"=>$x["pageTitle"],
					"pageOrder"=>$order++,
					"pageLoaded"=> $loaded,
					"preUpdate"=>$x["preUpdate"],
					"afterComplete"=>$x["afterComplete"],
					"postUpdate"=>$x["postUpdate"],
					"members"=>$x["isMembersPage"],
					"parentPageID"=>$x["parentPageID"],
					"pageLevel"=>$x["pageLevel"]  ,
					"rootPageID"=>"false"
				);
			}
		}
		
		return $pnArray;
	}
?>			
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', '<?php echo $_SESSION["googleAnalyticsCode"]; ?>', 'auto');
ga('send', 'pageview');

singlePageSite = <?php echo (isset($_SESSION["singlePageSite"]) && $_SESSION["singlePageSite"] != 0) ? "true" : "false"; ?>;
<?php 
	if(isset($_SESSION["singlePageSite"]) && $_SESSION["singlePageSite"] != 0){ 
		echo "singlePageOrientation = ".$_SESSION["singlePageSite"].";"; 
	}
?>
pageID = <?php echo $_SESSION["pageID"]?>;//global pageID
prevPage = 0;
pageName = "<?php echo $pQuery["pageName"]; ?>";//global pageName - do we use this?
String.prototype.salt = "<?php echo $_SESSION["salt"]; ?>";
seoFolderName = "<?php echo $_SESSION["seoFolderName"]; ?>";
pageInterTime = {}; //objects for timeouts and intervals on a page, properties are the cms classNames
standardInterTime = {}; //objects for timeouts and intervals that are standard, properties are the cms classNames

(function(window,undefined){
	var History = window.History; //create History object
	
	historyBool = false; //set historyBool for initial push
	historySet = 
		{ 
			ajaxRunFunction: 
			"upc('" + pageID + "',window.location.search)"
		};
	History.pushState(historySet,"","");
	historyBool = true; //true is our default
	
	// Note: We are using statechange instead of popstate	
	History.Adapter.bind(window,'statechange',function(){ 
		
		// Note: We are using History.getState() instead of event.state
		var State = History.getState(); 
		//don't run our function when we do a pushState
		if(
			historyBool && 
			typeof(State.data.ajaxRunFunction) !== "undefined"
		){
			historyBool = false;
			tempFunction = new Function(State.data.ajaxRunFunction);
			tempParams = State.data.hisUrlParams;
			tempFunction();
		}
		//set to our default of true
		historyBool = true;

		return true;
	});

})(window);

$(window).load(function(){
	<?php if($_SESSION['pageID'] > 0){
		echo "singlePageSite && loadSinglePageSite();\n"; 
		echo $_SESSION["pageTransition"];
	}?>
	
	historyBool = true; //true is our default
	extraScripts();
});