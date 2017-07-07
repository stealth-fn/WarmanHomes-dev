<?php
	#check if the POST data is sent from the CMS's javascript
	if(isset($_POST["scriptSend"])){
		#get CMS settings
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php");
		
		#set the charset and content type!
		iconv_set_encoding("internal_encoding", "UTF-8");
		iconv_set_encoding("output_encoding", "UTF-8");
		iconv_set_encoding("input_encoding", "UTF-8");
		
		//If it is not a bot it will be set to 0
		$bot = 0;
		
		//If there is a Google Recaptcha is part of the form
		if(isset($_POST['g-recaptcha-response'])) {
			
			$captcha = $_POST['g-recaptcha-response'];

			if(!$captcha){
				//The reCAPTCHA was not entered. Do not send form.
				exit;
			}
			
			$secretKey = $_SESSION["reCAPTCHASecretKey"];
			$ip = $_SERVER['REMOTE_ADDR'];
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
			$responseKeys = json_decode($response,true);
			
			if(intval($responseKeys["success"]) !== 1) {
				//There was a problem. You are a bot!
				$bot = 1;
			}
		}
		
		//Oh good I am not a bot. Continue.
		if ($bot == 0) {

			$message = '<table><tbody>';

			#the reply-to email address in the header
			$replyEmail = "";

			foreach ($_POST as $paramName => $paramValue){

				#no need to send these parameter to the user
				if($paramName !== "scriptSend" && 
				   $paramName !== "formPriKeyID" && 
				   $paramName !== "g-recaptcha-response") {
					
					if ($i % 2 != 0) {
						$message .= '<tr style="background-color:#fff;">';
					} else {
						$message .= '<tr style="background-color:#eeeff1;">';
					}
					$message .= '<td style="padding:10px;width:50%;font-weight:bold;">';
					$message .=  $paramName;
					$message .=  '</td>';
					$message .=  '<td style="padding:10px;width:50%;">';
					$message .=  $paramValue;
					$message .=  '</td>';
					$message .=  '</tr>';

					$i++;
				}

				if($paramName == "formPriKeyID"){
					//This is the Primary Key of the form that is being passed in.
					$formPriKeyID = $paramValue;
				}

				if(filter_var($paramValue, FILTER_VALIDATE_EMAIL)){
					$replyEmail = $paramValue;
				}
			}

			$message .=  '</tbody>';
			$message .=  '</table>';


			$to = $_SESSION["adminEmail"];
			$subject = $_SESSION["siteName"] . " Website Form";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= "From: " . $_SESSION["siteName"] . "<" . $_SESSION["adminEmail"] . ">\r\n";
			$headers .= "Reply-To: " . $replyEmail;

			//If this form was sent from the form Module
			if ($formPriKeyID) {
				//Fetch Contact Form Settingsfrom DB
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/contactUs/contactUs.php");
				$contactUsObj = new contact(false, NULL);
				$contact = $contactUsObj->getRecordByID($formPriKeyID);
				//as long as there is some info continue
				if(mysqli_num_rows($contact) > 0){
					
					$x = mysqli_fetch_assoc($contact);

					if ($x['sentTo']) {
						$to = $x['sentTo'];
					}
					if ($x['subject']) {
						$subject = $x['subject'];
					}

					$message = $logo ."
					<div><p>".$x['formName']."</p></div>
					".$message;

					#Send the form to the client
					mail($to, $subject, $message, $headers);
					#if auto response is turned on continue
					if ($x["autoResponseActive"]) {
						
						$noreply = "noreply@" . array_pop(explode('@', $to));

						$message = $x["autoResponseBody"];

						$to = $replyEmail;
						$subject = $x["autoResponseSubject"];
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
						$headers .= "From: " . $_SESSION["siteName"] . "<" . $noreply . ">\r\n";
						$headers .= "Reply-To: " . $noreply;

						#Send an email to the person that is contacting us to let them know we got it.
						mail($to, $subject, $message, $headers);

					}
				}
			} else {
				$message = $logo ."".$message;
				#mail to the admins of the CMS
				mail($to, $subject, $message, $headers);
			}


			#create as a Zoho lead
			if(isset($_SESSION["zohoAuth"]) && strlen($_SESSION["zohoAuth"])) {
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/zoho/zoho.php");
				$zohoObj = new zoho(false);
				$zohoObj->sendZohoLead($_POST);
			}
		}
		else {
			echo "You are probably a bot. No Script For You!";
		}
		
	}
	else{
		echo "You are probably a bot. No Script For You!";
	}
?>