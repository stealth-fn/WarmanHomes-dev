<?php
	#display all errors and notifications. MSIE times out if too many PHP notification errors 
	error_reporting(E_ALL);
	
	#session initialization
	if(!isset($_SESSION)) session_start();

	#set the charset and content type!
	if (PHP_VERSION_ID < 50600) {
		iconv_set_encoding('input_encoding', 'UTF-8');
		iconv_set_encoding('output_encoding', 'UTF-8');
		iconv_set_encoding('internal_encoding', 'UTF-8');
	} 
	else {
		ini_set('default_charset', 'UTF-8');
	}
	
	#initial browser http request
	$_GET["initPage"] = true;
	
	#Internet Explorer detection
	if(
		strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') !== false ||
		strpos($_SERVER["HTTP_USER_AGENT"], 'Trident') !== false ||
		strpos($_SERVER["HTTP_USER_AGENT"], 'Edge') !== false
	){
		$_GET["msie"] = true;
	}
	else{
		$_GET["msie"] = false;
	}
	
	#get/set CMS settings and session variables
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php"); 

	#get our page, or 404
	$pQuery = $pagesObj->getPage($_GET["pageMarker"]);

	#get modules that are displayed on every page
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
	$moduleObj = new module(false,NULL);
	$stanPubMods = $moduleObj->getModuleInfoQuery();

	$beforeModuleCode = "";
	$afterModuleCode = "";
