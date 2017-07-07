<div>
	<label for='description'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['description']; ?>
	</label>

	<input type="text" required id="description<?php echo $_REQUEST[" recordID "]; ?>" name="description" maxlength="255" value="<?php echo $priModObj[0]->displayInfo('description'); ?>"/>
</div>

<div>
	<label for='price'>
		<?php echo $priModObj[0]->languageLabels[$_SESSION["lng"]]['price']; ?>
	</label>

	<input type="number" required id="price<?php echo $_REQUEST[" recordID "]; ?>" name="price" maxlength="255" value="<?php echo $priModObj[0]->displayInfo('price'); ?>"/>
</div>

<?php
#list of Postal Codes
$postalCode = $postalCodeObj->getAllRecords();
if ( mysqli_num_rows( $postalCode ) > 0 ) {
	echo "<div class='moduleSubElement'>
				<h3  
					onclick=\"$('#postalCode" . $_REQUEST[ "recordID" ] . "').toggle()\" 
					class=\"adminShowHideParent\"

				>" . $priModObj[ 0 ]->languageLabels[ $_SESSION[ "lng" ] ][ 'postalCode' ] . "

					<span>" . $priModObj[ 0 ]->languageLabels[ $_SESSION[ "lng" ] ][ 'toggleExpand' ] . "</span>
				</h3>
			<div id='postalCode" . $_REQUEST[ "recordID" ] . "' class='adminShowHideChild'>";
	while ( $x = mysqli_fetch_array( $postalCode ) ) {
		if ( isset( $_REQUEST[ "recordID" ] ) ) {
			$postalIDMapped = $postalCodeMapObj->getConditionalRecord(
				array(
					"postalID", $x[ "priKeyID" ], true,
				    "flatRateID", $_REQUEST[ "recordID" ], true
				)
			);
			$postExist = $productMapObj->getCheckQuery(
				"SELECT * FROM flat_rate_postal_map WHERE postalID = ".$x[ "priKeyID" ]." AND flatRateID != " . $_REQUEST[ "recordID" ]
			);
		}
		else {
			$postExist = $productMapObj->getCheckQuery(
				"SELECT * FROM flat_rate_postal_map WHERE postalID = ".$x[ "priKeyID" ] 
			);			
		}
		
		$checked = "";
		$disable = "";
		if ( isset( $postalIDMapped ) && mysqli_num_rows($postalIDMapped) > 0) {
			$y = mysqli_fetch_row( $postalIDMapped );
			mysqli_data_seek( $postalIDMapped, 0 );
			$checked = 'checked="checked"';
		}
		if ( isset( $postExist ) && mysqli_num_rows( $postExist ) > 0 ) {
			$disable = 'disabled';
		}
		?>
		<div>
			<input type='checkbox' <?php echo $checked; ?><?php echo $disable; ?> id='postalID
			<?php echo $x["priKeyID"]; ?>_
			<?php echo $_REQUEST["recordID"]; ?>' name='postalID' class='flatRateProduct' value='
			<?php echo $x["priKeyID"]; ?>' />
			<span>
				<?php echo $x["postalCode"]; ?>
			</span>
		</div>

		<?php
	}
	echo "</div></div>";
}
?>

<?php
#list products
$products = $productsObj->getAllRecords();
if ( mysqli_num_rows( $products ) > 0 ) {
	echo "<div class='moduleSubElement'>
				<h3  
					onclick=\"$('#taxableProducts" . $_REQUEST[ "recordID" ] . "').toggle()\" 
					class=\"adminShowHideParent\"

				>" . $priModObj[ 0 ]->languageLabels[ $_SESSION[ "lng" ] ][ 'taxableProducts' ] . "

					<span>" . $priModObj[ 0 ]->languageLabels[ $_SESSION[ "lng" ] ][ 'toggleExpand' ] . "</span>
				</h3>
			<div id='taxableProducts" . $_REQUEST[ "recordID" ] . "' class='adminShowHideChild'>";
	while ( $x = mysqli_fetch_array( $products ) ) {
		if ( isset( $_REQUEST[ "recordID" ] ) ) {
			$prodMapped = $productMapObj->getConditionalRecord(
				array(
					"productID", $x[ "priKeyID" ], true,
				    "flatRateID", $_REQUEST[ "recordID" ], true
				)
			);
			$prodExist = $productMapObj->getCheckQuery(
				"SELECT * FROM flat_rate_product_map WHERE productID = ".$x[ "priKeyID" ]." AND flatRateID != " . $_REQUEST[ "recordID" ]
			);
		}
		else {
			$prodExist = $productMapObj->getCheckQuery(
				"SELECT * FROM flat_rate_product_map WHERE productID = ".$x[ "priKeyID" ] 
			);			
		}
		$checked = "";
		$disable = "";
		if ( isset( $prodMapped ) && mysqli_num_rows( $prodMapped ) > 0 ) {
			$y = mysqli_fetch_row( $prodMapped );
			mysqli_data_seek( $prodMapped, 0 );
			$checked = 'checked="checked"';
		}
		?>
		<div>
			<input type='checkbox' <?php echo $checked; ?> id='productID
			<?php echo $x["priKeyID"]; ?>_
			<?php echo $_REQUEST["recordID"]; ?>' name='productID' class='flatRateProduct' value='
			<?php echo $x["priKeyID"]; ?>' />
			<span>
				<?php echo $x["productName"]; ?>
			</span>
		</div>

		<?php
	}
	echo "</div></div>";
}
?>













