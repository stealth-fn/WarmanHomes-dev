<?php	
	#create our CMS url query string
	include($_SERVER['DOCUMENT_ROOT'] . "/public/moduleFrame/requestString.php");
		
	#record qty in query
	$priModObj[0]->recordCount = mysqli_num_rows($priModObj[0]->primaryModuleQuery);
	
	#adding a record through bulk add/edit. need to say
	#we have at least 1 record to go into the module
	if(isset($_REQUEST["pmpmID"]) && isset($priModObj[0]->bulkMod)){
		if($priModObj[0]->recordCount==0){
			$priModObj[0]->recordCount = 1;
		}
	}

	#how many pagination pages there are
	if($priModObj[0]->instanceDisplayType==2){
		#store this as session variable since we might do a 2nd ajax request to reset the pagination
		$priModObj[0]->pageCounter = ceil(
			$priModObj[0]->recordCount/$priModObj[0]->displayQty
		);
	}
	
	#loop through the home page products articles
	if($priModObj[0]->displayQty == -1){
		$priModObj[0]->displayQty = $priModObj[0]->recordCount;
	}

	#default pagPage
	if(!isset($priModObj[0]->pagPage)) {
		$priModObj[0]->pagPage = 1;
	}

	#how many queries into the loop are we 
	$priModObj[0]->qryLoopCnt = 0;
	
	#if its an empty query for an add/edit we still want to load our module
	if(
		$priModObj[0]->isTemplate==0 ||
		#hack for the login module...
		$priModObj[0]->moduleID==37		
	){
		$loopOnce = false;
	}
	else{
		$loopOnce = true;
	}

	#make sure our query pointer is at it's proper starting location
	if(mysqli_num_rows($priModObj[0]->primaryModuleQuery) > 0) {

		#Hard refresh or UPC
		if(
			isset($priModObj[0]->pagPage) &&
			strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") === false  &&
			strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") === false ||
			#...or paginated and a module level > 1
			(
				(strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") !== false ||
				strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") !== false) &&
				isset($priModObj[1])
			)||
			#refreshing pagination, with a pagination request
			isset($priModObj[0]->refreshPag) && $priModObj[0]->refreshPag
			
		){
			#visible elements
			if(
				!isset($priModObj[0]->clickStorage) || 
				(isset($priModObj[0]->clickStorage) && $priModObj[0]->clickStorage == 0)
			){
				#if we are on the first page, don't put the pointer to -10
				$tmpDsp = ($priModObj[0]->pagPage * $priModObj[0]->displayQty) - $priModObj[0]->displayQty;
	
				if($tmpDsp >= 0){
					$tmpPointer = $tmpDsp;
				}
				else{
					$tmpPointer = 0;
				}
				
				#only show the number of elements we're supposed to display
				$priModObj[0]->loopQty = $priModObj[0]->displayQty;
			}
			#loading items into the click slide storage container
			else{
				#start our query where it left off
				$tmpPointer = $priModObj[0]->displayQty;
				
				#loop through the rest of them, since -1 is all
				$priModObj[0]->loopQty = -1;
			}
			

			if(mysqli_num_rows($priModObj[0]->primaryModuleQuery) > $tmpPointer) {
				mysqli_data_seek($priModObj[0]->primaryModuleQuery,$tmpPointer);
			}
		}
		#Pagination, we only query the records we're changing
		else{
			mysqli_data_seek($priModObj[0]->primaryModuleQuery,0);
			
			#only show the number of elements we're supposed to display
			$priModObj[0]->loopQty = $priModObj[0]->displayQty;
		}
	}

	while(
		#looping through our module records...
		(
			($priModObj[0]->queryResults = mysqli_fetch_assoc($priModObj[0]->primaryModuleQuery)) &&
			#...if we're displaying all, or just through through the display quantity
			($priModObj[0]->loopQty == -1 || ($priModObj[0]->qryLoopCnt < $priModObj[0]->loopQty))
		) ||
		#go in at least once if we're adding a new record
		(!$loopOnce)
	){	

		#different css class to style every other one differently
		if($priModObj[0]->qryLoopCnt % 2 == 0) {
			$oddEven = "even";
		}
		else $oddEven = "odd";
	
		#main DOM for the module
		$adminStyleClass = "";
		if(
			($_SESSION["domainID"] < 0 && 
			#don't add this class for non-DOM-framework modules
			$priModObj[0]->isTemplate != 2 && $priModObj[0]->isTemplate != 3) ||
			#quick edit
			(isset($_REQUEST["quickEdit"]) && $_REQUEST["quickEdit"])
		){
			$adminStyleClass = "moduleContainer";

			if(isset($priModObj[0]->bulkMod)) {
				$adminStyleClass.= "Blk";
			}
			
			#add/edit module
			if($priModObj[0]->isTemplate == "0"){
				$adminStyleClass.= " addEditMod";
			}
			#template/list module
			else if($priModObj[0]->isTemplate == "1"){
				$adminStyleClass.= " tempMod";
			}
		}
		
		#default css 'clicked' class for first one
		if($priModObj[0]->qryLoopCnt == 0 && $priModObj[0]->isThumb){
			$clickedThumb = "clicked";
		}
		else{
			$clickedThumb = "";
		}
		?>
		
		<div 
			<?php if($priModObj[0]->itemscope == 1) echo 'itemscope=itemscope'; ?>
			<?php if(strlen($priModObj[0]->itemtype) > 0) echo 'itemtype="' . $priModObj[0]->itemtype . '"'; ?>
			class="mi mi_<?php echo $oddEven; ?> mi_<?php echo $priModObj[0]->originalClassName; ?> mi-<?php echo $priModObj[0]->className . " " . $adminStyleClass . " " . $clickedThumb; ?>"			
			id="<?php echo $priModObj[0]->miPrefix; ?>_<?php echo $priModObj[0]->className; ?>_<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>"
			<?php
				if(
					isset($_SESSION['sessionSecurityLevel']) && 
					$_SESSION['sessionSecurityLevel'] ==3
				) {
					
				}
			?>
		>
		<?php
			#add/edit
			if($priModObj[0]->isTemplate == 0){
				#DOM for add/edit forms
				include($_SERVER['DOCUMENT_ROOT']."/modules/moduleFrame/addEditFrame.php");
			}
			#DOM list
			elseif($priModObj[0]->isTemplate == 1){
								
				#check if it's the primary module on the page
				if(
					$priModObj[0]->isPrimaryPageModule == 1 && 
					isset($priModObj[0]->queryResults[$priModObj[0]->primaryPageModuleTitleField])
				) {
					#set page title and open graph title
					$_GET["openGraph"]["title"] = $_GET["primaryModulePageTitle"] = 
					strip_tags(
						$priModObj[0]->queryResults[$priModObj[0]->primaryPageModuleTitleField]
					);
					
					$microDataLink = rawurlencode($_GET["openGraph"]["title"]);
					
					#remove html tags
					$tempDesc = strip_tags(html_entity_decode(
						$priModObj[0]->queryResults[$priModObj[0]->primaryPageModuleDescField]
					));
					
					#trim our description
					$tempDesc = substr($tempDesc,0,"200") . '...';
					
					#set open graph description
					$_GET["openGraph"]["description"] = htmlentities(
						$tempDesc,ENT_QUOTES, "UTF-8"
					);
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
					$pagesObj = new pages(false,NULL);
					$primaryModPage = $pagesObj->getRecordByID($priModObj[0]->primaryModulePage);
					$pmp = mysqli_fetch_assoc($primaryModPage);
					
					$_GET["recordUrl"] = $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME'] . '/' . $_SESSION["seoFolderName"] .  '/' . rawurlencode ($pmp["pageName"]) . '/' . $microDataLink;
				}
				#don't overwrite one if its already set
				elseif(
					!isset($_GET["openGraph"]["title"]) &&
					strlen($priModObj[0]->primaryPageModuleTitleField) > 0
				){
					$_GET["primaryModulePageTitle"] = "";
		
					$microDataLink = rawurlencode(strip_tags(
						$priModObj[0]->queryResults[$priModObj[0]->primaryPageModuleTitleField]
					));
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
					$pagesObj = new pages(false,NULL);
					$primaryModPage = $pagesObj->getRecordByID($priModObj[0]->primaryModulePage);
					$pmp = mysqli_fetch_assoc($primaryModPage);
					
					$_GET["recordUrl"] = $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME'] . '/' . $_SESSION["seoFolderName"] .  '/' . rawurlencode ($pmp["pageName"]) . '/' . $microDataLink;				
				}
				elseif(
					!isset($_GET["openGraph"]["title"]) &&
					strlen($priModObj[0]->primaryPageModuleTitleField) == 0
				){
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
					$pagesObj = new pages(false,NULL);
					$primaryModPage = $pagesObj->getRecordByID($_GET["pageID"]);
					$pmp = mysqli_fetch_assoc($primaryModPage);
					
					$microDataLink = "";					
					$_GET["recordUrl"] = $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME'] . '/' . $_SESSION["seoFolderName"] .  '/' . rawurlencode ($pmp["pageName"]);				
				}
				
				#social media and twitter links to this page
				if(array_key_exists("socialMediaActive",$priModObj[0]->domFields)){
					
					ob_start();
					include($_SERVER['DOCUMENT_ROOT']."/public/socialMedia/socialMediaInclude.php");
					$tmpSocialCode = ob_get_contents();
					ob_end_clean();
					
					$priModObj[0]->domFields["socialMediaActive"] = $tmpSocialCode;		
				}
		
				#DOM elements for this module
				include($_SERVER['DOCUMENT_ROOT'].$priModObj[0]->templateDOMFile);
								
				#Display the number of records returned in the query, and what
				#record we're at in the slider
				if(
					array_key_exists("modRecNum",$priModObj[0]->domFields)
				){ 
					if(!isset($priModObj[0]->modRecNum)) {
						$priModObj[0]->modRecNum = 1;
					}
					else{
						$priModObj[0]->modRecNum++;
					}
					
					
					$priModObj[0]->domFields["modRecNum"] = '
						<div
							class="modRecNum modRecNum_' . $priModObj[0]->className .'" 
							id="modRecNum' . $priModObj[0]->queryResults["priKeyID"] . '"
						>
							' . $priModObj[0]->modRecNum . ' <div class="modRecNumSep"></div> ' . $priModObj[0]->recordCount . '
						</div>
					';
				}

				#GALLERY
				if(
					array_key_exists("modGal",$priModObj[0]->domFields) &&
					isset($priModObj[0]->queryResults["imageGalleryID"]) &&
					is_numeric($priModObj[0]->queryResults["imageGalleryID"])
				){ 
					#put child module into output buffer
					ob_start();
					$recursivePmpmID = $priModObj[0]->galleryPmpmID;
					include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");		$tmpGalCode = ob_get_contents();			
					ob_end_clean();
					
					$priModObj[0]->domFields["modGal"] = $tmpGalCode;
				}
				elseif(array_key_exists("modGal",$priModObj[0]->domFields)){
					$priModObj[0]->domFields["modGal"] = '<div class="mfmc"></div>';
				}
				
				#ONE GALLERY IMAGE
				if(isset($priModObj[0]->queryResults["galleryImageID"])){
					
					include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/gallery/galleryImages.php');
					$galleryImageObj = new galleryImage(false);
					$galleryImages = $galleryImageObj->getRecordByID(
						$priModObj[0]->queryResults["galleryImageID"]
					);
					$tmpGalImg = mysqli_fetch_assoc($galleryImages);
					
					#get alt attribute text
					if(strlen($tmpGalImg["imgCaption"]) > 0){
						$tmpAlt = htmlspecialchars($tmpGalImg["imgCaption"]);
					}
					else{
						$tmpAlt = $_SESSION["seoFolderName"];
					}
						
					#the module has an image, and it's visible in the mi				
					if(
						array_key_exists("Image",$priModObj[0]->domFields) &&
						strlen($tmpGalImg["fileName"]) > 0
					){	
					
						#get info of the image so we can create meta data
						$imgInfo  = getimagesize($_SERVER['DOCUMENT_ROOT'] . '/images/galleryImages/' . $priModObj[0]->queryResults["imageGalleryID"] . '/'.$priModObj[0]->imgPath. '/'. $tmpGalImg["fileName"]);				
						
						$priModObj[0]->domFields["Image"] = '
						<div 
							class="galImg galImg-' . $priModObj[0]->className . '"
							itemscope="itemscope"
							itemprop="image"  
							itemtype="https://schema.org/ImageObject"
						>
							<img
								alt="' . $tmpAlt . '"
								itemprop="url"
								src="/images/galleryImages/' . $priModObj[0]->queryResults["imageGalleryID"] . '/'.$priModObj[0]->imgPath. '/'. rawurlencode($tmpGalImg["fileName"]) .'"
							/>
							
							<meta 
								itemprop="height" content="' . $imgInfo[1] . '" 
							/>
							<meta 
								itemprop="width" content="' . $imgInfo[0] . '" 
							/>
						</div>';
					}
					#module has an image, but its no in the mi. put into microdata
					elseif(
						!array_key_exists("Image",$priModObj[0]->domFields) &&
						strlen($tmpGalImg["fileName"]) > 0
					){
						
						$imgInfo  = getimagesize($_SERVER['DOCUMENT_ROOT'] . '/images/galleryImages/' . $priModObj[0]->queryResults["imageGalleryID"] . '/'.$priModObj[0]->imgPath. '/'. $tmpGalImg["fileName"]);				

						$priModObj[0]->domFields["modImgMeta"] = '
						<div 
							class="microDataDiv"
							itemprop="image" 
							itemscope="itemscope" 
							itemtype="https://schema.org/ImageObject"
						>
							<meta 
								itemprop="url" 
								content="' . $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME'] . '/images/galleryImages/' . $priModObj[0]->queryResults["imageGalleryID"] . '/'.$priModObj[0]->imgPath. '/'. rawurlencode($tmpGalImg["fileName"]) .'"
							>
							<meta 
								itemprop="height" content="' . $imgInfo[1] . '" 
							/>
							<meta 
								itemprop="width" content="' . $imgInfo[0] . '" 
							/>
						</div>';
					}
					#get default image for microdata
					elseif($priModObj[0]->itemscope == 1){
						ob_start();
						include($_SERVER['DOCUMENT_ROOT'] . "/public/moduleFrame/defaultMicroDataImage.php");
						$tmpImgCode = ob_get_contents();
						ob_end_clean();
											
						$priModObj[0]->domFields["Image"] = $tmpImgCode;
					}

					#if primage module get the image for open graph (social media sharing)
					if(
						$priModObj[0]->isPrimaryPageModule == 1 && 
						strlen($tmpGalImg["fileName"]) > 0 && 
						(
							isset($_GET["openGraph"]["image"]) &&
							strlen($_GET["openGraph"]["image"]) == 0
						)
					) {
						$_GET["openGraph"]["image"] = '/images/galleryImages/' . $priModObj[0]->queryResults["imageGalleryID"] . '/'.$priModObj[0]->imgPath. '/'. rawurlencode($tmpGalImg["fileName"]);
					}
				}
				#get default image for microdata
				elseif($priModObj[0]->itemscope == 1){
					ob_start();
					include($_SERVER['DOCUMENT_ROOT'] . "/public/moduleFrame/defaultMicroDataImage.php");
					$tmpImgCode = ob_get_contents();
					ob_end_clean();
										
					$priModObj[0]->domFields["Image"] = $tmpImgCode;
				}
				
				#if we have rich snippet info
				if($priModObj[0]->itemscope == 1){
					$_SESSION["protocol"] = isset($_SERVER["https"]) ? 'https' : 'http';
					$logoInfo = getimagesize($_SERVER['DOCUMENT_ROOT'] . '/images/admin/logo-project.png');
					
					#if it's the blog module
					if($priModObj[0]->moduleID == 56){
						$priModObj[0]->domFields["publisher"] = '
						<div 
							itemprop="publisher" 
							itemscope="itemscope" 
							itemtype="https://schema.org/Organization"
							class="microDataDiv"
						>
							<div 
								itemprop="logo" 
								itemscope="itemscope" 
								itemtype="https://schema.org/ImageObject"
							>
								<meta 
									itemprop="url" 
									content="' . $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME'] . '/images/admin/logo-project.png"
								>
								<meta 
									itemprop="height" content="' . $logoInfo[1] . '" 
								/>
								<meta 
									itemprop="width" content="' . $logoInfo[0] . '" 
								/>
							</div>
							<meta itemprop="name" content="' . $_SESSION["siteName"] . '" />
						</div>
						';
					}
					
					if(!isset($_GET["recordUrl"])){
						$_GET["recordUrl"] = $_SESSION["protocol"] . "://" . $_SERVER["HTTP_HOST"] . "/" . $_SERVER["REQUEST_URI"];
					}
					
					$priModObj[0]->domFields["mainEntityOfPage"] = '
						<link
							itemprop="mainEntityOfPage"
							href="' . $_GET["recordUrl"]  .'"
						/>
					';
				}
				
				#rating system, ex 4/5 stars - using http://www.fyneworks.com/jquery/star-rating/
				#needs to be included in the displayElements in the public_module_page_map
				if($priModObj[0]->hasRating == 1 ) {
					ob_start();
					include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/ratingBox.php");
					$priModObj[0]->domFields["rate"] = ob_get_contents();
					ob_end_clean();
				}
				
				#output our selected DOM elements
				include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleDOMElements.php");
				
				#edit, delete buttons for admins on lists or pagnation pages
				if(
					(
						$priModObj[0]->instanceDisplayType==1 || 
						$priModObj[0]->instanceDisplayType==2
					) &&
					$_SESSION["domainID"] < 0 &&
					#isn't a child module
					count($priModObj) == 1
				){
					include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/adminButtons.php");
				}
				
				#quick edit for module list items, only when logged in as admin
				if(
					#logged in as an admin
					isset($_SESSION['sessionSecurityLevel']) && 
					$_SESSION['sessionSecurityLevel'] ==3 &&
					#is a module list item
					$priModObj[0]->isTemplate == 1 &&
					#has a mapped add/edit module
					is_numeric($priModObj[0]->primaryPmpmAddEditID) &&
					#isn't a child module
					count($priModObj) == 1
				) {
					echo '
					<div
						class="moduleQuickEdit"
						title="Quick Edit"
					>
						<img
							alt="Quick Edit"
							height="16px" 
							src="/images/admin/button-edit.jpg" 
							width="16px"
						/>
					</div>
					';
				}
			} 
			
			#button to expand/hide divs. just adds and removes css class to mi
			if($priModObj[0]->expandContractMIs == 1){
		?>	
			<div
				class="expandBtn"
				id="expd_<?php echo $priModObj[0]->className; ?>_<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>" 
			>
			</div>
            
            
            <div
                class="closeBtn"
                id="cls_<?php echo $priModObj[0]->className; ?>_<?php echo $priModObj[0]->queryResults["priKeyID"]; ?>" 
            ></div>
						
			<?php
				}
			?>
			
		</div>

		<?php			
		$priModObj[0]->qryLoopCnt++;

		#only loop through once if there aren't any records or we're adding an new record
		$loopOnce = true;
	}#module item query loop
			
	#add individual and bulk edit buttons on lists or pagnation pages
	if(
		(
			$priModObj[0]->instanceDisplayType==1 || 
			$priModObj[0]->instanceDisplayType==2
	) &&
		$_SESSION["domainID"] < 0 &&
		$priModObj[0]->isTemplate==1 &&
		#isn't a child module
		count($priModObj) == 1 &&
		#standard Content module doesn't need these buttons - Fateme
		$priModObj[0]->priKeyID != -1117
	){
		include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/adminAddBulkButtons.php");
	}
		
	#no record returned on
	if(
		$priModObj[0]->isTemplate != 0 && 
		mysqli_num_rows($priModObj[0]->primaryModuleQuery) == 0
	){
?>
	<div class="mem mem-<?php echo $priModObj[0]->className;?>">
		No results found.
	</div>
<?php
	}

	#clickslide arrows - only show if there is more than 1 item
	if(
		($priModObj[0]->instanceDisplayType == 0 ||
		$priModObj[0]->instanceDisplayType == 3 ||
		$priModObj[0]->instanceDisplayType == 4) && 
		#more than one record
		mysqli_num_rows($priModObj[0]->primaryModuleQuery) > $priModObj[0]->displayQty && 
		#not in the clss container
		(
			!isset($priModObj[0]->clickStorage) ||
			(isset($priModObj[0]->clickStorage) && $priModObj[0]->clickStorage == 0)
		) &&
		/*not the login module. login module must be isTemplate 1, because
		we update the innerHTML of it using the paginate function*/
		$priModObj[0]->moduleID != 37
	){
		
		if(
			$priModObj[0]->instanceDisplayType == 0 ||
			$priModObj[0]->instanceDisplayType == 4
		) $moveFunction = "fadeRotate";
		else if($priModObj[0]->instanceDisplayType == 3) {
			$moveFunction = "clickSlide";
		}
?>
		<div 
			class="mcl mcll mcll-<?php echo $priModObj[0]->className;?> sb" 
			id="mcll-<?php echo $priModObj[0]->className;?>"
			onclick="<?php echo $priModObj[0]->className;?>.<?php echo $moveFunction; ?>(0)"
		>
		</div>
		
		<div 
			class="mcl mclr mclr-<?php echo $priModObj[0]->className;?> sb" 
			id="mclr-<?php echo $priModObj[0]->className;?>"
			onclick="<?php echo $priModObj[0]->className;?>.<?php echo $moveFunction; ?>(1)"
		>
		</div>
<?php
	}
?>