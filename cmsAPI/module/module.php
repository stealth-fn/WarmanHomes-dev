<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class module extends common{				
		public $moduleTable = "modules";
		
		#gets mapped query between public_module_map and the modules table
        public function getModuleInfoQuery($pageID = NULL,$publicModulePageMapID = NULL){
 
            #if null we're loading in standard modules, get admin or public modules
            if(is_null($pageID) && is_null($publicModulePageMapID)) {
                #standard public
                if($_SESSION["domainID"] > 0) {
                    $pageID = -1;
                }
                #standard admin
                else{
                    $pageID = -2;
                }
            }
            elseif(!is_null($pageID)){
                #get pages for the group
                include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
                $pagesObj = new pages(false,NULL);
 
                #get this page
                $tempPage = $pagesObj->getRecordByID($pageID);
                
                #get all pages in the same group
                $x = mysqli_fetch_assoc($tempPage);
                $groupPages = $pagesObj->getConditionalRecord(
                    array("groupID",$x["groupID"],true)
                );
                
                #turn our query into a list of ID's
                $pageID = $pagesObj->getQueryValueString($groupPages,"priKeyID");
            }
            
            /*set the priKeyID of public_module_page_map to the priKeyID for the query
            which ends up becoming the priKeyID property of our $priModObj object
            
            the if conditions in the select field list should make sure fields from the
            public_module_page_map overwrrite fields from the modules table
            */        
            $pageModuleQuery = '
            SELECT 
                modules.*, 
                public_module_page_map.*, 
                public_pages.pageName AS pageName,
                public_pages.defPageURLParams AS defPageURLParams,
                public_module_page_map.priKeyID AS priKeyID,
                IF(CHAR_LENGTH(public_module_page_map.primaryPmpmAddEditID) > 0, public_module_page_map.primaryPmpmAddEditID,modules.primaryPmpmAddEditID) AS primaryPmpmAddEditID
            FROM modules
            LEFT JOIN public_module_page_map
            ON (modules.priKeyID = public_module_page_map.moduleID)
            LEFT JOIN public_pages
            ON (
                public_module_page_map.pageID = public_pages.priKeyID OR
                public_module_page_map.pageID = "shortcode"
            )
            WHERE ';
            
            /*getting all the modules for a page
                -1 is standard public modules
                -2 is standard admin modules*/
                
            /*FIND_IN_SET() lets us map a module to more than one page by seperating out
            the pageID's with ,'s in the public_module_page_map
            
            IN() is used to map a module to more than one groupID (for example 
            for multi-lingual sites)*/
			$pageIDArray = explode(",",$pageID);
			$tempArray = array_values($pageIDArray);
			$firstValue = $tempArray[0];
			
			#know where we are while looping through the pageID's
			$x = 1;


				if($pageID !== NULL){

						$pageModuleQuery .= 
							" (FIND_IN_SET('". 
							$GLOBALS["mysqli"]->real_escape_string($pageID) . "' , public_module_page_map.pageID) 
							OR public_module_page_map.pageID IN (" . $GLOBALS["mysqli"]->real_escape_string($pageID) . ")
							OR (
									(
										public_pages.pageCode LIKE concat('%<div id=\"pmpmID',public_module_page_map.priKeyID,'%' ) OR
										public_pages.pageCode LIKE concat('%[pmpmID',public_module_page_map.priKeyID,'%' )
									) AND
									public_module_page_map.pageID = 'shortcode' AND
									public_pages.priKeyID IN (" . $_SESSION["pageID"] . ")
								)
							)";
					
				}

			
            
            #used for thumbnail, moduleLevel > 1, pagination
            if($publicModulePageMapID !== NULL){
				if($pageID !== NULL){
					$pageModuleQuery .= " OR ";
				}
                $pageModuleQuery .= 
                    " public_module_page_map.priKeyID = '". 
                    $GLOBALS["mysqli"]->real_escape_string($publicModulePageMapID) . "'";
            }
            #if querying for a whole page
            else{
                $pageModuleQuery .= " AND public_module_page_map.isActive = 1 "; 
            }
            #echo $pageModuleQuery;
            return $this->getCheckQuery($pageModuleQuery);
        }
		
	

		
		#recursively setup module javascript. recursion is used for children of children...
		#ex. thumbnail of thumbnail of gallery
		public function setModuleScript($priModObj){
			
			if(!isset($_GET["moduleScripts"])){
				$_GET["moduleScripts"] = "";
			}

			#add/edit form JS Object or module items JS Object
			if(
				$priModObj[0]->isTemplate==0 || 
				$priModObj[0]->isTemplate==1 ||
			 	$priModObj[0]->isTemplate==3
			){
				$_GET["moduleScripts"] .= '
				mIP =' . $priModObj[0]->jsonInstanceProp . ';

				if(!window[mIP.modProp.jsObject]){
					window[mIP.modProp.jsObject] = function(){};
					window[mIP.modProp.jsObject].prototype = new stealthCommon();
				};';
			}

			#make an instance of out module type js object, if there is one
			if(
				strlen($priModObj[0]->jsObject) > 0 && 
				(
					$priModObj[0]->isTemplate==0 || 
					$priModObj[0]->isTemplate==1 ||
					#trying this out for the password reset module
					$priModObj[0]->isTemplate==3
				)
			){	
				#module settings
				$_GET["moduleScripts"] .= '
				window[mIP.modProp.jsObject].prototype.moduleID = mIP.instanceProp.moduleID;
				window[mIP.modProp.jsObject].prototype.primaryPmpmAddEditID = mIP.modProp.primaryPmpmAddEditID;
				window[mIP.modProp.jsObject].prototype.addEditPageID = mIP.modProp.addEditPageID;
				window[mIP.modProp.jsObject].prototype.isTemplate = mIP.modProp.isTemplate;

				//ADD EDIT module properties
				window[mIP.modProp.jsObject].prototype.apiPath = mIP.modProp.primaryAPIFile;
				window[mIP.modProp.jsObject].prototype.moduleAlert = mIP.modProp.moduleAlert;
				
				//defaults for input fields that need to be handled in a special manner
				//format date and time for mysql
				window[mIP.modProp.jsObject].prototype.timeFields = "";
				';
								
				#module instance settings
				$_GET["moduleScripts"] .= '
				window[mIP.instanceProp.className + "Obj"] = function(){};
				window[mIP.instanceProp.className + "Obj"].prototype = new window[mIP.modProp.jsObject]();	
							
				//automatically append instance properties
				for(var key in mIP.instanceProp) {
					if(key == "priKeyID") {
						window[mIP.instanceProp.className + "Obj"].prototype.pmpmID = mIP.instanceProp[key];
					}
					else if(key == "className"){
						window[mIP.instanceProp.className + "Obj"].prototype.moduleClassName = mIP.instanceProp[key];
					}
					
					else if(key == "clickScroll"){
						window[mIP.instanceProp.className + "Obj"].prototype.slideAxis = mIP.instanceProp[key];
					}
					
					else if(key == "displayQty"){
						window[mIP.instanceProp.className + "Obj"].prototype.holdQty = parseInt(mIP.instanceProp[key]);
					}
										
					else{
						window[mIP.instanceProp.className + "Obj"].prototype[key] = mIP.instanceProp[key];
					}
				}	
				';
				
				#alert the developer if they chose a bad className
				if($priModObj[0]->className . "Obj" === $priModObj[0]->jsObject){
					$_GET["moduleScripts"] .= "console.log('Stealth Error: Your className appended to \"Obj\" is the same as your jsObject. Change this modules className.');";
				}
				
				#this module is probably being opened from withint another module
				if(isset($_REQUEST["quickEdit"])) {
					$_GET["moduleScripts"] .= 'window[mIP.instanceProp.className + "Obj"].prototype.quickAddEdit = true;';
				}
				
				$_GET["moduleScripts"] .= '
				window[mIP.instanceProp.className + "Obj"].prototype.slideFinished = true;';
				
				/*if we initialize this for the forms as well, it overwrites the 
				first record when we add new records in the bulkAddEdit*/
				if(
					!isset($priModObj[0]->bulkMod) ||
					isset($priModObj[0]->bulkMod) && !isset($_GET["pmpmID"]
				)){
					$_GET["moduleScripts"] .= '
					window[mIP.instanceProp.className] = new window[mIP.instanceProp.className + "Obj"]()	
					';
				}

			}
			
			#load in rating system javascript
			if($priModObj[0]->hasRating == 1){
				ob_start();
				
				#for some reason if we include this file it breaks the PHP output buffer!
				#include_once($_SERVER['DOCUMENT_ROOT'] . "/js/rating/jquery.MetaData.js");
				include_once($_SERVER['DOCUMENT_ROOT'] . "/js/rating/jquery.rating.js");
				
				$_GET["moduleScripts"] .= ob_get_contents();
				ob_end_clean();
			}
			
			#we only need to load in the script files once per module
			ob_start();
			if(!$priModObj[0]->isThumb){
				#loop through the scripts for this module
				$jScripts = explode("?^^?",$priModObj[0]->jScript);
				foreach($jScripts as $s){
					if(strlen($s) > 0) {
						include($_SERVER['DOCUMENT_ROOT'].$s);
					}
				}
			}
				
			#if it's an add/edit module build up for our forms
			if($priModObj[0]->isTemplate == 0 || $priModObj[0]->isTemplate==1) {
				include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/moduleScriptObjects.php");
			}
			
			$_GET["moduleScripts"] .= ob_get_contents();
			
			ob_end_clean();
			
			if($priModObj[0]->instanceDisplayType==2){
				#set pagination properties
				if(isset($priModObj[0]->currentPagPage) && is_numeric($priModObj[0]->currentPagPage)){
					$_GET["moduleScripts"] .= 'window[mIP.instanceProp.className].pagPage = "' . $priModObj[0]->currentPagPage .  '";';
				}
				else $_GET["moduleScripts"] .= 'window[mIP.instanceProp.className].pagPage = 1;';
				/*how many pages we can paginate through, don't update this on paginate
				because our paginate query is only the records we are displaying*/
				if(
					(strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") === false &&
					strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") === false) /*&&
					#not a module level > 2
					I DON"T KNOW WHY WE HAD THIS CONDITION IN THERE! - jared
					!isset($priModObj[1])*/
				){
					$_GET["moduleScripts"] .= 'window[mIP.modProp.jsObject].prototype.maxPagPage = "' . $priModObj[0]->pageCounter . '";';
				}
			}
			
			if($priModObj[0]->isThumb){
				$parentModule = $this->getModuleInfoQuery(
					NULL,$priModObj[0]->thumbParentID
			   );
												
				$tm = mysqli_fetch_assoc($parentModule);
																
				#set parent class here to use in recursive call
				$priModObj[0]->parentClassName = $tm["className"];
				$priModObj[0]->parentDisplayType = $tm["instanceDisplayType"];	
				
				$functionType = "";
				
				#fade rotate
				if($priModObj[0]->parentDisplayType == 0)
					$functionType = "parentFade";	
				#click slide
				else if($priModObj[0]->parentDisplayType == 3) {
					$functionType = "parentSlide";
				}
				
				#prototype the module item to control the parent module frame item we keep track 
				#of the parent and child instance name so they can call each others functions
				$_GET["moduleScripts"] .= '
				
				window[mIP.instanceProp.className].parentClassName = "' . $priModObj[0]->parentClassName . '";
				window[mIP.instanceProp.className].parentDisplayType = "' . $priModObj[0]->parentDisplayType . '";
				
				moduleInstanceItems = $(".mi-" + mIP.instanceProp.className);
				var tmpMiCnt = moduleInstanceItems.length;

				for(var m = 0; m < tmpMiCnt; m++){
					moduleInstanceItems[m].onclick = function(){' . $priModObj[0]->className . '.' . $functionType . '(this);}
				}
				';
			}
			
			if($priModObj[0]->expandContractMIs == 1){
				$_GET["moduleScripts"] .= '
				$("#mfmc-'.$priModObj[0]->className.'").on(
					"click", ".expandBtn,.closeBtn",
					function(){
						if($(this).hasClass("expandBtn")){
							var isExpanded = $(this).parent().hasClass("expanded") ? true : false;
							$("#mfmc-'.$priModObj[0]->className.'").find(".expandWrap.expanded").switchClass("expanded","",500).find(".expandable.exp").switchClass("exp","",500);
							
							
							if(!isExpanded){
								$(this).next().switchClass("","exp",500).parent().switchClass("","expanded",500);
							}
							
							$(this).parent().siblings().removeClass("expanded").find(".expandable.exp").switchClass("exp","",500);
						}
						else{
							$(this).parent().siblings().removeClass("expanded").find(".expandable.exp").switchClass("exp","",500);
							$(this).parent().removeClass("expanded");
						}
					});
				';
			}
			
			#disqus comments
			if($priModObj[0]->hasComments == 1){
				
				#the disqus_config callback fixes a bug when we would show/hide the disqus container
				$_GET["moduleScripts"] .= '
					var disqus_shortname = "' . $priModObj[0]->disqusShortname . '";
					disqus_url = "http://' . $_SERVER['SERVER_NAME'] . '/index.php?pageID=' . $priModObj[0]->pageID  . $priModObj[0]->commentPriKeyIDParam . "=" .$priModObj[0]->queryResults["priKeyID"] . '";
					disqus_config = function() {
						this.callbacks.onReady = [function() {
							$("#disqus_thread iframe").css({
								"height": "500px",
								"height": "auto !important",
								"min-height": "500px",
								"overflow": "scroll !important"
							});
						}];
					};
					
					(function() {
						var dsq = document.createElement("script"); 
						dsq.type = "text/javascript"; dsq.async = true;
						dsq.src = "http://" + disqus_shortname + ".disqus.com/embed.js";
						(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
       				 })();
				';
			}
			
			#SHARE THIS
			if(
				isset($priModObj[0]->domFields) &&
				array_key_exists("Social Media",$priModObj[0]->domFields)
			){
				
				$_GET["moduleScripts"] .= '	
					//load share this buttons
					if(typeof window.stButtons === "undefined")	{			
						$.getScript("http://w.sharethis.com/button/buttons.js", function(data, textStatus, jqxhr) {
							var switchTo5x = true;
							stLight.options({publisher: "4b8fe4b5-0457-40d3-8a33-2937aa537cd0", doNotHash: false, doNotCopy: false, hashAddressBar: false});
										
						});
					}
					//reinitializes the buttons if we already loaded sharethis once
					else{
						stButtons.locateElements();		
					}
				';
			}
					
			#prototype functions to module items to stop/start
			if(
				$priModObj[0]->autoChange == 1 && 
				$priModObj[0]->autoChangeMouseOverDisable == 1
			){

				#standard module
				if($priModObj[0]->pageID < 0) {
					$timerObj = "standardInterTime";
				}
				#page module
				else { 
					$timerObj = "pageInterTime";
				}
				
				#fade rotate
				$mouseOutFunction = "";
				if($priModObj[0]->instanceDisplayType == 0 ||
				$priModObj[0]->instanceDisplayType == 4){
					$_SESSION["modulePageTransition"] .= $mouseOutFunction.= 
					$timerObj . '.' . $priModObj[0]->className . ' = setInterval(
						\'' . $priModObj[0]->className . '.fadeRotate(' . $priModObj[0]->autoChangeDirection . ')\',
						' . $priModObj[0]->autoChangeDuration . '
					);' . PHP_EOL;
				}
				#click slide
				else if($priModObj[0]->instanceDisplayType == 3){
					$_SESSION["modulePageTransition"] .= $mouseOutFunction.= 
					$timerObj . '.' . $priModObj[0]->className . ' = setInterval(
						\'' . $priModObj[0]->className . '.clickSlide(' . $priModObj[0]->autoChangeDirection . ')\',
						' . $priModObj[0]->autoChangeDuration . '
					);' . PHP_EOL;
				}
				
				if(
					$priModObj[0]->instanceDisplayType == 0 ||
					$priModObj[0]->instanceDisplayType == 4 ||
					$priModObj[0]->instanceDisplayType == 3
				){
					
					#can't set this until the dom is ready
					$_SESSION["modulePageTransition"] .= '
						$s("mfmc-' . $priModObj[0]->className . '").onmouseover = 
						function(event){
							if(event){
								event.cancelBubble = true; //prevent event bubbling
								if(event.stopPropagation) { 				event.stopPropagation();
								}
							}

							if(typeof(' . $timerObj . '.' . $priModObj[0]->className . ') !== "undefined"){console.log("fateme",event);	
								window.clearInterval(' . $timerObj . '.' . $priModObj[0]->className . ');
							}
						}
						
						$s("mfmc-' . $priModObj[0]->className . '").onmouseout = 
						function(event){
							if(event){
								event.cancelBubble = true; //prevent event bubbling
								if(event.stopPropagation) event.stopPropagation();
							}

							' . $mouseOutFunction . '
						}
					'
					;
				}
			}

			#setup thumnails for this module	
			if($priModObj[0]->clickThumbs == 1){			
				$thumbModule = $this->getModuleInfoQuery(
					NULL,$priModObj[0]->clickThumbsPmpmID
			   );
												
				$tm = mysqli_fetch_assoc($thumbModule);
								
				/*if this is a level 2 or greater module, append the prikeyID 
				of the parent to the class name to keep unique id's in the html*/
				$objQty = count($priModObj);
				
				$tempParentPriKeyIDs = "";
				for($x = 0; $x < $objQty; $x++) {
					if(isset($priModObj[$x]) && isset($priModObj[$x]->queryResults)) {
						#used in the DOM
						$tempParentPriKeyIDs .= $priModObj[$x]->queryResults["priKeyID"];
					}
				}

				#we keep track of the parent and child instance name so they can call each others functions
				$_GET["moduleScripts"] .= 'window[mIP.instanceProp.className].childClassName = "' . $tm["className"] . $tempParentPriKeyIDs . '";';
			}
		}
	}

	#$_REQUEST["pmpmID"] used in adding from bulk add/edit	
	if(isset($_REQUEST["function"])){
		$moduleObj = new module(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new module(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>