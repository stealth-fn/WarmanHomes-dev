<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	class pages extends common{
		protected $rootPageID;
		public $moduleTable = "public_pages";
		public $instanceTable = "instance_pages";
		
		public function __construct($isAjax,$pmpmID = 1){		
			parent::__construct($isAjax,$pmpmID);
			
			#mapping infor for pages and user groups
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "pageID";
			$this->mappingArray[0]["fieldName"] = "publicUserGroupID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/publicUsers/publicUserGroups/publicUserGroupPageMap.php";
		}
							
		public function getPageTree(
			$pageID,
			$navType,
			$navClass,
			$subNav = 0,
			$firstRec = true
		){
			if(!isset($_SESSION))session_start();
			#this only echo's, there is not return value. make false so we can use $this for common functions
			$this->ajax = false;
									
			/*SAMPLE OUTPUT
			<div 
				//adjusts the toggled state in the nav, supplies the callback function
				onclick="atpo.toggleBlind(&quot;88&quot;,true,0,&quot;upc(88,\&quot;\&quot;);&quot;,this,event)" 
				
				//nc - anything in a nav system/accordion, 
				//nl1 - side nav level 1, 
				//ni88 - item/pageID88 of a nav item - used to update same item 
						 in multiple navs, ex HOME button in top and bottom nav
				class="nc nl1 ni88" 
				
				//nothing special about the ID
				id="nid88"
			>
				//actual link used for SEO and so user can right click element to open in new window
				<a 
					href="/saskatoon-web-design/Public Login" 
					onclick="return false" 
					id="npid88" 
					class="nc np"
				>
					Public Login
				</a>
			</div>*/

			#$pageID 0 means this is a root page
			#TOP/HORIZONTAL
			if($navType == 0){	
				#sub navs need unique id's and some unique classes			
				$pageDivID = $subNav ? "sntid" : "ntid";
				$pageDivClass = $subNav ? "nc sntl": "nc ntl";
				$pageParDivID = $subNav ? "sntpid" : "ntpid";
				$pageParClass = $subNav ? "nc sntp" : "nc ntp";
				$pageChildDivID = $subNav ? "stpc" : "tpc";
				$pageChildDivClass = $subNav ? "stpc" : "tpc";
				$jsTreeObj = $subNav ? "satpto" : "atpto";

				if($pageID != 0) $publicPages = $this->getRecordByID($pageID);
				else {
					#roots pages
					$publicPages = $this->getConditionalRecord(
						array(
							  "isTopStyle","1",true,
							  "pageLevel","1",true,
							  "domainID",$_SESSION["domainID"],true
						)
					);
				}
			}
			
			#SIDE/VERTICAL
			if($navType == 1){
				$pageDivID = $subNav ? "snid" : "nid";
				$pageDivClass = $subNav ? "nc snl": "nc nl";
				$pageParDivID = $subNav ? "snpid" : "npid";
				$pageParClass = $subNav ? "nc snp" : "nc np";
				$pageChildDivID = $subNav ? "spc" : "pc";
				$pageChildDivClass = $subNav ? "spc" : "pc";
				$jsTreeObj = $subNav ? "satpo" : "atpo";
				
				if($pageID != 0) $publicPages = $this->getRecordByID($pageID);
				else {
					#roots pages
					$publicPages = $this->getConditionalRecord(
						array(
							  "isSideStyle","1",true,
							  "pageLevel","1",true,
							  "domainID",$_SESSION["domainID"],true
						)
					);
				}
			}
			
			#BOTTOM/HORIZONTAL
			if($navType == 2){		
				$pageDivID = $subNav ? "snbid" : "nbid";
				$pageDivClass = $subNav ? "nc snbl": "nc nbl";
				$pageParDivID = $subNav ? "snbpid" : "nbpid";
				$pageParClass = $subNav ? "nc snbp" : "nc nbp";
				$pageChildDivID = $subNav ? "sbpc" : "bpc";
				$pageChildDivClass = $subNav ? "sbpc" : "bpc";
				$jsTreeObj = $subNav ? "satpbo" : "atpbo";
				
				if($pageID != 0) $publicPages = $this->getRecordByID($pageID);
				else {
					#roots pages
					$publicPages = $this->getConditionalRecord(
						array(
							  "isBottomStyle","1",true,
							  "pageLevel","1",true,
							  "domainID",$_SESSION["domainID"],true
						)
					);
				}
			}
			
			#APPEND CLASS NAMES FOR UNIQUE IDs
			$pageDivID .= "_".$navClass;
			$pageParDivID .= "_".$navClass;
			$pageChildDivID .= "_".$navClass;
			$jsTreeObj .= "_".$navClass;

			#loop through all the pages
			while($y = mysqli_fetch_assoc($publicPages)){
				#only get it once. its a slow function
				if(!isset($_GET["parentPageIDArray"])) {
					$_GET["parentPageIDArray"] = $this->getParentPages($_SESSION["pageID"]);
				}
				
				#if its a member page, see if the user has access to it
				$hasAccess = true;

				if($y["isMembersPage"] == 1 && $_SESSION['sessionSecurityLevel'] < 3){
					
					if($y["allMembers"] == 0) {

						$permArray = array(
							array("LEFT JOIN","public_user_group_page_map","public_pages","pageID","priKeyID"),
							array("LEFT JOIN","public_user_group_map","public_user_group_page_map","publicUserGroupID","publicUserGroupID"),
						);
						
						$_SESSION["userID"] = isset($_SESSION["userID"]) ? $_SESSION["userID"] : 0;
	
						$accessQuery = $this->getConditionalRecord(
							array(
								"public_pages.priKeyID",$y["priKeyID"],true,
								"public_user_group_map.publicUserID",$_SESSION["userID"],true
							),$permArray
						);

						if(mysqli_num_rows($accessQuery) === 0) {
							$hasAccess = false;
						}
					}
					elseif(isset($_SESSION["userID"]) && ($_SESSION["userID"] > 0 || $_SESSION["userID"] < 0)){
						$hasAccess = true;
					}
					else{
						$hasAccess = false;
					}
				}	
				
				if($hasAccess){
					#$pageID 0 means this is a root page
					if($pageID == 0) $this->rootPageID = $y["priKeyID"];

					#this is the root page of a subnav
					else if($firstRec) $this->rootPageID = $pageID;
	
					/*check to see if this child has children. if it does we make a marker 
					so people know to click here to see more pages*/
					$childsChildren = $this->getConditionalRecord(
						array("parentPageID",$y["priKeyID"],true)
					);
					if(mysqli_num_rows($childsChildren) > 0) $children = true;
					else $children = false;
	

					#if the page forwards to another page in the cms
					/*if($y["linkPageID"] != 0) {
						$pageCallID = $y["linkPageID"];
						$tempLinkPage = $this->getRecordByID($y["linkPageID"]);
						$tmpLP = mysqli_fetch_assoc($tempLinkPage);
						$pageCallName = $tmpLP["pageName"];
					}
					else {*/
						$pageCallID = $y["priKeyID"];
						$pageCallName = $y["pageName"];
					/*}*/
	
					#if the page is a null page
					if($y["isNullPage"] > 0) $copyUpdate = '""';
					#don't do a upc, just get the pageText
					else if($y["textOnlyUpdate"]) $copyUpdate = '"upt('.$pageCallID.');"';
					#regular page update
					else $copyUpdate = '"upc('.$pageCallID.',\\"\\");"';
					
					#js accordion params
					if($firstRec){
						$pageRoot = 0;
					}
					else{
						$pageRoot = $this->rootPageID;
					}
					
					#children act differently depending if they are in the a side nav or a top nav
					$rootPageInfo = $this->getRecordByID($this->rootPageID);
					$pageDivClassLvl = $pageDivClass . $y["pageLevel"];

					while($z = mysqli_fetch_assoc($rootPageInfo)){

						#put this element in its hover state so we know its chosen
						if(
							#highlights the current page
							$pageCallID == $_GET["pageID"] ||
							#highlight parent page
							(isset($_GET["parentPageIDArray"]) &&
							(
								in_array($pageCallID,$_GET["parentPageIDArray"])
							)) 
						){
							$pageDivClassLvl .= " fakeHover";
						}
						#else{
							$pageDivClassLvl .= " sel".$pageCallID;
							$pageDivClassLvl .= " pci".$pageCallID;
							$pageDivClassLvl .= " lpi".$y["linkPageID"];
						#}
						
						$onmouseover = $onmouseout = "";
					
						#if the link goes to a url...
						if(strlen($y["linkPageURL"])){
							
							#we can put in a / to indicate current domain
							#Fateme, we don't need to add http, user puts the complete url in linkPageURL input
							if(strlen($y["linkPageURL"]) > 1){
								$onclick = " onclick='window.open(\"" . $y["linkPageURL"] . "\");return false' ";
								$href = $y["linkPageURL"];
							}
							else{
								$onclick = "";
								$href = "index.php?pageID=" . $y["priKeyID"];
							}
							if($navType == 0 || $navType == 2){
								if($y["pageLevel"] == 1){}
								else {
									$onmouseover = " onmouseover='" . $jsTreeObj . ".navHover(this,true);accordionTree.prototype.lastExpanded=\"" . $y["priKeyID"]. "\"'" . PHP_EOL;
									$onmouseout = " onmouseout='" . $jsTreeObj . ".navHover(this,false)'";
								}
							}
						}
						else{
							$onclick = " onclick='" . $jsTreeObj . ".toggleBlind(\"" .$y["priKeyID"]. "\"," . $pageRoot . "," . $copyUpdate . ",\"" . $pageDivID . $y["priKeyID"] . "\",event);return false'" . PHP_EOL;
							$href = rawurlencode($_SESSION["seoFolderName"]) . '/' . rawurlencode($pageCallName);
							if($navType == 0 || $navType == 2){								
								if($children){
									#roots need to set the lastExpandedRoot property
									if($y["pageLevel"] == 1){
										$onmouseover = " onmouseover='accordionTree.prototype.lastExpanded=\"" . $y["priKeyID"]. "\";accordionTree.prototype.lastExpandedRoot=\"" . $y["priKeyID"]. "\"'" . PHP_EOL;
										$onmouseout = " onmouseout=''";
									}
									else{
										$onmouseover = " onmouseover='accordionTree.prototype.lastExpanded=\"" . $y["priKeyID"]. "\"'" . PHP_EOL;
										$onmouseout = " onmouseout=''";
									}
								}
							}
						}
					}
					
					if($children){
						$hasChildrenClass = " hc";
					}
					else{
						$hasChildrenClass = "";
					}
					
					#create our menu item
					echo "<li 
							class='" . $pageDivClassLvl . " ni" . $y["priKeyID"] . $hasChildrenClass ."'
							id='" . $pageDivID . $y["priKeyID"] . "'"
							. $onmouseout . " 
						>" . PHP_EOL;
					
					if(strlen($y["navLabel"]) > 0){
						$tempPageName = $y["navLabel"];
					}
					else{
						$tempPageName = $y["pageName"];
					}
					
					#UTF-8 html safe version of the page name
					$tempPageName = htmlentities(html_entity_decode($tempPageName,ENT_QUOTES, "UTF-8"),ENT_QUOTES, "UTF-8");

					echo '<a 
							class="' . $pageParClass . '" 
							id="' . $pageParDivID . $y["priKeyID"] . '"' . 
							$onmouseover . 
							$onclick .
							'href="/' . $href . '"
							title="' . $tempPageName . '" 
						>' . PHP_EOL .
						  $tempPageName .
					'</a>';
					
					#if this page is selected make it's ul container expanded
					if(
						#is a side nav
						$navType == 1 &&
						isset($_GET["parentPageIDArray"]) && 
						#if its a parent of the selected page
						(in_array($y["priKeyID"],$_GET["parentPageIDArray"]) ||
						#the page itself is selected
						$_GET["pageID"] == $y["priKeyID"])
					){
						$pageChildDivClass = "expand " . $pageChildDivClass;
					}
								
					#if there is children	
					if($children){
						echo "<ul
								class='ec " . $pageChildDivClass . $y["pageLevel"] . "'
								id='" . $pageChildDivID . $y["priKeyID"] . "'" . PHP_EOL . 
								$onmouseover . 
							">";					
						while($x = mysqli_fetch_assoc($childsChildren)){	
							echo $this->getPageTree(
								$x["priKeyID"],$navType,$navClass,$subNav,0
							);
						}
						echo "</ul>";
					}
					echo "</li>";	
				}#has permission to view member page						
			}	
		}
		
		#return an array of parent pages, index 0 is the root
		public function getParentPages($pageID){
			#we don't want getRecordByID to return JSON
			$tempAjax = $this->ajax;
			$this->ajax = false;
			
			#first time through our $pageID is numeric
			if(is_numeric($pageID)) $pageID = array($pageID);
			
			$tempPage = $this->getRecordByID($pageID[0]);
			$tp = mysqli_fetch_assoc($tempPage);
			#change back to what it was
			$this->ajax = $tempAjax;

			#not a root page
			if(is_numeric($tp["parentPageID"])){
				$tempArray = array($tp["parentPageID"]);
				$tempMerged = array_merge($tempArray,$pageID);
				return $this->getParentPages($tempMerged);
			}
			#return root page
			else{
				return $pageID;
			}
		}
		
		public function getPageRootName($rootID){
			$tempAjax = $this->ajax;
			$this->ajax = false;
			
			#get root pageInfo
			$tempPage = $this->getRecordByID($rootID);
			$tp = mysqli_fetch_assoc($tempPage);
			#change back to what it was
			$this->ajax = $tempAjax;
			
			#sometimes there are dash character in page name, looks nicer to return navigation label instead of page name - Fateme
			if ($tp["navLabel"] != "") {
				return $tp["navLabel"];
			}
			else return $tp["pageName"];
		}
		
		public function getPageInfo($pageID){
			$pagesObj = new pages(false,NULL); #need non-ajax results
			
			#return the page based off its name or ID,remove - from negative page id's
			if(is_numeric(ltrim($pageID,"-"))) {
				$result = $pagesObj->getRecordByID($pageID);
			}
			else{
				
				#search between admin or public pages
				if($_SESSION["domainID"] < 0){
					$domainType = 0;
					$domainCompare = "less";
				}
				else{
					$domainType = 1;
					$domainCompare = "greatEqual";
				}
				
				$result = $pagesObj->getConditionalRecord(
					array(
						"pageName",$pageID,true,
						"domainID", $domainType,$domainCompare
					)
				);
				
				#incase we removed the "?" for url params
				if(mysqli_num_rows($result)===0){
					$result = $pagesObj->getConditionalRecord(
						array(
							"pageName",$pageID . "?",true,
							"domainID", $domainType,$domainCompare
						)
					);
				}
			}
			
			#if the page doesn't exist
			if(mysqli_num_rows($result) === 0) {
				$result = $pagesObj->getRecordByID(0);
			}
			
			$pageInfo = $this->processRecord($result);
						
			#we need to see if there is a page for this language
			$result = $pagesObj->getConditionalRecord(
				array(
					"groupID", $pageInfo["groupID"], true,
					"domainID", $_SESSION["domainID"],true
				)
			);
			
			#if the page doesn't exist
			if(mysqli_num_rows($result) === 0) {
				$result = $pagesObj->getRecordByID(0);
			}
			
			$pageInfo = $this->processRecord($result);
			
			#the fact that we have this many variables all getting the pageID tells me there should  be a better way - Jared
			$_SESSION["pageID"] = $_REQUEST["pageID"] = $_GET["pageID"] = $pageInfo["priKeyID"];			
			return $pageInfo;
		}
				
		public function getPage($pageID){
			#display all errors an notifications. ie 7 & 8 can 
			#error out if too many PHP notifications are supressed
			error_reporting(E_ALL);
			$GLOBALS['isPublic'] = true; #public side module
			$pagesObj = new pages(false, NULL); #need non-ajax results											
			$pageInfo = $pagesObj->getPageInfo($pageID);
			
			$_SESSION["pageName"] = $pageInfo["pageName"];
		
			#if the page redirects
			if(
				is_numeric($pageInfo["linkPageID"]) && 
				$pageInfo["linkPageID"] != 0 && 
				$pageInfo["linkPageID"] != NULL
			){
				$tempForwardPage = $pageInfo;
				
				$linkedResult = $pagesObj->getRecordByID($pageInfo["linkPageID"]);
				$pageInfo = $this->processRecord($linkedResult);

				#set the default URL parameters from the page thats redirecting
				if(strlen($tempForwardPage["defPageURLParams"]) > 0){
					$_REQUEST["defPageURLParams"] = $tempForwardPage["defPageURLParams"];
					unset($tempForwardPag);
				}
				else{
					$_REQUEST["defPageURLParams"] = $pageInfo["defPageURLParams"];
				}
			}
			else{
				$_REQUEST["defPageURLParams"] = $pageInfo["defPageURLParams"];
			}
			
			$pageID = $pageInfo["priKeyID"]; 
			 	
			#check if its a member only page, if it is check if they are logged in
			$hasAccess = false;

			if($pageInfo["isMembersPage"] == 1 ){
				#all members have access to this page
				if(
					($pageInfo["allMembers"] == 1 && 
					isset($_SESSION["userID"]) && $_SESSION["userID"] != 0) ||
					$_SESSION['sessionSecurityLevel'] >= 3
				){
					$hasAccess = true;
				}
				#must be in a user group with access
				else{
					#get all user groups for this user, and see if any of them are mapped to this page
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroupPageMap.php");
					$publicUserGroupPageMapObj = new publicUserGroupPageMap(false,NULL);
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUserGroups/publicUserGroupMap.php");
					$publicUserGroupMapObj = new publicUserGroupMap(false,NULL);
					
					$_SESSION["userID"] = isset($_SESSION["userID"]) ? $_SESSION["userID"] : 0;
					
					#get user groups
					$mappedGroups = $publicUserGroupMapObj->getConditionalRecord(
						array("publicUserID",$_SESSION['userID'],true)
					);
				
					#if the user is mapped to groups...
					if(mysqli_num_rows($mappedGroups) > 0){ 
						#check if the users groups are mapped to the page
						$mappedUserGroupIDList = $publicUserGroupMapObj->getQueryValueString($mappedGroups,"publicUserGroupID");
						$mappedPages = $publicUserGroupPageMapObj->getConditionalRecordFromList(
							array(
								"publicUserGroupID",$mappedUserGroupIDList,true,
								"pageID",$pageID,true
							)
						);
						if(mysqli_num_rows($mappedPages) > 0){
							$hasAccess = true;
						}
					}
				}
				#no member access
				if(!$hasAccess){
					#redirect them to the page id set in the nonMemberRedirect field in public_pages if it is not null
					$_SESSION["desiredPage"] = $pageID;

					if(is_numeric($pageInfo['nonMemberRedirect'])) {
						$pageID = $pageInfo['nonMemberRedirect'];
					}
					#the default non member redirect page set in cmsSettings.php
					else {
						$pageID = $_SESSION['nonMemberDefaultRedirect'];
					}
					
					$result = $pagesObj->getRecordByID($pageID);
					$pageInfo = $this->processRecord($result);
					
					#what page to go to if we create and account to access the page
					$pageArray['desiredPage'] = $_SESSION["desiredPage"];
				}
			}
			
			#the fact that we have this many variables all getting the pageID tells me there should  be a better way - Jared
			$_SESSION["pageID"] = $_REQUEST["pageID"] = $_GET["pageID"] = $pageInfo["priKeyID"];
			$pageID = $pageInfo["priKeyID"]; 
			
			#get the parent page info, if this is > level1, otherwise set itself as the parent
			if(is_numeric($pageInfo["parentPageID"]) && $pageInfo["parentPageID"] > 0){
				#array of all parents
				$parentPageArray = $this->getParentPages($pageInfo["priKeyID"]);
				#index 0 is the root
				$rpi = $pagesObj->getRecordByID($parentPageArray[1]);
				$rootPageInfo = mysqli_fetch_assoc($rpi);
				$_GET["rootPageID"] = $rootPageInfo["priKeyID"];
			}
			else{
				$rootPageInfo = $pageInfo;
				$_GET["rootPageID"] = $pageInfo["priKeyID"];
			}
			
			#$_GET so we can use the pageName in our modules
			$_GET['pageName'] = $pageInfo['pageName'];
			$_GET['rootPageName'] = $rootPageInfo['pageName'];

			#get all the modules for this page
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
			$moduleObj = new module(false, NULL);
			$pageModules = $moduleObj->getModuleInfoQuery($_GET["pageID"]);
			
			#check if page has primary modules
			$hasPrimaryMod = false;
			while($pMod=mysqli_fetch_assoc($pageModules)){
				if($pMod["isPrimaryPageModule"] == 1){
					$hasPrimaryMod = true;
				}
			}

			#last empty segment in URI can't belong to module. do 404 redirect
			/*if(
				#last empty segment in URI
				isset($_GET["hasLastEmptyURI"]) && $_GET["hasLastEmptyURI"] && 
				(!isset($_GET["cms301"]) || (isset($_GET["cms301"]) && !$_GET["cms301"])) &&
				#no modules, or no primary modules
				(mysqli_num_rows($pageModules) == 0 || !$hasPrimaryMod)
			){
				header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
				header("Location: /index.php?pageID=-5");
			}*/

		 	$_GET["moduleRunScripts"] = "";
			$_GET["moduleScripts"] = "";
			$_GET["moduleStyles"] = "";
			
			$beforeModuleCode = "";
			$afterModuleCode = "";

			/*
			-set up instances
			-get the script code as text then insert into script tag. this 
			 way we can append to $moduleScripts for our level2 js code
			 */
			 
			mysqli_data_seek($pageModules,0);
			while($pMod=mysqli_fetch_assoc($pageModules)){
				if($pMod["isTemplate"]==0 || $pMod["isTemplate"]==1 || $pMod["isTemplate"]==3){
					include($_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/pages/pageModuleBuild.php");
				}
				else{  
	
					$modContents = $this->getModuleContents(
						$_SERVER['DOCUMENT_ROOT'] . $pMod["includeFile"],
						$pMod["priKeyID"],$pageInfo
					);
					
					#if we're using a short code
					if(isset($pageInfo) && strpos($pageInfo['pageCode'], "pmpmID" . $pMod["priKeyID"]) !== false){
						
						#replace the short code with the module
						$pageInfo['pageCode'] = $modContents;
					}
					else {
						#appears after pageText
						if($pMod["beforeAfter"]==1) {
							$afterModuleCode .= $modContents;
						}
						#appears before pageText
						else{
							$beforeModuleCode .= $modContents;
						}
					}	
					
					#if a module requires multiple script files we separate them
					#with ?^^? in the modules table
					ob_start();
					$jScripts = explode("?^^?",$pMod["jScript"]);
					foreach($jScripts as $s){
						if(strlen($s) > 0) {
							include($_SERVER['DOCUMENT_ROOT'] . $s);
							$_GET["moduleScripts"] .= ob_get_contents();
						}
					}
					ob_end_clean();
					
					#functions to run when the scripts load
					$jRunScripts = explode("?^^?",$pMod["runFunction"]);
					foreach($jRunScripts as $s){
						if(strlen($s) > 0) {
							$_GET["moduleRunScripts"] .=  ";" . $s;
						}
					}
					
					ob_start();
						if(strlen($pMod["cssLink"]) > 0) {
							include($_SERVER['DOCUMENT_ROOT'] . $pMod["cssLink"]);
						}
					$_GET["moduleStyles"] .= ob_get_contents();
					ob_end_clean();
				}
			}

			#user wants to display the sub navigation on this page and its children
            if($pageInfo["showSubNav"] == 1 || $rootPageInfo["showSubNav"]) {
                
                #determine if its a side or top instance
                if($pageInfo["subNavType"] == 1) $tmpPmPmID = -75;
                else $tmpPmPmID = -80;
                
                $pageModules = $moduleObj->getModuleInfoQuery(NULL,$tmpPmPmID);
                $pMod=mysqli_fetch_assoc($pageModules);
                                
                include($_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/pages/pageModuleBuild.php");
            }

			$pageArray = array();
			if(isset($_GET["primaryModulePageTitle"]) && strlen($_GET["primaryModulePageTitle"]) > 0){
				#add module item info to the page title
				$pageArray['pageTitle'] = $_GET["primaryModulePageTitle"]; 
				$pageArray['pageName'] = $pageInfo['pageName'];
			}
			else{
				$pageArray['pageTitle'] = $pageInfo['pageTitle'];
				$pageArray['pageName'] = $pageInfo['pageName'];
			}
		
			$pageArray['pageCode'] = '<div class="pageText" id="pageText' . $_GET["pageID"] . '" >
									 '. $pageInfo['pageCode'] .'</div>' . PHP_EOL;
			$pageArray['metaWords'] = $pageInfo['metaWords'];
			$pageArray['metaDesc'] = $pageInfo['metaDesc'];
			$pageArray['beforeModuleCode'] = $beforeModuleCode;
			$pageArray['afterModuleCode'] = $afterModuleCode;
			$pageArray['moduleScripts'] = $_GET["moduleScripts"];
			$pageArray['moduleRunScripts'] = $_GET["moduleRunScripts"];
			$pageArray['pageTransition'] = $_SESSION["pageTransition"];
			$pageArray['modulePageTransition'] = $_SESSION["modulePageTransition"];
			$pageArray['moduleRunScripts'] .= (!empty($pageInfo['postUpdate']) && 
												$_SESSION["singlePageSite"] == 0) ? 
												"\n".$pageInfo['postUpdate'] : "";
			$pageArray['moduleStyles'] = $_GET["moduleStyles"];
			$pageArray['priKeyID'] = $pageInfo['priKeyID'];
			$pageArray['rootPageID'] = $_GET['rootPageID'];
			#if we are using php 5.4 we can use the 2nd json_encode param for UTF_8 problems. see bug 153	
			if($this->ajax) echo json_encode($pageArray);
			else return $pageArray;											
		}	
	}
	
	#$_REQUEST["pmpmID"] used in adding from bulk add/edit	
	if(isset($_REQUEST["function"])){
		$moduleObj = new pages(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new pages(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>