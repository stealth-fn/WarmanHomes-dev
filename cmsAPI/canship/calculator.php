<?
/*
	Test Phase Info:
		Shipping Profile : http://206.191.4.228/servlet/LogonServlet
		TechSupport : 1-800-277-4799
*/
	$product = getProductArray() ;
	( submit("submitted" ) == 1 && submit("countryChanged") == 0 ) 
		? displayShippingResponse( $product ) 
		: displayRequestForm( $product ) ;

// = = = = = = = = = = = = = = = = = = = = = = = = = = =	
function	displayRequestForm( &$product ){
	global $isShowLogo ; // show Canada Post Logo or not
	global $debug ;
?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
<!--
	function quote(){
		var form = document.frmShipping ;
		
		if( isNaN(trim(form.itemsQuantity.value)) ) {
			alert( "Please type in Quantity." );
			return ;
		}
		
		if( "" == trim(form.city.value) ){
			alert( "Please type in City." );
			return ;
		}

		if( ! isPostalCode( form.country.value, form.postalCode.value ) ){
			alert( "Postal Code is invalid." );
			return ;
		};
		form.submit();
	}
	
	function	trim( str ){
			str += "" ;
			str = str.replace( /^ +/gi, "" );
			str = str.replace( / +$/gi, "" );
			return str;
	}

	function	nospace( str ){
			str += "" ;
			str = str.replace( /^ +/gi, "" );
			str = str.replace( / +$/gi, "" );
			str = str.replace( / +/gi, "" );
			return str;
	}
	
	function isPostalCode( countryName, postalCode ){
		postalCode = nospace( postalCode ).toUpperCase();
		switch( countryName.toUpperCase() ){
			case "CANADA" :
				ok = postalCode.match( /^[A-Z][0-9][A-Z][0-9][A-Z][0-9]$/ ); 
				break;
			case "UNITED STATES" :
				ok = postalCode.match( /^[0-9]{5}$/ ); 
				break;
			default : // always true
				ok = true ;
				break ;
		}
		return ok ;
	}
	
	
	
//-->
</SCRIPT>
<form action="<?= getEnv("SCRIPT_NAME") ?>" method="post" name="frmShipping">
<input type="Hidden" name="submitted" value="1">
<input type="hidden" name="itemsQuantity" value="1" >
<input type="hidden" name="countryChanged" value="0">
<input type="hidden" name="debug" value="<? print $debug == 1 ? 1 : 0 ?>">
<?
	if( !$debug ) {
		foreach( $product as $key => $value ){
			print "<input type='hidden' name='$key' value=\""  . htmlspecialchars($value) . "\">\n" ;
		}
	}
?>
<table  cellpadding="0" cellspacing="0" border=1  bordercolor="#ff0000">
	<tr>
		<td>
<!-- -------------------------------------------------------------- -->

<table border="0" cellpadding="0" cellspacing="10" width="450">
<? if( $isShowLogo ) {?>
<tr>
	<td bgcolor="#ff0000" align="center">
		<a href="http://www.allaboutweb.ca/sf/canship/"><img src="pics/canadapost.gif" width="178" height="60" alt="" border="0"><br>
		<font color="#ffffff" class="pageTitle" style="text-decoration : none">Free PHP Canada Post Shipping Rate Calculator</font></a>
		<br><br>
	</td>
</tr>
<?
	}
?>
<tr>
	<td><? displayProductInfo( $product ); ?> </td>
</tr>
<tr>
	<td bgcolor="#4A5A6B"><img src="/pics/blank.gif" width="1" height="1" border="0"></td>
</tr>
<tr>
	<td>
	<table border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td colspan="2" align="right" nowrap width="140"><b>City :</b></td>
			<td><input type="Text" name="city" size="30" value="<?= submit("city") ?>" class="inputField"></td>
		</tr>
		<tr>
			<td colspan="2" align="right" nowrap><b>Country :</b></td>
			<td>
<?
	$defaultCountry = strtoupper( submit( "country" ) ? submit( "country" ) : "United States" );
	displayCountry( $defaultCountry ) ;
?>				
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right" nowrap><b>Province/State :</b></td>
			<td>
<?
	if( $defaultCountry == "UNITED STATES" || $defaultCountry == "CANADA" ) {
		$provStates = file( $defaultCountry == "UNITED STATES" ?  FILE_US_STATES : FILE_CA_PROVINCES  );
?>
		<select name="provOrState" class='inputField'>
<?
		foreach( $provStates as $ps ) {
			print "<option value=\"" . htmlspecialchars(trim($ps)) . "\">" . htmlspecialchars(trim($ps)) . "</option>\n" ;
		}
?>			
		</select>
<?		
	} else {	
?>			
			<input type="Text" name="provOrState" size="30" value="" class="inputField">
<?
	}
?>				
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right" nowrap><b>Postal Code/Zip Code :</b></td>
			<td><input type="Text" size="30" name="postalCode" value="<?= submit("postalCode") ?>" class="inputField"></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><br><input type="button" value="Get Shipping Quote"  onclick="quote();"></td>
		</tr>
		</table><br>
			
		</td>
</tr>
</table>
<!-- -------------------------------------------------------------- -->
		</td>
	</tr>
</table>

</form>

<?
}

	function	displayCountry( $default = "United States" ){
		print "<select name='country' class='inputField' onchange='document.frmShipping.countryChanged.value=1;document.frmShipping.submit();'>\n" ;
		print "<option value=''> - Select - </option>\n" ;

		$countries = file( FILE_COUNTRY );
		foreach( $countries as $c ){
			$value = htmlspecialchars(trim($c)) ;
			$selected = strtoupper($default) == strtoupper(trim($c)) ? " selected " : "" ;
			print "<option value=\"$value\" $selected>$value</option>\n" ;
		}
		print "</select>\n" ;
	}

