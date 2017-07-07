<?php
	#Order ID
	if(array_key_exists("OrderID",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["OrderID"] = 
		'<div 
			class="orderID-'. $priModObj[0]->className .'"
			id="orderID-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Order Number: 
		' .$priModObj[0]->queryResults["priKeyID"]. '</div>';
	}

	#Order Date
	if(array_key_exists("Order Date",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Order Date"] = 
		'<div 
			class="orderDate-'. $priModObj[0]->className .'"
			id="orderDate-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Order Date: 
		' .date( 'F jS Y', strtotime( $priModObj[0]->queryResults["orderDate"] )). '</div>';
	}

	#order time
	if(array_key_exists("Order Time",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Order Time"] = 
		'<div 
			class="orderTime-'. $priModObj[0]->className .'"
			id="orderTime-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Order Time: ' .$priModObj[0]->queryResults["orderTime"]. '</div>';
	}

	#payment method
	if($priModObj[0]->queryResults["paymentMethod"] == 0){
		$tempPM = "PayPal";
	}
	elseif($priModObj[0]->queryResults["paymentMethod"] == 1){
		$tempPM = "Beanstream";
	}
	if(array_key_exists("Payment Method",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["Payment Method"] = 
		'<div 
			class="paymentMethod-'. $priModObj[0]->className .'"
			id="paymentMethod-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Payment Method: ' . $tempPM . '</div>';
	}

	#payment processor transation ID
	if(array_key_exists("Transaction ID",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Transaction ID"] = 
		'<div 
			class="transactionID-'. $priModObj[0]->className .'"
			id="transactionID-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Transaction ID: ' .$priModObj[0]->queryResults["transactionID"]. '</div>';
	}

	#Shipping Method
	if(array_key_exists("Shipping Method",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Shipping Method"] = 
		'<div 
			class="shippingMethod-'. $priModObj[0]->className .'"
			id="shippingMethod-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Shipping Method: ' .$priModObj[0]->queryResults["shipMethod"]. '</div>';
	}

	#Name of person being shipped to
	if(array_key_exists("Name",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Name"] = 
		'<div 
			class="name-'. $priModObj[0]->className .'"
			id="name-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Shipping To: ' .$priModObj[0]->queryResults["shipName"]. '</div>';
	}

	#Street
	if(array_key_exists("Street",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Street"] = 
		'<div 
			class="street-'. $priModObj[0]->className .'"
			id="street-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Street: ' .$priModObj[0]->queryResults["shipStreet"]. '</div>';
	}

	#City
	if(array_key_exists("City",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["City"] = 
		'<div 
			class="city-'. $priModObj[0]->className .'"
			id="city-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		City: ' .$priModObj[0]->queryResults["shipCity"]. '</div>';
	}

	#Province/State
	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/provState.php');
	$provStateObj = new provState(false);
	$province = $provStateObj->getRecordByID(
		$priModObj[0]->queryResults["shipProvStateID"]
	);
	$p = mysqli_fetch_assoc($province);
	if(array_key_exists("Province",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["Province"] = 
		'<div 
			class="province-'. $priModObj[0]->className .'"
			id="province-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		State/Province:' . $p["provState"]. '</div>';
	}

	#postal code/ zip code
	if(array_key_exists("Postal Code",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Postal Code"] = 
		'<div 
			class="postalCode-'. $priModObj[0]->className .'"
			id="postalCode-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
			Zip/Postal Code: ' .$priModObj[0]->queryResults["shipPostalZip"]. 
		'</div>';
	}

	#Country
	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/country.php');
	$countryObj = new country(false);
	$country = $countryObj->getRecordByID($priModObj[0]->queryResults["shipCountryID"]);
	$c = mysqli_fetch_array($country);

	if(array_key_exists("Country",$priModObj[0]->domFields)){
			
		$priModObj[0]->domFields["Country"] = 
		'<div 
			class="country-'. $priModObj[0]->className .'"
			id="country-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
		Country:' .$c["country"]. '</div>';

	}

	#Products for this order
	if(array_key_exists("Products",$priModObj[0]->domFields)){ 
		#put child module into output buffer
		ob_start();
		$recursivePmpmID = $priModObj[0]->productInstanceID;
		include($_SERVER['DOCUMENT_ROOT'] . "/modules/moduleFrame/recursiveModule.php");
		$priModObj[0]->domFields["Products"] = ob_get_contents();
		ob_end_clean();
	}
	elseif(array_key_exists("Products",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Products"] = '<div class="mfmc"></div>';
	}

	


	#Order Amount
	if(array_key_exists("Order Amount",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Order Amount"] = 
		'<div 
			class="orderAmount-'. $priModObj[0]->className .'"
			id="orderAmount-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
			Item Amount: $' .$priModObj[0]->queryResults["orderItemAmt"] . 
		'</div>';
	}


	#Shipping Amount
	if(array_key_exists("Shipping Amount",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Shipping Amount"] = 
		'<div 
			class="shippingAmount-'. $priModObj[0]->className .'"
			id="shippingAmount-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
			Shipping Amount: $' .$priModObj[0]->queryResults["orderShipAmt"] . 
		'</div>';
	}

	#Tax Amount
	if(array_key_exists("Tax Amount",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Tax Amount"] = 
		'<div 
			class="taxAmount-'. $priModObj[0]->className .'"
			id="taxAmount-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
			Tax Amount: $' .$priModObj[0]->queryResults["orderTaxAmt"] . 
		'</div>';

	}

	#Order Total
	if(array_key_exists("Total",$priModObj[0]->domFields)){
		$priModObj[0]->domFields["Total"] = 
		'<div 
			class="total-'. $priModObj[0]->className .'"
			id="total-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
		>
			Total: $' .$priModObj[0]->queryResults["orderTotalAmt"] . 
		'</div>';
	}

	#link to page to display order information
	if(array_key_exists("Order Details Link",$priModObj[0]->domFields)){

		$priModObj[0]->domFields["Order Details Link"] = 
		'<a 
			href="/index.php?pageID=' . $priModObj[0]->orderPageID . '&amp;orderID=' . $priModObj[0]->queryResults["priKeyID"] . '"
			class="detailLink-'. $priModObj[0]->className .'"
			id="detailLink-'. $priModObj[0]->className . '-' . $priModObj[0]->queryResults["priKeyID"] .'"
			onclick="upc(' . $priModObj[0]->orderPageID . ',&quot;pmpm=%28%22'.$priModObj[0]->orderPmpmID.'%22%3A%28%22orderID%22%3A%22'.$priModObj[0]->queryResults["priKeyID"].'%22%29%29&quot;); return false"
			>' . $priModObj[0]->orderDetailsText . '</a>';

	}
	if(array_key_exists("EditOrderButton",$priModObj[0]->domFields)){
		if(isset($_SESSION["sessionSecurityLevel"]) && $_SESSION["sessionSecurityLevel"] == 3){
			$priModObj[0]->domFields["EditOrderButton"] = '<a id="editOrder(' .$priModObj[0]->queryResults["priKeyID"]. ')" class="editOrderBtn" onclick="editOrder(' .$priModObj[0]->queryResults["priKeyID"]. ');">Edit Order</a>';
		}
		else{
			$priModObj[0]->domFields["EditOrderButton"] = "";
		}
	}

	if(array_key_exists("Invocie",$priModObj[0]->domFields)){
		
		$priModObj[0]->domFields["Invocie"] = 
		'<div class="invoice-box">
				<table cellpadding="0" cellspacing="0">
					<tr class="top">
						<td colspan="2"><table>
								<tr>
									<td class="title"><img src="/images/admin/logo-project.png" style="width:100%; max-width:300px;"></td>
									<td>Order Number: ' .$priModObj[0]->queryResults["priKeyID"]. '<br>
										Order Date: '.date( 'F jS Y', strtotime( $priModObj[0]->queryResults["orderDate"] )).'<br>
										Last Updated: '.date( 'F jS Y', strtotime( $priModObj[0]->queryResults["lastUpdated"] )).'<br>
										Order Status: ' .$priModObj[0]->queryResults["orderStatus"]. '
										</td>
								</tr>
							</table></td>
					</tr>
					<tr class="information">
						<td colspan="2"><table>
								<tr>
									<td>
									'.$_SESSION["orderCompanyName"].'<br/>
									'.$_SESSION["orderCompanyAddress1"].'<br/>
									'.$_SESSION["orderCompanyAddress2"].'<br/>
									'.$_SESSION["orderCompanyAddress3"].'
									</td>
										
									<td>' .$priModObj[0]->queryResults["shipName"]. '<br>
										' .$priModObj[0]->queryResults["shipStreet"]. '<br>
										' .$priModObj[0]->queryResults["shipCity"]. ', '.$p["provStateCode"].' ' .$priModObj[0]->queryResults["shipPostalZip"]. '<br>
										' .$c["country"] . '
									</td>
								</tr>
							</table></td>
					</tr>
					<tr class="heading">
						<td> Order Information </td>
						<td>  </td>
					</tr>
					<tr class="item">
						<td> Payment Method </td>
						<td> '.$tempPM.' </td>
					</tr>
					<tr class="item">
						<td> Transaction ID </td>
						<td> ' .$priModObj[0]->queryResults["transactionID"]. ' </td>
					</tr>
					<tr class="heading">
						<td> Shipping Information </td>
						<td>  </td>
					</tr>
					<tr class="item">
						<td> Shipping Method </td>
						<td> ' .$priModObj[0]->queryResults["shipMethod"]. ' </td>
					</tr>
					<tr class="item">
						<td> Tracking Number </td>
						<td> ' .$priModObj[0]->queryResults["shippingTrackingNumber"]. ' </td>
					</tr>
					<tr class="heading">
						<td> Item(s) </td>
						<td> Qty - Price </td>
					</tr>
					';
		
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/storeOrders/storeOrderProductMap.php");
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/storeOrders/storeOrderProductOptionMap.php");
					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
					$storeOrderProductMapObj = new storeOrderProductMap(false, NULL);
					$storeOrderProductOptionMapObj = new storeOrderProductOptionMap(false, NULL);
					$productsObj = new products(false, NULL);
		
					$orderProdMap = $storeOrderProductMapObj->getConditionalRecord(
						array("storeOrderID",$priModObj[0]->queryResults["priKeyID"],true)
					);
					$products = $productsObj->getAllRecords();
		
			
					while($x = mysqli_fetch_array($orderProdMap)){
						$priModObj[0]->domFields["Invocie"] .= '
						<tr class="item">
							<td> ' . $x["productName"] . ' </td>
							<td> '.$x["qty"] .' - $' . number_format($x["price"] ,2) . '</td>
						</tr>';
						$orderProdOptionMap = $storeOrderProductOptionMapObj->getConditionalRecord(
							array("storeOrderProductMapID",$x["priKeyID"],true)
						);
						while($y = mysqli_fetch_array($orderProdOptionMap)){
							$priModObj[0]->domFields["Invocie"] .= '
							<tr class="item option">
								<td> ' . $y["productName"] . ' </td>
								<td> '.$y["qty"] .' - $' . number_format($y["price"] ,2) . '</td>
							</tr>';
						}
					}
					
					$priModObj[0]->domFields["Invocie"] .= '
					<tr class="total">
						<td></td>
						<td> Subtotal: $' . number_format($priModObj[0]->queryResults["orderItemAmt"] ,2) . '</td>
					</tr>
					<tr class="total">
						<td></td>
						<td> Tax: $' . number_format($priModObj[0]->queryResults["orderTaxAmt"] ,2) . '</td>
					</tr>
					<tr class="total">
						<td></td>
						<td> Shipping: $' . number_format($priModObj[0]->queryResults["orderShipAmt"] ,2) . '</td>
					</tr>
					<tr class="total">
						<td></td>
						<td> Total: $' . number_format($priModObj[0]->queryResults["orderTotalAmt"] ,2) . '</td>
					</tr>
				</table>
			</div>';
	}

?>