<?php
//get Beanstream Gateway
require_once $_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/beanstream/Gateway.php";

$merchant_id = '300203673'; //INSERT MERCHANT ID (must be a 9 digit string)
$api_key = '0274416dD5C84176809744B35e50c208'; //INSERT API ACCESS PASSCODE
$api_version = 'v1'; //default
$platform = 'www'; //default

//init new Beanstream Gateway object
$beanstream = new \Beanstream\Gateway($merchant_id, $api_key, $platform, $api_version);

$order_number = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));

foreach ($_POST as $paramName => $paramValue){
		
	#no need to send this parameter to the user
	if($paramName !== "scriptSend"){
		if ($paramName == 'order_number') {
			#$order_number = $paramValue;
		}
		elseif ($paramName == 'amount') {
			$amount = $paramValue;
		}
		elseif ($paramName == 'name') {
			$name = $paramValue;
		}
		elseif ($paramName == 'email') {
			$email = $paramValue;
		}
		elseif ($paramName == 'phoneNumber') {
			$phoneNumber = $paramValue;
			//Get only the numbers entered in the phone number
			$phoneNumber =  preg_replace("/[^0-9,.]/", "", $phoneNumber);
		}
		elseif ($paramName == 'ccName') {
			$ccName = $paramValue;
		}
		elseif ($paramName == 'ccNumber') {
			$ccNumber = $paramValue;
		}
		elseif ($paramName == 'ccMonth') {
			$ccMonth = $paramValue;
		}
		elseif ($paramName == 'ccYear') {
			$ccYear = $paramValue;
			//Get the last 2 digits of the year
			$ccYear = substr($ccYear, -2);
		}
		elseif ($paramName == 'ccCvv') {
			$ccCvv = $paramValue;
		}
	}
}

//example payment transaction data
//$payment_data = array(
//        'order_number' => 'abcdefghi12jk',
//        'amount' => $amount,
//        'payment_method' => 'card',
//        'card' => array(
//            'name' => $ccName,
//            'number' => $ccNumber,
//            'expiry_month' => $ccMonth,
//            'expiry_year' => $ccYear,
//            'cvd' => $ccCvv
//        ),
//	    'billing' => array(
//	        'name' => $name,
//	        'email_address' => $email
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

try {
	
	//**** PAYMENTS EXAMPLES
	
	//make a credit card payment
	$result = $beanstream->payments()->makeCardPayment($payment_data, $complete);
	
	$transaction_id = $result['id'];
	$transaction_card_type = $result['card']['card_type'];
	
	//display result
	//is_null($result)?:print_r($result);
	
	//echo $transaction_id;
	
	echo '' . $result['message'] .
	 '<br/>Please wait, you will be taken to your receipt momentarily.';


} catch (\Beanstream\Exception $e) {
    /*
     * Handle transaction error, $e->code can be checked for a
     * specific error, e.g. 211 corresponds to transaction being
     * DECLINED, 314 - to missing or invalid payment information
     * etc.
     */
	 
     #print_r($e); 
	 #echo $e->getCode();
	 
	 echo 'Your transaction has been: ' . $e->getMessage() .
	 '<br/>Please review your inforamtion and try again.';
	 
}
