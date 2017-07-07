<div id="viewCartContainer">
	<?php

		if(!isset($_SESSION)) session_start();		

		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/cmsCart/cmsCart.php');
		$cmsCartObj = new cmsCart(false);	

		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/country.php');
		$countryObj = new country(false);
		$countries = $countryObj->getConditionalRecord(array("isActive",1,true));

		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/location/provState.php');
		$provStateObj = new provState(false);

		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/settings/ecommerce/canadaPost/canadaPostSettings.php');
		$canadaPostSettingsObj = new canadaPostSettings(false);
		$canadaPostSettings = $canadaPostSettingsObj->getAllRecords();
		$cpSettings = mysqli_fetch_array($canadaPostSettings);	

	?>
	<div id="viewCartShippingInfo">
		<?php
			#If we are an administrator we will be given the option to pick any orders from a drop down
			#this will auto populate the cart and will allow the admin it make edits as needed
			if(isset($_SESSION['sessionSecurityLevel']) && $_SESSION['sessionSecurityLevel'] == 3 ) {
				include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/storeOrders/storeOrder.php');
				$orderObj = new storeOrder (false, NULL);
				$orders = $orderObj->getAllRecords();
			echo '<h2>Edit Existing Orders</h2>
				<p><em>Add and Remove items as desired. When ready proceed to checkout as normal. Payment processor will be bypassed.</em></p>
			';	
			echo'<div>
					<label for="orderToEdit">Select Order to Edit:</label>
					<select id="orderToEdit" name="orderToEdit" onchange="edit();">
					<option value="0"> ~ Select New Order ~ </option>
					<option value="0"> ~ Quite Edit Mode ~ </option>';
			while($x = mysqli_fetch_array($orders)){
				echo'<option id="orderID' . $x["priKeyID"] . '"';
				echo 'value="'. $x["priKeyID"] . '">Order ID: ' .$x["priKeyID"] . ' - '.$x["shipName"].'</option>';
			}
				
			echo 	'</select></div>';
			
			}
		?>
		<h2 id="welcomeMsg"> Welcome New Customer! </h2>
		<p><em>Please fill out the form below to proceed with your order.</em></p>
		
		<form name="shippingForm" id="shippingForm" action="">
			<?php
			if(isset($_SESSION["editOrder"]["orderID"] )){
				echo '
				<div id="viewCartFirstNameContainer" class="viewCartshippingInfoItem">
					<label for="priKeyID">Editing Order:</label>
					<input 
						name="priKeyID" 
						id="priKeyID" 
						maxlength="32" 
						type="text"
						readonly="readonly"
						value="'.$_SESSION["editOrder"]["orderID"].'"
					/>
				</div>';
			}
			?>
			<div id="viewCartFirstNameContainer" class="viewCartshippingInfoItem">
				<label for="shippingFirstName">First Name *:</label>
				<?php
				if(isset($_SESSION["editOrder"]["shipName"])) {
					$value = $_SESSION["editOrder"]["shipName"];
					$name = preg_split("/[\s,]+/", $value);
					$value = $name[0];
				}
				elseif (isset($_SESSION['firstName'])) {
					$value = $_SESSION['firstName'];
				}
				else{
					$value = "";
				}
				?>
				<input 
					name="shippingFirstName" 
					id="shippingFirstName" 
					maxlength="32" 
					type="text"
					required="required"
					value="<?php echo $value; ?>"
				/>
			</div>
			<?php
				if(isset($_SESSION["editOrder"]["shipName"])) {
					$value = $_SESSION["editOrder"]["shipName"];
					$name = preg_split("/[\s,]+/", $value);
					$i = 0;
					$lastName= "";
					foreach($name as &$value) {
						if($i > 0) {
							$lastName .= $value . " ";
						}
						$i++;
					}
					$value = $lastName;
				}
				elseif (isset($_SESSION['lastName'])) {
					$value = $_SESSION['lastName'];
				}
				else{
					$value = "";
				}
				?>
			<div id="viewCartLastNameContainer" class="viewCartshippingInfoItem">
				<label for="shippingLastName">Last Name *:</label>
				<input 
					name="shippingLastName" 
					id="shippingLastName" 
					maxlength="50" 
					type="text"
					required="required"
					value="<?php echo $value; ?>"

				/>
			</div>
			<?php
				if(isset($_SESSION["editOrder"]["shipStreet"])) {
					$value = trim(preg_replace("/[^0-9]/", "", $_SESSION["editOrder"]["shipStreet"]));
				}
				elseif (isset($_SESSION['address'])) {
					$value = trim(preg_replace("/[^0-9]/", "", $_SESSION['address']));
				}
				else{
					$value = "";
				}
			?>
			<div id="viewCartStreetNumberContainer" class="viewCartshippingInfoItem">
				<label for="shippingNumber">Street Number *:</label>
				<input 
					name="shippingNumber" 
					id="shippingNumber" 
					maxlength="6" 
					type="text"
					required="required"
					onfocus="getShipValue(this)"
					onblur="checkShipClear(this)"
					value="<?php echo $value; ?>"
				/>
			</div>
			<?php
				if(isset($_SESSION["editOrder"]["shipStreet"])) {
					$value = trim(preg_replace("/[^A-Za-z ]/", "", $_SESSION["editOrder"]["shipStreet"]));
				}
				elseif (isset($_SESSION['address'])) {
					$value = trim(preg_replace("/[^A-Za-z ]/", "", $_SESSION['address']));
				}
				else{
					$value="";
				}
			?>
			<div id="viewCartStreetNameContainer" class="viewCartshippingInfoItem">
				<label for="shippingName">Street Name *:</label>
				<input 
					name="shippingName" 
					id="shippingName" 
					maxlength="25" 
					type="text"
					required="required"
					onfocus="getShipValue(this)"
					onblur="checkShipClear(this)"
					value="<?php echo $value; ?>"
				/>
			</div>
			<div id="viewCartAddress2Container" class="viewCartshippingInfoItem">
				<label for="address2">Unit/Apt:</label>
				<input 
					name="address2"
					id="address2" 
					maxlength="25" 
					type="text" 
					onfocus="getShipValue(this)"
					onblur="checkShipClear(this)"
					value=""
				/>
			</div>
			<?php
				if(isset($_SESSION["editOrder"]["shipCity"])) {
					$value = $_SESSION["editOrder"]["shipCity"];
				}
				elseif (isset($_SESSION['city'])) {
					$value = $_SESSION['city'];
				}
				else{
					$value = "";
				}
			?>
			<div id="viewCartCityContainer" class="viewCartshippingInfoItem">
				<label for="shippingCity">City * :</label>
				<input 
					name="shippingCity" 
					id="shippingCity" 
					maxlength="40" 
					type="text"
					required="required"
					onfocus="getShipValue(this)"
					onblur="checkShipClear(this)"
					value="<?php echo $value; ?>"
				/>
			</div>
			<div id="viewCartCountry" class="viewCartshippingInfoItem">
				<label for="shippingCountry">Country *:</label>
				<select 
					name="shippingCountry" 
					id="shippingCountry" 
					required="required"
					onchange="getProvStates('shippingProvState','shippingCountry')" 
					onfocus="getShipValue(this)"
					onblur="checkShipClear(this)"
				>
					<option value="">~ Country ~</option>
					<?php
						#we use country codes instead of the prikey ID so that we can pass it to paypal
						$countrySelected = 0;
						while($x = mysqli_fetch_array($countries)){

					?>
					<option 

							id="shippingCountry<?php echo $x["priKeyID"]; ?>" 
							<?php

								if(isset($_SESSION['country']) && $x["priKeyID"] == $_SESSION['country']){
									echo 'selected="selected"';
									#countryID to use to query our provinces
									$countrySelected = $x["priKeyID"];

								}

							?>
							value="<?php echo $x["countryCode"]; ?>"
						> <?php echo $x["country"]; ?> </option>
					<?php

						}

					?>
				</select>
			</div>
			<div id="viewCartProvState" class="viewCartshippingInfoItem">
				<label for="shippingProvState">Prefecture <span>(Prov./State)</span> *:</label>
				<select 
					name="shippingProvState" 
					id="shippingProvState" 
					required="required"
					onfocus="getShipValue(this)"
					onblur="checkShipClear(this)"
				>
					<option value="">~ Choose A Country ~</option>
					<?php
						if($countrySelected > 0){
							$provStates = $provStateObj->getConditionalRecord(array("countryID",$countrySelected,true));
							#get provinces and states for this country
							while($x = mysqli_fetch_array($provStates)){

					?>
					<option 

									id="provState<?php echo $x["priKeyID"]; ?>" 

									<?php

										if(isset($_SESSION['provState']) && $x["priKeyID"] == $_SESSION['provState'])

											echo 'selected="selected"';

									?>

									value="<?php echo $x["priKeyID"]; ?>"

								> <?php echo $x["provState"]; ?> </option>
					<?php

							}

						}

					?>
				</select>
			</div>
			<?php
				if(isset($_SESSION["editOrder"]["shipPostalZip"])) {
					$value = $_SESSION["editOrder"]["shipPostalZip"];
				}
				elseif (isset($_SESSION['postalZip'])) {
					$value = $_SESSION['postalZip'];
				}
				else{
					$value = "";
				}
			?>
			<div id="viewCartPostalZip" class="viewCartshippingInfoItem">
				<label for="shippingPostalZip">Postal Code/ Zip Code:</label>
				<input 
					name="shippingPostalZip" 
					id="shippingPostalZip" 
					maxlength="10"
					type="text"
					required="required"
					onfocus="getShipValue(this)" 
					onblur="checkShipClear(this)"
					value="<?php echo $value; ?>"

				/>
			</div>
			<?php
				if(isset($_SESSION["editOrder"]["primaryPhone"])) {
					$value = $_SESSION["editOrder"]["primaryPhone"];
				}
				elseif (isset($_SESSION['homePhone'])) {
					$value = $_SESSION['homePhone'];
				}
				else{
					$value = "";
				}
			?>
			<div id="viewCartPriPhoneContainer" class="viewCartshippingInfoItem">
				<label for="shippingPhoneNumber">Phone:</label>
				<input 
					name="shippingPhoneNumber" 
					id="shippingPhoneNumber" 
					maxlength="50" 
					type="tel"
					required="required"
					value="<?php echo $value; ?>"

				/>
			</div>
			<h2 id="calShip">Calculate shipping and select a shipping option.</h2>
			<p><em>Click calculate shipping and select one of the following shipping options.</em></p>
			<div id="calcShipButton" class="sb" onclick="getShippingOptions()"> <span>Calculate Shipping</span> </div>
		</form>
		<div id="shippingOptionsWaiting" style="display:none"> <span><?php echo $cpSettings["ajaxWaitingMessage"] ?></span> </div>
	</div>
	<div id="viewCartShippingOptions"></div>
	<div id="viewCartTotals">
		<h2 id="checkout">Checkout</h2>
		<div id="viewCartProdTotal"> Subtotal: <span id="itemProductTotal" class="cartValue"> $<?php echo number_format($cmsCartObj->getCartProductTotal(),2); ?> </span> </div>
		<div id="viewCartTaxesTotal"> Taxes: <span id="itemTaxesTotal" class="cartValue"> $<?php echo number_format($cmsCartObj->getCartTaxTotal(),2); ?> </span> </div>
		<div id="viewCartShippingTotal"> Shipping: <span id="itemShippingTotal" class="cartValue"> $0.00 </span> </div>
		<div id="getCartTotal"> Total: <span id="itemCartTotal" class="cartValue"> $<?php echo number_format($cmsCartObj->getCartTotal(),2); ?> </span> </div>
	</div>
	<div id="checkoutButton" class="sb" onclick="proceedToCheckout()"> <span>Checkout</span> </div>
</div>
<div id="ccd" style="opacity:0;filter:alpha(opacity=0)"></div>
