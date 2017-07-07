<?php 
	if(
		#loading in a module instance individually - bulk add/edit, thumbnails
		(!isset($pMod) &&
		(!isset($priModObj) ||
		(isset($priModObj) && count($priModObj) === 0))) ||
		(isset($_GET["isThumb"]) && $_GET["isThumb"] == 1)
	){
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
		$moduleObj = new module(false, NULL);
				
		$modThumb = $moduleObj->getModuleInfoQuery(NULL,$_GET["pmpmID"]);
		$pMod = mysqli_fetch_assoc($modThumb);
		
		if(!isset($beforeModuleCode)) $beforeModuleCode = "";
		if(!isset($afterModuleCode)) $afterModuleCode = "";
		
		unset($_GET["isThumb"]);
	}
	
	#setup the object for the module
	include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleObjectSet.php");
	
	#log how long it took to run this module
	if($_SESSION["moduleBenchmark"]){
		#setup benchmark timer
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;
		
		#gather the DOM and CSS for the module
		include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pageModuleDOMBuild.php");
		
		#get time, and insert into dabase
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$endtime = $mtime;
		$totaltime = ($endtime - $starttime);
		
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/moduleBenchmark.php");
		$moduleBenchmarkObj = new moduleBenchmark(false, NULL);
		
		$paramsArray = array();
		$paramsArray["moduleID"] = $priModObj[0]->moduleID;
		$paramsArray["moduleName"] = $priModObj[0]->moduleName;
		$paramsArray["pageID"] = $priModObj[0]->priKeyID;
		$paramsArray["execTime"] = $totaltime;
		$moduleBenchmarkObj->addRecord($paramsArray);
	}
	else{
		#gather the DOM and CSS for the module 
		include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/pages/pageModuleDOMBuild.php");
	}

	#setup our javascript for this module
	$moduleObj->setModuleScript($priModObj);
	
	/*thumb nails for the module. we want to load it automatically, so if it's a level >= 2
	it will be at the same level in the DOM as the parent module it's going to control...
	for example we have a gallery in a product module, and  that gallery has thumbnails,
	this will load in the thumbnails right after the gallery*/
	if($priModObj[0]->clickThumbs == 1) {
		#get the pmpmID for this modules thumbnails
		$_GET["pmpmID"] = $priModObj[0]->clickThumbsPmpmID;
		$_GET["isThumb"] = 1;
		#remove object at front of the array, returns to level above
		array_shift($priModObj);

		include($_SERVER['DOCUMENT_ROOT'] . "/cmsAPI/pages/pageModuleBuild.php");
	}
	else{
		#remove object at front of the array, returns to level above 
		array_shift($priModObj);
	}
?>