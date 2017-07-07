<?php
if(array_key_exists("Contact Form",$priModObj[0]->domFields)){
	$priModObj[0]->domFields["Contact Form"] =
	'<div id="'.$priModObj[0]->className.'Outter">
		<div id="'.$priModObj[0]->className.'Inner">
			<form name="'.$priModObj[0]->className.'" id="'.$priModObj[0]->className.'" action="return%20false">
				<fieldset>';
	if ($priModObj[0]->queryResults["firstName"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["firstNameReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="field">
			<label for="firstName-'.$priModObj[0]->className.'">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['fname'] .' '. $requiredMark.'</label>
			<input type="text" title="First Name"  name="First Name" id="firstName-'.$priModObj[0]->className.'" placeholder="First Name" '.$required.'/>
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["lastName"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["lastNameReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="field">
			<label for="lastName-'.$priModObj[0]->className.'">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['lname'] .' '. $requiredMark.'</label>
			<input type="text" title="Last Name" name="Last Name" id="lastName-'.$priModObj[0]->className.'" placeholder="Last Name" '.$required.'/>
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["fullName"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["fullNameReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="field">
			<label for="fullName-'.$priModObj[0]->className.'">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['fullName'] .' '. $requiredMark.'</label>
			<input type="text"  name="Full Name" id="fullName-'.$priModObj[0]->className.'" placeholder="Full Name" '.$required.'/>
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["companyName"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["companyNameReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="field">
			<label for="companyName-'.$priModObj[0]->className.'">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['compName'] .' '. $requiredMark.'</label>
			<input type="text"  name="Company Name" id="companyName-'.$priModObj[0]->className.'" placeholder="Company Name" '.$required.'/>
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["phoneNumber"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["phoneNumberReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="field">
			<label for="phoneNumber-'.$priModObj[0]->className.'">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['phone'] .' '. $requiredMark.'</label>
			<input type="tel"  name="Phone Number" id="phoneNumber-'.$priModObj[0]->className.'" placeholder="Phone Number" '.$required.'/>
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["email"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["emailReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="field">
			<label for="email-'.$priModObj[0]->className.'">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['email'] .' '. $requiredMark.'</label>
			<input type="email"  name="Email" id="email-'.$priModObj[0]->className.'" placeholder="Email Address" '.$required.'/>
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["howToContact"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["howToContactReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="field ">
			<label class="requiredLabel center" id="howToContactLabel-'.$priModObj[0]->className.'" for="howToContact">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['contactPref'] .' '. $requiredMark.'</label>
			
			<div class="radio">
				<label for="howToContact">
					<input class="ContactTypePreference" id="howToContact-'.$priModObj[0]->className.'" name="Contact Preference" value="Phone" type="radio"'.$required.'>
			  	<label for="howToContact-'.$priModObj[0]->className.'"><span><span></span></span>Phone</label>
					</label>
			</div>
			<div class="radio">
				<label for="ContactTypeEmail-'.$priModObj[0]->className.'">
					<input class="ContactTypePreference" id="ContactTypeEmail-'.$priModObj[0]->className.'" name="Contact Preference" value="Email" type="radio">
			  	<label for="ContactTypeEmail-'.$priModObj[0]->className.'"><span><span></span></span>Email</label>
			</div>
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["fileUpload"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["fileUploadReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="textContainer left">
			<label for="fileToUpload" class="fileLabel">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['file'] .' '. $requiredMark.'</label>
			<input type="file" '.$required.' name="fileToUpload[]" id="fileToUpload" multiple="multiple">
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["comments"]) {
		$required = '';
		$requiredMark = '';
		
		if ($priModObj[0]->queryResults["commentsReq"]) {
			$required = 'required';
			$requiredMark = '*';
		}
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="textContainer">
			<label for="comments-'.$priModObj[0]->className.'">
			' . $priModObj[0]->languageLabels[$_SESSION["lng"]]['comments'] .' '. $requiredMark.'</label>
			<textarea 
				rows="1" cols="1" name="Comments" 
				id="comments-'.$priModObj[0]->className.'"
				placeholder="Question / Comments"
				'.$required.'
			></textarea>
		</div>
		';	
	}
	if ($priModObj[0]->queryResults["reCAPTCHA"] && strlen($_SESSION["reCAPTCHASiteKey"]) > 0 && strlen($_SESSION["reCAPTCHASecretKey"]) > 0){
		
		$priModObj[0]->domFields["Contact Form"] .= '
		<div class="textContainer">
		<div id="reCAPTCHA"></div>
		</div>';
		$recap = 1;
	}else{
		$recap = 0;
	}
	
	
	$priModObj[0]->domFields["Contact Form"] .= '
				<div><a class="btn button2" onclick="sendContactFormValues($(\'#'.$priModObj[0]->className.'\'),'.$priModObj[0]->queryResults["priKeyID"].','.$recap.')">Submit</a></div>
				</fieldset>
			</form>
		</div>
	</div>
	';
}
elseif(isset($priModObj[0]->ispmpmBuild)){
	$priModObj[0]->domFields["Contact Form"] = "";
}

if(array_key_exists("Form Name",$priModObj[0]->domFields)){
	$priModObj[0]->domFields["Form Name"] = "<div>" . $priModObj[0]->queryResults["formName"] . "</div>";
}
elseif(isset($priModObj[0]->ispmpmBuild)){
	$priModObj[0]->domFields["Form Name"] = "";
}

if(array_key_exists("Description",$priModObj[0]->domFields)){
	$priModObj[0]->domFields["Description"] = "<div>" . $priModObj[0]->queryResults["description"] . "</div>";
}
elseif(isset($priModObj[0]->ispmpmBuild)){
	$priModObj[0]->domFields["Description"] = "";
}

?>
