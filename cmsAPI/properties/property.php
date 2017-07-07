<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');	
	
	class property extends common {	
		public $moduleTable = "properties";
		public $instanceTable = "instance_properties";
		
		public function __construct($isAjax,$pmpmID = 1){
			parent::__construct($isAjax,$pmpmID);
			
			$this->mappingArray = array();			
			$this->mappingArray[0] = array();
			$this->mappingArray[0]["priKeyName"] = "propertyID";
			$this->mappingArray[0]["fieldName"] = "typeID";
			$this->mappingArray[0]["apiPath"] = "/cmsAPI/properties/propertyType/propTypeMap.php";
					
			$this->mappingArray[1] = array();
			$this->mappingArray[1]["priKeyName"] = "propertyID";
			$this->mappingArray[1]["fieldName"] = "citiesID";
			$this->mappingArray[1]["apiPath"] = "/cmsAPI/properties/propertyCity/propCityMap.php";
		}
	
	
	
	public function propertySearch($searchParams){
			
			#mysqli_set_charset('utf8');
			#convert modData to an associative array
			#$argsArray = json_decode(urldecode($searchParams),true);
			$argsArray = $searchParams;	
			
			$condStr = "WHERE ";
			$condArray = array();								
			
			#searching for building name or address
			if(strlen($argsArray["Keyword"]) > 0 && $argsArray["Keyword"] != ""){
				array_push($condArray," (properties.propertyName LIKE '%" . $argsArray["Keyword"] . "%')");
			}
			
			if($argsArray["bedroom"] != ""){
				$arr = $argsArray["bedroom"];
				$bedroomCon = array();
				$allBedroomCon = "";
				foreach ($arr as $value) {
					if ($value == "4") {
						array_push($bedroomCon, " properties.numOfBedrooms >= '". $value."'");	
					}
					else {
						array_push($bedroomCon, "properties.numOfBedrooms LIKE '". $value."'");
					}
				}
				
				
				$allBedroomCon .= "(". implode(" OR ", $bedroomCon) . ")";	
				
				array_push($condArray, $allBedroomCon);	
			}
			
			if(strlen($argsArray["minPrice"]) > 0 || strlen($argsArray["maxPrice"]) > 0){
				array_push($condArray," (properties.price BETWEEN " . $argsArray["minPrice"] . " AND " . $argsArray["maxPrice"] . ")");
			}
			
			array_push($condArray," (properties.isActive=1)");
			
			if(strlen($argsArray["propertyType"]) > 0 && $argsArray["propertyType"] != "0") {
				array_push($condArray," (property_type_map.propertyID ='". $argsArray["propertyType"] ."')");
				array_push($condArray," (property_type_map.typeID = properties.priKeyID)");
			}
			
			if(strlen($argsArray["City"]) > 0 && $argsArray["City"] != "0") {
				array_push($condArray," (property_city_map.citiesID ='". $argsArray["City"] ."')");
				array_push($condArray," (property_city_map.propertyID = properties.priKeyID)");
			}
			
			$condStr .= implode(" AND ", $condArray);		
			
			$mq = "";
			#if we have conidtions
			if(count($condArray) > 0) {
				$mq = "
					SELECT * FROM property_type_map, property_city_map, properties
				" . $condStr . "Group By properties.priKeyID";
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
			
			#return $this->commonReturn($mq);
		}
	}
	
	
	if(isset($_REQUEST["function"])){	
		$moduleObj = new property(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new property(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}

?>