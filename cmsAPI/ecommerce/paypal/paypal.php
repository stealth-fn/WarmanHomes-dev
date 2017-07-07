<?php	
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');

	class paypal extends common{	
		public $moduleTable = "paypal_settings";

		public function getOrderItemNVP(){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/products/products.php');
			$productsObj = new products(false);

			#prepare our item sting
			$itemParams = "";
			$itemCnt = 0;
			if(isset($_SESSION["cartProductIDs"]) && count($_SESSION["cartProductIDs"]) > 0){

				foreach($_SESSION["cartProductIDs"] as $key => $value){
					foreach($value as $loc => $cartProd){

						$prodID = $_SESSION["cartProductIDs"][$key][$loc]["productID"];
						$prodQty = $_SESSION["cartProductIDs"][$key][$loc]["qty"];
	
						$productInfo = $productsObj->getRecordByID($prodID);
						$pi = mysqli_fetch_array($productInfo);
	
						#127 character limit for paypal
						$itemParams .= 
	
						"&L_NAME" . $itemCnt . "=" . urlencode(substr($pi["productName"],0,126)) .
						"&L_DESC" . $itemCnt . "=" . urlencode(substr($pi["productName"],0,126)) .	
						"&L_QTY" . $itemCnt . "=" . urlencode($prodQty) .	
						"&L_PAYMENTREQUEST_" . $itemCnt . "_NUMBERm=" . urlencode($prodID) .
						"&L_AMT" . $itemCnt . "=" . urlencode(substr($productsObj->getUserProductPrice($pi["priKeyID"]),0,126));
	
						$itemCnt++;

						#loop through chosen options for this product
						if(isset($_SESSION["cartProductIDs"]["product$prodID"][$loc]["options"])){
	
							foreach($_SESSION["cartProductIDs"]["product$prodID"][$loc]["options"] as $key2 => $value2){
		
								$prodOpID = $_SESSION["cartProductIDs"]["product$prodID"][$loc]["options"][$key2]["optionID"];
	
								#multiply qty of option by parent product qty
								$prodOpQty = $_SESSION["cartProductIDs"]["product$prodID"][$loc]["options"][$key2]["qty"] * $prodQty;
	
								#paypal has a limit on how many price/qty's  
								#it can take so don't send empty ones
								if($prodOpQty > 0){
									$productOpInfo = $productsObj->getRecordByID($prodOpID);
									$poi = mysqli_fetch_assoc($productOpInfo);

									#127 character limit for paypal
									#we need a way to identify which item the product is  
									#for, so we append the parent item name here as well
	
									#in the future we will need a better way 
									#to determine what option goes with what product

									$itemParams .= 
									"&L_NAME" . $itemCnt . "=" . 
									urlencode(substr($pi["productName"],0,63)) . "_" . urlencode(substr($poi["productName"],0,63)) .
									"&L_DESC" . $itemCnt . "=" . 
									urlencode(substr($pi["productName"],0,63)) . "_" . urlencode(substr($poi["productName"],0,63)) .
									"&L_QTY" . $itemCnt . "=" . 
									urlencode($prodOpQty) . 
									"&L_PAYMENTREQUEST_" . $itemCnt . "_NUMBERm=" . 
									urlencode($prodOpID) . 
									"&L_AMT" . $itemCnt . "=" . 
									urlencode(substr($productsObj->getUserProductPrice($poi["priKeyID"]),0,126));
	
									$itemCnt++;
								}
							}
						}
					}
				}
			}
			return $itemParams;
		}

		public function getShippingInfoNVP(){			

			#shipping info string
			return 

			"&SHIPTONAME=" . urlencode($_SESSION["shippingInfo"]["firstName"]) . " " . urlencode($_SESSION["shippingInfo"]["lastName"]) .
			"&SHIPTOSTREET=" . urlencode($_SESSION["shippingInfo"]["address"]) .
			"&SHIPTOCITY=" . urlencode($_SESSION["shippingInfo"]["city"]) .
			"&SHIPTOSTATE=" . urlencode($_SESSION["shippingInfo"]["provStateCode"]) .
			"&SHIPTOZIP=" . urlencode($_SESSION["shippingInfo"]["postal_code"]) .
			"&SHIPTOCOUNTRY=" . urlencode($_SESSION["shippingInfo"]["countryCode"]);

		}

		

		#ajax call from to proceed to checkout
		public function expressCheckout($shipAmount,$shippingName){
			$token = $this->setExpressCheckout($shipAmount,$shippingName);
		}

		#called from expressCheckout
		public function setExpressCheckout($shipAmount,$shippingName){
			if(!isset($_SESSION)) session_start();

			include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/cmsCart/cmsCart.php');
			$cmsCartObj = new cmsCart(false);

			#item amount
			$itemTotal = $cmsCartObj->getCartProductTotal();

			#tax amount
			$taxTotal = $cmsCartObj->getCartTaxTotal();

			#item, taxes and shipping
			$_SESSION["shipAmount"] = urlencode($shipAmount);
			$_SESSION["shipName"] = urlencode($shippingName);
			$orderTotal = $cmsCartObj->getCartTotal() + $shipAmount;

			$pps = $this->getPayPalSettings();
			

			#prepare our main NVP string
			$paramString = "USER=" . urlencode($pps["sendUsr"]) .
			"&PWD=" . urlencode($pps["sendPw"]) .
			"&SIGNATURE=" . urlencode($pps["sendSig"]) .
			"&VERSION=" . urlencode($pps["VERSION"]) .
			"&METHOD=SetExpressCheckout" .
			"&AMT=" . $orderTotal .
			"&ITEMAMT=" . $itemTotal .
			"&SHIPPINGAMT=" . $_SESSION["shipAmount"] .
			"&TAXAMT=" . $taxTotal .
			"&CURRENCYCODE=" . urlencode($pps["currencyCode"]) .
			"&PAYMENTACTION=" . urlencode($pps["paymentAction"]) .
			"&ADDROVERRIDE=" . urlencode($pps["addrOverride"]) .
			"&NOSHIPPING=" . urlencode($pps["noShipping"]) .
			"&REQCONFIRMSHIPPING=" . urlencode($pps["REQCONFIRMSHIPPING"]) .
			"&ReturnURL=" . urlencode($pps["returnURL"]) .
			"&CancelURL=" . urlencode($pps["cancelURL"])
			;
			
			#full nvp string
			$paramString .= $this->getOrderItemNVP() . $this->getShippingInfoNVP();

			# create curl resource
			$ch = curl_init();

			# set url
			curl_setopt($ch, CURLOPT_URL, $pps["paypalURL"]);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$paramString);

			#return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			#setup HTTPS
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			
			#do a regular post
			curl_setopt ($ch, CURLOPT_POST, 1);

			#$output contains the output string
			$output = curl_exec($ch);
			$ppResponse = array();
			parse_str($output,$ppResponse);

			if($pps["isLive"] == 0) {
				echo "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=" . $ppResponse["TOKEN"] . "&useraction=" . $pps["userAction"];
			}else {
				echo "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=" . $ppResponse["TOKEN"] . "&useraction=" . $pps["userAction"];
			}
		}

		public function getExpressCheckoutDetails($token){

			if(!isset($_SESSION)) session_start();

			$pps = $this->getPayPalSettings();

			#prepare our main NVP string
			$paramString = "USER=" . urlencode($pps["sendUsr"]) .
			"&PWD=" . urlencode($pps["sendPw"]) .
			"&SIGNATURE=" . urlencode($pps["sendSig"]) .
			"&VERSION=" . urlencode($pps["VERSION"]) .
			"&TOKEN=" . urlencode($token) .
			"&METHOD=GetExpressCheckoutDetails"
			;
			
			# create curl resource
			$ch = curl_init();

			# set url
			curl_setopt($ch, CURLOPT_URL, $pps["paypalURL"]);

			curl_setopt($ch, CURLOPT_POSTFIELDS,$paramString);

			#return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			#setup HTTPS
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

			#do a regular post
			curl_setopt ($ch, CURLOPT_POST, 1);

			# $output contains the output string
			$output = curl_exec($ch);

			#put our results into an associative array
			$returnArray = explode( '&', $output );
			$resultArray = array();

			foreach($returnArray as $value){

				$tempArray = explode( '=', $value );

				$resultArray[$tempArray[0]] = urldecode($tempArray[1]);

			}

			

			return $resultArray;

		}

		

		#called in /public/ecommerce/cmsCart/orderComplated.php

		public function doExpressCheckoutPayment($token){

			if(!isset($_SESSION)) session_start();

			

			$pps = $this->getPayPalSettings();

			

			$orderDetails = $this->getExpressCheckoutDetails($token);

			

			#prepare our main NVP string

			$paramString = "USER=" . urlencode($pps["sendUsr"]) .

			"&PWD=" . urlencode($pps["sendPw"]) .
			"&SIGNATURE=" . urlencode($pps["sendSig"]) .
			"&VERSION=" . urlencode($pps["VERSION"]) .
			"&TOKEN=" . urlencode($token) .
			"&CURRENCYCODE=" . urlencode($pps["currencyCode"]) .
			"&CUSTOM=" . "Shipping Method " . $_SESSION["shipName"] .
			"&AMT=" . urlencode($orderDetails["AMT"]) .
			"&ITEMAMT=" . urlencode($orderDetails["ITEMAMT"]) .
			"&SHIPPINGAMT=" . urlencode($orderDetails["SHIPPINGAMT"]) .
			"&TAXAMT=" . urlencode($orderDetails["TAXAMT"]) .
			"&PAYERID=" . urlencode($orderDetails["PAYERID"]) .
			"&PAYMENTACTION=SALE" .
			"&METHOD=DoExpressCheckoutPayment"
			;

			#full nvp string
			$paramString .= $this->getOrderItemNVP() . $this->getShippingInfoNVP();	

			# create curl resource
			$ch = curl_init();

			# set url
			curl_setopt($ch, CURLOPT_URL, $pps["paypalURL"]);

			curl_setopt($ch, CURLOPT_POSTFIELDS,$paramString);

			#return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			#setup HTTPS
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

			#do a regular post
			curl_setopt ($ch, CURLOPT_POST, 1);

			# $output contains the output string
			$output = curl_exec($ch);

			#put our results into an associative array
			$returnArray = explode( '&', $output );
			$resultArray = array();



			foreach($returnArray as $value){
				$tempArray = explode( '=', $value );
				$resultArray[$tempArray[0]] = urldecode($tempArray[1]);

			}
			
			return $resultArray;

		}

		

		public function addEditPayPalProduct(){
			$pps = $this->getPayPalSettings();
			
			#prepare our NVP string
			$paramString = "USER=" . urlencode($pps["sendUsr"]) .

			"&PWD=" . urlencode($pps["sendPw"]) .
			"&SIGNATURE=" . urlencode($pps["sendSig"]) .
			"&VERSION=" . urlencode($pps["VERSION"]) .
			"&METHOD=BMCreateButton" .
			"&BUTTONCODE=" . "HOSTED" .
			"&BUTTONTYPE=" . "CART" .
			"&BUTTONSUBTYPE=" . "PRODUCTS" .
			"&BUTTONIMAGE=" . "reg" .
			"&L_BUTTONVAR0=" . "amount=" . urlencode($_REQUEST["price"]) .
			"&L_BUTTONVAR1=" . "item_name=" . urlencode($_REQUEST["productName"]) .
			"&L_BUTTONVAR2=" . "currency_code=" . urlencode($pps["countryCurrency"]) .
			"&L_BUTTONVAR3=" . "no_shipping=" . urlencode("1") .
			"&L_BUTTONVAR3=" . "no_note=" . urlencode("1");

			# create curl resource
			$ch = curl_init();

			# set url
			curl_setopt($ch, CURLOPT_URL, $pps["paypalURL"]);

			curl_setopt($ch, CURLOPT_POSTFIELDS,$paramString);

			#return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			#setup HTTPS
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

			#do a regular post
			curl_setopt ($ch, CURLOPT_POST, 1);

			# $output contains the output string
			$output = curl_exec($ch);

			#put our results into an associative array
			$returnArray = explode( '&', $output );
			$resultArray = array();

			foreach($returnArray as $value){

				$tempArray = explode( '=', $value );

				$resultArray[$tempArray[0]] = $tempArray[1];

			}

			

			#update cms product table with paypal info

			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");

			$productsObj = new products(false);

			$productsObj->updateRecord(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$resultArray["WEBSITECODE"],$resultArray["EMAILLINK"],$resultArray["HOSTEDBUTTONID"]);

			

			# close curl resource to free up system resources

			curl_close($ch); 

			

		}

		

		private function getPayPalSettings(){

			$paypalSettingsObj = new paypal(false);

			$paypalSettings = $paypalSettingsObj->getRecordByID(1);

			$pps = mysqli_fetch_assoc($paypalSettings);

			

			#add another field to determine which URL we should actually be using 

			if($pps["isLive"]==1){

				$pps["paypalURL"] = $pps["liveURL"];

				$pps["sendUsr"] = $pps["USER"];

				$pps["sendPw"] = $pps["PWD"];

				$pps["sendSig"] = $pps["SIGNATURE"];

				$pps["apiDate"] = $pps["apiRequestDate"];

				$pps["cancelURL"] = $pps["cancelURLLive"];

				$pps["returnURL"] = $pps["returnURLLive"];

			}

			else if($pps["isLive"]==0){

				$pps["paypalURL"] = $pps["sandboxURL"];

				$pps["sendUsr"] = $pps["userSandBox"];

				$pps["sendPw"] = $pps["pwdSandBox"];

				$pps["sendSig"] = $pps["signatureSandBox"];

				$pps["apiDate"] = $pps["sandBoxApiRequestDate"];

				$pps["cancelURL"] = $pps["cancelURLSandBox"];

				$pps["returnURL"] = $pps["returnURLSandBox"];

			}

						

			return $pps;

		}

	}



	if(isset($_REQUEST["function"])){

		$moduleObj = new paypal(true);

		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');

	}	

?>