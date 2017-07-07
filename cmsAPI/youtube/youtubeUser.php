<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class youtubeUser extends common{	
		public $moduleTable = "";
		
		function __construct($isAjax){
			parent::__construct($isAjax);
			
			/*set include_path for zend library*/
			$path = $_SERVER['DOCUMENT_ROOT'].'/cmsAPI/library';
			set_include_path(get_include_path() . PATH_SEPARATOR . $path);
			
			// the Zend dir must be in your include_path, set from dataSet.php
			require_once 'Zend/Loader.php'; 
			Zend_Loader::loadClass('Zend_Gdata_YouTube');
			Zend_Loader::loadClass('Zend_Gdata_AuthSub');
		}
			
		public function getAuthTok(){
			$next = 'http://' . $_SERVER['SERVER_NAME'] . '/modules/youtube/youtubeAccount/passToken.php';
			$scope = 'http://gdata.youtube.com';
			$secure = false;
			$session = true;
			echo Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure, $session);
		}
		
		/*if we need to get a login token from a different module*/
		public function getBlogAuth(){
			$next = 'http://' . $_SERVER['SERVER_NAME'] . '/modules/youtube/youtubeAccount/passBlogToken.php';
			$scope = 'http://gdata.youtube.com';
			$secure = false;
			$session = true;
			echo Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure, $session);
		}
	}
	
	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){	
		$moduleObj = new youtubeUser(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new youtubeUser(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>