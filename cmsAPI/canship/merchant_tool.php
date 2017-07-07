<?
	require_once("./include.php");
	common_header( "Merchant Tool" );
	$product = getProductArray() ;
	displayToolFrom( $product ) ;
	common_footer();
	exit;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	function	displayToolFrom( $product ){
?>
<form action="<?= getEnv("SCRIPT_NAME") ?>" method="post" name="frmShipping">
<input type="Hidden" name="submitted" value="1">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td><?displayProductForm( $product );?></td>
	</tr>
	<tr>
		<td><img src='pics/blank.gif' border=0 width=181 height=1><input type="Submit" value="Create eBay Shipping Link"></td>
	</tr>
<?
	if( submit("submitted") == 1  ) {
?>
	<tr>
		<td>
<? 
		$shippingLink = getUrlEncode($product) ;
		print "<br><br><hr>" . $product["description"] . "<br><br>" . $shippingLink .
				"<br><br><b>Copy the following HTML text to your web site:</b><br>\n<textarea  style='width:100%;height:60px;background-color:#f2f2f2' name='shippinglink'> $shippingLink </textarea>\n" ;
?>
		</td>
	</tr>
<?
	}
?>	
</table>
</form>
<?
	}
?>