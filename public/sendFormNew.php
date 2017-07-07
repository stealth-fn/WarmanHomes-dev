<?php
	#check if the POST data is sent from the CMS's javascript
	#if(isset($_POST["scriptSend"])){	
	if(isset($_POST["scriptSend"])){	
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/cmsSettings.php"); #If it is not a bot it will be set to 0
		$bot = 0; #If there is a Google Recaptcha is part of the form
		if(isset($_POST['g-recaptcha-response'])) {
			
			$captcha = $_POST['g-recaptcha-response'];

			if(!$captcha){ #The reCAPTCHA was not entered. Do not send form.
				exit;
			}
			
			$secretKey = $_SESSION["reCAPTCHASecretKey"];
			$ip = $_SERVER['REMOTE_ADDR'];
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
			$responseKeys = json_decode($response,true);
			
			if(intval($responseKeys["success"]) !== 1) { #There was a problem. You are a bot!
				$bot = 1;
			}
		}
		
		#Oh good I am not a bot. Continue.
		if ($bot == 0) {

			$logo = '<div style="display:block;">
			<img alt="' . $_SESSION["siteName"] . '" 
			src="http://'.$_SERVER['SERVER_NAME'].'/images/admin/logo-project.png" width="150"/>
			</div>';

			$message .= '<table><tbody>';

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
					if (is_array($paramValue)) {
						$message .= implode(", " , $paramValue);
					}
					else {
						$message .=  $paramValue;
					}
					
					$message .=  '</td>';
					$message .=  '</tr>';

					$i++;
				}

				if($paramName == "formPriKeyID"){ #This is the Primary Key of the form that is being passed in.
					$formPriKeyID = $paramValue;
				}

				if(filter_var($paramValue, FILTER_VALIDATE_EMAIL)){
					$replyEmail = $paramValue;
				}
			}

			$message .=  '</tbody>';
			$message .=  '</table>';

			#Get the admin email address for the site
			$to = $_SESSION["adminEmail"];
			#get the default subject line
			$subject = $_SESSION["siteName"] . " Website Form"; 
			
			#If this form was sent from the form Module
			if ($formPriKeyID) { #Fetch Contact Form Settingsfrom DB
				include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/contactUs/contactUs.php");
				$contactUsObj = new contact(false, NULL);
				$contact = $contactUsObj->getRecordByID($formPriKeyID); #as long as there is some info continue
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
					
					#send required info to the sendMail funtion
					sendMail($to,$subject,$message, $replyEmail);
					
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
			} else { #Add company logo to the message 
				$message = $logo ."".$message;
				#send required info to the sendMail funtion
				sendMail($to,$subject,$message, $replyEmail);
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



function sendMail( $to, $subject, $messageHTML, $replyEmail ) {
	
	include_once($_SERVER['DOCUMENT_ROOT']."/PHPMailer/PHPMailerAutoload.php");

	#email sending the messages
	$from = 'tech@stealthinteractive.net';
	#password for email sending the messages
	$pass = 'paperbeatsrock';
	
	$email = new PHPMailer();
	#$email->IsSMTP(); #Use SMTP
	#$email->Host        = "mail.stealthinteractive.net"; #Sets SMTP server
	#$email->SMTPDebug   = 2; #2 to enable SMTP debug information
	#$email->SMTPAuth    = TRUE; #enable SMTP authentication
	#$email->SMTPSecure  = "tls"; #Secure conection
	#$email->Port        = 587; #set the SMTP port
	$email->Username 	= $from; #SMTP account username
	$email->Password 	= $pass; #SMTP account password
	$email->Priority    = 1; #Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
	$email->CharSet     = 'UTF-8';
	$email->Encoding    = '8bit';
	$email->Subject     = $subject;
	$email->ContentType = 'text/html; charset=utf-8\r\n';
	$email->From        = $from;
	$email->AddReplyTo("" . $replyEmail . "");
	$email->FromName    = $_SESSION["siteName"];
	$email->WordWrap    = 900; #RFC 2822 Compliant for Max 998 characters per line
	
	foreach($_FILES as $index => $file)	{ #for easy access
		$fileName     = $file['name']; #for easy access
		$fileTempName = $file['tmp_name'];			
		$email->AddAttachment($fileTempName , $fileName);			
	}

	if( strpos($to, ',') !== false ) {
		$myArray = explode(',', $to);
		foreach ($myArray as &$value) {
			$email->AddAddress("" .$value . "");
			$sentFrom = $value;
		}
	}
	#If there is only one then just add that one.
	else {
		$email->AddAddress($to);
		$sentFrom = $to;
	}
	
	$email->isHTML( TRUE );
	$email->Body    = $messageHTML;
	$email->Send();
	$email->SmtpClose();

	#send email.
	if ( $email->IsError() ) { #This error checking was missing
		echo 'Mailer Error: ' . $email->ErrorInfo;
		return FALSE;
	}
	else {
		echo "Message has been sent successfully";
		return TRUE;
	}
}

?>