<div>
	<label for='orderStatus'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['orderStatus']; ?>
	</label>
	<div class='moduleFormStyledSelect'>
		<select id="orderStatus" name="orderStatus">
			<option value="TBD" <?php if($priModObj[0]->displayInfo('orderStatus') == 0) echo 'selected="selected"';?>> ~ Select Status ~ </option>
			<option value="Processing" <?php if($priModObj[0]->displayInfo('orderStatus') == "Processing") echo 'selected="selected"';?>> Processing </option>
			<option value="Shipped" <?php if($priModObj[0]->displayInfo('orderStatus') == "Shipped") echo 'selected="selected"';?>> Shipped </option>
			<option value="Completed" <?php if($priModObj[0]->displayInfo('orderStatus') == "Completed") echo 'selected="selected"';?>> Completed </option>
		</select>
	</div>
</div>
<div>
	<label for='publicUserID'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['publicUserID']; ?>
	</label>

	<div class='moduleFormStyledSelect'>

		<select id="publicUserID" name="publicUserID">
			<option> ~ No Account ~ </option>
			<?php
			$usersQuery = $publicUsersObj->getAllRecords();
			while($x = mysqli_fetch_array($usersQuery)){
				$selected = "";
				if($x['priKeyID'] === $priModObj[0]->queryResults["publicUserID"]) {
					$selected="selected='selected'";
				}
				echo "<option " . $selected . " value='".$x['priKeyID']."'>".$x['firstName'] . ' ' . $x['lastName']."</option>";
				?>
				
			<?php
			}
			?>
		</select>
	</div>
</div>

 <?php
	#we need to format the time from 24 to 12 hour, and make the date manually
	if(strlen($priModObj[0]->displayInfo('orderDate')) > 0){
		$editDate = date("Y-m-d",strtotime($priModObj[0]->displayInfo('orderDate')));
	}
	else{
		$editDate = date("Y-m-d",$_SERVER['REQUEST_TIME']);
	}
	
	if(strlen($priModObj[0]->displayInfo('orderTime')) > 0){
		$editTime = date("g:i a",strtotime($priModObj[0]->displayInfo('orderTime')));
	}
	else{
		$hourPlus = date("g")+2;
		$hourPlus = $hourPlus > 12 ? $hourPlus-12 : $hourPlus;
		$editTime = $hourPlus . date(":i a");
	}
?>
<div>
	<label for='orderDate'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['orderDate']; ?>
	</label>
	<input
		class="orderDate noBulkExpand"
		maxlength="20"
		name="orderDate"
		id="orderDate<?php echo $_REQUEST["recordID"]; ?>"
		type="text"
		value="<?php echo $editDate; ?>"
	/>
</div>

<div>
	<label for='orderTime'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['orderTime']; ?>
	</label>
	<input
		class="orderTime noBulkExpand"
		name="orderTime"
		type="text"
		maxlength="20"
		id="orderTime<?php echo $_REQUEST["recordID"]; ?>"
		value="<?php echo $editTime; ?>"
	/>
</div>

<div>
	<label for='paymentMethod'><?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['paymentMethod']; ?></label>
	<div class='moduleFormStyledSelect'>
		<select id="paymentMethod" name="paymentMethod">
			<option> ~ Select Payment Method ~ </option>
			<option <?php if($priModObj[0]->displayInfo('paymentMethod') == 0) echo 'selected="selected"';?> value="0">PayPal</option>
			<option <?php if($priModObj[0]->displayInfo('paymentMethod') == 1) echo 'selected="selected"';?> value="1">Beanstream</option>	
		</select>
	</div>
</div>

<div>
	<label for='transactionID'><?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['transactionID']; ?></label>
	<input id="transactionID"  maxlength="255" name="transactionID" type="text" value="<?php echo $priModObj[0]->displayInfo('transactionID'); ?>"/>
</div>

<div>
	<label for='shipMethod'><?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shipMethod']; ?></label>
	<input id="shipMethod"  maxlength="255" name="shipMethod" type="text" value="<?php echo $priModObj[0]->displayInfo('shipMethod'); ?>"/>
</div>

<div>
	<label for='shipName'><?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shipName']; ?></label>
	<input id="shipName" maxlength="255" name="shipName" type="text" value="<?php echo $priModObj[0]->displayInfo('shipName'); ?>"/>
</div>

