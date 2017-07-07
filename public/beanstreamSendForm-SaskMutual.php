<?php
//get Beanstream Gateway
require_once "/home/sask432m/public_html/Beanstream/Gateway.php";

//Stealth Testing Credentials 
$merchant_id = '300203673'; //INSERT MERCHANT ID (must be a 9 digit string)
$api_key = '0274416dD5C84176809744B35e50c208'; //INSERT API ACCESS PASSCODE

//Live Credentials 
//$merchant_id = '117682326'; //INSERT MERCHANT ID (must be a 9 digit string)
//$api_key = '786bF9a5F749400988DD09C4f18D3b0F'; //INSERT API ACCESS PASSCODE

$api_version = 'v1'; //default
$platform = 'www'; //default

//init new Beanstream Gateway object
$beanstream = new \Beanstream\Gateway($merchant_id, $api_key, $platform, $api_version);

//Order # for testing.
#$order_number = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));


$amount = $_POST["tx_form"]["amount"];
$amount = floatval($amount);
$amount = round($amount, 2);

if (empty($_POST["tx_form"]["name"])) {
	$error .= "Client Name is required</br>";
} else {
	$name = test_input($_POST["tx_form"]["name"]);
	// check if name only contains letters and whitespace
	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		$error .= "Client Name: Only letters and white space allowed</br>";
	}
}

if (empty($_POST["tx_form"]["order_number"])) {
	$error .= "Policy Number is required</br>";
} else {
	$order_number = test_input($_POST["tx_form"]["order_number"]);
	// Between 5-10 digits then 1-5 alphabet then 2 more digits.
	if (!preg_match("/\d{5,10}?[a-z-A-z]{1,5}?\d{2}/",$order_number)) {
		$error .= "Policy Number: Invalid format</br>";
	}
}

if (empty($_POST["tx_form"]["email"])) {
	$emailErr = "Email Address is required";
} else {
	$email = test_input($_POST["tx_form"]["email"]);
	// check if e-mail address is well-formed
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  	$error .= "Email Address: Invalid email format";
	}
}

if (empty($_POST["tx_form"]["phoneNumber"])) {
	$error .= "Phone Number is required</br>";
} else {
	$phoneNumber = test_input($_POST["tx_form"]["phoneNumber"]);
	//Get only the numbers entered in the phone number
	$phoneNumber =  preg_replace("/[^0-9,.]/", "", $phoneNumber);
	//Check for valid phone number
	if (!preg_match("/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/",$phoneNumber)) {
		$error .= "Phone Number: Invalid email format  Example: (306) 555-5555</br>";
	}
}

if (empty($_POST["tx_form"]["ccName"])) {
	$error .= "Name on Credit Card is required</br>";
} else {
	$ccName = test_input($_POST["tx_form"]["ccName"]);
	//check if name only contains letters and whitespace
	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		$error .= "Name on Credit Card: Only letters and white space allowed</br>";
	}
}

if (empty($_POST["tx_form"]["cc-number"])) {
	$error .= "Card Number is required</br>";
} else {
	$ccNumber = $_POST["tx_form"]["cc-number"];
	//replace know and allowed characters
	$ccNumber = str_replace("-","",$ccNumber);
	$ccNumber = str_replace(" ","",$ccNumber);
	//make sure it is the correct length
	if (!preg_match("/^[0-9]{16}$/",$ccNumber)) {
		$error .= "Invalid Credit Card Length</br>";
	}
	//make sure it is valid
	if (!preg_match("/((4\d{3})|(5[1-5]\d{2})|(6011))-?\d{4}-?\d{4}-?\d{4}|3[4,7]\d{13}$/",$ccNumber)) {
		$error .= "Card Number: Invalid Credit Card format</br>
			Valid Credit Card Formats: </br> 5555 0000 0000 0000 OR 5555-0000-0000-0000 OR55550000000000";
	}
}

if (empty($_POST["tx_form"]["ccCvv"])) {
	$error .= "CVV is required</br>";
} else {
	$ccCvv = test_input($_POST["tx_form"]["ccCvv"]);
	//Make sure VCC is valid
	if (!preg_match("/^([0-9]{3})$/",$ccCvv)) {
		$error .= "CVV: Invalid CVV</br>";
	}
}

$ccMonth = $_POST["tx_form"]["ccMonth"];
$ccYear = $_POST["tx_form"]["ccYear"];

if ($ccYear < 2000) {
	$error = "FORM BROKEN - CONTACT ADMIN</br>";
}

//Get the last 2 digits of the year
$ccYear = substr($ccYear, -2);

if ($ccMont > 12) {
	$error = "FORM BROKEN - CONTACT ADMIN</br>";
}


//example payment transaction data
//$payment_data = array(
//        'order_number' => $order_number,
//        'amount' => $amount,
//        'payment_method' => 'card',
//        'card' => array(
//            'name' => 'Mr. Card Testerson',
//            'number' => '4030000010001234',
//            'expiry_month' => '07',
//            'expiry_year' => '22',
//            'cvd' => '123'
//        ),
//	    'billing' => array(
//	        'name' => 'Mr. John Doe',
//	        'email_address' => 'johndoe@email.com',
//	        'phone_number' => '1234567890'
//		)
//);

