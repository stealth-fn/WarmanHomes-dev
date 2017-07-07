<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");
	$pagesObj = new pages(false, NULL);
?>

<div class="navOuter" id="navOuter-<?php echo $priModObj[0]->className; ?>">
	<button class="hamburger--<?php echo $priModObj[0]->hamburgerAnimation; ?> responsiveBtn"  id="responsiveBtn-<?php echo $priModObj[0]->className; ?>" type="button">
		<span class="hamburger-box">
			<span class="hamburger-inner"></span>
		</span>
	</button>
	<nav class="navInner" id="navInner-<?php echo $priModObj[0]->className; ?>">
		<?php
			#setup javscript object for nav header
			if($priModObj[0]->navType == 0){
				$jsTreeObj = $priModObj[0]->isSubNav ? "satpto" : "atpto";
				$pageDivID = $priModObj[0]->isSubNav ? "sntid" : "ntid";
			}
			else if($priModObj[0]->navType == 1){
				$jsTreeObj = $priModObj[0]->isSubNav ? "satpo" : "atpo";
				$pageDivID = $priModObj[0]->isSubNav ? "snid" : "nid";
			}
			else if($priModObj[0]->navType == 2){
				$jsTreeObj = $priModObj[0]->isSubNav ? "satpbo" : "atpbo";
				$pageDivID = $priModObj[0]->isSubNav ? "snbid" : "nbid";
			}
			
			$jsTreeObj .= "_" . $priModObj[0]->className;
			
			#the pageID of what info we want for the header
			$priModObj[0]->headerPageID = "";
			
			#for our default top nav the header links back to the home page
			if($priModObj[0]->priKeyID == -200){
				$priModObj[0]->headerPageID = 1;
			}
			#there is no root page on level 0 pages...
			elseif(is_numeric($_GET["rootPageID"]))	{
				$priModObj[0]->headerPageID = $_GET["rootPageID"];
			}
		?>
		
		<a 
			class="fa navHeader" 
			id="navHeader-<?php echo $priModObj[0]->className; ?>"
			href="/<?php echo urlencode($pagesObj->getPageRootName($priModObj[0]->headerPageID)); ?>"
			onclick='<?php echo $jsTreeObj . ".toggleBlind(\"". $priModObj[0]->headerPageID ."\",\"" . $priModObj[0]->headerPageID . "\",\"upc(". $priModObj[0]->headerPageID .")\",\"" . $pageDivID . "". $priModObj[0]->headerPageID ."\",event);return false" ?>'
		>
			<?php
				#for our default top nav the header links back to the home page
				if($priModObj[0]->priKeyID == -200){
					echo $pagesObj->getPageRootName($priModObj[0]->headerPageID);
				}
				#there is no root page on level 0 pages...
				elseif(is_numeric($_GET["rootPageID"]))	{
					echo $pagesObj->getPageRootName($priModObj[0]->headerPageID);
				}
				#...so just show its name instead
				else{
					echo $_GET['pageName'];
				}
			?>
		</a>
		<ul>
		<?php			
			#show child pages
			if(
				$priModObj[0]->isSubNav == 1 && /*&& $priModObj[0]->subNavParentPageID == 0*/
				$pageInfo["subNavCurrentLevel"] == 1
			){			
				$priModObj[0]->subNavParentPageID = $_GET["pageID"];
			}
			#show sibblingspages
			else if(
				$priModObj[0]->isSubNav == 1 &&
				$pageInfo["subNavCurrentLevel"] == 0
			){			
				$priModObj[0]->subNavParentPageID = $pageInfo["parentPageID"];
			}
			#show sibblings and children pages
			else if(
				$priModObj[0]->isSubNav == 1 &&
				$pageInfo["subNavCurrentLevel"] == 2
			){			
				$priModObj[0]->subNavParentPageID = $_GET["rootPageID"];
			}
	
			#sub nav, root pages are the first siblings of the page specified
			if($priModObj[0]->subNavParentPageID != 0){
				$navPages = $pagesObj->getConditionalRecord(
					array(
						"parentPageID",$priModObj[0]->subNavParentPageID,true,
						"domainID",$_SESSION["domainID"],true,
						"ORDINAL","ASC"
					)
				);
				
				while($x = mysqli_fetch_assoc($navPages)){
					echo $pagesObj->getPageTree(
						$x["priKeyID"],
						$priModObj[0]->navType,
						$priModObj[0]->className,
						$priModObj[0]->isSubNav
					);
				}
			}
			#standard nav/root pages
			else{
				echo $pagesObj->getPageTree(
					0,
					$priModObj[0]->navType,
					$priModObj[0]->className,
					$priModObj[0]->isSubNav
				);
			}
		?>
		</ul>
	</nav>
</div>