/*
	According "Architecture Document" from http://eparcel.magma.ca/DevelopersResources/	
	postalCode : " "( space ) if sent outside Canada
	provOrState : " "( space ) if sent outside Canada and USA
*/
	function prepareXMLRequest( &$product ){
		$qty = $product["quantity"];
$xml = 
"<?xml version=\"1.0\" ?>
<eparcel>
	<language>en</language>
	<ratesAndServicesRequest>
		<merchantCPCID>CPC_ESEENET_COM</merchantCPCID>
		<turnAroundTime>24</turnAroundTime>
		<lineItems>
			<item>
				<quantity>" . $qty . "</quantity>
				<weight>" . $product["weight"]  . "</weight>
				<length>" . $product["length"]  . "</length>
				<width>" . $product["width"]  . "</width>
				<height>" . $product["height"]  . "</height>
				<description>" . $product["name"]. "</description>
				<readyToShip />
			</item>
		</lineItems>
		" . 
( strlen(submit("city")) > 0  ? "<city>" . htmlspecialchars(submit("city")) . "</city>\n" : "" ) . 
( strlen(submit("provOrState")) > 0  ? "		<provOrState>" . htmlspecialchars(submit("provOrState")) . "</provOrState>\n" : "		<provOrState> </provOrState>\n" ) . 
( strlen(submit("country")) > 0  ? "		<country>" . htmlspecialchars(submit("country")) . "</country>\n" : "" ) . 
( strlen(submit("postalCode")) > 0  ? "		<postalCode>" . submit("postalCode") . "</postalCode>\n" : "		<postalCode> </postalCode>\n" ) . 
"	</ratesAndServicesRequest>
</eparcel>
" ;
	return $xml ;
}

function 	getShippingMethods(){
	global $debug ;
	require( "canadapost.php" );
	$cp = new CanadaPost();
	$cp->xml_code = prepareXMLRequest() ;
	$cp->calc_shipping() ;
	if( !$cp->error ){
		print "<table border='0' cellpadding='0' cellspacing='8' width=400 >\n" ;
		print "<tr> <td>&nbsp;</td> <td><b>Shipping Method</b></td> <td align='right'><b>Delivery Date</b></td> <td align='right'><b >Rate (CAD$)</b></td> </tr>\n" ;
		$devider =  "<tr> <td colspan=4 bgcolor='#cccccc'><img src='pics/blank.gif' border=0 width=1 height=1></td> </tr>\n" ;
		print $devider ;
		foreach( $cp->return_shipping_methods as $m ){
			print "<tr> <td align='right'><input type='radio' name='shippingMethod' value=\"" . htmlspecialchars($m["name"]) .  "\"></td><td>" . $m["name"] .  "</td> <td align='right'>" . $m["delivery_date"] .  "</td> <td align='right'>\$ " .  $m["rate"] . "</td></tr>\n" ;
			print $devider ;
		}
		$shippingDate = $cp->return_shipping_methods[0]["shipping_date"] ;
		print "<tr> <td colspan=4 ><b>Base on a shipping date of $shippingDate.</b><br><br>Comment:" . $cp->return_shipping_comment . " </td> </tr>\n" ;
		print "</table>\n" ;
	} else {
		print "<br><br>Error! "  . $cp->error_msg ;
	}

}


