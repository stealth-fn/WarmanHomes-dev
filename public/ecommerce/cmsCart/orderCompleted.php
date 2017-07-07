<?php

	if(!isset($_SESSION)) session_start();

	include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/paypal/paypal.php');
	$paypalSettingsObj = new paypal(false, NULL);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/products/products.php");
	$productsObj = new products(false, NULL);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/storeOrders/storeOrder.php");
	$storeOrderObj = new storeOrder(false, NULL);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/storeOrders/storeOrderProductMap.php");
	$storeOrderProductMapObj = new storeOrderProductMap(false, NULL);

	include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/ecommerce/storeOrders/storeOrderProductOptionMap.php");
	$storeOrderProductOptionMapObj = new storeOrderProductOptionMap(false, NULL);

	#token is passed back from paypal
	if(isset($_GET["token"])){
		$orderDetails = $paypalSettingsObj->getExpressCheckoutDetails($_GET["token"]);
		$finalDetails = $paypalSettingsObj->doExpressCheckoutPayment($_GET["token"]);
	}

	#we can only get the details once, so we put the TRANSACTIONID 
	#into a session variable so we can use it again later, ex if they refresh this page
	if(isset($finalDetails["TRANSACTIONID"]) || isset($_SESSION["editOrder"]["orderID"])){
		#if paypal save the transactionID in a session
		if(isset($finalDetails["TRANSACTIONID"])) {
			$_SESSION["payPalTransactionID"] = $finalDetails["TRANSACTIONID"];	
		}
		if(isset($_SESSION["editOrder"]["orderID"])) {
			$_SESSION["recentOrder"] = $_SESSION["editOrder"]["orderID"];
		}

		#create our order in the CMS
		$paramsArray = array();

		#not all checkouts require someone to be logged in
		if(isset($_SESSION["userID"])) {
			if(isset($_SESSION["isGuest"]) && $_SESSION["isGuest"] == 1) {
				$paramsArray["publicUserID"] = 0;
			}else {
				$paramsArray["publicUserID"] = $_SESSION["userID"];
			}
		} else {
			$paramsArray["publicUserID"] = 0;
		}
		
		if(isset($_SESSION["editOrder"]["orderID"] )){
			$paramsArray["paymentMethod"] = 0;
			$paramsArray["shipMethod"] = $_SESSION["shipName"];
			$paramsArray["shipName"] = $_SESSION["shippingInfo"]["firstName"] . " " . $_SESSION["shippingInfo"]["lastName"];
			$paramsArray["shipStreet"] = $_SESSION["shippingInfo"]["address"];
			$paramsArray["shipCity"] = $_SESSION["shippingInfo"]["city"];
			$paramsArray["shipProvStateID"] = $_SESSION["shippingInfo"]["provStateID"];
			$paramsArray["shipPostalZip"] = $_SESSION["shippingInfo"]["postal_code"];
			$paramsArray["primaryPhone"] = $_SESSION["shippingInfo"]["primaryPhone"];
			$paramsArray["shipCountryID"] = $_SESSION["shippingInfo"]["countryID"];
			
			include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/cmsCart/cmsCart.php');
			$cmsCartObj = new cmsCart(false, NULL);
			#item amount
			$itemTotal = $cmsCartObj->getCartProductTotal();
			#tax amount
			$taxTotal = $cmsCartObj->getCartTaxTotal();

			#item, taxes and shipping
			$_SESSION["shipAmount"] = $_GET["shipAmt"];
			$_SESSION["shipName"] = $_GET["shipName"];
			$orderTotal = $cmsCartObj->getCartTotal() + $_SESSION["shipAmount"];
			
			$paramsArray["orderItemAmt"] = number_format($itemTotal,2);
			$paramsArray["orderShipAmt"] = number_format($_SESSION["shipAmount"] ,2);
			$paramsArray["orderTaxAmt"] = number_format($taxTotal,2);
			$paramsArray["orderTotalAmt"] = number_format($orderTotal,2);

		} else {
			$paramsArray["paymentMethod"] = 0;
			$paramsArray["transactionID"] = $finalDetails["TRANSACTIONID"];
			$paramsArray["shipMethod"] = $_SESSION["shipName"];
			$paramsArray["shipName"] = $orderDetails["SHIPTONAME"];
			$paramsArray["shipPhoneNumber"] = $orderDetails["SHIPTONAME"];
			$paramsArray["shipStreet"] = $orderDetails["SHIPTOSTREET"];
			$paramsArray["shipCity"] = $orderDetails["SHIPTOCITY"];
			$paramsArray["shipProvStateID"] = $_SESSION["shippingInfo"]["provStateID"];
			$paramsArray["shipPostalZip"] = $orderDetails["SHIPTOZIP"];
			$paramsArray["primaryPhone"] = $_SESSION["shippingInfo"]["primaryPhone"];
			$paramsArray["shipCountryID"] = $_SESSION["shippingInfo"]["countryID"];
			
			$paramsArray["orderItemAmt"] = number_format($orderDetails["ITEMAMT"],2);
			$paramsArray["orderShipAmt"] = number_format($orderDetails["SHIPPINGAMT"],2);
			$paramsArray["orderTaxAmt"] = number_format($orderDetails["TAXAMT"],2);
			$paramsArray["orderTotalAmt"] = number_format($orderDetails["AMT"],2);
		}
		
		#check to see if we are editing an order
		if(isset($_SESSION["editOrder"]["orderID"] )){
			#add the primary key to the recored
			$paramsArray["priKeyID"] = $_SESSION["editOrder"]["orderID"];
			#update the recored
			$cmsOrderID = $storeOrderObj->updateRecord($paramsArray);	
		}
		else{
			#create a new recored - we are not editing
			$cmsOrderID = $storeOrderObj->addRecord($paramsArray);	
		}
		
		$_SESSION["recentOrder"] = $cmsOrderID;
		

		#-adjust the inventory level for each product and add our products to the order information table
		#-add prodcuts to order mapping table
		if(isset($_SESSION["cartProductIDs"])){
			#check to see if we are editing an order
			if(isset($_SESSION["editOrder"]["orderID"] )){
				#Delete all products currently associated with that Order
				$storeOrderProductMapObj->removeRecordsByCondition("storeOrderID", $cmsOrderID);
			}


			foreach($_SESSION["cartProductIDs"] as $key => $value){
				foreach($value as $loc => $cartProd){
					#update our inventory quantity
					$paramsArray = array();
					$paramsArray["priKeyID"] = $_SESSION["cartProductIDs"][$key][$loc]["productID"];
					$prodID = $paramsArray["priKeyID"];

					$tmpProd = $productsObj->getRecordByID($paramsArray["priKeyID"]);
					$tp = mysqli_fetch_array($tmpProd);

					#get the invtQty of the current product
					$paramsArray["invtQty"] = $tp["invtQty"] - $_SESSION["cartProductIDs"][$key][$loc]["qty"];
					$productsObj->updateRecord($paramsArray);

					#add produts to order mapping table
					$paramsOMArray = array();
					$paramsOMArray["storeOrderID"] = $cmsOrderID;
					$paramsOMArray["productID"] = $paramsArray["priKeyID"];
					$paramsOMArray["qty"] = $_SESSION["cartProductIDs"][$key][$loc]["qty"];

					/*include the product information, so we don't have to worry about 
					prices, names, sku's etc changing*/
					$paramsOMArray["groupID"] = $tp["groupID"];
					$paramsOMArray["domainID"] = $tp["domainID"];
					$paramsOMArray["productName"] = $tp["productName"];
					$paramsOMArray["sku"] = $tp["sku"];
					$paramsOMArray["productCopy"] = $tp["productCopy"];
					$paramsOMArray["active"] = $tp["isActive"];
					$paramsOMArray["price"] = $tp["price"];
					$paramsOMArray["invtQty"] = $tp["invtQty"];
					$paramsOMArray["allowNegInvt"] = $tp["allowNegInvt"];
					$paramsOMArray["negInvtMsg"] = $tp["negInvtMsg"];
					$paramsOMArray["optionQty"] = $tp["optionQty"];
					$paramsOMArray["prodLink"] = $tp["prodLink"];
					$paramsOMArray["prodLen"] = $tp["prodLen"];
					$paramsOMArray["prodWidth"] = $tp["prodWidth"];
					$paramsOMArray["prodHeight"] = $tp["prodHeight"];
					$paramsOMArray["prodWeight"] = $tp["prodWeight"];
					$paramsOMArray["ordinal"] = $tp["ordinal"];

					$storeOPMID = $storeOrderProductMapObj->addRecord($paramsOMArray);


					#loop through chosen options for this product, add to mapping table
					if(isset($_SESSION["cartProductIDs"]["product$prodID"][$loc]["options"])){
						#check to see if we are editing an order
						if(isset($_SESSION["editOrder"]["orderID"] )){
							#Delete all products currently associated with that Order
							$storeOrderProductOptionMapObj->removeRecordsByCondition("storeOrderProductMapID", $storeOPMID);
						}
						foreach($_SESSION["cartProductIDs"]["product$prodID"][$loc]["options"] as $key2 => $value2){
							$prodOpQty = $_SESSION["cartProductIDs"]["product$prodID"][$loc]["options"][$key2]["qty"];

							if($prodOpQty > 0){

								$tempProdOpID = $_SESSION["cartProductIDs"]["product$prodID"][$loc]["options"][$key2]["optionID"];
								$tmpProdOp = $productsObj->getRecordByID($tempProdOpID);
								$tpo = mysqli_fetch_array($tmpProdOp);

								#update our inventory quantity
								$paramsArray = array();
								$paramsArray["priKeyID"] = $tempProdOpID;
								$prodOpID = $paramsArray["priKeyID"];

								#get the invtQty of the current product
								$paramsArray["invtQty"] = $tpo["invtQty"] - $prodOpQty;
								$productsObj->updateRecord($paramsArray);

								$paramsOPMArray = array();
								$paramsOPMArray["storeOrderProductMapID"] = $storeOPMID;
								$paramsOPMArray["productID"] = $prodOpID;
								$paramsOPMArray["productOptionID"] = $tempProdOpID;
								$paramsOPMArray["qty"] = $prodOpQty;

								/*include the product information, so we don't have to worry about 
								prices, names, sku's etc changing*/
								$paramsOPMArray["groupID"] = $tpo["groupID"];
								$paramsOPMArray["domainID"] = $tpo["domainID"];
								$paramsOPMArray["productName"] = $tpo["productName"];
								$paramsOPMArray["sku"] = $tpo["sku"];
								$paramsOPMArray["productCopy"] = $tpo["productCopy"];
								$paramsOPMArray["active"] = $tpo["isActive"];
								$paramsOPMArray["price"] = $tpo["price"];
								$paramsOPMArray["invtQty"] = $tpo["invtQty"];
								$paramsOPMArray["allowNegInvt"] = $tpo["allowNegInvt"];
								$paramsOPMArray["negInvtMsg"] = $tpo["negInvtMsg"];
								$paramsOPMArray["optionQty"] = $tpo["optionQty"];
								$paramsOPMArray["prodLink"] = $tpo["prodLink"];
								$paramsOPMArray["prodLen"] = $tpo["prodLen"];
								$paramsOPMArray["prodWidth"] = $tpo["prodWidth"];
								$paramsOPMArray["prodHeight"] = $tpo["prodHeight"];
								$paramsOPMArray["prodWeight"] = $tpo["prodWeight"];
								$paramsOPMArray["ordinal"] = $tpo["ordinal"];

								$storeOrderProductOptionMapObj->addRecord($paramsOPMArray);

							}
						}
					}		
				}
			}
		}
		#remove our session cart info
		unset($_SESSION["cartProductIDs"]);
		#remove the session variable, we are no longer editing an order
		if(isset($_SESSION["editOrder"])){
			unset($_SESSION["editOrder"]);
		}
	}
	
	#If there has been a recent transaction regardless of it was an update or a paid transaction
	#output the order
	if (isset($_SESSION["recentOrder"])) {
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/storeOrders/storeOrder.php');
		$storeOrderObj = new storeOrder(false, NULL);
		$storeOrder = $storeOrderObj->getRecordByID($_SESSION["recentOrder"]);
		if(mysqli_num_rows($storeOrder) > 0){
			$x = mysqli_fetch_assoc($storeOrder);
		}
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/provState.php');
		$provStateObj = new provState(false, NULL);
		$province = $provStateObj->getRecordByID($x["shipProvStateID"]);
		if(mysqli_num_rows($storeOrder) > 0){
			$p = mysqli_fetch_assoc($province);
		}
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/country.php');
		$countryObj = new country(false);
		$country = $countryObj->getRecordByID($x["shipCountryID"]);
		if(mysqli_num_rows($storeOrder) > 0){
			$c = mysqli_fetch_array($country);
		}

		
		#payment method
		if($x["paymentMethod"] == 0){
			$tempPM = "PayPal";
		}
		elseif($x["paymentMethod"] == 1){
			$tempPM = "Beanstream";
		}
		
		echo '
				<div class="invoice-box">
				<table cellpadding="0" cellspacing="0">
					<tr class="top">
						<td colspan="2"><table>
								<tr>
									<td class="title"><img src="/images/admin/logo-project.png" style="width:100%; max-width:300px;"></td>
									<td>Order Number: ' .$x["priKeyID"]. '<br>
										Order Date: '.date( 'F jS Y', strtotime( $x["orderDate"] )).'<br>
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
										
									<td>' .$x["shipName"]. '<br>
										' .$x["shipStreet"]. '<br>
										' .$x["shipCity"]. ', '.$p["provStateCode"].' ' .$x["shipPostalZip"]. '<br>
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
						<td> ' .$x["transactionID"]. ' </td>
					</tr>
					<tr class="heading">
						<td> Shipping Information </td>
						<td>  </td>
					</tr>
					<tr class="item">
						<td> Shipping Method </td>
						<td> ' .$x["shipMethod"]. ' </td>
					</tr>
					<tr class="item">
						<td> Tracking Number </td>
						<td> ' .$x["shippingTrackingNumber"]. ' </td>
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
						array("storeOrderID",$x["priKeyID"],true)
					);
					$products = $productsObj->getAllRecords();
		
			
					while($o = mysqli_fetch_array($orderProdMap)){
						echo '
						<tr class="item">
							<td> ' . $o["productName"] . ' </td>
							<td> '.$o["qty"] .' - $' . number_format($o["price"] ,2) . '</td>
						</tr>';
						$orderProdOptionMap = $storeOrderProductOptionMapObj->getConditionalRecord(
							array("storeOrderProductMapID",$o["priKeyID"],true)
						);
						while($y = mysqli_fetch_array($orderProdOptionMap)){
							echo '
							<tr class="item option">
								<td> ' . $y["productName"] . ' </td>
								<td> '.$y["qty"] .' - $' . number_format($y["price"] ,2) . '</td>
							</tr>';
						}
					}
					
					echo '
					<tr class="total">
						<td></td>
						<td> Subtotal: $' . number_format($x["orderItemAmt"] ,2) . '</td>
					</tr>
					<tr class="total">
						<td></td>
						<td> Tax: $' . number_format($x["orderTaxAmt"] ,2) . '</td>
					</tr>
					<tr class="total">
						<td></td>
						<td> Shipping: $' . number_format($x["orderShipAmt"] ,2) . '</td>
					</tr>
					<tr class="total">
						<td></td>
						<td> Total: $' . number_format($x["orderTotalAmt"] ,2) . '</td>
					</tr>
				</table>
			</div>';
	}
	else {
		echo "<p>There was no order completed.</p>";
	}