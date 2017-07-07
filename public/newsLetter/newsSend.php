<?php 
	#get CMS settings
	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
	
	if(isset($_GET["emailAddress"])==true){
		$to = $_SESSION["adminEmail"];
		$subject = "Newsletter Request";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= "From: " . $_SESSION["siteName"];
		$headers .= "From: " . $_SESSION["siteName"];
		$message = "Please add " . $_GET["emailAddress"] . " to the mailing list!";
		
		$mailed = mail($to, $subject, $message, $headers);
	}
	
	if($mailed){
		echo "1";
	}
	else{
		echo "0";
	}
?>