?><!doctype html>
<html lang="<?php echo $_SESSION["lng"]; ?>" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $pQuery["pageTitle"]; #title must be first tag in head ?></title> 
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<!--removes skype highlighting on phone numbers-->
		<meta content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" name="SKYPE_TOOLBAR" />
		<!--makes sure search engines use the meta information we provide, and not their own-->
		<meta name="robots" content="noodp, noydir" /> 	
		
        <!-- Firefox for Android doesn't report its viewport properly -->
		<?php $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
			  if(stripos($ua,'android') !== false && stripos($ua,'firefox') !== false) { ?>
			  	<meta name="viewport" content="width=720">
		<?php } else { ?>
			  	<?php if ($_SESSION["iPhone"]) { ?>
                <meta name='viewport' content='width=device-width, initial-scale=0.6, user-scalable=no' />
                <?php } else if ($_SESSION["iPad"]){ ?>
                <meta name='viewport' content='width=device-width, initial-scale=0.75, user-scalable=no' />	
                <?php } else { ?>
                <meta name='viewport' content='width=device-width, initial-scale=0.6, user-scalable=no' />
                <?php } ?>	
		<?php } ?>
        
		<?php
			$googleVer = explode(",",$_SESSION["googleSiteVerification"]);
			
			foreach($googleVer as $verKey){
				echo '<meta content="' , $verKey , '" name="google-site-verification"/>' , PHP_EOL;
			}
			
			if(strlen($_SESSION["metaWords"]) > 0){
				$_SESSION["metaWords"] .= "," . htmlentities($pQuery["metaWords"]);
			}
			else{
				$_SESSION["metaWords"] = htmlentities($pQuery["metaWords"]);
			}
			
			if(strlen($_SESSION["metaDesc"]) > 0){
				$_SESSION["metaDesc"] .= "," . htmlentities($pQuery["metaDesc"]);
			}
			else{
				$_SESSION["metaDesc"] = htmlentities($pQuery["metaDesc"]);
			}
		?>
		<meta 
			content="<?php echo $_SESSION["metaWords"]; ?>"
			id="pageMetaKeywords" 
			name="keywords" 
		/>
		<meta 
			content="<?php echo $_SESSION["metaDesc"]; ?>"
			id="pageMetaDesc"
			name="description" 	 	
		/>
		
		
		<meta property="og:site_name" content="<?php echo $_GET["openGraph"]["site_name"]?>"/>
		
		<?php
			if(!isset($_GET["recordUrl"])){
				$_GET["recordUrl"] = $_SESSION["protocol"] . "://" . $_SERVER["HTTP_HOST"] . "/" . $_SERVER["REQUEST_URI"];
			}
		?>
		<meta property="og:url" content="<?php echo $_GET["recordUrl"]?>"/>
		<meta property="fb:app_id" content="1089879104416281"/>
		
		<?php
			#if this page has a primary module set it up for open graph
			if(strlen($_GET["openGraph"]["title"]) === 0){
				
			$imgInfo  = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/images/admin/logo-project.png");				
		?>
		<meta property="og:image" content="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/admin/logo-project.png"/>
		<meta property="og:image:width" content="<?php echo $imgInfo[0]?>"/>
		<meta property="og:image:height" content="<?php echo $imgInfo[1]?>"/>
		<meta property="og:title" content="<?php echo $_SESSION["siteName"]?>"/>
		<meta property="og:description" content="<?php echo $pQuery["metaDesc"]?>"/>
		<?php
			}
			else{
				
			$imgInfo  = getimagesize($_SERVER['DOCUMENT_ROOT'] . rawurldecode($_GET["openGraph"]["image"]));				

		?>
		<meta property="og:title" content="<?php echo $_GET["openGraph"]["title"]?>"/>
		<meta property="og:image" content="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME'] . $_GET["openGraph"]["image"]; ?>"/>
		<meta property="og:image:width" content="<?php echo $imgInfo[0]?>"/>
		<meta property="og:image:height" content="<?php echo $imgInfo[1]?>"/>
		<meta property="og:description" content="<?php echo $_GET["openGraph"]["description"]?>"/>
		<?php
			}
		?>
		
		<!--must be first style tag in doc-->
		<style title="moduleStyles" type="text/css"><?php echo $pQuery["moduleStyles"];?>
		</style>
		<style type="text/css"><?php include($_SERVER['DOCUMENT_ROOT']."/css/standardStyles.php");?>
		</style>                		 
        <link rel="icon" sizes="57x57" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/apple-touch-icon-57x57.png" />
		<link rel="icon" sizes="114x114" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/apple-touch-icon-114x114.png" />
		<link rel="icon" sizes="72x72" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/apple-touch-icon-72x72.png" />
		<link rel="icon" sizes="144x144" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/apple-touch-icon-144x144.png" />
		<link rel="icon" sizes="60x60" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/apple-touch-icon-60x60.png" />
		<link rel="icon" sizes="120x120" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/apple-touch-icon-120x120.png" />
		<link rel="icon" sizes="76x76" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/apple-touch-icon-76x76.png" />
		<link rel="icon" sizes="152x152" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/apple-touch-icon-152x152.png" />
		<link rel="icon" type="image/png" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/favicon-196x196.png" sizes="196x196" />
		<link rel="icon" type="image/png" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/favicon-96x96.png" sizes="96x96" />
		<link rel="icon" type="image/png" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/favicon-32x32.png" sizes="32x32" />
		<link rel="icon" type="image/png" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/favicon-16x16.png" sizes="16x16" />
		<link rel="icon" type="image/png" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/favicon-128.png" sizes="128x128" />
		<link rel="icon" type="image/png" href="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/favicon.ico" sizes="48x48" />
		<meta name="application-name" content="<?php echo $_SESSION["protocol"] . "://" . $_SESSION["siteName"];  ?>"/>
		<meta name="msapplication-TileColor" content="#FFFFFF" />
		<meta name="msapplication-TileImage" content="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/mstile-144x144.png" />
		<meta name="msapplication-square70x70logo" content="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/mstile-70x70.png" />
		<meta name="msapplication-square150x150logo" content="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/mstile-150x150.png" />
		<meta name="msapplication-wide310x150logo" content="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/mstile-310x150.png" />
		<meta name="msapplication-square310x310logo" content="<?php echo $_SESSION["protocol"] . "://" . $_SERVER['SERVER_NAME']?>/images/favicons/mstile-310x310.png" />
		
		<?php
			if(strlen($_SESSION["googlePublisherLink"]) > 0){
		?>
		<link rel="Publisher" href="<?php echo $_SESSION["googlePublisherLink"]; ?>" />
		<?php
			}
		?>
		<script src="/js/headScripts.php" type="text/javascript"></script>
		
	</head>
	<body>
		<div class="pc" id="pc<?php echo $pQuery["priKeyID"];?>">
        
			<?php
				if(mysqli_num_rows($stanPubMods) > 0){
					$standardRunScripts = "";
					$_GET["moduleScripts"] = "";
					while($x = mysqli_fetch_assoc($stanPubMods)){	
						#show standard modules after the pcpy div
						if($x["beforeAfter"]!=1){				
							$pMod = $x;
	
							#stealth framework
							if(
								$x["isTemplate"]==0 || $x["isTemplate"]==1 || $x["isTemplate"]==3
							){
								include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pageModuleBuild.php");
							}
							#regular DOM insert 
							elseif(strlen($x["includeFile"]) > 0){
								$_GET["instanceID"] = $x["instanceID"];
								ob_start();
								include($_SERVER['DOCUMENT_ROOT'] . $x["includeFile"]);
								$beforeModuleCode .= ob_get_contents();
								ob_end_clean();	
																				
								ob_start();
								if(strlen($x["jScript"]) > 0){
									include($_SERVER['DOCUMENT_ROOT'] . $x["jScript"]);
								}
								$_GET["moduleScripts"] .= ob_get_contents();
								ob_end_clean();
							}
							
							$standardRunScripts .= $x["runFunction"];
						}
					}
					#output the module DOM
					if(isset($beforeModuleCode)) {
						echo $beforeModuleCode;
					}
						
					mysqli_data_seek($stanPubMods,0);
					$moduleCode = "";
				}
			?>
			<main class="pcpy" id="pcpy<?php echo $pQuery["priKeyID"];?>">
			<?php
				echo $pQuery["beforeModuleCode"];
				echo $pQuery["pageCode"];
				echo $pQuery["afterModuleCode"];
			?>
			</main> 
			<?php
				if(mysqli_num_rows($stanPubMods) > 0){
					while($x = mysqli_fetch_assoc($stanPubMods)){
						#show standard modules after the pcpy div
						if($x["beforeAfter"]==1){
							$pMod = $x;
	
							#stealth framework
							if($x["isTemplate"]==0 || $x["isTemplate"]==1 || $x["isTemplate"]==3){
								include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pageModuleBuild.php");
							}
							#regular DOM insert 
							elseif(strlen($x["includeFile"]) > 0){
								$_GET["instanceID"] = $x["instanceID"];
								ob_start();
								include($_SERVER['DOCUMENT_ROOT'] . $x["includeFile"]);
								$afterModuleCode .= ob_get_contents();
								ob_end_clean();
													
								ob_start();
								if(strlen($x["jScript"]) > 0){
									include($_SERVER['DOCUMENT_ROOT'] . $x["jScript"]);
								}
								$_GET["moduleScripts"] .= ob_get_contents();
								ob_end_clean();
							}
							
							$standardRunScripts .= $x["runFunction"];
						}
					}
					#output the module DOM
					if(isset($afterModuleCode)) {
						echo $afterModuleCode;
					}
						
					mysqli_data_seek($stanPubMods,0);
				} 
			?>
		</div>
		<script id="moduleScript" type="text/javascript">
		<!--
		<?php 
			echo $pQuery["moduleScripts"];
			echo '$(window).bind("load", function(){' . 
				$pQuery['moduleRunScripts'] . 
			'} );';
		?>
		// -->
		</script>
		<script type="text/javascript">
		<!--
		<?php 			
			#standard scripts
			echo $_GET["moduleScripts"];
			echo $standardRunScripts;
		?>
		$(window).load(function(){
			<?php 
				echo $_SESSION["modulePageTransition"];
			?>
		});
		// -->
		</script>
	</body>
</html>