<?php
// Sent the correct header so browsers display properly, with or without XSL.
header( 'Content-Type: application/xml' );

include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");

echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
echo '<?xml-stylesheet type="text/xsl" href="/css/sitemap.xsl"?>' . "\n";

include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pages.php");

function getPageArray($pagesObj,$currentPage,&$order){
	
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$site = $protocol . $_SERVER['HTTP_HOST'];

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
	}
	$pnArray = array();
	#loop through the current level, starting with the root
	while($x = mysqli_fetch_assoc($currentLevel)){
		if($x["priKeyID"] > 0){
			$tempName = htmlspecialchars($x["pageName"],ENT_NOQUOTES);
			
			$pnArray[$x["priKeyID"]] = array(
				"loc"=>$site."/".$_SESSION["seoFolderName"]."/".$tempName,
				"lastModified"=>$x["lastUpdate"],
			);
			$children = getPageArray($pagesObj,$x,$order);
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
		if($x["priKeyID"] > 0){
			$pnArray[$x["priKeyID"]] = array(
				"loc"=>$site."/".$_SESSION["seoFolderName"]."/".$tempName,
				"lastModified"=>$x["lastUpdate"],
			);
		}
	}
	
	return $pnArray;
}


function buildXMLMap($pageArray){
	foreach($pageArray as $page){
?>
	<url>
        <loc><?php echo $page["loc"]; ?></loc>
    <?php if($page["lastUpdate"]){ ?>
        <lastmod><?php echo $page["lastModified"]; ?></lastmod>
    <?php } ?>
    </url>
<?php
	}
}

?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
	$pagesObj = new pages(false);
	$order = 1;
	buildXMLMap(getPageArray($pagesObj,null,$order));
?>
</urlset>