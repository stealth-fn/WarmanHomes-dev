<?php	
	#DESCRIPTION
	if(array_key_exists("Description",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Description"] =
		'<div 
			itemprop="description"
			id="bd-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="bd bd-' . $priModObj[0]->className . '"
		>' . 
			 $priModObj[0]->queryResults["blogDescription"] .
		'</div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Description"] = "";
	}
		
	#NAME
	if(array_key_exists("Title",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Title"] =
		'<div 
			itemprop="headline"
			id="bn-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="bn bn-' . $priModObj[0]->className . '"
		>' . 
			(($priModObj[0]->titleTrim > 0) 
			? substr($priModObj[0]->queryResults["blogName"],0,$priModObj[0]->titleTrim) 
			: $priModObj[0]->queryResults["blogName"]) .
		'</div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Title"] = "";
	}
	else{
		$priModObj[0]->domFields["bnameMeta"] ='
		<meta 
			itemprop="headline" 
			content="' . htmlspecialchars($priModObj[0]->queryResults["blogName"]) . '"
		/>
		';
	}
	
	#DATE
	if(array_key_exists("Date",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Date"] =
		'<div 
			class="bdate bdate-' . $priModObj[0]->className . 
		'">' .
			(($priModObj[0]->blogDateFormatType == 1)
			? 
			'<div 
				id="bmonth-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '" 
				class="bmonth bmonth-' . $priModObj[0]->className . '"
			>' .
				date($priModObj[0]->blogMonthFormat,strtotime($priModObj[0]->queryResults["postDate"])) .
			'</div>
			<div 
				id="bday-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '" 
				class="bday bday-' . $priModObj[0]->className . '"
			>' .
				date($priModObj[0]->blogDayFormat,strtotime($priModObj[0]->queryResults["postDate"])) .
			'</div>
			<div 
				id="byear-' . $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] . '" 
				class="byear byear' . $priModObj[0]->className . '"
			>' .
				date($priModObj[0]->blogYearFormat,strtotime($priModObj[0]->queryResults["postDate"])) .
			'</div>'
			:
			date($priModObj[0]->blogDateFormat,strtotime($priModObj[0]->queryResults["postDate"]))) .
		'</div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Date"] = "";
	}
	
	#Rich Snippets datePublished metaData - ISO 8601 format
	if(!isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["richPubDate"] = '
			<meta 
				itemprop="datePublished" 
				content="' . date("c", strtotime($priModObj[0]->queryResults["postDate"])) . '"
			/>
			
			<meta 
				itemprop="dateModified" 
				content="' . date("c", strtotime($priModObj[0]->queryResults["postDate"])) . '"
			/>
		';
	}
	
	#TIME
	if(array_key_exists("Time",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Time"] =
		'<div 
			id="btime-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
			class="btime btime-' . $priModObj[0]->className . '"
		>' .
			date($priModObj[0]->blogTimeFormat,strtotime(htmlspecialchars($priModObj[0]->queryResults["postDate"]))) .
		'</div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Time"] = "";
	}
	
	#AUTHOR
	if(is_numeric($priModObj[0]->queryResults["blogAuthorID"])){
		
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/publicUsers/publicUsers.php");
		$publicUsersObj = new publicUsers(false,NULL);
	
		$getAuthorName = $publicUsersObj->getRecordByID(
			$priModObj[0]->queryResults["blogAuthorID"]
		);
		$authorNameResults = mysqli_fetch_assoc($getAuthorName);
		$authorName = $authorNameResults['firstName'] . ' ' . $authorNameResults['lastName'];
	
		if(strlen(trim($authorName)) == 0){
			$authorName = $_SESSION["siteName"];
		}
	}
	else{
		$authorName = $_SESSION["siteName"];
	}
		
	if(array_key_exists("Author",$priModObj[0]->domFields)){
		
		if(is_numeric($priModObj[0]->queryResults["blogAuthorID"])) {
			include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/gallery/galleryImages.php');
			$galleryImageObj = new galleryImage(false);
			$galleryImages = $galleryImageObj->getRecordByID(
				$authorNameResults["galleryImageID"]
			);
			$tmpGalImg = mysqli_fetch_assoc($galleryImages);
			
			if(is_numeric($authorNameResults["galleryImageID"])){	
				$priModObj[0]->domFields["Author"] =
				'<div
					id="bauthor-' . $priModObj[0]->className . $priModObj[0]->queryResults["priKeyID"] . '"
					class="bauthor bauthor-' . $priModObj[0]->className . '"
				>
					<img 
						alt="'. $authorName . '"
						class="bAuthImg"
						src="/images/galleryImages/'. $authorNameResults['imageGalleryID'] . '/thumb/'. $tmpGalImg["fileName"] .'"
					/>
					<span itemprop="author" class="bAuthorName">'. $authorName . '</span>
					<span class="bAuthorDesc">'. $authorNameResults['notes'] . '</span>
				</div>';
			}
			else{
				$priModObj[0]->domFields["Author"] = '
					<meta 
						itemprop="author" 
						content="' . $authorName . '"
					/>
				';
			}
		}
		else{
			$priModObj[0]->domFields["AuthorMeta"] = '
				<meta 
					itemprop="author" 
					content="' . $authorName . '"
				/>
			';
		}
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Author"] = "";
	}
	else{
		$priModObj[0]->domFields["Author"] = '
		<meta 
			itemprop="author" 
			content="' . $authorName . '"
		/>
	';
	}
		
	#BODY
	if(array_key_exists("Content",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Content"] = 
		'<div 
			itemprop="articleBody"
			class="blogBody blogBody-'.$priModObj[0]->className.'"
			id="blogBody'.$priModObj[0]->className.'-'.$priModObj[0]->queryResults["priKeyID"].'"
		>';
		
		#preview text
		if($priModObj[0]->blogTrim > 0){
			
			#strip tags except links from preview text
			$blogBodyText = strip_tags(
				html_entity_decode($priModObj[0]->queryResults["blogCopy"]),
				"<a>"
			);
			
			#trim text while maintaining HTML
			$priModObj[0]->domFields["Content"] .= $priModObj[0]->truncate_html(
				$blogBodyText, $priModObj[0]->blogTrim
			);	
		} 
		else {
			$blogBodyText = $priModObj[0]->queryResults["blogCopy"];
			$priModObj[0]->domFields["Content"] .= $priModObj[0]->queryResults["blogCopy"];
		}

		$priModObj[0]->domFields["Content"] .= '</div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Content"] = "";
	}
	
	#Link to full blog article	
	if(array_key_exists("Article Link",$priModObj[0]->domFields)){
		$showViewMore = true;
		if(isset($priModObj[0]->blogKeyID)){
			if($priModObj[0]->blogKeyID == $priModObj[0]->queryResults["priKeyID"]){
				$showViewMore = false;
			}
		}

		if($showViewMore){
			
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php"); 
			$pagesObj = new pages(false,NULL);
			$blogPage = $pagesObj->getRecordByID($priModObj[0]->specificBlogPageID);
			$bp = mysqli_fetch_assoc($blogPage);
			
			$priModObj[0]->domFields["Article Link"] =
			'<a 
				class="sb blogMoreLink blogMoreLink-' . $priModObj[0]->className . '"
				href="/' . $_SESSION["seoFolderName"] . '/' . str_replace(' ', '%20', $bp["pageName"]) . '/' . rawurlencode($priModObj[0]->getCleanURLStr($priModObj[0]->queryResults["blogName"])) .'"
				onclick="upc(' . $priModObj[0]->specificBlogPageID . ',&quot;pmpm=%28%22'.$priModObj[0]->blogToQueryPmpmID.'%22%3A%28%22blogKeyID%22%3A%22'.$priModObj[0]->queryResults["priKeyID"].'%22%29%29&quot;); return false"
			>' . $priModObj[0]->blogButtonText . '</a>';
		}
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Article Link"] = "";
	}
	
	#Blog Tags
	if(array_key_exists("Tags",$priModObj[0]->domFields)){
		$blogTags = $blogTagMapObj->getConditionalRecord(array('blogID',$priModObj[0]->queryResults["priKeyID"],true));
		$blogTagIDList = $blogTagMapObj->getQueryValueString($blogTags,'blogTagID',',');
		$bTags = $blogTagObj->getConditionalRecordFromList(array('priKeyID',$blogTagIDList,true));
		if(mysqli_num_rows($bTags) > 0){
			$allTags = "";
			while($bt = mysqli_fetch_assoc($bTags)){
				$allTags .=
				'<a
					class="sb blogTagLink blogTagLink-' . $priModObj[0]->className . '"
					href="/index.php?pageID=' . $priModObj[0]->sortByTagPageID . '&amp;viewBlogTagID=' . $bt['priKeyID'] . '"
					onclick="upc(' . $priModObj[0]->sortByTagPageID . ',"viewBlogTagID=' . $bt['priKeyID'] .'");return false"
				>
					<span>' . $bt['tagText'] . '</span>
				</a>';
			}
		}
		$priModObj[0]->domFields["Tags"] =
		'<div class="blogTags blogTags-' . $priModObj[0]->className . '">' .
			$allTags .
		'</div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Tags"] = "";
	}
	
	#RECOMMENDED BLOGS
	if(
		array_key_exists("Recommended Articles",$priModObj[0]->domFields) &&
		isset($priModObj[0]->recommendedBlogInstanceID) &&
		is_numeric($priModObj[0]->recommendedBlogInstanceID)
	){
		#put child module into output buffer
		ob_start();
		$recursivePmpmID = $priModObj[0]->recommendedBlogInstanceID;
		include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");
		$tmpBlogCode = ob_get_contents();
		ob_end_clean();
		
		$priModObj[0]->domFields["Recommended Articles"] = $tmpBlogCode;
	}
	elseif(array_key_exists("Recommended Articles",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Recommended Articles"] = '<div class="mfmc"></div>';
	}
	elseif(isset($priModObj[0]->ispmpmBuild)){
		$priModObj[0]->domFields["Recommended Articles"] = "";
	}
?>
