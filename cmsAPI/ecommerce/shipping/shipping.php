<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	class shipping extends common{
		
		public function getShippingOptions(
			$firstName, 
			$lastName, 
			$streetNum, 
			$streetName,
			$address2,
			$city, 
			$provstate, 
			$provStateID, 
			$country, 
			$countryID, 
			$countryCode, 
			$postal_code,
			$primaryPhone
		){
			if(!isset($_SESSION)) session_start();
			
			#canada post & paypal uses 1 string for the address 
			$address = $streetNum . " " . $streetName . " " . $address2;
			
			#get province code
			include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/provState.php');
			$provStateObj = new provState(false);
			$provStateCode = $provStateObj->getConditionalRecord(array("provState",$provstate,true));
			$psCode = mysqli_fetch_assoc($provStateCode);
						
			#need shipping info for paypal
			$_SESSION["shippingInfo"] = array();
			$_SESSION["shippingInfo"]["firstName"] = $firstName;
			$_SESSION["shippingInfo"]["lastName"] = $lastName;
			$_SESSION["shippingInfo"]["address"] = $address;
			$_SESSION["shippingInfo"]["city"] = $city;
			$_SESSION["shippingInfo"]["provstate"] = $provstate;
			$_SESSION["shippingInfo"]["provStateID"] = $provStateID;
			$_SESSION["shippingInfo"]["primaryPhone"] = $primaryPhone;
			
			/*for international shipping there is no province or state code
			but paypal wants a value, so just pass the name of the region*/
			if(strlen($psCode["provStateCode"])>0){
				$_SESSION["shippingInfo"]["provStateCode"] = $psCode["provStateCode"];
			}
			else{
				$_SESSION["shippingInfo"]["provStateCode"] = $provstate;
			}
			
			$_SESSION["shippingInfo"]["country"] = $country;
			$_SESSION["shippingInfo"]["countryCode"] = $countryCode;
			$_SESSION["shippingInfo"]["countryID"] = $countryID;
			$_SESSION["shippingInfo"]["postal_code"] = $postal_code;
					
			#need to determine taxes for this shipping location
			#we use $_SESSION["salesTaxIDList"] in cmsCart.php getCartTaxTotal()
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/taxes/locationTaxMap.php");
			$locationTaxMapObj = new locationTaxMap(false);
			
			#if the id's are 0's it returns the records... not sure why... - jared
			$provTaxes = $locationTaxMapObj->getConditionalRecord(
				array("provStateID",$provStateID,true,"provStateID",0,false)
			 );
			
			$federalTaxes = $locationTaxMapObj->getConditionalRecord(
				array("countryID",$countryID,true,"countryID",0,false)
			);
			
			$taxIDList = $locationTaxMapObj->getQueryValueString($provTaxes,"taxID",",");		
			/* added check for federal taxes, was adding comma with null value to us addresses */ 
			if(strlen($taxIDList) > 0){
				if(strlen($locationTaxMapObj->getQueryValueString($federalTaxes,"taxID",",")) > 0){
					$taxIDList .= "," . $locationTaxMapObj->getQueryValueString($federalTaxes,"taxID",",");
				}
			}
			else{
				$taxIDList = $locationTaxMapObj->getQueryValueString($federalTaxes,"taxID",",");
			}
			
			$_SESSION["salesTaxIDList"] = $taxIDList;
			
			#use the product settings to determine what shipping companies are usable
			include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/products/products.php');
			$productsObj = new products(false);
			
			#if is Flat Rate Shipping Price
			if($productsObj->isFlatRate) {
				$flatRateShippingTotal = 0;
				$flatRateShippingNotAvailable = false;
			}
			else {
				#canada post
				if($productsObj->isCanadaPost){
					include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/canship/includes/canadapost.php');
					$canadaPostObj = new CanadaPost(false);
				}
				#purolator
				if($productsObj->isPurolator){
					include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/shipping/purolator/purolator.php');
					$purolatorObj = new purolator(false);
					$client = $purolatorObj->createPWSSOAPClient();

					#create empty object to build up and pass to purolator
					$request = new stdClass();
					$request->Shipment = new stdClass();
					$request->Shipment->PackageInformation = new stdClass();
					$request->Shipment->PackageInformation->TotalWeight = new stdClass();
					$request->ReceiverAddress = new stdClass();
					$request->TotalWeight = new stdClass();

					$request->Shipment->PackageInformation->TotalWeight->WeightUnit = "kg";
					$request->Shipment->PackageInformation->TotalWeight->Value = 0;
					$request->Shipment->PackageInformation->TotalPieces = 10;
					$request->ShowAlternativeServicesIndicator = "false";
				}
			}
			
			#add items to our shipping data
			if(count($_SESSION["cartProductIDs"]) > 0){
				foreach($_SESSION["cartProductIDs"] as $key => $value){					
					foreach($value as $loc => $cartProd){
						
						$prodID = $_SESSION["cartProductIDs"][$key][$loc]["productID"];
						$prodQty = $_SESSION["cartProductIDs"][$key][$loc]["qty"];
						$productInfo = $productsObj->getRecordByID($prodID);

						$pi = mysqli_fetch_assoc($productInfo);
						if($productsObj->isPurolator && $productsObj->isFlatRate != 1){
							$request->Shipment->PackageInformation->TotalPieces++;
						}
						#canada post needs dimensions, weight and desc
						if($productsObj->isCanadaPost && $productsObj->isFlatRate != 1){
							$canadaPostObj->addItem(
								$prodQty, 
								$pi["prodWeight"], 
								$pi["prodLen"], 
								$pi["prodWidth"], 
								$pi["prodHeight"],
								$pi["productName"] 
							);
						}
					}
					#if is Flat Rate Shipping Price
					if($productsObj->isFlatRate) {
						
						include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/flatRateShipping/flatRateShipping.php");
						include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/flatRateShipping/flat_rate_postal_map.php");
						include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/flatRateShipping/flat_rate_product_map.php");
						include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/postalCode/postalCode.php");
						
						$flatRateObj = new flatRateShipping(false, NULL);
						$flatRatePostalMapObj = new flatRatePostalMap(false, NULL);		
						$flatRateProdMapObj = new flatRateProdMap(false, NULL);	
						$postalCodeObj = new postalCode(false, NULL);
							
						$flatRate = $flatRateObj->getAllRecords();
						$postalCode = $postalCodeObj->getAllRecords();
						
						$flatRateID = 'NULL';
						$flatRatePrice = 'NULL';
						#If there are flat rates
						if(mysqli_num_rows($flatRate) > 0){
							#loop though all of the flat rates
							while($x = mysqli_fetch_array($flatRate)){
								
								$postalID = "NULL";
								#get the users postal code and make it all caps
								$userPostal = strtoupper($_SESSION["shippingInfo"]["postal_code"]);
								#strip the users postal code of all spaces
								$userPostal = str_replace(' ', '', $userPostal);
								
								#If there are postal codes
								if(mysqli_num_rows($postalCode) > 0){	
									#See if there is a flat rate for the postal code passed by the user
									$postal = $postalCodeObj->getConditionalRecord(
										array("postalCode",$userPostal,true)
									);
									#if there is a record then save the PostalCodeID
									if ($postal->num_rows > 0){
										$p = mysqli_fetch_assoc($postal);
										$postalID = $p["priKeyID"];
									}		
								}
								#find the flat rate using the postalID gotten above
								$flatRatePostMap = $flatRatePostalMapObj->getConditionalRecord(
									array(
										"postalID",$postalID,true,
										"flatRateID",$x["priKeyID"],true
									)
								);
								
								#If we found a postal ID for this product and this postal code
								#Add the flat rate to the shipping total
								if ($flatRatePostMap->num_rows > 0){
									$flatRateID = $x["priKeyID"];
									$flatRatePrice = $x["price"];
								}	
							}
							#Now that we have the flatRateID asssociated with this postalcode
							#see if this product is mapped to this flatRate
							$flatRateProdtMap = $flatRateProdMapObj->getConditionalRecord(
								array(
									"productID",$prodID,true,
									"flatRateID",$flatRateID,true
								)
							);
							#if it is add the price
							if ($flatRateProdtMap->num_rows > 0){
								$flatRateShippingTotal += $flatRatePrice;
							}
							#if it is not do not allow
							else{
								$flatRateShippingNotAvailable = true;
							}	
						}	
					}
					#purolator only needs the weight, no dimensions
					if($productsObj->isPurolator && $productsObj->isFlatRate != 1){
						#$request->Shipment->PackageInformation->TotalWeight->Value += $pi["prodWeight"] * $prodQty;
						#if it doesn't have a weight assigned, use default weight
						if($pi["prodWeight"]==0){
							$request->Shipment->PackageInformation->TotalWeight->Value += $purolatorObj->defaultItemWeight * $prodQty;
						}
						else{
							$request->Shipment->PackageInformation->TotalWeight->Value += $pi["prodWeight"] * $prodQty;
						}
					}

					if(isset($_SESSION["cartProductIDs"]["product$prodID"])){
						#for each product option set in the cart
						foreach($_SESSION["cartProductIDs"]["product$prodID"] as $key2 => $prodLocation){
							#loop through chosen options for this product	
							if(isset($prodLocation["options"])){
								
								foreach($prodLocation["options"] as $key3 => $prodOption){
									$prodOpID = $prodOption["optionID"];
									$prodOpQty = $prodOption["qty"];
									
									if($prodOpQty > 0 && $productsObj->isFlatRate != 1){
										if($productsObj->isPurolator){
											$request->Shipment->PackageInformation->TotalPieces++;
										}
										$productOpInfo = $productsObj->getRecordByID($prodOpID);
										$poi = mysqli_fetch_assoc($productOpInfo);
										//var_dump($poi);
										#only add products/optoins with dimensions and weight
										if(
											strlen($poi["prodWeight"])!==0 && $poi["prodWeight"] != 0 ||
											strlen($poi["prodLen"])!==0 && $poi["prodLen"] != 0 ||
											strlen($poi["prodWidth"])!==0 && $poi["prodWidth"] != 0 &&
											strlen($poi["prodHeight"])!==0 && $poi["prodHeight"] != 0
										){
																			
											#canada post needs dimensions, weight and desc
											if($productsObj->isCanadaPost){
												$canadaPostObj->addItem($prodOpQty, 
													$poi["prodWeight"], 
													$poi["prodLen"], 
													$poi["prodWidth"], 
													$poi["prodHeight"],
													$poi["productName"] 
												);
											}
											#purolator only needs the weight
											if($productsObj->isPurolator){
												#if it doesn't have a weight assigned, use default weight
												if($poi["prodWeight"]==0){
													$request->Shipment->PackageInformation->TotalWeight->Value += $purolatorObj->defaultItemWeight * $prodOpQty;
												}
												else{
													$request->Shipment->PackageInformation->TotalWeight->Value += $poi["prodWeight"] * $prodOpQty;
												}
											}
										}#checking weights and dimensions
									}#if there's a quantity
								}#options loop
							}#if optoins exist for this product
						}#product loop
					}#if there are cart products
				}#cart loop
			}#if there's a cart

			if($productsObj->isCanadaPost && $productsObj->isFlatRate != 1){
				$canadaPostOptions = $canadaPostObj->getQuote($city, $provstate, $country, $postal_code);
			}
			
			#weight must be a whole number, apparently in purolator this shouldn't change the price by much
			#http://www.purolatorwebservices.com/viewtopic.php?f=29&t=46
			if($productsObj->isPurolator && $productsObj->isFlatRate != 1){
				$request->Shipment->PackageInformation->TotalWeight->Value = ceil($request->Shipment->PackageInformation->TotalWeight->Value);
			}
			
			if($productsObj->isPurolator && $productsObj->isFlatRate != 1){
				
				if($purolatorObj->GetFullEstimate){
					$request->Shipment->SenderInformation->Address->Name = $purolatorObj->senderName;
					$request->Shipment->SenderInformation->Address->StreetNumber = $purolatorObj->senderStreetNumber;
					$request->Shipment->SenderInformation->Address->StreetName = $purolatorObj->StreetName;
					$request->Shipment->SenderInformation->Address->City = $purolatorObj->senderCity;
					$request->Shipment->SenderInformation->Address->Province = $purolatorObj->senderProvState;
					$request->Shipment->SenderInformation->Address->Country = $purolatorObj->senderCounty;
					$request->Shipment->SenderInformation->Address->PostalCode = $purolatorObj->senderPostalZip;    
					$request->Shipment->SenderInformation->Address->PhoneNumber->Phone = $purolatorObj->senderPhoneNumber;
	
					$request->Shipment->ReceiverInformation->Address->Name = $firstName . " " . $lastName;
					$request->Shipment->ReceiverInformation->Address->StreetNumber = $streetNum;
					$request->Shipment->ReceiverInformation->Address->StreetName = $streetName;
					$request->Shipment->ReceiverInformation->Address->StreetAddress2 = $address2;
					$request->Shipment->ReceiverInformation->Address->City = $city;
					$request->Shipment->ReceiverInformation->Address->Province = $_SESSION["shippingInfo"]["provStateCode"];
					$request->Shipment->ReceiverInformation->Address->Country = $countryCode;
					$request->Shipment->ReceiverInformation->Address->PostalCode = $postal_code;    
					$request->Shipment->ReceiverInformation->Address->PhoneNumber->Phone = $primaryPhone;
										
					$purlatorOptions = $client->GetFullEstimate($request);
				}
				else{
					$request->BillingAccountNumber = $purolatorObj->billingAccount;
					$request->SenderPostalCode = $purolatorObj->senderPostalZip;
					$request->ReceiverAddress->City = $city;
					$request->ReceiverAddress->Country = $countryCode;
					
					/*if it's outside of canada/US don't inclue province and 
					postal code and it will trigger international shipping*/
					if($countryCode == "CA" || $countryCode == "US"){
						$request->ReceiverAddress->Province =  $_SESSION["shippingInfo"]["provStateCode"];
						$request->ReceiverAddress->PostalCode = $postal_code; 
					}
					 
					$request->PackageType = "CustomerPackaging";
					$request->TotalWeight->Value = $request->Shipment->PackageInformation->TotalWeight->Value;
					$request->TotalWeight->WeightUnit = "kg";
					$purlatorOptions = $client->GetQuickEstimate($request);
				}
			}
							
			#determine what taxes to apply to shipping
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/taxes/taxes.php");
			$taxesObj = new taxes(false);
			$shipTaxes = $taxesObj->getConditionalRecordFromList(
				array("priKeyID",$taxIDList,true,"shipTax","1",true)
			 );
			
			$taxPercentSum = 0;
			

			if(mysqli_num_rows($shipTaxes) > 0)

				while($x = mysqli_fetch_assoc($shipTaxes))$taxPercentSum += $x["taxAmount"];

			
			$x = 1;
			
			$shipHTML = '<div id="shippingInfoContainer">
				<form name="shippingOptions" id="shippingOptions" action="">';
				
			#build DOM for Flat Rate
			if($productsObj->isFlatRate) {
				if($flatRateShippingNotAvailable) {
					$shipHTML .= '<h2>The item(s) in your cart are not available in your region. An administrator has been contacted and will email you with shipping information within 1-2 business days.</h2>';
					
					$message = '<table><tbody>';
					$message .= '<tr><td>Name:</td><td>'. $firstName .' ' . $lastName . '</td></tr>';
					$message .= '<tr><td>Address:</td><td>'. $streetNum .' ' . $streetName . ' ' . $city . ' ' . $_SESSION["shippingInfo"]["provStateCode"] . ' ' . $countryCode . ' ' . $postal_code . '</td></tr>';
					$message .= '<tr><td>Phone Number:</td><td>'. $primaryPhone  .'</td></tr>';
					$message .= '<tr><td></td><td></td></tr>';
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
					$productsObj = new products(false, NULL);

					#loop through the cart
					foreach($_SESSION["cartProductIDs"] as $key => $value){

						foreach($value as $loc => $cartProd) {
								$prodQty = $_SESSION["cartProductIDs"][$key][$loc]["qty"];
								#get product info
								$prodID = $_SESSION["cartProductIDs"][$key][$loc]["productID"];
								$productInfo = $productsObj->getRecordById($prodID);
								$p = mysqli_fetch_assoc($productInfo);
							
								$message .= '<tr><td><strong>Product</strong></td><td>' .$p["productName"].'</td></tr>';
								$message .= '<tr><td>Quantity</td><td>' .$prodQty.'</td></tr>';
								
							
								$locOp = $_SESSION["cartProductIDs"]["product$prodID"][$loc];
							
								if(isset($locOp["options"])){
									$message .= '<tr><td><strong>Options</strong></td><td></td></tr>';
									
									foreach($locOp["options"] as $key2 => $value2){
										$productOpInfo = $productsObj->getRecordById($locOp["options"][$key2]["optionID"]);
										$op = mysqli_fetch_assoc($productOpInfo);
										
										$message .= '<tr><td>Product</td><td>' .$op["productName"].'</td></tr>';
										$message .= '<tr><td>Quantity</td><td>' .$locOp["options"][$key2]["qty"].'</td></tr>';

									}
								}
							$message .= '<tr><td></td><td></td></tr>';
						}
					}
					
					$message .= '</table></tbody>';
					
					$to = $_SESSION["adminEmail"];
					$subject = 'Attempted Purchase - Flat Rate Not Setup';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					$headers .= "From: " . $_SESSION["siteName"] . "<" . $_SESSION["adminEmail"] . ">\r\n";
					$headers .= "Reply-To: " . $replyEmail;

					#Send an email to the person that is contacting us to let them know we got it.
					mail($to, $subject, $message, $headers);
					
				}
				else {
					$shipHTML .= '<div id="shippingCompany' . $x . '" class="shippingCompany">Flat Rate Shipping Fee</div>
					<div class="shippingInfoHeader">
						<div class="shippingMethods">Shipping Methods</div>
						<div class="shippingRate">Rate (CAD $)</div>
					</div>';
					
					if($productsObj->flatRateTax){
						#Apply tax to the shipping rate
						if($taxPercentSum != 0) {
							$tempVal = number_format(round($flatRateShippingTotal + ($flatRateShippingTotal*($taxPercentSum/100)),2),2);
						}
						else {
							$tempVal = number_format(round($flatRateShippingTotal,2),2);
						}
					}
					else{
						$tempVal = $flatRateShippingTotal;
					}
						
						$shipHTML .= '<div id="methodName' . $x . '" class="shippingMethods shippingLi">Flat Rate</div>';
						$shipHTML .= '<div id="methodRate' . $x . '" class="shippingRate shippingLi">$' . number_format($tempVal,2)  .'</div>';

						$shipHTML .= '<div id="methodCheck' . $x . '" class="methodCheck shippingLi">'  
										. '<input 
												class="methodCheckBox"
												type="radio" 
												name="methodCheckBox" 
												id="methodCheckBox' . $x . '" value="' . $tempVal . '"
												onclick="updateCartTotalWithShipping(\'' . $tempVal . '\')"
											/>'
									. '</div>';


				}
			}
			#build DOM for canadapost options
			if($productsObj->isCanadaPost && $productsObj->isFlatRate != 1){
				$shipHTML .= '<div id="shippingCompany' . $x . '" class="shippingCompany">Canada Post</div>
				<div class="shippingInfoHeader">
					<div class="shippingMethods">Shipping Methods</div>
					<div class="shippingDelDate">Shipping Delivery Date</div>

					<div class="shippingRate">Rate (CAD $)</div>

				</div>';
				foreach($canadaPostOptions as $info){
					#taxes aren't applied to the handling fee, only the shipping rate
					if($taxPercentSum != 0)
						$tempVal = number_format(round($info["rate"] + ($info["rate"]*($taxPercentSum/100)),2),2);
					else $tempVal = number_format(round($info["rate"],2),2);
					
					#add handling fee
					$tempVal += $canadaPostObj->handlingFee;
					
					$shipHTML .= '<div id="methodName' . $x . '" class="shippingMethods shippingLi">' . $info["name"] .'</div>';
					$shipHTML .= '<div id="methodDelivery' . $x . '" class="shippingDelDate shippingLi">' . $info["deliveryDate"] .'</div>';

					$shipHTML .= '<div id="methodRate' . $x . '" class="shippingRate shippingLi">$' . number_format($tempVal,2)  .'</div>';

					$shipHTML .= '<div id="methodCheck' . $x . '" class="methodCheck shippingLi">'  
									. '<input 
											class="methodCheckBox"
											type="radio" 
											name="methodCheckBox" 
											id="methodCheckBox' . $x . '" value="' . number_format($tempVal,2) . '"
											onclick="updateCartTotalWithShipping(\'' . number_format($tempVal,2) . '\')"
										/>'
								. '</div>';
					$x++;
				}
			}
			#build DOM for purolator optoins
			if($productsObj->isPurolator && $productsObj->isFlatRate != 1){
				
				#domestic shipping
				if(is_array($purlatorOptions->ShipmentEstimates->ShipmentEstimate)){
					$tempShipLabel = "Shipping Delivery Date";
				}
				#international shipping
				elseif(is_object($purlatorOptions->ShipmentEstimates->ShipmentEstimate)){
					$tempShipLabel = "Shipment Date";
				}
				else{
				}

				$shipHTML .= '<div id="shippingCompany' . $x . '" class="shippingCompany shippingLi">Purolator</div>
				<div class="shippingInfoHeader">

					<div class="shippingMethods">Shipping Methods</div>
					<div class="shippingDelDate">' . $tempShipLabel . '</div>
					<div class="shippingRate">Rate (CAD $)</div>
				</div>';

				#domestic shipping
				if(is_array($purlatorOptions->ShipmentEstimates->ShipmentEstimate)){
					foreach($purlatorOptions->ShipmentEstimates->ShipmentEstimate as $estimate){						 
						$shipHTML .= '<div id="methodName' . $x . '" class="shippingMethods shippingLi">' . $estimate->ServiceID . '</div>';
						$shipHTML .= '<div id="methodDelivery' . $x . '" class="shippingDelDate shippingLi">' . $estimate->ExpectedDeliveryDate . '</div>';
						$shipHTML .= '<div id="methodRate' . $x . '" class="shippingRate shippingLi">$' . $estimate->TotalPrice . '</div>';
						$shipHTML .= '<div id="methodCheck' . $x . '" class="methodCheck shippingLi">'  
										. '<input 
												class="methodCheckBox"
												type="radio" 
												name="methodCheckBox" 
												id="methodCheckBox' . $x . '" value="' . $estimate->TotalPrice . '"
												onclick="updateCartTotalWithShipping(\'' . $estimate->TotalPrice . '\')"
											/>'
									. '</div>';
									
						$x++;
					}
				}
				#international shipping
				elseif(is_object($purlatorOptions->ShipmentEstimates->ShipmentEstimate)){
					$estimate = $purlatorOptions->ShipmentEstimates->ShipmentEstimate;
					$shipHTML .= '<div id="methodName' . $x . '" class="shippingMethods shippingLi">' . $estimate->ServiceID . '</div>';
					$shipHTML .= '<div id="methodDelivery' . $x . '" class="shippingDelDate shippingLi">' . $estimate->ShipmentDate . '</div>';
					$shipHTML .= '<div id="methodRate' . $x . '" class="shippingRate shippingLi">$' . $estimate->TotalPrice . '</div>';
					$shipHTML .= '<div id="methodCheck' . $x . '" class="methodCheck shippingLi">'  
									. '<input 
											class="Shipping Method"
											type="radio" 
											name="methodCheckBox" 
											id="methodCheckBox' . $x . '" value="' . $estimate->TotalPrice . '"
											onclick="updateCartTotalWithShipping(\'' . $estimate->TotalPrice . '\')"
										/>'
								. '</div>';
								
					$x++;
				}
				#order is too heavy
				elseif(is_object($purlatorOptions->ResponseInformation->Errors)
					&& $purlatorOptions->ResponseInformation->Errors->Error->Code == "1100514"){
						
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
					$productObj = new products(false);
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productGalleryMap.php");
					$productGalleryMapObj = new productGalleryMap(false);
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productFeatures/productFeatures.php");
					$productFeatureObj = new productFeature(false);
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/productOptionCategory.php");
					$productOptionCategoryObj = new productOptionCategory(false);
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/productOptionCategoryMap.php");
					$prodOpCatMap = new productOptionCategoryMap(false);
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/optionCategoryProductMap.php");
					$optionCategoryProductMapObj = new optionCategoryProductMap(false);
					
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/productOptions/productOptionCategoryMap.php");
					$productOptionCategoryMapObj = new productOptionCategoryMap(false);
					
					include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/cmsCart/cmsCart.php');
					$cmsCartObj = new cmsCart(false);
					
					#If user has added at lesat one product to the Cart, it is shown
					if (isset($_SESSION["cartProductIDs"]) && count($_SESSION["cartProductIDs"])) {
						$prodQueryArray = array();
						#loop through the cart products
						foreach($_SESSION["cartProductIDs"] as $key => $value){
					
						#loop through each product/option configuration in the cart
						foreach($value as $loc => $cartProd){
							array_push(
								$prodQueryArray,
								$productObj->getConditionalRecord(
									array("products.priKeyID",$cartProd["productID"],true),
									array(),true
								)
							);
							//echo $cartProd["productID"]. " ". $prodQueryArray;
						}
					}
					//var_dump($prodQueryArray);
					
					$productQuery = $productObj->getCheckQuery(
						implode(" UNION ALL ", $prodQueryArray)
					);

					$message = '';
					$message .= '<div>Name: '. $firstName. ' ';
					$message .= $lastName. '</div>';
					$message .= '<div>Address: '. $address. '</div>';
					$message .= '<div>City: '. $city. '</div>';
					$message .= '<div>State/Province: '. $provstate. '</br>';
					$message .= '<div>Zip/Postal Code: '. $postal_code. '</div>';
					$message .= '<div> Phone#: '. $primaryPhone. '</div></br><div>Products Ordered:</div>';
					ob_start();
					
					while($pq = mysqli_fetch_assoc($productQuery)){
				
						$isEmpty = true;
						$formName = "";
		
						$mappedOptionCategories = $optionCategoryProductMapObj->getConditionalRecord(
							array("productID",$pq["priKeyID"],true)
						);
						$optionCategoryIDList = $optionCategoryProductMapObj->getQueryValueString(
							$mappedOptionCategories,"productOptionCategoryID",","
						);
						#only get the parent option groups
						$optionCategories = $productOptionCategoryObj->getConditionalRecordFromList(
						array(	
							"priKeyID",$optionCategoryIDList,true/*, 
							"childOptionsGroupID", "0", "great"*/
						)
						);
					
						echo $pq["productName"];
		
						#loop through all the option categories
						while($poc = mysqli_fetch_assoc($optionCategories)){
						
							#only show the parent categories
							$hasParent = $productOptionCategoryObj->getConditionalRecordFromList(
								array(	
										"childOptionsGroupID",$poc["priKeyID"],true
								)
								);
								
							$hc = mysqli_fetch_assoc($hasParent);
							
							echo '</br><div class="optionContainer">';	
								
							if(mysql_num_rows($hasParent)==0){
						
							#loop through everything in the cart
							foreach(
								$_SESSION["cartProductIDs"]
									["product" . $pq["priKeyID"]][0]
									["options"] as $key => $value
								){
								
								#if they have this item in their cart
								if($value["qty"]>0){
									#echo "THE ID!" . $value["optionID"] . " " .$value["qty"];
									#get all the options in this option category
									$prodInGroup = $productOptionCategoryMapObj->getConditionalRecord(
										array(
											"productID",$value["optionID"],true,
											"productOptionCategoryID",$poc["priKeyID"],true
										)
									);
									
									#get all options in this options categories child category
									$prodInChild = $productOptionCategoryMapObj->getConditionalRecord(
										array(
											"productID",$value["optionID"],true,
											"productOptionCategoryID",$poc["childOptionsGroupID"],true
										)
									);
																
									#THE THE PRODUCT CANNOT BE MAPPED TO THIS OPTION IF THAT
									#PRODUCT IS ALSO AN OPTION!
									if(
										mysql_num_rows($prodInGroup) || 
										mysql_num_rows($prodInChild)
									) {
										#check if this option or its parent are mapped to this group					
										$optionDetails = $productObj->getRecordByID($value["optionID"]);
										$od = mysqli_fetch_assoc($optionDetails);
										
										#check if this product itself is an option
										echo '
										<div class="productListOption">
											-' . $od["productName"] . 
										'</div>';
									}
								}
							}
							
							/*echo '
								 <div class="parentOption">
							' . htmlspecialchars_decode($poc["productOptionCategoryDesc"]) . 
							'</div>';*/
							}
							
							echo '</div>';
							}
					}
					$isEmpty = false;
					$message .= ob_get_contents();
					ob_end_clean();
		
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		
					#echo "message: ". $message;
					if(!($isEmpty)) {
						//mail($to, "Overweight Purolator Order", $message, $headers);
						mail($_SESSION["adminEmail"], "Overweight Purolator Order", $message, $headers);
						echo "Weight of order is over limit for purolator auto quote. Your order has been
							emailed to a site administrator and you will be contacted shortly.";
					}
				}
			}
				#we might get a bad return from purolator
			else{
					$shipHTML .= '<div>Invalid shipping address for Purolator. Please double check and try again.</div>';
				}
			}
			$shipHTML .= '</form>
					</div>';
			
			echo $shipHTML;
		}#getShippingOptions function end
	}#class end

	if(isset($_REQUEST["function"])){	
		$moduleObj = new shipping(true);
		include_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
?>