<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
	$moduleObj = new module(false);
	$modules = $moduleObj->getRecordByID($_REQUEST["moduleID"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<!--quick fix for multi-step pop up modules - jared-->
		<style title="moduleStyles"></style>
		<?php
			#public side module
			$GLOBALS['isPublic'] = true;
				
			$m = $moduleObj->processRecord($modules);
			#page module scripts and styles			
			echo '<title>' . $m["moduleName"] . '</title>';
		
			if(strlen($m["cssLink"]) > 0){
				$cssStyles = explode("?^^?",$m["cssLink"]);
				for($i=0;$i<count($cssStyles);$i++){
					echo '<link 
								href="' . $cssStyles[$i] . '" 
								id="moduleStyle' . $i . '" 
								rel="stylesheet" 
								type="text/css"
						  />';
				}
			}
			
			if($m["isAdmin"]==1) echo '<link 
											href="/css/admin.css" 
											rel="stylesheet" 
											type="text/css"
						 				/>';
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js" type="text/javascript"></script>
		<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
		<script 
			src="/js/headScripts.php?pageID=-1&amp;mID=<?php echo $_REQUEST["moduleID"]; ?>" 
			type="text/javascript">
		</script>
	</head>
	<body>
		<?php
			include($_SERVER['DOCUMENT_ROOT'].$m["includeFile"]);
			
			#input module
			if(isset($addEditFilePath)) include($_SERVER['DOCUMENT_ROOT'].$addEditFilePath);
		?>
		<script id="moduleScript" type="text/javascript">
		<!--
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/js/moduleScripts.php");?>
		// -->
		</script>
	</body>
</html>