<div>
	<label for='shipStreet'><?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shipStreet']; ?></label>
	<input id="shipStreet" maxlength="255" name="shipStreet" type="text" value="<?php echo $priModObj[0]->displayInfo('shipStreet'); ?>"/>
</div>

<div>
	<label for='shipCity'><?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shipCity']; ?></label>
	<input id="shipCity" maxlength="255" name="shipCity" type="text" value="<?php echo $priModObj[0]->displayInfo('shipCity'); ?>"/>
</div>

<div>
	<label for='shipPostalZip'><?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shipPostalZip']; ?></label>
	<input id="shipPostalZip" maxlength="255" name="shipPostalZip" type="text" value="<?php echo $priModObj[0]->displayInfo('shipPostalZip'); ?>"/>
</div>

<div>
	<label for='country'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shipCountryID']; ?>
	</label>

	<div class="moduleFormStyledSelect">

		<select 
			id="shipCountryID<?php echo $_REQUEST["recordID"]; ?>" 
			name="shipCountryID"
			onchange="getProvStates('shipProvStateID<?php echo $_REQUEST["recordID"]; ?>','shipCountryID<?php echo $_REQUEST["recordID"]; ?>')" 
		>

			<option value="">Select a Country</option>
			<?php
				#we use country codes instead of the pricey ID so that we can pass it to paypal
				while($x = mysqli_fetch_assoc($countries)){
			?>
				<option 
					id="shipCountryID<?php echo $x["priKeyID"]; ?>" 
					value="<?php echo $x["priKeyID"]; ?>"
					<?php
						if($priModObj[0]->displayInfo('shipCountryID') == $x["priKeyID"])
							echo 'selected="selected"';
					?>
				>
					<?php echo $x["country"]; ?>
				</option>
			<?php
				}
			?>
		</select>

	</div>

</div>

<div>
	<label for='shipProvStateID'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['shipProvStateID']; ?>
	</label>

	<div class="moduleFormStyledSelect">
		<select id="shipProvStateID<?php echo $_REQUEST["recordID"]; ?>"  name="shipProvStateID">
			<option value="" >First Choose A Country</option>
			<?php
				if(strlen($priModObj[0]->displayInfo('shipCountryID')) > 0){
					$provStates = $provStateObj->getConditionalRecord(
						array("countryID", $priModObj[0]->displayInfo('shipCountryID'),true)
					);
					while($x = mysqli_fetch_assoc($provStates)){
			?>
					<option 
						value="<?php echo $x["priKeyID"]; ?>"
						id="shipProvStateID<?php echo $x["priKeyID"]; ?>"
						<?php
							if($priModObj[0]->displayInfo('shipProvStateID') == $x["priKeyID"])
								echo 'selected="selected"';
						?>
					>
						
						<?php echo $x["provState"]; ?>
					</option>
		<?php
				}
			}
		?>
		</select>

	</div>

</div>

<div>
	<label for='orderItemAmt'>Subtotal</label>
	<input id="orderItemAmt" maxlength="255" name="orderItemAmt" type="text" value="<?php echo $priModObj[0]->displayInfo('orderItemAmt'); ?>"/>
</div>

<div>
	<label for='orderShipAmt'>Shipping Amount</label>
	<input id="orderShipAmt" maxlength="255" name="orderShipAmt" type="text" value="<?php echo $priModObj[0]->displayInfo('orderShipAmt'); ?>"/>
</div>

<div>
	<label for='orderTaxAmt'>Tax Amount</label>
	<input id="orderTaxAmt" maxlength="255" name="orderTaxAmt" type="text" value="<?php echo $priModObj[0]->displayInfo('orderTaxAmt'); ?>"/>
</div>

<div>
	<label for='orderTotalAmt'>Total</label>
	<input id="orderTotalAmt" maxlength="255" name="orderTotalAmot" type="text" value="<?php echo $priModObj[0]->displayInfo('orderTotalAmt'); ?>"/>
</div>
<div>
	<label for='orderTotalAmt'>Edit Order</label>
	<?php
		include_once($_SERVER['DOCUMENT_ROOT'] . '/cmsAPI/ecommerce/cmsCart/cmsCart.php');
		$cmsCartObj = new cmsCart(false);
		$cart = $cmsCartObj->editOrderAddCart($priModObj[0]->queryResults["priKeyID"]);
	?>
	<a href="#" onclick="">click here</a>
</div>