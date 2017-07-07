<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class fileLibraryCategory extends common{
		public $moduleTable = "file_library_categories";
		public $instanceTable = "instance_fileLibrary_category";
		
		public function __construct($isAjax,$pmpmID = 1){		
			parent::__construct($isAjax,$pmpmID);
		
			#mapping infor for pages and user groups
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "fileLibraryCategoryID";
			$this->mappingArray[0]["fieldName"] = "fileLibraryID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/fileLibrary/fileLibraryCatMap.php";
		}
		
		# Added for SHRF site
		public function getAllCategoryFiles($fileCatID){
						
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/fileLibrary/fileLibraryCatMap.php");
			$fileCatObj = new fileLibraryCatMap(false);
			
			$catFiles = $GLOBALS["mysqli"]->query("SELECT fcm.priKeyID, fcm.fileLibraryID, fcm.fileLibraryCategoryID
			 FROM file_library_category_map AS fcm
			 WHERE fcm.fileLibraryID 
			 IN (
					 SELECT fileLibraryID 
					 FROM file_library_category_map
					 WHERE fileLibraryCategoryID = " . $GLOBALS["mysqli"]->real_escape_string($fileCatID) . "
				)
			 AND
			 fcm.fileLibraryCategoryID = " . $GLOBALS["mysqli"]->real_escape_string($fileCatID));
			 
			$fileList = $this->getQueryValueString($catFiles,"fileLibraryID",",");

			return $fileList;			
		}
	}
		
	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){
		$moduleObj = new fileLibraryCategory(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new fileLibraryCategory(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>