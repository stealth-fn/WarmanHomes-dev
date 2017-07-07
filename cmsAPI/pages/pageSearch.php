<?php	

	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');	

	

	class pageSearch extends common{

		public $moduleTable = "instance_page_search";

		

		public function publicPageSearch($searchTerm){

			$sanitizedSearch = $GLOBALS["mysqli"]->real_escape_string($searchTerm,$this->openConn());

			$query = "SELECT DISTINCT public_pages.pageCode, public_pages.pageTitle, public_pages.priKeyID

					  FROM public_pages

					  WHERE public_pages.pageCode LIKE \"%".$sanitizedSearch."%\" OR

					  public_pages.pageTitle LIKE \"%".$sanitizedSearch."%\"";

					  

			$result = $this->getCheckQuery($query,$this->openConn());

			return $this->commonReturn($result);

		}

	}

	

	#ajax, our first parameter is the function name, the other parameters are parameters for that function

	if(isset($_REQUEST["function"])){	

		$moduleObj = new pageSearch(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');

	}

	elseif(isset($_REQUEST["modData"])){

		$moduleObj = new pageSearch(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');

	}

?>