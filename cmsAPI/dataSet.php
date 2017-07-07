<?php
	#start our user session
	if(!isset($_SESSION) && !headers_sent()){
		session_start();
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
	}
	
	$mysqli = false;

	class dataSet {		
	
		protected function __construct($isAjax){
			global $mysqli;
			#connect to database if connection doesn't already exist
			if(!$mysqli) $this->openConn();
		}
		
		protected function openConn(){
			global $mysqli;
			
			$mysqli = new mysqli(
				$_SESSION['dbHostName'],$_SESSION['dbUsername'],
				$_SESSION['dbPassword'],$_SESSION['dbName']
			);
			
			/*$mysqli = new mysqli(
				'cmsprod.stealthssd.com','mystealt_cmsprod',
				'uWPew@fkZ8IU','mystealt_cmsprod'
			);*/
			
			return $mysqli;
		}
	}
?>