//Payment transaction data
$payment_data = array(
        'order_number' => $order_number,
        'amount' => $amount,
        'payment_method' => 'card',
        'card' => array(
            'name' => $ccName,
            'number' => $ccNumber,
            'expiry_month' => $ccMonth,
            'expiry_year' => $ccYear,
            'cvd' => $ccCvv
        ),
	    'billing' => array(
	        'name' => $name,
	        'email_address' => $email,
			'phone_number' => $phoneNumber,
		),
);

//REQUEST EXAMPLE FUNCTIONS BELOW
//UNCOMMENT THE ONES YOU WOULD LIKE TO TEST 

if (strlen($error) > 1) {
	echo '<div style="font-family: sans-serif; padding: 30px; font-size: 18px;">
					<h1>Oops Something Has Gone Wrong!</h1>
					<p style="font-weight: bold;">Reason: ' . $error .
					 '</p><p>Please review your inforamtion and try again.</p>
					<button style="text-decoration: none; text-transform: uppercase; border: 2px solid rgb(84, 143, 224); padding: 10px 25px; margin-top: 15px; display: block; max-width: 250px; text-align: center; color: rgb(84, 143, 224); cursor: pointer; background-color: rgb(255, 255, 255); font-family: sans-serif; font-size: 16px; line-height: 1;" onclick="history.go(-1);">Back </button>
			</div>';	
}
else {
	try {
		
		//**** PAYMENTS EXAMPLES
		
		//make a credit card payment
		$result = $beanstream->payments()->makeCardPayment($payment_data, $complete);
		
		//display result
		//is_null($result)?:print_r($result);
		 
		 $message ='<div style="font-family: sans-serif; padding: 30px; font-size: 18px;">
					<h1>Saskatchewan Mutual Insurance Company</h1>
					<p>279 3rd Ave. North, Saskatoon, SK. S7K 2H8<br>
						Phone: <a href="tel:3066534232">(306) 653-4232</a> <br>
						Email: <a href="mailto:accounting@saskmutual.com">accounting@saskmutual.com</a> <br>
						Website: <a href="http://www.saskmutual.com/" target="_blank">www.saskmutual.com</a> </p>
					<p style="font-weight: bold;">Your payment of $'. $amount .' has been processed for policy # '. $result['order_number'] .'.</p>
					<p> Authorization Code: '. $result['auth_code'] .'<br>
						Transaction Number: '. $result['id'] .' <br>
						Cardholder: '. $ccName .'<br>
						'. $result['card']['card_type'] .' #******'. $result['card']['last_four'] .' </p>
					<p>If you have any questions, please contact your broker.</p>
					<p>Please do not reply to this email.  This mailbox is not monitored and you will not receive a response.</p>
					<p style="font-weight: bold;">Print this invoice for your records.</p>
					<a href="http://www.saskmutual.com/" style="text-decoration: none; text-transform: uppercase; border: 2px solid rgb(84, 143, 224); padding: 10px 25px; margin-top: 15px; display: block; max-width: 250px; text-align: center; color: rgb(84, 143, 224); cursor: pointer;">Back To Saskatchewan Mutual Website</a>
				</div>
				';
				
		echo $message;		
				
		#set the charset and content type!
		iconv_set_encoding("internal_encoding", "UTF-8");
		iconv_set_encoding("output_encoding", "UTF-8");
		iconv_set_encoding("input_encoding", "UTF-8");
		
		$to = $email;
		$subject = "Saskatchewan Mutual Insurance - Receipt - Policy: " . $order_number;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: Saskatchewan Mutual Insurance<accounting@saskmutual.com>\r\n";
		$headers .= "Reply-To: accounting@saskmutual.com";
		
		#mail to the admins of the CMS
		mail($to, $subject, $message, $headers);
	
	
	} catch (\Beanstream\Exception $e) {
		/*
		 * Handle transaction error, $e->code can be checked for a
		 * specific error, e.g. 211 corresponds to transaction being
		 * DECLINED, 314 - to missing or invalid payment information
		 * etc.
		 */
		 
		 #print_r($e); 
		 #echo $e->getCode();
		 
		 echo '<div style="font-family: sans-serif; padding: 30px; font-size: 18px;">
					<h1>Oops Something Has Gone Wrong!</h1>
					<p style="font-weight: bold;">Reason: ' . $e->getMessage() .
					 '</p><p>Please review your inforamtion and try again.</p>
					<button style="text-decoration: none; text-transform: uppercase; border: 2px solid rgb(84, 143, 224); padding: 10px 25px; margin-top: 15px; display: block; max-width: 250px; text-align: center; color: rgb(84, 143, 224); cursor: pointer; background-color: rgb(255, 255, 255); font-family: sans-serif; font-size: 16px; line-height: 1;" onclick="history.go(-1);">Back </button>
				</div>';
		 
	}
}

function test_input($data) {
  $data = trim($data);
  $data = htmlspecialchars($data);
  return $data;
}
