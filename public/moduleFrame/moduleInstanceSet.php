<?php 
	if(isset($_REQUEST["csvDump"])){ 
		header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename="NSC_Load_Info.csv"');
	}
	#this file should be only be called durring a partial page load... ex pagination...
	if(!isset($_SESSION)) session_start();
	
	#parse our pmpm param from JSON to php array
	include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/pmpmParse.php");

	#if its pagination
	if(isset($requestPMPM)){	
		#setup $pMod for this module
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/module.php");
		$moduleObj = new module(false,NULL);
		$pageModules = $moduleObj->getModuleInfoQuery(NULL,key($requestPMPM));
		$pMod = mysqli_fetch_assoc($pageModules);
				
		#echo $requestPMPM[$pMod["priKeyID"]]["pagPage"];
		#setup the object for the module
		include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleObjectSet.php");
		
		#setup module instance
		include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleQuerySet.php");
		$priModObj[0]->pagPage = $requestPMPM[$pMod["priKeyID"]]["pagPage"];
	
		#not being loaded into the click slide
		if(
			!isset($priModObj[0]->clickStorage) || 
			isset($priModObj[0]->clickStorage) && $priModObj[0]->clickStorage == "0"
		){
			if(!isset($_REQUEST["csvDump"])) {
				#get items for this module
				ob_start();
				include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFrameItems.php");
				$moduleCode = ob_get_contents();
				ob_end_clean();

				#get scripts
				#setup our javascript for this module
				$moduleObj->setModuleScript($priModObj);

				if ($priModObj[0]->refreshPag) {
					#get pagination for this module
					ob_start();
					include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/modulePaginate.php");
					$modulePag = ob_get_contents();
					ob_end_clean();

					#get pagination quantity drop down for this module
					ob_start();
					include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFramePaginateQty.php");
					$modulePagQty = ob_get_contents();
					ob_end_clean();
				}
				else {
					$modulePag = "";
					$modulePagQty = "";
				}

				$moduleArray = array();
				$moduleArray["DOM"] = $moduleCode;
				$moduleArray["JS"] = $_GET["moduleScripts"];
				$moduleArray["PAG"] = $modulePag;
				$moduleArray["PAGQTY"] = $modulePagQty;


				echo utf8_encode(json_encode($moduleArray));
			}
			else {
				$priModObj[0]->getCSVDump();
			}
		}
	}
	
?>