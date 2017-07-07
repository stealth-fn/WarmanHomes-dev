<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	class fileLibrary extends common{
		public $moduleTable = "file_library";		
		public $instanceTable = "instance_fileLibrary";

		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
			#mapping infor for pages and user groups
			$this->mappingArray = array();
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "fileLibraryID";
			$this->mappingArray[0]["fieldName"] = "fileLibraryCategoryID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/fileLibrary/fileLibraryCatMap.php";
			
			
			$this->mappingArray[1] = array();
			$this->mappingArray[1]["priKeyName"] = "fileLibraryID";
			$this->mappingArray[1]["fieldName"] = "ageID";
			$this->mappingArray[1]["apiPath"] = "/cmsAPI/fileLibrary/fileLibraryAge/fileLibraryAgeMap.php";
			
			
			$this->mappingArray[2] = array();
			$this->mappingArray[2]["priKeyName"] = "fileLibraryID";
			$this->mappingArray[2]["fieldName"] = "gradeID";
			$this->mappingArray[2]["apiPath"] = "/cmsAPI/fileLibrary/fileLibraryGrade/fileLibraryGradeMap.php";
		}
		
		public function removeFile($priKeyID){
			$fileInfo = $this->getRecordByID($priKeyID);
			#where do we save the files
			while($x = mysqli_fetch_array($fileInfo)){
				unlink($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $x["galleryID"] . "/original/" . $x["fileName"]);
		 		unlink($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $x["galleryID"] . "/thumb/" . $x["fileName"]);
		 		unlink($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $x["galleryID"] . "/medium/" . $x["fileName"]);
		 		unlink($_SERVER['DOCUMENT_ROOT']. '/images/galleryImages/' . $x["galleryID"] . "/large/" . $x["fileName"]);
			}
		}

		public function mapPublicUsers($fileID,$userID){
			$this->isAjax = false;
			#remove all old entries!
			mysqli_query("DELETE FROM file_library_user_map WHERE fileID = " . $fileID . ";");

			if(!empty($userID)){
				$children = explode(",",$userID);
				if(count($children) > 0){
					foreach($children as $cID){
						$values .= "(".$fileID.",".$cID."),";
					}
					echo "INSERT INTO file_library_user_map (fileID,userID) VALUES" . substr($values,0,strlen($values)-1) . ";";
					$result = mysqli_query("INSERT INTO file_library_user_map (fileID,userID) VALUES" . substr($values,0,strlen($values)-1) . ";");										
					echo $result;
				}
				else echo "1";
			}
			else echo "1";
		}
		
		public function lessonSearch($searchParams){
				
				$argsArray = $searchParams;	
				
				$condStr = "WHERE ";
				$condArray = array();			
				
				#searching for building name or address
				if(strlen($argsArray["Keyword"]) > 0 && $argsArray["Keyword"] != ""){
					array_push($condArray," (file_library.fileName LIKE '%" . $argsArray["Keyword"] . "%')");
				}
				
				if(strlen($argsArray["Subject"]) > 0 && $argsArray["Subject"] != "0") {
					array_push($condArray," (file_library_category_map.fileLibraryCategoryID ='". $argsArray["Subject"] ."')");
					array_push($condArray," (file_library_category_map.fileLibraryID = file_library.priKeyID)");
				}
				
				if(strlen($argsArray["Grade"]) > 0 && $argsArray["Grade"] != "0") {
					array_push($condArray," (file_library_grade_map.gradeID ='". $argsArray["Grade"] ."')");
					array_push($condArray," (file_library_grade_map.fileLibraryID = file_library.priKeyID)");
				}
				
				if(strlen($argsArray["Age"]) > 0 && $argsArray["Age"] != "0") {
					array_push($condArray," (file_library_age_map.ageID ='". $argsArray["Age"] ."')");
					array_push($condArray," (file_library_age_map.fileLibraryID = file_library.priKeyID)");
				}
				
				$condStr .= implode(" AND ", $condArray);		
				
				$mq = "";
				#if we have conidtions
				if(count($condArray) > 0) {
					$mq = "
						SELECT * FROM file_library_age_map, file_library_category_map, file_library_grade_map, file_library
					" . $condStr . "Group By file_library.fileDesc";
				}
				else {
					$mq = "
						SELECT * FROM file_library
					Group By file_library.fileDesc";
				}
				
				
				if(
					(strpos($_SERVER['REQUEST_URI'],"modulePaginate.php") !== false ||
					strpos($_SERVER['REQUEST_URI'],"moduleInstanceSet.php") !== false) &&
					#not a module level > 2
					!isset($priModObj[1])
				){
					#if there isn't a currentPagPage its probably a level > 2 module
					if(!isset($this->currentPagPage)) {
						$this->currentPagPage = 1;
					}	
	
					#probably being called in some API file, not set with the module
					if(
						!isset($this->displayQty) || 
						isset($this->displayQty) && $this->displayQty == -1
					) {
						$this->displayQty = "2147483647";
					}
	
					$startRec = ($this->currentPagPage-1) * $this->displayQty;
					$dspQty = $this->displayQty;
					$ordinalStr = " LIMIT " . $startRec . "," . $dspQty;
				}
				else{
					$ordinalStr = "";
				}
		
				return $this->commonReturn($mq . $ordinalStr);
		}
		
	}

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new fileLibrary(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new fileLibrary(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>