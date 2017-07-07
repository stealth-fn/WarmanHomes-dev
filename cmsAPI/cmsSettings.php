<?php
	if(!isset($_SESSION)) session_start();
	
	#initial page load, and we haven't gotten page information yet
	if(
		(isset($_GET["initPage"]) && !isset($_GET["pageMarker"]) &&
		#not our sitemap
		strrpos($_SERVER['REQUEST_URI'],"sitemap.php") === false) ||
		#doing an ajax page refresh with an expired session
		(!isset($_SESSION["domainID"]))
	){	
		
		$_SESSION['dbHostName'] = 'cmsprod.stealthssd.com';
		$_SESSION['dbUsername'] = 'mystealt_cmsprod';
		$_SESSION['dbPassword'] = 'uWPew@fkZ8IU';
		$_SESSION['dbName'] = 'mystealt_cmsprod';
		
		# Fetch CMS Setting from DB
		
		$tempCon = new mysqli($_SESSION['dbHostName'], $_SESSION['dbUsername'], $_SESSION['dbPassword'], $_SESSION['dbName']);

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		/* return name of current default database */
		$y = $tempCon->query("SELECT * FROM cmsSettings WHERE priKeyID = 1");
		
		$x = mysqli_fetch_assoc($y);
		
		
		#don't overwrite existing security levels, or you'll be sooooorrrryyyyy
		if(!isset($_SESSION['sessionSecurityLevel'])) $_SESSION['sessionSecurityLevel'] = 0;
		$_SESSION["googleAnalyticsCode"] = $x["googleAnalyticsCode"];
		$_SESSION["googleSiteVerification"] = $x["googleSiteVerification"];
		$_SESSION["googleDevKey"] = $x["googleDevKey"];
		$_SESSION["googlePublisherLink"] = $x["googlePublisherLink"];

		$_SESSION["youtubeUser"] = $x["youtubeUser"];
		$_SESSION["zohoAuth"] = $x["zohoAuth"];
		$_SESSION["zohoLeadOwner"] = $x["zohoLeadOwner"];

		$_SESSION["siteName"] = $x["siteName"];
		$_SESSION["adminEmail"] = $x["adminEmail"];
		
		$_SESSION["metaWords"] = $x["metaWords"];
		$_SESSION["metaDesc"] = $x["metaDesc"];
		
		$_SESSION["reCAPTCHASiteKey"] = $x["reCAPTCHASiteKey"];
		$_SESSION["reCAPTCHASecretKey"] = $x["reCAPTCHASecretKey"];
		
		$_SESSION["singlePageSite"] = 0;# 0 - off, 1 - vertical, 2 - horizontal;
		$_SESSION["pageTransition"] = $x["pageTransition"];

		$_SESSION["primaryModulePriKeyID"] = "";
		
		#For ecommerce invoices 
		$_SESSION["orderCompanyName"] = $x["orderCompanyName"];
		$_SESSION["orderCompanyAddress1"] = $x["orderCompanyAddress1"];
		$_SESSION["orderCompanyAddress2"] = $x["orderCompanyAddress2"];
		$_SESSION["orderCompanyAddress3"] = $x["orderCompanyAddress3"];
		
		#0 to comrpess and use compressed
		#1 to use non-compressed version
		#2 use whatever script was last created
		$_SESSION["shrinkScripts"] = 1;
		$_SESSION["moduleBenchmark"] = false;
		$_SESSION["seoFolderName"] = $x["seoFolderName"];
		$_SESSION["salt"] = strrev(hash("sha256","thisisatest"));
		
		$y->close();
		
		#defualt time zone
		date_default_timezone_set('Canada/Saskatchewan');
		
		#determine if its http or https
		$_SESSION["protocol"] = isset($_SERVER["https"]) ? 'https' : 'http';
		
		#php iOS detection
		$_SESSION["iPhone"] = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
		$_SESSION["iPad"] = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
		
		#stores js to be called on upc and initial page load
		#currently only used for auto-rotate interval
		$_SESSION["modulePageTransition"] = "";
		
		#mobile detection script
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/mobileDetect/Mobile_Detect.php");
        $_SESSION["mobileDetect"] = new Mobile_Detect;
        $_SESSION["isMobile"] = $_SESSION["mobileDetect"]->isMobile();
		
		#if we have a primary module on a page, put some of its values into this array
		#an populate the meta values in index.php. use for social media sharing
		if(!isset($_GET["openGraph"])){
			$_GET["openGraph"] = array();
			$_GET["openGraph"]["title"] = "";
			$_GET["openGraph"]["image"] = "/images/admin/logo-project.png";
			$_GET["openGraph"]["description"] = "";
			$_GET["openGraph"]["site_name"] = $_SESSION["siteName"];
		}
			
		/*the domain running the site, used for larger scope things... nav, pmpm, standard content
		$_SESSION["domainID"] 
		
		used for adding/editing records
		$_SESSION["lngDmnID"]
		
		used when we want to change the language, used to determine which labels to use
		typically passed in from the browser
		$_REQUEST["lng"]*/

		#set the domainID - should only need to be set once here, then overwritten if needed after
		if(!isset($_SESSION["domainID"]) && substr($_SERVER['SERVER_NAME'],0,5) === "admin"){
			#admin sub domain
			$_SESSION["domainID"] = -1;
			$_SESSION["adminPub"] = -1;
			$_SESSION["lngDmnID"] = 1;
			$_SESSION["lng"] = "en";
		}
		elseif(!isset($_SESSION["domainID"])){
			#default/regular public domain
			$_SESSION["domainID"] = 1;
			$_SESSION["adminPub"] = 1;
			$_SESSION["lngDmnID"] = 1;
			$_SESSION["lng"] = "en";
		}
		
		#language for data
		if(isset($_REQUEST["lng"])) {
			#english
			if($_REQUEST["lng"] == "en") {
				$_SESSION["lng"] = "en";
				$_SESSION["domainID"] = 1 * $_SESSION["adminPub"];
				$_SESSION["lngDmnID"] = 1;
			}
			#japanese
			elseif($_REQUEST["lng"] == "jp"){
				$_SESSION["lng"] = "jp";
				$_SESSION["domainID"] =  2 * $_SESSION["adminPub"];
				$_SESSION["lngDmnID"] = 2;
			}
			#default for the website - english by default
			else{
				$_SESSION["lng"] = "en";
				$_SESSION["domainID"] = 1 * $_SESSION["adminPub"];
				$_SESSION["lngDmnID"] = 1;
			}
		}
		elseif(!isset($_SESSION["domainID"])){

			if(strpos($_SERVER['SERVER_NAME'],"jp.") !== false) {
				$_SESSION["lng"] = "jp";
				$_SESSION["domainID"] =  3 * $_SESSION["adminPub"];
				$_SESSION["lngDmnID"] = 3;
				$defaultPageID = 2503;
			}
			else{
				#default for the website - english by default
				$_SESSION["lng"] = "en";
				$_SESSION["domainID"] = 1 * $_SESSION["adminPub"];
				$_SESSION["lngDmnID"] = 1;
			}
		}		
	}
	
	#admin
	if(substr($_SERVER['SERVER_NAME'],0,5) === "admin"){
		$defaultPageID = -11;
	}
	elseif(strpos($_SERVER['SERVER_NAME'],"jp.") !== false) {
		$_SESSION["lng"] = "jp";
		$_SESSION["domainID"] =  2 * $_SESSION["adminPub"];
		$_SESSION["lngDmnID"] = 2;
		$defaultPageID = 2503;
	}
	else{
		$_SESSION["lng"] = "en";
		$_SESSION["domainID"] = 1 * $_SESSION["adminPub"];
		$_SESSION["lngDmnID"] = 1;
		$defaultPageID = 1;
	}

		
	#initial page load, and we haven't gotten page information yet
	if(
		isset($_GET["initPage"]) && !isset($_GET["pageMarker"]) &&
		#not our sitemap
		strrpos($_SERVER['REQUEST_URI'],"sitemap.php") === false
	){
	
		#get page info
		require_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
		$pagesObj = new pages(false,NULL);
		$pQuery = null;
		
		#remove trailing and leading forward slashes
		$_SERVER['REQUEST_URI'] = trim($_SERVER['REQUEST_URI'],"/"); 
		 
		/*WE NEED TO DETERMINE WHAT PAGE WE'RE TRYING TO ACCESS. IF THE URL DOESN'T HAVE
		THE SEO FOLDER NAME IN IT, WE REDIRECT TO IT */
		
		/*used to check if we're doing a 301 from within 
		the cms for this page, set in the pagesmodule*/
		$_GET["cms301"] = false;
		
		$_GET["cms404"] = false;
		
		$_GET["hasLastEmptyURI"] = false;

		#pageID is specified
		if(isset($_GET["pageID"])) {
			$_GET["pageMarker"] = $_GET["pageID"];
			
			#404 page
			if($_GET["pageID"] == -5){
				$_GET["cms404"] = true;
			}
		}
		#the pageID is after a /, probably a JS redirect
		elseif(strrpos($_SERVER['REQUEST_URI'],"pageID") !== false){
			$pg = explode("=",$_SERVER['REQUEST_URI']);
			$_GET["pageMarker"] = $pg[1];
		}
		#index.php without a pageID
		elseif(strrpos($_SERVER['REQUEST_URI'],"index.php") !== false){
			$_GET["pageMarker"] = "1";
		}
		elseif(strlen($_SERVER['REQUEST_URI']) > 0){
			#explode uri to check for clean module uri (url/page/moduleSlug/field)
			$splitURI = explode("/",urldecode(strtok($_SERVER['REQUEST_URI'],'?')));
			$segmentPos = 0;
			
			$urlSegLen = count($splitURI);
					
			#keep looking for a page in the uri
			while(!is_array($pQuery) && $segmentPos < $urlSegLen){ 
				#check if there is page for current URI item
				$tempURI = $splitURI[$segmentPos++]; 
				$tempPage = $pagesObj->getConditionalRecord(array("pageName",$tempURI,true));

				#if there is get the page for it
				if(mysqli_num_rows($tempPage) > 0) {
					$tp = mysqli_fetch_assoc($tempPage);
					$_GET["pageMarker"] = $tp["pageName"];
					#break;
				}
				
				#last segment in uri doesn't exist as a page
				#either gonna be a 404 or a record for the primary page module
				elseif($segmentPos == $urlSegLen){
					$lastEmptyURI = $tempURI;
					$_GET["hasLastEmptyURI"] = true;
				}
				
				#check to see if we had any 301's in place
				$cms301Check = $pagesObj->getCheckQuery(
					"SELECT * from public_pages 
					WHERE FIND_IN_SET('" . $GLOBALS["mysqli"]->real_escape_string($tempURI) . "',redirect301)"
				);
				
				if(mysqli_num_rows($cms301Check) > 0) {
					$tp = mysqli_fetch_assoc($cms301Check);
					$_GET["pageMarker"] = $tp["pageName"];

					#doing a 301 from the pages module
					$_GET["cms301"] = true;
					#break;
				}
				
				/*we would search for this term against the value of the 
				primaryPageModuleTitle field in the modules table*/
				$_SESSION["lastURI"] = $tempURI;
			}		

			#didn't request a page, just had URL params
			if(!isset($tp) || (isset($tp) && !is_array($tp))){
				/*$tempPage = $pagesObj->getRecordByID($defaultPageID);
				$tp = mysqli_fetch_assoc($tempPage);*/
				$_GET["pageMarker"] = -5; 
				$_GET["cms404"] = true;
			}
		}
		#no page specified. going to the home page
		elseif(strlen($_SERVER['REQUEST_URI']) == 0){
			$tempPage = $pagesObj->getRecordByID($defaultPageID);
			$tp = mysqli_fetch_assoc($tempPage);
			$_GET["pageMarker"] = $tp["pageName"];
		}
		#page doesn't exist. likely a 404
		else{
			#404 page
			$_GET["pageMarker"] = "-5"; 
			$_GET["cms404"] = true;
		}

		$pageInfo = $pagesObj->getPageInfo($_GET["pageMarker"]);
		
		#404
		if($pageInfo["priKeyID"] == ""){
			$pageInfo = $pagesObj->getPageInfo(-5);
			$_GET["cms404"] = true;
		}
		
		$settingsPageID = $pageInfo["priKeyID"];

		if($_GET["cms404"]){
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
			$_GET["pageMarker"] = "-5"; 
		}
		#if the SEO folder name isn't in our URL redirect
		elseif(
			(strrpos(urldecode($_SERVER['REQUEST_URI']), $_SESSION["seoFolderName"] . "/") === false &&
			$settingsPageID != 1 && $settingsPageID != -5) ||
			$_GET["cms301"]
		){

			header("HTTP/1.1 301 Moved Permanently"); 

			if(strlen($_SERVER['QUERY_STRING']) > 0){
				header("Location: /" . $_SESSION["seoFolderName"] . "/" . $pageInfo["pageName"] . "?" . $_SERVER["QUERY_STRING"]); 
			}
			else{
				header("Location: /" . $_SESSION["seoFolderName"] . "/" . $pageInfo["pageName"]); 
			}
		}
		#trying to access the home page, just send them to the root
		elseif(strlen($_SERVER['REQUEST_URI']) > 0 && $settingsPageID == 1){

			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: /"); 
			
		}
		#page names and redirects are OK, proceed to load document
		else{
			header("Content-type: text/html; charset=utf-8");
		}
		
		#IF YOU WANT MULTIPLE CITIES, USE THE CODE BELOW	
		/*
		saskatoon - 0
		regina - 1
		edmonton - 2
		calgary - 3
		vancouver - 4*/
		
		/*$_SESSION["cityInfo"] = array();
		$_SESSION["cityInfo"][0] = array();
		$_SESSION["cityInfo"][0]["city"] = "Saskatoon";
		$_SESSION["cityInfo"][0]["phone"] = '<a href="tel:+13069789018">(306) 978-9018</a>';
		$_SESSION["cityInfo"][0]["address"] = "550 Circle Drive, Saskatoon, SK, S7K 0T8";
		
		$_SESSION["cityInfo"][1] = array();
		$_SESSION["cityInfo"][1]["city"] = "Regina";
		$_SESSION["cityInfo"][1]["phone"] = '<a href="tel:+13069789018">(306) 978-9018</a>';
		$_SESSION["cityInfo"][1]["address"] = "";
		
		$_SESSION["cityInfo"][2] = array();
		$_SESSION["cityInfo"][2]["city"] = "Edmonton";
		$_SESSION["cityInfo"][2]["phone"] = '<a href="tel:+17804818783">(780) 481-8783</a>';
		$_SESSION["cityInfo"][2]["address"] = "Manulife Place 10180 - 101 Street Suite 3400, Edmonton, AB, T5J 3S4";
		
		$_SESSION["cityInfo"][3] = array();
		$_SESSION["cityInfo"][3]["city"] = "Calgary";
		$_SESSION["cityInfo"][3]["phone"] = '<a href="tel:+14032650515">(403) 265-0515</a>';
		$_SESSION["cityInfo"][3]["address"] = "Sun Life Plaza West Tower - 144-4 Avenue SW Suite 1600, Calgary, AB, T2P 3N4";
		
		$_SESSION["cityInfo"][4] = array();
		$_SESSION["cityInfo"][4]["city"] = "Vancouver";
		$_SESSION["cityInfo"][4]["phone"] = '<a href="tel:+16044089888">(604) 408-9888</a>';
		$_SESSION["cityInfo"][4]["address"] = "1500 West Georgia - Suite 1300 Vancouver, BC, V6G 2Z6";
		
		#DEFAULT
		$_SESSION["cityInfo"][5] = array();
		$_SESSION["cityInfo"][5]["city"] = "";
		$_SESSION["cityInfo"][5]["phone"] = '<a href="tel:+13069789018">(306) 978-9018</a>';
		$_SESSION["cityInfo"][5]["address"] = "550 Circle Drive, Saskatoon, SK, S7K 0T8";
		
		#Regina
		if($_GET["pageID"] == 417){
			$_SESSION["cityEntry"] = 1;
			$_SESSION["cityPriority"] = array(1,0,3,4,2);
		}
		#Edmonton
		elseif($_GET["pageID"] == 418){
			$_SESSION["cityEntry"] = 2;
			$_SESSION["cityPriority"] = array(2,3,4,0,1);
		}
		#Calgary
		elseif($_GET["pageID"] == 419){
			$_SESSION["cityEntry"] = 3;
			$_SESSION["cityPriority"] = array(3,4,2,0,1);
		}
		#Vancouver
		elseif($_GET["pageID"] == 500){
			$_SESSION["cityEntry"] = 4;
			$_SESSION["cityPriority"] = array(4,3,2,0,1);
		}
		#Saskatoon
		elseif($_GET["pageID"] == 420){
			$_SESSION["cityEntry"] = 0;
			$_SESSION["cityPriority"] = array(0,1,3,4,2);
		}
		#DEFAULT SASKATOON
		else{
			$_SESSION["cityEntry"] = 5;
			$_SESSION["cityPriority"] = array(0,1,3,4,2);
		}*/
	}
?>