function	displayShippingResponse( &$product ){
	global $debug ;
	global $isShowLogo ;

	$cp = new CanadaPost() ;
	$cp->addItem( $product["quantity"]  , $product["weight"] , $product["length"] , $product["width"] , $product["height"], $product["description"]  ) ;
	$cp->getQuote( submit( "city" ), submit("provOrState"), submit("country"), submit("postalCode") );
?>

<table  cellpadding="0" cellspacing="0" border=1  bordercolor="#ff0000">
	<tr>
		<td>
<!-- -------------------------------------------------------------- -->

<table border="0" cellpadding="0" cellspacing="10" width="550">
<? if( $isShowLogo ) {?>
<tr>
	<td bgcolor="#ff0000" align="center">
		<a href="http://www.allaboutweb.ca/sf/canship/"><img src="pics/canadapost.gif" width="178" height="60" alt="" border="0"><br>
		<font color="#ffffff" class="pageTitle">Free PHP Canada Post Shipping Rate Calculator</font></a>
		<br><br>
	</td>
</tr>
<?
	}
?>

<tr>
	<td><? displayProductInfo( &$product ) ?></td>
</tr>
<tr>
	<td bgcolor="#4A5A6B"><img src="/pics/blank.gif" width="1" height="1" border="0"></td>
</tr>
<tr>
	<td><table border="0" cellpadding="2" cellspacing="0">
		<tr>
			<td colspan="2" align="right" nowrap><b>City :</b></td>
			<td><? print htmlspecialchars(submit( "city" )) ?></td>
		</tr>
		<tr>
			<td colspan="2" align="right" nowrap><b>Province/State :</b></td>
			<td><? print htmlspecialchars(submit("provOrState")) ; ?></td>
		</tr>
		<tr>
			<td colspan="2" align="right" nowrap><b>Country :</b></td>
			<td><? print htmlspecialchars(submit("country")) ; ?></td>
		</tr>
		<tr>
			<td colspan="2" align="right" nowrap><b>Postal Code/Zip Code :</b></td>
			<td><? print htmlspecialchars(submit("postalCode")) ?></td>
		</tr>
		</table><br>
		<table border="0" cellpadding="0" cellspacing="5" width="100%">
		<tr>
			<td nowrap><b>Shipping Methods</b></td>
			<td><b>Delivery Date</b></td>
			<td align="right"><b>Rate (CAD$)</b></td>
		</tr>
		<tr>
			<td colspan="3" bgcolor="#cccccc"><img src="/pics/blank.gif" width="1" height="1" border="0"></td>
		</tr>
<?
	if( !$cp->error ){
		foreach( $cp->shipping_methods as $m ){
?>
		<tr valign="top">
			<td><? print $m["name"] ; ?></td>
			<td><? print $m["deliveryDate"]; ?></td>
			<td align="right"><? print '$' . number_format( $m["rate"],2 ) ; ?></td>
		</tr>
		<tr>
			<td colspan="3" bgcolor="#cccccc"><img src="/pics/blank.gif" width="1" height="1" border="0"></td>
		</tr>
<?
		} // foreach
		$shippingDate = $cp->shipping_methods[0]["shippingDate"] ;
?>
		<tr>
			<td colspan="3" ><? print "<b>Base on a shipping date of $shippingDate.</b><br>" . $cp->shipping_comment  . "<br>* For reference only. Do not represent actual shipping."; ?></td>
		</tr>
<?		
	}	else { 
		reportQuoteError();
?>		
		<tr>
			<td colspan="3" align="center"><? print "<br><br> <b><font color='red'>Sorry! There is an error occured.</font> <br>Please try again later.</b><!-- " . $cp->error_msg  . " --></b><br><br>"; ?></td>
		</tr>
<?
	} // $cp->error
?>		
		</table>
		</td>
</tr>
</table>

<!-- -------------------------------------------------------------- -->
		</td>
	</tr>
</table>
<?
	if( $debug ){
		print "<hr>\n\n\n" ;
		print "Request XML:<br><form action='http://" . CP_SERVER . ":" . CP_PORT . "' method='post' target='_blank' ><textarea name='XMLRequest' style='width:100%;height:400px;background-color:#f2f2f2'>\n" . $cp->xml_request . "\n\n</textarea><br><input type='submit' value='Send to Canada Post'></form>";
		print "<br><br>Return XML:<br><form><textarea style='width:100%;height:400px;background-color:#f2f2f2'>\n" . $cp->xml_response . "\n\n</textarea></form>";
	}

} // function


	function	displayProductInfo( &$product ){
		global $debug ;
		if( $debug && ! (submit("submitted" ) == 1) ) {
			displayProductForm( $product ) ;
		} else {
?>
<table border="0" cellpadding="5" cellspacing="0">
 		<tr>
			<td align="right" nowrap width="140"><b>Description :</b></td>
			<td><? print htmlspecialchars(strtoupper($product['description'])) ; ?></td>
		</tr>
		<tr>
			<td align="right" nowrap><b>Length (cm) :</b></td>
			<td><? print htmlspecialchars($product['length']); ?></td>
		</tr>
		<tr>
			<td align="right" nowrap><b>Width (cm) :</b></td>
			<td><? print htmlspecialchars($product['width']); ?></td>
		</tr>
		<tr>
			<td align="right" nowrap><b>Height (cm) :</b></td>
			<td><? print htmlspecialchars($product['height']); ?></td>
		</tr>
		<tr>
			<td align="right" nowrap><b>Weight (kg) :</b></td>
			<td><? print htmlspecialchars($product['weight']) ; ?></td>
		</tr>
</table>
<?
		} // $debug
	}

	function	reportQuoteError(){
		mail( DEBUGER_EMAIL, "Fail to get shipping quote (IP:" . getEnv("REMOTE_ADDR") . ")", prepareXMLRequest(), "From: shippingCalculator@" . SITE_DOMAIN_NAME ) ;
	}
?>		